<?php

defined('ABSPATH') || exit;

$theme_version = '1657717607';

add_action('init', 'get_theme_path');
function get_theme_path()
{
    if (isset($_GET['theme_path'])) {
        echo get_bloginfo('template_url');
        exit;
    }
}

// extend_functions_top //

add_action('admin_head', 'editor_full_width_taxonomy');
if (!function_exists('editor_full_width_taxonomy')) {
    function editor_full_width_taxonomy()
    {
        echo '<style>#edittag{max-width: none !important;}</style>';
    }
}

if (file_exists(dirname(__FILE__) . '/dynamic_functions.php')) {
    include_once __DIR__ . '/dynamic_functions.php';
}
if (file_exists(dirname(__FILE__) . '/shop_functions.php')) {
    include_once __DIR__ . '/shop_functions.php';
}
if (file_exists(dirname(__FILE__) . '/configurator.php')) {
    include_once __DIR__ . '/configurator.php';
}
if (file_exists(dirname(__FILE__) . '/custom_functions.php')) {
    include_once __DIR__ . '/custom_functions.php';
}

require_once ABSPATH . 'wp-admin/includes/plugin.php';
if (file_exists(dirname(__FILE__) . '/vendor/ajax-simply') && !is_plugin_active('ajax-simply/ajax-simply.php')) {
    include_once 'vendor/ajax-simply/ajax-simply.php';
}

if (file_exists(dirname(__FILE__) . '/vendor/classic-editor') && !is_plugin_active('classic-editor/classic-editor.php')) {
    include_once 'vendor/classic-editor/classic-editor.php';
}

add_theme_support('menus');
add_theme_support('woocommerce');
add_theme_support('post-thumbnails');
add_filter('widget_text', 'do_shortcode');
add_theme_support('title-tag');

add_action('admin_head', 'admin_custom_styles');
add_action('wp_head', 'admin_custom_styles');
function admin_custom_styles()
{
    if (is_user_logged_in()) {
?>
        <style>
            #wp-admin-bar-wp-admin-bar-options>.ab-item:before {
                content: "\f100";
                top: 2px;
            }
        </style>
<?php
    }
}

add_action('admin_enqueue_scripts', 'add_admin_scripts');
function add_admin_scripts()
{
    wp_register_script('admin_script', get_template_directory_uri() . '/js/admin.js', ['jquery'], false, true);
    wp_enqueue_script('admin_script');
    wp_enqueue_style('admincss', get_template_directory_uri() . '/css/admin.css');
}

add_action('wp_enqueue_scripts', 'add_site_scripts');
function add_site_scripts()
{
    global $theme_version;
    wp_deregister_script('jquery-core');
    wp_register_script('jquery-core', '//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', false, false, true);
    wp_enqueue_script('jquery');
    wp_enqueue_style('main', get_stylesheet_directory_uri() . '/css/main.css', [], $theme_version);
    if (!is_admin()) {
        wp_enqueue_script('jquery-ui-core', ['jquery']);
        wp_enqueue_script(
            'jquery-ui-slider',
            ['jquery', 'jquery-ui-core']
        );
    }
}

add_filter('wp_default_scripts', 'remove_jquery_migrate');
function remove_jquery_migrate(&$scripts)
{
    if (!is_admin()) {
        $scripts->remove('jquery');
        $scripts->add('jquery', false, ['jquery-core'], '1.12.4');
    }
}

if (!function_exists('slugify')) {
    function slugify($text)
    {
        $translation = [
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm',
            'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
            'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh',
            'щ' => 'sch', 'ы' => 'y', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 'і' => 'i',
            'ї' => 'yi', 'є' => 'ye', 'ґ' => 'g', 'е' => 'e', 'ё' => 'e',
            '\'' => '', '"' => '', '`' => '', 'ь' => '', 'ъ' => ''
        ];
        $text = trim($text);
        $text = mb_convert_case($text, MB_CASE_LOWER, 'UTF-8');
        $text = strtr($text, $translation);
        $text = preg_replace('~(\W+)~', '_', $text);
        $text = trim($text, '_');
        $text = strtolower($text);
        return $text;
    }
}

function get_layout_var($layout_field, $layout_name, $sub_field, $post_id = '')
{
    if ($post_id === '') {
        $post_id = get_the_ID();
    }
    foreach (get_field($layout_field, $post_id) as $layout) {
        if ($layout['acf_fc_layout'] === $layout_name) {
            return $layout[$sub_field];
        }
    }
    return '';
}

function get_range_meta_value($post_type, $meta_field, $range)
{
    global $wpdb;
    $value = $wpdb->get_var("SELECT $range(CAST(meta_value AS UNSIGNED)) FROM `{$wpdb->prefix}postmeta` WHERE meta_key = '$meta_field'");
    if ($value == '') {
        $value = 0;
    }
    return $value;
}

function wtw_get_meta_range_on_term($post_type, $term_id, $meta_field)
{
    global $wpdb;
    $sql = "
    SELECT  MIN( convert(meta_value, DECIMAL)  ) as min_price , MAX( convert(meta_value, DECIMAL)  ) as max_price
    FROM {$wpdb->posts}
    INNER JOIN {$wpdb->term_relationships} ON ({$wpdb->posts}.ID = {$wpdb->term_relationships}.object_id)
    INNER JOIN {$wpdb->postmeta} ON ({$wpdb->posts}.ID = {$wpdb->postmeta}.post_id)
    WHERE
    ( {$wpdb->term_relationships}.term_taxonomy_id IN (%d) )
    AND {$wpdb->posts}.post_type = '$post_type'
    AND {$wpdb->posts}.post_status = 'publish'
    AND {$wpdb->postmeta}.meta_key = '$meta_field'
    ";

    $result = $wpdb->get_results($wpdb->prepare($sql, $term_id));

    return $result[0];
}

function wtw_get_meta_range_on_archive($post_type, $meta_field)
{
    global $wpdb;
    $sql = "
    SELECT  MIN( convert(meta_value, DECIMAL)  ) as min_price , MAX( convert(meta_value, DECIMAL)  ) as max_price
    FROM {$wpdb->posts}
    INNER JOIN {$wpdb->postmeta} ON ({$wpdb->posts}.ID = {$wpdb->postmeta}.post_id)
    WHERE
    {$wpdb->posts}.post_type = '$post_type'
    AND {$wpdb->posts}.post_status = 'publish'
    AND {$wpdb->postmeta}.meta_key = '$meta_field'
    ";

    $result = $wpdb->get_results($wpdb->prepare($sql));

    return $result[0];
}

function getTerm($term_name)
{
    $terms = get_the_terms(get_the_ID(), $term_name);
    return $terms[0]->name;
}

function getCatID()
{
    global $wp_query;
    if (is_category() || is_single()) {
        $cat_ID = get_query_var('cat');
    }
    return $cat_ID;
}

add_shortcode('show_file', 'show_file_func');
function show_file_func($atts)
{
    extract(shortcode_atts([
        'file' => ''
    ], $atts));
    if ($file != '') {
        return @file_get_contents($file);
    }
}

if (is_admin()) {
    foreach (get_taxonomies() as $taxonomy) {
        add_action("manage_edit-${taxonomy}_columns", 'tax_add_col');
        add_filter("manage_edit-${taxonomy}_sortable_columns", 'tax_add_col');
        add_filter("manage_${taxonomy}_custom_column", 'tax_show_id', 10, 3);
    }
    add_action('admin_print_styles-edit-tags.php', 'tax_id_style');
    function tax_add_col($columns)
    {
        return $columns + ['tax_id' => 'ID'];
    }
    function tax_show_id($v, $name, $id)
    {
        return 'tax_id' === $name ? $id : $v;
    }
    function tax_id_style()
    {
        print '<style>#tax_id{width:4em}</style>';
    }

    add_filter('manage_posts_columns', 'posts_add_col', 5);
    add_action('manage_posts_custom_column', 'posts_show_id', 5, 2);
    add_filter('manage_pages_columns', 'posts_add_col', 5);
    add_action('manage_pages_custom_column', 'posts_show_id', 5, 2);
    add_action('admin_print_styles-edit.php', 'posts_id_style');
    function posts_add_col($defaults)
    {
        $defaults['wps_post_id'] = __('ID');
        return $defaults;
    }
    function posts_show_id($column_name, $id)
    {
        if ($column_name === 'wps_post_id') {
            echo $id;
        }
    }
    function posts_id_style()
    {
        print '<style>#wps_post_id{width:4em}</style>';
    }
}

function isCurrentLink($test_link)
{
    if ($test_link == 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] || ($test_link == site_url() . '/' && substr_count(get_permalink(), 'p=') != 0)) {
        $current_class = ' w--current';
    } else {
        $current_class = '';
    }
    return $current_class;
}

function wtw_current_url($get_params = false)
{
    if ($get_params) {
        $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        echo $url;
    } else {
        $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        $url = $url[0];
    }
    return $url;
}

function wtw_is_current_url($test_url, $get_params = false)
{
    if ($get_params) {
        $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        echo $url;
    } else {
        $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        $url = $url[0];
    }
    return $test_url === $url;
}

function get_id_by_slug($page_slug)
{
    $page = get_page_by_path($page_slug);
    if ($page) {
        return $page->ID;
    } else {
        return null;
    }
}

function posts_schet_class()
{
    global $post_num;
    if (++$post_num % 2) {
        $class = 'nechet';
    } else {
        $class = 'chet';
    }
    return $class;
}

function post_parity()
{
    global $post_num;
    if (++$post_num % 2) {
        return 'odd';
    } else {
        return 'even';
    }
}

add_filter('upload_mimes', 'my_myme_types', 1, 1);
function my_myme_types($mime_types)
{
    $mime_types['svg'] = 'image/svg+xml'; // поддержка SVG
    return $mime_types;
}

add_filter('post_thumbnail_html', 'remove_width_attribute', 10);
add_filter('image_send_to_editor', 'remove_width_attribute', 10);
function remove_width_attribute($html)
{
    $html = preg_replace('/(width|height)="\d*"\s/', '', $html);
    return $html;
}

add_action('init', 'remheadlink');
function remheadlink()
{
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
    remove_action('wp_head', 'feed_links_extra', 3);
}

function wtw_change_settings($option, $old_value, $value)
{
    if (
        substr($option, 0, 25) === 'options_custom_post_types'
        || substr($option, 0, 25) === 'options_custom_taxonomies'
    ) {
        update_option('wtw_settings_changed', true);
    }
}
add_action('updated_option', 'wtw_change_settings', 10, 3);

function wtw_flush_rewrite()
{
    if (get_option('wtw_settings_changed') == true) {
        flush_rewrite_rules();
        update_option('wtw_settings_changed', false);
    }
}
add_action('admin_init', 'wtw_flush_rewrite');

add_filter('template_include', 'set_custom_templates');
function set_custom_templates($original_template)
{
    global $wp_query;
    if (is_tax() && get_queried_object()->parent) {
        $child_template = str_replace('.php', '-child.php', $original_template);
        if (file_exists($child_template)) {
            return $child_template;
        } else {
            return $original_template;
        }
    } elseif ($wp_query->is_posts_page) {
        if (file_exists(TEMPLATEPATH . '/archive-post.php')) {
            return TEMPLATEPATH . '/archive-post.php';
        } else {
            return TEMPLATEPATH . '/archive.php';
        }
    } else {
        return $original_template;
    }
}

add_filter('search_template', 'change_search_template');
function change_search_template($template)
{
    if ($_GET['post_type'] != '' && $_GET['post_type'] != 'post' && $_GET['post_type'] != 'page') {
        return locate_template('archive-' . $_GET['post_type'] . '.php');
    } else {
        return locate_template('search.php');
    }
}

function wp_admin_bar_options()
{
    global $wp_admin_bar;
    $wp_admin_bar->add_menu([
        'id' => 'wp-admin-bar-options',
        'title' => __('Site options'),
        'href' => get_site_url() . '/wp-admin/themes.php?page=options'
    ]);
}
add_action('wp_before_admin_bar_render', 'wp_admin_bar_options');

if (function_exists('acf_add_options_page') && current_user_can('manage_options')) {
    acf_add_options_page([
        'page_title' => 'Site options',
        'menu_title' => 'Site options',
        'menu_slug' => 'options',
        'parent_slug' => 'themes.php',
        'update_button' => __('Update'),
        'updated_message' => __('Item updated.'),
        'autoload' => true
    ]);
}

if (function_exists('acf_add_options_page') && current_user_can('manage_options')) {
    acf_add_options_page([
        'page_title' => 'Site configurator',
        'menu_title' => 'Configurator',
        'menu_slug' => 'config',
        'icon_url' => 'dashicons-screenoptions',
        'parent_slug' => 'tools.php',
        'update_button' => __('Update'),
        'updated_message' => __('Item updated.'),
        'autoload' => true
    ]);
}

add_filter('acf/load_field/name=taxonomy_for_query', 'get_taxonomies_for_query');
function get_taxonomies_for_query($field)
{
    $taxonomies = get_taxonomies();
    unset($taxonomies['category'], $taxonomies['post_tag']);

    foreach ($taxonomies as $key => $value) {
        $tax = get_taxonomy($key);
        $taxonomies[$key] = get_taxonomy_labels($tax)->singular_name . ' (' . $key . ')';
    }
    $field['choices']['category_name'] = 'Рубрика (category)';
    $field['choices']['tag'] = 'Метка (post_tag)';
    $field['choices'] = array_merge($field['choices'], $taxonomies);
    return $field;
}

add_filter('acf/load_field/name=taxonomy_select', 'get_taxonomies_select');
function get_taxonomies_select($field)
{
    $taxonomies = get_taxonomies();
    foreach ($taxonomies as $key => $value) {
        $tax = get_taxonomy($key);
        $taxonomies[$key] = get_taxonomy_labels($tax)->singular_name . ' (' . $key . ')';
    }
    $field['choices'] = array_merge($field['choices'], $taxonomies);
    return $field;
}

add_filter('acf/load_field/name=post_type_select', 'get_post_type_select');
function get_post_type_select($field)
{
    $post_types = get_post_types();
    foreach ($post_types as $key => $value) {
        $post_type = get_post_type_object($key);
        $post_types[$key] = get_post_type_labels($post_type)->singular_name . ' (' . $key . ')';
    }
    $field['choices'] = $post_types;
    return $field;
}

function select_query_by_name($query_name)
{
    $args = [];
    if (function_exists('have_rows')) {
        if (have_rows('custom_query', 'option')) :
            while (have_rows('custom_query', 'option')) : the_row();
                if (get_sub_field('name') === $query_name) {
                    $args['post_type'] = get_sub_field('post_type_select');
                    $args['posts_per_page'] = get_sub_field('posts_per_page') === '' ? -1 : get_sub_field('posts_per_page');
                    if (get_sub_field('paged')) {
                        $args['paged'] = get_query_var('paged');
                    }
                    while (have_rows('taxonomy')) : the_row();
                        $args[get_sub_field('taxonomy_for_query')] = get_sub_field('terms');
                    endwhile;
                }
            endwhile;
        endif;
    }
    return $args;
}

function select_term_query_by_name($query_name)
{
    $args = [];
    if (function_exists('have_rows')) {
        if (have_rows('custom_term_query', 'option')) :
            while (have_rows('custom_term_query', 'option')) : the_row();
                if (get_sub_field('name') === $query_name) {
                    $args['taxonomy'] = get_sub_field('taxonomy_select');
                    $args['hide_empty'] = get_sub_field('hide_empty');
                    $args['orderby'] = get_sub_field('orderby');
                    $args['order'] = get_sub_field('order');
                }
            endwhile;
        endif;
    }
    return $args;
}

add_action('init', 'register_cpts');
function register_cpts()
{
    if (function_exists('have_rows')) :
        while (have_rows('custom_post_types', 'option')) : the_row();
            register_post_type(
                get_sub_field('name'),
                [
                    'labels' => [
                        'name' => get_sub_field('many_name'),
                        'menu_name' => get_sub_field('menu_name') != '' ? get_sub_field('menu_name') : get_sub_field('many_name'),
                        'singular_name' => get_sub_field('single_name'),
                        'add_new' => 'Добавить',
                        'add_new_item' => get_sub_field('single_name'),
                        'edit_item' => 'Редактировать',
                        'new_item' => get_sub_field('single_name'),
                        'all_items' => 'Все ' . mb_strtolower(get_sub_field('many_name')),
                        'view_item' => 'Просмотреть',
                        'search_items' => 'Найти',
                        'not_found' => 'Ничего не найдено.',
                        'not_found_in_trash' => 'В корзине пусто.'
                    ],
                    'public' => true,
                    'menu_icon' => get_sub_field('icon'),
                    'menu_position' => 20,
                    'has_archive' => true,
                    'supports' => get_sub_field('support'),
                    'taxonomies' => [''],
                    'show_in_rest' => get_sub_field('show_in_rest'),
                    'publicly_queryable' => get_sub_field('publicly_queryable') !== '' ? get_sub_field('publicly_queryable') : true,
                    'rewrite' => [
                        'slug' => get_sub_field('slug')
                    ]
                ]
            );
        endwhile;
    endif;
}

add_action('init', 'register_taxs');
function register_taxs()
{
    if (function_exists('have_rows')) :
        while (have_rows('custom_taxonomies', 'option')) : the_row();
            register_taxonomy(
                get_sub_field('name'),
                get_sub_field('post_type_select'),
                [
                    'labels' => [
                        'name' => get_sub_field('many_name'),
                        'singular_name' => get_sub_field('single_name'),
                        'search_items' => 'Найти',
                        'popular_items' => 'Популярные ' . mb_strtolower(get_sub_field('many_name')),
                        'all_items' => 'Все ' . mb_strtolower(get_sub_field('many_name')),
                        'parent_item' => null,
                        'parent_item_colon' => null,
                        'edit_item' => 'Редактировать',
                        'update_item' => 'Обновить',
                        'add_new_item' => 'Добавить новый элемент',
                        'new_item_name' => 'Введите название записи',
                        'separate_items_with_commas' => 'Разделяйте ' . mb_strtolower(get_sub_field('many_name')) . ' запятыми',
                        'add_or_remove_items' => 'Добавить или удалить ' . mb_strtolower(get_sub_field('many_name')),
                        'choose_from_most_used' => 'Выбрать из наиболее часто используемых',
                        'menu_name' => get_sub_field('menu_name') != '' ? get_sub_field('menu_name') : get_sub_field('many_name')
                    ],
                    'hierarchical' => get_sub_field('type') === 'true' ? true : false,
                    'public' => true,
                    'publicly_queryable' => get_sub_field('publicly_queryable') !== '' ? get_sub_field('publicly_queryable') : true,
                    'show_in_nav_menus' => true,
                    'show_admin_column' => true,
                    'show_in_quick_edit' => true,
                    'show_in_rest' => false,
                    'show_ui' => true,
                    'show_tagcloud' => true,
                    'update_count_callback' => '_update_post_term_count',
                    'query_var' => true,
                    'rewrite' => [
                        'slug' => get_sub_field('slug'),
                        'hierarchical' => false
                    ],
                ]
            );
        endwhile;
    endif;
}

function query_filter()
{
    if ((isset($_GET['post_type']) || isset($_GET['sort']) || isset($_GET['posts_per_page']))
        && !isset($_GET['min_price']) && !isset($_GET['max_price'])
        && !strpos($_SERVER['QUERY_STRING'], 'filter_')
    ) {
        global $wp_query;

        $args = [];
        $args['meta_query'] = ['relation' => 'AND'];
        $args['tax_query'] = ['relation' => 'AND'];

        foreach ($_GET as $key => $value) {
            if (is_array($value)) {
                if (substr($key, 0, 6) === 'in_pm_') {
                    $args['meta_query'][] = [
                        'key' => substr($key, 6),
                        'value' => $value,
                        'compare' => 'IN'
                    ];
                } else {
                    $args['tax_query'][] = [
                        'taxonomy' => $key,
                        'field' => 'slug',
                        'terms' => $value,
                        'operator' => 'IN'
                    ];
                }
            }

            if (substr($key, 0, 7) === 'min_pm_' && $value != '') {
                $args['meta_query'][] = [
                    'key' => substr($key, 7),
                    'value' => $value,
                    'type' => 'numeric',
                    'compare' => '>='
                ];
            }

            if (substr($key, 0, 7) === 'max_pm_' && $value != '') {
                $args['meta_query'][] = [
                    'key' => substr($key, 7),
                    'value' => $value,
                    'type' => 'numeric',
                    'compare' => '<='
                ];
            }

            if (substr($key, 0, 8) === 'min_pmf_' && $value != '') {
                $args['meta_query'][] = [
                    'key' => substr($key, 8),
                    'value' => $value,
                    'type' => 'decimal',
                    'compare' => '>='
                ];
            }

            if (substr($key, 0, 8) === 'max_pmf_' && $value != '') {
                $args['meta_query'][] = [
                    'key' => substr($key, 8),
                    'value' => $value,
                    'type' => 'decimal',
                    'compare' => '<='
                ];
            }

            if (substr($key, 0, 8) === 'min_pmd_' && $value != '') {
                $args['meta_query'][] = [
                    'key' => substr($key, 8),
                    'value' => date('Ymd', strtotime($value)),
                    'type' => 'date',
                    'compare' => '>='
                ];
            }

            if (substr($key, 0, 8) === 'max_pmd_' && $value != '') {
                $args['meta_query'][] = [
                    'key' => substr($key, 8),
                    'value' => date('Ymd', strtotime($value)),
                    'type' => 'date',
                    'compare' => '<='
                ];
            }

            if (substr($key, 0, 3) === 'pm_' & $value !== '') {
                $args['meta_query'][] = [
                    'key' => substr($key, 3),
                    'value' => $value
                ];
            }

            if ($key === 'post_types') {
                $args['post_type'] = explode(',', $value);
            }

            if ($key === 'posts_per_page') {
                $args['posts_per_page'] = $value;
            }

            if ($key === 'sort') {
                $v = explode('.', $value);
                if (count($v) === 3) {
                    $args['orderby'] = $v[0];
                    $args['meta_key'] = $v[1];
                    $args['order'] = $v[2];
                } else {
                    $args['orderby'] = $v[0];
                    $args['order'] = $v[1];
                }
            }
        }
        $result_query = array_merge($args, $wp_query->query);
        $result_query = apply_filters('wtw_query_filter_result_query', $result_query, $_GET);
        query_posts($result_query);
    }
}

add_action('wp', 'query_filter');

function ajaxs_load_posts($jx)
{
    $args = [];
    $args = unserialize(stripslashes($jx->data['query']));
    $args['post_status'] = 'publish';
    $args['paged'] = $jx->data['page'] + 1;
    if (isset($args['ID']) || $jx->data['archive']) {
        $post = get_post($args['ID']);
        query_posts($args);
    }
    ob_start();
    require locate_template('template-parts/' . $jx->data['part'] . '.php');
    return ob_get_clean();
};

function posts_per_page_change($query)
{
    if (isset($_GET['perpage']) && $query->is_main_query() && !$query->is_admin) {
        $query->set('posts_per_page', $_GET['perpage']);
    }
}
add_action('pre_get_posts', 'posts_per_page_change');

add_action('after_setup_theme', 'add_editor_css');
function add_editor_css()
{
    add_theme_support('editor-styles');
    //add_editor_style( 'css/main.css' );
}

function get_term_option_html($taxonomy, $term)
{
    global $wp_query;
    return '<option value="' . $term->slug . '" ' . selected(!isset($_GET['post_type']) ? $wp_query->query_vars['term'] : $_GET[$taxonomy], $term->slug, false) . '>' . $term->name . '</option>';
}

function get_option_html($value, $title, $selected = false)
{
    return '<option value="' . $value . '" ' . selected($selected, $value, false) . '>' . $title . '</option>';
}

function d()
{
    if (!headers_sent()) {
        header('Content-Type: text/html; charset=utf-8');
    }

    echo '<pre style="text-align: left; font-size: 10px;">';
    foreach (func_get_args() as $var) {
        print_r($var);
        echo '<br><br>';
    }
    echo '</pre>';
}

function dc()
{
    if (!headers_sent()) {
        header('Content-Type: text/html; charset=utf-8');
    }

    echo "<!--\n";
    foreach (func_get_args() as $var) {
        print_r($var) . "\n";
    }
    echo "\n-->";
}

function dd()
{
    if (!headers_sent()) {
        header('Content-Type: text/html; charset=utf-8');
    }

    echo '<pre style="text-align: left; font-size: 10px;">';
    foreach (func_get_args() as $var) {
        print_r($var);
        echo '<br><br>';
    }
    echo '</pre>';
    die();
}

add_filter('get_the_archive_title', function ($title) {
    return preg_replace('~^[^:]+: ~', '', $title);
});

function ajaxs_filter($jx)
{
    $args = unserialize(stripslashes($jx->data['query']));

    $args['meta_query'] = ['relation' => 'AND'];
    $args['tax_query'] = ['relation' => 'AND'];
    $args['post_status'] = 'publish';

    foreach ($jx->data as $key => $value) {
        if ($value !== '') {
            if ($key === 's') {
                $args['s'] = $value;
            } elseif (substr($key, 0, 6) === 'in_pm_') {
                $args['meta_query'][] = [
                    'key' => substr($key, 6),
                    'value' => $value,
                    'compare' => 'IN'
                ];
            } elseif (substr($key, 0, 7) === 'min_pm_') {
                $args['meta_query'][] = [
                    'key' => substr($key, 7),
                    'value' => $value,
                    'type' => 'numeric',
                    'compare' => '>='
                ];
            } elseif (substr($key, 0, 7) === 'max_pm_') {
                $args['meta_query'][] = [
                    'key' => substr($key, 7),
                    'value' => $value,
                    'type' => 'numeric',
                    'compare' => '<='
                ];
            } elseif (substr($key, 0, 8) === 'min_pmf_') {
                $args['meta_query'][] = [
                    'key' => substr($key, 8),
                    'value' => $value,
                    'type' => 'decimal',
                    'compare' => '>='
                ];
            } elseif (substr($key, 0, 8) === 'max_pmf_') {
                $args['meta_query'][] = [
                    'key' => substr($key, 8),
                    'value' => $value,
                    'type' => 'decimal',
                    'compare' => '<='
                ];
            } elseif (substr($key, 0, 8) === 'min_pmd_') {
                $args['meta_query'][] = [
                    'key' => substr($key, 8),
                    'value' => date('Ymd', strtotime($value)),
                    'type' => 'date',
                    'compare' => '>='
                ];
            } elseif (substr($key, 0, 8) === 'max_pmd_') {
                $args['meta_query'][] = [
                    'key' => substr($key, 8),
                    'value' => date('Ymd', strtotime($value)),
                    'type' => 'date',
                    'compare' => '<='
                ];
            } elseif (substr($key, 0, 3) === 'pm_') {
                $args['meta_query'][] = [
                    'key' => substr($key, 3),
                    'value' => $value
                ];
            } elseif ($key === 'post_type') {
                $args['post_type'] = explode(',', $value);
            } elseif ($key === 'posts_per_page') {
                $args['posts_per_page'] = $value;
            } elseif ($key === 'sort') {
                $v = explode('.', $value);
                if (count($v) === 3) {
                    $args['orderby'] = $v[0];
                    $args['meta_key'] = $v[1];
                    $args['order'] = $v[2];
                } else {
                    $args['orderby'] = $v[0];
                    $args['order'] = $v[1];
                }
            } elseif ($key === 'ajaxs_nonce') {
            } elseif ($key === 'query') {
            } else {
                $operator = 'IN';
                $field = 'slug';

                if (strpos($value, ':') !== false && !is_array($value)) {
                    $value_arr = explode(':', $value);

                    if (count($value_arr) === 2) {
                        $operator = $value_arr[0];
                        $value = $value_arr[1];
                    } elseif (count($value_arr) === 3) {
                        $field = $value_arr[0];
                        $operator = $value_arr[1];
                        $value = $value_arr[2];
                    }

                    if (strpos($value, ',') !== false) {
                        $value = explode(',', $value);
                    }
                }
                if (trim(implode('', $value)) !== '') {
                    $args['tax_query'][] = [
                        'taxonomy' => $key,
                        'field'    => $field,
                        'operator' => $operator,
                        'terms'    => $value,
                    ];
                } else {
                    if ($value !== '' && !is_array($value)) {
                        $args['tax_query'][] = [
                            'taxonomy' => $key,
                            'field'    => $field,
                            'terms'    => [$value],
                        ];
                    }
                }
            }
        }
    }

    // $jx->log($jx->data);
    // $jx->log($args);

    $query_vars = serialize($args);

    $jx->call('set_query_vars', $query_vars);

    ob_start();
    include locate_template('template-parts/' . $jx->data['post_type'] . '.php');
    return ob_get_clean();
}

function wtw_sort_terms_hierarchicaly(&$cats, &$into, $parentId = 0)
{
    foreach ($cats as $i => $cat) {
        if ($cat->parent == $parentId) {
            $into[$cat->term_id] = $cat;
            unset($cats[$i]);
        }
    }

    foreach ($into as $top_cat) {
        $top_cat->children = [];
        wtw_sort_terms_hierarchicaly($cats, $top_cat->children, $top_cat->term_id);
    }
}

function wtw_sort_menu_hierarchicaly(&$menu_items, &$into, $parentId = 0)
{
    foreach ($menu_items as $i => $item) {
        if ($item->parent == $parentId) {
            $into[$item->id] = $item;
            unset($menu_items[$i]);
        }
    }

    foreach ($into as $top_menu) {
        $top_menu->children = [];
        wtw_sort_menu_hierarchicaly($menu_items, $top_menu->children, $top_menu->id);
    }
}

function wtw_get_menu_posts($menu_id)
{
    $args = [
        'post_type' => 'nav_menu_item',
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'tax_query' => [
            [
                'taxonomy' => 'nav_menu',
                'field' => 'slug',
                'terms' => $menu_id
            ]
        ]
    ];

    $menu_posts = new WP_Query;
    $menu_posts->query($args);
    $menu = [];

    foreach ($menu_posts->posts as $p) {
        $m = get_post_meta($p->ID);

        if ($m['_menu_item_type'][0] === 'taxonomy') {
            $term = get_term($m['_menu_item_object_id'][0], $m['_menu_item_object'][0]);
            $post_title = $term->name;
            $page_url = get_term_link((int) $m['_menu_item_object_id'][0], $m['_menu_item_object'][0]);
        } elseif ($m['_menu_item_object'][0] !== 'custom' && $p->post_title === '') {
            $page = get_post($m['_menu_item_object_id'][0]);
            $post_title = $page->post_title;
            $page_url = '/' . get_page_uri($page->ID);
        } else {
            $post_title = $p->post_title;
            $page_url = $m['_menu_item_url'][0];
        }

        $parent = (int) $m['_menu_item_menu_item_parent'][0];
        $menu_item = new stdClass;
        $menu_item->id = $p->ID;
        $menu_item->title = $post_title;
        $menu_item->url = $page_url;
        $menu_item->parent = $parent;
        $menu_item->object = $m['_menu_item_object'][0];
        $menu_item->object_id = $m['_menu_item_object_id'][0];
        $menu_item->item_type = $m['_menu_item_type'][0];
        $menu[] = $menu_item;
    }
    return $menu;
}

function wtw_get_menu_tree($menu_name)
{
    $menu_object = wp_get_nav_menu_object($menu_name);
    if ($menu_object) {
        $menu_tree = [];
        $menu_posts = wtw_get_menu_posts($menu_object->slug);

        wtw_sort_menu_hierarchicaly($menu_posts, $menu_tree);

        return $menu_tree;
    }
}

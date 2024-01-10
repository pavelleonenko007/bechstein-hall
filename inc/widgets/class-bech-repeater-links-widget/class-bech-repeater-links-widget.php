<?php

/**
 * Adds Foo_Widget widget.
 */
class Bech_Repeater_Links_Widget extends WP_Widget
{

    /**
     * Register widget with WordPress.
     */
    public function __construct()
    {
        parent::__construct(
            'bech_repeater_links_widget',
            'Bechstein Repeater Links Widget',
            array('description' => 'Add multiple links',)
        );

        add_action('admin_enqueue_scripts', array($this, 'register_widget_scripts'));
    }

    public function register_widget_scripts()
    {
        wp_register_script(
            'bech_repeater_widget_script',
            get_template_directory_uri() . '/inc/widgets/class-bech-repeater-links-widget/class-bech-repeater-links-widget.js',
            false,
            time(),
            true
        );
        wp_enqueue_script('bech_repeater_widget_script');
        wp_enqueue_style('bech_repeater_widget_style', get_template_directory_uri() . '/inc/widgets/class-bech-repeater-links-widget/class-bech-repeater-links-widget.css', false, time(), false);
    }

    /**
     * Front-end display of widget.
     *
     * @param array $args Widget arguments.
     * @param array $instance Saved values from database.
     * @see WP_Widget::widget()
     *
     */
    public function widget($args, $instance)
    {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);

        echo $before_widget;
        if (!empty($title)) { ?>
            <div id="w-node-e2a4b54f-db07-d972-40d4-89e5e03639ea-8073c07c" class="p-30-40 med w35"><?php echo $title; ?></div>
        <?php }
        if (!empty($instance['links'])) {
            foreach ($instance['links'] as $link): ?>
                <a href="<?php echo $link['url']; ?>" class="ui-yourvisit_link-in w-inline-block">
                    <div class="p-20-30 med w20"><?php echo $link['title']; ?></div>
                    <div class="p-17-25 mar10"><?php echo $link['description']; ?></div>
                </a>
            <?php endforeach;
        }
        echo $after_widget;
    }

    /**
     * Back-end widget form.
     *
     * @param array $instance Previously saved values from database.
     * @see WP_Widget::form()
     *
     */
    public function form($instance)
    {
        $title = $instance['title'] ? $instance['title'] : '';
        $links = $instance['links'] ? $instance['links'] : [];

        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"></label>
            <input
                    class="widefat"
                    id="<?php echo $this->get_field_id('title'); ?>"
                    name="<?php echo $this->get_field_name('title'); ?>"
                    type="text"
                    value="<?php echo esc_attr($title); ?>"
            />
        </p>
        <div class="bech-repeater-widget-fields">
            <p>
                <label for="<?php echo $this->get_field_id('links[0][title]'); ?>">Title</label>
                <input type="text" id="<?php echo $this->get_field_id('links[0][title]'); ?>" class="widefat" name="<?php echo $this->get_field_name('links[0][title]'); ?>" value="">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('links[0][description]'); ?>">Description</label>
                <input type="text" id="<?php echo $this->get_field_id('links[0][description]'); ?>" class="widefat" name="<?php echo $this->get_field_name('links[0][description]'); ?>" value="">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('links[0][url]'); ?>">URL</label>
                <input type="text" id="<?php echo $this->get_field_id('links[0][url]'); ?>" class="widefat" name="<?php echo $this->get_field_name('links[0][url]'); ?>" value="">
            </p>
        </div>
        <?php
        if (!empty($links)) {
//            var_dump($links);
            foreach ($links as $index => $link):
                $num = $index + 1; ?>
                <div class="bech-repeater-widget-fields">
                    <p>
                        <label for="<?php echo $this->get_field_id('links['. $num .'][title]'); ?>">Title</label>
                        <input type="text" id="<?php echo $this->get_field_id('links['. $num .'][title]'); ?>" class="widefat" name="<?php echo $this->get_field_name('links['. $num .'][title]'); ?>" value="<?php echo $link['title']; ?>">
                    </p>
                    <p>
                        <label for="<?php echo $this->get_field_id('links['. $num .'][description]'); ?>">Description</label>
                        <input type="text" id="<?php echo $this->get_field_id('links['. $num .'][description]'); ?>" class="widefat" name="<?php echo $this->get_field_name('links['. $num .'][description]'); ?>" value="<?php echo $link['description']; ?>">
                    </p>
                    <p>
                        <label for="<?php echo $this->get_field_id('links['. $num .'][url]'); ?>">URL</label>
                        <input type="text" id="<?php echo $this->get_field_id('links['. $num .'][url]'); ?>" class="widefat" name="<?php echo $this->get_field_name('links['. $num .'][url]'); ?>" value="<?php echo $link['url']; ?>">
                    </p>
                </div>
            <?php endforeach;
        }
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     * @see WP_Widget::update()
     *
     */
    public function update($new_instance, $old_instance): array
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['links'] = (!empty($new_instance['links'])) ? $new_instance['links'] : [];

        $instance['links'] = array_filter($instance['links'], function ($item) {
            return !empty($item['title']);
        });
//        die(var_dump(!empty($new_instance['links'])));
        return $instance;
    }
}

add_action('widgets_init', 'bech_register_repeater_links_widget');
function bech_register_repeater_links_widget(): void
{
    register_widget('Bech_Repeater_Links_Widget');
}

?>
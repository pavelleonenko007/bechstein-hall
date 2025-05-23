<?php
require get_template_directory() . '/inc/widgets/class-bech-repeater-links-widget/class-bech-repeater-links-widget.php';
require get_template_directory() . '/inc/widgets/class-bech-contact-widget/class-bech-contact-widget.php';

add_theme_support( 'custom-logo' );
add_theme_support( 'widgets' );

add_action( 'wp_enqueue_scripts', 'bech_add_scripts' );
function bech_add_scripts(): void {
	wp_enqueue_style( 'custom', get_template_directory_uri() . '/css/custom.css', array( 'main' ), rand() );
	wp_enqueue_style( 'style-css', get_template_directory_uri() . '/css/style-cus.css', array( 'custom' ), rand() );

	/**
	 * script for IE 9
	 */
	wp_enqueue_script( 'placeholders', '//cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js', array(), false, true );
	wp_script_add_data( 'placeholders', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-datepicker' );
	wp_enqueue_script( 'main', get_template_directory_uri() . '/js/main.js', array( 'jquery' ), time(), true );
	wp_enqueue_script( 'add-to-calendar-button', '//cdn.jsdelivr.net/npm/add-to-calendar-button@1', array( 'main' ), false, true );
	wp_enqueue_script( 'front', get_template_directory_uri() . '/js/front.js', array( 'main' ), false, true );
	wp_enqueue_script( 'splide', '//cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js', array( 'front' ), false, true );
	wp_enqueue_script( 'gsap', '//cdnjs.cloudflare.com/ajax/libs/gsap/3.8.0/gsap.min.js', array( 'front' ), false, true );
	wp_enqueue_script( 'tween-max', get_template_directory_uri() . '/js/TweenMax.min.js', array( 'front' ), false, true );
	wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/custom.js', array( 'front' ), false, true );
	wp_enqueue_script( 'script-cus', get_template_directory_uri() .'/js/script-cus.js', array( 'custom' ), false, true );
	wp_localize_script(
		'custom',
		'bech_var',
		array(
			'url'      => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'ajax-nonce' ),
			'home_url' => get_home_url(),
		)
	);
}

add_action( 'widgets_init', 'bech_register_sidebar' );
function bech_register_sidebar(): void {
	register_sidebar(
		array(
			'name' => 'Bechstein Sidebar',
			'id'   => 'custom_bechstein_sidebar',
		)
	);
}

/* Tix Utils Functions */

function bech_format_date( $str = '', $format = 'Y-m-d H:i:s' ): string {
	$date = new DateTime( $str );

	return $date->format( $format );
}

function bech_purchase_url_format_data( $arr ): array {
	$formatted_arr = array();

	foreach ( $arr as $item ) {
		$formatted_item                       = array();
		$formatted_item['two_letter_culture'] = $item['TwoLetterCulture'];
		$formatted_item['link']               = $item['Link'];

		$formatted_arr[] = $formatted_item;
	}

	return $formatted_arr;
}

function bech_get_events_number( $array, $word ) {
	$count = count( $array );
	if ( $count === 1 ) {
		return "{$count} {$word}";
	} else {
		return "{$count} {$word}s";
	}
}

function bech_get_current_url() {
	global $wp;
	return home_url( $wp->request );
}

function bech_is_current_url( $url ) {
	$formatted_url = '';
	if ( substr( $url, -1 ) !== '/' ) {
		$formatted_url = $url;
	} else {
		$formatted_url = substr( $url, 0, -1 );
	}

	return bech_get_current_url() === $formatted_url;
}

add_action( 'init', 'bech_register_post_types' );
function bech_register_post_types() {
	register_post_type(
		'team',
		array(
			'label'         => null,
			'labels'        => array(
				'name'               => 'Team', // основное название для типа записи
				'singular_name'      => 'Teammate', // название для одной записи этого типа
				'add_new'            => 'Add new', // для добавления новой записи
				'add_new_item'       => 'Add new teammate', // заголовка у вновь создаваемой записи в админ-панели.
				'edit_item'          => "Edit teammate's info", // для редактирования типа записи
				'new_item'           => 'New teammate', // текст новой записи
				'view_item'          => 'View teammate', // для просмотра записи этого типа.
				'search_items'       => 'Search teammates', // для поиска по этим типам записи
				'not_found'          => 'Not Found', // если в результате поиска ничего не было найдено
				'not_found_in_trash' => 'Not Found in trash', // если не было найдено в корзине
				'parent_item_colon'  => '', // для родителей (у древовидных типов)
				'menu_name'          => 'Team', // название меню
			),
			'description'   => '',
			'public'        => false,
			// 'publicly_queryable'  => null, // зависит от public
			// 'exclude_from_search' => null, // зависит от public
			'show_ui'       => true, // зависит от public
		// 'show_in_nav_menus'   => null, // зависит от public
			'show_in_menu'  => true,
			// показывать ли в меню адмнки
			// 'show_in_admin_bar'   => null, // зависит от show_in_menu
			'show_in_rest'  => true,
			// добавить в REST API. C WP 4.7
			'rest_base'     => null,
			// $post_type. C WP 4.7
			'menu_position' => 15,
			'menu_icon'     => 'dashicons-groups',
			// 'capability_type'   => 'post',
			// 'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
			// 'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
			'hierarchical'  => false,
			'supports'      => array( 'title', 'editor', 'thumbnail' ),
			// 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
			'taxonomies'    => array(),
			'has_archive'   => false,
			'rewrite'       => true,
			'query_var'     => true,
		)
	);

	register_post_type(
		'press-office',
		array(
			'label'         => null,
			'labels'        => array(
				'name'               => 'Press Office', // основное название для типа записи
				'singular_name'      => 'News', // название для одной записи этого типа
				'add_new'            => 'Add news', // для добавления новой записи
				'add_new_item'       => 'Add news', // заголовка у вновь создаваемой записи в админ-панели.
				'edit_item'          => 'Edit news', // для редактирования типа записи
				'new_item'           => 'New post', // текст новой записи
				'view_item'          => 'View post', // для просмотра записи этого типа.
				'search_items'       => 'Search news', // для поиска по этим типам записи
				'not_found'          => 'Not Found', // если в результате поиска ничего не было найдено
				'not_found_in_trash' => 'Not Found in trash', // если не было найдено в корзине
				'parent_item_colon'  => '', // для родителей (у древовидных типов)
				'menu_name'          => 'Press Office', // название меню
			),
			'description'   => '',
			'public'        => true,
			// 'publicly_queryable'  => null, // зависит от public
			// 'exclude_from_search' => null, // зависит от public
			'show_ui'       => true, // зависит от public
		// 'show_in_nav_menus'   => null, // зависит от public
			'show_in_menu'  => true,
			// показывать ли в меню адмнки
			// 'show_in_admin_bar'   => null, // зависит от show_in_menu
			'show_in_rest'  => true,
			// добавить в REST API. C WP 4.7
			'rest_base'     => null,
			// $post_type. C WP 4.7
			'menu_position' => 15,
			// 'menu_icon'     => 'dashicons-post',
			// 'capability_type'   => 'post',
			// 'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
			// 'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
			'hierarchical'  => false,
			'supports'      => array( 'title', 'editor', 'thumbnail' ),
			// 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
			'taxonomies'    => array(),
			'has_archive'   => true,
			'rewrite'       => true,
			'query_var'     => true,
		)
	);

	remove_post_type_support( 'press-office', 'editor' );

	register_taxonomy(
		'press_tag',
		array( 'press-office' ),
		array(
			'label'             => '', // определяется параметром $labels->name
			'labels'            => array(
				'name'              => 'Press Office tags',
				'singular_name'     => 'Tag',
				'search_items'      => 'Search Tags',
				'all_items'         => 'All Tags',
				'view_item '        => 'View Tag',
				'parent_item'       => 'Parent Tag',
				'parent_item_colon' => 'Parent Tag:',
				'edit_item'         => 'Edit Tag',
				'update_item'       => 'Update Tag',
				'add_new_item'      => 'Add New Tag',
				'new_item_name'     => 'New Tag Name',
				'menu_name'         => 'Tags',
				'back_to_items'     => '← Back to Tags',
			),
			'description'       => '', // описание таксономии
			'public'            => false,
			// 'publicly_queryable'    => null, // равен аргументу public
			// 'show_in_nav_menus'     => true, // равен аргументу public
			'show_ui'           => true, // равен аргументу public
			'show_in_menu'      => true, // равен аргументу show_ui
		// 'show_tagcloud'         => true, // равен аргументу show_ui
		// 'show_in_quick_edit'    => null, // равен аргументу show_ui
			'hierarchical'      => false,

			'rewrite'           => true,
			// 'query_var'             => $taxonomy, // название параметра запроса
			'capabilities'      => array(),
			'meta_box_cb'       => null, // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
			'show_admin_column' => false, // авто-создание колонки таксы в таблице ассоциированного типа записи. (с версии 3.5)
			'show_in_rest'      => null, // добавить в REST API
			'rest_base'         => null, // $taxonomy
		// '_builtin'              => false,
		// 'update_count_callback' => '_update_post_term_count',
		)
	);
}

// add_filter('pre_get_posts', function ($query_vars) {
// if (is_admin()) {
// return $query_vars;
// }

// if (is_post_type_archive('press-office')) {
// $query_vars->query;
// $query_vars->query['pagename'] = 'press-office';
// $query_vars->query['page'] = '';
// unset($query_vars->query['post_type']);
// }

// var_dump($query_vars);
// return $query_vars;
// });

add_filter( 'request', 'bech_change_post_variable_in_press_office_archive' );

function bech_change_post_variable_in_press_office_archive( $query_vars ) {
	if ( is_admin() ) {
		return $query_vars;
	}

	$request           = urldecode( $_SERVER['REQUEST_URI'] );
	$change_query_vars = false;

	if ( str_contains( $_SERVER['HTTP_HOST'], 'localhost' ) ) {
		if ( $request === '/bechstein-hall/press-office/' ) {
			$change_query_vars = true;
		}
	} elseif ( $request === '/press-office/' ) {
			$change_query_vars = true;
	}

	if ( $change_query_vars ) {
		$query_vars['pagename'] = 'press-office';
		$query_vars['page']     = '';
		unset( $query_vars['post_type'] );
	}

	return $query_vars;
}

/* Tix Utils Functions */

/**
 * webhook endpoint
 */

// add_action('rest_api_init', function () {
// register_rest_route('tix-webhook/v1', '/webhook', array(
// 'methods'             => 'GET',
// 'callback'            => 'bech_webhook_callback',
// 'permission_callback' => '__return_true'
// ));
// });

function bech_webhook_callback( WP_REST_Request $request ) {
	require_once ABSPATH . 'wp-admin/includes/file.php';
	$url      = 'https://eventapi.tix.uk/v2/Events?key=39c4703fb4a64c7e';
	$response = wp_remote_get( $url );

	if ( is_wp_error( $response ) ) {
		return new WP_Error( 'can_not_fetch_data', 'Can not fetch data from tix', array( 'status' => 400 ) );
	}

	if ( is_dir( get_home_path() . 'tix-logs' ) === false ) {
		mkdir( get_home_path() . 'tix-logs' );
	}

	$file = fopen( get_home_path() . 'tix-logs/logs.txt', 'a' );
	fwrite( $file, '=== Start: ' . date( 'l jS \of F Y h:i:s A' ) . '=== ||' );
	fwrite( $file, json_encode( $request->get_body_params() ) );

	fwrite( $file, '==||==' );

	fwrite( $file, json_encode( $request->get_body() ) );
	fwrite( $file, '|| === End ===' );
	fclose( $file );

	$body  = json_decode( $response['body'], true );
	$error = '';

	foreach ( $body as $event ) {
		$category_res = '';

		$existing_category = get_terms(
			array(
				'taxonomy'   => 'event_cat',
				'get'        => 'all',
				'meta_key'   => 'event_group_id',
				'meta_value' => $event['EventGroupId'],
			)
		);

		if ( $existing_category[0] ) {
			$category_res = wp_update_term(
				$existing_category[0]->term_id,
				'event_cat',
				array(
					'description' => $event['Description'],
				)
			);
		} else {
			$category_res = wp_insert_term(
				$event['Name'],
				'event_cat',
				array(
					'description' => $event['Description'],
				)
			);
		}

		if ( is_wp_error( $category_res ) ) {
			$error = $category_res->get_error_message();
			break;
		}

		update_field( 'field_62fa240659e1f', $event['EventGroupId'], 'event_cat_' . $category_res['term_id'] );
		update_field( 'field_62e114041c431', $event['EventImagePath'], 'event_cat_' . $category_res['term_id'] );
		update_field( 'field_62e116751c432', $event['FeaturedImagePath'], 'event_cat_' . $category_res['term_id'] );
		update_field( 'field_62e116931c433', $event['PosterImagePath'], 'event_cat_' . $category_res['term_id'] );
		update_field( 'field_62e112e21c42e', bech_purchase_url_format_data( $event['PurchaseUrls'] ), 'event_cat_' . $category_res['term_id'] );

		foreach ( $event['Dates'] as $tiket ) {
			$existing_tiket = get_posts(
				array(
					'post_type'  => 'event',
					'meta_key'   => 'eventid',
					'meta_value' => $tiket['EventId'],
				)
			);

			$tiket_args = array(
				'post_type'    => 'event',
				'post_title'   => $tiket['Name'],
				'post_status'  => 'publish',
				'post_author'  => 1,
				'post_content' => '<p></p>',
			);

			if ( $existing_tiket[0] ) {
				$tiket_args['ID'] = $existing_tiket[0]->ID;
			}

			$ticket_id = wp_insert_post( $tiket_args, true );

			if ( is_wp_error( $ticket_id ) ) {
				$error = $ticket_id->get_error_message();
				break 2;
			}

			$cat_id = wp_set_object_terms( $ticket_id, $category_res['term_id'], 'event_cat', false );

			if ( is_wp_error( $cat_id ) ) {
				$error = $cat_id->get_error_message();
				break 2;
			}

			$event_id_field          = 'field_62fa1a2a5e949';
			$sale_status_field       = 'field_62fa1a3a5e94a';
			$sold_out_field          = 'field_62fa1aee5e94b';
			$waiting_list_field      = 'field_62fa1b775e94c';
			$duration_field          = 'field_62fa1cd95e94d';
			$online_sale_start_field = 'field_62d6800f618cb';
			$online_sale_end_field   = 'field_62d68403618cc';
			$online_date_start_field = 'field_62fa1f3b5e94f';
			$online_date_end_field   = 'field_62fa1f755e950';
			$min_price_field         = 'field_62d68426618cd';
			$max_price_field         = 'field_62d68451618ce';
			$purchase_urls_field     = 'field_62d684c2618cf';

			/* Update Online Sale Start Field */

			update_field( $event_id_field, $tiket['EventId'], $ticket_id );
			update_field( $sale_status_field, $tiket['SaleStatus'], $ticket_id );
			update_field( $duration_field, $tiket['Duration'], $ticket_id );
			update_field( $sold_out_field, $tiket['SoldOut'], $ticket_id );
			update_field( $waiting_list_field, $tiket['WaitingList'], $ticket_id );
			update_field( $online_date_start_field, $tiket['StartDate'], $ticket_id );
			update_field( $online_date_end_field, $tiket['EndDate'], $ticket_id );
			update_field( $online_sale_start_field, $tiket['OnlineSaleStart'], $ticket_id );
			update_field( $online_sale_end_field, $tiket['OnlineSaleEnd'], $ticket_id );
			update_field( $min_price_field, $tiket['MinPrice'], $ticket_id );
			update_field( $max_price_field, $tiket['MaxPrice'], $ticket_id );
			update_field( $max_price_field, $tiket['MaxPrice'], $ticket_id );
			update_field( $purchase_urls_field, bech_purchase_url_format_data( $tiket['PurchaseUrls'] ), $ticket_id );
		}
	}

	if ( $error ) {
		return new WP_Error( 'error_post_update', $error, array( 'status' => 500 ) );
	}

	$rest_response = rest_ensure_response(
		array(
			'code'    => 'success',
			'message' => 'Data succesfully updated',
			'data'    => array(
				'status' => 201,
			),
		)
	);

	$rest_response->set_status( 201 );

	return $rest_response;
}

function bech_sort_tickets( array $tickets ): array {
	$sorted_tickets = array();

	foreach ( $tickets as $ticket ) {
		$date_time                             = new DateTime( bech_get_ticket_date_field( '_bechtix_ticket_start_date', $ticket->ID ) );
		$ticket_date                           = $date_time->format( 'Y-m-d' );
		$ticket_date_unix                      = strtotime( $ticket_date );
		$sorted_tickets[ $ticket_date_unix ][] = $ticket;
	}

	ksort( $sorted_tickets );

	return $sorted_tickets;
}

function bech_get_ticket_from_to_price( $post_id ) {
	$from_price = get_post_meta( $post_id, '_bechtix_min_price', true );
	$to_price   = get_post_meta( $post_id, '_bechtix_max_price', true );

	// from £100 to £320
	if ( $from_price === $to_price ) {
		if ( $from_price !== '' ) {
			return "up to £{$from_price}";
		}
	} else {
		if ( $from_price === '' ) {
			return "up to £{$to_price}";
		}

		if ( $to_price === '' ) {
			return "from £{$from_price}";
		}

		return "from £{$from_price} to £{$to_price}";
	}
}
/**
 * @param string      $field_key
 * @param int|WP_Post $ticket
 */
function bech_get_ticket_date_field( string $field_key, $ticket ): string {
	$field_date_string = get_field( $field_key, $ticket );

	if ( empty( $field_date_string ) ) {
		return '';
	}

	$date = new DateTime( get_field( $field_key, $ticket ), new DateTimeZone( 'UTC' ) );
	$date->setTimezone( new DateTimeZone( get_option( 'timezone_string' ) ) );

	return $date->format( 'Y-m-d H:i:s' );
}

function bech_get_ticket_times( $post_id ): string {
	$start_date = new DateTime( bech_get_ticket_date_field( '_bechtix_ticket_start_date', $post_id ) );
	$end_date   = new DateTime( bech_get_ticket_date_field( '_bechtix_ticket_end_date', $post_id ) );
	$start_time = $start_date->format( 'H:i' );
	$end_time   = $end_date->format( 'H:i' );

	switch ( true ) {
		case $start_time !== '' && $end_time !== '':
			return $start_time . '—' . $end_time;
		case $end_time === '':
			return 'start from ' . $start_time;
		case $start_time === '':
			return 'ends at ' . $end_time;
		default:
			return '–';
	}
}

function bech_get_custom_taxonomies( $taxonomy ) {
	$terms = array_filter(
		get_terms(
			array(
				'taxonomy'   => $taxonomy,
				'hide_empty' => true,
				'parent'     => 0,
			)
		),
		function ( $term ) {
			$tickets = get_posts(
				array(
					'post_type'   => 'events',
					'post_status' => 'publish',
					'tax_query'   => array(
						array(
							'taxonomy' => $term->taxonomy,
							'field'    => 'slug',
							'terms'    => $term->slug,
						),
					),
				)
			);

			return ! empty( $tickets );
		}
	);

	return $terms;
}

function bech_get_specials_filters() {
	$events = get_posts(
		array(
			'post_type'   => 'events',
			'post_status' => 'publish',
			'fields'      => 'ids',
			'meta_query'  => array(
				array(
					'key'     => '_bechtix_festival_relation',
					'value'   => '',
					'compare' => '!=',
				),
			),
		)
	);

	$festivals = array_map(
		function ( $event ) {
			return get_post( get_post_meta( $event, '_bechtix_festival_relation', true ) );
		},
		$events
	);

	return array_unique( $festivals, SORT_REGULAR );
}

function bech_get_selected_filters_string( array $params ): string {
	$selected_params = array();

	foreach ( $params as $key => $param ) {
		if ( ( $key === 'from' || $key === 'to' ) && $param !== '' ) {
			$selected_params[] = gmdate( 'j M Y', strtotime( $param ) );
		} elseif ( $key === 'festival' ) {
			foreach ( $param as $festival_id ) {
				$festival          = get_post( $festival_id );
				$selected_params[] = $festival->post_title;
			}
		} elseif ( $key === 'genres' || $key === 'instruments' || $key === 'time' || $key === 'festival' || $key === 'event_tag' || $key === 's' ) {
			if ( is_array( $param ) ) {
				foreach ( $param as $values ) {
					$selected_params[] = $values;
				}
			}

			if ( is_string( $param ) && $param !== '' ) {
				$selected_params[] = $param;
			}
		}
	}

	return join( ', ', $selected_params );
}

/**
 * Event ->
 *  [
 *
 *  ]
 */

function bech_get_smaller_date( $param ) {
	if ( $param === 'today' || $param === 'tomorrow' ) {
		$date_time = new DateTime( $param );
		return $date_time->format( 'l' );
	} elseif ( $param === 'next-week' ) {
		$date_time = new DateTime();
		$date_time->setISODate( $date_time->format( 'o' ), absint( $date_time->format( 'W' ) ) + 1 );
		$periods = new DatePeriod( $date_time, new DateInterval( 'P1D' ), 7 );
		$days    = array_map(
			function ( $datetime ) {
				return $datetime->format( 'j M' );
			},
			iterator_to_array( $periods )
		);

		return $days[0] . '-' . $days[ count( $days ) - 1 ];
	} elseif ( $param === 'weekend' ) {
		$date_time = new DateTime( 'next Saturday' );
		$periods   = new DatePeriod( $date_time, new DateInterval( 'P1D' ), 2 );
		$days      = array_map(
			function ( $datetime ) {
				return $datetime->format( 'j M' );
			},
			iterator_to_array( $periods )
		);

		return $days[0] . '-' . $days[ count( $days ) - 1 ];
	}
}

/* What's on filters */

add_action( 'wp_ajax_get_filtered_tickets', 'bech_get_filtered_tickets' );
add_action( 'wp_ajax_nopriv_get_filtered_tickets', 'bech_get_filtered_tickets' );

function bech_get_filtered_tickets() {
	if ( ! isset( $_POST['bech_filter_nonce'] ) || ! wp_verify_nonce( $_POST['bech_filter_nonce'], 'bech_filter_nonce_action' ) ) {
		wp_send_json(
			array(
				'status'  => 'bad',
				'message' => 'Sorry but you are not authorize',
				'data'    => array(
					'status' => 400,
				),
			),
			400
		);
	}

	$html = '<p class="no-event-message">' . esc_html( NO_EVENTS_TEXT ) . '</p>';

	$tickets_query_args = array(
		'post_type'  => 'tickets',
		'orderby'    => 'meta_value',
		'meta_key'   => '_bechtix_ticket_start_date',
		'order'      => 'ASC',
		'meta_query' => array(
			array(
				'key'     => '_bechtix_ticket_start_date',
				'value'   => current_time( 'Y-m-d H:i:s' ),
				'compare' => '>=',
				'type'    => 'DATETIME',
			),
		),
	);

	if ( isset( $_POST['genres'] ) ) {
		$tickets_query_args['tax_query'][] = array(
			'taxonomy' => 'genres',
			'field'    => 'slug',
			'terms'    => $_POST['genres'],
		);
	}

	if ( isset( $_POST['instruments'] ) ) {
		$tickets_query_args['tax_query'][] = array(
			'taxonomy' => 'instruments',
			'field'    => 'slug',
			'terms'    => $_POST['instruments'],
		);
	}

	if ( isset( $_POST['event_tag'] ) ) {
		$tickets_query_args['tax_query'][] = array(
			'taxonomy' => 'event_tag',
			'field'    => 'slug',
			'terms'    => $_POST['event_tag'],
		);
	}

	if ( isset( $_POST['festival'] ) ) {
		$tickets_query_args['meta_query'][] = array(
			'key'     => '_bechtix_festival_relation',
			'value'   => $_POST['festival'],
			'compare' => 'IN',
		);
	}

	if ( ! empty( $_POST['from'] ) ) {
		$from_dt = new DateTime( $_POST['from'] );

		$tickets_query_args['meta_query'][] = array(
			'key'     => '_bechtix_ticket_start_date',
			'value'   => $from_dt->format( 'Y-m-d H:i:s' ),
			'compare' => '>=',
			'type'    => 'DATETIME',
		);

		if ( ! empty( $_POST['to'] ) ) {
			$to_dt                              = new DateTime( $_POST['to'] );
			$tickets_query_args['meta_query'][] = array(
				'key'     => '_bechtix_ticket_start_date',
				'value'   => $to_dt->format( 'Y-m-d H:i:s' ),
				'compare' => '<=',
				'type'    => 'DATETIME',
			);
		}
	} elseif ( ! empty( $_POST['time'] ) ) {
		if ( $_POST['time'] === 'today' ) {
			$datetime  = new DateTime( 'today' );
			$next_date = new DateTime( 'tomorrow' );

			$tickets_query_args['meta_query'][] = array(
				'key'     => '_bechtix_ticket_start_date',
				'value'   => array( $datetime->format( 'Y-m-d H:i:s' ), $next_date->format( 'Y-m-d H:i:s' ) ),
				'compare' => 'BETWEEN',
				'type'    => 'DATETIME',
			);
		} elseif ( $_POST['time'] === 'tomorrow' ) {
			$datetime  = new DateTime( 'tomorrow' );
			$next_date = new DateTime( 'tomorrow' );
			$next_date->modify( '+1 day' );

			$tickets_query_args['meta_query'][] = array(
				'key'     => '_bechtix_ticket_start_date',
				'value'   => array( $datetime->format( 'Y-m-d H:i:s' ), $next_date->format( 'Y-m-d H:i:s' ) ),
				'compare' => 'BETWEEN',
				'type'    => 'DATETIME',
			);
		} elseif ( $_POST['time'] === 'next-week' ) {
			$dt = new DateTime();
			$dt->setISODate( $dt->format( 'o' ), absint( $dt->format( 'W' ) ) + 1 );
			$periods = new DatePeriod( $dt, new DateInterval( 'P1D' ), 7 );
			$days    = array_map(
				function ( $datetime ) {
					return $datetime->format( 'Y-m-d H:i:s' );
				},
				iterator_to_array( $periods )
			);

			$tickets_query_args['meta_query'][] = array(
				'key'     => '_bechtix_ticket_start_date',
				'value'   => array( $days[0], $days[7] ),
				'compare' => 'BETWEEN',
				'type'    => 'DATETIME',
			);
		} elseif ( $_POST['time'] === 'weekend' ) {
			$dt                                 = new DateTime( 'next Saturday' );
			$periods                            = new DatePeriod( $dt, new DateInterval( 'P1D' ), 2 );
			$days                               = array_map(
				function ( $datetime ) {
					return $datetime->format( 'Y-m-d H:i:s' );
				},
				iterator_to_array( $periods )
			);
			$tickets_query_args['meta_query'][] = array(
				'key'     => '_bechtix_ticket_start_date',
				'value'   => $days,
				'compare' => 'BETWEEN',
				'type'    => 'DATETIME',
			);
		}
	}

	if ( ! empty( $_POST['s'] ) ) {
		$tickets_query_args['s'] = $_POST['s'];
	}

	if ( ! empty( $_POST['paged'] ) ) {
		$tickets_query_args['paged'] = intval( $_POST['paged'] );
	}

	$tickets_query = new WP_Query( $tickets_query_args );

	if ( $tickets_query->have_posts() ) {
		ob_start();

		$dates = bech_sort_tickets( $tickets_query->posts );

		foreach ( $dates as $date => $tickets ) {
			?>
			<div class="cms-ul">
				<div class="cms-heading">
					<h2 class="h2-cms"><?php echo date( 'd F Y', $date ); ?></h2>
					<h2 class="h2-cms day"><?php echo date( 'l', $date ); ?></h2>
				</div>
				<div class="cms-ul-events">
					<?php
					foreach ( $tickets as $ticket ) :
						get_template_part(
							'inc/components/whats-on-ticket',
							null,
							array(
								'ticket' => $ticket->ID,
							)
						);
					endforeach;
					?>
				</div>
			</div>
			<?php
		}

		$html = ob_get_clean();
	}

	wp_send_json(
		array(
			'status'  => 'success',
			'message' => 'Data succesfully updated',
			'data'    => array(
				'status'          => 200,
				'html'            => $html,
				'selected_string' => bech_get_selected_filters_string( $_POST ),
				'max_pages'       => $tickets_query->max_num_pages,
				'posts_count'     => $tickets_query->post_count,
			),
		),
		200
	);
}

	/* What's on filters */

function bech_get_youtube_video_id_from_link( $link = '' ) {
	preg_match( '/watch\?v=(.+)/', $link, $matches );

	return $matches[1];
}

function bech_custom_logo( $return = false ) {
	$logo_img = '';
	if ( $custom_logo_id = get_theme_mod( 'custom_logo' ) ) {
		$logo_img = wp_get_attachment_image(
			$custom_logo_id,
			'full',
			false,
			array(
				'class'    => 'logo custom-logo',
				'itemprop' => 'logo',
			)
		);
	}

	if ( $return ) {
		return $logo_img;
	} else {
		echo $logo_img;
	}
}

	add_action( 'wp_ajax_get_press_release_posts', 'bech_get_press_release_posts' );
	add_action( 'wp_ajax_nopriv_get_press_release_posts', 'bech_get_press_release_posts' );

function bech_get_press_release_posts(): void {
	$args = array(
		'post_type'      => 'press-office',
		'posts_per_page' => 10,
		'post_status'    => 'publish',
	);

	if ( ! empty( $_POST['tag'] ) ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'press_tag',
			'field'    => 'slug',
			'terms'    => trim( $_POST['tag'] ),
		);
	}

	if ( ! empty( $_POST['page'] ) ) {
		$args['paged'] = intval( $_POST['page'] );
	}

	$press_query = new WP_Query( $args );

	ob_start();
	?>
	<div class="cms-press-ajax">
	<?php
	if ( $press_query->have_posts() ) {
		while ( $press_query->have_posts() ) {
			$press_query->the_post();
			?>
				<a href="<?php echo get_the_permalink(); ?>" class="ui-pressrelease-a w-inline-block">
					<div class="p-20-30 w20"><?php echo get_the_date( 'j F Y' ); ?></div>
					<div class="p-25-40 mar13"><?php echo get_the_title(); ?></div>
				</a>
				<?php
		}
		wp_reset_postdata();

		if ( $press_query->max_num_pages > 1 && intval( $_POST['page'] ) < $press_query->max_num_pages ) {
			?>
				<a href="#" class="showmore-btn w-inline-block">
					<div>SHOW MORE</div>
				</a>
			<?php
		}
	} else {
		?>
			<p>NO POSTS</p>
		<?php } ?>
	</div>
		<?php
		$html     = ob_get_clean();
		$response = array(
			'status' => 'success',
			'html'   => $html,
		);
		wp_send_json( $response, 200 );
		wp_die();
}

	add_action( 'wp_ajax_get_homepage_slider_items', 'bech_get_homepage_slider_items' );
	add_action( 'wp_ajax_nopriv_get_homepage_slider_items', 'bech_get_homepage_slider_items' );

function bech_get_homepage_slider_items() {
	if ( ! wp_verify_nonce( $_POST['home_filter_action'], 'home_filter_action_nonce' ) ) {
		return wp_send_json(
			array(
				'status'  => 'bad',
				'message' => 'Something went wrong. Please try again later',
			),
			400
		);
	}

	$args = array(
		'post_type'      => 'event',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
	);

	if ( ! empty( $_POST['instruments'] ) ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'instruments',
			'field'    => 'slug',
			'terms'    => $_POST['instruments'],
		);
	}

	if ( ! empty( $_POST['genres'] ) ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'genres',
			'field'    => 'slug',
			'terms'    => $_POST['genres'],
		);
	}

	if ( ! empty( $_POST['event_tag'] ) ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'event_tag',
			'field'    => 'slug',
			'terms'    => $_POST['event_tag'],
		);
	}

	if ( ! empty( $_POST['start_date'] ) ) {
		$args['meta_query'][] = array(
			'key'     => 'start_date',
			'value'   => $_POST['start_date'],
			'compare' => '>=',
			'type'    => 'DATETIME',
		);
	}

	$tickets_query = new WP_Query( $args );
	ob_start();
	if ( $tickets_query->have_posts() ) {
		while ( $tickets_query->have_posts() ) {
			$tickets_query->the_post();
			?>
			<div class="slider-wvwnts_slide wo-slider_item wo-slide">
				<div class="link-block">
					<div class="slider-wvwnts_top">
					<?php
					global $post;
					$event_cat = get_the_terms( $post, 'event_cat' );
					?>
						<img src="<?php echo get_field( 'event_image', $event_cat[0] ); ?>" loading="eager" alt class="img-cover">
						<?php
						$term_query = wp_get_object_terms(
							$post->ID,
							array(
								'event_tag',
								'genres',
								'instruments',
							)
						);
						?>
						<div class="slider-wvwnts_top-cats">
						<?php foreach ( $term_query as $term ) : ?>
								<a href="#" class="slider-wvwnts_top-cats_a"><?php echo $term->name; ?></a>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="slider-wvwnts_bottom">
						<div class="p-20-30 w20"><?php echo date( 'd F', strtotime( get_field( 'start_date' ) ) ); ?></div>
						<div class="p-30-45 bold"><?php the_title(); ?></div>
						<div class="p-17-25 home-card">Couperin, Mesian, Brahms</div>
						<?php $purchase_urls = get_field( 'purchase_urls' ); ?>
						<a bgline="1" href="<?php echo $purchase_urls[0]['link']; ?>" class="booktickets-btn home-page">
							<strong>Book tickets</strong>
						</a>
					</div>
				</div>
			</div>
				<?php
		}
	} else {
		?>
		<p>There is no tickets with this filter parameters</p>
		<?php
	}
	$html = ob_get_clean();

	wp_send_json(
		array(
			'status' => 'success',
			'html'   => $html,
		)
	);
	wp_die();
}

function bech_get_format_date_for_whats_on_slide( $post_id ) {
	$start_date = strtotime( bech_get_ticket_date_field( '_bechtix_ticket_start_date', $post_id ) );
	$end_date   = strtotime( bech_get_ticket_date_field( '_bechtix_ticket_end_date', $post_id ) );
	$long_date  = gmdate( 'j F', $start_date );
	$time       = ', ' . gmdate( 'H:i', $start_date ) . '—' . gmdate( 'H:i', $end_date );

	return $long_date . $time;
}

function bech_get_ticket_event_data_for_calendar( $ticket ) {
	$start_date_unix = strtotime( bech_get_ticket_date_field( '_bechtix_ticket_start_date', $ticket->ID ) );
	$end_date_unix   = strtotime( bech_get_ticket_date_field( '_bechtix_ticket_end_date', $ticket->ID ) );
	return esc_attr(
		wp_json_encode(
			array(
				'name'         => $ticket->post_title,
				'description'  => $ticket->post_content,
				'startDate'    => gmdate( 'Y-m-d', $start_date_unix ),
				'endDate'      => gmdate( 'Y-m-d', $end_date_unix ),
				'startTime'    => gmdate( 'H:i', $start_date_unix ),
				'endTime'      => gmdate( 'H:i', $end_date_unix ),
				'timeZone'     => 'Europe/London',
				'location'     => 'Bechstein Hall',
				'iCalFileName' => $ticket->post_title,
			)
		)
	);
}

function bech_get_purchase_urls( $ticket_id ) {
	return json_decode( get_post_meta( $ticket_id, '_bechtix_purchase_urls', true ), true );
}

function bech_get_purchase_urls_attribute( $ticket_id ) {
	return esc_attr( get_post_meta( $ticket_id, '_bechtix_purchase_urls', true ) );
}

function bech_get_sale_status_string_value( $sale_status ) {
	$sale_statuses = array(
		'No Status',
		'Few tickets left',
		'Sold out',
		'Cancelled',
		'Not scheduled',
	);

	return $sale_statuses[ intval( $sale_status ) ];
}

function bech_is_event_sold_out( $event_id ) {
	$all_tickets = get_posts(
		array(
			'post_type'   => 'tickets',
			'post_status' => 'publish',
			'numberposts' => -1,
			'fields'      => 'ids',
			'meta_query'  => array(
				array(
					'key'     => '_bechtix_event_relation',
					'value'   => $event_id,
					'compare' => '=',
				),
			),
		)
	);

	$all_tickets_statuses = array_unique(
		array_map(
			function ( $ticket_id ) {
				return bech_get_sale_status_string_value( get_post_meta( $ticket_id, '_bechtix_sale_status', true ) );
			},
			$all_tickets
		),
		SORT_STRING
	);

	return $all_tickets_statuses[0] === 'Sold out';
}

function bech_get_event_duration( $event_id ) {
	$event_duration = get_post_meta( $event_id, '_bechtix_event_duration_info', true );

	if ( $event_duration !== '' ) {
		return $event_duration;
	}

	$tickets = get_posts(
		array(
			'post_type'   => 'tickets',
			'post_status' => 'publish',
			'numberposts' => 1,
			'fields'      => 'ids',
			'meta_query'  => array(
				array(
					'key'     => '_bechtix_event_relation',
					'value'   => $event_id,
					'compare' => '=',
				),
			),
		)
	);

	return get_post_meta( $tickets[0], '_bechtix_duration', true );
}

function bech_get_the_content_without_formatting( $post_id ) {
	return strip_tags( get_the_content( null, false, $post_id ), array( 'br', 'a', 'b', 'strong', 'i' ) );
}

	add_action( 'wp_ajax_get_more_filter_buttons', 'bech_get_more_filter_buttons' );
	add_action( 'wp_ajax_nopriv_get_more_filter_buttons', 'bech_get_more_filter_buttons' );
function bech_get_more_filter_buttons() {
	if ( isset( $_POST['taxonomy'] ) && $_POST['taxonomy'] !== '' ) {
		$taxonomy_terms_count = wp_count_terms( $_POST['taxonomy'] );
		$offset               = 5;
		$number               = $taxonomy_terms_count - $offset;
		$other_filters        = array_filter(
			get_terms(
				array(
					'taxonomy' => $_POST['taxonomy'],
					'number'   => $number,
					'offset'   => $offset,
				)
			),
			function ( $term ) {
				$events = get_posts(
					array(
						'post_type'   => 'events',
						'post_status' => 'publish',
						'tax_query'   => array(
							array(
								'taxonomy' => $_POST['taxonomy'],
								'field'    => 'slug',
								'terms'    => $term->slug,
							),
						),
					)
				);

				return ! empty( $events );
			}
		);

		ob_start();

		foreach ( $other_filters as $index => $other_filter ) :
			?>
			<label class="w-checkbox cbx-mom">
				<div class="w-checkbox-input w-checkbox-input--inputType-custom cbx"></div>
				<input data-filter="checkbox" type="checkbox" id="<?php echo $other_filter->taxonomy . '-' . $other_filter->term_id; ?>" name="<?php echo $other_filter->taxonomy; ?>[]" value="<?php echo $other_filter->slug; ?>" style="opacity:0;position:absolute;z-index:-1" />
				<span class="filter-cbx ischbx w-form-label" for="<?php echo $other_filter->taxonomy . '-' . $other_filter->term_id; ?>"><?php echo $other_filter->name; ?></span>
			</label>
				<?php
	endforeach;

		$html = ob_get_clean();

		$response = array(
			'status' => 'success',
			'data'   => array(
				'html' => $html,
			),
		);

		wp_send_json( $response, 200 );
		wp_die();
	} else {
		$response = array(
			'status'  => 'bad',
			'message' => 'Wrong taxonomy parameter',
		);

		wp_send_json( $response, 400 );
		wp_die();
	}
}

	add_action( 'admin_menu', 'bech_register_custom_admin_links' );
function bech_register_custom_admin_links() {
	add_menu_page( null, 'Global Widgets', 'edit_posts', '/widgets.php', null, 'dashicons-welcome-widgets-menus', 25 );
	add_menu_page( null, 'Header & Footer', 'edit_posts', '/themes.php?page=options#footer-&-header-fields', null, 'dashicons-align-center', 26 );
	add_menu_page( null, 'Footer Contacts', 'edit_posts', '/themes.php?page=options#footer-contacts', null, 'dashicons-megaphone', 27 );
	add_menu_page( null, 'Video Intro', 'edit_posts', '/themes.php?page=options#video-intro', null, 'dashicons-format-video', 28 );
	add_menu_page( null, 'Tickets Information', 'edit_posts', '/themes.php?page=options#tickets-information', null, 'dashicons-info', 29 );
}

	// add_filter('wp_insert_post_data', function ($data, $postarr) {
	// $data['post_content'] = wpautop($data['post_content']);
	// return $data;
	// }, 10, 2);

	/**
	 * [
	 *  [
	 *      'date' => DateTime,
	 *      'customer_id' => int|''
	 *  ]
	 * ]
	 */

function bech_get_min_date_index( array $dates ): int {
	$index    = 0;
	$min_date = strtotime( $dates[0]['date'] );

	for ( $i = 1; $i < count( $dates ); $i++ ) {
		if ( strtotime( $dates[ $i ]['date'] ) < $min_date ) {
			$index = $i;
		}
	}

	return $index;
}

function bech_is_priority_booking_time( int $post_id ): bool {
	$online_sale_start_dates = get_field( 'online_dates', $post_id ) ? get_field( 'online_dates', $post_id ) : array( array( 'date' => get_post_meta( $post_id, '_bechtix_ticket_online_sale_start', true ) ) );

	$min_date_index = bech_get_min_date_index( $online_sale_start_dates );

	if ( empty( $online_sale_start_dates[ $min_date_index ]['customer_id'] ) ) {
		return false;
	}

	$time_now             = time();
	$benefit_sale_time    = strtotime( $online_sale_start_dates[ $min_date_index ]['date'] );
	$free_sales_date_time = strtotime( get_post_meta( $post_id, '_bechtix_ticket_online_sale_start', true ) );

	if ( $time_now >= $benefit_sale_time && $time_now < $free_sales_date_time ) {
		return true;
	}

	return false;
}

function bech_get_page_by_slug( string $slug ) {
	$page = get_page_by_path( $slug );

	if ( $page && ! is_array( $page ) ) {
		return $page;
	} elseif ( is_array( $page ) ) {
		return $page[0];
	} else {
		return null;
	}
}

	add_filter( 'pto/posts_orderby/ignore', 'bech_ignore_tix_queryes_orderby', 10, 3 );
function bech_ignore_tix_queryes_orderby( $ignore, $orderBy, $query ) {
	$query_vars = $query->query_vars;
	if ( $query_vars['post_type'] === 'tickets' || $query_vars['post_type'] === 'events' || $query_vars['post_type'] === 'festivals' ) {
		$ignore = true;
	}

	return $ignore;
}

function bech_recursive_chunk_array( $fromArr = array(), $newArr = array(), $chank = array() ) {
	if ( count( $fromArr ) === 0 ) {
		return $newArr;
		var_dump( 'FINISH' );
	}

	$value   = array_shift( $fromArr );
	$chank[] = $value;

	if ( gmdate( 'D', strtotime( $value ) ) === 'Mon' ) {
		$newArr[] = $chank;
		return bech_recursive_chunk_array( $fromArr, $newArr, array() );
	} else {
		return bech_recursive_chunk_array( $fromArr, $newArr, $chank );
	}
}

function bech_get_three_month_weekends(): array {
	$now   = new DateTime();
	$month = new DatePeriod( new DateTime( $now->format( 'Y-m-d' ) ), DateInterval::createFromDateString( '+1 day' ), new DateTime( '+3 month' ) );

	$month_as_array = array_map(
		function ( $date_time ) {
			return $date_time->format( 'Y-m-d H:i:s' );
		},
		array_filter(
			iterator_to_array( $month, false ),
			function ( $date_time ) {
				if ( $date_time->format( 'D' ) === 'Fri' || $date_time->format( 'D' ) === 'Sat' || $date_time->format( 'D' ) === 'Sun' ) {
					if ( $date_time->format( 'D' ) === 'Sun' ) {
						return $date_time->modify( '+1 day' );
					}
					return $date_time;
				}
			}
		)
	);

	$dates_array = bech_recursive_chunk_array( $month_as_array, array(), array() );

	$todayWeekDay = $now->format( 'D' );
	if ( $todayWeekDay === 'Fri' || $todayWeekDay === 'Sat' || $todayWeekDay === 'Sun' ) {
		$dates_array[0][0] = $now->format( 'Y-m-d H:i:s' );
	}

	return array_map(
		function ( $arr ) {
			return array( $arr[0], $arr[ count( $arr ) - 1 ] );
		},
		$dates_array
	);
}

function bech_get_whats_on_ticket_image( $post_id ): string {
	$image_id = get_field( 'whats_on_image', $post_id );
	return ! empty( $image_id ) ? wp_get_attachment_image(
		$image_id,
		'medium',
		false,
		array(
			'class' => 'cms-li_img',
			'style' => 'max-height: 270rem',
		)
	) : '';
}

	add_filter( 'wpseo_metadesc', 'bech_set_default_custom_meta_description' );
	add_filter( 'wpseo_opengraph_desc', 'bech_set_default_custom_meta_description' );
function bech_set_default_custom_meta_description( $description ) {
	if ( ! $description || empty( $description ) ) {
		return 'Bechstein Hall official website';
	}
	return $description;
}

	add_filter( 'wpseo_schema_webpage', 'bech_set_default_description_field_to_webpage_piece' );
function bech_set_default_description_field_to_webpage_piece( $data ) {
	if ( empty( $data['description'] ) ) {
		$data['description'] = 'Bechstein Hall official website';
	}
	return $data;
}

	add_action( 'wpseo_add_opengraph_additional_images', 'bech_default_og_image' );
function bech_default_og_image( $image ) {
	global $post;

	if ( ! $image->has_images() ) {
		$image->add_image( 'default' ); // this can be whatever you want it to be as long as it isn't falsey
	}
}

// set the default share image
add_action( 'wpseo_twitter_image', 'bech_default_share_image' );
add_action( 'wpseo_opengraph_image', 'bech_default_share_image' );
function bech_default_share_image( $image ) {
	global $post;

	if ( ! $image || 'default' === $image ) {
		if ( is_singular( 'events' ) && ! empty( get_field( 'main_image', $post ) ) ) {
			$image = wp_get_attachment_image_url( get_field( 'main_image', $post ), 'medium' );
		} else {
			$image = esc_url( get_template_directory_uri() . '/images/ogmeta.png' );
		}
	}

	return $image;
}
	// now we can call the same function for both actions without having to set a default facebook image in the UI

	// fix big image upload
	add_filter( 'big_image_size_threshold', '__return_false' );

	/**
	 * Convert phone number string to phone link
	 *
	 * @param string $phone_number Phone number string.
	 * @return string Phone number link
	 */
function bech_format_phone_to_link( string $phone_number ): string {
	if ( empty( $phone_number ) ) {
		return '';
	}

	return 'tel:' . preg_replace( '/[^0-9+]/', '', $phone_number );
}

	/**
	 * Convert email string to email link
	 *
	 * @param string $email Email string.
	 * @param string $subject Email Subject.
	 * @return string Email link
	 */
function bech_format_email_link( string $email, string $subject = '' ): string {
	$email_link = "mailto:{$email}";

	if ( ! empty( $subject ) ) {
		$email_link .= "?subject={$subject}";
	}

	return esc_url( $email_link );
}

add_action( 'wp_ajax_subscribe_to_newsletter', 'bech_subscribe_to_newsletter' );
add_action( 'wp_ajax_nopriv_subscribe_to_newsletter', 'bech_subscribe_to_newsletter' );
function bech_subscribe_to_newsletter() {
	if ( ! isset( $_POST['subscribe_to_newsletter_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['subscribe_to_newsletter_nonce'] ) ), 'subscribe_to_newsletter' ) ) {
		wp_send_json_error(
			array(
				'detail' => 'Bad request',
			),
			400
		);
	}

	$errors = array();

	if ( empty( $_POST['agreement'] ) ) {
		$errors['agreement'] = 'Agreement is required';
	}

	if ( empty( $_POST['email'] ) ) {
		$errors['email'] = 'Email is required';
	}

	$email = sanitize_email( wp_unslash( $_POST['email'] ) );

	if ( ! is_email( $email ) ) {
		$errors['email'] = 'Email is invalid';
	}

	if ( ! empty( $errors ) ) {
		wp_send_json_error(
			array(
				'errors' => $errors,
			)
		);
	}

	$api_key = get_field( 'mailchimp_api_key', 'option' );

	if ( empty( $api_key ) ) {
		wp_send_json_error(
			array(
				'detail' => 'Unable to process your request. Please try again later.',
				'debug'  => 'API key is required',
			),
			400
		);
	}

	$list_id     = '8282349c41';
	$data_center = substr( $api_key, strpos( $api_key, '-' ) + 1 );
	$url         = 'https://' . $data_center . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members?skip_merge_validation=true';
	$data        = array(
		'email_address' => $email,
		'status'        => 'subscribed',
	);

	$response = wp_remote_post(
		$url,
		array(
			'headers' => array(
				'Authorization' => 'Basic ' . base64_encode( 'anystring:' . $api_key ),
				'Content-Type'  => 'application/json',
			),
			'body'    => wp_json_encode( $data ),
		)
	);

	if ( is_wp_error( $response ) ) {
		wp_send_json_error( array( 'detail' => 'Something went wrong. Please, try agail later!' ), 400 );
	}

	$body        = json_decode( wp_remote_retrieve_body( $response ), true );
	$status_code = wp_remote_retrieve_response_code( $response );

	// curl -X POST \
	// 'https://${dc}.api.mailchimp.com/3.0/lists/{list_id}/members?skip_merge_validation=true' \
	// --user "anystring:${apikey}"' \
	// -d '{"email_address":"","email_type":"","status":"subscribed","merge_fields":{},"interests":{},"language":"","vip":false,"location":{"latitude":0,"longitude":0},"marketing_permissions":[],"ip_signup":"","timestamp_signup":"","ip_opt":"","timestamp_opt":"","tags":[]}'

	switch ( $status_code ) {
		case 200:
			if ( isset( $body['status'] ) && 'subscribed' === $body['status'] ) {
					wp_send_json_success(
						array(
							'detail' => 'Thanks for joining us!<br> Look out for exciting updates in your inbox soon.',
							'data'   => $body,
						),
						201
					);
			}
			break;

		case 400:
			if ( isset( $body['title'] ) && 'Member Exists' === $body['title'] ) {
					wp_send_json_error(
						array(
							'detail' => 'This email is already subscribed to our newsletter.',
						),
						400
					);
			}
			break;

		case 401:
				wp_send_json_error(
					array(
						'detail' => 'Authentication failed. Please try again later.',
					),
					401
				);
			break;

		default:
				wp_send_json_error(
					array(
						'detail' => 'An unexpected error occurred. Please try again later.',
						'debug'  => $body,
					),
					$status_code
				);
	}

	// // Fallback error response
	wp_send_json_error(
		array(
			'detail' => 'Unable to process your request. Please try again later.',
		),
		400
	);
}

function bech_dump( $data ) {
	echo '<pre>';
	var_dump( $data );
	echo '</pre>';
}

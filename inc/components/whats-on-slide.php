<?php
/**
 * Whats on slider card component
 *
 * @package 0.0.1
 */

defined( 'ABSPATH' ) || exit;

global $post;
$purchase_urls            = get_post_meta( $post->ID, '_bechtix_purchase_urls', true );
$purchase_urls_normal     = json_decode( $purchase_urls, true );
$sale_status              = get_post_meta( $post->ID, '_bechtix_sale_status', true );
$is_priority_booking_time = bech_is_priority_booking_time( $post->ID );

$can_buy_ticket     = '' === $sale_status || '0' === $sale_status || '1' === $sale_status || '4' === $sale_status;
$is_in_waiting_list = (bool) get_post_meta( $post->ID, '_bechtix_in_waiting_list', true );

?>
<div class="slider-wvwnts_slide wo-slider_item wo-slide">
	<div class="link-block">
		<div class="slider-wvwnts_top">
			<?php
			$event_id        = get_post_meta( $post->ID, '_bechtix_event_relation', true );
				$event_url   = get_the_permalink( $event_id );
				$event_image = wp_get_attachment_image(
					get_field( 'slider_image', $event_id ),
					'large',
					false,
					array(
						'class'     => 'img-cover',
						'draggable' => 'false',
					)
				);

				if ( ! empty( $event_image ) ) :
					?>
					<?php echo $event_image; ?>
			<?php endif; ?>
			<?php
			$term_query = wp_get_object_terms(
				$event_id,
				array(
					'event_tag',
					'genres',
					'instruments',
				)
			);
			?>
			<div class="slider-wvwnts_top-cats">
				<?php foreach ( $term_query as $term ) : ?>
				<a class="slider-wvwnts_top-cats_a"><?php echo $term->name; ?></a>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="slider-wvwnts_bottom">
			<div class="p-20-30 w20"><?php echo bech_get_format_date_for_whats_on_slide( $post->ID ); ?></div>
			<a draggable="false" href="<?php echo $event_url; ?>" class="p-30-45 bold"><?php the_title(); ?></a>
			<div class="p-17-25 home-card"><?php the_content(); ?></div>
			<!-- <a draggable="false" bgline="1" href="<?php /* echo $purchase_urls[0]['link']; */?>" class="booktickets-btn home-page">
				<strong>Book tickets</strong>
			</a> -->
			<?php
			if ( $can_buy_ticket ) :
				if ( $is_priority_booking_time ) :
					?>
					<a draggable="false" bgline="1" class="booktickets-btn home-page priority">
						<strong>priority booking only</strong>
					</a>
			<?php endif; ?>
				<a draggable="false" bgline="1" href="<?php echo esc_url( $purchase_urls_normal[0]['link'] ); ?>" class="booktickets-btn home-page <?php echo $is_priority_booking_time ? 'none' : ''; ?>">
					<strong>Book tickets</strong>
				</a>
				<?php
			else :
				if ( $is_in_waiting_list ) :
					?>
					<a draggable="false" bgline="1" href="<?php echo esc_url( $purchase_urls_normal[0]['link'] ); ?>" class="booktickets-btn home-page">
						<strong>Join Waiting List</strong>
					</a>
				<?php else : ?>
					<a draggable="false" bgline="2" href="#" class="booktickets-btn home-page sold-out">
						<strong><?php echo esc_html( bech_get_sale_status_string_value( $sale_status ) ); ?></strong>
					</a>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
</div>

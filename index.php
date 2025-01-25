<?php
/**
 * Template name: Bechstein Hall Home Page
 *
 * @package 0.1.0
 */

?>
<!DOCTYPE html>
<!-- This site was created in Webflow. https://www.webflow.com -->
<!-- Last Published: Wed Jul 13 2022 13:06:33 GMT+0000 (Coordinated Universal Time) -->
<html <?php language_attributes(); ?> data-wf-page="624c5364ec30465eea0a1090" data-wf-site="624c5364ec3046603b0a108f">
<?php get_template_part( 'header_block', '' ); ?>

<body <?php body_class( 'body' ); ?>>
	<?php wp_body_open(); ?>
	<?php get_template_part( 'inc/components/loader' ); ?>
	<div class="page-wrapper">
		<?php get_header(); ?>
		<main class="wrapper home-wrapper">
			<!-- Key events slider start -->
			<?php
			$slider = get_field( 'home_slider' );
			if ( ! empty( $slider ) ) :
				?>
				<section class="section home-grey wf-section" data-type="cursor-area">
					<div class="head-event-container">
						<div class="bech-slider" data-type="slider">
							<div class="bech-slider__slides">
								<?php foreach ( $slider as $slide ) : ?>
									<div class="bech-slider__slide" data-type="slide">
										<div class="head-event-content">
											<?php
											$slide_image = wp_get_attachment_image(
												$slide['background_image']['ID'],
												'large',
												false,
												array(
													'class' => 'img-fw mob-cover head-event-image',
												)
											);

											$slider_image_mob = wp_get_attachment_image(
												$slide['background_image_mob']['ID'],
												'large',
												false,
												array(
													'class' => 'head-event-image_mob',
												)
											);

                                            // @codingStandardsIgnoreStart
											if ( ! empty( $slide_image ) ) :
												echo $slide_image;
											endif;

											if ( ! empty( $slider_image_mob ) ) :
												echo $slider_image_mob;
											endif;
                                            // @codingStandardsIgnoreEnd

											$slide_link        = ! empty( $slide['link'] ) ? $slide['link'] : '#';
											$slide_date_sign   = $slide['date_sign'];
											$slide_heading     = $slide['slide_heading'];
											$slide_description = $slide['slide_description'];
											?>
											<a href="<?php echo esc_url( $slide_link ); ?>" class="head-event-content_in home-slid w-inline-block">
												<div class="left-event-col home-slid">
													<?php if ( ! empty( $slide_date_sign ) ) : ?>
														<div class="home-slid-timer"><?php echo esc_html( $slide['date_sign'] ); ?></div>
													<?php endif; ?>
													<?php if ( ! empty( $slide_heading ) ) : ?>
														<h1 class="h1-75-90 event-h"><?php echo esc_html( $slide_heading ); ?></h1>
													<?php endif; ?>
													<?php if ( ! empty( $slide_description ) ) : ?>
														<div class="p-25-40"><?php echo esc_html( $slide_description ); ?></div>
													<?php endif; ?>
												</div>
											</a>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
							<div class="bech-slider__controls">
								<div class="bech-slider__counter">
									<div data-type="current">0</div>
									<div class="bech-slider__separator">–</div>
									<div data-type="count">0</div>
								</div>
								<button type="button" class="bech-slider__arrow arrow-button" data-type="prev">
									←
								</button>
								<button type="button" class="bech-slider__arrow arrow-button" data-type="next">
									<svg width="50" height="50" viewBox="0 0 100 100" style="width: 100%; height: 100%;">
										<circle r="50" cx="50" cy="50" fill="transparent"></circle>
										<circle class="arrow-button__progress" r="50" cx="50" cy="50" fill="transparent"></circle>
									</svg>
									→
								</button>
							</div>
							<div data-type="cursor" bgline="3" class="book-pseudo-b">
								<div><strong>Book tickets</strong></div>
							</div>
						</div>
					</div>
					<div class="grey-z top-z"></div>
				</section>
			<?php endif; ?>
			<!-- Key events slider end -->
			<!-- Calendar and weekend events block start -->
			<?php
			$calendar_events_block = get_field( 'calendar_and_weekend_events_block' );
			$calendar_heading      = $calendar_events_block['heading'];
			?>
			<?php $whats_on_page_id = 255; ?>
			<section class="section home-grey wf-section">
				<div class="container-home-slider">
					<?php if ( ! empty( $calendar_heading ) ) : ?>
						<h2 class="h2-50-65 white"><?php echo esc_html( $calendar_heading ); ?></h2>
					<?php endif; ?>
					<div class="calendar-container">
						<div class="calendar-wiget">
							<form method="get" action="<?php echo esc_url( get_the_permalink( $whats_on_page_id ) ); ?>" id="home-filter-form" class="form">
								<div class="p-20-30 white">What do you like?</div>
								<?php
								$tags_args                    = array(
									'taxonomy' => array( 'genres', 'instruments', 'event_tag' ),
									'orderby'  => 'count',
									'order'    => 'DESC',
									'number'   => 10,
								);
														$tags = get_terms( $tags_args );
								if ( ! empty( $tags ) ) :
									?>
									<div class="filter-flex">
									<?php foreach ( $tags as $filter_tag ) : ?>
											<label class="w-checkbox filter-flex-btn">
												<div class="w-checkbox-input w-checkbox-input--inputType-custom filter-flex-bg"></div>
												<input type="checkbox" id="tag_<?php echo esc_attr( $filter_tag->term_id ); ?>" name="<?php echo esc_attr( $filter_tag->taxonomy ); ?>[]" value="<?php echo esc_attr( $filter_tag->slug ); ?>" style="opacity:0;position:absolute;z-index:-1">
												<span class="w-form-label" for="tag_<?php echo esc_attr( $filter_tag->term_id ); ?>"><?php echo esc_html( $filter_tag->name ); ?></span>
											</label>
										<?php endforeach; ?>
									</div>
								<?php endif; ?>
								<div class="calendar-devider"></div>
								<input class="visually-hidden" name="from" value="" />
								<input class="visually-hidden" name="to" value="" />
								<div class="p-20-30 white">When would you like to visit?</div>
								<div id="calendar" class="cal-slider"></div>
								<input type="submit" value="Find Events" class="w-button">
							</form>
						</div>
						<?php

						$weekends = bech_get_three_month_weekends();

						$args = array(
							'post_type'      => 'tickets',
							'posts_per_page' => -1,
							'post_status'    => 'publish',
							'meta_key'       => '_bechtix_ticket_start_date',
							'orderby'        => 'meta_value',
							'order'          => 'ASC',
							'meta_query'     => array(
								'relation' => 'OR',
							),
						);

						foreach ( $weekends as $key => $weekend ) {
							$args['meta_query'][] = array(
								'key'     => '_bechtix_ticket_start_date',
								'value'   => $weekend,
								'compare' => 'BETWEEN',
								'type'    => 'DATETIME',
							);
						}

						$query = new WP_Query( $args );

						?>
						<div class="slider-wvwnts-home">
							<div class="slider-wvwnts">
								<div class="slider-wvwnts_mask wo-slider">
									<?php
									while ( $query->have_posts() ) :
										$query->the_post();
										?>
										<?php get_template_part( 'inc/components/whats-on-slide' ); ?>
										<?php
									endwhile;
									wp_reset_postdata();
									?>
								</div>
							</div>
							<div id="whats-on-cursor" class="splide__cursor"></div>
						</div>
						<div id="w-node-_0c687936-78a2-7976-2297-97e720f86e4e-89261594" class="slider-wvwnts-home_bottom">
							<div class="p-20-30 white"><?php echo esc_html( bech_get_events_number( $query->posts, 'event' ) ); ?></div>
							<a href="<?php echo esc_url( get_the_permalink( $whats_on_page_id ) ); ?>" class="link-20 home">WHAT’S ON</a>
						</div>
					</div>
				</div>
				<div class="grey-z"></div>
			</section>
			<!-- Calendar and weekend events block end -->
			<!-- “About Bechstein Hall” block start -->
			<?php
			$about_bechstein_hall_block = get_field( 'about_bechstein_hall_block' );
			$heading_1st_line           = $about_bechstein_hall_block['heading_1st_line'];
			$heading_2nd_line           = $about_bechstein_hall_block['heading_2nd_line'];
			$description                = $about_bechstein_hall_block['description'];
			$about_block_link           = $about_bechstein_hall_block['link'];
			?>
			<section class="section reder homer home-white wf-section">
				<?php if ( ! empty( $heading_1st_line ) ) : ?>
					<h2 data-w-id="0ced73ca-e65f-2bb3-0ae8-df703d949277" class="h2-75-90">
						<?php echo esc_html( $heading_1st_line ); ?>
					</h2>
				<?php endif; ?>
				<div class="his-container homet">
					<div class="his-left home-page">
						<div class="his-left-imagemom home">
							<?php
							echo wp_get_attachment_image(
								$about_bechstein_hall_block['sticky_image']['ID'],
								'large',
								false,
								array(
									'class' => 'img-cover',
								)
							);
							?>
						</div>
					</div>
					<div class="his-right homepage">
						<?php
						if ( ! empty( $heading_2nd_line ) ) :
							?>
							<h2 data-w-id="0ced73ca-e65f-2bb3-0ae8-df703d94927e" class="h2-75-90 _2 no-tab">
								<?php echo esc_html( $heading_2nd_line ); ?>
							</h2>
						<?php endif; ?>
						<?php if ( ! empty( $description ) ) : ?>
							<div data-w-id="3956ba2f-4390-87fa-389c-350f9d52c59c" class="p-20-35 w910 w-richtext">
								<?php echo esc_html( $description ); ?>
							</div>
						<?php endif; ?>
						<?php
						if ( ! empty( $about_block_link['link_url'] ) ) :
							?>
							<a href="<?php echo esc_url( $about_block_link['link_url'] ); ?>" class="link-20"><?php echo $about_block_link['link_title'] ? esc_html( $about_block_link['link_title'] ) : esc_html( $about_block_link['link_url'] ); ?></a>
						<?php endif; ?>
					</div>
				</div>
				<div class="white-z"></div>
			</section>
			<section class="section section-subscribe" style="display: none;">
				<div class="section-subscribe__inner">
					<div class="section-subscribe__content">
						<h2 class="section-subscribe__heading">Stay In Tune</h2>
						<p class="section-subscribe__description">Be the first to know about our upcoming concerts, exclusive events, and special offers. Let the music come to you!</p>
					</div>
					<form data-js-validate-form data-js-subscribe-form class="section-subscribe__form subscribe-form" novalidate>
						<div class="subscribe-form__wrapper" data-js-subscribe-form-wrapper>
							<h3 class="subscribe-form__heading">Subscribe to our newsletter</h3>
							<div class="subscribe-form__body">
								<div class="bech-field">
									<input 
										type="email" 
										name="email" 
										class="bech-field__control"
										placeholder="Your email"
										pattern="[^@\s]+@[^@\s]+\.[^@\s]+"
										title="Please enter a valid email address."
										required
									>
									<span class="bech-field__errors" data-js-validate-form-field-errors></span>
								</div>
								<button class="subscribe-form__button">→</button>
							</div>
							<label class="bech-field bech-checkbox">
								<input 
									type="checkbox" 
									name="agreement" 
									value="agree" 
									class="bech-checkbox__control" 
									required
								>
								<span class="bech-checkbox__label">
								I agree to the website’s <a href="<?php echo esc_url( get_privacy_policy_url() ); ?>">Privacy Policy</a>
								</span>
							</label>
						</div>
						<div class="subscribe-form__success" data-js-subscribe-form-global-message></div>
						<input type="hidden" name="action" value="subscribe_to_newsletter">
						<?php wp_nonce_field( 'subscribe_to_newsletter', 'subscribe_to_newsletter_nonce' ); ?>
					</form>
					<div class="section-subscribe__decoration" style="background-image: url('<?php echo wp_get_attachment_image_url( 62, 'full' ); ?>"></div>
				</div>
			</section>
			<?php
			$infinite_carousel = $about_bechstein_hall_block['infinite_carousel'];

			if ( ! empty( $infinite_carousel ) ) :
				$infinite_carousel = array_filter(
					$infinite_carousel,
					function ( $slide ) {
						return ! empty( $slide['image'] );
					}
				);
				?>
				<section class="section home-white wf-section">
					<div class="splide">
						<div class="splide__track">
							<div class="splide__list">
								<?php foreach ( $infinite_carousel as $image ) : ?>
									<div class="splide__slide">
										<?php
										echo wp_get_attachment_image(
											$image['image']['ID'],
											'large',
											false,
											array(
												'class'   => 'image-4',
												'loading' => 'eager',
											)
										);
										?>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
					<div id="splide-cursor" class="splide__cursor"></div>
					<div class="white-z"></div>
				</section>
			<?php endif; ?>
			<!-- “About Bechstein Hall” block end -->
			<!-- “Your Visit” block start -->
			<?php
			$your_visit_block   = get_field( 'your_visit_block' );
			$your_visit_heading = $your_visit_block['heading'];
			?>
			<section class="section home-grey wf-section">
				<div class="container-home-slider _2">
					<div class="bottom-links-container">
						<div id="w-node-_232af724-2b60-16c2-c638-e9eaf3767da9-89261594" class="div-block-17">
							<?php if ( ! empty( $your_visit_heading ) ) : ?>
								<h2 class="h2-50-65 white h-60-75">
									<?php echo esc_html( $your_visit_heading ); ?>
								</h2>
							<?php endif; ?>
							<div class="his-left-imagemom _2">
								<?php
								$sticky_image = $your_visit_block['sticky_image'];
								if ( ! empty( $sticky_image ) ) {
									echo wp_get_attachment_image(
										$sticky_image['ID'],
										'large',
										false,
										array(
											'class' => 'img-cover',
										)
									);
								}
								?>
							</div>
						</div>
						<div id="w-node-f68b1e07-4cf2-4c60-76f8-48cbef9b803c-89261594" class="div-block-16">
							<?php
							$data_w_ids = array(
								'2f72eb80-2a8c-9b7d-2cf8-2b029d419185',
								'63653c19-eb20-5e7d-99bb-36203865bed8',
								'864c5c2b-0c2b-b4a9-5cc9-04ae5df778f7',
								'3633954b-6047-8770-86f4-118c9f8d4003',
								'ef6822ff-480a-758e-b105-2831eb599714',
							);

							$data_images_w_ids = array(
								'947e45a5-ca5f-a28e-a049-21a0175e70e6',
								'89aa9b38-760f-c5ec-16d5-9f1ae26ad59f',
								'16750c43-c631-2779-61ea-5b3be611245a',
								'70aa6f49-2517-4b9a-3f3b-1e5de238aeeb',
								'ed1bcf43-9212-cdda-faa0-08583c0a8af7',
							);

							$links = $your_visit_block['links'];

							foreach ( $links as $index => $link_item ) :
								?>
								<a data-w-id="<?php echo esc_attr( $data_w_ids[ $index ] ?? '' ); ?>" href="<?php echo esc_url( $link_item['link_url'] ); ?>" class="home-but-link w-inline-block">
									<div><?php echo $link_item['link_title'] ? esc_html( $link_item['link_title'] ) : ''; ?></div>
								</a>
								<div data-w-id="0a29acdc-7f6a-f365-9b49-b48c411c22cd" class="devider-but"></div>
							<?php endforeach; ?>
							<div id="ball" class="cursor">
								<div class="cursor-mom">
									<?php foreach ( $links as $index => $link_item ) : ?>
										<?php
										echo wp_get_attachment_image(
											$link_item['hover_image']['ID'],
											'large',
											false,
											array(
												'class' => 'image-cursor',
												'data-w-id' => $data_images_w_ids[ $index ] ?? '',
												'style' => '-webkit-transform:translate3d(0, 0, 0) scale3d(1.2, 1.2, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);-moz-transform:translate3d(0, 0, 0) scale3d(1.2, 1.2, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);-ms-transform:translate3d(0, 0, 0) scale3d(1.2, 1.2, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);transform:translate3d(0, 0, 0) scale3d(1.2, 1.2, 1) rotateX(0) rotateY(0) rotateZ(0) skew(0, 0);opacity:0',
											)
										);
										?>
									<?php endforeach; ?>
								</div>
							</div>
							<?php
							$link = $your_visit_block['your_visit_link'];
							if ( ! empty( $link['url'] ) ) :
								?>
								<a href="<?php echo esc_url( $link['url'] ); ?>" class="link-20 white" target="<?php echo ! empty( $link['target'] ) ? esc_attr( $link['target'] ) : '_self'; ?>"><?php echo esc_html( $link['title'] . ' ' ); ?></a>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="grey-z"></div>
			</section>
			<!-- “Your Visit” block end -->
		</main>
		<?php get_footer(); ?>
	</div>
	<!-- <a href="#" class="button clear-cookie w-button">clear cache</a> -->
	<script>
		let headwidth;

		$(".b-menu").click(function() {

			headwidth = $(".navbar").width();
			$(".header").css({
				"max-width": headwidth
			});

			if ($(".body").hasClass("menuopen")) {
				$(".body").removeClass("menuopen");
				$(".navbar").removeClass("grey-head");
			} else {
				$(".body").addClass("menuopen");
				$(".navbar").addClass("grey-head");
			}

		});


		document.addEventListener("DOMContentLoaded", function() {
			function reportWindowSize() {
				headwidth = $(".navbar").width();
				console.log(headwidth);
				$(".header").css({
					"max-width": headwidth
				});
			}

			window.onresize = reportWindowSize;
		});
	</script>
	<!-- F’in sweet Webflow Hacks -->
	<style>
		/*The page-wrapper is initially hidden*/
		.page-wrapper {
			display: none;
		}
	</style>
	<?php get_template_part( 'footer_block', '' ); ?>

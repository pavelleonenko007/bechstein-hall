<?php
/*
Template name: Festival
*/
?>
<!DOCTYPE html>
<!-- This site was created in Webflow. https://www.webflow.com -->
<!-- Last Published: Wed Jul 13 2022 13:06:33 GMT+0000 (Coordinated Universal Time) -->
<html <?php language_attributes(); ?> data-wf-page="62bc3fe7d9cc619b4c261599" data-wf-site="62bc3fe7d9cc6134bf261592">
<?php get_template_part("header_block", ""); ?>

<body <?php body_class("body"); ?>>
	<?php wp_body_open(); ?>
	<?php get_template_part('inc/components/loader'); ?>
	<div class="page-wrapper">
		<?php get_header();
		the_post(); ?>
		<main class="wrapper">
			<section class="section wf-section">
				<div class="breadcrumbs-line">
					<?php if (function_exists('bcn_display')) bcn_display(); ?>
				</div>
			</section>
			<section class="section wf-section">
				<div class="head-fest">
					<h1 class="h1-75-90">
						<?php the_title(); ?>
					</h1>
					<div class="p-35-45 date-text">
						<?php echo get_post_meta($post->ID, '_bechtix_festival_dates', true); ?>
					</div>
				</div>
			</section>
			<section class="section wf-section">
				<div class="mom-fest-img">
					<?php the_post_thumbnail('large', [
						'class' => 'img-fest'
					]); ?>
			</section>
			<section class="section wf-section">
				<div class="desc-fest">
					<p class="p-25-40 fest-desc">
						<?php echo get_field('festival_description'); ?>
					</p>
				</div>
			</section>
			<section class="section wf-section">
				<div class="catalog-row">
					<div class="festival-column no-mob">
						<div class="festival-styk">
							<div class="fest-img-mom">
								<?php the_post_thumbnail('medium', [
									'class' => 'img-cover'
								]); ?>
							</div>
							<div class="p-30-40 f40">
								<?php the_title(); ?>
							</div>
							<div class="p-20-30 fest">
								<?php echo get_post_meta($post->ID, '_bechtix_festival_dates', true); ?>
							</div>
							<?php $tickets_information_link = get_field('tickets_information_url', $post->ID) ? get_field('tickets_information_url', $post->ID) : get_field('tickets_information_url', 'option');

							if (trim($tickets_information_link) !== '') : ?>
								<a href="<?php echo $tickets_information_link; ?>" class="p-15-25"><strong>Tickets information</strong></a>
							<?php endif; ?>
							<div class="p-17-25 italic">
								<?php echo get_post_meta($post->ID, '_bechtix_festival_note', true); ?>
							</div>
						</div>
					</div>
					<div class="catalog-column fest-col">
						<div class="cms-ul-events">
							<div class="cms-tems">
								<?php
								$events = get_posts([
									'post_type' => 'events',
									'post_status' => 'publish',
									'numberposts' => -1,
									'fields' => 'ids',
									'meta_query' => [
										[
											'key' => '_bechtix_festival_relation',
											'value' => $post->ID
										]
									]
								]);

								$tickets = [];

								if (!empty($events)) {
									$tickets = get_posts([
										'post_type' => 'tickets',
										'post_status' => 'publish',
										'numberposts' => -1,
										'meta_query' => [
											[
												'key' => '_bechtix_event_relation',
												'value' => $events,
												'compare' => 'IN'
											]
										]
									]);
								}

								$sorted_tickets = bech_sort_tickets($tickets);

								if (!empty($sorted_tickets)) :
									foreach ($sorted_tickets as $date => $tickets) : ?>
										<div class="cms-ul">
											<div class="cms-heading">
												<h2 class="h2-cms"><?php echo date('d F', strtotime($date)); ?></h2>
												<h2 class="h2-cms day"><?php echo date('l', strtotime($date)); ?></h2>
											</div>
											<div class="cms-ul-events">
												<?php foreach ($tickets as $ticket) :
													$event = get_post(get_post_meta($ticket->ID, '_bechtix_event_relation', true));
													$purchase_urls = get_post_meta($ticket->ID, '_bechtix_purchase_urls', true);
													$purchase_urls_normal = json_decode($purchase_urls, true);
												?>
													<?php get_template_part('inc/components/whats-on-ticket', '', [
														'ticket' => $ticket->ID
													])  ?>
													<!-- <div class="cms-li">
													<div class="cms-li_mom-img">
														<?php echo wp_get_attachment_image(
															get_post_meta($event->ID, '_bechtix_event_image', true),
															'medium',
															false,
															[
																'class' => 'cms-li_img',
																'style' => 'max-height: 270rem'
															]
														); ?>
														<?php $sale_status = get_post_meta($ticket->ID, '_bechtix_sale_status', true);
														$sale_statuses = [
															'No Status',
															'Few tickets',
															'Sold out',
															'Cancelled',
															'Not scheduled'
														];
														if ($sale_status !== '0' && $sale_status !== '') :
														?>
															<div class="cms-li_sold-out-banner"><?php echo $sale_statuses[intval($sale_status)]; ?></div>
														<?php endif; ?>
													</div>
													<div class="cms-li_content">
														<div class="cms-li_time-div">
															<div class="p-30-45"><?php echo bech_get_ticket_times($ticket->ID); ?></div>
															<div class="p-17-25 italic"><?php echo get_post_meta($ticket->ID, '_bechtix_duration', true); ?></div>
														</div>
														<div class="p-20-30 title-event"><?php echo get_the_title($ticket); ?></div>
														<p class="p-17-25"><?php echo get_field('event_subheader', $ticket->ID); ?></p>
														<div class="cms-li_tags-div">
															<?php $tags = wp_get_object_terms($ticket->ID, ['event_tag', 'genres', 'instruments']);
															foreach ($tags as $tag) : ?>
																<a href="#" class="cms-li_tag-link"><?php echo $tag->name; ?></a>
															<?php endforeach; ?>
														</div>
														<div class="cms-li_actions-div">
															<?php
															if ($sale_status === '' || $sale_status === '0' || $sale_status === '1') : ?>
																<a bgline="1" href="<?php echo $purchase_urls_normal[0]['link']; ?>" class="booktickets-btn">
																	<strong>Book tickets</strong>
																</a>
															<?php else : ?>
																<a bgline="2" href="#" class="booktickets-btn sold-out">
																	<strong><?php echo $sale_statuses[intval($sale_status)]; ?></strong>
																</a>
															<?php endif; ?>
															<a href="<?php echo get_the_permalink($event->ID); ?>" class="readmore-btn w-inline-block">
																<div>read more</div>
																<div> →</div>
															</a>
														</div>
														<div class="cms-li_price"><?php echo bech_get_ticket_from_to_price($ticket->ID); ?></div>
													</div>
													<div class="cms-li_actions-div biger">
														<a bgline="1" href="<?php echo $purchase_urls_normal[0]['link']; ?>" class="booktickets-btn">
															<strong>Book tickets</strong>
														</a>
														<div class="cms-li_price"><?php echo bech_get_ticket_from_to_price($ticket->ID); ?></div>
													</div>
												</div> -->
												<?php endforeach; ?>
											</div>
										</div>
									<?php endforeach;
								else : ?>
									<div class="no-events">
										<p class="no-event-message">There is no events — we're working on a concert program.</p>
										<a href="<?php echo get_the_permalink(255); ?>" class="link-20"><?php echo get_the_title(255); ?></a>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</section>
		</main>
		<?php get_footer(); ?>
	</div>
	<!--[if lte IE 9]><script src="//cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif]-->
	<script>
		let headwidth;

		$(".b-menu").click(function() {

			headwidth = $(".navbar").width();
			console.log(headwidth);
			$(".header").css({
				"max-width": headwidth
			});

			if ($(".body").hasClass("menuopen"))

			{
				$(".body").removeClass("menuopen");
				$(".navbar").removeClass("grey-head");
			} else

			{
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
	<?php get_template_part("footer_block", ""); ?>
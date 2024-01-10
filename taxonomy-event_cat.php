<?php
/*
Template name: Event
*/

$category = get_queried_object();
?>
<!DOCTYPE html>
<!-- This site was created in Webflow. https://www.webflow.com -->
<!-- Last Published: Wed Jul 13 2022 13:06:33 GMT+0000 (Coordinated Universal Time) -->
<html <?php language_attributes(); ?> data-wf-page="62bc3fe7d9cc618392261598" data-wf-site="62bc3fe7d9cc6134bf261592">
<?php get_template_part("header_block", ""); ?>

<body <?php body_class("body"); ?>>
	<?php wp_body_open(); ?>
	<?php get_header(); ?>
	<main class="wrapper">
		<section class="section wf-section">
			<div class="head-event-container single-page">
				<div class="head-event-content single-page">
					<img src="<?php echo get_field('event_image', $category); ?>">
					<div class="head-event-content_in">
						<div class="left-event-col left-event">
							<h1 class="h1-75-90 event-h">
								<?php echo $category->name; ?>
							</h1>
							<div class="p-25-40">
								<?php echo $category->description; ?>
							</div>
							<a href="#tickets" bgline="1" class="choisetckets-btn min">
								<strong>choose tickets</strong>
							</a>
						</div>
						<?php
						$args = [
							'post_type' => 'event',
							'post_status' => 'publish',
							'numberposts' => -1,
							'tax_query' => [
								[
									'taxonomy' => $category->taxonomy,
									'field' => 'id',
									'terms' => $category->term_id
								]
							]
						];

						$tickets = get_posts($args);

						//var_dump($tickets); 
						?>

						<div class="right-event-col">
							<?php foreach ($tickets as $ticket) : ?>
								<div class="events-ticket">
									<div class="events-ticket_left">
										<div class="p-17-25 top-ticket"><?php echo date('l', strtotime(get_field('start_date', $ticket->ID))); ?></div>
										<div class="p-20-30"><?php echo date('d F', strtotime(get_field('start_date', $ticket->ID))); ?></div>
										<div class="p-20-30 w20"><?php echo bech_get_ticket_times($ticket->ID); ?></div>
									</div>
									<div class="events-ticket_right">
										<?php $sale_status = get_field('sale_status', $ticket->ID);
										if ($sale_status['value'] === '0' || $sale_status['value'] === '1') :
											$purchase_urls = get_field('purchase_urls', $ticket->ID); ?>
											<a bgline="1" href="<?php echo $purchase_urls[0]['link']; ?>" data-book-urls="<?php echo _wp_specialchars(wp_json_encode($purchase_urls), ENT_QUOTES, 'UTF-8', true); ?>" class="booktickets-btn min">
												<strong>Book tickets</strong>
											</a>
											<a href="#" class="event-ticket_calendar-btn w-inline-block">
												<img src="<?php echo get_template_directory_uri() ?>/images/62bc3fe7d9cc6162b22615c0_calendar.svg" loading="lazy" alt class="img-calendar">
												<div>ADD TO CALENDAR</div>
											</a>
										<?php else : ?>
											<a bgline="2" href="#" class="booktickets-btn sold-out min">
												<strong><?php echo $sale_status['label']; ?></strong>
											</a>
										<?php endif; ?>
									</div>
								</div>
							<?php endforeach;
							unset($ticket); ?>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="section event-page wf-section">
			<div class="event-row">
				<div class="event-row_left-col">
					<div class="event-row_left-info">
						<div class="evetn-left-contnt-div">
							<div class="event-avatar">
								<img src="<?php echo get_field('event_image', $category); ?>" />
							</div>
							<div>
								<div class="p-35-45 no-mpb">
									<?php echo $category->name; ?>
								</div>
								<div class="p-17-25 no-mob">
									<?php echo $category->description; ?>
								</div>
								<div class="cms-li_tags-div in-left">
									<?php

									if (!empty($tickets)) :
										$term_query = wp_get_object_terms($tickets[0]->ID, ['event_tag', 'genres', 'instruments']);
										foreach ($term_query as $term) : ?>
											<a href="<?php echo get_term_link($term->term_id, $term->taxonomy); ?>" class="cms-li_tag-link"><?php echo $term->name ?></a>
									<?php endforeach;
										unset($term_query);
									endif; ?>
								</div>
								<div class="p-17-25 italic">
									<?php echo get_field('duration_info') ?>
								</div>
							</div>
						</div>
						<div class="tikets-pc">
							<div>
								<?php foreach ($tickets as $ticket) : ?>
									<div class="events-ticket">
										<div class="events-ticket_left">
											<div class="p-17-25 top-ticket _2"><?php echo date('l', strtotime(get_field('start_date', $ticket->ID))); ?></div>
											<div class="p-20-30 w20 m30"><?php echo date('d F', strtotime(get_field('start_date', $ticket->ID))); ?></div>
											<div class="p-20-30 w20"><?php echo bech_get_ticket_times($ticket->ID); ?></div>
										</div>
										<div class="events-ticket_right">
											<a bgline="1" href="<?php echo $purchase_urls[0]['link']; ?>" data-book-urls="<?php echo _wp_specialchars(wp_json_encode($purchase_urls), ENT_QUOTES, 'UTF-8', true); ?>" target="_blank" class="booktickets-btn min left-side">
												<strong>Book tickets</strong>
											</a>
											<a href="#" class="event-ticket_calendar-btn min w-inline-block">
												<img src="<?php echo get_template_directory_uri() ?>/images/62bc3fe7d9cc6162b22615c0_calendar.svg" loading="lazy" alt class="img-calendar">
												<div>ADD TO CALENDAR</div>
											</a>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
							<div class="info-right-side-bottom">
								<div>Tickets information</div>
								<div>Seating plan</div>
							</div>
						</div>
					</div>
				</div>
				<div class="event-row_right-col">
					<?php $content_blocks = get_field('content_blocks', $category);

					foreach ($content_blocks as $content_block) : ?>
						<?php if ($content_block['acf_fc_layout'] === 'alert_block') :
							$link = $content_block['link'];
							$link_html = $link['url'] ? '<a href="' . $link['url'] . '">' . $link['link_text'] . '</a>' : ''; ?>
							<div class="ui_alert-block w-richtext">
								<p><?php echo $content_block['text']; ?> <?php echo $link_html; ?></p>
							</div>
						<?php elseif ($content_block['acf_fc_layout'] === 'paragraph') : ?>
							<div class="ui_text-block w-richtext">
								<?php echo $content_block['paragraph']; ?>
							</div>
						<?php elseif ($content_block['acf_fc_layout'] === 'programme_columns') : ?>
							<div class="ui_program-row">
								<?php $columns = $content_block['columns'];
								foreach ($columns as $column) : ?>
									<div id="w-node-fa9df372-dff5-74be-646a-834100e2033a-92261598" class="ui_program-col">
										<h2 class="h2-35-45">
											<?php echo $column['column_title']; ?>
										</h2>
										<?php $list = $column['column_list'];
										if (!empty($list)) : ?>
											<div class="ui_program-core">
												<?php foreach ($list as $list_item) : ?>
													<div class="ui_program-item">
														<div class="p-20-30">
															<?php echo $list_item['list_title']; ?>
														</div>
														<div class="p-17-25 italic">
															<?php echo $list_item['list_subtitle']; ?>
														</div>
													</div>
												<?php endforeach; ?>
											</div>
										<?php endif; ?>
									</div>
								<?php endforeach; ?>
							</div>
						<?php elseif ($content_block['acf_fc_layout'] === 'watch_and_listen') : ?>
							<h2 class="h2-35-45">
								<?php echo $content_block['heading']; ?>
							</h2>
							<?php
							$videos = $content_block['videos'];
							foreach ($videos as $video) : ?>
								<a href="#" class="ui-event-link w-inline-block w-lightbox">
									<div class="ui-event-link_img-mom">
										<?php echo preg_replace('/(width|height)=\"(\d+)\"/', '', wp_get_attachment_image(
											$video['poster']['ID'],
											'medium',
											false,
											[
												'class' => 'ui-event-link_img'
											]
										)); ?>
										<!-- <img src="" loading="lazy" alt class="play-ico-24"> -->
									</div>
									<div class="vert">
										<div class="p-25-40"><?php echo $video['video_title']; ?></div>
										<div class="p-17-25 italic"><?php echo $video['video_description']; ?></div>
									</div>
									<?php
									$json = [];
									$json['group'] = $content_block['heading'];
									$json['items'][] = [
										'url' => $video['video_link'],
										'originalUrl' => $video['video_link'],
										'html' => '<iframe width="940" height="528" src="https://www.youtube.com/embed/' . bech_get_youtube_video_id_from_link($video['video_link']) . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
										'thumbnailUrl' => wp_get_attachment_image_url($video['poster']['ID'], 'full'),
										'width' => 940,
										'height' => 528,
										'type' => 'video'
									];
									?>
									<script class="w-json" type="application/json">
										<?php echo json_encode($json, JSON_UNESCAPED_SLASHES); ?>
									</script>
								</a>
							<?php endforeach; ?>
						<?php elseif ($content_block['acf_fc_layout'] === 'dropdowns_block') : ?>
							<h2 class="h2-35-45">
								<?php echo $content_block['heading']; ?>
							</h2>
							<?php $dropdowns = $content_block['dropdowns'];
							foreach ($dropdowns as $dropdown) : ?>
								<div class="ui-drop-container">
									<div class="ui-drop-container_btn">
										<div class="p-20-30">
											<?php echo $dropdown['dropdown_title']; ?>
										</div>
										<div class="ui-drop-container_ico-mom">
											<div class="ui-drop-container_ico-mom_down">→</div>
											<div class="ui-drop-container_ico-mom_top">→</div>
										</div>
									</div>
									<div class="ui-drop-container_content">
										<p class="p-17-25">
											<?php echo $dropdown['dropdown_content']; ?>
										</p>
									</div>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
					<?php endforeach;
					?>
					<?php if (get_field('show_alert_box')) { ?>
						<div>
							<div class="ui_alert-block w-richtext">
								<?php echo get_field('alert_box_text') ?>
							</div>
						</div>
					<?php } ?>
					<div class="ui_text-block w-richtext">
						<?php echo get_field('main_info') ?>
					</div>
					<div class="ui_program-row">
						<div id="w-node-fa9df372-dff5-74be-646a-834100e2033a-92261598" class="ui_program-col">
							<h2 class="h2-35-45">
								<?php echo get_field('performers_header') ?>
							</h2>
							<?php if (have_rows('performers_loop')) { ?>
								<div class="ui_program-core">
									<?php global $parent_id;
									$parent_id = $loop_id;
									$loop_index = 0;
									$loop_title = "Performers loop";
									$loop_field = "performers_loop";
									while (have_rows('performers_loop')) {
										global $loop_id;
										$loop_index++;
										$loop_id++;
										the_row(); ?>
										<div class="ui_program-item">
											<div class="p-20-30">
												<?php echo get_sub_field('name') ?>
											</div>
											<div class="p-17-25 italic">
												<?php echo get_sub_field('instrument') ?>
											</div>
										</div>
									<?php } ?>
								</div>
							<?php } ?>
						</div>
						<div id="w-node-_3918fa0d-bee1-22b5-2113-249bb5d8e536-92261598" class="ui_program-col">
							<h2 class="h2-35-45">
								<?php echo get_field('programme_header') ?>
							</h2>
							<?php if (have_rows('programme_loop')) { ?>
								<div class="ui_program-core">
									<?php global $parent_id;
									$parent_id = $loop_id;
									$loop_index = 0;
									$loop_title = "Programme loop";
									$loop_field = "programme_loop";
									while (have_rows('programme_loop')) {
										global $loop_id;
										$loop_index++;
										$loop_id++;
										the_row(); ?>
										<div class="ui_program-item">
											<div class="p-20-30">
												<?php echo get_sub_field('composer') ?>
											</div>
											<div class="p-17-25 italic">
												<?php echo get_sub_field('composition') ?>
											</div>
										</div>
									<?php } ?>
								</div>
							<?php } ?>
						</div>
					</div>

					<h2 class="h2-35-45">
						<?php echo get_field('watch_and_listen_header') ?>
					</h2>
					<?php if (have_rows('videos')) { ?>
						<div>
							<?php global $parent_id;
							$parent_id = $loop_id;
							$loop_index = 0;
							$loop_title = "Videos";
							$loop_field = "videos";
							while (have_rows('videos')) {
								global $loop_id;
								$loop_index++;
								$loop_id++;
								the_row(); ?>
								<a href="#" class="ui-event-link w-inline-block w-lightbox">
									<div class="ui-event-link_img-mom"><img src="<?php $field = get_sub_field('video_cover');
																																if (isset($field['url'])) {
																																	echo ($field['url']);
																																} elseif (is_numeric($field)) {
																																	echo (wp_get_attachment_image_url($field, 'full'));
																																} else {
																																	echo ($field);
																																} ?>" loading="lazy" alt="<?php echo esc_attr($field['alt']); ?>" class="ui-event-link_img" title="<?php echo pathinfo($field['filename'])['filename'] !== $field['title'] ? esc_attr($field['title']) : ''; ?>"><img src="<?php echo get_template_directory_uri() ?>/images/62bc3fe7d9cc6168db2615cc_poly-play.svg" loading="lazy" alt class="play-ico-24"></div>
									<div class="vert">
										<div class="p-25-40"><?php echo get_sub_field('video_header') ?></div>
										<div class="p-17-25 italic"><?php echo get_sub_field('video_description') ?></div>
									</div>
									<script type="application/json" class="w-json">
										<?php
										$item = get_sub_field('video_link');
										$items = array();
										if (is_array($item)) {
											$video = $item['video'];
											$poster = $item['poster'];
											if (isset($poster['url'])) {
												$image_url = $poster['url'];
											} elseif (is_numeric($poster)) {
												$image_url = wp_get_attachment_image_url($poster, 'full');
											} else {
												$image_url = $poster;
											}
										} else {
											$video = $item;
											$image_url = '';
										}
										$items[] = [
											'html' => $video,
											'thumbnailUrl' => $image_url,
											'width' => 940,
											'height' => 528,
											'type' => 'video'
										];
										echo json_encode([
											'group' => '',
											'items' => $items
										], JSON_UNESCAPED_SLASHES);
										?>
									</script>
								</a>
							<?php } ?>
						</div>
					<?php } ?>
					<?php if (get_field('show_festival_block')) { ?>
						<div class="div-block-24">
							<?php if (have_rows('festival_group')) { ?>
								<div>
									<?php global $parent_id;
									$parent_id = $loop_id;
									$loop_index = 0;
									$loop_title = "Festival group";
									$loop_field = "festival_group";
									while (have_rows('festival_group')) {
										global $loop_id;
										$loop_index++;
										$loop_id++;
										the_row(); ?>
										<h2 class="h2-35-45">
											<?php echo get_sub_field('festival_block_header') ?>
										</h2><a href="<?php echo get_sub_field('festival_link') ?>" class="ui-festival-link w-inline-block"><img src="<?php $field = get_sub_field('festival_image');
																																																																	if (isset($field['url'])) {
																																																																		echo ($field['url']);
																																																																	} elseif (is_numeric($field)) {
																																																																		echo (wp_get_attachment_image_url($field, 'full'));
																																																																	} else {
																																																																		echo ($field);
																																																																	} ?>" loading="lazy" alt="<?php echo esc_attr($field['alt']); ?>" class="ui-festival-link_img" title="<?php echo pathinfo($field['filename'])['filename'] !== $field['title'] ? esc_attr($field['title']) : ''; ?>">
											<div class="ui-festival-link_content">
												<div><?php echo get_sub_field('image_header') ?></div>
												<div><?php echo get_sub_field('festival_dates') ?></div>
											</div>
										</a>
									<?php } ?>
								</div>
							<?php } ?>
						</div>
					<?php } ?>
					<h2 class="h2-35-45">
						<?php echo get_field('your_visit_header') ?>
					</h2>
					<?php if (have_rows('dropdowns_loop')) { ?>
						<div>
							<?php global $parent_id;
							$parent_id = $loop_id;
							$loop_index = 0;
							$loop_title = "Dropdowns loop";
							$loop_field = "dropdowns_loop";
							while (have_rows('dropdowns_loop')) {
								global $loop_id;
								$loop_index++;
								$loop_id++;
								the_row(); ?>
								<div class="ui-drop-container">
									<div class="ui-drop-container_btn">
										<div class="p-20-30">
											<?php echo get_sub_field('header') ?>
										</div>
										<div class="ui-drop-container_ico-mom">
											<div class="ui-drop-container_ico-mom_down">→</div>
											<div class="ui-drop-container_ico-mom_top">→</div>
										</div>
									</div>
									<div class="ui-drop-container_content">
										<p class="p-17-25">
											<?php echo get_sub_field('text') ?>
										</p>
									</div>
								</div>
							<?php } ?>
						</div>
					<?php } ?>
					<div id="tickets" class="tikets-mob">
						<div class="events-ticket">
							<div class="events-ticket_left">
								<div class="p-17-25 top-ticket _2">Thursday</div>
								<div class="p-20-30 w20 m30">29 February</div>
								<div class="p-20-30 w20">19:00–21:00</div>
							</div>
							<div class="events-ticket_right"><a bgline="1" href="#" class="booktickets-btn min left-side"><strong>Book tickets</strong></a><a href="#" class="event-ticket_calendar-btn min w-inline-block"><img src="<?php echo get_template_directory_uri() ?>/images/62bc3fe7d9cc6162b22615c0_calendar.svg" loading="lazy" alt class="img-calendar">
									<div>ADD TO CALENDAR</div>
								</a></div>
						</div>
						<div class="events-ticket">
							<div class="events-ticket_left">
								<div class="p-17-25 top-ticket _2">Thursday</div>
								<div class="p-20-30 w20 m30">29 February</div>
								<div class="p-20-30 w20">19:00–21:00</div>
							</div>
							<div class="events-ticket_right"><a bgline="1" href="#" class="booktickets-btn min left-side"><strong>Book tickets</strong></a><a href="#" class="event-ticket_calendar-btn min w-inline-block"><img src="<?php echo get_template_directory_uri() ?>/images/62bc3fe7d9cc6162b22615c0_calendar.svg" loading="lazy" alt class="img-calendar">
									<div>ADD TO CALENDAR</div>
								</a></div>
						</div>
						<div class="info-right-side-bottom">
							<div>Tickets information</div>
							<div>Seating plan</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>
	<footer class="footer">
		<div class="foo-mom">
			<div class="footer-container top-container">
				<div id="w-node-e1be876e-05a4-9245-628d-78602bcc79a4-2bcc79a3" class="footer-col _1 top-col"><a href="/whats-on" class="link-foo-big">What’s on?</a>
					<div class="foo-menu-div"><a href="#" class="link-foo-small">Schedule</a><a href="#" class="link-foo-small">Priority booking</a></div>
					<div class="foo-marger"></div><a href="/festival" class="link-foo-whats_last w-inline-block"><img src="<?php echo get_template_directory_uri() ?>/images/62bc3fe7d9cc612f532615c7_Rectangle2039.jpg" loading="lazy" alt class="img-cover foters">
						<div class="text-block">Autumn Festival ‘22</div>
					</a><a href="#" class="link-foo-small no-mob">Rachmaninov Days at Bechstein Hall</a>
				</div>
				<div id="w-node-e1be876e-05a4-9245-628d-78602bcc79ba-2bcc79a3" class="footer-col top-col center-col"><a href="/your-visit" class="link-foo-big">your visit</a>
					<div class="foo-menu-div"><a href="/box-office" class="link-foo-small">Health and safety</a></div>
					<div class="foo-marger"></div>
					<div class="foo-menu-div"><a href="/box-office" class="link-foo-small">Ticketing Info</a><a href="#" class="link-foo-small">Getting here</a><a href="#" class="link-foo-small">Security & Rules</a><a href="#" class="link-foo-small">Contact Us</a></div>
					<div class="foo-marger"></div>
					<div class="foo-menu-div"><a href="/about" class="link-foo-small">Around Bechstein Hall</a><a href="#" class="link-foo-small">Tours</a><a href="#" class="link-foo-small">Eat & drink</a><a href="#" class="link-foo-small">Venue & seating plan</a></div>
					<div class="foo-marger"></div>
					<div class="foo-menu-div"><a href="#" class="link-foo-small">Accesible facilities</a><a href="#" class="link-foo-small">Accesibility statement</a><a href="/contacts" class="link-foo-small">Contacts</a></div>
					<div class="foo-bottom no-pc"><a href="#" class="link-foo-small _2">Terms and Conditions</a><a href="#" class="link-foo-small last">Privacy policy</a></div>
				</div>
				<div id="w-node-e1be876e-05a4-9245-628d-78602bcc79dd-2bcc79a3" class="footer-col _3 top-col"><a href="/history" class="link-foo-big _2">History</a><a href="#" class="link-foo-big _2">friends</a><a href="/press-office" class="link-foo-big _2">Press</a><a href="#" class="link-foo-big _2">hire the hall</a></div>
			</div>
			<div class="footer-container bottom">
				<div class="footer-col _1">
					<div class="div-block-2">
						<div class="p-20-27">(020) 1234 5678 support@bechsteinhall.com London, W1U 2RJ, 22–28 Wigmore St.</div>
					</div>
					<div class="foo-soc-line"><a href="#" class="link-soc w-inline-block"></a><a href="#" class="link-soc w-inline-block"></a><a href="#" class="link-soc w-inline-block"></a><a href="#" class="link-soc w-inline-block"></a></div>
				</div>
				<div class="footer-col no-mob">
					<div class="foo-bottom nz"><a href="#" class="link-foo-small _2">Terms and Conditions</a><a href="#" class="link-foo-small last">Privacy policy</a></div>
				</div>
				<div class="footer-col _3">
					<div class="foo-bottomer">
						<div>© 2022, Bechstein Hall</div><a href="#" class="funk-link">Website made by Func. ↗</a>
					</div>
				</div>
			</div>
		</div>
		<div class="white-z"></div>
	</footer>
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
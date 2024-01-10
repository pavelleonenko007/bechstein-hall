<?php
/*
Template name: Your Visit archive template
*/
?>
<!DOCTYPE html>
<!-- This site was created in Webflow. https://www.webflow.com -->
<!-- Last Published: Wed Jul 13 2022 13:06:33 GMT+0000 (Coordinated Universal Time) -->
<html <?php language_attributes(); ?> data-wf-page="62bc3fe7d9cc6167a126159e" data-wf-site="62bc3fe7d9cc6134bf261592">
<?php get_template_part("header_block", ""); ?>

<body <?php body_class("body"); ?>>
	<?php get_template_part('inc/components/loader'); ?>
	<div class="page-wrapper">
		<?php get_header();
		the_post(); ?>
		<main class="wrapper">
			<section class="section wf-section">
				<div class="breadcrumbs-line">
					<?php if (function_exists('bcn_display')) {
						bcn_display();
					} ?>
				</div>
			</section>
			<section class="section wf-section">
				<div class="catalog-row m-revert">
					<div class="festival-column yvisit">
						<div class="yvisit-styk yvis">
							<?php $hide_sidebar = get_field('hide_original_sidebar');
							!$hide_sidebar && dynamic_sidebar('custom_bechstein_sidebar');
							?>
							<?php $sidebar_items = get_field('sidebar_flexible_content');
							if (!empty($sidebar_items)) : ?>
								<?php foreach ($sidebar_items as $sidebar_item) : ?>
									<?php if ($sidebar_item['acf_fc_layout'] === 'list_block') : ?>
										<div class="page-sidebar-block">
											<div id="w-node-b4f2a2bf-0315-f758-a56f-5ed7b3867d97-e526159f" class="p-30-40 med w35">
												<?php echo $sidebar_item['heading']; ?>
											</div>
											<div class="page-sidebar-block__content">
												<?php foreach ($sidebar_item['link_list'] as $list_item) : ?>
													<a href="<?php echo $sidebar_item['item_link']; ?>" class="ui-yourvisit_link-in w-inline-block" target="_blank">
														<div class="p-20-30 med w20"><?php echo $list_item['item_title']; ?></div>
														<div class="p-17-25 mar10"><?php echo $list_item['item_short_description']; ?></div>
													</a>
												<?php endforeach; ?>
											</div>
										</div>
									<?php elseif ($sidebar_item['acf_fc_layout'] === 'small_text_block') : ?>
										<div class="page-sidebar-block">
											<div id="w-node-b4f2a2bf-0315-f758-a56f-5ed7b3867d97-e526159f" class="p-30-40 med w35">
												<?php echo $sidebar_item['heading']; ?>
											</div>
											<div class="page-sidebar-block__content">
												<div class="small-text-content">
													<?php echo $sidebar_item['small_text']; ?>
												</div>
											</div>
										</div>
									<?php endif; ?>
								<?php endforeach; ?>
							<?php endif; ?>
						</div>
					</div>
					<div class="yourvisit-column">
						<h1 class="h1-75-90 yv-page"><?php the_title(); ?></h1>
						<?php $description = bech_get_the_content_without_formatting($post->ID);
						if (!empty($description)) : ?>
							<p class="p-25-40 your-visit"><?php echo $description; ?></p>
						<?php endif; ?>
						<div class="layouts">
							<?php $page_sections = get_field('site_sections');
							foreach ($page_sections as $page_section) : ?>
								<?php if ($page_section['acf_fc_layout'] === 'information_listing') : ?>
									<?php foreach ($page_section['blocks'] as $block) : ?>
										<?php get_template_part('inc/acf-flexible-sections/information-card', '', [
											'card-info' => $block,
										]); ?>
									<?php endforeach; ?>
								<?php elseif ($page_section['acf_fc_layout'] === 'information_grid_listing') : ?>
									<div class="ui-boxoffice-block">
										<div class="wig-block">
											<div class="div-block-23">
												<h2 class="h2-35-45">
													<?php echo $page_section['header']; ?>
												</h2>
											</div>
											<?php $grid_cards = $page_section['grid_blocks'];
											if (!empty($grid_cards)) : ?>
												<div class="cms-about">
													<?php foreach ($grid_cards as $grid_card) : ?>
														<?php get_template_part('inc/acf-flexible-sections/restoraunt-grid-card', '', [
															'card' => $grid_card,
														]); ?>
													<?php endforeach; ?>
												</div>
											<?php endif; ?>
											<div class="t-line"></div>
										</div>
									</div>
								<?php elseif ($page_section['acf_fc_layout'] === 'dropdown_section') : ?>
									<div class="ui-boxoffice-block">
										<div class="div-block-23">
											<h2 class="h2-35-45">
												<?php echo $page_section['header']; ?>
											</h2>
										</div>
										<?php $dropdowns = $page_section['dropdowns_loop'];
										if (!empty($dropdowns)) : ?>
											<div class="cms-drops">
												<?php foreach ($dropdowns as $dropdown) : ?>
													<?php get_template_part('inc/acf-flexible-sections/dropdown', '', [
														'dropdown' => $dropdown,
													]); ?>
												<?php endforeach; ?>
											</div>
										<?php endif; ?>
									</div>
								<?php elseif ($page_section['acf_fc_layout'] === 'text_section') : ?>
									<?php get_template_part('inc/acf-flexible-sections/text-section', '', [
										'title'   => $page_section['header'],
										'content' => $page_section['text'],
									]); ?>
								<?php elseif ($page_section['acf_fc_layout'] === 'text_quote_section') : ?>
									<?php get_template_part('inc/acf-flexible-sections/blockquote', '', [
										'blockquote' => $page_section['text_with_quote'],
									]); ?>
								<?php elseif ($page_section['acf_fc_layout'] === 'quote_with_image') : ?>
									<?php get_template_part('inc/acf-flexible-sections/blockquote-with-image', '', [
										'blockquote' => [
											'author'     => $page_section['author'],
											'image'      => $page_section['image'],
											'quote_text' => $page_section['quote_text'],
										]
									]); ?>
								<?php elseif ($page_section['acf_fc_layout'] === 'contacts_section') : ?>
									<?php get_template_part('inc/acf-flexible-sections/contacts', '', [
										'contacts' => [
											'header' => $page_section['header'],
											'text'   => $page_section['text'],
										]
									]); ?>
								<?php elseif ($page_section['acf_fc_layout'] === 'announcements_section') : ?>
									<?php $press_args = [
										'post_type'      => 'post',
										'posts_per_page' => 6,
										'paged'          => get_query_var('page') ?? get_query_var('paged')
									];

									$press_query = new WP_Query($press_args);
									if ($press_query->have_posts()) : ?>
										<div class="cms-press-ajax">
											<?php while ($press_query->have_posts()) : $press_query->the_post(); ?>
												<?php get_template_part('inc/components/press-office-component', ''); ?>
											<?php endwhile;
											wp_reset_postdata(); ?>
										</div>
									<?php endif; ?>
								<?php elseif ($page_section['acf_fc_layout'] === 'booking_tabs_section') : ?>
									<?php get_template_part('inc/acf-flexible-sections/tabs', '', [
										'title' => $page_section['header'],
										'tabs'  => $page_section['tabs']
									]); ?>
								<?php elseif ($page_section['acf_fc_layout'] === 'gallery_section') : ?>
									<?php get_template_part('inc/acf-flexible-sections/image-gallery', '', [
										'gallery' => $page_section['gallery_loop'],
									]); ?>
								<?php endif; ?>
							<?php endforeach; ?>
							<?php $constructor_sections = get_field('site_sections'); ?>
						</div>
					</div>
				</div>
			</section>
		</main>
		<?php get_footer(); ?>
	</div>
	<!--[if lte IE 9]>
<script src="//cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif]-->
	<script>
		let headwidth;

		$(".b-menu").click(function() {

			headwidth = $(".navbar").width();
			console.log(headwidth);
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
	<?php get_template_part("footer_block", ""); ?>
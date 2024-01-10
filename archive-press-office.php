<?php
/*
Template name: Archive Press office
*/
?>
<!DOCTYPE html>
<!-- This site was created in Webflow. https://www.webflow.com -->
<!-- Last Published: Wed Aug 24 2022 15:21:23 GMT+0000 (Coordinated Universal Time) -->
<html <?php language_attributes(); ?> data-wf-page="625fd286caf248048073c07c" data-wf-site="624c5364ec3046603b0a108f">
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
          <div class="pressres-column">
            <h1 class="h1-75-90">Press Office</h1>
            <?php $args = [
              'post_type' => 'press-office',
              'posts_per_page' => 10,
              'post_status' => 'publish'
            ];
            $posts = new WP_Query($args);

            if ($posts->have_posts()) : ?>
              <?php $tags = get_terms([
                'taxonomy'   => 'press_tag',
                'parent'     => 0
              ]); ?>
              <div class="filter-press">
                <form id="press-filter-form" class="form-filter-press tabs-menu">
                  <input type="submit" value="Submit" data-wait="Please wait..." class="hidden-input w-button">
                  <label class="filter-chek w-radio">
                    <div class="w-form-formradioinput w-form-formradioinput--inputType-custom none w-radio-input"></div>
                    <input type="radio" data-name="tag" id="tag-0" name="tag" value="" style="opacity:0;position:absolute;z-index:-1" checked><span class="radio-button-label w-form-label" for="tag-0">all</span>
                  </label>
                  <?php foreach ($tags as $tag) : ?>
                    <label class="filter-chek w-radio">
                      <div class="w-form-formradioinput w-form-formradioinput--inputType-custom none w-radio-input"></div>
                      <input type="radio" data-name="tag" id="tag-<?php echo $tag->term_id; ?>" name="tag" value="<?php echo $tag->slug; ?>" style="opacity:0;position:absolute;z-index:-1">
                      <span class="radio-button-label w-form-label" for="tag-<?php echo $tag->term_id; ?>"><?php echo $tag->name; ?></span>
                    </label>
                  <?php endforeach; ?>
                  <input type="hidden" name="page" value="1" />
                  <input type="hidden" name="action" value="get_press_release_posts" />
                </form>
              </div>
              <div id="press-office-container">
                <div class="cms-press-ajax">
                  <?php while ($posts->have_posts()) : $posts->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="ui-pressrelease-a w-inline-block">
                      <div class="p-20-30 w20"><?php echo get_the_date('j F Y'); ?></div>
                      <div class="p-25-40 mar13"><?php the_title(); ?></div>
                    </a>
                  <?php endwhile;
                  wp_reset_postdata(); ?>
                </div>
                <?php if ($posts->max_num_pages > 1) : ?>
                  <a href="#" class="showmore-btn w-inline-block">
                    <div>SHOW MORE</div>
                  </a>
                <?php endif; ?>
              </div>
            <?php else : ?>
              <p style="font-size: 20rem; line-height: 30rem; color: #030e14; margin-bottom: 10rem;">There is no news yet</p>
            <?php endif; ?>
          </div>
        </div>
      </section>
    </main>
  </div>
  <?php get_footer(); ?>
  <!--[if lte IE 9]>
<script src="//cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif]-->
  <?php get_template_part("footer_block", ""); ?>
<?php
/*
Template name: Team
*/
?>
<!DOCTYPE html>
<!-- This site was created in Webflow. https://www.webflow.com -->
<!-- Last Published: Wed Jul 13 2022 13:06:33 GMT+0000 (Coordinated Universal Time) -->
<html <?php language_attributes(); ?> data-wf-page="62bc3fe7d9cc61d9bf26159d" data-wf-site="62bc3fe7d9cc6134bf261592">
<?php get_template_part("header_block", ""); ?>

<body <?php body_class("body black-theme"); ?>>
  <?php get_template_part('inc/components/loader'); ?>
  <div class="page-wrapper">
    <?php get_header(); ?>
    <main class="wrapper">
      <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
          <section class="section wf-section">
            <div class="breadcrumbs-line">
              <?php if (function_exists('bcn_display')) {
                bcn_display();
              } ?>
            </div>
          </section>
          <section class="section wf-section">
            <div class="head-fest">
              <h1 class="h1-75-90">
                <?php the_title(); ?>
              </h1>
            </div>
          </section>
          <?php $top_query_args = [
            'post_type'      => 'team',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            // 'orderby' => 'menu_order',
            // 'order' => 'ASC',
            'meta_query'     => [
              [
                'key'   => 'show_on_top',
                'value' => '1'
              ]
            ]
          ];

          $team_top_query = new WP_Query($top_query_args);
          if ($team_top_query->have_posts()) : ?>
            <section class="section wf-section">
              <div class="team-container">
                <div id="w-node-_9f6b2996-04a1-f2cc-7d62-857f070d5ae1-bf26159d" class="div-block-20"></div>
                <div class="team-cms top">
                  <?php while ($team_top_query->have_posts()) : $team_top_query->the_post(); ?>
                    <?php get_template_part('inc/components/team-card-large'); ?>
                  <?php endwhile;
                  wp_reset_postdata(); ?>
                </div>
                <div id="w-node-e85f44ae-829b-cdab-d9ae-0d4a731bd8d6-bf26159d" class="div-block-13"></div>
              </div>
            </section>
          <?php endif; ?>
          <?php $bottom_query_args = [
            'post_type'      => 'team',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            // 'orderby' => 'menu_order',
            // 'order' => 'ASC',
            'meta_query'     => [
              [
                'key'     => 'show_on_top',
                'value'   => '1',
                'compare' => '!='
              ]
            ]
          ];

          $team_bottom_query = new WP_Query($bottom_query_args);
          if ($team_bottom_query->have_posts()) :
          ?>
            <section class="section wf-section">
              <div class="team-container">
                <p class="p-35-45 teamx">
                  <?php echo strip_tags(get_the_content()); ?>
                </p>
                <div class="team-cms bottom">
                  <?php while ($team_bottom_query->have_posts()) : $team_bottom_query->the_post(); ?>
                    <?php get_template_part('inc/components/team-card-small'); ?>
                  <?php endwhile;
                  wp_reset_postdata(); ?>
                </div>
              </div>
            </section>
          <?php endif; ?>
        <?php endwhile; ?>
      <?php endif; ?>
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
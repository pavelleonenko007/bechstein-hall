<?php
/*
Template name: Event
*/
global $post;
?>
<!DOCTYPE html>
<!-- This site was created in Webflow. https://www.webflow.com -->
<!-- Last Published: Wed Jul 13 2022 13:06:33 GMT+0000 (Coordinated Universal Time) -->
<html <?php language_attributes(); ?> data-wf-page="62bc3fe7d9cc618392261598" data-wf-site="62bc3fe7d9cc6134bf261592">
<?php get_template_part("header_block", ""); ?>

<body <?php body_class("body"); ?>>
  <?php wp_body_open(); ?>
  <?php get_template_part('inc/components/loader'); ?>
  <div class="page-wrapper">
    <?php get_header(); ?>
    <main class="wrapper">
      <?php the_post(); ?>
      <section class="section wf-section">
        <div class="head-event-container single-page">
          <div class="head-event-content single-page">
            <?php echo wp_get_attachment_image(get_field('main_image', $post->ID), 'full', false, [
              'class' => 'img-fw mob-cover'
            ]); ?>
            <div class="head-event-content_in">
              <div class="left-event-col left-event">
                <?php if (bech_is_event_sold_out($post->ID)) : ?>
                  <a bgline="2" href="#" class="booktickets-btn sold-out min">
                    <strong>All tickets sold out</strong>
                  </a>
                <?php endif; ?>
                <h1 class="h1-75-90 event-h"><?php the_title(); ?></h1>
                <div class="p-25-40">
                  <?php echo get_post_meta($post->ID, '_bechtix_event_description', true); ?>
                </div>
                <a href="#tickets-mob" bgline="1" class="choisetckets-btn min">
                  <strong>choose tickets</strong>
                </a>
              </div>
              <?php
              $args = [
                'post_type' => 'tickets',
                'post_status' => 'publish',
                'posts_per_page' => 3,
                'meta_key' => '_bechtix_ticket_start_date',
                'orderby' => 'meta_value',
                'order' => 'ASC',
                'meta_query' => [
                  [
                    'key' => '_bechtix_event_relation',
                    'value' => $post->ID,
                    'compare' => '='
                  ]
                ]
              ];

              $tickets_query = new WP_Query($args);
              if ($tickets_query->have_posts()) :
              ?>
                <div class="right-event-col">
                  <?php while ($tickets_query->have_posts()) : $tickets_query->the_post(); ?>
                    <?php get_template_part('inc/components/single-event-ticket'); ?>
                  <?php endwhile;
                  wp_reset_postdata(); ?>
                  <?php if ($tickets_query->max_num_pages > 1) : ?>
                    <a href="#tickets" class="link-20 home">More dates</a>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
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
                  <?php echo wp_get_attachment_image(get_field('author_image', $post->ID), 'full', false, [
                    'class' => 'img-cover'
                  ]); ?>
                </div>
                <div>
                  <div class="p-35-45 no-mpb"><?php the_title(); ?></div>
                  <div class="p-17-25 no-mob"><?php the_content(); ?></div>
                  <div class="cms-li_tags-div in-left">
                    <?php
                    $term_query = wp_get_object_terms($post->ID, ['event_tag', 'genres', 'instruments']);
                    foreach ($term_query as $term) : ?>
                      <a href="<?php echo get_term_link($term->term_id, $term->taxonomy); ?>" class="cms-li_tag-link"><?php echo $term->name ?></a>
                    <?php endforeach;
                    unset($term_query); ?>
                  </div>
                  <div class="p-17-25 italic">
                    <?php echo bech_get_event_duration($post->ID); ?>
                  </div>
                </div>
              </div>
              <?php $args['posts_per_page'] = -1;
              $tickets_query = new WP_Query($args); ?>
              <div class="tikets-pc">
                <?php if ($tickets_query->have_posts()) : ?>
                  <div id="tickets">
                    <?php while ($tickets_query->have_posts()) : $tickets_query->the_post(); ?>
                      <?php get_template_part('inc/components/single-event-ticket-small'); ?>
                    <?php endwhile;
                    wp_reset_postdata(); ?>
                  </div>
                <?php endif; ?>
                <div class="info-right-side-bottom">
                  <?php $tickets_information_link = get_field('tickets_information_url', $post->ID) ? get_field('tickets_information_url', $post->ID) : get_field('tickets_information_url', 'option');

                  $seating_plan_link = get_field('seating_plan_url', $post->ID) ? get_field('tickets_information_url', $post->ID) : get_field('seating_plan_url', 'option');

                  if (trim($tickets_information_link) !== '') : ?>
                    <a href="<?php echo $tickets_information_link; ?>">Tickets information</a>
                  <?php endif; ?>
                  <?php if (trim($seating_plan_link) !== '') : ?>
                    <a href="<?php echo $seating_plan_link; ?>">Seating plan</a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
          <div class="event-row_right-col">
            <?php $content_blocks = get_field('content_blocks');
            if (!empty($content_blocks)) : ?>
              <?php foreach ($content_blocks as $content_block) : ?>
                <?php
                if ($content_block['acf_fc_layout'] === 'dropdowns_block') :
                  continue;
                elseif ($content_block['acf_fc_layout'] === 'alert_block') :
                  $link = $content_block['link'];
                  $link_html = $link['url'] ? '<a href="' . $link['url'] . '">' . $link['link_text'] . '</a>' : '';
                  if ($content_block['text']) : ?>
                    <div class="ui_alert-block w-richtext">
                      <p><?php echo $content_block['text']; ?> <?php echo $link_html; ?></p>
                    </div>
                  <?php endif; ?>
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
                <?php endif; ?>
            <?php endforeach;
            endif;
            ?>
            <?php $festival = get_post_meta($post->ID, '_bechtix_festival_relation', true);
            if (!empty($festival)) : ?>
              <h2 class="h2-35-45"><?php echo get_the_title($festival); ?></h2>
              <a href="<?php echo get_the_permalink($festival); ?>" class="ui-festival-link w-inline-block">
                <?php echo get_the_post_thumbnail($festival, 'large', [
                  'class' => 'ui-festival-link_img'
                ]); ?>
                <div class="ui-festival-link_content">
                  <div><?php echo get_the_title($festival); ?></div>
                  <div><?php echo get_post_meta($festival, '_bechtix_festival_dates', true); ?></div>
                </div>
              </a>
            <?php endif; ?>
            <?php
            if (!empty($content_block)) :
              foreach ($content_blocks as $content_block) : ?>
                <?php if ($content_block['acf_fc_layout'] !== 'dropdowns_block') :
                  continue;
                else : ?>
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
                        <?php echo preg_replace('/<p([^>]+)?>/', '<p$1 class="p-17-25">', $dropdown['dropdown_content']); ?>
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach;
            endif; ?>

            <?php if ($tickets_query->have_posts()) : ?>
              <div id="tickets-mob" class="tikets-mob">
                <?php while ($tickets_query->have_posts()) : $tickets_query->the_post(); ?>
                  <?php get_template_part('inc/components/single-event-ticket-small'); ?>
                <?php endwhile;
                wp_reset_postdata(); ?>
                <?php foreach ($tickets as $ticket) : ?>
                  <div class="events-ticket">
                    <div class="events-ticket_left">
                      <div class="p-17-25 top-ticket _2"><?php echo date('l', strtotime(get_post_meta($ticket->ID, '_bechtix_ticket_start_date', true))); ?></div>
                      <div class="p-20-30 w20 m30"><?php echo date('d F', strtotime(get_post_meta($ticket->ID, '_bechtix_ticket_start_date', true))); ?></div>
                      <div class="p-20-30 w20"><?php echo bech_get_ticket_times($ticket->ID); ?></div>
                    </div>
                    <div class="events-ticket_right">
                      <?php $sale_status = get_post_meta($ticket->ID, '_bechtix_sale_status', true);
                      $sale_statuses = [
                        'No Status',
                        'Few tickets',
                        'Sold out',
                        'Cancelled',
                        'Not scheduled'
                      ];
                      if ($sale_status === '0' || $sale_status === '1' || empty($sale_status)) :

                        $purchase_urls = json_decode(get_post_meta($ticket->ID, '_bechtix_purchase_urls', true), true); ?>
                        <a bgline="1" href="<?php echo $purchase_urls[0]['link']; ?>" data-book-urls="<?php echo _wp_specialchars(wp_json_encode($purchase_urls), ENT_QUOTES, 'UTF-8', true); ?>" class="booktickets-btn min left-side">
                          <strong>Book tickets</strong>
                        </a>
                        <a data-calendar="<?php echo bech_get_ticket_event_data_for_calendar($ticket); ?>" class="event-ticket_calendar-btn min w-inline-block">
                          <img src="<?php echo get_template_directory_uri() ?>/images/62bc3fe7d9cc6162b22615c0_calendar.svg" loading="lazy" alt class="img-calendar">
                          <div>ADD TO CALENDAR</div>
                        </a>
                      <?php else : ?>
                        <a bgline="2" href="#" class="booktickets-btn sold-out min">
                          <strong><?php echo $sale_statuses[$sale_status]; ?></strong>
                        </a>
                      <?php endif; ?>
                    </div>
                  </div>
                <?php endforeach;
                unset($ticket); ?>
                <div class="info-right-side-bottom">
                  <div>Tickets information</div>
                  <div>Seating plan</div>
                </div>
              </div>
            <?php endif; ?>
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
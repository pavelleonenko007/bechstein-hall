<?php
/*
Template name: Whats on - search results
*/
?>
<!DOCTYPE html>
<!-- This site was created in Webflow. https://www.webflow.com -->
<!-- Last Published: Wed Aug 24 2022 15:21:23 GMT+0000 (Coordinated Universal Time) -->
<html <?php language_attributes(); ?> data-wf-page="62503ae70435302bb070be82" data-wf-site="624c5364ec3046603b0a108f">
<?php get_template_part("header_block", ""); ?>

<body <?php body_class("body"); ?>>
  <?php wp_body_open(); ?>
  <?php get_template_part('inc/components/loader'); ?>
  <div class="page-wrapper">
    <?php get_header(); ?>
    <?php
    global $wp_query;
    $event_ids = array_map(function ($event) {
      return $event->ID;
    }, $wp_query->posts);

    $ticket_objects = [];

    if (!empty($event_ids)) {
      $ticket_objects = get_posts([
        'post_type' => 'tickets',
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby' => 'meta_value',
        'meta_key' => '_bechtix_ticket_start_date',
        'order' => 'ASC',
        'meta_query' => [
          [
            'key' => '_bechtix_event_relation',
            'value' => $event_ids,
            'compare' => 'IN'
          ]
        ]
      ]);
    }
    ?>
    <main class="wrapper">
      <section class="section wf-section">
        <div class="search-row">
          <div class="filter-column"></div>
          <div class="search-column">
            <h1 class="h1-75-90 searh">SEARCH RESULTS <span class="search-span"><?php echo count($ticket_objects); ?></span></h1>
            <form method="get" action="<?php echo home_url('/') ?>" class="search w-form">
              <input type="search" class="search0page-line w-input" autofocus="true" maxlength="256" value="<?php echo get_search_query() ?>" name="s" placeholder="search by keyword…" id="search" required>
              <input type="submit" value="Search" class="search-button w-button">
            </form>
            <?php $sorted_tickets = !empty($ticket_objects) ? bech_sort_tickets($ticket_objects) : []; ?>
            <?php if (!empty($sorted_tickets)) : ?>
              <div class="cms-tems">
                <?php foreach ($sorted_tickets as $date => $tickets) : ?>
                  <div class="cms-ul">
                    <div class="cms-heading">
                      <h2 class="h2-cms"><?php echo date('d F', $date); ?></h2>
                      <h2 class="h2-cms day"><?php echo date('l', $date); ?></h2>
                    </div>
                    <div class="cms-ul-events">
                      <?php foreach ($tickets as $ticket) : ?>
                        <?php get_template_part('inc/components/whats-on-ticket', '', [
                          'ticket' => $ticket->ID
                        ]); ?>
                      <?php endforeach; ?>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php else : ?>
              <div class="h2-cms no-events">there's no events</div>
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
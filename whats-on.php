<?php
/*
Template name: What's on
*/
?>

<!DOCTYPE html>

<!-- This site was created in Webflow. https://www.webflow.com -->
<!-- Last Published: Wed Jul 13 2022 13:06:33 GMT+0000 (Coordinated Universal Time) -->
<html <?php language_attributes(); ?> data-wf-page="62bc3fe7d9cc6100802615a2" data-wf-site="62bc3fe7d9cc6134bf261592">

<?php get_template_part("header_block", ""); ?>

<body <?php body_class("body"); ?>>
  <?php get_template_part('inc/components/loader'); ?>
  <div class="page-wrapper">
    <?php get_header(); ?>
    <main class="wrapper">
      <section class="section wf-section">
        <div class="breadcrumbs-line">
          <?php if (function_exists('bcn_display')) bcn_display(); ?>
        </div>
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="catalog-row">
              <div class="filter-column">
                <form data-filter="form" class="filter-styk">
                  <div class="search-filter">
                    <input type="search" value="<?php echo get_search_query() ?>" class="search-line-input w-input" maxlength="256" name="s" placeholder="search by keyword…" id="s" required="" />
                    <input type="submit" value="Search" class="search-line-btn w-button" />
                  </div>
                  <div class="filters-form">
                    <div>
                      <div data-popup="calendar" class="mobile-filter-popup">
                        <div class="mobile-filter-popup__header">
                          <div class="mobile-filter-popup__title">
                            Calendar
                          </div>
                          <button type="button" class="mobile-filter-popup__close">
                            <svg width="32" height="31" viewBox="0 0 32 31" fill="none">
                              <line x1="2.71199" y1="1.43511" x2="30.9963" y2="29.7194" stroke="#030E14" stroke-width="2" />
                              <line x1="1.29289" y1="29.5772" x2="29.5772" y2="1.29289" stroke="#030E14" stroke-width="2" />
                            </svg>
                          </button>
                        </div>
                        <div class="mobile-filter-popup__body">
                          <div class="filters-div">
                            <input class="visually-hidden" name="from" value="<?php echo !empty($_GET['from']) ? $_GET['from'] : ''; ?>" />
                            <input class="visually-hidden" name="to" value="<?php if (!empty($_GET['to'])) echo $_GET['to']; ?>" />

                            <div class="filters-top-div">
                              <div class="p-20-30">Time to go</div>
                              <div id="calendar-widget"></div>
                              <!-- <a href="#" class="calendar-btn w-inline-block">
                                <img src="https://uploads-ssl.webflow.com/62bc3fe7d9cc6134bf261592/62bc3fe7d9cc6162b22615c0_calendar.svg" loading="lazy" alt="" class="img-calendar" />
    
                                <button class="calendar-btn__reset" data-type="reset">✕</button>
                                <div class="calendar-btn__close">Close</div>
                                <div id="filter-calendar" class="filter-calendar"></div>
                              </a> -->
                            </div>
                            <div class="filters-bottom-div">
                              <label class="w-radio cbx-mom">
                                <div class="w-radio-input w-radio-input--inputType-custom cbx"></div>
                                <input type="radio" id="today" name="time" value="today" style="opacity:0;position:absolute;z-index:-1" />
                                <span class="filter-cbx w-form-label" for="today">today</span>
                              </label>
                              <label class="w-radio cbx-mom">
                                <div class="w-radio-input w-radio-input--inputType-custom cbx"></div>
                                <input type="radio" id="tomorrow" name="time" value="tomorrow" style="opacity:0;position:absolute;z-index:-1" />
                                <span class="filter-cbx w-form-label" for="tomorrow">tomorrow</span>
                              </label>
                              <label class="w-radio cbx-mom">
                                <div class="w-radio-input w-radio-input--inputType-custom cbx"></div>
                                <input type="radio" id="weekend" name="time" value="weekend" style="opacity:0;position:absolute;z-index:-1" />
                                <span class="filter-cbx w-form-label" for="weekend">this weekend</span>
                              </label>
                              <label class="w-radio cbx-mom">
                                <div class="w-radio-input w-radio-input--inputType-custom cbx"></div>
                                <input type="radio" id="next-week" name="time" value="next-week" style="opacity:0;position:absolute;z-index:-1" />
                                <span class="filter-cbx w-form-label" for="next-week">next week</span>
                              </label>
                            </div>
                          </div>
                        </div>
                        <a bgline="1" class="booktickets-btn mobile-filter-popup__button">
                          <strong>Show 10 events</strong>
                        </a>
                        <a bgline="1" class="booktickets-btn mobile-filter-popup__clear">
                          <strong>Clear filters</strong>
                        </a>
                      </div>
                      <div data-popup="filters" class="mobile-filter-popup">
                        <div class="mobile-filter-popup__header">
                          <div class="mobile-filter-popup__title">
                            Filters
                          </div>
                          <button type="button" class="mobile-filter-popup__close">
                            <svg width="32" height="31" viewBox="0 0 32 31" fill="none">
                              <line x1="2.71199" y1="1.43511" x2="30.9963" y2="29.7194" stroke="#030E14" stroke-width="2" />
                              <line x1="1.29289" y1="29.5772" x2="29.5772" y2="1.29289" stroke="#030E14" stroke-width="2" />
                            </svg>
                          </button>
                        </div>
                        <div class="mobile-filter-popup__body">
                          <?php $event_tags = bech_get_custom_taxonomies('event_tag');
                          if (!empty($event_tags)) : ?>
                            <div class="filters-div">
                              <div class="filters-top-div">
                                <div class="p-20-30">Event categories</div>
                              </div>
                              <div class="filters-bottom-div">
                                <?php foreach ($event_tags as $index => $event_tag) : ?>
                                  <?php if ($index <= 3) : ?>
                                    <label class="w-checkbox cbx-mom">
                                      <div class="w-checkbox-input w-checkbox-input--inputType-custom cbx"></div>
                                      <input type="checkbox" id="event_tag-<?php echo $event_tag->term_id; ?>" name="event_tag[]" value="<?php echo $event_tag->slug; ?>" style="opacity:0;position:absolute;z-index:-1" />
                                      <span class="filter-cbx ischbx w-form-label" for="event_tag-<?php echo $event_tag->term_id; ?>"><?php echo $event_tag->name; ?></span>
                                    </label>
                                  <?php else : ?>
                                    <label class="w-checkbox cbx-mom hidden-item">
                                      <div class="w-checkbox-input w-checkbox-input--inputType-custom cbx"></div>
                                      <input type="checkbox" id="event_tag-<?php echo $event_tag->term_id; ?>" name="event_tag[]" value="<?php echo $event_tag->slug; ?>" style="opacity:0;position:absolute;z-index:-1" />
                                      <span class="filter-cbx ischbx w-form-label" for="event_tag-<?php echo $event_tag->term_id; ?>"><?php echo $event_tag->name; ?></span>
                                    </label>
                                  <?php endif; ?>
                                <?php endforeach; ?>
                                <?php if (count($event_tags) > 3) : ?>
                                  <button type="button" class="show-all-btn show-all-btn--hide" data-button="show-all-filters" data-taxonomy="<?php echo $event_tags[0]->taxonomy; ?>">show all</button>
                                <?php endif; ?>
                              </div>
                            </div>
                          <?php endif;
                          unset($event_tags); ?>
                          <?php $genres = bech_get_custom_taxonomies('genres');
                          if (!empty($genres)) : ?>
                            <div class="filters-div">
                              <div class="filters-top-div">
                                <div class="p-20-30">Genre</div>
                              </div>
                              <div class="filters-bottom-div">
                                <?php
                                foreach ($genres as $index => $genre) :
                                  if ($index <= 3) : ?>
                                    <label class="w-checkbox cbx-mom">
                                      <div class="w-checkbox-input w-checkbox-input--inputType-custom cbx"></div>
                                      <input data-filter="checkbox" type="checkbox" id="<?php echo $genre->taxonomy . '-' . $genre->term_id; ?>" name="genres[]" value="<?php echo $genre->slug; ?>" <?php if (isset($_GET['genres']) && in_array($genre->slug, $_GET['genres'])) echo 'checked'; ?> style="opacity:0;position:absolute;z-index:-1" />
                                      <span class="filter-cbx ischbx w-form-label" for="<?php echo $genre->taxonomy . '-' . $genre->term_id; ?>"><?php echo $genre->name; ?></span>
                                    </label>
                                  <?php else : ?>
                                    <label class="w-checkbox cbx-mom hidden-item">
                                      <div class="w-checkbox-input w-checkbox-input--inputType-custom cbx"></div>
                                      <input data-filter="checkbox" type="checkbox" id="<?php echo $genre->taxonomy . '-' . $genre->term_id; ?>" name="genres[]" value="<?php echo $genre->slug; ?>" <?php if (isset($_GET['genres']) && in_array($genre->slug, $_GET['genres'])) echo 'checked'; ?> style="opacity:0;position:absolute;z-index:-1" />
                                      <span class="filter-cbx ischbx w-form-label" for="<?php echo $genre->taxonomy . '-' . $genre->term_id; ?>"><?php echo $genre->name; ?></span>
                                    </label>
                                <?php
                                  endif;
                                endforeach;
                                unset($index); ?>
                                <?php if (count($genres) > 3) : ?>
                                  <button type="button" class="show-all-btn show-all-btn--hide" data-button="show-all-filters" data-taxonomy="<?php echo $genres[0]->taxonomy; ?>">show all</button>
                                <?php endif; ?>
                              </div>
                            </div>
                          <?php endif;
                          unset($genres); ?>
                          <?php $instruments = bech_get_custom_taxonomies('instruments');
                          if (!empty($instruments)) : ?>
                            <div class="filters-div">
                              <div class="filters-top-div">
                                <div class="p-20-30">Instruments</div>
                              </div>
                              <div class="filters-bottom-div">
                                <?php foreach ($instruments as $index => $instrument) :
                                  if ($index <= 4) : ?>
                                    <label class="w-checkbox cbx-mom">
                                      <div class="w-checkbox-input w-checkbox-input--inputType-custom cbx"></div>
                                      <input data-filter="checkbox" type="checkbox" id="<?php echo $instrument->taxonomy . '-' . $instrument->term_id; ?>" name="instruments[]" value="<?php echo $instrument->slug; ?>" <?php if (isset($_GET['instruments']) && in_array($instrument->slug, $_GET['instruments'])) echo 'checked'; ?> style="opacity:0;position:absolute;z-index:-1" />
                                      <span class="filter-cbx ischbx w-form-label" for="<?php echo $instrument->taxonomy . '-' . $instrument->term_id; ?>"><?php echo $instrument->name; ?></span>
                                    </label>
                                <?php
                                  endif;
                                endforeach; ?>
                                <?php if (count($instruments) > 5) : ?>
                                  <button type="button" class="show-all-btn" data-button="show-all-filters" data-taxonomy="<?php echo $instruments[0]->taxonomy; ?>">show all</button>
                                <?php endif; ?>
                              </div>
                            </div>
                          <?php endif;
                          unset($instruments); ?>
                          <?php
                          $festivals = bech_get_specials_filters();
                          if (!empty($festivals)) : ?>
                            <div class="filters-div">
                              <div class="filters-top-div">
                                <div class="p-20-30">Specials and Festivals</div>
                              </div>
                              <div class="filters-bottom-div">
                                <?php foreach ($festivals as $festival) : ?>
                                  <label class="w-checkbox cbx-mom">
                                    <div class="w-checkbox-input w-checkbox-input--inputType-custom cbx"></div>
                                    <input type="checkbox" id="festival-<?php echo $festival->ID; ?>" name="festival[]" style="opacity:0;position:absolute;z-index:-1" value="<?php echo $festival->ID; ?>" />
                                    <span class="filter-cbx ischbx w-form-label" for="festival-<?php echo $festival->ID; ?>"><?php echo $festival->post_title; ?></span>
                                  </label>
                                <?php endforeach; ?>
                              </div>
                            </div>
                          <?php endif;
                          unset($festivals);
                          ?>
                        </div>
                        <a bgline="1" class="booktickets-btn mobile-filter-popup__button">
                          <strong>Show 10 events</strong>
                        </a>
                        <a bgline="1" class="booktickets-btn mobile-filter-popup__clear">
                          <strong>Clear filters</strong>
                        </a>
                      </div>
                      <input type="hidden" name="paged" value="1" />
                      <input type="hidden" name="action" value="get_filtered_tickets">
                      <?php wp_nonce_field('bech_filter_nonce_action', 'bech_filter_nonce'); ?>
                      <input type="submit" value="Submit" data-wait="Please wait..." class="hidden-input w-button" />
                    </div>
                  </div>
                </form>
              </div>
              <div class="catalog-column">
                <h1 class="h1-75-90"><?php the_title(); ?></h1>
                <div class="mobile-filters">
                  <a data-popup="calendar" class="calendar-btn w-inline-block">
                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none">
                      <rect x="0.5" y="1" width="23" height="23" rx="1.5" stroke="#030E14" />
                      <rect x="1" y="1.5" width="22" height="6" fill="#030E14" />
                      <path d="M9.24651 19.2793C10.9841 19.2793 12.1501 18.2619 12.1501 16.8215C12.1501 15.4726 11.087 14.5467 9.50943 14.5467C9.18935 14.5467 8.89213 14.5924 8.64064 14.661C10.0238 13.9294 11.4871 13.255 11.4871 12.0775C11.4871 11.1859 10.7554 10.5 9.6809 10.5C8.80068 10.5 6.45725 11.4602 6.45725 12.4776C6.45725 12.832 6.69731 13.0721 7.02882 13.0721C7.90904 13.0721 7.47464 11.7117 8.10337 11.1973C8.332 11.003 8.58349 10.9458 8.84641 10.9458C9.52086 10.9458 10.0353 11.5174 10.0353 12.2604C10.0353 13.2778 9.31509 14.1237 7.77186 15.004C8.18339 14.9125 8.49204 14.8668 8.78925 14.8668C9.90952 14.8668 10.664 15.667 10.664 16.7987C10.664 18.079 9.88666 18.9135 8.75496 18.9135C8.37772 18.9135 8.00049 18.8335 7.77186 18.6963C7.12027 18.319 7.50894 16.7301 6.583 16.7301C6.24006 16.7301 6 16.9816 6 17.3474C6 18.2276 8.08051 19.2793 9.24651 19.2793Z" fill="#030E14" />
                      <path d="M13.3763 19.1421H17L15.9255 18.5134V10.5L13.0676 11.4831L14.4965 11.9289V18.5134L13.3763 19.1421Z" fill="#030E14" />
                    </svg>
                    Calendar
                  </a>
                  <a data-popup="filters" class="calendar-btn w-inline-block">
                    Filters
                    <svg width="7" height="13" viewBox="0 0 7 13" fill="none">
                      <path d="M3.585 0.929999V9.855L0.78 8.91L3.765 12.27L6.735 8.91L3.93 9.855V0.929999H3.585Z" fill="#030E14" />
                    </svg>
                  </a>
                </div>
                <?php $selected_filter_string = bech_get_selected_filters_string($_GET); ?>
                <div id="selected-filters" class="filters-line-text <?php echo !empty($selected_filter_string) ? 'filters-line-text--active' : ''; ?>">
                  <div>you choose &#x27;<span data-filter="choosen"><?php echo $selected_filter_string; ?></span>’ in filters.</div><a id="clear" href="#" class="clearfilter-btn"> clear filters</a>
                </div>
                <div id="tickets-container" class="cms-tems">
                  <?php
                  $events_args = [
                    'post_type' => 'events',
                    'post_status' => 'publish',
                    'numberposts' => -1,
                    'fields' => 'ids',
                  ];

                  if (!empty($_GET['genres'])) {
                    $events_args['tax_query'][] = [
                      'taxonomy' => 'genres',
                      'field'    => 'slug',
                      'terms'    => $_GET['genres']
                    ];
                  }

                  if (!empty($_GET['instruments'])) {
                    $events_args['tax_query'][] = [
                      'taxonomy' => 'instruments',
                      'field'    => 'slug',
                      'terms'    => $_GET['instruments']
                    ];
                  }

                  $event_ids = new WP_Query($events_args);

                  if (empty($event_ids)) : ?>
                    <p class="no-event-message">There is no events — we're working on a concert program.</p>
                    <?php else :
                    $tickets_args = [
                      'post_type' => 'tickets',
                      'post_status' => 'publish',
                      'posts_per_page' => 10,
                      'orderby' => 'meta_value',
                      'meta_key' => '_bechtix_ticket_start_date',
                      'order' => 'ASC',
                      'meta_query' => [
                        [
                          'key' => '_bechtix_event_relation',
                          'value' => $event_ids->posts,
                          'compare' => 'IN'
                        ]
                      ]
                    ];

                    if (!empty($_GET['from'])) {
                      $dt = new DateTime($_GET['from']);
                      $tickets_args['meta_query'][] = [
                        'key'     => '_bechtix_ticket_start_date',
                        'value'   => $dt->format('Y-m-d H:i:s'),
                        'compare' => '>=',
                        'type'    => 'DATETIME'
                      ];
                    }

                    if (!empty($_GET['to'])) {
                      $dt = new DateTime($_GET['to']);
                      $tickets_args['meta_query'][] = [
                        'key'     => '_bechtix_ticket_start_date',
                        'value'   => $dt->format('Y-m-d H:i:s'),
                        'compare' => '<=',
                        'type'    => 'DATETIME'
                      ];
                    }

                    $tickets_query = new WP_Query($tickets_args);
                    $tickets = $tickets_query->posts;

                    $sorted_tickets = bech_sort_tickets($tickets);

                    foreach ($sorted_tickets as $date => $tickets) : ?>
                      <div class="cms-ul">
                        <div class="cms-heading">
                          <h2 class="h2-cms"><?php echo date('d F Y', $date); ?></h2>
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
                  <?php endforeach;
                  endif; ?>
                </div>
                <div data-type="load_more" data-max-pages="<?php echo $tickets_query->max_num_pages; ?>" style="width: 100%; height: 0px; background: green"></div>
              </div>
            </div>
        <?php endwhile;
        endif; ?>
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
<?php
global $post;
$post = !empty($args['ticket']) ? get_post($args['ticket']) : $post;
$event = get_post(get_post_meta($post->ID, '_bechtix_event_relation', true));
$purchase_urls = get_post_meta($post->ID, '_bechtix_purchase_urls', true);
$purchase_urls_normal = json_decode($purchase_urls, true);
$benefits_json = get_post_meta($post->ID, '_bechtix_ticket_benefits', true);
$benefits = _wp_specialchars($benefits_json, ENT_QUOTES, 'UTF-8', true);
$online_sale_start = get_post_meta($post->ID, '_bechtix_ticket_online_sale_start', true);
$is_priority_booking_time = bech_is_priority_booking_time($post->ID);

// var_dump($is_priority_booking_time);

$event_image = bech_get_whats_on_ticket_image($event->ID);
$sale_status = get_post_meta($post->ID, '_bechtix_sale_status', true);

/**
 * 
 * Ticket statuses:
 * 
 *  1. Canceled [3]
 *  2. Sold Out [2]
 *  3. Not Scheduled [4]
 *  4. None [0]
 *   4.1. Priority Booking
 *   4.2. Free sales
 *    4.2.1. Few tickets [1]
 */
?>
<div class="cms-li" data-ticket_benefits="<?php echo $benefits; ?>">
  <?php if (!empty($event_image)) : ?>
    <a href="<?php echo get_the_permalink($event->ID); ?>" class="cms-li_mom-img">
      <?php echo $event_image; ?>
      <?php
      if ($sale_status === '2' || $sale_status === '3') :
      ?>
        <div class="cms-li_sold-out-banner"><?php echo bech_get_sale_status_string_value($sale_status); ?></div>
      <?php endif; ?>
    </a>
  <?php endif; ?>
  <div class="cms-li_content">
    <div class="cms-li_time-div">
      <div class="p-30-45"><?php echo bech_get_ticket_times($post->ID); ?></div>
      <div class="p-17-25 italic"><?php echo bech_get_event_duration($event->ID); ?></div>
    </div>
    <a href="<?php echo get_the_permalink($event->ID); ?>" class="p-20-30 title-event"><?php echo get_the_title($post); ?> <?php echo $post->ID; ?></a>
    <div class="p-17-25"><?php echo get_post_meta($event->ID, '_bechtix_event_description', true); ?></div>
    <div class="cms-li_tags-div">
      <?php $tags = wp_get_object_terms($event->ID, ['event_tag', 'genres', 'instruments']);
      foreach ($tags as $index => $tag) :
        if ($index <= 4) : ?>
          <a class="cms-li_tag-link"><?php echo $tag->name; ?></a>
      <?php endif;
      endforeach; ?>
    </div>
    <div class="cms-li_actions-div">
      <?php
      if ($sale_status === '' || $sale_status === '0' || $sale_status === '1' || $sale_status === '4') :
        if ($is_priority_booking_time) : ?>
          <a bgline="1" class="booktickets-btn priority">
            <strong>priority booking only</strong>
          </a>
        <?php endif; ?>
        <a bgline="1" href="<?php echo $purchase_urls_normal[0]['link']; ?>" class="booktickets-btn <?php echo $is_priority_booking_time ? 'none' : ''; ?>">
          <strong>Book tickets</strong>
        </a>
      <?php else : ?>
        <a bgline="2" href="#" class="booktickets-btn sold-out">
          <strong><?php echo bech_get_sale_status_string_value($sale_status); ?></strong>
        </a>
      <?php endif; ?>
      <a href="<?php echo get_the_permalink($event->ID); ?>" class="readmore-btn w-inline-block">
        <div>read more</div>
        <div> →</div>
      </a>
    </div>
    <?php if ($sale_status === '' || $sale_status === '0' || $sale_status === '4') : ?>
      <?php if ($is_priority_booking_time) : ?>
        <div class="cms-li_price">free sales from <?php echo date('j F', strtotime($online_sale_start)); ?></div>
      <?php endif; ?>
      <div class="cms-li_price <?php echo $is_priority_booking_time ? 'none' : ''; ?>"><?php echo bech_get_ticket_from_to_price($post->ID); ?></div>
    <?php elseif ($sale_status === '1') : ?>
      <div class="cms-li_price" style="color: #B47171;"><?php echo bech_get_sale_status_string_value($sale_status); ?></div>
    <?php endif; ?>
  </div>
  <div class="cms-li_actions-div biger">
    <?php
    if ($sale_status === '' || $sale_status === '0' || $sale_status === '1' || $sale_status === '4') :
      if ($is_priority_booking_time) : ?>
        <a bgline="1" class="booktickets-btn priority">
          <strong>priority booking only</strong>
        </a>
      <?php endif; ?>
      <a bgline="1" href="<?php echo $purchase_urls_normal[0]['link']; ?>" class="booktickets-btn <?php echo $is_priority_booking_time ? 'none' : ''; ?>">
        <strong>Book tickets</strong>
      </a>
    <?php else : ?>
      <a bgline="2" href="#" class="booktickets-btn sold-out">
        <strong><?php echo bech_get_sale_status_string_value($sale_status); ?></strong>
      </a>
    <?php endif; ?>
    <?php if ($sale_status === '' || $sale_status === '0' || $sale_status === '4') : ?>
      <?php if ($is_priority_booking_time) : ?>
        <div class="cms-li_price">free sales from <?php echo date('j F', strtotime($online_sale_start)); ?></div>
      <?php endif; ?>
      <div class="cms-li_price <?php echo $is_priority_booking_time ? 'none' : ''; ?>"><?php echo bech_get_ticket_from_to_price($post->ID); ?></div>
    <?php elseif ($sale_status === '1') : ?>
      <div class="cms-li_price" style="color: #B47171;"><?php echo bech_get_sale_status_string_value($sale_status); ?></div>
    <?php endif; ?>
  </div>
</div>
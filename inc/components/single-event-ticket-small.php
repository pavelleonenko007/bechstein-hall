<?php
global $post;

$ticket = !empty($args['ticket']) ? get_post($args['ticket']) : $post;
$ticket_start_date_unix = strtotime(get_post_meta($ticket->ID, '_bechtix_ticket_start_date', true));
$sale_status = get_post_meta($ticket->ID, '_bechtix_sale_status', true);
$purchase_urls = bech_get_purchase_urls($ticket->ID);
?>

<div class="events-ticket">
  <div class="events-ticket_left">
    <div class="p-17-25 top-ticket _2"><?php echo date('l', $ticket_start_date_unix); ?></div>
    <div class="p-20-30 w20 m30"><?php echo date('d F', $ticket_start_date_unix); ?></div>
    <div class="p-20-30 w20"><?php echo bech_get_ticket_times($ticket->ID); ?></div>
  </div>
  <div class="events-ticket_right">
    <?php if ($sale_status === '0' || $sale_status === '1' || empty($sale_status)) : ?>
      <a bgline="1" href="<?php echo $purchase_urls[0]['link']; ?>" data-book-urls="<?php echo bech_get_purchase_urls_attribute($ticket->ID); ?>" target="_blank" class="booktickets-btn min left-side">
        <strong>Book tickets</strong>
      </a>
      <a href="#" data-calendar="<?php echo bech_get_ticket_event_data_for_calendar($ticket); ?>" class="event-ticket_calendar-btn min w-inline-block">
        <!-- <img src="<?php echo get_template_directory_uri() ?>/images/62bc3fe7d9cc6162b22615c0_calendar.svg" loading="lazy" alt class="img-calendar"> -->
        <div>ADD TO CALENDAR</div>
      </a>
    <?php else : ?>
      <a bgline="2" href="#" class="booktickets-btn sold-out min">
        <strong><?php echo bech_get_sale_status_string_value($sale_status); ?></strong>
      </a>
    <?php endif; ?>
  </div>
</div>
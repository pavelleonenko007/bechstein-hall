<?php
global $post;

$ticket = !empty($args['ticket']) ? get_post($args['ticket']) : $post;
$ticket_start_date_unix = strtotime(get_post_meta($ticket->ID, '_bechtix_ticket_start_date', true));
$sale_status = get_post_meta($ticket->ID, '_bechtix_sale_status', true);
$purchase_urls = bech_get_purchase_urls($ticket->ID);

$can_buy_ticket = $sale_status === '0' || $sale_status === '1' || empty($sale_status);
$is_in_waiting_list = (bool) get_post_meta($ticket->ID, '_bechtix_in_waiting_list', true);

//TODO: date_default_timezone_get(), date_default_timezone_set();
?>


<div class="events-ticket">
  <div class="events-ticket_left">
    <div class="p-17-25 top-ticket"><?php echo date('l', $ticket_start_date_unix); ?></div>
    <div class="p-20-30"><?php echo date('d F', $ticket_start_date_unix); ?></div>
    <div class="p-20-30 w20"><?php echo bech_get_ticket_times($ticket->ID); ?></div>
  </div>
  <div class="events-ticket_right<?php echo $can_buy_ticket ? '' : ' events-ticket_right--disabled'; ?>">
    <?php if ($can_buy_ticket) : ?>
      <a bgline="1" href="<?php echo $purchase_urls[0]['link']; ?>" data-book-urls="<?php echo bech_get_purchase_urls_attribute($ticket->ID); ?>" class="booktickets-btn min">
        <strong>Book tickets</strong>
      </a>
      <a href="#" data-calendar="<?php echo bech_get_ticket_event_data_for_calendar($ticket); ?>" class="event-ticket_calendar-btn w-inline-block">
        <div>ADD TO CALENDAR</div>
      </a>
    <?php else : ?>
			<?php if ($is_in_waiting_list): ?>
				<a bgline="1" href="<?php echo $purchase_urls[0]['link']; ?>" data-book-urls="<?php echo bech_get_purchase_urls_attribute($ticket->ID); ?>" class="booktickets-btn min">
					<strong>Join Waiting List</strong>
				</a>
			<?php else: ?>
				<a bgline="2" href="#" class="booktickets-btn sold-out min">
					<strong><?php echo bech_get_sale_status_string_value($sale_status); ?></strong>
				</a>
			<?php endif; ?>
    <?php endif; ?>
  </div>
</div>
<a href="<?php the_permalink(); ?>"
   class="ui-pressrelease-a w-inline-block"
   data-content="query_item">
    <div class="p-20-30 w20"><?php echo get_the_date( get_option( 'date_format' ) ); ?></div>
    <div class="p-25-40 mar13"><?php the_title(); ?></div>
</a>
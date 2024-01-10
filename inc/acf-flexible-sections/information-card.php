<?php
//global $args;
$card = $args['card-info']; ?>

<a href="<?php echo $card['link']; ?>"
   class="ui-yourvisit w-inline-block">
    <div class="ui-yourvisit_mom-div">
		<?php echo wp_get_attachment_image( $card['image']['ID'], 'large', false, [
			'class' => "img-cover"
		] ); ?>
    </div>
    <div class="ui-yourvisit_content">
        <div class="p-35-45 w40"><?php echo $card['header']; ?></div>
        <div class="p-17-25 mar13"><?php echo $card['description']; ?></div>
    </div>
</a>

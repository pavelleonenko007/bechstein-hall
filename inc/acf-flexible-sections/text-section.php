<?php
$title   = $args['title'];
$content = $args['content'];
?>

<div class="ui-boxoffice-block">
    <div class="text-block-ui">
		<?php if ( ! empty( $title ) ): ?>
            <h2 class="h2-35-45">
				<?php echo $title; ?>
            </h2>
		<?php endif; ?>
		<?php if ( ! empty( $content ) ): ?>
            <div class="p-17-25 mar20 w-richtext">
				<?php echo $content; ?>
            </div>
		<?php endif; ?>
    </div>
    <div class="t-line fw"></div>
</div>

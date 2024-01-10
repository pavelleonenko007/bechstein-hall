<?php
$text_blockquote = $args['blockquote'];
if ( ! empty( $text_blockquote ) ): ?>
	<div class="ui-boxoffice-block">
		<div class="text-block-ui bloq1">
			<div class="p-17-25-2 w-richtext">
				<?php echo $text_blockquote; ?>
			</div>
		</div>
	</div>
<?php endif;

<?php
$blockquote = $args['blockquote']; ?>

<div class="ui-boxoffice-block">
	<div class="text-block-ui bloq2">
		<?php echo wp_get_attachment_image($blockquote['image']['ID'], 'large', false, [
			'class' => 'image-5'
		]); ?>
		<div class="bloq-right">
			<blockquote class="block-quote p-17-25 bloq2">
				<?php echo $blockquote['quote_text']; ?>
			</blockquote>
			<div class="text-block-7">
				<?php echo $blockquote['author']; ?>
			</div>
			<div class="html-embed-5 w-embed">
				<svg width="25" height="17" viewbox="0 0 25 17" fill="none"
				     xmlns="http://www.w3.org/2000/svg">
					<path d="M5.03906 12.7761L8.49506 16.2321L11.8791 12.7761L8.49506 9.39207L11.8791 0.752071L11.4471 0.320068L5.03906 12.7761ZM14.1831 12.7761L17.6391 16.2321L21.0231 12.7761L17.6391 9.39207L21.0231 0.752071L20.6631 0.320068L14.1831 12.7761Z"
					      fill="#030E14"></path>
				</svg>
			</div>
		</div>
	</div>
</div>

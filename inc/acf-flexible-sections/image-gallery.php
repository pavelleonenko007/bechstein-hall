<?php
$gallery = $args['gallery'];
?>

<div class="ui-boxoffice-block">
	<?php if ( ! empty( $gallery ) ): ?>
        <div class="images-grid">
			<?php foreach ( $gallery as $gallery_image ): ?>
                <a href="#"
                   id="w-node-b48eefdc-4051-7d04-ab37-51fc79556990-e526159f"
                   class="link-grid w-inline-block w-lightbox">
					<?php echo wp_get_attachment_image( $gallery_image['image']['ID'], 'large', false, [
						'class' => 'img-cover'
					] ); ?>
                    <script type="application/json" class="w-json">
														<?php
						$item = $gallery_image['image'];
						if ( isset( $item['url'] ) ) {
							$image_url = $item['url'];
						} elseif ( is_numeric( $item ) ) {
							$image_url = wp_get_attachment_image_url( $item, 'full' );
						} else {
							$image_url = $item;
						}
						$items   = array();
						$items[] = [
							'url'     => $image_url,
							'type'    => 'image',
							'caption' => isset( $item['caption'] ) ? $item['caption'] : ''
						];
						echo json_encode( [
							'group' => 'parent_id',
							'items' => $items
						], JSON_UNESCAPED_SLASHES );
						?>

                    </script>
                </a>
			<?php endforeach; ?>
        </div>
	<?php endif; ?>
</div>

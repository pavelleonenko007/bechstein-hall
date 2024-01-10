<?php
$title = $args['title'];
$tabs  = $args['tabs'];
?>
<div class="ui-boxoffice-block">
    <div class="div-block-23">
        <h2 class="h2-35-45">
			<?php echo $title; ?>
        </h2>
		<?php if ( ! empty( $tabs ) ): ?>
            <div class="payment-tabs">
                <div data-current="Tab 0" data-easing="ease" data-duration-in="300"
                     data-duration-out="100" class="tabs w-tabs">
                    <div class="tabs-menu w-tab-menu">
						<?php foreach (
							$tabs
							as $index => $tab
						): ?>
                            <a data-w-tab="Tab <?php echo $index; ?>"
                               class="tab-payments w-inline-block w-tab-link <?php if ( $index === 0 ) {
								   echo 'w--current';
							   } ?>">
                                <div><?php echo $tab['tab_header']; ?></div>
                            </a>
						<?php endforeach; ?>
                    </div>
                    <div class="tabs-content w-tab-content">
						<?php foreach ( $tabs as $index => $tab ): ?>
                            <div data-w-tab="Tab <?php echo $index; ?>"
                                 class="w-tab-pane <?php if ( $index === 0 ) {
								     echo 'w--tab-active';
							     } ?>">
                                <div class="rich w-richtext">
									<?php echo $tab['tab_description']; ?>
                                </div>
                            </div>
						<?php endforeach; ?>
                    </div>
                </div>
            </div>
		<?php endif; ?>
    </div>
    <div class="t-line fw"></div>
</div>

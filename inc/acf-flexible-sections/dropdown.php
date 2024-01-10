<?php
$dropdown = $args['dropdown']; ?>

<div class="ui-drop-container">
	<div class="ui-drop-container_btn">
		<div class="p-20-30 med w20">
			<?php echo $dropdown['dropdown_header']; ?>
		</div>
		<div class="ui-drop-container_ico-mom">
			<div class="ui-drop-container_ico-mom_down">→</div>
			<div class="ui-drop-container_ico-mom_top">→</div>
		</div>
	</div>
	<div class="ui-drop-container_content">
		<p class="p-17-25">
			<?php echo $dropdown['text']; ?>
		</p>
	</div>
</div>

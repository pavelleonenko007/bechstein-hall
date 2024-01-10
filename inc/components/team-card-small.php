<?php
global $post;
?>

<div class="ui-big-man_left-col small">
	<div class="ui-big-man_left-col_mom-img small">
		<?php the_post_thumbnail('large', [
			'class' => 'img-cover'
		]); ?>
	</div>
	<div class="ui-big-man_left-col_content-block small">
		<div class="p-35-45 team-name">
			<?php the_title(); ?>
		</div>
		<div class="p-17-25 op05">
			<?php echo get_field( 'job_title' ) ?>
		</div>
	</div>
</div>

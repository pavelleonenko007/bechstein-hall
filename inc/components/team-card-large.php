<?php
global $post;

$instagram = get_field('instagram');
$facebook = get_field('facebook');
$spotify = get_field('spotify_url');
?>

<div class="ui-big-man_left-col med">
	<div class="ui-big-man_left-col_mom-img med">
		<?php the_post_thumbnail('large', [
			'class' => 'img-cover'
		]); ?>
	</div>
	<div class="ui-big-man_left-col_content-block small">
		<div class="p-35-45 team-name">
			<?php the_title(); ?>
		</div>
		<div class="p-17-25 op05">
			<?php echo get_field('job_title') ?>
		</div>
		<div class="div-block-12">
			<?php if (!empty($instagram)) : ?>
				<a rel="nofollow" href="<?php echo esc_url($instagram); ?>" target="_blank" class="p-17-25 italic link-color">Instagram</a>
			<?php endif; ?>
			<?php if (!empty($facebook)) : ?>
				<a rel="nofollow" href="<?php echo esc_url($facebook); ?>" target="_blank" class="p-17-25 italic link-color">Facebook</a>
			<?php endif; ?>
			<?php if (!empty($spotify)) : ?>
				<a rel="nofollow" href="<?php echo esc_url($spotify); ?>" target="_blank" class="p-17-25 italic link-color">Spotify</a>
			<?php endif; ?>
		</div>
		<p class="p-20-30 people-p">
			<?php echo strip_tags(get_the_content()); ?>
		</p>
	</div>
</div>
<?php wp_footer(); ?>
<?php if (file_exists(dirname(__FILE__) . '/mailer.php')) {
	include_once 'mailer.php';
} ?>
<?php if (function_exists('the_field')) {
	the_field('footer_code', 'option');
} ?>
<?php if (file_exists(dirname(__FILE__) . '/footer_code.php')) {
	include_once 'footer_code.php';
} ?>
</body>

</html>
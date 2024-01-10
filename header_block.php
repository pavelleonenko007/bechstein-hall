<head>
		<meta charset="utf-8">
		<meta content="width=device-width, initial-scale=1" name="viewport">
	<meta name="format-detection" content="telephone=no">
		<!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js" type="text/javascript"></script><![endif]-->
		<script type="text/javascript">!function(o,c){var n=c.documentElement,t=" w-mod-";n.className+=t+"js",("ontouchstart"in o||o.DocumentTouch&&c instanceof DocumentTouch)&&(n.className+=t+"touch")}(window,document);</script>
		<style>
  
  .body.menuopen{}

  .body.menuopen{overflow:hidden}

  .burger-menu{display:block; opacity: 0; transition: all 300ms ease; pointer-events:none;
    width: 100vw;}
  
  .body.menuopen .burger-menu{display:block; opacity: 1;pointer-events:all}
  
		
		</style>
		<script id="query_vars">
    var query_vars =
        '<?php global $wp_query; echo serialize($wp_query->query) ?>';
		</script>
		<?php wp_head(); ?>
		<?php if(function_exists('the_field')) { the_field('head_code', 'option'); } ?>
		<?php if(file_exists(dirname( __FILE__ ).'/header_code.php')){ include_once 'header_code.php'; } ?>
	</head>
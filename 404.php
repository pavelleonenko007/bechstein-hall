<?php
/*
Template name: 404
*/
?>
<!DOCTYPE html>
<!-- Last Published: Fri Dec 02 2022 11:52:38 GMT+0000 (Coordinated Universal Time) -->
<html <?php language_attributes(); ?> data-wf-page="6388ceed2a3f48a2e778a58a" data-wf-site="624c5364ec3046603b0a108f">
<?php get_template_part("header_block", ""); ?>

<body <?php body_class("body black-theme"); ?>>
    <?php get_template_part('inc/components/loader'); ?>
    <?php get_header(); ?>
    <main class="wrapper _404wrp">
        <section class="section _404sec wf-section"><img src="<?php echo get_template_directory_uri() ?>/images/6389e34cc8b193e1e31538a7_img-min-p-1600.png" loading="lazy" alt class="image-7">
            <div class="div-block-25">
                <div class="_404txt">404</div>
                <div class="text-block-9">page not found</div>
                <a href="<?php echo home_url('/'); ?>" class="link-20 white _404-page">go to main page</a>
            </div>
        </section>
    </main>
    <!--[if lte IE 9]><script src="//cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif]-->
    <script>
        let headwidth;

        $(".b-menu").click(function() {

            headwidth = $(".navbar").width();
            console.log(headwidth);
            $(".header").css({
                "max-width": headwidth
            });

            if ($(".body").hasClass("menuopen"))

            {
                $(".body").removeClass("menuopen");
                $(".navbar").removeClass("grey-head");
            } else

            {
                $(".body").addClass("menuopen");
                $(".navbar").addClass("grey-head");
            }

        });



        document.addEventListener("DOMContentLoaded", function() {
            function reportWindowSize() {
                headwidth = $(".navbar").width();
                console.log(headwidth);
                $(".header").css({
                    "max-width": headwidth
                });
            }

            window.onresize = reportWindowSize;
        });
    </script>
    <?php get_template_part("footer_block", ""); ?>
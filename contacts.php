<?php
/*
Template name: Contacts
*/
?>
<!DOCTYPE html>
<!-- This site was created in Webflow. https://www.webflow.com -->
<!-- Last Published: Wed Jul 13 2022 13:06:33 GMT+0000 (Coordinated Universal Time) -->
<html <?php language_attributes(); ?> data-wf-page="62bc3fe7d9cc61f84a261597" data-wf-site="62bc3fe7d9cc6134bf261592">
<?php get_template_part("header_block", ""); ?>

<body <?php body_class("body"); ?>>
    <?php get_template_part('inc/components/loader'); ?>
    <div class="page-wrapper">
        <?php get_header(); ?>
        <main class="wrapper">
            <section class="section wf-section">
                <div class="breadcrumbs-line">
                    <?php if (function_exists('bcn_display')) bcn_display(); ?>
                </div>
                <div class="catalog-row m-revert cont">
                    <?php if (have_posts()) : ?>
                        <?php while (have_posts()) : the_post(); ?>
                            <div class="filter-column vis">
                                <div class="marer"></div>
                                <?php $sidebar_contacts = get_field('sidebar_contacts');
                                if (!empty($sidebar_contacts)) : ?>
                                    <div class="cont-styk">
                                        <?php foreach ($sidebar_contacts as $sidebar_contact) : ?>
                                            <div class="cont-line">
                                                <div class="p-35-45 w40">
                                                    <?php echo $sidebar_contact['contact_header']; ?>
                                                </div>
                                                <a href="<?php echo 'mailto:' . $sidebar_contact['contact_text']; ?>" class="p-20-30 w20">
                                                    <?php echo $sidebar_contact['contact_text']; ?>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="catalog-column cont">
                                <h1 class="h1-75-90 cont-h">
                                    <?php the_title(); ?>
                                </h1>
                                <div class="p-25-40 cont">
                                    <?php echo get_field('address') ?>
                                </div>
                                <div class="p-25-40 cont">
                                    <?php echo get_field('telephone') ?>
                                </div>
                                <div class="map-embe w-embed">
                                    <?php echo do_shortcode(get_field('map_html_code')) ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </section>
        </main>
        <?php get_footer(); ?>
    </div>
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
<?php
/* Template Name: Add post page */

acf_form_head();
get_header();
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

        <?php
        while ( have_posts() ) :
            the_post();

            get_template_part( 'template-parts/content', 'page' );

        endwhile; // End of the loop.
        ?>

        <?php
            acf_form(array(
                'post_id'       => 'new_user_post',
                'field_groups' => array( 4691 ),
                'form'               => true,
                'submit_value'      => 'Submit Your News',
                'updated_message'    => 'Added!'
            ));
        ?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php

get_footer();

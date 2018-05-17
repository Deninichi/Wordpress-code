<?php

/**
 * Add a custom numeric pagination for posts.
 */
function custom_posts_numeric_pagination( $query ) {

    $wp_query = $query;

    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;

    $paged = get_query_var( 'page' ) ? absint( get_query_var( 'page' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );

    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;

    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    ob_start(); ?>

    <div class="blog-navigation d-flex align-items-center align-items-stretch">
        <div class="pagination-wrapper">
            <ul class="pagination list-inline">
                <?php
                    /** Link to first page, plus ellipses if necessary */
                    if ( ! in_array( 1, $links ) ) {
                        $class = 1 == $paged ? ' active' : '';

                        printf( '<li class="page-item %s"><a class="page-link" href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

                        if ( ! in_array( 2, $links ) )
                            echo '<li>…</li>';
                    }

                    /** Link to current page, plus 2 pages in either direction if necessary */
                    sort( $links );
                    foreach ( (array) $links as $link ) {
                        $class = $paged == $link ? ' active' : '';
                        printf( '<li class="page-item %s"><a class="page-link" href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
                    }

                    /** Link to last page, plus ellipses if necessary */
                    if ( ! in_array( $max, $links ) ) {
                        if ( ! in_array( $max - 1, $links ) )
                            echo '<li>…</li>' . "\n";

                        $class = $paged == $max ? ' active' : '';
                        printf( '<li class="page-item %s"><a class="page-link" href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
                    }
                ?>
            </ul>
        </div>
        <div class="next-prev-wrapper d-flex align-items-center">
            <?php previous_posts_link( '<i class="fal fa-angle-left icon-left"></i>', $wp_query->max_num_pages ); ?>
            <?php next_posts_link( '<i class="fal fa-angle-right icon-right"></i>', $wp_query->max_num_pages ); ?>
        </div>
    </div>

    <?php

    $html = ob_get_contents();
    ob_clean();

    echo $html;

}
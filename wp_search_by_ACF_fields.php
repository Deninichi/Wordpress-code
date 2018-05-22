<?php

/**
 * List of ACF fields
 * @return Array
 */
function get_acf_search_fields(){

    $list_searcheable_acf = array(
        "direktutbetalning", 
        "utan_uc", 
        "helgutbetalning", 
        "med_laginkomst", 
        "oppet_nu", 
        "med_betalningsanmarkning", 
        "med_skulder", 
        "18-20_ar"
    );

    return $list_searcheable_acf;

}


/**
 * Custom search using ACF checkboxes. Show post if checkbox enabled
 * @param  String      $where    "Where" part of the search query
 * @param  Object      $wp_query WP_Query loop
 * @return String      $where    Customized "where" part od SQL request
 */
function acf_custom_search( $where, &$wp_query ) {
    global $wpdb;

    if ( empty( $where ) )
        return $where;

    // reset search in order to rebuilt it as we whish
    $where = '';

    // get ACF fields
    $searcheable_acf_fields = get_acf_search_fields();

    $where .= "
      AND (
        EXISTS (
          SELECT * FROM wp_postmeta
              WHERE post_id = wp_posts.ID";

    $where .= " AND (";
    $where .= " ( meta_key LIKE '%p_rackvidd_max%'  AND meta_value >= ".$_GET['loanRange']." )";

    foreach ( $searcheable_acf_fields as $field ) :
        if ( isset( $_GET[$field] ) ) {
            $where .= " OR (meta_key LIKE '%" . $field . "%' AND meta_value LIKE '%yes%') ";
        }
    endforeach;

    $where .= ")
        )
    )";

    return $where;
}
add_filter( 'posts_search', 'acf_custom_search', 99, 2 );
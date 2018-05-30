<?php

/**
 * Back-end creation of new news post
 * @uses Advanced Custom Fields Pro
 */
add_filter('acf/pre_save_post' , 'pdsw_do_pre_save_post' );
function pdsw_do_pre_save_post( $post_id ) {

    // check if this is to be a new post
    if( $post_id != 'new_user_post' ) {
        return $post_id;
    }

    if( empty($_POST['acf']) ) {
        return $post_id;
    }

    // Create a new post
    $post = array(
        'post_type'     => 'post',
        'post_status'   => 'draft',
        'post_title'    => $_POST['acf']['field_5b0bca1069204'],
        'post_content'  => $_POST['acf']['field_5b0bcaf8b9f45'],
        'post_excerpt'  => $_POST['acf']['field_5b0bcaecb9f44'],
    );

    // insert the post
    $post_id = wp_insert_post( $post );

    update_field( 'np_author', $_POST['acf']['field_5b0bcb05b9f46'], $post_id );
    update_field( 'np_event_date', $_POST['acf']['field_5b0bcb0fb9f47'], $post_id );
    update_field( 'np_call_to_action', $_POST['acf']['field_5b0bcb46b9f48'], $post_id );
    update_field( 'np_name', $_POST['acf']['field_5b0bcb6fb9f4a'], $post_id );
    update_field( 'np_organisation', $_POST['acf']['field_5b0bcb81b9f4b'], $post_id );
    update_field( 'np_phone', $_POST['acf']['field_5b0bcb89b9f4c'], $post_id );
    update_field( 'np_email', $_POST['acf']['field_5b0bcb95b9f4d'], $post_id );
    update_field( 'np_contact_details_are_visible', $_POST['acf']['field_5b0bcba3b9f4e'], $post_id );
    update_field( 'np_video_title', $_POST['acf']['field_5b0bcbc8b9f50'], $post_id );
    update_field( 'np_video_image', $_POST['acf']['field_5b0bcbe3b9f51'], $post_id );
    update_field( 'np_video_link', $_POST['acf']['field_5b0bcbfbb9f52'], $post_id );
    update_field( 'np_file_1_title', $_POST['acf']['field_5b0bcc20b9f54'], $post_id );
    update_field( 'np_file_1', $_POST['acf']['field_5b0bcc3fb9f55'], $post_id );
    update_field( 'np_file_2_title', $_POST['acf']['field_5b0bcc65b9f56'], $post_id );
    update_field( 'np_file_2', $_POST['acf']['field_5b0bcc70b9f57'], $post_id );
    update_field( 'np_file_3_title', $_POST['acf']['field_5b0bcc81b9f58'], $post_id );
    update_field( 'np_file_3', $_POST['acf']['field_5b0bcc92b9f59'], $post_id );

    // Save the fields to the post
    do_action( 'acf/save_post' , $post_id );
    return $post_id;
}
<?php

    /**
     * Filter for post type by taxonomy in the admin panel
     *
     * @since    1.0.0
     *
     * @param      array $columns    Array with default columns
     * @return     array
     */
    function  shows_custom_filter() {
        $type = 'post';
        if ( isset( $_GET['post_type'] ) ) {
            $type = $_GET['post_type'];
        }

        //only add filter to post type you want
        if ('ANY_POST_TYPE' == $type){

            $types = get_terms( 'show_type', array(
                'hide_empty' => false,
            ) );

            ?>
            <select name="_show_type_filter">
            <option value=""><?php _e('Filter By Type', 'pdsw-utilities'); ?></option>
            <?php
                $current_value = isset( $_GET['_show_type_filter'] ) ? $_GET['_show_type_filter'] : '';

                foreach ( $types as $type ) {
                    printf
                        (
                            '<option value="%s"%s>%s</option>',
                            $type->term_id,
                            $type->term_id == $current_value? ' selected="selected"':'',
                            $type->name
                        );
                    }
            ?>
            </select>
            <?php
        }

    }
    add_action( 'restrict_manage_posts', 'shows_custom_filter' );


    /**
     * Query filter for post type by taxonomy in the admin panel
     *
     * @since    1.0.0
     *
     * @param      array $columns    Array with default columns
     * @return     array
     */
    function shows_custom_filter_query( $query ){

        global $pagenow;

        $type = 'post';
        if ( isset( $_GET['post_type'] ) ) {
            $type = $_GET['post_type'];
        }

        if ( 'ANY_POST_TYPE' == $type && is_admin() && $pagenow=='edit.php' ) {

            // Filter by Type
            if( isset( $_GET['_show_type_filter'] ) && $_GET['_show_type_filter'] != '' ){
                $tax_query = $query->get('tax_query');

                $tax_query[] = array(
                        'taxonomy'     => 'show_type',
                        'field' => 'id',
                        'terms'    => array( $_GET['_show_type_filter'] ),
                );

                // Set the meta query to the complete, altered query
                $query->set( 'tax_query', $tax_query );
            }

        }
    }
    add_filter( 'parse_query', 'shows_custom_filter_query' );
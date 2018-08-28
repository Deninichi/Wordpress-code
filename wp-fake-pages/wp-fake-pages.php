<?php

/**
 * Helper class for office functions.
 *
 * @class FLOffices
 */
final class FLOffices {

    private $my_fake_pages = array(
        'office' => 'Office'
    );
    

    public function __construct(){
        add_filter( 'rewrite_rules_array', array( $this, 'fl_office_rules' ) );
        add_filter( 'query_vars', array( $this, 'fl_office_query' ) );

        add_filter( 'template_include', array( $this, 'fl_include_template' ), 90, 1 );
    }

    // Adding fake pages' rewrite rules
    function fl_office_rules($rules)
    {

        $newrules = array();
        foreach ( $this->my_fake_pages as $slug => $title ){
            $newrules[ $slug . '/([^/]*)/?' ] = 'index.php?fpage=' . $slug . '&office_id=$matches[1]';
        }

        return $newrules + $rules;
    }

    // Tell WordPress to accept our custom query variable
    function fl_office_query( $vars )
    {
        array_push( $vars, 'fpage' );
        array_push( $vars, 'office_id' );
        return $vars;
    }



    function fl_include_template($template){
        
        if( get_query_var('fpage') ){
            
            $new_template = WP_CONTENT_DIR.'/themes/bb-theme-child/single-office.php';
            if( file_exists($new_template ) ){
                $template = $new_template;
            }
        }
        return $template;
    }

}

$office = new FLOffices();
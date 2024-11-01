<?php
/**
 * Plugin Name: Socius Marketing Page Taxonomy
 * Plugin URI: http://sociusmarketing.com
 * Description: Adds custom taxonomies for product categories and areas served. Be sure to update your permalinks after activation.
 * Version: 1.1.14
 * Author: Socius Marketing
 * Author URI: http://sociusmarketing.com
 * License: GPL2
 */

/* Runs when plugin is activated */
register_activation_hook(__FILE__,'smct_plugin_install'); 

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'smct_plugin_remove' );

/* Create Archive pages for categories and areas served */
require_once plugin_dir_path( __FILE__ ) . '/inc/archive-pages.php';

/* Sets up custom taxonomy structure */
require_once plugin_dir_path( __FILE__ ) . '/inc/taxonomies.php';

/* Link State names to stateface font glyph */
require_once plugin_dir_path( __FILE__ ) . '/inc/stateface.php';

/* Sets up admin options page */
require_once plugin_dir_path( __FILE__ ) . '/inc/options-page.php';

function smct_admin_style() { //Hides hierarchical dropdown for Custom Categories
    if ( is_admin() ) {
          wp_enqueue_style('admin-styles', plugins_url('css/admin-styles.css', __FILE__ ) );
          wp_enqueue_style('admin-options-styles', plugins_url('css/admin-options.css', __FILE__) );
    }
}
add_action('admin_enqueue_scripts', 'smct_admin_style');

function smct_style() { //Add custom styles to plugin pages
    wp_enqueue_style('smct-styles', plugins_url('css/styles.min.css', __FILE__) );
}
add_action('wp_enqueue_scripts', 'smct_style');


function smct_plugin_install() {

    global $wpdb;

    //Check if desired page slugs are in use
    $existing_category_page = get_posts( array(
        'name'      => 'categories',
        'post_type' => 'page'
    ) );
    if( $existing_category_page == NULL ) {
        $smct_category_page_name = 'categories';
    } else {
        $smct_category_page_name = 'categories-2';
    }

    $existing_area_page = get_posts( array(
        'name'      => 'areas-served',
        'post_type' => 'page'
    ) );
    if( $existing_area_page == NULL ) {
        $smct_area_page_name = 'areas-served';
    } else {
        $smct_area_page_name = 'areas-served-2';
    }

    $smct_category_page_title = 'Categories';
    $smct_area_page_title = 'Areas Served';

    // the menu entry...
    delete_option("smct_category_page_title");
    add_option("smct_category_page_title", $smct_category_page_title, '', 'yes');
    delete_option("smct_area_page_title");
    add_option("smct_area_page_title", $smct_area_page_title, '', 'yes');
    // the slug...
    delete_option("smct_category_page_name");
    add_option("smct_category_page_name", $smct_category_page_name, '', 'yes');
    delete_option("smct_area_page_name");
    add_option("smct_area_page_name", $smct_area_page_name, '', 'yes');
    // the id...
    delete_option("smct_category_page_id");
    add_option("smct_category_page_id", '0', '', 'yes');
    delete_option("smct_area_page_id");
    add_option("smct_area_page_id", '0', '', 'yes');

    $smct_category_page = get_post( get_option('smct_category_page_id') );
    $smct_area_page = get_post( get_option('smct_area_page_id') );

    if ( ! $smct_category_page ) {

        // Create post object
        $_p = array();
        $_p['post_title'] = $smct_category_page_title;
        $_p['post_content'] = "This text may be overridden by the plugin. You shouldn't edit it.";
        $_p['post_status'] = 'publish';
        $_p['post_type'] = 'page';
        $_p['comment_status'] = 'closed';
        $_p['ping_status'] = 'closed';
        $_p['post_category'] = array(1); // the default 'Uncategorized'

        // Insert the post into the database
        $smct_category_page_id = wp_insert_post( $_p );

    }
    else {
        // the plugin may have been previously active and the page may just be trashed...

        $smct_category_page_id = $smct_category_page->ID;

        //make sure the page is not trashed...
        $smct_category_page->post_status = 'publish';
        $smct_category_page_id = wp_update_post( $smct_category_page );

    }


    if ( ! $smct_area_page ) {

        // Create post object
        $_a = array();
        $_a['post_title'] = $smct_area_page_title;
        $_a['post_content'] = "This text may be overridden by the plugin. You shouldn't edit it.";
        $_a['post_status'] = 'publish';
        $_a['post_type'] = 'page';
        $_a['comment_status'] = 'closed';
        $_a['ping_status'] = 'closed';
        $_a['post_category'] = array(1); // the default 'Uncategorized'

        // Insert the post into the database
        $smct_area_page_id = wp_insert_post( $_a );

    }
    else {
        // the plugin may have been previously active and the page may just be trashed...

        $smct_area_page_id = $smct_area_page->ID;

        //make sure the page is not trashed...
        $smct_area_page->post_status = 'publish';
        $smct_area_page_id = wp_update_post( $smct_area_page );

    }

    delete_option( 'smct_category_page_id' );
    add_option( 'smct_category_page_id', $smct_category_page_id );
    delete_option( 'smct_area_page_id' );
    add_option( 'smct_area_page_id', $smct_area_page_id );

    flush_rewrite_rules();
}

function smct_plugin_remove() {

    global $wpdb;

    $smct_category_page_title = get_option( "smct_category_page_title" );
    $smct_category_page_name = get_option( "smct_category_page_name" );
    $smct_area_page_title = get_option( "smct_area_page_title" );
    $smct_area_page_name = get_option( "smct_area_page_name" );

    //  the id of our page...
    $smct_category_page_id = get_option( 'smct_category_page_id' );
    if( $smct_category_page_id ) {

        wp_delete_post( $smct_category_page_id ); // this will trash, not delete

    }
    $smct_area_page_id = get_option( 'smct_area_page_id' );
    if( $smct_area_page_id ) {

        wp_delete_post( $smct_area_page_id ); // this will trash, not delete

    }

    delete_option("smct_category_page_title");
    delete_option("smct_category_page_name");
    delete_option("smct_category_page_id");

    delete_option("smct_area_page_title");
    delete_option("smct_area_page_name");
    delete_option("smct_area_page_id");

}

function smct_plugin_add_settings_link( $links ) {
    $settings_link = '<a href="options-general.php?page=smct-options">' . __( 'Settings' ) . '</a>';
    array_unshift( $links, $settings_link );
    return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'smct_plugin_add_settings_link' );

 

function smct_dashboard_widget() {
    global $wp_meta_boxes;
    wp_add_dashboard_widget('smct_custom_widget', 'Custom Taxonomies', 'smct_custom_dashboard');
}

function smct_custom_dashboard() {
    if( count(get_terms('smct_cats')) == 1 ) { $cats_term = 'Category'; } else { $cats_term = 'Categories'; }
    echo '<p><span class="dashicons dashicons-images-alt2"></span><a href="edit-tags.php?taxonomy=smct_cats&post_type=page"> ' . count(get_terms('smct_cats')) . ' Custom ' . $cats_term . '</a>';
    echo '<p><span class="dashicons dashicons-location"></span><a href="edit-tags.php?taxonomy=smct_areas&post_type=page"> ' . count(get_terms('smct_areas')) . ' Areas Served</a></p>';
    echo '<p><a href="' . get_permalink(get_option( 'smct_category_page_id' )) . '" class="button">View Categories page</a></p>';
    echo '<p><a href="' . get_permalink(get_option( 'smct_area_page_id' )) . '" class="button">View Areas Served page</a></p>';
}
add_action('wp_dashboard_setup', 'smct_dashboard_widget');


function smct_set_posts_per_page_for_archives( $query ) {
    $smct_paginate = get_option('smct_paginate_archives');
    if(is_array($smct_paginate) && $smct_paginate[0] !== 'yes') {
      if ( !is_admin() && $query->is_main_query() && is_tax('smct_cats') ) {
        $query->set( 'posts_per_page', '-1' );
      }
      if ( !is_admin() && $query->is_main_query() && is_tax('smct_areas') ) {
        $query->set( 'posts_per_page', '-1' );
      }
    }
}
add_action( 'pre_get_posts', 'smct_set_posts_per_page_for_archives' );


function smct_custom_css_output() {
    $output='<style>'.get_option('smct_custom_css').'</style>';
    echo $output;
}
add_action('wp_head','smct_custom_css_output');


//Parent Category Toggler function
//thanks to Ben Lobaugh - http://wordpress.org/extend/plugins/parent-category-toggler/
function smct_parent_toggler() {
    
    $taxonomies = apply_filters('smct_parent_toggler',array());
    for($x=0;$x<count($taxonomies);$x++)
    {
        $taxonomies[$x] = '#'.$taxonomies[$x].'div .selectit input';
    }
    $selector = implode(',',$taxonomies);
    if($selector == '') $selector = '.selectit input';
    
    echo '
        <script>
        jQuery("'.$selector.'").change(function(){
            var $chk = jQuery(this);
            var ischecked = $chk.is(":checked");
            $chk.parent().parent().siblings().children("label").children("input").each(function(){
var b = this.checked;
ischecked = ischecked || b;
})
            checkParentNodes(ischecked, $chk);
        });
        function checkParentNodes(b, $obj)
        {
            $prt = findParentObj($obj);
            if ($prt.length != 0)
            {
             $prt[0].checked = b;
             checkParentNodes(b, $prt);
            }
        }
        function findParentObj($obj)
        {
            return $obj.parent().parent().parent().prev().children("input");
        }
        </script>
        ';
    
}
add_action('admin_footer-post.php', 'smct_parent_toggler');
add_action('admin_footer-post-new.php', 'smct_parent_toggler');
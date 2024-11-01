<?php 
add_action( 'init', 'smct_cptui_register_my_taxes_categories' );
function smct_cptui_register_my_taxes_categories() {
	$labels = array(
		"name" => __( 'Custom Categories', '' ),
		"singular_name" => __( 'Custom Category', '' ),
		);

    $category_page_id = get_option( 'smct_category_page_id' );
    $category_page = get_post($category_page_id); 
	$category_page_slug = $category_page ? $category_page->post_name : '';
	if(get_option( 'smct_custom_category_archive_slug' ) !='') { 
		$categories_slug = get_option( 'smct_custom_category_archive_slug' ); 
	} else { 
		$categories_slug = $category_page_slug; 
	} 

	$args = array(
		"label" => __( 'Custom Categories', '' ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => true,
		"label" => "Custom Categories",
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => $categories_slug, 'with_front' => false, ),
		"show_admin_column" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"show_in_quick_edit" => true,
	);
	register_taxonomy( "smct_cats", array( "page" ), $args );

// End smct_cptui_register_my_taxes_categories()
}

add_action( 'init', 'smct_cptui_register_my_taxes_areas' );
function smct_cptui_register_my_taxes_areas() {
	$labels = array(
		"name" => __( 'Areas Served', '' ),
		"singular_name" => __( 'Area Served', '' ),
		"add_new_item" => __( 'Add New Location', '' ),
		);
    $areas_page_id = get_option( 'smct_area_page_id' );
    $areas_page = get_post($areas_page_id); 
	$areas_page_slug = $areas_page ? $areas_page->post_name : '';
	if(get_option( 'smct_custom_areas_archive_slug' ) !='') { 
		$areas_slug = get_option( 'smct_custom_areas_archive_slug' ); 
	} else { 
		$areas_slug = $areas_page_slug; 
	} 
	$args = array(
		"label" => __( 'Areas Served', '' ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => true,
		"label" => "Areas Served",
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => $areas_slug, 'with_front' => false, ),
		"show_admin_column" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"show_in_quick_edit" => true,

	);
	register_taxonomy( "smct_areas", array( "page" ), $args );

// End smct_cptui_register_my_taxes_areas()
}
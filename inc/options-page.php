<?php 
/* Custom Plugin Admin Page */
class smct_admin_options {
    public function __construct() {
        // Hook into the admin menu
        add_action( 'admin_menu', array( $this, 'smct_create_plugin_settings_page' ) );
        // Add Settings and Fields
        add_action( 'admin_init', array( $this, 'smct_setup_sections' ) );
        add_action( 'admin_init', array( $this, 'smct_setup_fields' ) );
    }
    public function smct_create_plugin_settings_page() {
        // Add the menu item and page
        $page_title = 'Custom Taxonomy Options';
        $menu_title = 'Custom Taxonomy';
        $capability = 'manage_options';
        $slug = 'smct-options';
        $callback = array( $this, 'smct_plugin_settings_page_content' );
        //Add submenu page under Settings
        add_submenu_page( 'options-general.php', $page_title, $menu_title, $capability, $slug, $callback );
    }
    public function smct_plugin_settings_page_content() {?>
        <div id="smct_options_page" class="wrap">
            <h1>Custom Taxonomy Options</h1>
            <p>This plugin creates 2 pages that serve as the top-level archives. These pages are initially named 'Categories' and 'Areas Served'.</p>
            <p>If you would like to customize these names, simply edit their title/slug in the Pages section and update your permalinks. Changing the page slugs will also update the slug of the archive child pages. For example, changing '/areas-served/' to '/locations/' will also update '/locations/florida/'.</p>  
            <p>If you would like the archive slug to be different than the page name, you can enter custom names in the boxes below.</p>
            <form method="POST" action="options.php">
                <?php
                    settings_fields( 'smct-options' );
                    do_settings_sections( 'smct-options' );
                    submit_button();
                ?>
            </form>
        </div> <?php
    }
    
    public function smct_setup_sections() {
        add_settings_section( 'smct_section_one', 'Custom Slug Names', array( $this, 'section_callback' ), 'smct-options' );
        add_settings_section( 'smct_section_two', 'Display Options', array( $this, 'section_callback' ), 'smct-options' );
        add_settings_section( 'smct_section_three', 'Theme Overrides', array( $this, 'section_callback' ), 'smct-options' );
        //add_settings_section( 'smct_section_four', 'Advanced Custom Fields', array( $this, 'section_callback' ), 'smct-options' );
    }
    public function section_callback( $arguments ) {
        switch( $arguments['id'] ){
            case 'smct_section_one':
                //echo 'This is the first description here!';
                break;
            case 'smct_section_two':
                //echo 'This one is number two';
                break;
            case 'smct_section_three':
                break;
            //case 'smct_section_four':
                //echo '<p>If you are using an ACF custom field to alter the displayed page title, enter its field name here.</p>';
                //break;
        }
    }
    public function smct_setup_fields() {
        $post1 = get_option( 'smct_category_page_id' ) ? get_post(get_option( 'smct_category_page_id' )) : null;
        $post2 = get_option( 'smct_area_page_id' ) ? get_post(get_option( 'smct_area_page_id' )) : null;
        
        $category_page_name = $post1 ? $post1->post_name : '';
        $areas_served_page_name = $post2 ? $post2->post_name : '';
        
        $fields = array(
            array(
                'uid' => 'smct_custom_category_archive_slug',
                'label' => 'Custom Category Archive Slug',
                'section' => 'smct_section_one',
                'type' => 'text',
                'placeholder' => $category_page_name,
                'helper' => '',
                'supplimental' => 'Make sure to update permalinks after saving changes.',
                'default' => $category_page_name,
            ),
            array(
                'uid' => 'smct_custom_areas_archive_slug',
                'label' => 'Custom Areas Served Archive Slug',
                'section' => 'smct_section_one',
                'type' => 'text',
                'placeholder' => $areas_served_page_name,
                'helper' => '',
                'supplimental' => 'Make sure to update permalinks after saving changes.',
                'default' => $areas_served_page_name,
            ),
            array(
                'uid' => 'smct_display_page_titles',
                'label' => 'Display Page Titles in the Content?',
                'section' => 'smct_section_two',
                'type' => 'radio',
                'options' => array(
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'default' => array('yes'),
            ),
            array(
                'uid' => 'smct_category_display_layout',
                'label' => 'Display Images in Category Archive?',
                'section' => 'smct_section_two',
                'type' => 'radio',
                'options' => array(
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
                'default' => array('yes'),
            ),
            array(
                'uid' => 'smct_page_title_source',
                'label' => 'Use Default WordPress Title Instead of Headlines?',
                'section' => 'smct_section_two',
                'type' => 'radio',
                'options' => array(
                    'no' => 'No',
                    'yes' => 'Yes',
                ),
                'default' => array('no'),
            ),
            array(
                'uid' => 'smct_paginate_archives',
                'label' => 'Paginate Archive Pages?',
                'section' => 'smct_section_two',
                'type' => 'radio',
                'options' => array(
                    'no' => 'No',
                    'yes' => 'Yes',
                ),
                'default' => array('no'),
            ),
            array(
                'uid' => 'smct_width_of_pages',
                'label' => 'Width of Archive Pages?',
                'section' => 'smct_section_two',
                'type' => 'radio',
                'options' => array(
                    'full-width' => 'Full-Width',
                    'sidebar' => 'Content & Sidebar',
                ),
                'supplimental' => 'The width of the Categories/Areas Served parent page is determined by your default page template.<br/>This setting will affect the archive list so that you can seamlessly match your layout.',
                'default' => array('full-width'),
            ),
            array(
                'uid' => 'smct_archive_container_class',
                'label' => 'CSS Class for Archive Width',
                'section' => 'smct_section_two',
                'type' => 'text',
                'placeholder' => '',
                'supplimental' => 'If displaying a sidebar in the option above, enter the class name that controls the width of your main content.',
                'default' => '',
            ),
            array(
                'uid' => 'smct_number_of_columns',
                'label' => 'Category Thumbnail Display Size ',
                'section' => 'smct_section_two',
                'type' => 'radio',
                'options' => array(
                    '4wide' => '4 Across',
                    '3wide' => '3 Across',
                ),
                'default' => array('4wide'),
            ),
            array(
                'uid' => 'smct_custom_css',
                'label' => 'Custom CSS',
                'section' => 'smct_section_three',
                'type' => 'textarea',
                'placeholder' => '',
                'default' => '',
            ),
            // array(
            //     'uid' => 'smct_alternate_page_title',
            //     'label' => 'Alternate Page Title Field Name',
            //     'section' => 'smct_section_four',
            //     'type' => 'text',
            //     'placeholder' => '',
            //     'default' => '',
            // ),
        );
        foreach( $fields as $field ){
            add_settings_field( $field['uid'], $field['label'], array( $this, 'smct_field_callback' ), 'smct-options', $field['section'], $field );
            register_setting( 'smct-options', $field['uid'] );
        }
    }
    public function smct_field_callback( $arguments ) {
        $value = get_option( $arguments['uid'] );
        if( ! $value ) {
            $value = $arguments['default'];
        }
        switch( $arguments['type'] ){
            case 'text':
            case 'password':
            case 'number':
                printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', $arguments['uid'], $arguments['type'], $arguments['placeholder'], $value );
                break;
            case 'textarea':
                printf( '<textarea name="%1$s" id="%1$s" placeholder="%2$s" rows="5" cols="50">%3$s</textarea>', $arguments['uid'], $arguments['placeholder'], $value );
                break;
            case 'select':
            case 'multiselect':
                if( ! empty ( $arguments['options'] ) && is_array( $arguments['options'] ) ){
                    $attributes = '';
                    $options_markup = '';
                    foreach( $arguments['options'] as $key => $label ){
                        $options_markup .= sprintf( '<option value="%s" %s>%s</option>', $key, selected( $value[ array_search( $key, $value, true ) ], $key, false ), $label );
                    }
                    if( $arguments['type'] === 'multiselect' ){
                        $attributes = ' multiple="multiple" ';
                    }
                    printf( '<select name="%1$s[]" id="%1$s" %2$s>%3$s</select>', $arguments['uid'], $attributes, $options_markup );
                }
                break;
            case 'radio':
            case 'checkbox':
                if( ! empty ( $arguments['options'] ) && is_array( $arguments['options'] ) ){
                    $options_markup = '';
                    $iterator = 0;
                    foreach( $arguments['options'] as $key => $label ){
                        $iterator++;
                        $options_markup .= sprintf( '<label for="%1$s_%6$s"><input id="%1$s_%6$s" name="%1$s[]" type="%2$s" value="%3$s" %4$s /> %5$s</label><br/>', 
                            $arguments['uid'], 
                            $arguments['type'], 
                            $key, 
                            checked( $value[ array_search( $key, $value, true ) ], $key, false ),
                            $label, 
                            $iterator );
                    }
                    printf( '<fieldset>%s</fieldset>', $options_markup );
                }
                break;
                exit;
        }
        if(isset($arguments['helper']) && $arguments['helper'] != "" ) {
            if( $helper = $arguments['helper'] ){
                printf( '<span class="helper"> %s</span>', $helper );
            }
        }
        if(isset($arguments['supplimental']) && $arguments['supplimental'] != "" ) {
            if( $supplimental = $arguments['supplimental'] ){
                printf( '<p class="description">%s</p>', $supplimental );
            }
        }
    }
}
new smct_admin_options();
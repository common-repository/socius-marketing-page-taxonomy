<?php 
// Grab the first content image
function smct_grab_first_image() {
  	global $post, $posts;
	$first_img = '';
	ob_start();
	ob_end_clean();

	// Attempt to get image ID from classes then grab URL with wp_get_attachment_image_src
	$first_image_classes = preg_match('/<img.+class=[\'"](?P<class>.+?)[\'"].*>/i', $post->post_content, $image_classes);
	$image_class_array = isset($image_classes['class']) && $image_classes['class'] ? explode(' ', $image_classes['class']) : array();
	$image_id = false;
	foreach( $image_class_array as $class ) {
		if( strpos($class, 'wp-image-') !== false ) {
			$image_id = str_replace('wp-image-', '', $class);
		}
	}
	if( $image_id ) {
		$first_img = wp_get_attachment_image_src($image_id, "medium_large")[0];
	}
	
	// If no image URL found for the image ID then grab the src of the image
	if( empty($first_img) || !$first_img ) {
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		if (isset($matches[1][0])) { $first_img = $matches[1][0]; }
	}

	// If no first image, check for a featued image
	if(empty($first_img)){
		if(has_post_thumbnail()) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "medium_large"); 
			$first_img = $image[0];
		} 
	}
  return $first_img;
}

function smct_grab_first_image_for_categories() {
  global $post, $posts;
	  $first_img = '';
	  ob_start();
	  ob_end_clean();
	  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	  if (isset($matches[1][0])) { $first_img = $matches[1][0]; }

	  if(empty($first_img)){ //Defines a default image
	  	if(has_post_thumbnail()) {
	  		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "medium_large"); 
	  		$first_img = $image[0];
			if( isset($_GET['dev']) ) {
				var_dump($image);
				die();
			}
	  	} elseif(category_description() !== '' ) {
	  		$content = category_description();
	  		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
	  		if (isset($matches[1][0])) { $first_img = $matches[1][0]; }
	  	} else {
    		$first_img = plugins_url('images/default.jpg', dirname(__FILE__) );
    	}
	  }
  return $first_img;
}

// Build Category Archive Page
function smct_category_content($content) {

	if(!preg_match('/\<!--\s*Module:Wysiwyg\s*--\>/i', $content)
    && get_the_ID() == get_option( 'smct_category_page_id' ) ) {

    $terms = get_terms( 'smct_cats', array(
	    'orderby'    => 'name',
	) );

	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		$content = '<div id="smct-category-archive">';

		$title_option = get_option('smct_display_page_titles');
        if( $title_option[0] !== 'no') {
		  $content .= '<h1>Articles</h1>';
        }
	    foreach ( $terms as $term ) {

					$cats_page_args = array(

					    'post_type' => 'page',
					    'order' => 'DESC',
					    'child_of' => get_the_ID(),
					    'taxonomy' => 'smct_cats',
			            'term' => $term->slug
					);

					$the_query = new WP_Query($cats_page_args);
					$i = 0;
					if( $the_query->have_posts() ) {
					  while ($the_query->have_posts() ) { 
					  	$the_query->the_post();
					  	if( smct_grab_first_image_for_categories() ) {
				  			if($i < 1 ) {
					  			$first_image = smct_grab_first_image_for_categories();
							  		if (strpos($first_image, 'default') !== false) {
							  			$cat_content = category_description($term->term_id);
								  		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $cat_content, $matches);
								  		if (isset($matches[1][0])) { $first_image = $matches[1][0]; }
									} else {
									    //use default image
							  		}
						  			$i++;
						  		}
						  	}
						}
					}
					wp_reset_postdata();

				$smct_number_of_columns = get_option('smct_number_of_columns');
				$display_images = get_option('smct_category_display_layout');
			  	if($display_images[0] == 'no') {
			  		$width = 'smct-col-xs-12 smct-category smct-list';
			  	} elseif($smct_number_of_columns[0] == '3wide') {
                    $width = 'smct-col-md-4 smct-col-sm-6 smct-category';
                } else {
                    $width = 'smct-col-md-3 smct-col-sm-6 smct-category';
                }

			    $content .= '<div id="smct-' . $term->slug . '" class="'. $width .'">';
			        $content .= '<h3><a href="' . esc_url( get_term_link( $term ) ) . '"><span class="smct-image-wrap" style="background-image:url(' . $first_image . ')"></span>' . $term->name . '</a></h3>';
			    $content .= '</div>';
		    }
		$content .= '</div><!-- end #smct-category-archive -->';
	} else {
		$content = '<div id="post-0" class="post error404 not-found">';
			$content .= '<h1 class="entry-title">No Entries</h1>';
			$content .= '<div class="entry-content">';
				$content .= '<p>Apologies, but no results were found for the requested archive.</p>';
			$content .= '</div><!-- .entry-content -->';
		$content .= '</div><!-- #post-0 -->';
	}

	} 
	return $content;

}

add_filter('the_content', 'smct_category_content');


// Build Areas Served Archive Page
function smct_area_content($content) {

	if(!preg_match('/\<!--\s*Module:Wysiwyg\s*--\>/i', $content)
    && get_the_ID() == get_option( 'smct_area_page_id' )) { 

	    $terms = get_terms( 'smct_areas', array(
		    'orderby'    => 'name',
		    'parent'	 => 0
		) );
			
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			$content = '<div id="smct-area-archive">';

			$title_option = get_option('smct_display_page_titles');
	        if( $title_option[0] !== 'no') {
	    		$content .= '<h1>Areas Served</h1>';
	        }

			$smct_number_of_columns = get_option('smct_number_of_columns');
		    if($smct_number_of_columns[0] == '3wide') {
		        $width = 'smct-col-md-4 smct-col-sm-6 smct-col-xs-12';
		    } else {
		        $width = 'smct-col-md-3 smct-col-sm-6 smct-col-xs-12';
		    }

		    $usa_count = 0;
		    $top = '';
		    $bottom = '';
			foreach ( $terms as &$term ) {
				$international_locations = array('africa','asia','australia','canada','caribbean','central-america','europe','mexico','middle-east','south-america','united-states');
				if(in_array($term->slug, $international_locations) ) {
					$term->international = 1;
				    $top .= '<div id="smct-' . $term->slug . '" class="' . $width . ' smct-state">';
				    	$top .= '<h3><a href="' . esc_url( get_term_link( $term ) ) . '">' . smct_determine_stateface($term->slug) . $term->name . '</h3></a>';
				    $top .= '</div>';
				} else {
					$term->international = 0;
					$bottom .= '<div id="smct-' . $term->slug . '" class="' . $width . ' smct-state">';
				   		$bottom .= '<h3><a href="' . esc_url( get_term_link( $term ) ) . '">' . smct_determine_stateface($term->slug) . $term->name . '</h3></a>';
				    $bottom .= '</div>';
				}
				if($term->slug == 'united-states') { $usa_count = $term->count; }
			}

			if(!empty($top)) {
				$content .= '<h3>International</h3>';
				$content .= '<div class="smct-row">';
					$content .= $top;
				$content .= '</div>';
			}
			if(!empty($top) && $usa_count < 1) {
				$content .= '<h3>United States</h3>';
			}
			if($usa_count < 1) {
				$content .= '<div class="smct-row">';
					$content .= $bottom;
				$content .= '</div>';
			}

			$content .= '</div><!-- end #smct-area-archive -->';

		} else {
			$content = '<div id="post-0" class="post error404 not-found">';
				$content .= '<h1 class="entry-title">No Entries</h1>';
				$content .= '<div class="entry-content">';
					$content .= '<p>Apologies, but no results were found for the requested archive.</p>';
				$content .= '</div><!-- .entry-content -->';
			$content .= '</div><!-- #post-0 -->';
		}

	} 

	return $content;

}

add_filter('the_content', 'smct_area_content');


// Customize the Wordpress Archive page in case the theme does not do so
function smct_get_category_post_type_template( $archive_template ) {
     global $post;

     if ( (is_archive() && is_tax('smct_cats')) || (is_archive() && is_tax('smct_areas')) ) {
          $archive_template = dirname( __FILE__ ) . '/template-archive.php';
     }
     return $archive_template;
}

add_filter( 'archive_template', 'smct_get_category_post_type_template' ) ;




// Customize the Excerpt for Archive pages
function smct_excerpt_length( $length ) {
	return 60;
}
add_filter( 'excerpt_length', 'smct_excerpt_length' );

function smct_auto_excerpt_more( $more ) {
	return ''; 
}
add_filter( 'excerpt_more', 'smct_auto_excerpt_more' );


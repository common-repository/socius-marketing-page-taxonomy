<?php
/**
 * The template for displaying the custom Archive pages.
 */

get_header(); ?>
<?php $smct_page_width = get_option('smct_width_of_pages'); 
	if(get_option('smct_archive_container_class')) { $smct_container_width = get_option('smct_archive_container_class'); } else { $smct_container_width = ''; }
?>
		<div id="container" class="<?php echo $smct_container_width; ?>">
			<div id="smct_content" role="main">

<?php
	/* Queue the first post, that way we know
	 * what date we're dealing with (if that is the case).
	 *
	 * We reset this later so we can run the loop
	 * properly with a call to rewind_posts().
	 */
	if ( have_posts() )
		the_post();
?>

			<?php /* Variables needed to alter display output whether it's a Category, State or City */
				$current_page = get_queried_object();
				$taxonomy = $current_page->taxonomy;
				$term_id = get_queried_object_id();
				$hierarchy = _get_term_hierarchy($taxonomy);
				$page_parent_ids = get_ancestors( $term_id, $taxonomy );
				$page_parent_id = end($page_parent_ids);
				$page_parent_name = get_term($page_parent_id, $taxonomy );
				$page_parent_middle = get_term_by('id', $current_page->parent, $taxonomy); 
				$slug_for_location_icon = $current_page->slug;
				if(!empty($page_parent_middle) && $page_parent_middle->slug !== 'united-states') {
					$slug_for_location_icon = $page_parent_middle->slug;
				}
			?>
			
			<h1 class="smct-page-title">				
				<?php if ( is_tax('smct_cats') ) { 
					$category = get_the_terms($post->ID,'smct_cats');
					echo 'Articles - ' . $category[0]->name; 
				} elseif ( is_tax('smct_areas') ) { 
					if(array_key_exists($term_id, $hierarchy)) {
						echo $current_page->name . ' Areas Served'; 
					} else {
						if(empty($page_parent_name->name)) {
							echo $current_page->name;
						} elseif(!empty($page_parent_middle->name)) {
							echo $current_page->name . ', ' . $page_parent_middle->name;
						} else {
							echo $current_page->name . ', ' . $page_parent_name->name;
						}
					} 
				} else {
					echo 'Articles';
				} ?>
			</h1>

			<?php rewind_posts(); ?>

			<?php /* Display navigation to next/previous pages when applicable */ ?>
			<?php if(is_tax('smct_cats') || is_tax('smct_areas')) {//If is Custom Taxonomy
				if (!array_key_exists($term_id, $hierarchy)) {// If is NOT State Page
					if ( $wp_query->max_num_pages > 1 ) : ?>
						<div id="smct-nav-above" class="navigation">
						<?php
						$big = 999999999; // an unlikely integer
						echo paginate_links( array(
							'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
							'format' => '?paged=%#%',
							'current' => max( 1, get_query_var('paged') ),
							'total' => $wp_query->max_num_pages,
							'prev_text' => __('« Previous'),
							'next_text' => __('Next »'),
						) );
						?>
						</div><!-- #nav-above -->
					<?php endif; 
				}
			} ?>

			<?php /* If there are no posts to display, such as an empty archive page */ ?>
			<?php if ( ! have_posts() ) : ?>
				<div id="post-0" class="post error404 not-found">
					<h1 class="smct-archive-title"><?php _e( 'No Entries' ); ?></h1>
					<div class="smct-archive-content">
						<p><?php _e( 'Apologies, but no results were found for the requested archive.' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .smct-archive-content -->
				</div><!-- #post-0 -->
			<?php endif; ?>


			<?php if(is_tax('smct_areas')) {//If is Area Page
				if (array_key_exists($term_id, $hierarchy)) {// If is State Page		  				    

					$termchildren = get_term_children( $term_id, $taxonomy );

					echo '<div id="smct-cities-listing">';
					echo '<div class="smct-row">';
						echo '<div class="smct-col-sm-4 smct-col-xs-12"><p>' . smct_determine_stateface($slug_for_location_icon) . '</p></div>';
						echo '<div class="smct-col-sm-8 smct-col-xs-12">';
							echo '<ul>';
							$cities_array = array();
								foreach ( $termchildren as $child ) {
									$term = get_term_by( 'id', $child, $taxonomy );
									$parents = count(get_ancestors( $child, $taxonomy ));
									$items = array(
								        'name' => $term->name, 
								        'slug' => $term->slug,
								        'parents' => $parents
								    );
									//$cities_array[] = $term->name;
									$cities_array[] = $items;
								}		
							sort($cities_array);

							if( count($page_parent_ids) > 0 ) {
								foreach ($cities_array as $city) { //Areas with at least one parent
									if($city['parents'] > 1 ) {
										echo '<li class="smct-col-sm-6"><a href="' . get_term_link( $city['slug'], $taxonomy ) . '">' . $city['name'] . '</a></li>';
									}
								}
							} else {
								foreach ($cities_array as $city) {
									if($city['parents'] == 1 ) { //Don't show parented items from previous page
										echo '<li class="smct-col-sm-6"><a href="' . get_term_link( $city['slug'], $taxonomy ) . '">' . $city['name'] . '</a></li>';
									}
								}
							}
							echo '</ul>';
						echo '</div>';
					echo '</div>';
					echo '</div>';
  
				} 
			} ?>

			<?php while ( have_posts() ) : the_post(); 
				if (!array_key_exists($term_id, $hierarchy)) {//If is not State Page ?>

					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>				

						<?php
							$display_images = get_option('smct_category_display_layout');
							$row_width = 'smct-row';
							$left_col_widths = 'smct-col-md-3 smct-col-sm-4 smct-col-xs-12 smct-image';
							$right_col_widths = 'smct-col-md-9 smct-col-sm-8 smct-col-xs-12 smct-text';
							$photo = smct_grab_first_image();
							if(empty($photo) || $display_images[0] == 'no') {
								$row_width = '';
								$left_col_widths = 'hidden-xs hidden-sm hidden-md hidden-lg';
								$right_col_widths = 'smct-col-xs-12 smct-text';
							} 
						?>
						<div class="smct-archive-summary <?php echo $row_width; ?>">
							<?php if(!empty($photo) && $display_images[0] !== 'no') { ?>
							<div class="<?php echo $left_col_widths;?>">
								<a href="<?php the_permalink(); ?>"><span class="smct-image-wrap" style="background-image:url(<?php echo smct_grab_first_image(); ?>)"></span></a>
							</div>
							<?php } ?>
							<div class="<?php echo $right_col_widths;?>">
								<h3 class="smct-archive-title"><a href="<?php the_permalink(); ?>" title="<?php printf( the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
								<?php //Updated 1.1.6 - Use Default Page Title Options
									$title_source = get_option('smct_page_title_source');
									if($title_source[0] == 'yes') {
										the_title(); 
									} 
									//Use Custom Page Title meta, if there is one
									elseif(get_option('smct_alternate_page_title') !== false) { 
										if( class_exists('acf') ) {
											if(get_field(get_option('smct_alternate_page_title'))) { 
												the_field(get_option('smct_alternate_page_title')); 
											} elseif (preg_match_all('#(<h[0-6].*?>).*?(</h[0-6]>)#',get_the_content(), $matches)) {
												if($matches) {
													echo strip_tags($matches[0][0]);
												} else {
													the_title();
												}
											} else { 
												the_title(); 
											}
										} elseif (preg_match_all('#(<h[0-6].*?>).*?(</h[0-6]>)#', get_the_content(), $matches)) {
											if($matches) {
												echo strip_tags($matches[0][0]);
											} else {
												the_title();
											}
										} else {
											the_title();
										}									
									} 
									//Check for H1 first; use H3 as a fallback
									elseif (preg_match_all('#(<h[0-6].*?>).*?(</h[0-6]>)#', get_the_content(), $matches)) {
										if($matches) {
											echo strip_tags($matches[0][0]);
										} else {
											the_title();
										}
									} else {
										the_title();
									}
								?>	
								</a></h3>
								<?php //Updated 1.0.13 - check for shortcode in content/allow child function override
								if( ! function_exists('smct_strip_shortcodes_from_excerpt') ) {
									function smct_strip_shortcodes_from_excerpt() {
										$stripped_content = '<p>' . wp_trim_words(preg_replace('#(<h[0-6].*?>).*?(</h[0-6]>)#', '$1$2', strip_tags( get_the_content(), '<p><h1><h3><br>' )),60,' ...') . '</p>';
										$stripped_content = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $stripped_content);
										echo $stripped_content;
									}
								}
								smct_strip_shortcodes_from_excerpt();
								?>
							</div>
						</div><!-- .smct-archive-summary -->

					</div><!-- #post-## -->


			<?php } 
			endwhile; // End the loop. Whew. ?>

			<?php /* Display navigation to next/previous pages when applicable */ ?>
			<?php if(is_tax('smct_cats') || is_tax('smct_areas')) {//If is Custom Taxonomy
				if (!array_key_exists($term_id, $hierarchy)) {// If is NOT State Page	
					if ( $wp_query->max_num_pages > 1 ) : ?>
						<?php
						$big = 999999999; // an unlikely integer
						echo paginate_links( array(
							'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
							'format' => '?paged=%#%',
							'current' => max( 1, get_query_var('paged') ),
							'total' => $wp_query->max_num_pages,
							'prev_text' => __('« Previous'),
							'next_text' => __('Next »'),
						) );
						?>
						</div><!-- #nav-above -->
					<?php endif; 
				}
			} ?>


			</div><!-- #content -->
		</div><!-- #container -->

<?php if($smct_page_width[0] == 'sidebar') {
		get_sidebar();
	} ?>
<?php get_footer(); ?>

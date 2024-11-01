=== Socius Marketing Page Taxonomy ===
Contributors: sociusmarketing
Tags: taxonomy, taxonomies, pages, categories, locations, socius
Requires at least: 3.0.1
Tested up to: 4.9
Stable tag: 1.1.14
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds 2 custom taxonomies (categories & areas served) to Pages for easy, dynamic archive listing.

== Description ==

This plugin creates two taxonomies for categorizing pages, and their respective archives.

Upon activation, two pages are created that serve as the top-level archives. They are initially named 'Categories' and 'Areas Served', but may be updated to suit your needs. These pages will display a visual category selection that link to paginated listings of all the content pages associated with each taxonomy. 

Pages can be easily assigned to the custom taxonomies by using the checkbox options added to the Edit Page admin area. 

= Custom Categories =
This taxonomy is intended for products or services, for example: "Bathrooms," "Kitchens," "Outdoor," etc. All categories in this taxonomy will exist as top-level items (no parent/child relationships).

= Areas Served =
This taxonomy is intended to use US cities and states in parent/child relationships, for example: Texas > Dallas. Properly setting up these locations will allow the Areas Served archive page to create separate state pages with a sub-listing of all its cities.

== Installation ==

1. Upload 'socius-marketing-page-taxonomy' to the '/wp-content/plugins/' directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Update your permalinks by going to Settings->Permalinks and clicking 'Save Changes'. That's it! Everything will be functional at this point.
4. If you need further customization, use the Settings->Custom Taxonomy screen to configure the plugin.

== Frequently Asked Questions ==

= Q. How can I find my Categories or Areas Served page? =
A. The pages that are created by the plugin are regular pages that can be found in the Pages section of the admin. By default, the are called Categories and Areas Served, and can be found alphabetically as such. Alternatively, the plugin also creates an admin home dashboard widget that provides direct links to both pages.

= Q. How do I add new Categories? =
A. You can add new Categories one of two ways. You can manage all your categories at one time by going to Pages->Custom Categories. Alternatively, you can add Categories on the fly on the Edit Page admin screen in the Custom Categories meta box found in the right-hand column. 

= Q. How do I add new Areas Served? =
A. Just like Categories, you can add new Areas Served one of two ways. You can manage all your Areas Served at one time by going to Pages->Areas Served. Alternatively, you can add Areas Served on the fly on the Edit Page admin screen in the Areas Served meta box found in the right-hand column. Don't forget that US states are meant to be parent categories with cities underneath them. You can always edit the parent/child relationship in Pages->Areas Served.

= Q. Why do I get a 404 page when I click on a category/area served? =
A. Your permalinks need to be updated. Go to Settings->Permalinks and click Save Changes to update your permalinks (no actually changes need to be made). Refresh your archive page and your categories should click through.

= Q. Where does the image come from on the archive page for a category or article? =
A. The image is pulled from the page content. The Category cover image is the content image from the first page within that Category.

= Q. What icons are available for international locations? =
A. Custom icons have been added for Africa, Asia, Australia, Caribbean, Canada, Central America, Europe, Mexico, Middle East, and South America. Just like with states, international locations must have a country and continent selected in order for it to appear properly on all archive pages. You may also add in a third level of city, country, and continent, so long as you parent/child them properly. Note that Canada and Mexico were separated out of North America since the original plugin options covered the United States.

== Screenshots ==

1. Taxonomy meta boxes on the Edit Page screen
2. Options page for further customization
3. Category archive page
4. Areas Served archive page with state icons
5. State archive page with city listings
6. Sample archive page listing of a city

== Changelog ==
= 1.1.14 =
* Fix a minor bug affecting the options page

= 1.1.13 =
* Fix an array data type reference

= 1.1.12 =
* Fix a conflict with the Socius Theme - PROseries

= 1.1.11 =
* Change function on archive pages to get larger image based on first image ID

= 1.1.10 =
* Change with_front to false so taxonomies won't be affected by /blog/

= 1.1.9 =
* CSS box-sizing fix for non-bootstrap themes

= 1.1.8 =
* Admin bug fixes

= 1.1.7 =
* Fixed admin placeholder bug

= 1.1.6 =
* Added option to use WordPress title in place of headlines

= 1.1.5 =
* Simplified template-archive title query

= 1.1.4 =
* Replaced deprecated is_taxonomy()

= 1.1.3 =
* Added option to hide thumbnails on category archive

= 1.1.2 =
* Edited query for archive page title to only pull H3 if there is no H1

= 1.1.1 =
* Fixed city listing bug to read slug instead of name

= 1.1.0 =
* Introduced Continents for World categorization
* Fixed typo bug when trying to use Washington, DC
* Renamed archive template ID to be more specific to plugin content and not conflict with general theme naming
* Removed ACF Field option from settings page due to lack of usage

= 1.0.13 =
* Updated archive content to be a pluggable function, allowing for different find and replace options in a child function.

= 1.0.12 =
* Fixed bug with default pagination of archives behavior

= 1.0.11 =
* Updated query to only make new archive pages on when taxonomies are empty. This will hopefully cut down on the archive pages being duplicated when reactivating the plugin.
* Added minified stylesheet
* Updated styling to properly size archive row if no photo present
* Changed default setting to display page title in the content
* Changed default setting to show four columns for categories and states

= 1.0.10 =
* Updated content excerpt to remove shortcode tags
* Updated archive listing to only show an image if one exists, instead of forcing the same fallback image across all category pages. 

= 1.0.9 =
* Changed archive listing to extract headline tags from the excerpt and use them for title links.

= 1.0.8 =
* Added option to take a category image from the category content area before displaying the default image
* Edited archive width option to be used regardless of sidebar display

= 1.0.7 =
* Style update for image display

= 1.0.6 =
* Added Washington, DC to display the proper icon

= 1.0.5 =
* Fixed error on pagination option.
* Added options for displaying a sidebar and controlling the content width on archive pages.
* Added option for CSS overrides.

= 1.0.4 =
* Fixed error on pagination option.
* Fixed error on archive template for retrieving category title.
* Removed box-sizing on CSS.

= 1.0.3 =
* Added option to turn off pagination of taxonomy archive pages.
* Updated Category page to pull image from most recent post instead of oldest post.

= 1.0.2 =
* Added alphabetization of cities display.

= 1.0.1 =
* Updated CSS to not conflict with Bootstrap.

= 1.0.0 =
* Custom Taxonomies.

== Upgrade Notice ==
*No issues at this time.
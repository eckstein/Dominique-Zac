<?php
/**
 * The home page template. Generates the structure and content of the home page post grid.
 * @package WordPress
 */

get_header(); ?>

	<div class="catgrid">
		<h3 class="tagline text-center">
			<a href="">
			<?php echo _get_latest_tagline(); ?>
			</a>
		</h3>
		
		<?php
		

		if (get_field('manage_grid', 'option')) { //See if we have values
			$gridArr = get_field('manage_grid', 'option'); //Array with 10 posts, each type, category ID, post ID, and snippet toggle
				$fullCnt = 0; $postCnt = 0;	$catCnt = 0; //Keep track of how many of each
				
			foreach ($gridArr as $key => $item) { //We're going to loop through each item and figure out how to grab the proper post
				$type = $item['source_type']; //'Type' is either category or a post
				
				if ($type == 'category') { //Type is a category, so we find the first/next post in the category
					$catID = $item['category'];
					$snippet = $item['show_snippet'];
					$latestCPost = get_posts(array(
						'post_type' => 'post',
						'category' => $catID,
						'ignore_sticky_posts' => 1, 
						'posts_per_page' => 1, 
						'offset' => $catCnt, //This ensures we're not getting the same post twice is a category is chosen in more than 1 spot
						)
					);
					foreach ($latestCPost as $post) {
						setup_postdata($post);
						
							generate_home_box($fullCnt, $snippet); //Generate the HTML for each box (functions.php)
						
						$catCnt++;
						wp_reset_postdata();
					}	
				} elseif ($type == 'post') { //Type is just a single post...
						$postID = $item['post'];
						$snippet = $item['show_snippet'];
						$latestPost = get_posts(array(
						'post_type' => 'post',
						'posts_per_page' => 1,
						'post__in' => array($postID), //..so just get that post. This MUST be an array.
						'ignore_sticky_posts' => 1, //We need this because post__in includes sticky posts, and we don't want it to
						)
					);
					foreach ($latestPost as $post) {
						setup_postdata($post);
						
							generate_home_box($fullCnt, $snippet); //Generate the HTML for each box (functions.php)
						
						$postCnt++;
						wp_reset_postdata();
					}
					
				}
				$fullCnt++;
			}
		}

?>


<?php get_footer(); ?>
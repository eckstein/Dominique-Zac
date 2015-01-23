<?php


//Add ACF Options Pages
if(function_exists('acf_add_options_page')) { 

	acf_add_options_page();
	acf_add_options_sub_page('Home Grid');

}

add_image_size( 'grid-image0', '570', '400', true );
add_image_size( 'grid-image1', '285', '400', true );
add_image_size( 'grid-image2-3', '285', '200', true );
add_image_size( 'grid-image4-5-8-9', '285', '280', true );
add_image_size( 'grid-image6-7', '570', '280', true );

//ENABLE POST THUMBNAILS
add_theme_support( 'post-thumbnails' ); 


//ENABLE SECONDARY IMG SELECTION INSTEAD OF FEATURED IMAGE
function register_custom_image_pickers() {
    add_theme_support('mfi-reloaded', array(
        'hero-image' => array(
            'post_types' => array('post'),
            'labels' => array(
                'name' => __('Hero Image'),
                'set' => __('Set hero image'),
                'remove' => __('Remove hero image'),
                'popup_title' => __('Set Hero Image'),
                'popup_select' => __('Set hero image'),
            ),
        ),
        'home-image' => array(
            'post_types' => array('post'),
            'labels' => array(
                'name' => __('Home Image'),
                'set' => __('Set home image'),
                'remove' => __('Remove home image'),
                'popup_title' => __('Set Home Image'),
                'popup_select' => __('Set home image'),
            ),
        ),
    ));
}
add_action('after_setup_theme', 'register_custom_image_pickers');


//PRIMARY MENU
function register_primary_menu() {
  register_nav_menu('primary',__( 'Primary Menu' ));
}
add_action( 'init', 'register_primary_menu' );

//SECONDARY MENU
function register_secondary_menu() {
  register_nav_menu('secondary',__( 'Secondary Menu' ));
}
add_action( 'init', 'register_secondary_menu' );

//HEADER SIDEBAR
register_sidebar(array(
	'name' => 'Header Right',
	'id' => 'header_right_sidebar'
));

//SHARE AREA SIDEBAR
register_sidebar(array(
	'name' => 'Share Area',
	'id' => 'share_area_sidebar'
));

// DOM ENTRY META FOR A POST
function dom_entry_meta() {
	$html = '';
	$date = sprintf( '<time class="entry-date" datetime="%1$s">%2$s</time>',
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);
	$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'twentytwelve' ), get_the_author() ) ),
		get_the_author()
	);

	$html = '<p>'.$date.' by '.$author.'</p>';

	printf($html);
}

// DOM ENTRY META FOR A POST'S SINGLE PAGE
function dom_single_entry_meta() {
	$html = '';
	$date = sprintf( '<time class="entry-date" datetime="%1$s">%2$s</time>',
		esc_attr( get_the_date( 'c' ) ),
		esc_html( the_date('F d, Y', '', '', false) )
	);
	$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'twentytwelve' ), get_the_author() ) ),
		get_the_author()
	);
	$cat = get_the_category( get_the_ID() );
	$catLink = get_category_link( $cat[0]->term_id );
	
	$issue = wp_get_post_terms( get_the_ID(), 'issue' );
	$issueLink = '';
	if($issue) {
		$issueLink = get_term_link( intval($issue[0]->term_id), 'issue' );
	}

	$html .= '<div class="col-md-9">by '.$author.' // '.$date;
	
	if($cat && $catLink && $issue && $issueLink){
		$html .= ' // featured in the <a href="'.$catLink.'">'.$cat[0]->name.'</a> section of <a href="'.$issueLink.'">'.$issue[0]->name.'</a>';
	}
	
	$html .= '</div>';

	return $html;
}

// DOM PAGINATION
function dom_paging() {
	global $wp_query;
	$html = '';

	if ( $wp_query->max_num_pages > 1 ) {	
		$big = 999999999; // need an unlikely integer
		$links = paginate_links( array(
			'base' 			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' 		=> '?paged=%#%',
			'current'		=> max( 1, get_query_var('paged') ),
			'total' 		=> $wp_query->max_num_pages,
			'show_all'		=> false,
			'end_size'      => 4,
			'mid_size'      => 3,
			'prev_next'     => True,
			'prev_text'     => __('&lt;'),
			'next_text'     => __('&gt;'),
			'type' 			=> 'list',
		) );
		$html .= '<div class="pagination col-lg-12 text-right">PAGES '.$links.'</div>';
	}
	
	print($html);
}

//RETURNS SOMETHING LIKE: "A Digital Mag for the Designer’s Soul in All of Us  //  Issue I  //  July 15, 2014"
function _get_latest_tagline() {
	$html = '';
	$linkText = array();
	$latestIssue = get_term_by( 'slug', mag_get_current_issue() , 'issue' );;
	
	//Make the linktext
	if(get_bloginfo('description')!==''){
		$linkText[] = get_bloginfo('description');
	}
	if($latestIssue->name!==''){
		$linkText[] = $latestIssue->name;
	}
	if($latestIssue->description!==''){
		$linkText[] = $latestIssue->description;
	}
	$linkText = implode(' // ', $linkText);
	
	//Assemble the link with linkText
	$html .= '<h3 class="tagline text-center">';
	if($latestIssue->term_id!==''){
		$html .= '<a href="'.get_term_link( intval($latestIssue->term_id), 'issue' ).'">';
	}
	$html .= $linkText;
	if($latestIssue->term_id!==''){
		$html .= '</a>';
	}
	$html .= '</h3>';
	
	return $html;
}


//GETS THE IMAGE SIZE NAME FOR A HOME GRID POST BASED ON WHICH TILE ITS DISPLAYED IN
function calc_home_img_size($fullCnt) {
		if ($fullCnt == 0) {
			$imgSize = 'grid-image0';
		} elseif ($fullCnt == 1) {
			$imgSize = 'grid-image1';
		} elseif ($fullCnt ==2 || $fullCnt == 3) {
			$imgSize = 'grid-image2-3';
		} elseif ($fullCnt == 4 || $fullCnt == 5 || $fullCnt == 8 || $fullCnt == 9) {
			$imgSize = 'grid-image4-5-8-9';
		} elseif ($fullCnt ==6 || $fullCnt == 7) {
			$imgSize = 'grid-image6-7';
		}
		return $imgSize;
}

//Generates the HTML for a home page grid box. Must be used inside loop.
function generate_home_box($fullCnt, $snippet=true) {
	?>
	<div class="post post<?php echo $fullCnt; ?>">
		<div class="inner">
		<a href="<?php the_permalink(); ?>">
			<?php
			if (get_field('select_image')) {
				$homeImg = get_field('select_image');
			} else {
				$homeImg = get_post_thumbnail_id();
			}
			$imgSize = calc_home_img_size($fullCnt);
			echo wp_get_attachment_image($homeImg, $imgSize, array('scale'=>'0'));
			?>
		</a>
		<div class="ovl">
			<div class="txtWrap">
				<div class="title">
				<?php the_title() ?>
				</div>
				<?php if ($snippet) { ?>
				<div class="snippet">
				<?php
				if (get_field('home_teaser')) {
					the_field('home_teaser');
				} else {
					$excerpt = get_the_excerpt();
					$teaser = tokenTruncate($excerpt, 100);
					echo $teaser;
				}
				?>
				</div>
				<?php } ?>
				<div class="ovl-btn">
				READ ON
				<a class="linkwrap" href="<?php the_permalink(); ?>"></a>
				</div>
			</div>
		</div>
		</div>
	</div>
	<?php
}

//Cuts a string to the nearest space
function tokenTruncate($string, $your_desired_width) {
  $parts = preg_split('/([\s\n\r]+)/', $string, null, PREG_SPLIT_DELIM_CAPTURE);
  $parts_count = count($parts);

  $length = 0;
  $last_part = 0;
  for (; $last_part < $parts_count; ++$last_part) {
    $length += strlen($parts[$last_part]);
    if ($length > $your_desired_width) { break; }
  }

  return implode(array_slice($parts, 0, $last_part));
}


//RETURNS AN ARRAY WITH THE LATEST POST IN EACH CATEGORY OF THE LATEST ISSUE
function _get_postgrid_blocks() {
	$output = array();
            	
	$categories = get_categories( array(
		'orderby' => 'name',
		'hide_empty' => 1
  	) ); 

    foreach ( $categories as $category ) { 
     	// ignore the master category
    	if ( $category->slug == get_option( 'mag_master_category') ) {
			continue;
		}
		
		// get the posts for the category			
		$cat_posts = new WP_Query( array(	
                'orderby'		=> 'date',
                'order'			=> 'DESC',
                'post_per_page'	=> 1,
                'cat'			=> $category->cat_ID,
                'tax_query' 	=> array(
										array(
											'taxonomy' => 'issue' ,
											'field' => 'slug',
											'terms' => mag_get_current_issue(),
										)
									),
		) );
	
		if($cat_posts->have_posts()){	
			$cat_posts->the_post();
		
		
			//fallback img
			$img = get_template_directory_uri().'/images/blank.png';
			if ( has_post_thumbnail() && !is_attachment() ){
				$img = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
			}
		
			$teaser = '';
			$teaser = get_post_custom_values('Teaser', get_the_ID())[0];
			$output[$category->name] = array(
				'link' 		 => get_permalink(),
				'img'		 => $img,
				'post_title' => get_the_title(),
				'post_teaser' 	 => substr($teaser, 0, 90) //only get the first 90 characters of the teaser
			);
		}
    }
				
    wp_reset_postdata();
    		
	return $output;

}

// [postgrid]
function get_postgrid( $atts ) {
    $a = shortcode_atts( array('num' => 'something'), $atts );
	$blocks = _get_postgrid_blocks();
	$posts = array();
		
	$posts[] = '<link href="'.get_template_directory_uri().'/css/catgrid.css" rel="stylesheet" type="text/css">';
	
	$posts[] = '<div class="catgrid">';
	
	$posts[] = _get_latest_tagline();
	
	$i = 0;
	foreach($blocks as $category => $block) {
	 	$posts[] = '<div class="post post'.$i.'">'.
				'<a href="'.$block['link'].'"><img src="'.$block['img'].'" alt="'.$block['post_title'].'" title="'.$block['post_title'].'"></a>'.
				'<div class="ovl">'.
					'<div class="txtWrap">'.
						'<p class="post-title"><strong>'.$block['post_title'].'</strong><br>'.
						'<span class="teaser">'.$block['post_teaser'].'</span></p>'.
						'<p><a href="'.$block['link'].'" class="btn">Read On</a></p>'.
					'</div>'.
				'</div>'.
			'</div>';
			$i++;
			//restart the numbering every 10 posts so the design loops
			if($i==10){
				$i=0;
			}
	}
	
	$posts[] = '</div><div style="clear:both;"></div>';
	
	$posts = implode($posts);
	
    return $posts;
}
add_shortcode( 'postgrid', 'get_postgrid' );

// [issue_archives]
function get_issue_archives( $atts ) {
	$output = '';
	
	//GET ALL THE ISSUES
	$issues = get_categories( array(
	    'orderby'       => 'id', 
	    'order'         => 'DESC',
	    //'hide_empty'    => 0,
		'taxonomy'		=> 'issue'
  	) );
	
	//GET ALL TAXONOMY IMAGES FROM THE TAXONOMY IMAGE PLUGIN
	$associations = taxonomy_image_plugin_get_associations();
 
	// START PAGINATION LOGIC
	$issues_per_page = 5;
	$current = (intval(get_query_var('paged'))) ? intval(get_query_var('paged')) : 1;
	global $wp_rewrite;
	$pagination_args = array(
		'base' => @add_query_arg('paged','%#%'),
		'format' => '',
		'total' => ceil(sizeof($issues)/$issues_per_page),
		'current' => $current,
		'show_all' => false,
		'end_size'     => 4,
		'mid_size'     => 3,
		'prev_next'    => True,
		'prev_text'    => __('&lt;'),
		'next_text'    => __('&gt;'),
		'type' => 'list',
	);
	if( $wp_rewrite->using_permalinks() ){
		$pagination_args['base'] = user_trailingslashit( trailingslashit( remove_query_arg('s',get_pagenum_link(1) ) ) . 'page/%#%/', 'paged');
	}
	if( !empty($wp_query->query_vars['s']) ){
		$pagination_args['add_args'] = array('s'=>get_query_var('s'));
	}
	$start = ($current - 1) * $issues_per_page;
	$end = $start + $issues_per_page;
	$end = (sizeof($issues) < $end) ? sizeof($issues) : $end;
	//END PAGINATION LOGIC

	for ($i=$start;$i < $end ;++$i ) {
	 	$issue = $issues[$i];
	 
		$issue_posts = get_posts( array(
		   'post_type' => 'post',
		   'tax_query' => array(
		      array(
		         'taxonomy' => 'issue',
		         'field' => 'slug',
		         'terms' => array($issue->slug),
		      )
		   )
		) );
		
		$img = '';		

		//$issue_term_id = absint( $issue->term_id );
		if ( array_key_exists( $issue->term_id, $associations ) ) {
		    $image_id = absint( $associations[ $issue->term_id ] );
			$img = wp_get_attachment_url($image_id, 'full' );
		}
		
		//fallback image if there isn't one associated with the issue
		if ( $img=='' ){
			$img = get_template_directory_uri().'/images/issue-thumbnail-fallback.jpg';
	 	}
		
		//Get the permalink for the issue
		$url = get_term_link( intval($issue->term_id), 'issue' );
		
		$output .= '<article id="issue-'.$issue->slug.'" class="category-post clearfix"><div class="col-md-4"><p><a href="'.$url.'"><img src="'.$img.'" alt="'.$issue->name.'" title="'.$issue->name.'" class="img-responsive"></a></p></div><div class="col-md-8">';
		
		//add the header
		$output .= '<header class="entry-header"><h1 class="entry-title" ><a href="'.$url.'" rel="bookmark">'.$issue->name;
		if($issue->description!=='') {
			$output .= ' // '.$issue->description;
		}
		$output .= '</a></h1></header>';
		
		if(!empty($issue_posts)) {
			$output .= '<ul class="post-list">';
			foreach($issue_posts as $post) {
				$li = '';
				$teaser = get_post_custom_values('Teaser', $post->ID)[0];
				
				$li .= '<li><a href="'.$post->guid.'"><span class="post-title">'.$post->post_title.'</span>';
				if($teaser!=='' && isset($teaser)){
					$li .= ' <span class="teaser">'.$teaser.'</span>';
				}
				$li .= '</a></li>';
				
				$output .= $li;
			}
			$output .= '</ul>';
		}
		
		$output .=  '</div></article>';
	}
	
	if(count($issues)>$issues_per_page){
		$output .= '<div class="pagination col-lg-12 text-right">PAGES '.paginate_links($pagination_args).'</div>';
	}
	
	return $output;
}
add_shortcode( 'issue_archives', 'get_issue_archives' );

// PREVIOUS AND NEXT PAGE LINKS FOR ISSUES
function get_dom_prev_next_issue() {
	$html = '';
	// get current term/taxonomy
	$current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
	// get all the issues so we can loop through them and find the previous and next issues
	$terms = get_terms('issue', array(
		'hide_empty' => 0,
		'orderby' => 'id',
		'order' => 'DESC',
	));
	$i = 0;
	
	if(count($terms) > 3){	
		$html .= '<ul class="pager">';
	
		foreach($terms as $term) {
			if ($term->slug == $current_term->slug) {
				$next_issue = $terms[$i+1];
				$prev_issue = $terms[$i-1];
			
				if(isset($prev_issue)){
					$html .= ' <li class="previous"><a href="'.get_term_link( intval($prev_issue->term_id), 'issue' ).'"><strong>Previous Issue:</strong> '.$prev_issue->name.'</a></li>';
				}
			
				if(isset($next_issue)){
					$html .= '<li class="next"><a href="'.get_term_link( intval($next_issue->term_id), 'issue' ).'"><strong>Next Issue:</strong> '.$next_issue->name.'</a></li>';
				}
			}
			$i++;
		}
	
		$html .= '<ul>';
	}
	
	print($html);
}

// DROPCAP SHORTCODE [drop]*[/drop]
function make_drop_cap($atts, $content = '') {
	return '<span class="dropcap">'.$content.'</span>';
}
add_shortcode( 'drop', 'make_drop_cap' );

// BLOCKQUOTE SHORTCODE [blockquote]*[/blockquote]
function make_blockquote($atts, $content = '') {
	$class = 'alignleft';
		
	if($atts['align'] == 'right'){
		$class = 'alignright';
	}
	
	return '<blockquote class="quoter col-lg-4 '.$class.'">'.$content.'</blockquote>';
}
add_shortcode( 'blockquote', 'make_blockquote' );

// COLUMN SHORTCODES [col num="(2|3|4|6|12)"]*[/col]
function make_columns($atts, $content = '') {
	$class = '';

	switch ($atts['num']) {
		case 2:
			$class = 6;
			break;
		case 3:
			$class = 4;
			break;
		case 4:
			$class = 3;
			break;
		case 6:
			$class = 2;
			break;
		case 12:
			$class = 1;
			break;
		default:
			$class = 6;
	}
	
	return '<div class="col-lg-'.$class.' post-col">'.do_shortcode($content).'</div>';
}
add_shortcode( 'col', 'make_columns' );

// RESPONSIVE VIDEO SHORTCODE [video ratio="(16-9|4-3)"]<embed code />[/video]
function responsive_video($atts, $content = '') {
	$class = '';
	if($atts['ratio']=='4-3'){
		$class = 'embed-responsive-4by3';
	} else {
		$class = 'embed-responsive-16by9';
	}
	
	return '<p><div class="embed-responsive '.$class.'">'.$content.'</div></p>';
}
add_shortcode( 'video', 'responsive_video');

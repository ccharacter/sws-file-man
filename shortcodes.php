<?php



// SHORTCODE FOR Displaying Items
function sws_mg_items_display_func($atts) {
	$a=shortcode_atts(array(
	  'list_title' 	=> 'In Other News...',
	  'mgr_type' 	=> 'link',
	  'category' 	=> 'covid-19',
	  'sort_by' 	=> 'post_date',
	  'show_date' 	=> 'N',
	  'show_option_all' => 'VIEW ALL',
	  'show_all_link' => '/current/news-archive/other-stories/',
	  'sort_order' 	=> 'DESC',
	  'word_limit'	=> 30,
	  'heading_class' => "c-block__heading-title u-theme--color--darker",
	  'container_class' => "sws-accordion",
	  'subcontainer_class' => 'sws-acc-content',
	  'ul_class' => "sws-ul",
	  'item_limit' => 15
	), $atts);
	// NOTE TO SELF: SHORTCODE_ATTS DOESN'T LIKE UPPERCASE!!!!
	
	$args =  array( 
		'post_type'			=> 'item',
		'posts_per_page' 	=> $a['item_limit'],
		'order' 			=> $a['sort_order'],
		'orderby' 			=> $a['sort_by'],
		'meta_query'		=> array (
			array(
				'key'		=>	'mgr_type',
				'value'		=>	$a['mgr_type'],
				'compare'	=>	'LIKE',
				)
			),
	);
	
	$myItems = new WP_Query($args);

	//ob_start();	
	if ($myItems->have_posts() ) :
	$rnd=rand(1000,9999);
	$mytext="<div class='".$a['container_class']."'>";

	if ($a['container_class']=="sws-accordion") { 
		$mytext.="<input type=\"checkbox\" id=\"toggle$rnd\" class=\"sws-acc-ck\" /><label for=\"toggle$rnd\" class='".$a['heading_class']."'>".$a['list_title']."</label>";	}
	else { 
		$mytext.="<h3 class='".$a['heading_class']."'>".$a['list_title']."</h3>";
	}
	
	$mytext.="<div class='".$a['subcontainer_class']."'><ul class='".$a['ul_class']."'>"; 

	switch($a['mgr_type']) {
		default:
			while ( $myItems->have_posts() ) :
				
				$myItems->the_post();
				
				if ($a['show_date']=="Y") { $dtext=" (".get_field('mgr_date').")";} else {$dtext="";}
				
				$mytext.="<li class='sws-li'><a href=\"".get_field('mgr_url')."\" target='_blank'>".wp_trim_words(get_the_title(),$a['word_limit'])."</a>$dtext</li>";
			
			endwhile;
		
		break;
	}

	if (!($a['show_option_all']=="")) { $mytext.="<li><a href='".$a['show_all_link']."'>".$a['show_option_all']."</a><li>";}

	$mytext.="</ul></div></div>";
	endif;
	
	return $mytext;
}

// register shortcode
add_shortcode('sws_display_items', 'sws_mg_items_display_func'); 


// SHORTCODE FOR Displaying CATEGORIES
function sws_mg_items_cat_func($atts) {
	$a=shortcode_atts(array(
	  'list_title' => 'View Posts by Category',
	  'show_count' => 1,
	  'post_type' => 'post',
	  'hide_empty' => true,
	  'depth' => 5,
	  'show_option_all' => 'VIEW ALL',
	  'exclude' => "1",
	  'heading_class' => "c-block__heading-title u-theme--color--darker",
	  'container_class' => "sws-accordion",
	  'subcontainer_class' => 'sws-acc-content',
	  'ul_class' => "sws-ul",
	  'limit' => 15
	), $atts);
	// NOTE TO SELF: SHORTCODE_ATTS DOESN'T LIKE UPPERCASE!!!!
	
	$mytext="<div class='".$a['container_class']."'>";
	$rnd=rand(1000,9999);

	if ($a['container_class']=="sws-accordion") { 
		$mytext.="<input type=\"checkbox\" id=\"toggle$rnd\" class=\"sws-acc-ck\" /><label for=\"toggle$rnd\" class='".$a['heading_class']."'>".$a['list_title']."</label>";	}
	else { 
		$mytext.="<h3 class='".$a['heading_class']."'>".$a['list_title']."</h3>";
	}
	
	$mytext.="<div class='".$a['subcontainer_class']."'><ul class='".$a['ul_class']."'>"; 
	
	$myCats=sws_list_categories_for_post_type( array('depth'=>$a['depth'],'hide_title_if_empty'=>$a['hide_empty'],'show_count'=>$a['show_count'],'echo'=>0,'exclude'=>$a['exclude'],'show_option_all'=>$a['show_option_all'],'title_li'=>''));
	
	$myCats.="</ul></div></div>"; 
		
	return $mytext.$myCats;
}

// register shortcode
add_shortcode('sws_display_categories', 'sws_mg_items_cat_func'); 

?>
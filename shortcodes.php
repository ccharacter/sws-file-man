<?php



// SHORTCODE FOR Displaying Items
function sws_mg_items_display_func($atts) {
	$a=shortcode_atts(array(
	  'list_title' 	=> 'In Other News...',
	  'mgr_type' 	=> 'link',
	  'category' 	=> 'covid-19',
	  'sort_by' 	=> 'post_date',
	  'show_date' 	=> 'N',
	  'in_ul'		=> 'Y',
	  'sort_order' 	=> 'DESC',
	  'word_limit'	=> 30,
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
	
		$mytext="<h3 class='c-block__heading-title u-theme--color--darker'>".$a['list_title']."</h3>";	


	switch($a['mgr_type']) {
		default:
			if ($a['in_ul']=="Y") { $mytext.="<ul class='sws-ul'>"; }
			while ( $myItems->have_posts() ) :
				
				$myItems->the_post();
				
				if ($a['show_date']=="Y") { $dtext=" (".get_field('mgr_date').")";} else {$dtext="";}
				
				$mytext.="<li class='sws-li'><a href=\"".get_field('mgr_url')."\" target='_blank'>".wp_trim_words(get_the_title(),$a['word_limit'])."</a>$dtext</li>";
			
			endwhile;
		
			if ($a['in_ul']=="Y") { $mytext.="</ul>"; }
		break;
	}

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

	if ($container_class=="sws-accordion") { 
		$mytext.="<input type=\"checkbox\" id=\"toggle1\" class=\"sws-acc-ck\" /><label for=\"toggle1]\"><h3 class='".$a['heading_class']."'>".$a['list_title']."</h3></label>";	}
	else { 
		$mytext.="<h3 class='".$a['heading_class']."'>".$a['list_title']."</h3>";
	}
	
	$mytext.="<div class='".$a['subcontainer_class']."'><ul class='".$a['ul_class']."'>"; 
	
	$myCats=wp_list_categories( array('depth'=>$a['depth'],'hide_title_if_empty'=>$a['hide_empty'],'show_count'=>$a['show_count'],'echo'=>0,'exclude'=>$a['exclude'],'show_option_all'=>$a['show_option_all'],'title_li'=>''));
	
	$myCats.="</ul></div></div>"; 
		
	return $mytext.$myCats;
}

// register shortcode
add_shortcode('sws_display_categories', 'sws_mg_items_cat_func'); 

?>
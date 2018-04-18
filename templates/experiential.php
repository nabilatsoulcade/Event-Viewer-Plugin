<?php
/*
This is the Experiential template for the Event Viewer plugin.

The plugin is made to take different templates by including all PHP files in the /templates direectory.
So in order to make a new template, you simply create a new PHP file in this directory and create 2 functions,
one for printing the HTML, and one for printing the CSS. The name of the functions themselves are important as the
template name and the function name are the same. For example, in order to use this template in a shortcode you would
write [events template='default_template']. Futhermore, the function for your css should be the name of your function for printing
the individual events + "_css". So for example, since the function name for printing events is "default_template", the function for CSS
is named default_template_css (If this naming convention is not followed then the CSS will not be included)
*/

//This Function is what prints the individual events with the needed classes to style them
function experiential($post)
	{
	$returnvalue = '<div class="experiental_event row">';
	$returnvalue .= '<span class="experiental_category">' . $post['category'] . '</span>';
	$returnvalue .= '<p class="experiental_title">' . $post['title'] . '</p>';
	$sdate = new DateTime($post['starts']);
	$returnvalue .= '<p class="experiental_date">'  . date('F', strtotime($post['starts'])) . ' ' . date('j', strtotime($post['starts'])) . date('S', strtotime($post['starts'])) . ' at ' . $sdate->format('g:i a') . '</p>';
	$returnvalue .= '<p class="experiental_description">' . strip_tags(substr( $post['description'], 0,375)) . '...</p>';
	$returnvalue .=  "<a class='rss_event_read_more' href=" . $post['url'] . "> <button class='btn read-more'> Read More </button> </a>";
	$returnvalue .= '</div>';
	return $returnvalue;
	}

?>

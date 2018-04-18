<?php
/*
This is the default template for the Event Viewer plugin.

The plugin is made to take different templates by including all PHP files in the /templates direectory.
So in order to make a new template, you simply create a new PHP file in this directory and create 2 functions,
one for printing the HTML, and one for printing the CSS. The name of the functions themselves are important as the
template name and the function name are the same. For example, in order to use this template in a shortcode you would
write [events template='default_template']. Futhermore, the function for your css should be the name of your function for printing
the individual events + "_css". So for example, since the function name for printing events is "default_template", the function for CSS
is named default_template_css (If this naming convention is not followed then the CSS will not be included)
*/

//This Function is what prints the individual events with the needed classes to style them
function default_template($post){
$returnvalue = '<div class="rwevents clearfix">';
  $returnvalue .= '<div class=" column left">';
    $returnvalue .=  "<div class='ucf_rss_event_larger_date_text_day'>"  . date('j', strtotime($post['starts'])) . "</div>";
    $returnvalue .=  "<div class='ucf_rss_event_larger_date_text_month'>"  . date('M', strtotime($post['starts'])) . "</div>";
  $returnvalue .= '</div>';
  $returnvalue .= '<div class="column right">';
    $returnvalue .=  '<div class="event-title"><a href="'. $post['url'] .'" class="rss_event_title"> '. $post['title'] .' </a></div>';
                $sdate = new DateTime($post['starts']);
                $edate = new DateTime($post['ends']);
    $returnvalue .=  "<div class='rss_event_date'>"  . $sdate->format('g:i a') . " - " . $edate->format('g:i a') . "</div>";
    $returnvalue .=  "<div class='location'><p>" . $post['location'] . "</p></div>";
    $returnvalue .=  "<div class='rss_event_description'>" . strip_tags(substr( $post['description'], 0,375)) . " </div>";
    $returnvalue .=  "<a class='rss_event_read_more' href=" . $post['url'] . "> <button class='btn read-more'> Read More </button> </a>";
    $returnvalue .= '</div>';
$returnvalue .= '</div>';

return $returnvalue;
}

?>

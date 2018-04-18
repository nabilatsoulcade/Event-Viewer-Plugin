<?php
/*
These are the Bootstrap Based Templates for the Event Viewer plugin.

The plugin is made to take different templates by including all PHP files in the /templates direectory.
So in order to make a new template, you simply create a new PHP file in this directory and create 2 functions,
one for printing the HTML, and one for printing the CSS. The name of the functions themselves are important as the
template name and the function name are the same. For example, in order to use this template in a shortcode you would
write [events template='default_template']. Futhermore, the function for your css should be the name of your function for printing
the individual events + "_css". So for example, since the function name for printing events is "default_template", the function for CSS
is named default_template_css (If this naming convention is not followed then the CSS will not be included)
*/

/*
______             _       _                     _____                    _       _        ______                _   _
| ___ \           | |     | |                   |_   _|                  | |     | |       |  ___|              | | (_)
| |_/ / ___   ___ | |_ ___| |_ _ __ __ _ _ __     | | ___ _ __ ___  _ __ | | __ _| |_ ___  | |_ _   _ _ __   ___| |_ _  ___  _ __  ___
| ___ \/ _ \ / _ \| __/ __| __| '__/ _` | '_ \    | |/ _ \ '_ ` _ \| '_ \| |/ _` | __/ _ \ |  _| | | | '_ \ / __| __| |/ _ \| '_ \/ __|
| |_/ / (_) | (_) | |_\__ \ |_| | | (_| | |_) |   | |  __/ | | | | | |_) | | (_| | ||  __/ | | | |_| | | | | (__| |_| | (_) | | | \__ \
\____/ \___/ \___/ \__|___/\__|_|  \__,_| .__/    \_/\___|_| |_| |_| .__/|_|\__,_|\__\___| \_|  \__,_|_| |_|\___|\__|_|\___/|_| |_|___/
                                        | |                        | |
                                        |_|                        |_|
*/

//BOOTSTRAP CARD FUNCTION
function bootstrap_card($post)
      {
      $sdate = new DateTime($post['starts']);
      $returnvalue = '<div class="card">
        <h5 class="card-header">' . $post['title'] . ' - ' . $post['category'] . '</h5>
        <div class="card-body">
          <h5 class="card-title">'  . date('F', strtotime($post['starts'])) . ' ' . date('j', strtotime($post['starts'])) . date('S', strtotime($post['starts'])) . ' at ' . $sdate->format('g:i a') . '</h5>
          <p class="card-text">' . strip_tags(substr( $post['description'], 0,375)) . '</p>
          <a href="' . $post['url'] . '" class="btn btn-primary">Read More</a>
        </div>
      </div>';
      return $returnvalue;
      }

//BOOTSTRAP CALENDER CARD FUNCTION
function bootstrap_calendar_card($post)
      {
      $sdate = new DateTime($post['starts']);
      $edate = new DateTime($post['ends']);
      $returnvalue = '<div class="row row-striped">
            <div class="col-md-1">
      			   <div class="col-2 text-right">
      				<h1 class="display-4"><span class="badge badge-secondary"> ' . date('d', strtotime($post['starts'])) . ' </span></h1>
      				<h2> ' . date('M', strtotime($post['starts'])) . ' </h2>
      			     </div>
            </div>
            <div class="col-md-7">
      			<div class="col-10">
      				<div class = "calendar_event_title"><a href=" '.$post['url'].' " style=" text-decoration:none; color:#ffcc00; "><h3 class="text-uppercase"><strong> ' . $post['title'] . ' </strong></h3></a></div>
      				<ul class="list-inline">
      				    <li class="list-inline-item"><i class="fa fa-calendar" aria-hidden="true"></i> ' . date('l', strtotime($post['starts'])) . ' </li>
      					<li class="list-inline-item"><i class="fa fa-clock-o" aria-hidden="true"></i>  '  . $sdate->format('g:i a') .  ' - '  . $edate->format('g:i a') . '</li>
      					<li class="list-inline-item"><i class="fa fa-location-arrow" aria-hidden="true"></i> ' . $post['location'] . ' </li>
      				</ul>
      				<p> ' . strip_tags(substr( $post['description'], 0,375)) . '</p></div></div></div>';
      return $returnvalue;
      }

?>

<?php
/*
* Plugin Name: UCF Events Viewer
* Description: Display Events from the UCF Events Calender
* Version: 1.0
* Author: Nabil Sekirime
* Author URI: https://undergrad.ucf.edu/
*/

/*
 _   _  _____ ______   _____                      _     _   _  _
| | | |/  __ \|  ___| |  ___|                    | |   | | | |(_)
| | | || /  \/| |_    | |__  __   __  ___  _ __  | |_  | | | | _   ___ __      __  ___  _ __
| | | || |    |  _|   |  __| \ \ / / / _ \| '_ \ | __| | | | || | / _ \\ \ /\ / / / _ \| '__|
| |_| || \__/\| |     | |___  \ V / |  __/| | | || |_  \ \_/ /| ||  __/ \ V  V / |  __/| |
\___/  \____/\_|      \____/   \_/   \___||_| |_| \__|  \___/ |_| \___|  \_/\_/   \___||_|
*/

//Looks in template folder and includes all .php files inside
  foreach( glob(dirname(__FILE__) . '/Templates/*.php') as $class_path )
  		{
  			require_once( $class_path );
  		}

//Event Viewer Function
function ucf_event_viewer($atts){

//Get Attributes and set Variables
	$atts = shortcode_atts(
		array(
			'src' => 'http://events.ucf.edu/calendar/3117/college-of-undergraduate-studies/upcoming/feed.json',
			'amount' => '25',
			'template' => 'default_template',
			'debug' => 'false',
			'forcebackup' => 'true',
      'bootstrap' => 'false',
		),
		$atts
	);
  $src = $atts['src'];
	$forcebackup = $atts['forcebackup'];
  $amount = (int)$atts['amount'];
	$returnvalue = "";
	$postcount = $amount;
  $template = $atts['template'];
	$template_css = $template . '_css';
	$debug = $atts['debug'];
  $bootstrap = $atts['bootstrap'];
  $url = $src;
  $data = wp_remote_get($url); // put the contents of the file into a variable
	$data = wp_remote_retrieve_body($data);
  $posts = json_decode($data, true); // decode the JSON feed


//If there are no events, pull the events from DTL
if( empty( $posts ) )
if ($forcebackup == 'true')
	{
	$url = 'http://events.ucf.edu/calendar/3117/college-of-undergraduate-studies/upcoming/feed.json';
	}

//If the template does not exist than set it to the default
if( !is_callable( $template ) )
		{
		$template = 'default_template';
		}

//Debug mode (Prints debug data before the Events)
//If debug mode is enabled then print according data
if ($debug == 'true')
  {
  if( empty( $posts)) {$hasposts = 'No';}
  if( !empty( $posts)) {$hasposts = 'Yes';}

  $cssfilename = plugin_dir_url( __FILE__ ) . 'templates/css/' . $template . '.css';
  $header_response = get_headers($cssfilename,1);
  $file_exist = strpos($header_response[0],"404");

  if ($file_exist !== false)
    {
      $hastemplate='No';
    }

    else
    {
    $hastemplate='Yes';
    }
  $returnvalue .= '<h3>Debug Mode for UCF Event Viewer</h3>';
  $returnvalue .= '<h4>URL Info</h4>';
  $returnvalue .= '<h5>URL Entered:' . $src . '</h5>';
  $returnvalue .= '<h5>Does this URL have posts:' . $hasposts . '</h5>';
  $returnvalue .= '<h5>URL Used:' . $url . '</h5>';
  $returnvalue .= '<h4>Template Info</h4>';
  $returnvalue .= '<h5>Template Entered:' . $template . '</h5>';
  $returnvalue .= '<h5>Is the Template Active:' . $hastemplate . '</h5>';
  $returnvalue .= '<h5>Is the Template CSS Active:' . $hastemplatecss . '</h5>';
  $returnvalue .= '</br><p>Note: The URL for Events defaults to Undergraduate Studies and the Template for displaying them defaults to Default Template when these arguments are not provided</p>';
  }
if ($debug == 'help')
  {
  $returnvalue .= '<h3>Debug Mode for UCF Event Viewer</h3>';
  $returnvalue .= '<h4>List of Aguments for Event Viewer</h4>';
  $returnvalue .= '<h4>src:</h4><h5> The URL of the JSON file for the events | Defaults to UCF Undergraduate Studies if URL not provided or no posts are avaliable</h5>';
  $returnvalue .= '<h4>amount:</h4><h5> The amount of events to display</h5>';
  $returnvalue .= '<h4>template:</h4><h5> The Template to format the posts with | Defaults to default_template if argument not provided or template not found (Developers see <a href="' . dirname(__FILE__) . '/templates' . '/default.php' .  '"> plugin-active-directory/templates/default.php </a> for documentation on how to create templates in comments) </h5>';
  $returnvalue .= '<h4>debug:</h4><h5> Set plugin to debug mode | Set to "true" for variable dumps and information and to "help" for this prompt</h5>';
  }
//If there are posts, this will call the function associated with the variable to add all the formatted posts (This is where the function thats prints the HTML for each event in a template is called)
  if( !empty( $posts ) )
      {
      $count = 0;
      foreach( $posts as $post )
            {
            if( is_callable( $template ) )
              	{
              	$returnvalue .= $template($post);
              	}
            $count++;

            if($count == $postcount)
                {
                break;
                }
            }
      };

//Enqueue CSS into Wordpress
$cssfilename = plugin_dir_url( __FILE__ ) . 'templates/css/' . $template . '.css';
$header_response = get_headers($cssfilename,1);
$file_exist = strpos($header_response[0],"404");

if ($file_exist !== false)
	{
		$returnvalue .= '<h1> CSS was not found. File URL Below</h1>';
		$returnvalue .= '<h3>' . $cssfilename . '</h3>';
	}

	else
	{
		wp_register_style( 'simple_grid', plugin_dir_url( __FILE__ ) . 'templates/css/simple_grid.css');
    wp_enqueue_style( 'simple_grid' );

    wp_register_style( 'event_css', $cssfilename);
		wp_enqueue_style( 'event_css' );
	}

if ($bootstrap == 'true')
  {
    // JS
    wp_register_script('prefix_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js');
    wp_enqueue_script('prefix_bootstrap');

    // CSS
    wp_register_style('prefix_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');
    wp_enqueue_style('prefix_bootstrap');
  }
//Print out the posts where the shortcode is used
return $returnvalue;
}

//Add Shortcode to Wordpress
add_shortcode('events', 'ucf_event_viewer');
?>

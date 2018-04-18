<?php
//The Debug Mode Function (Not a template)
function debug_mode($debug,$template,$posts,$url){
  $returnvalue = '';
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
    return $returnvalue;
}
?>

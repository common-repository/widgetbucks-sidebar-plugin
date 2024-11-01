<?php
/*
Plugin Name: WidgetBucks Sidebar Plugin
Plugin URI: http://www.chris-fletcher/plug-ins/widgetbucks-sidebar-plugin
Description: This Plug-in will allow you to copy the generated widgetbucks code into wordpress and display it on the sidebar.
Version: 1.0
Author: Chris Fletcher
Author URI: http://www.chris-fletcher.com
*/
?>

<?php
$pluginpath = str_replace(str_replace('\\', '/', ABSPATH), get_settings('siteurl').'/', str_replace('\\', '/', dirname(__FILE__))).'/';

function widgetbucks($echo = 'true',
	$parameter1 = ''
	)
{
	$options = get_option('widgetbucks');
	$parameter1 = (($parameter1 != '') ? $parameter1 : $options['parameter1']);
	if($echo)
	{
		echo widgetbucks_return (
		$parameter1
		);
	}
	else
	{
		return widgetbucks_return (
		$parameter1
		);
	}
}

function widgetbucks_return (
	$parameter1
	)
{
	global $pluginpath;
	$output = '<!-- START CUSTOM WIDGETBUCKS CODE --><div><script src="http://api.widgetbucks.com/script/ads.js?uid=' . $parameter1 . '"></script></div><!-- END CUSTOM WIDGETBUCKS CODE -->';

	return($output);
}

function content_widgetbucks($content)
{
	if(preg_match('/<!--widgetbucks[\(]*(.(?)[\)]*-->/',$content,$matches))
	{
		$parameter1 =$matches[1];
		$content = preg_replace('/<!--widgetbucks(.*?)-->/',widgetbucks(false,$parameter1), $content);
	}
	return $content;
}

function widgetbucks_control()
{
	$options = get_option('widgetbucks');

	if ( !is_array($options) )
	{
		$options = array('title'=>'Widgetbucks',
		'parameter1'=>'Your Ad Code Here'
		);
	}
	if ( $_POST['widgetbucks-submit'] )
	{
		$options['title'] = strip_tags(stripslashes($_POST['widgetbucks-title']));

		$options['parameter1'] = strip_tags(stripslashes($_POST['widgetbucks-parameter1']));

		update_option('widgetbucks', $options);
	}

	$title = htmlspecialchars($options['title'], ENT_QUOTES);
	include $pluginpath . 'widgetbucks_control.inc.php';

}

//This function adds the options panel under the Settings menu of the admin interface
function widgetbucks_addMenu()
{
	add_options_page("WidgetBucks", "WidgetBucks", 8, __FILE__, 'widgetbucks_optionsMenu');
}

//This function displays the options panel
function widgetbucks_optionsMenu()
{
	echo '<div style="width:250px; margin:auto;"><form method="post">';
	widgetbucks_control();
	echo '<p class="submit"><input value="Save Changes >>" type="submit"></form></p></div>';
}

//This function is a wrapper for all the widget specific functions
//You can find out more about widgets here: http://automattic.com/code/widgets/
function widget_widgetbucks_init()
{
	if (!function_exists('register_sidebar_widget'))
		return;

	//This displays the plugin's output as a widget. You shouldn't need to modify it.
	function widget_widgetbucks($args)
	{
		extract($args);

		$options = get_option('widgetbucks');
		$title = $options['title'];

		echo $before_widget;
		echo $before_title . $title . $after_title;
		widgetbucks();
		echo $after_widget;
	}

	register_sidebar_widget('WidgetBucks', 'widget_widgetbucks');
	//You'll need to modify these two numbers to get the widget control the right size for your options
	//250 is a good width, but you'll need to change the 200 depending on how many options you add
	register_widget_control('WidgetBucks', 'widgetbucks_control', 250, 200);
}
add_action('plugins_loaded', 'widget_widgetbucks_init');

?>
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2003 - 2011, EllisLab, Inc.
 * @license		http://expressionengine.com/user_guide/license.html
 * @link		http://expressionengine.com
 * @since		Version 2.0
 * @filesource
 */
 
// ------------------------------------------------------------------------

/**
 * Ego Cookie Control Plugin
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Plugin
 * @author		Jon Carlisle, Ego Creative
 * @link		
 */

$plugin_info = array(
	'pi_name'		=> 'Ego Cookie Control',
	'pi_version'	=> '1.0',
	'pi_author'		=> 'Jon Carlisle, Ego Creative',
	'pi_author_url'	=> '',
	'pi_description'=> 'End User Cookie Agreement Notification',
	'pi_usage'		=> Ego_cookie_control::usage()
);


class Ego_cookie_control {

	public $return_data;
    
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->EE =& get_instance();
	}
	
	// ----------------------------------------------------------------
	
	/**
	 * Plugin Usage
	 */
	public static function usage()
	{
		ob_start();
?>

Checks to see whether a cookie agreement is in place, if not renders the code between the tags or sets the cookie if the user has clicked yuppers.
PHP function only, needs javascript enhancement.

<?php
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
	
	// ----------------------------------------------------------------
	public function test()
	{
		return null;
	}
	public function display()
	{
		# is the cookie control accepted
		if (isset($_COOKIE['exp_ego_cookie_control']) && $_COOKIE['exp_ego_cookie_control'] == 'agreed') {
			# yup, done, stop
			return null;
		} else {	
			# is there any GET data to process
			if (isset($_GET['ego_cookie_response']) && $_GET['ego_cookie_response'] == 'agreed') {
				$this->EE->functions->set_cookie('ego_cookie_control', 'agreed', 31536000);
				# yup, done, stop
				return null;
			} else {
				# otherwise lets render out the control html - first off lets get the tagdata
				$tagdata = $this->EE->TMPL->tagdata;
				# work out what the correct link should be, if there is GET data just add ot it otherwise add a new query string
				if ($_GET) {
					$link = $_SERVER['REQUEST_URI'] . '&ego_cookie_response=agreed';
				} else {
					$link = $_SERVER['PATH_INFO'] . '?ego_cookie_response=agreed';
				}
				# replace all {link} with the correctomundo links
				$tagdata = str_replace('{link}', $link, $tagdata);
				# return the modified tagdata to the tmpl
				return $tagdata;
			}
		}
	}
}


/* End of file pi.ego_cookie_control.php */
/* Location: /system/expressionengine/third_party/ego_cookie_control/pi.ego_cookie_control.php */
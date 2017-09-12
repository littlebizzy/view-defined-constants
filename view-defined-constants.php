<?php
/*
Plugin Name: View Defined Constants
Plugin URI: https://www.littlebizzy.com
Description: Displays all defined constants found by PHP (and WordPress) using a simple print method that can be easily accessed under the Tools menu in WP Admin.
Version: 1.0
Author: LittleBizzy
Author URI: https://www.littlebizzy.com
License: GPL3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

// Avoid script calls via plugin URL
if (!function_exists('add_action'))
	die;

// This plugin constants
define('VWDFCS_FILE', __FILE__);
define('VWDFCS_PATH', dirname(VWDFCS_FILE));
define('VWDFCS_VERSION', '1.0.0');

// Quick context check
if (!is_admin() || (defined('DOING_AJAX') && DOING_AJAX))
	return;


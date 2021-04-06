<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = 'index';
$route['404_override'] = 'Error404';

$route[config_item('uri_segment_admin') . '/preview/adminshow/(.+)'] = "$1";

if (config_item('uri_segment_admin') !== 'admin') {
	$route['admin'] = '_show404notfounderrorpage';
	$route[config_item('uri_segment_admin')] = 'admin';

	$route['admin/(.+)'] = '_show404notfounderrorpage';
	$route[config_item('uri_segment_admin') . '/(.+)'] = "admin/$1";
}

$route[config_item('uri_segment_board') . '/([a-zA-Z0-9_-]+)'] = "board_post/lists/$1";
$route[config_item('uri_segment_board') . '/ajax/([a-zA-Z0-9_-]+)'] = "board_post/ajax_lists/$1";
if (strtoupper(config_item('uri_segment_post_type')) === 'B') {
	$route['([a-zA-Z0-9_-]+)/' . config_item('uri_segment_post') . '/([0-9]+)'] = "board_post/post/$2";
} else if (strtoupper(config_item('uri_segment_post_type')) === 'C') {
	$route[config_item('uri_segment_post') . '/([a-zA-Z0-9_-]+)/([0-9]+)'] = "board_post/post/$2";
} else {
	$route[config_item('uri_segment_post') . '/([0-9]+)'] = "board_post/post/$1";
    $route[config_item('uri_segment_post') . '/ajax/([0-9]+)'] = "board_post/ajax_post/$1";
}
$route[config_item('uri_segment_write') . '/([a-zA-Z0-9_-]+)'] = "board_write/write/$1";
$route[config_item('uri_segment_reply') . '/([0-9]+)'] = "board_write/reply/$1";
$route[config_item('uri_segment_modify') . '/([0-9]+)'] = "board_write/modify/$1";
$route[config_item('uri_segment_rss') . '/([a-zA-Z0-9_-]+)'] = "rss/index/$1";
$route[config_item('uri_segment_group') . '/([a-zA-Z0-9_-]+)'] = "group/index/$1";
$route[config_item('uri_segment_document') . '/([a-zA-Z0-9_-]+)'] = "document/index/$1";
$route[config_item('uri_segment_faq') . '/([a-zA-Z0-9_-]+)'] = "faq/index/$1";
$route['profile/([a-zA-Z0-9_-]+)'] = "profile/index/$1";
$route['print/([0-9]+)'] = "board_post/post/$1/print";
$route['sitemap\.xml'] = "sitemap";
$route['sitemap_([0-9_-]+)\.xml'] = "sitemap/board/$1";
$route['board_info/(:any)'] = "board_info/index/$1";

$route[config_item('uri_segment_cmall_item') . '/([a-zA-Z0-9_-]+)'] = "cmall/item/$1";
$route[config_item('uri_segment_cmall_item') . '/ajax/([a-zA-Z0-9_-]+)'] = "cmall/ajax_item/$1";

$route['beatsomeone'] = "brandshop/shop/beatsomeone";
$route['brandshop/(:any)'] = "brandshop/shop/$1";
$route['brandshop'] = "brandshop/integrate";
$route['sublist'] = "index/sublist";
$route['detail/(:any)'] = "index/detail/$1";
$route['notsupport'] = "index/notsupport";


$route['ko/' . config_item('uri_segment_board') . '/([a-zA-Z0-9_-]+)'] = "board_post/lists/$1";
$route['ko/' . config_item('uri_segment_board') . '/ajax/([a-zA-Z0-9_-]+)'] = "board_post/ajax_lists/$1";
if (strtoupper(config_item('uri_segment_post_type')) === 'B') {
    $route['ko/([a-zA-Z0-9_-]+)/' . config_item('uri_segment_post') . '/([0-9]+)'] = "board_post/post/$2";
} else if (strtoupper('ko/' . config_item('uri_segment_post_type')) === 'C') {
    $route['ko/' . config_item('uri_segment_post') . '/([a-zA-Z0-9_-]+)/([0-9]+)'] = "board_post/post/$2";
} else {
    $route['ko/' . config_item('uri_segment_post') . '/([0-9]+)'] = "board_post/post/$1";
    $route['ko/' . config_item('uri_segment_post') . '/ajax/([0-9]+)'] = "board_post/ajax_post/$1";
}
$route['ko/' . config_item('uri_segment_write') . '/([a-zA-Z0-9_-]+)'] = "board_write/write/$1";
$route['ko/' . config_item('uri_segment_reply') . '/([0-9]+)'] = "board_write/reply/$1";
$route['ko/' . config_item('uri_segment_modify') . '/([0-9]+)'] = "board_write/modify/$1";
$route['ko/' . config_item('uri_segment_rss') . '/([a-zA-Z0-9_-]+)'] = "rss/index/$1";
$route['ko/' . config_item('uri_segment_group') . '/([a-zA-Z0-9_-]+)'] = "group/index/$1";
$route['ko/' . config_item('uri_segment_document') . '/([a-zA-Z0-9_-]+)'] = "document/index/$1";
$route['ko/' . config_item('uri_segment_faq') . '/([a-zA-Z0-9_-]+)'] = "faq/index/$1";
$route['ko/profile/([a-zA-Z0-9_-]+)'] = "profile/index/$1";
$route['ko/print/([0-9]+)'] = "board_post/post/$1/print";
$route['ko/sitemap\.xml'] = "sitemap";
$route['ko/sitemap_([0-9_-]+)\.xml'] = "sitemap/board/$1";
$route['ko/board_info/(:any)'] = "board_info/index/$1";

$route['ko/' . config_item('uri_segment_cmall_item') . '/([a-zA-Z0-9_-]+)'] = "cmall/item/$1";
$route['ko/' . config_item('uri_segment_cmall_item') . '/ajax/([a-zA-Z0-9_-]+)'] = "cmall/ajax_item/$1";

$route['ko/beatsomeone'] = "brandshop/shop/beatsomeone";
$route['ko/brandshop/(:any)'] = "brandshop/shop/$1";
$route['ko/brandshop'] = "brandshop/integrate";
$route['ko/sublist'] = "index/sublist";
$route['ko/detail/(:any)'] = "index/detail/$1";
$route['ko/notsupport'] = "index/notsupport";

$route['(\ko|en)/(.*)'] = '$2';
$route['(\ko|en)'] = $route['default_controller'];

//$route['(\w{2})/(.*)'] = '$2';
//$route['(\w{2})'] = $route['default_controller'];

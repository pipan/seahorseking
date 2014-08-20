<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
//CMS
$route['cms/(:any)'] = "cms/$1";
$route['cms'] = "cms/login";
//logout
$route['cms/logout'] = "cms/login/logout";
//article
$route['(:any)/article/tag/(:num)/(:any)'] = "article/tag/$3/$2/$1";
$route['(:any)/article/tag/(:any)'] = "article/tag/$2/1/$1";
$route['(:any)/article/view/(:any)'] = "article/view/$2/$1";
$route['(:any)/article/(:num)'] = "article/index/$1/$2";
$route['article/(:num)'] = "article/index/lang/$1";
$route['(:any)/article'] = "article/index/$1";
$route['article'] = "article/index";
//project
$route['(:any)/project/tag/(:num)/(:any)'] = "project/tag/$3/$2/$1";
$route['(:any)/project/tag/(:any)'] = "project/tag/$2/1/$1";
$route['(:any)/project/view/(:num)/(:any)'] = "project/view/$3/$2/$1";
$route['(:any)/project/view/(:any)'] = "project/view/$2/1/$1";
$route['(:any)/project/gallery/(:any)'] = "project/gallery/$2/$1";
$route['(:any)/project/(:num)'] = "project/index/$1/$2";
$route['project/(:num)'] = "project/index/lang/$1";
$route['(:any)/project'] = "project/index/$1";
$route['project'] = "project/index";
//member
$route['(:any)/member/(:num)'] = "member/index/$1/$2";
$route['member/(:num)'] = "member/index/lang/$1";
$route['(:any)/member'] = "member/index/$1";
$route['member'] = "member/index";
//static
$route['(:any)/(:any)'] = "static_page/index/$2/$1";
$route['(:any)'] = "article/index/$1";

$route['default_controller'] = "article";
//$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */
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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'Home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


//auth
$route['datacenter']	= 'Auth';
$route['auth/login']	= 'Auth/login';
$route['auth/logout']	= 'Auth/logout';

//dashboard
$route['dashboard']	= 'Dashboard';

$route['informasi_public']	= 'Home/informasi_public';
$route['visi_misi']			= 'Home/visi_misi';
$route['struktur_bawaslu']	= 'Home/struktur_bawaslu';
$route['dasar_hukum']		= 'Home/dasar_hukum';


//admin
$route['admin/file']		='Admin/File';
$route['admin/get_data_file']		= 'Admin/File/get_data_file';
$route['admin/insert_file']			= 'Admin/File/insert';
$route['admin/edit/(:num)']			= 'Admin/File/update/$1';
$route['admin/public/(:num)']		= 'Admin/File/public/$1';
$route['admin/private/(:num)']		= 'Admin/File/private/$1';
$route['admin/deleteFile/(:num)']	= 'Admin/File/delete/$1';


$route['admin/petugas']				= 'Admin/Petugas';
$route['admin/get_data_petugas']	= 'Admin/Petugas/get_data_petugas';
$route['admin/insert_petugas']		= 'Admin/Petugas/insert';
$route['admin/edit_petugas/(:num)'] = 'Admin/Petugas/update/$1';
$route['admin/register_petugas']	= 'Admin/Petugas/register';
$route['admin/deletePetugas/(:num)'] = 'Admin/Petugas/delete/$1';
$route['admin/updatePetugas/(:num)'] = 'Admin/Petugas/update/$1';


//petugas
$route['petugas/profile']		= 'Users/Petugas';
$route['petugas/update_profile']= 'Users/Petugas/profile';
$route['petugas/file']			= 'Users/Petugas/file';
$route['petugas/get_data_file']	= 'Users/Petugas/get_data_file';

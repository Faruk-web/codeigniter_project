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
$route['form_validation'] = 'form_validation';
$route['default_controller'] = 'website';
$route['404_override'] = 'templates/error';
$route['translate_uri_dashes'] = FALSE;

/*Website Route*/
$route['history'] = 'website/history';
$route['constitution'] = 'website/constitution';
$route['activities'] = 'website/activities';
$route['president-message'] = 'website/presidentMessage';
$route['secretary-message'] = 'website/secretaryMessage';
$route['admission-form'] = 'website/admissionForm';
$route['present-committee'] = 'website/presentCommittee';
$route['previous-committees'] = 'website/previousCommittee';
$route['committee/(:any)'] = 'website/committee/$1';
$route['office-staff'] = 'website/officeStaff';
$route['membership'] = 'website/membership';
$route['membership/lists'] = 'website/membership';
$route['membership/lists/(:any)'] = 'website/membership/$1';
$route['membership/details/(:any)'] = 'website/membershipDetails/$1';
$route['membership/change-details/(:any)'] = 'website/membershipChange/$1';
$route['membership/update-details/(:any)'] = 'website/membershipUpdate/$1';
$route['news-event'] = 'website/newsEvent';
$route['news-event-details/(:any)'] = 'website/newsEventDetails/$1';
$route['gallery'] = 'website/gallery';
$route['contact-us'] = 'website/contact';
$route['send-mail'] = 'website/contactSend';

//Password Reset...
$route['login'] = 'auth';
$route['password/reset'] = 'auth/password';
$route['password/reset'] = 'auth/password';
$route['password/email'] = 'auth/password/email';
$route['password/sent'] = 'auth/password/sent';
$route['password/resetform/(:any)'] = 'auth/password/resetform/$1';
$route['password/update'] = 'auth/password/update';
$route['password/success'] = 'auth/password/success';

//Logout...
$route['logout'] = 'auth/logout';

//Login Admin Profile Details...
$route['profile'] = 'auth/profile';
$route['profile/edit'] = 'auth/profile/edit';
$route['profile/update'] = 'auth/profile/update';
$route['profile/password'] = 'auth/profile/password';
$route['profile/change'] = 'auth/profile/change';
$route['profile/avatar'] = 'auth/profile/avatar';
$route['profile/upload'] = 'auth/profile/upload';


/*Website Route*/
$route['case-related-to-cabinet-division'] = 'website/casesOne';
$route['case-administrative-tribunal'] = 'website/casesTwo';
$route['case-administrative-appellate-tribunal'] = 'website/casesThree';
$route['case-details/(:num)'] = 'website/casesDetails/$1';
$route['writ-petition'] = 'website/writPetition';
$route['writ-petition-details/(:num)'] = 'website/writPetitionDetails/$1';
$route['opinions'] = 'website/opinions';
$route['laws-examination-committee'] = 'website/examinationCommittee';
$route['important-judgment'] = 'website/importantJudgment';
$route['miscellaneous-notes'] = 'website/miscellaneous';
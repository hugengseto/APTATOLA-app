<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/employee', 'Employee::index');
$routes->get('/employee/create', 'Employee::create');
$routes->get('/employee/edit/(:num)', 'Employee::edit/$1');
$routes->get('/transaction', 'Transaction::index');
$routes->get('/transaction/create', 'Transaction::create');
$routes->get('/transaction/edit/(:num)', 'Transaction::edit/$1');
$routes->get('/transaction/payment', 'Transaction::payment');
$routes->get('/transaction/getCustomerData/(:any)', 'Transaction::getCustomerData/$1');
$routes->get('/transaction/invoice/(:any)', 'Transaction::invoice/$1');
$routes->get('/transaction/invoicePrint/(:any)', 'Transaction::invoicePrint/$1');
$routes->get('/transaction/detail/(:any)', 'Transaction::detail/$1');
$routes->get('/transaction/reports', 'Transaction::reports');
$routes->get('/transaction/getTransactionWithEmployeeData', 'Transaction::getTransactionWithEmployeeData');
$routes->get('/pdf/generateReport', 'Pdf::generateReport');
$routes->get('/package', 'Package::index');
$routes->get('/package/create', 'Package::create');
$routes->get('/package/edit/(:num)', 'Package::edit/$1');
$routes->get('/store', 'Store::index');
$routes->get('/profile/information', 'Profile::index');

$routes->post('/auth', 'Auth::login');
$routes->post('/logout', 'Auth::logout');
$routes->post('/employee/save', 'Employee::save');
$routes->post('/employee/update/(:num)', 'Employee::update/$1');
$routes->post('/transaction/save', 'Transaction::save');
$routes->post('/transaction/repeatTransaction', 'Transaction::repeatTransaction');
$routes->post('/transaction/update/(:num)', 'Transaction::update/$1');
$routes->post('/transaction/updateStatus/(:num)', 'Transaction::updateStatus/$1');
$routes->post('/transaction/paymentAction', 'Transaction::paymentAction');
$routes->post('/transaction/sendInvoiceFirst/(:any)', 'Transaction::sendInvoiceFirst/$1');
$routes->post('/transaction/sendInvoice/(:any)', 'Transaction::sendInvoice/$1');
$routes->post('/package/save', 'Package::save');
$routes->post('/package/update/(:num)', 'Package::update/$1');
$routes->post('/pdf/reportPdf', 'Pdf::index');
$routes->post('/pdf/reportPdf', 'Pdf::index');
$routes->post('/store/update', 'Store::update');
$routes->post('/profile/update', 'Profile::update');
$routes->post('/profile/updatePassword/(:any)', 'Profile::updatePassword/$1');

$routes->delete('/package/(:num)', 'Package::remove/$1');
$routes->delete('/employee/(:num)', 'Employee::remove/$1');
$routes->delete('/transaction/(:num)', 'Transaction::remove/$1');

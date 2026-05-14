<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ตั้งหน้าแรกเป็นหน้าหลัก
$routes->get('/', 'User::index');

$routes->get('register', 'Home::register');

// ตั้งหน้าแรกเป็นหน้าหลัก
$routes->get('home/default', 'DashboardController::index');

// เส้นทางหน้าแสดงข้อมูล
$routes->get('home/emtyjob', 'Home::empty_job');
$routes->get('home/submitResume', 'Home::resume_job');
$routes->get('home/promote', 'Home::promote');
$routes->get('home/report', 'Home::report_list');
$routes->get('student/list', 'Student::index');

// เส้นทางสำหรับการจัดการข้อมูล
$routes->get('home/delete/(:num)', 'Home::delete/$1'); // ลบข้อมูลตาม ID
$routes->get('home/details/(:num)', 'Home::details/$1'); // แสดงรายละเอียดตาม ID
$routes->get('home/report_details/(:num)', 'Home::report_details/$1'); // แสดงรายละเอียดตาม ID
$routes->post('home/updateStatus/(:num)', 'Home::updateStatus/$1'); // อัพเดทสถานะตาม ID
$routes->get('promote_details/(:num)', 'Home::promote_details/$1'); // แสดงรายละเอียดตาม ID
$routes->get('student_details/(:num)', 'Student::student_details/$1'); // แสดงรายละเอียดตาม ID
$routes->get('resume_details/(:num)', 'Home::resume_details/$1'); // แสดงรายละเอียดตาม ID

// เส้นทางสำหรับ Ajax
$routes->get('/home/getAlertsAjax', 'Home::getAlertsAjax');

$routes->group('user', function ($routes) {
    $routes->get('/', 'User::index');
    $routes->get('form_test', 'User::form_test');
    $routes->get('form_history', 'User::form_history');
    $routes->get('form_part_time', 'User::form_part_time');
    $routes->post('save', 'User::save');
    $routes->post('save_history', 'User::save_history');
    $routes->post('save_student', 'User::save_student');
    $routes->get('status/(:num)', 'User::status/$1');
    $routes->get('get-status/(:num)', 'User::getStatus/$1');
});

$routes->get('company/company_list', 'CompanyController::index');
$routes->post('company/bulkAction', 'CompanyController::bulkAction');
$routes->get('company/summary', 'CompanyController::summary');
$routes->get('company/saveSelection', 'CompanyController::saveSelection');
$routes->get('company/addCompany', 'CompanyController::addCompany');
$routes->post('company/saveAdd_company', 'CompanyController::saveAdd_company');
$routes->post('company/chk_company', 'CompanyController::chk_company');
$routes->get('company/coppy_list', 'CompanyController::coppy_list');
$routes->post('company/saveSelection', 'CompanyController::saveSelection');


$routes->get('generate-resume/(:num)', 'PdfController::generateResume/$1');

$routes->get('/login', 'AuthController::login');
$routes->post('/authcontroller/loginauth', 'AuthController::loginAuth');
$routes->get('/logout', 'AuthController::logout');

$routes->get('/employeecontroller/create', 'EmployeeController::create');
$routes->post('/employeecontroller/save', 'EmployeeController::save');
$routes->post('/employeecontroller/updateProfile', 'EmployeeController::updateProfile');
$routes->get('/employeecontroller/profile', 'EmployeeController::profile');
$routes->post('/employeecontroller/updatePassword', 'EmployeeController::updatePassword');
$routes->get('/employeecontroller/employee-list', 'EmployeeController::employeeList');
$routes->get('/employeecontroller/deleteEmployee/(:num)', 'EmployeeController::deleteEmployee/$1');
$routes->post('/employeecontroller/updateEmployee', 'EmployeeController::updateEmployee');

$routes->get('test-email', 'EmailController::send');






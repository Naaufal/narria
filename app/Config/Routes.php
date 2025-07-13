<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Public routes (dapat diakses semua orang termasuk guest) 
$routes->get('/', 'Home::index');
$routes->get('novels', 'Home::novels');
$routes->get('search', 'Home::search');
$routes->get('novel/(:num)', 'Home::novel/$1');
$routes->get('novel/(:num)/chapter/(:num)', 'Home::chapter/$1/$2');
$routes->get('categories', 'Home::category');
$routes->get('category/(:segment)', 'Home::category/$1');

// Bookmark routes
$routes->get('profile/bookmarks', 'Profile::bookmarks');
$routes->post('toggle-bookmark', 'Profile::toggleBookmark');
$routes->get('check-bookmark/(:num)', 'Profile::checkBookmark/$1');

// profile routes
$routes->get('profile/edit', 'Profile::edit');         
$routes->post('profile/update', 'Profile::update');      
$routes->get('profile', 'Profile::index');
$routes->get('profile/history', 'Profile::history');
$routes->get('profile/(:segment)', 'Profile::index/$1');

// Auth Routes
$routes->group('', function ($routes) {
    $routes->get('login', 'Auth::login', ['as' => 'login']);
    $routes->post('login', 'Auth::authLogin');
    $routes->get('register', 'Auth::register', ['as' => 'register']);
    $routes->post('register', 'Auth::authRegister');
    $routes->get('logout', 'Auth::logout', ['as' => 'logout']);
});


// Author Routes
$routes->group('author', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'Author::dashboard');
    $routes->get('dashboard', 'Author::dashboard');
    
    // Novel Routes
    $routes->get('novels', 'Author::novels');
    $routes->get('novels/create', 'Author::create');
    $routes->post('novels', 'Author::store');
    $routes->get('novels/edit/(:num)', 'Author::edit/$1');
    $routes->put('novels/(:num)', 'Author::update/$1');
    $routes->post('novels/delete/(:num)', 'Author::delete/$1');
    
    // Chapter Routes
    $routes->get('novels/(:num)/chapters', 'Author::chapters/$1');
    $routes->get('novels/(:num)/chapters/create', 'Author::createChapter/$1');
    $routes->post('novels/(:num)/chapters', 'Author::storeChapter/$1');
    $routes->get('novels/(:num)/chapters/(:num)/edit', 'Author::editChapter/$1/$2');
    $routes->put('novels/(:num)/chapters/(:num)', 'Author::updateChapter/$1/$2');
    $routes->delete('novels/(:num)/chapters/(:num)', 'Author::destroyChapter/$1/$2');
});

// Admin Routes 
$routes->group('admin', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('', 'Admin::dashboard');
    $routes->get('dashboard', 'Admin::dashboard');
    $routes->get('users', 'Admin::users');
    $routes->get('users/create', 'Admin::create');
    $routes->post('users', 'Admin::store');
    $routes->get('users/edit/(:any)', 'Admin::edit/$1');
    $routes->put('users/(:any)', 'Admin::update/$1');
    $routes->delete('users/(:num)', 'Admin::destroy/$1');
    $routes->get('novels', 'Admin::novels');
    $routes->get('novel/upload', 'Admin::novelCreate');
    $routes->post('novel/store', 'Admin::novelStore');
    $routes->get('categories', 'Admin::category');
    $routes->delete('novels/(:num)', 'Admin::novelDestroy/$1');
});

$routes->group('errors', function ($routes) {
    $routes->get('403', 'error::noAccess');
    $routes->get('404', 'error::notFound');

});


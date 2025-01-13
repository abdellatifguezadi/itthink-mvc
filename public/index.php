<?php
session_start();

require_once('../core/BaseController.php');
require_once '../core/Router.php';
require_once '../core/Route.php';
require_once '../app/controllers/HomeController.php';
require_once '../app/controllers/AuthController.php';
require_once '../app/controllers/AdminController.php';
require_once '../app/controllers/ClientController.php';
require_once '../app/config/db.php';

$router = new Router();
Route::setRouter($router);

// Define routes
// auth routes 
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'handleRegister']);
Route::get('/login', [AuthController::class, 'showleLogin']);
Route::post('/login', [AuthController::class, 'handleLogin']);
Route::post('/logout', [AuthController::class, 'logout']);

// admin routes
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/admin/users', [AdminController::class, 'handleUsers']);
Route::get('/admin/categories', [AdminController::class, 'hundelcat']);
Route::get('/admin/testimonials', [AdminController::class, 'handleTesto']);
Route::get('/admin/projects', [AdminController::class, 'handleProjet']);
Route::post('/remove_user', [AdminController::class, 'removeUser']);
Route::post('/status_user', [AdminController::class, 'changeStatus']);
Route::post('/add_Update_Cat', [AdminController::class, 'addUpdatCat']);
Route::post('/add_Update_SubCat', [AdminController::class, 'addUpdatSubCat']);
Route::post('/delete_cat', [AdminController::class, 'deleteCat']);
Route::post('/delete_sub_cat', [AdminController::class, 'deleteSubCat']);
Route::post('/delete_projet', [AdminController::class, 'removeProject']);
Route::post('/delete_testo', [AdminController::class, 'removeTesto']);

// client routes
Route::get('/client', [ClientController::class, 'index']);
Route::get('/client/projects', [ClientController::class, 'handleProjetUser']);
Route::get('/client/offres', [ClientController::class, 'handleoffres']);
Route::get('/client/testimonials', [ClientController::class, 'handleTesto']);
Route::post('/drop_project', [ClientController::class, 'dropProject']);
Route::post('/add_updat_user_projet', [ClientController::class, 'addUpdateUserProjet']);
Route::post('/accept_offre', [ClientController::class, 'acceptOffres']);
Route::post('/addorupdatetesto', [ClientController::class, 'addUpdateTesto']);
Route::post('/remove_testo_user', [ClientController::class, 'removeUserTesto']);


// Dispatch the request
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

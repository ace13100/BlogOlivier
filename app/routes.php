<?php 

/**
 * On définit le tableau des routes : on associe à chaque route un fichier PHP 
 * qui jouera la rôle de contrôleur. Par exemple pour la page d'accueil, c'est un fichier home.php
 * qui sera inclus. Pour la page Images, ce sera un fichier Picture.php, etc
 */
$routes = [

    // Route de la page d'accueil
    'homepage' => [
        'path' => '/',
        'controller' => 'Home',
        'method' => 'index'
    ],

    // Route de la page des Images
    'picture' => [
        'path' => '/Picture',
        'controller' => 'Picture',
        'method' => 'index'
    ],


    'signup' => [
        'path' => '/signup',
        'controller' => 'Account',
        'method' => 'signup'
    ],

    'login' => [
        'path' => '/login',
        'controller' => 'Auth',
        'method' => 'login'
    ],

    'logout' => [
        'path' => '/logout',
        'controller' => 'Auth',
        'method' => 'logout'
    ],
    
    'admin' => [
        'path' => '/admin',
        'controller' => 'Admin\\Admin',
        'method' => 'index'
    ],

    'admin_picture_new' => [
        'path' => '/admin/picture/new',
        'controller' => 'Admin\\Picture',
        'method' => 'new'
    ],

    'admin_picture_edit' => [
        'path' => '/admin/article/edit',
        'controller' => 'Admin\\Picture',
        'method' => 'edit'
    ],

    'admin_picture_delete' => [
        'path' => '/admin/article/delete',
        'controller' => 'Admin\\Picture',
        'method' => 'delete'
    ],



    'user' => [
        'path' => '/user',
        'controller' => 'User\\User',
        'method' => 'index'
    ],

    'user_picture_new' => [
        'path' => '/user/picture/new',
        'controller' => 'User\\Picture',
        'method' => 'new'
    ],

    'user_picture_edit' => [
        'path' => '/user/picture/edit',
        'controller' => 'user\\Picture',
        'method' => 'edit'
    ],

    'user_picture_delete' => [
        'path' => '/user/picture/delete',
        'controller' => 'User\\Picture',
        'method' => 'delete'
    ]






];

define('ROUTES', $routes);

return $routes;
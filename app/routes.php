<?php 

/**
 * On définit le tableau des routes : on associe à chaque route un fichier PHP 
 * qui jouera la rôle de contrôleur. Par exemple pour la page d'accueil, c'est un fichier home.php
 * qui sera inclus. Pour la page Article, ce sera un fichier article.php, etc
 */
$routes = [

    // Route de la page d'accueil
    'homepage' => [
        'path' => '/',
        'controller' => 'Home',
        'method' => 'index'
    ],

    // Route de la page Article
    'article' => [
        'path' => '/article',
        'controller' => 'Article',
        'method' => 'index'
    ],

    'add-comment' => [
        'path' => '/add-comment',
        'controller' => 'Article',
        'method' => 'addComment'
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

    'admin_article_new' => [
        'path' => '/admin/article/new',
        'controller' => 'Admin\\Article',
        'method' => 'new'
    ],

    'admin_article_edit' => [
        'path' => '/admin/article/edit',
        'controller' => 'Admin\\Article',
        'method' => 'edit'
    ],

    'admin_article_delete' => [
        'path' => '/admin/article/delete',
        'controller' => 'Admin\\Article',
        'method' => 'delete'
    ]






];

define('ROUTES', $routes);

return $routes;
<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Auth
$r->group(['prefix' => 'auth'], function ($r) {
    // Registration
    $r->get('register', 'Auth\AuthController@getRegister');
    $r->post('register', 'Auth\AuthController@postRegister');

    // Activation
    $r->get(
        'activate/{token}',
        ['as' => 'auth.get.activation', 'uses' => 'Auth\AuthController@getActivation']
    );
    $r->post(
        'activate',
        ['as' => 'auth.post.activation', 'uses' => 'Auth\AuthController@postActivation']
    );

    // Login
    $r->get('login', 'Auth\AuthController@getLogin');
    $r->post('login', 'Auth\AuthController@postLogin');
    $r->get('logout', 'Auth\AuthController@getLogout');

    // Password reset
    $r->get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    $r->post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    $r->post('password/reset', 'Auth\PasswordController@reset');

    // Socialite
    $r->get('{provider}', 'Auth\AuthController@redirectToProvider');
    $r->get('{provider}/callback', 'Auth\AuthController@handleProviderCallback');
});

// Account
$r->group(['prefix' => 'account', 'as' => 'account.'], function ($r) {
    // Settings & logins
    $r->get(
        'settings',
        ['as' => 'settings', 'uses' => 'User\AccountController@getSettings']
    );
    $r->post('settings', 'User\AccountController@postSettings');
    $r->get(
        '{provider}/disconnect',
        ['as' => 'disconnect-login', 'uses' => 'User\AccountController@getDisconnectLogin']
    );
    $r->post('{provider}/disconnect', 'User\AccountController@postDisconnectLogin');

    // Profile
    $r->get('profile', 'User\AccountController@redirectToProfile');
    $r->get(
        'profile/edit',
        ['as' => 'profile.edit', 'uses' => 'User\AccountController@getEditProfile']
    );
    $r->post('profile/edit', 'User\AccountController@postEditProfile');
});

// User
$r->group(['prefix' => 'user', 'as' => 'user.'], function ($r) {
    // Profiles
    $r->get(
        '{id}-{name}',
        ['as' => 'profile', 'uses' => 'User\ProfileController@show']
    );
});

// Home
$r->get(
    '/',
    ['as' => 'home', 'uses' => 'HomeController@show']
);

// Events
$r->group(['prefix' => 'events', 'as' => 'event.'], function ($r) {
    $r->get('/', 'EventController@index');
    $r->get(
        '{event}-{name}',
        ['as' => 'show', 'uses' => 'EventController@show']
    );
});

// Image gallery
$r->group(['prefix' => 'gallery', 'as' => 'image-album.'], function ($r) {
    $r->get('/', 'ImageAlbumController@index');
    $r->get(
        '{album}-{title}',
        ['as' => 'show', 'uses' => 'ImageAlbumController@show']
    );
    $r->get(
        'create',
        ['as' => 'create', 'uses' => 'ImageAlbumController@create']
    );
    $r->post(
        'create',
        ['as' => 'store', 'uses' => 'ImageAlbumController@store']
    );
    $r->get(
        '{album}/edit',
        ['as' => 'edit', 'uses' => 'ImageAlbumController@edit']
    );
    $r->patch(
        '{album}',
        ['as' => 'update', 'uses' => 'ImageAlbumController@update']
    );
    $r->delete(
        '{album}',
        ['as' => 'delete', 'uses' => 'ImageAlbumController@delete']
    );
});

// Comments
$r->group(['prefix' => 'comments', 'as' => 'comment.'], function ($r) {
    $r->post(
        '{model}/{id}',
        ['as' => 'store', 'uses' => 'CommentController@store']
    );
    $r->get(
        '{comment}/edit',
        ['as' => 'edit', 'uses' => 'CommentController@edit']
    );
    $r->patch(
        '{comment}',
        ['as' => 'update', 'uses' => 'CommentController@update']
    );
    $r->delete(
        '{comment}',
        ['as' => 'delete', 'uses' => 'CommentController@delete']
    );
});

// Tags
$r->get('tagged/{tag}', 'TagController@show');

// Admin
$r->group(['prefix' => 'admin', 'namespace' => 'Admin'], function ($r) {
    // Dashboard
    $r->get('/', 'AdminController@getDashboard');

    // Articles
    $r->resource('article', 'ArticleController');

    // Events
    $r->resource('event', 'EventController');

    // Forum
    $r->group(['prefix' => 'forum', 'namespace' => 'Forum'], function ($r) {
        $r->resource('category', 'CategoryController');
    });

    // Resource deletion
    $r->get(
        '{model}/{id}/delete',
        ['as' => 'admin.resource.delete', 'uses' => 'AdminController@getDeleteResource']
    );
    $r->delete('{model}/{id}', 'AdminController@postDeleteResource');
});

// Model binding
$r->model('album', \App\Models\ImageAlbum::class);
$r->model('article', \App\Models\Article::class);
$r->model('comment', \Slynova\Commentable\Models\Comment::class);
$r->model('event', \App\Models\Event::class);

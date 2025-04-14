<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\SecurityController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileViewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::middleware(\App\Http\Middleware\TrackVisitor::class)->get('/projects/{category?}', [App\Http\Controllers\ProjectController::class, 'index'])->name('projects.index');
Route::middleware(\App\Http\Middleware\TrackVisitor::class)->get('/project-show/{project}', [App\Http\Controllers\ProjectController::class, 'show'])->name('projects.show');

// Public profile route
Route::middleware(\App\Http\Middleware\TrackVisitor::class)->get('/', [ProfileViewController::class, 'show'])->name('home');
Route::middleware(\App\Http\Middleware\TrackVisitor::class)->get('/profile', [ProfileViewController::class, 'show'])->name('profile.show');

// Public contact route
Route::middleware(\App\Http\Middleware\TrackVisitor::class)->get('/contact', [App\Http\Controllers\ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

// Comment routes
Route::post('/projects/{project}/comments', [CommentController::class, 'store'])->name('comments.store');


// Admin routes
Route::middleware(\App\Http\Middleware\AdminAuth::class)
    ->prefix('admin')->group(function () {

        //dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    
        // Profile management routes
        Route::get('/profile/edit', [ProfileController::class, 'view'])->name('admin.profile.edit');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('admin.profile.update');
        Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('admin.profile.photo');
        Route::post('/profile/cv', [ProfileController::class, 'updateCV'])->name('admin.profile.cv');
        
        // Project routes
        Route::get('/projects', [ProjectController::class, 'index'])->name('admin.projects.index');
        Route::get('/projects/create', [ProjectController::class, 'create'])->name('admin.projects.create');
        Route::post('/projects/create', [ProjectController::class, 'store'])->name('admin.projects.store');
        Route::get('/projects/edit/{project}', [ProjectController::class, 'edit'])->name('admin.projects.edit');
        Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('admin.projects.destroy');
        Route::delete('/projects/{project}/images/{image}', [ProjectController::class, 'destroyImage'])->name('admin.projects.images.destroy');
        Route::put('/projects/{project}/toggle-published', [ProjectController::class, 'togglePublished'])->name('admin.projects.toggle-published');
        
        // Category routes
        Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
        
        // Comment routes
        Route::get('/comments', [AdminCommentController::class, 'index'])->name('admin.comments.index');
        Route::get('/projects/{project}/comments', [AdminCommentController::class, 'projectComments'])->name('admin.comments.project');
        Route::put('/comments/{comment}', [AdminCommentController::class, 'update'])->name('admin.comments.update');
        Route::delete('/comments/{comment}', [AdminCommentController::class, 'destroy'])->name('admin.comments.destroy');
        Route::put('/comments/{comment}/approve', [AdminCommentController::class, 'approve'])->name('admin.comments.approve');
        Route::put('/comments/{comment}/reject', [AdminCommentController::class, 'reject'])->name('admin.comments.reject');
        
        // Contact routes
        Route::get('/contacts', [ContactController::class, 'index'])->name('admin.contacts.index');
        Route::get('/contacts/{contact}', [ContactController::class, 'show_message'])->name('admin.contacts.show');
        Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('admin.contacts.destroy');
        Route::put('/contacts/{contact}/mark-as-read', [ContactController::class, 'markAsRead'])->name('admin.contacts.mark-as-read');
        Route::put('/contacts/{contact}/mark-as-unread', [ContactController::class, 'markAsUnread'])->name('admin.contacts.mark-as-unread');
        Route::post('/admin/contacts/{contact}/reply', [ContactController::class, 'reply'])->name('admin.contacts.reply');

        // Statistics routes
        Route::get('/statistics', [StatisticsController::class, 'index'])->name('admin.statistics.index');
        
        // Security routes
        Route::get('/security', [SecurityController::class, 'index'])->name('admin.security.index');
});


Route::controller(\App\Http\Controllers\Admin\AuthController::class)
    ->prefix('admin')
    ->name('admin.')->group(function (){

        /** LOGIN
         *
         */

        Route::get('/login','login')
            ->name('login');
        Route::post('/login','login_process')
            ->middleware('throttle:super-admin-login')
            ->name('login_process');


        /** PASSWORD-RESET-WHILE-IS-NOT-CONNECTED
         *
         * (modifier le mot de passse sans etre connecte)
         */
        Route::get('/password_reset_init_while_dissconnected','password_reset_init_while_dissconnected')->name('password_reset_init_while_dissconnected');
        Route::post('/password_reset_init_while_dissconnected','password_reset_init_while_dissconnected_process')->name('password_reset_init_while_dissconnected_process');
        Route::get('/password_reset_while_dissconnected','password_reset_while_dissconnected')->name('password_reset_while_dissconnected');
        Route::post('/password_reset_while_dissconnected','password_reset_process_while_dissconnected')->name('password_reset_while_dissconnected_process');


        /** LOGOUT
         *
         */
        Route::delete('/logout','logout')->name('logout');
    });

/**
 *
 *
 *
 * ROUTES RESERVEES A L'AUTHENTIFICATION ADMINISTRATEUR
 *
 *
 *
 *
 * PARTIE 2 ( ROUTES LIEES A L'AUTHENTIFICATION UTILISEES LORSQUE L'ADMINISTRATEUR EST CONNECTE)
 *
 *
 *
 *
 * */


Route::controller(\App\Http\Controllers\Admin\AuthController::class)
    ->middleware(\App\Http\Middleware\AdminAuth::class)
    ->prefix('admin')
    ->name('admin.')->group(function (){
        /** DEFAULT-ERASE
         *
         * pour la supression des identifiants par defaut (mot de passe : 0000 et email null)
         */
        Route::get('/otp_request_default_erase', 'otp_request_default_erase')->name('otp_request_default_erase');
        Route::post('/otp_request_default_erase', 'otp_request_default_erase_process')->name('otp_request_default_erase_process');

        Route::get('/default_erase', 'default_erase')->name('default_erase');
        Route::post('/default_erase', 'default_erase_process')->name('default_erase_process');


        /** PASSWORD-RESET-WHILE-IS-CONNECTED
         *
         * (modifier lemot de passse etant deja connecte)
         */
        Route::get('/password_reset_init', 'password_reset_init')->name('password_reset_init');
        Route::get('/password_reset', 'password_reset')->name('password_reset');
        Route::post('/password_reset', 'password_reset_process')->name('password_reset_process');


        /** EMAIL - RESET
         *
         * (pour modifier l'adresse mail associee au compte )
         */
        Route::get('/email_reset_otp_request', 'email_reset_otp_request')->name('email_reset_otp_request');
        Route::post('/email_reset_otp_request', 'email_reset_otp_request_process')->name('email_reset_otp_request_process');
        Route::get('/email_reset', 'email_reset')->name('email_reset');
        Route::post('/email_reset', 'email_reset_process')->name('email_reset_process');
    });

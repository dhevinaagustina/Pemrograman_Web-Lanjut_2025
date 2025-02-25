<?php

// use App\Http\Controllers\WelcomeController;
// use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PhotoController; 


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/greeting', [WelcomeController::class, 
'greeting']); 


// Route::get('/greeting', function () {  	
//     return view('blog.hello', ['name' => 'Dhevina']); 
// }); 

Route::get('/', HomeController::class);

Route::get('/about', AboutController::class);

Route::get('/articles/{id}', ArticleController::class);

Route::resource('photos', PhotoController::class); 

Route::resource('photos', PhotoController::class)->only([ 
    'index', 'show' 
]); 

Route::resource('photos', PhotoController::class)->except([ 
    'create', 'store', 'update', 'destroy' ]); 


    

// Route::get('/', [PageController::class, 'index']);
// Route::get('/about', [PageController::class, 'about']);
// Route::get('/articles/{id}', [PageController::class, 'articles']);

// Route::get('/hello', [WelcomeController::class,'hello']); 
// Route::get('/hello', function () {
//     return ('Hello World');
// });

// Route::get('/world', function () {    
//     return 'World'; 
// });

// Route::get('/welcome', function () {         
//     return 'Selamat Datang'; 
// });

// Route::get('/about', function () {    
//     return 'NIM: 2341760065,
//             Nama: Dhevina Agustina'; 
// });

// // Route::get('/user/{name}', function ($name) {    
// //     return 'Dhevina Agustina ' . $name;
// // });

// Route::get('/posts/{post}/comments/{comment}', function 
// ($postId, $commentId) { 
//     return 'Pos ke-'.$postId." Komentar ke-: ".$commentId; }); 

// Route::get('/articles/{id}', function ($id) {
//      return 'Halaman Artikel dengan ID ' . $id;
// });
    
// Route::get('/user/{name?}', function ($name = null) {
//     return 'Nama saya ' . $name;
// });

// Route::get('/user/{name?}', function ($name = 'John') {
//     return 'Nama Saya ' . $name;
// });





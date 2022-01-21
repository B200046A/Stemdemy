<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SharedController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/save', [SharedController::class,'save'])->name('save'); //register user
Route::post('/check', [SharedController::class,'check'])->name('check'); //login teacher or student
Route::get('/logout',[SharedController::class, 'logout'])->name('logout'); //log out as teacher or student
Route::post('/search',[SharedController::class, 'searchPage'])->name('searchPage');
Route::get('/class/{id}',[SharedController::class, 'classPage'])->name('ClassPage');
Route::get('/classPage',[SharedController::class, 'classPage'])->name('classPage');

Route::group(['middleware'=>['AuthCheck']], function(){
    //All users (including guests)
    Route::get('/', [SharedController::class,'homePage'])->name('homePage');
    Route::get('/login', [SharedController::class,'login'])->name('login');
    Route::get('/register', [SharedController::class,'register'])->name('register');
    Route::get('/personalInfoPage',[SharedController::class, 'personalInfoPage'])->name('personalInfoPage');
    //Route::get('/classPage',[SharedController::class, 'classPage'])->name('classPage');
    //Route::get('/class/{id}',[SharedController::class, 'classPage'])->name('ClassPage');
    Route::get('/course/{id}',[SharedController::class, 'coursePage'])->name('CoursePage');
    //Route::post('/search',[SharedController::class, 'searchPage'])->name('searchPage');

    //Student
    Route::get('/student/mainPage',[StudentController::class, 'studentMain'])->name('studentMain');
    Route::get('/student/cartPage',[StudentController::class, 'cartPage'])->name('cartPage');
    Route::get('/student/receiptPage',[StudentController::class, 'receiptPage'])->name('receiptPage');
    Route::post('/checkout/{promo}/{total}/{subtotal}',[StudentController::class, 'generateReceipt'])->name('generateReceipt');
    //Route::post('/checkout/{promo}/{total}/{subtotal}',[StudentController::class, 'generateReceipt'])->name('generateReceipt');
    //Route::get('/student/coursePage',[StudentController::class, 'coursePage'])->name('coursePage');
    Route::get('/student/favoritePage',[StudentController::class, 'favoritePage'])->name('favoritePage');
    Route::get('/student/{Type}',[StudentController::class, 'favoritePage'])->name('myClassPage');
    
    //Teacher
    Route::get('/teacher/infoPage',[TeacherController::class, 'infoPage'])->name('infoPage');
    Route::get('/teacher/mainPage',[TeacherController::class, 'teacherMain'])->name('teacherMain');
    Route::get('/teacher/createClassPage',[TeacherController::class, 'createClassPage'])->name('createClassPage');
    Route::get('/teacher/editClassPage/{id}',[TeacherController::class, 'editClassPage'])->name('editClassPage');
    
    // Function
    Route::put('/updatePersonalInfo/{id}',[SharedController::class, 'updatePersonalInfo'])->name('updatePersonalInfo'); //update Personal Info as teacher or student
    Route::put('/updateCourseInfo/{id}',[TeacherController::class, 'updateCourseInfo'])->name('updateCourseInfo'); //update Personal Info as teacher or student
    Route::put('/updateClassInfo/{id}',[TeacherController::class, 'updateClassInfo'])->name('updateClassInfo'); //update Class Info as teacher
    Route::put('/createNewClass',[TeacherController::class, 'createNewClass'])->name('createNewClass'); //create New Class as teacher
    Route::get('/teacher_del_class/{classId}',[TeacherController::class, 'teacher_del_class'])->name('teacher_del_class'); //shortcut for teacher to delete class or student to add class to favorite list
    Route::put('/submit_comment',[SharedController::class, 'submitComment'])->name('submitComment'); //for student or teacher to write comment at class page
    Route::get('/add_fav/{classId}/{userId}/{type}',[StudentController::class, 'addFav'])->name('addFav'); //for student to add class to favorite list
    Route::put('/add_rating',[StudentController::class, 'addRating'])->name('addRating'); //for student to add class review
    Route::get('/cart/{classId}/{userId}/{type}',[StudentController::class, 'addCart'])->name('addCart'); //for student to add cart
    Route::put('/reply_comment',[SharedController::class, 'replyComment'])->name('replyComment'); //for student to add cart
    Route::get('/delete_comment/{commentId}',[SharedController::class, 'deleteComment'])->name('deleteComment'); //for teacher or student delete comment
    Route::post('/match_promo_code',[StudentController::class, 'matchPromoCode'])->name('matchPromoCode'); //for student match promo code
    Route::post('/receipt_pdf',[StudentController::class, 'receiptPDF'])->name('receiptPDF'); //for student generate receipt pdf
    
});

//Admin
Route::get('admin/login',[SharedController::class, 'admin_login'])->name('admin_login'); //admin login page
Route::post('admin/check', [SharedController::class,'admin_check'])->name('admin_check'); //function for check admin to login
Route::get('admin/logout',[AdminController::class, 'admin_logout'])->name('admin_logout'); //log out as admin

Route::group(['middleware'=>['AuthCheck_admin']], function(){
    Route::get('admin/index', [AdminController::class,'index'])->name('admin_index');// admin index
    Route::get('admin/table/{table}', [AdminController::class,'table'])->name('admin_table');// admin table
    Route::put('admin/update/',[AdminController::class, 'update_admin_table'])->name('update_admin_table'); //update Class Info as teacher
    
});

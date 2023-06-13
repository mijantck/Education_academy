<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseCommentController;
use App\Http\Controllers\CourseRequirementsController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\CourseOfWhomsController;
use App\Http\Controllers\CourseQAController;
use App\Http\Controllers\EarningHistoryController;
use App\Http\Controllers\EnrollStudentController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\RatingsCourseController;
use App\Http\Controllers\ResourcesController;
use App\Http\Controllers\VideosController;
use App\Http\Controllers\VideoSectionsController;
use App\Http\Controllers\WillLearnCourseController;
use App\Http\Controllers\WithdrawalHistoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});







//Admin apis 
Route::prefix('admin')->group(function () {

    Route::post('/register_admin', [AdminController::class, 'register']);
    Route::post('/login_admin', [AdminController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/admin', [AdminController::class, 'getAdminInfo']);


         //category apis 
        Route::get('/categories', [CategoryController::class, 'index']);
        Route::post('/categories_store', [CategoryController::class, 'store']);
        Route::post('/categories_update/{id}', [CategoryController::class, 'update']);
        Route::delete('/categories_delete/{id}', [CategoryController::class, 'destroy']);



        // instructor 
        Route::get('/instructors', [InstructorController::class, 'index']);
        Route::post('/instructors_add', [InstructorController::class, 'store']);
        Route::get('/instructors/{id}', [InstructorController::class, 'show']);
        Route::put('/instructors_update/{id}', [InstructorController::class, 'update']);
        Route::delete('/instructors_delete/{id}', [InstructorController::class, 'destroy']);

        Route::get('/instructors/{id}/earnings', [InstructorController::class, 'getEarnings']);

        //Courese
        Route::get('/courses', [CoursesController::class, 'index']);
        Route::get('/courses/{id}', [CoursesController::class, 'show']);
        Route::post('/courses_create', [CoursesController::class, 'store']);
        Route::post('/short_courses_create/{id}', [CoursesController::class, 'updateShortDetails']);
        Route::post('/full_courses_create/{id}', [CoursesController::class, 'updateFullDetails']);
        Route::get('/courses/{course}/students', [CoursesController::class, 'getEnrolledStudents']);

        
    

        //Course Requirment
        Route::post('/courese-requirment',[CourseRequirementsController::class,'store']);
        Route::get('/courses/{course_id}/requirements',[CourseRequirementsController::class,'index']);


        //course-of-whoms
        Route::get('/course-of-whoms', [CourseOfWhomsController::class, 'index']);
        Route::post('/course-of-whoms-create', [CourseOfWhomsController::class, 'store']);

        //Course  QA
        Route::post('/courese-q-a-create',[CourseQAController::class,'store']);
        Route::get('/courese-q-a/{course_id}',[CourseQAController::class,'show']);



        Route::get('/will-learn-courses', [WillLearnCourseController::class, 'index']);
        Route::post('/will-learn-courses', [WillLearnCourseController::class, 'store']);
        Route::get('/will-learn-courses/{id}', [WillLearnCourseController::class, 'show']);
        Route::put('/will-learn-courses/{id}', [WillLearnCourseController::class, 'update']);
        Route::delete('/will-learn-courses/{id}', [WillLearnCourseController::class, 'destroy']);



        Route::post('/ratings', [RatingsCourseController::class, 'store']);
        Route::get('/courses/{courseId}/average-rating', [RatingsCourseController::class, 'getCourseAverageRating']);


        //Enroll Student 
        Route::post('/enroll-students', [EnrollStudentController::class, 'store']);
        Route::get('students/{studentId}/courses', [EnrollStudentController::class, 'index']);
        Route::get('/students/{studentId}/enrolled-courses', [StudentController::class ,'getEnrolledCourses']);


        // Store a new video section
        Route::post('/video-sections', [VideoSectionsController::class, 'store']);
        Route::get('/courses/{course}/video-sections', [VideoSectionsController::class, 'show']);
        Route::get('/video-sections/{section}', [VideoSectionsController::class, 'intdex']);
        Route::post('/video-sections/{section}', [VideoSectionsController::class, 'update']);
        Route::delete('/video-sections/{section}', [VideoSectionsController::class, 'destroy']);




       //video 
        Route::post('/videos/upload', [VideosController::class, 'store']);
        Route::get('/courses/{course}/videos', [VideosController::class, 'index']);
        Route::post('/videos/{video}', [VideosController::class, 'update']);
        Route::delete('/videos/{video}', [VideosController::class, 'destroy']);


        //Resouce 
        Route::post('/resources', [ResourcesController::class, 'store']);
        Route::put('/resources/{resource}', [ResourcesController::class, 'update']);
        Route::delete('/resources/{resource}', [ResourcesController::class, 'destroy']);
        


        //Comments
        Route::post('course-comments', [CourseCommentController::class, 'store']);
        Route::get('course-comments', [CourseCommentController::class, 'index']);
        Route::get('course-comments/{course_id}', [CourseCommentController::class, 'index']);
        Route::get('course-comments/{comment}', [CourseCommentController::class, 'show']);
        Route::post('course-comments/{comment}', [CourseCommentController::class, 'update']);
        Route::delete('course-comments/{comment}', [CourseCommentController::class, 'destroy']);



        // Retrieve all earning histories
        Route::get('/earning-histories', [EarningHistoryController::class,'index']);
        Route::post('/earning-histories', [EarningHistoryController::class, 'store']);
        Route::get('/earning-histories/{earningHistory}', [EarningHistoryController::class , 'show']);
        Route::post('/earning-histories/{earningHistory}', [EarningHistoryController::class,'updateStatus']);
        Route::delete('/earning-histories/{earningHistory}', [EarningHistoryController::class,'destroy']);



        //Withdrawal history
        Route::get('/withdrawal-histories', [WithdrawalHistoryController::class,'index']);
        Route::post('/withdrawal-histories', [WithdrawalHistoryController::class,'store']);

        //Route::put('/withdrawal-histories/{withdrawalHistory}', 'WithdrawalHistoryController@update')->name('withdrawal-histories.update');




    });

   



});





// mobile apis
Route::prefix('mApp')->group(function () {

    Route::post('/register_student', [StudentController::class, 'register']);
    Route::post('/login_student', [StudentController::class, 'login'])->name('login');

   // Route::middleware('auth:sanctum')->get('/user', [StudentController::class, 'getUserInfo']);

    Route::middleware('auth:sanctum')->group(function () {


        //Student
        Route::get('/user', [StudentController::class, 'getUserInfo']);
        Route::post('/change-password', [StudentController::class, 'changePassword']);
        Route::post('/logout', [StudentController::class, 'logout']);
        Route::get('/students/{studentId}/enrolled-courses', [StudentController::class ,'getEnrolledCourses']);

        //seaching 
        Route::get('/courses/search', [CoursesController::class,'search']);

        //home 
        Route::get('/home', [HomePageController::class,'homePage']);


       //Courese
       Route::get('/courses', [CoursesController::class, 'index']);
       Route::get('/courses/{id}', [CoursesController::class, 'show']);
       Route::get('/courses/{course}/students', [CoursesController::class, 'getEnrolledStudents']);


        //Comments
        Route::post('course-comments', [CourseCommentController::class, 'store']);
        Route::get('course-comments', [CourseCommentController::class, 'index']);
        Route::get('course-comments/{course_id}', [CourseCommentController::class, 'index']);
        Route::get('course-comments/{comment}', [CourseCommentController::class, 'show']);

        //Enroll Student 
        Route::post('/enroll-students', [EnrollStudentController::class, 'store']);
        Route::get('students/{studentId}/courses', [EnrollStudentController::class, 'index']);
        Route::get('/students/{studentId}/enrolled-courses', [StudentController::class ,'getEnrolledCourses']);


    });
});


// web app apis
Route::prefix('webApp')->group(function () {

    Route::post('/register_student', [StudentController::class, 'register']);
    Route::post('/login_student', [StudentController::class, 'login'])->name('login');

   // Route::middleware('auth:sanctum')->get('/user', [StudentController::class, 'getUserInfo']);

    Route::middleware('auth:sanctum')->group(function () {


        //Student
        Route::get('/user', [StudentController::class, 'getUserInfo']);
        Route::post('/change-password', [StudentController::class, 'changePassword']);
        Route::post('/logout', [StudentController::class, 'logout']);
        Route::get('/students/{studentId}/enrolled-courses', [StudentController::class ,'getEnrolledCourses']);

        //seaching 
        Route::get('/courses/search', [CoursesController::class,'search']);

        //home 
        Route::get('/home', [HomePageController::class,'homePage']);


       //Courese
       Route::get('/courses', [CoursesController::class, 'index']);
       Route::get('/courses/{id}', [CoursesController::class, 'show']);
       Route::get('/courses/{course}/students', [CoursesController::class, 'getEnrolledStudents']);


        //Comments
        Route::post('course-comments', [CourseCommentController::class, 'store']);
        Route::get('course-comments', [CourseCommentController::class, 'index']);
        Route::get('course-comments/{course_id}', [CourseCommentController::class, 'index']);
        Route::get('course-comments/{comment}', [CourseCommentController::class, 'show']);

        //Enroll Student 
        Route::post('/enroll-students', [EnrollStudentController::class, 'store']);
        Route::get('students/{studentId}/courses', [EnrollStudentController::class, 'index']);
        Route::get('/students/{studentId}/enrolled-courses', [StudentController::class ,'getEnrolledCourses']);


    });
});


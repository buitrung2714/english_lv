<?php

use Illuminate\Support\Facades\Route;

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
Route::group(['namespace' => 'App\Http\Controllers'],function(){
      //home
    Route::get('', 'HomeController@index');
    Route::get('home', 'HomeController@index');
    Route::get('contact', 'HomeController@contact');
    Route::post('contact-control', 'HomeController@contact_control');

        //teacher
    Route::get('list-test', 'HomeController@list_test');
    Route::get('show-test/{result_id}', 'HomeController@show_test');
    Route::put('update-mark/{result_id}', 'HomeController@update_mark');

        //user 
    Route::post('add-user','HomeController@addUser');
    Route::get('register-verify','HomeController@register_verify');
    Route::post('add-user-verify','HomeController@add_user_verify');
    
    Route::post('login-user','HomeController@loginUser');
    Route::get('logout-user','HomeController@logoutUser');
    Route::post('check-email','HomeController@check_email');
   
    //forgot pass
    Route::get('forgot-pass', 'HomeController@forgot_pass');
    Route::post('recover-pass', 'HomeController@recover_pass');
    Route::get('update-new-pass', 'HomeController@update_new_pass');
    Route::post('new-pass', 'HomeController@new_pass');

    Route::get('redirect', 'HomeController@redirectToProvider');
    Route::get('callback', 'HomeController@handleProviderCallback');

    //nếu user đã đăng nhập
    Route::group(['middleware' => 'loginuser'],function(){

        //profile
        Route::get('profile/{customer_id}','HomeController@profile');
        Route::post('update-student/{student_id}','HomeController@update_student');
        Route::get('check-old-pass','HomeController@check_old_pass');

            //lesson - sample
        Route::get('result-sample','HomeController@result_sample');
        Route::get('lesson-sample', 'HomeController@lesson_sample');
        Route::get('show-lesson-sample/{lesson_id}', 'HomeController@show_lesson_sample');


            //exercise test
        Route::get('exercise-test', 'HomeController@exercise_test');


            //example test

        Route::get('example-test', 'HomeController@example_test');

        Route::get('start-random-example/{filter_id}', 'HomeController@start_random_example');
        // Route::get('show-random-example/{filter_id}', 'HomeController@ramdom_example');

        Route::get('random-example/{filter_id}' ,'HomeController@ramdom_example');

        Route::get('show-random-example/{filter_id}', 'HomeController@show_random_example');

        Route::post('results-example-test/{result_id}', 'HomeController@results_example_test');

        Route::get('show-result-example/{result_id}', 'HomeController@show_result_example')->withoutMiddleware('loginuser')->name('show_result');

        Route::post('start-exercise', 'HomeController@start_exercise');

        Route::get('remark/{result_id}', 'HomeController@remark');

        Route::POST('check-filter', 'HomeController@check_filter');
        Route::POST('rebuild', 'HomeController@rebuild');
        Route::POST('detail-result', 'HomeController@detail_result');
        Route::post('save-src','HomeController@save_src');

        Route::POST('check-err', 'HomeController@check_filter_err');

        // studyroute
   
        Route::get('study-route', 'HomeController@study_route');
        Route::get('input-route', 'HomeController@input_route');
        
        Route::get('start-route/{route_id}', 'HomeController@start_route');
        Route::get('route-test/{filter_id}', 'HomeController@start_random_example');
    });
    
    //admin
    Route::group(['middleware' => ['checklogin','imperson'],'prefix' => 'admin'], function () {
        //Dashboard
        Route::get('', 'StaffController@login')->withoutMiddleware(['checklogin']);
        Route::post('login-control', 'StaffController@login_control')->withoutMiddleware(['checklogin']);
        Route::get('logout', 'StaffController@logout');
        Route::get('dashboard', 'StaffController@dashboard');
        Route::get('profile/{staff_id}', 'StaffController@profile');
        Route::get('change-password/{staff_id}', 'StaffController@change_password');
        Route::put('change-password-control/{staff_id}', 'StaffController@change_password_control');
        //Skill
        Route::get('skills', 'SkillController@index');
        Route::get('add-skill', 'SkillController@create');
        Route::post('add-skill-control', 'SkillController@store');
        Route::get('get-id-skill/{skill_id}', 'SkillController@show');
        Route::get('edit-skill/{skill_id}', 'SkillController@edit');
        Route::put('update-skill-control/{skill_id}', 'SkillController@update');
        Route::get('delete-skill/{skill_id}', 'SkillController@destroy');
        //Level
        Route::get('levels', 'LevelController@index');
        Route::get('add-level', 'LevelController@create');
        Route::post('add-level-control', 'LevelController@store');
        Route::get('get-id-level/{level_id}', 'LevelController@show');
        Route::get('edit-level/{level_id}', 'LevelController@edit');
        Route::put('update-level-control/{level_id}', 'LevelController@update');
        Route::get('delete-level/{level_id}', 'LevelController@destroy');
        //Part
        Route::get('parts', 'PartController@index');
        Route::get('add-part', 'PartController@create');
        Route::post('add-part-control', 'PartController@store');
        Route::get('get-id-part/{part_id}', 'PartController@show');
        Route::get('edit-part/{part_id}', 'PartController@edit');
        Route::put('update-part-control/{part_id}', 'PartController@update');
        Route::get('delete-part/{part_id}', 'PartController@destroy');
        //Topic
        Route::get('get-list-part-topic/{skill_id}', 'TopicController@get_list_part_topic');
        Route::get('get-skill-topic/{skill_id}', 'TopicController@get_skill_topic');
        Route::get('download-audio/{id}', 'TopicController@download_audio');
        Route::get('topics', 'TopicController@index');
        Route::get('add-topic', 'TopicController@create');
        Route::post('add-topic-control', 'TopicController@store');
        Route::get('get-id-topic/{topic_id}', 'TopicController@show');
        Route::get('edit-topic/{topic_id}', 'TopicController@edit');
        Route::put('update-topic-control/{topic_id}', 'TopicController@update');
        Route::get('delete-topic/{topic_id}', 'TopicController@destroy');
        //Question
        Route::get('get-list-part-ques/{skill_id}', 'QuestionController@get_list_part_ques');
        Route::get('get-skill-ques/{skill_id}', 'QuestionController@get_skill_ques');
        Route::get('get-list-topic-ques/{part_id}', 'QuestionController@get_topic_ques');
        Route::get('get-detail-topic-ques/{topic_id}', 'QuestionController@get_detail_topic_ques');
        Route::post('edit-topic-ques/{topic_id}', 'QuestionController@update_topic');
        Route::get('use-excel', 'QuestionController@use_excel');
        Route::post('add-question-excel', 'QuestionController@storeExcel');
        Route::post('export-question', 'QuestionController@showExcel');
        Route::get('questions', 'QuestionController@index');
        Route::get('add-question', 'QuestionController@create');
        Route::post('add-question-control', 'QuestionController@store');
        Route::get('get-id-question/{question_id}', 'QuestionController@show');
        Route::get('edit-question/{question_id}', 'QuestionController@edit');
        Route::put('update-question-control/{question_id}', 'QuestionController@update');
        Route::get('delete-question/{question_id}', 'QuestionController@destroy');
        //Answer
        Route::get('update-answer/{answer_id}', 'AnswerController@destroy');

        Route::group(['middleware' => 'adminrole'], function(){
            //Structure
            Route::post('check-struc', 'FilterStructureController@check_struc');
            Route::get('structures', 'FilterStructureController@index');
            Route::get('add-structure', 'FilterStructureController@create');
            Route::post('add-structure-control', 'FilterStructureController@store');
            Route::get('get-id-structure/{filter_id}', 'FilterStructureController@show');
            Route::get('edit-structure/{filter_id}', 'FilterStructureController@edit');
            Route::post('update-structure-control/{filter_id}', 'FilterStructureController@update');
            Route::get('status-structure/{filter_id}/{status}', 'FilterStructureController@status_structure');
            //Lesson
            Route::get('get-filter-struc/{filter_id}', 'LessonController@get_filter_struc');
            Route::get('get-ques-topic/{topic_id}', 'LessonController@get_ques_topic');
            Route::get('lessons', 'LessonController@index');
            Route::get('add-lesson', 'LessonController@create');
            Route::post('add-lesson-control', 'LessonController@store');
            Route::get('get-id-lesson/{lesson_id}', 'LessonController@show');
            Route::get('edit-lesson/{lesson_id}', 'LessonController@edit');
            Route::put('update-lesson-control/{lesson_id}', 'LessonController@update');
            Route::get('status-lesson/{lesson_id}/{status}', 'LessonController@status_lesson');
            //Route
            Route::get('routes', 'RouteController@index');
            Route::get('add-route', 'RouteController@create');
            Route::post('add-route-control', 'RouteController@store');
            Route::get('get-id-route/{route_id}', 'RouteController@show')->withoutMiddleware('checklogin');
            Route::get('edit-route/{route_id}', 'RouteController@edit');
            Route::put('update-route-control/{route_id}', 'RouteController@update');
            Route::get('status-route/{route_id}/{status}', 'RouteController@destroy');
            Route::get('delete-route-struct/{route_id}', 'RouteController@destroyStructure');
            //Staff
            Route::get('imper-staff/{staff_id}', 'StaffController@imper_staff');
            Route::get('stop-imper', 'StaffController@stop_imper')->withoutMiddleware('adminrole');
            Route::get('staff', 'StaffController@index');
            Route::get('add-staff', 'StaffController@create');
            Route::post('add-staff-control', 'StaffController@store');
            Route::get('get-id-staff/{staff_id}', 'StaffController@show');
            Route::get('edit-staff/{staff_id}', 'StaffController@edit');
            Route::put('update-staff-control/{staff_id}', 'StaffController@update');
            Route::get('delete-staff/{staff_id}', 'StaffController@destroy');
            //Student
            Route::get('students', 'StudentController@index');
            Route::get('get-id-student/{student_id}', 'StudentController@show');
            Route::get('lock-student/{student_id}/{status}', 'StudentController@lock_student');
            Route::get('delete-student/{student_id}', 'StudentController@destroy');
        });
    });
});
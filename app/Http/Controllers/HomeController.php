<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Student;
use App\Models\Part;
use App\Models\Level;
use App\Models\Topic;
use App\Models\Skill;
use App\Models\Lesson;
use App\Models\LessonContent;
use App\Models\Question;
use App\Models\FilterStructure;
use App\Models\FilterPart;
use App\Models\Answer;
use App\Models\Result;
use App\Models\Route;
use App\Models\DetailRoute;
use App\Models\AnswerStudent;
use App\Mail\SendMail;
use App\Mail\contactMail;
use App\Mail\recoverpassMail;
use App\Mail\verifyReg;
use Carbon\Carbon;
use DB;
use Auth;
use Mail;
use Validator;
use Socialite;
use Str;
use Session;

use Illuminate\Support\Facades\Redirect;
session_start();


class HomeController extends Controller
{
   public function index()
   {
        //
      return view('pages.home');  
  }

   //--------------- add user ---------------

  public function addUser(Request $request){
    $dataUser = array();
    $dataUser['student_name'] = $request->name;
    $dataUser['student_email'] = $request->email;
    $dataUser['student_password'] = md5($request->password);
    $dataUser['student_status'] = 2;
    $dataUser['student_token'] = Str::random();

    $add_fail= Student::where('student_email',$request->email)->get();
           
    if(count($add_fail)>0){
        Session::put('add_fail','Registration User Fail');
        return Redirect::to('/home');
    }else
    {
        $insert_stu = Student::insertGetId($dataUser);

        $now =Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
        $title_mail ="Registration Account English Club".' '.$now;

           
        $link_reset_pass =url('/register-verify?email='.$dataUser['student_email'].'&token='.$dataUser['student_token']);

        $data = array(
            "name"  =>      $title_mail,
            "body"  =>      $link_reset_pass,
            'email' =>      $dataUser['student_email']
        );
            
        Mail::to($dataUser['student_email'])->send(new verifyReg($data));
        return Redirect::to('/home')->with('email_send','Please verify your email!');

    }

}
public function register_verify()
{
    return View('pages.Register.register_verify');
}
public function add_user_verify(Request $re)
{

    $token = $re['token'];
    $email = $re['email'];
    $pass = md5($re['password']);

    $new_token =  Str::random();
    $student = Student::where([
        ['student_email','=',$email],
        ['student_token','=',$token],
        ['student_password','=',$pass]
    ])->get();

    if($student->count()>0){
        //dd(1);
        foreach ($student as $key => $value) {
            $student_id =$value['student_id'];
            $student_name =$value['student_name'];
            $student_email =$value['student_email'];
        }
        $student = Student::where('student_id',$student_id)
        ->update(['student_status'=>0,'student_token'=>$new_token]);
        Session::put('student_id',$student_id);
        Session::put('student_name',$student_name);
        Session::put('student_email', $student_email);
        Session::put('login_success','Login User Success!');

        return Redirect::to('/home');
    }

    else{
        return Redirect::to('/forgot-pass')->with('update_pass_fail','Re-enter your email because the link has expired ');
    }


}

//-------------------------add user google ----------------------
    /**
      * Redirect the user to the Google authentication page.
      *
      * @return \Illuminate\Http\Response
      */
    public function redirectToProvider()
    {
        // config(['services.google.redirect' => 'http://localhost:8081/English/callback']);
        return Socialite::driver('google')->redirect();
    }
    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        try {
            // config(['services.google.redirect' => 'http://localhost:8081/English/callback']);
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/');
        }
        // only allow people with @company.com to login
        // if(explode("@", $user->email)[1] !== 'gmail.com'){
        //     return redirect()->to('/');
            
        // }
        // check if they're an existing user
        $existingUser = Student::where('student_email', $user->email)->first();
        //dd($existingUser->student_status);
        if($existingUser && $existingUser->student_status == 0){
            // log them incount($add_fail)>0
            //auth()->login($existingUser, true);
            Session::put('student_id',$existingUser->student_id);
            Session::put('student_name',$existingUser->student_name);
            Session::put('student_email',$existingUser->student_email);
            // Session::put('login_success','Registration User Success');
            // Session::put('add_fail','Registration User Fail');
            // return Redirect::to('/home');
        }else if($existingUser && $existingUser->student_status == 1 ){
            Session::put('fail','Your account is locking!');
            return Redirect::to('/home');
        }
        else {
            // create a new user
            $newUser                          = new Student;
            $newUser->student_name            = $user->name;
            $newUser->student_email           = $user->email;
            $newUser->student_password        = '';

            //$newUser->google_id       = $user->student_id;

            $newUser->save();
            //auth()->login($newUser, true);
           // dd($newUser);

            Session::put('student_id',$newUser->student_id);
            Session::put('student_name',$newUser->student_name);
            Session::put('student_email', $newUser->student_email);
            // Session::put('add_success','Registration User Success');
        }
        

        return redirect('/home')->with('login_success', 'Login Successfully!');
    }


    // ------------------------loginUser -------------------------
      //loginUser
    public function loginUser(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $result_student = Student::where('student_email',$email)->where([['student_password',md5($password)]])->first();
        $result_teacher = Staff::where('staff_email',$email)->where('staff_password',md5($password))->first();
        if (isset($result_teacher) && !isset($result_student)) {

            if (Staff::find($result_teacher->staff_id)->roles()->whereRoleName('Teacher')->count() > 0) {

                $id_gv = $result_teacher->staff_id;
                $name_gv = $result_teacher->staff_name;
                $email_gv = $result_teacher->staff_email;

                Session()->put('id_gv', $id_gv);
                Session()->put('name_gv', $name_gv);
                Session()->put('email_gv', $email_gv);
                return back()->with('login_success', 'Login User Success!');
            }else{

                return back()->with('fail', 'You dont have permission login here!');
            }

        }else if (!isset($result_teacher) && isset($result_student)){

            if ($result_student->student_status == 1) {
                return Redirect('/home')->with('fail', 'Your account is locking!');
            }else if($result_student->student_status == 2){
                return Redirect('/home')->with('fail', 'Pending Account!');
            }

            Session::put('student_id',$result_student->student_id);
            Session::put('student_name',$result_student->student_name);
            Session::put('student_email', $result_student->student_email);
            Session::put('login_success','Login User Success!');
            return Redirect::to('/home');
        }else{
            Session::put('fail','Email and Password incorrect!');
            return Redirect::to('/home');
        }
    }

    //--------------------check_pass--------------------

    public function check_pass(Request $re)
    {
        $student_email = $re->student_email;
        $student_password = md5($re->student_password);
        $pass_ok = 0;
        $result_student = Student::where('student_email',$student_email)->where([['student_password',$student_password]])->first();
        dd($result_student);
        if($result_student!=null){
            $pass_ok = 1;
        }
        return response()->json($pass_ok);

    }
    //------------------- logoutUser ------------------
    //logoutUser

    public function logoutUser()
    {
        if (session()->has('id_gv')) {
            session()->remove('id_gv');

        } else{
            Session::put('student_id', null);
            Session::put('student_name', null);
            Session::put('student_email', null);
            Session::put('logout_success','Logout User Successfully!');
        }  

        return Redirect('/home');


    }

 //---------------- forgot pass -------------------
    public function forgot_pass()
    {
       return view('pages.forgot_pass.forgot_pass');
   }
   public function recover_pass(Request $re)
   {
    $student_email = $re->email;
    $now =Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
    $title_mail ="Forgot Password English Club".' '.$now;

    $student = Student::where('student_email','=',$student_email)->first();
        //dd($student);
    if(!isset($student)){
        $error_forgot = 'Email does not exist!';
        return response()->json(['status' => 0, 'mess' => $error_forgot]);
    }else if($student->student_status == 1){
        $error_forgot = 'Your account is locking!!';
        return response()->json(['status' => 0, 'mess' => $error_forgot]);
    }
    else{
        $token = Str::random();
        $student->student_token=$token;
        $student->save();

        $link_reset_pass =url('/update-new-pass?email='.$student_email.'&token='.$token);

        $data = array(
            "name"  =>      $title_mail,
            "body"  =>      $link_reset_pass,
            'email' =>      $student_email
        );

        Mail::to($student->student_email)->send(new recoverpassMail($data));
        $forgor_success = 'Email was sent!';
        return response()->json(['status' => 1 ,'mess' => $forgor_success]);
    }

}

//update - password
public function update_new_pass(){
    return View('pages.Forgot_pass.forgot_pass_notify');
}

//new pass
public function new_pass(Request $re)
{
    $token = $re['token'];
    $email = $re['email'];

    $new_pass_tamp = $re['new_pass'];
    $new_token =  Str::random();
    $student = Student::where([['student_email','=',$email],['student_token','=',$token]])->get();
    //dd($new_pass);
    
    $new_pass = md5($new_pass_tamp);
    if($student->count()>0){
        //dd(1);
        foreach ($student as $key => $value) {
            $student_id =$value['student_id'];
            $student_name =$value['student_name'];
            $student_email =$value['student_email'];
        }
        $student = Student::where('student_id',$student_id)
        ->update(['student_password'=>$new_pass,'student_token'=>$new_token]);
        Session::put('student_id',$student_id);
        Session::put('student_name',$student_name);
        Session::put('student_email', $student_email);
        Session::put('login_success','Login User Success!');

        return Redirect::to('/home');
    }

    else{
        return Redirect::to('/forgot-pass')->with('update_pass_fail','Re-enter your email because the link has expired ');
    }
    
}

    //---------------- profileUser -------------------
public function profile($student_id)
{

    $cus = Student::where('student_id',$student_id)->get();
    return view('pages.profile')->with('cus' ,$cus);

}
public function check_old_pass(Request $data)
{
    $student_id = $data['user_id'];
    $student_password = md5($data['old_pass']);
    $cus = Student::where([['student_id',$student_id],['student_password',$student_password]])->get()->toArray();
    $ok =0;
    if(count($cus)>0){
        $ok =1;
    }

    return response()-> json($ok);
}
public function update_student(Request $re,$student_id)
{
    $student_name = $re->name;
    $password = md5($re->pass);
    if($password != ''){
        $student = Student::where('student_id',$student_id)
        ->update(['student_password'=>$password]);
    }
    //dd($student_name).
    $student = Student::where('student_id',$student_id)
    ->update(['student_name' => $student_name]);
    return Redirect::to('/profile/'.$student_id)->with('success','Updated Successfully!');
}
public function check_email(Request $re)
{
    $student_email = $re->student_email;
    $add_fail= Student::where('student_email',$student_email)->get();
        //dd($add_fail);
    if(count($add_fail)>0){
        // Session::put('add_fail','Registration User Fail');
        // return Redirect::to('/home');
        $email_exits =1;
    }else{
        $email_exits =0;
    }
    return response()->json(['email_exits'=>$email_exits]);

}
    //----------------------------exercise_test------------------

public function exercise_test()
{
    $allSkill = Skill::all();
    $allpart = Part::orderBy('skill_id','ASC')->orderBy('part_no','ASC')->get(); 
    $allLevel = Level::all();
    $allTopic = Topic::all();
    $student_id=Session::get('student_id');

    $list_lesson = Result::join('answer_students','results.result_id','=','answer_students.result_id')
    ->join('lesson_contents','answer_students.lesson_content_id','=','lesson_contents.lesson_content_id')
    ->join('lessons','lessons.lesson_id','=','lesson_contents.lesson_id')
    ->join('filter_structures','lessons.filter_id','=','filter_structures.filter_id')
    ->where('results.student_id',$student_id)
    ->distinct()->get(
       ['lessons.lesson_id','results.total_mark','results.created_at','lessons.filter_id','results.result_id','filter_structures.filter_status','lessons.lesson_status','results.fee','results.result_status','results.submit']
   )->toArray();

    if (count($list_lesson) > 0) {

        foreach($list_lesson as $filter){

            $skill_fee = [];
            $parts = FilterStructure::find($filter['filter_id'])->parts;
            
            foreach($parts as $key => $part){

                $skill = Part::find($part->part_id)->skills->skill_name;
                
                if (($skill == 'Writting' || $skill == 'Speaking') && (!in_array($skill, $skill_fee))) {
                    $skill_fee[] = $skill;
                }

            }

            $result_lessons = [];
            $result_total_mark = 0;
            $GPA = null;
            
            $lesson_cont = LessonContent::where('lesson_id',$filter['lesson_id'])->first('lesson_content_id');
            $result_lessons[] = LessonContent::find($lesson_cont['lesson_content_id'])->results()->where('student_id',$student_id)->get()->toArray();
            
            foreach ($result_lessons as $key => $result_lesson) {
                
                foreach ($result_lesson as $k => $v) {
                    $route_id = $v['route_id'];
                    if( $v['total_mark'] !== null)
                    {
                        $GPA = 1;
                        $result_total_mark = $v['total_mark'];
                    }
                }
            };
            $ques_mark_max =0.0;
            $arr_ques_marks = Lesson::find($filter['lesson_id'])->questions()->get()->toArray();
            
            foreach ($arr_ques_marks as $key => $arr_ques_mark) {
                $ques_mark_max += $arr_ques_mark['question_mark'];
            }
            
            if($GPA != null){
                $GPA =($result_lessons != []) ? round((($result_total_mark*10)/$ques_mark_max),2) : 0;
                $GPA =($GPA > 10.0) ? floor($GPA) : $GPA;
            }


            $list_lesson_id[] = 
            [   
                'created_at'    =>      $filter['created_at'],
                'lesson_status' =>      $filter['lesson_status'], 
                'lesson_id'     =>      $filter['lesson_id'],
                'total_mark'    =>      $GPA,
                'filter_id'     =>      $filter['filter_id'],
                'result_id'     =>      $filter['result_id'],
                'filter_status' =>      $filter['filter_status'],
                'fee'           =>      $filter['fee'],
                'result_status' =>      $filter['result_status'],
                'skill_fee'     =>      count($skill_fee) > 0 ? $skill_fee : null,
                'unfinish'      =>      $filter['submit'] == 0 ? 1 : 0,
                'route_id'      =>      $route_id,
            ];
            
        }
        
        rsort($list_lesson_id);
    }

    if(isset($student_id))
    {
        return view('pages.exercise_test.exercise_test')
        ->with('allSkill',$allSkill)
        ->with('allpart',$allpart)
        ->with('allTopic',$allTopic)
        ->with('allLevel',$allLevel)
        ->with('list_lesson_id',isset($list_lesson_id) ? $list_lesson_id : null);
    }else{
        Session::put('re','Log in to continue testing');
        return Redirect::to('/home'); 
    }


}

public function rebuild(Request $re)
{
    $filter_id = $re->filter_id;


    $filter_part = FilterPart::join('parts','parts.part_id','=','filter_parts.part_id')
    ->join('skills','parts.skill_id','=','skills.skill_id')
    ->where('filter_id',$filter_id)
    ->distinct()->orderBy('skills.skill_id','ASC')
    ->get(['filter_parts.part_id',
        'filter_parts.filter_part_amount_topic',
        'filter_parts.filter_topic_level',
        'skills.skill_id',
        'skills.skill_name',
        'parts.part_amount_ques_per_topic',
        'parts.part_name'
    ]);

    $all_level =Level::all();


        // return response()->json($filter_id);
    return response()->json(['filter_part'=>$filter_part,'all_level'=>$all_level]);
}
public function detail_result(Request $re)
{
    $result_id = $re->result_id;
    $ques_of_skill = AnswerStudent::join('lesson_contents','answer_students.lesson_content_id','=','lesson_contents.lesson_content_id')
    ->join('questions','questions.question_id','=','lesson_contents.question_id')
    ->join('topics','questions.topic_id','=','topics.topic_id')
    ->join('parts','topics.part_id','=','parts.part_id')
    ->join('skills','parts.skill_id','=','skills.skill_id')
    ->where('answer_students.result_id',$result_id)
    ->distinct()->orderBy('skills.skill_id','ASC')
    ->get(['skills.skill_id','skills.skill_name','questions.question_id','answer_students.mark']);
    return response()->json($ques_of_skill);
}

//----------------------------example_test------------------
public function example_test()
{
    // cấu trúc chuẩn
    $standard_strucs = FilterStructure::where('filter_status',1)->get('filter_id')->first();

    return view('pages.Example_test.example_test')
    ->with('standard_strucs',$standard_strucs);
}


public function start_random_example($filter_id)
{

    $filter = FilterStructure::where('filter_id',$filter_id)->get()->toArray();
    foreach($filter as $k => $value)
    {
        $filter_status=$value['filter_status'];
    }

    $student_id=Session::get('student_id');
    if(isset($student_id))
    {
        $route_id = (isset($_GET['route'])) ? $_GET['route'] : null;
        return view('pages.Example_test.start_random_example')
        ->with('filter_id',$filter_id)
        
        ->with('route',$route_id)
        ->with('filter_status',$filter_status);

    }else{
        Session::put('re','Log in to continue testing');
        return Redirect::to('/example-test'); 
    }
}
    // ham random lesson theo filter chuan
public function ramdom_example($filter_id)
{
        if(isset($_GET['route']) && $_GET['route']!= null )
        {
            $route_id = $_GET['route'];
            $lesson_status = 2 ;
        }else{
            $route_id=null;
            $lesson_status = 0 ;
        }

        //them lesson
        $student_id = Session::get('student_id');

        $lesson = new Lesson();
        $lesson->filter_id=$filter_id;
        $lesson->lesson_status = $lesson_status;
        $lesson->save();

        $lesson_id = $lesson->lesson_id;

    
       // them result 
        $result = new Result();
        $result->student_id=$student_id;
        $result->teacher_id=null;
        $result->total_mark=null;
        $result->fee=$_GET['fee'];
        $result->route_id=$route_id;
        $result->submit = 0;
        $result->save();

        $result_id = $result->result_id;
    
        //==========================================================================================
    $all_skills = Skill::all();
    $all_parts = Part::orderBy('part_no')->get();


    $push_allques = [];
    $all_topic_oks = [];
    $error = '';
    foreach ($all_skills as $key => $all_skill) 
    {
        $all_parts = Part::where('skill_id',$all_skill['skill_id'])->orderBy('part_no')->get()->toArray();
        //dd($all_parts);
        foreach ($all_parts as $key => $all_part) 
        {

            $part_amount_ques_per_topic=$all_part['part_amount_ques_per_topic'];  

            $detail_filters = FilterPart::where('filter_id',$filter_id)->get();
            $sum_amount_topic = FilterPart::where('filter_id',$filter_id)->sum('filter_part_amount_topic');
                //dd($sum_amount_topic);
            foreach($detail_filters as $k => $detail_filter)
            {
                $index=0;
                if($detail_filter['part_id']==$all_part['part_id'])
                    // if($detail_filter['part_id']==3)

                {
                    $amount_topic = $detail_filter['filter_part_amount_topic'];
                    $level_id =  $detail_filter['filter_topic_level'];
                       // $all_topic_oks = [];

                            //dd($amount_topic);
                    $all_topics =Topic::where([['part_id',$detail_filter['part_id']],['level_id',$level_id]])
                    ->inRandomOrder()->get()->toArray();
                         //dd($all_topics,$amount_topic);
                    $count_all_topic = count($all_topics);
                    if($count_all_topic >= $amount_topic){

                        foreach ($all_topics as $key1 => $all_topic) 
                        {

                            $all_quess = Question::join('topics','topics.topic_id','=','questions.topic_id')
                            ->where([['topics.part_id',$detail_filter['part_id']],
                                ['topics.level_id',$level_id],
                                ['topics.topic_id',$all_topic['topic_id']]
                            ])
                            ->inRandomOrder()->limit($part_amount_ques_per_topic)->get()->toArray();
                                //dd($all_quess);

                            $count_all_quess = count($all_quess);

                            if($count_all_quess >= $part_amount_ques_per_topic){
                                    //dd($all_topic);
                                if($index < $amount_topic){
                                    array_push($all_topic_oks,$all_topic);
                                    $index++;
                                }

                            }

                        }

                    }
                }
            }
        }
    }
     // dd($all_topic_oks,$sum_amount_topic);
    if(count($all_topic_oks)>=$sum_amount_topic){
        foreach ($all_topic_oks as $k => $all_topic_ok) {
            $amount_ques = Part::where('part_id',$all_topic_ok['part_id'])->get('part_amount_ques_per_topic')->toArray();
            foreach ($amount_ques as $key => $value) {
                $part_amount_ques_per_topic = $value['part_amount_ques_per_topic'];
            }
            //
            //dd($part_amount_ques_per_topic);
            $all_quess = Question::where('topic_id',$all_topic_ok['topic_id'])
            ->inRandomOrder()->limit($part_amount_ques_per_topic)->get()->toArray();

            //dd($all_quess);
            foreach ($all_quess as $key => $all_ques) {
                //array_push($push_allques, $all_ques['question_id']);
                $insQuestion= new LessonContent();
                $insQuestion->lesson_id= $lesson_id ;
                $insQuestion->question_id= $all_ques['question_id'];
                $insQuestion->save();
                // $index++;
                    //$abc++;

                $lesson_content_id = $insQuestion->lesson_content_id;

                    //them answer_student

                $ans_stu = new AnswerStudent();
                $ans_stu->lesson_content_id = $lesson_content_id;
                $ans_stu->result_id=$result_id;
                $ans_stu->ans_id_stu = null;
                $ans_stu->ans_task= null;
                $ans_stu->mark = null;
                $ans_stu->save(); 
            }
        }
  
        }else{

            return response()->json(['error' => 'Please click OK to again!!!']);
        }

        return response()->json([
            'lesson_id'     =>      isset($_GET['lesson'])     ? $_GET['lesson']    : $lesson_id, 
            'result_id'     =>      isset($_GET['result'])     ? $_GET['result']    : $result_id,
            'filter_id'     =>      $filter_id,     
        ]);

}  

    // ham show de thi vua radom

public function show_random_example($filter_id)
{   

    $lesson_id = $_GET['lesson'];
    $result_id = $_GET['result'];

    //nếu đã có kết quả
    $count_result_full = Result::find($result_id)->lesson_content->count();
    $count_result_null = Result::find($result_id)->lesson_content()->whereNull('mark')->count();

    if(Result::find($result_id)->total_mark !== null || ($count_result_full > $count_result_null)){
        return redirect('show-result-example/'.$result_id);
    }

    // =======================================PROCESSING=======================================
    $filter_parts = FilterPart::join('parts','parts.part_id','=','filter_parts.part_id')
    ->where('filter_parts.filter_id',$filter_id)->distinct()
    ->get()->toArray();

    $filter = FilterStructure::where('filter_id',$filter_id)->get()->toArray();
    foreach($filter as $k => $value)
    {
        $filter_status=$value['filter_status'];
    }

    $skills = Skill::all();
    $amountquesListen = 0;
    $amountquesread = 0;
    $amountqueswrite = 0;
    $amountquesspeak = 0;

    foreach ($skills as $key => $value) {

        foreach ($filter_parts as $key => $filter_part) {
            // dd($filter_part);
            // $amountQuesPart=0;
            if($value['skill_id']==$filter_part['skill_id'] && $value['skill_name']=='Listening'){
                 // dd($filter_part);
                $amountQuesPart = $filter_part['part_amount_ques_per_topic']*$filter_part['filter_part_amount_topic'];
                $amountquesListen += $amountQuesPart;

            }else if($value['skill_id']==$filter_part['skill_id'] && $value['skill_name']=='Reading'){
                 // dd($filter_part);
                $amountQuesPart = $filter_part['part_amount_ques_per_topic']*$filter_part['filter_part_amount_topic'];
                $amountquesread += $amountQuesPart;

            }else if($value['skill_id']==$filter_part['skill_id'] && $value['skill_name']=='Writting'){
                 // dd($filter_part);
                $amountQuesPart = $filter_part['part_amount_ques_per_topic']*$filter_part['filter_part_amount_topic'];
                $amountqueswrite += $amountQuesPart;

            }else if($value['skill_id']==$filter_part['skill_id'] && $value['skill_name']=='Speaking'){
                 // dd($filter_part);
                $amountQuesPart = $filter_part['part_amount_ques_per_topic']*$filter_part['filter_part_amount_topic'];
                $amountquesspeak += $amountQuesPart;

            }
        }
    }


    $data = array();
    $data_listen = array();
    $data_read = array();
    $data_write = array();
    $data_speak = array();
    $lesson = Lesson::find($lesson_id);
    $lesson_contents = $lesson->questions;
    foreach($lesson_contents as $question){
        $answers = Question::find($question->question_id)->answers()->inRandomOrder()->get(['answer_content','answer_id']);
        
        $topic = Topic::find($question->topic_id);
        $part = $topic->parts;
        $skill = Part::find($part->part_id)->skills->skill_name;
        //nếu kỹ năng nghe
        if ($skill == 'Listening') {
            array_push($data_listen, 
                [
                    'part_id'       =>    $part->part_id,
                    'part_name'     =>    $part->part_name,
                    'part_des'      =>    isset($part->part_des) ? $part->part_des : null,
                    'topic'         =>    [[
                        'topic_id'      =>  $topic->topic_id,
                        'topic_name'    =>  $topic->topic_name,
                        'topic_audio'   =>  $topic->topic_audio,
                        'topic_image'   =>  $topic->topic_image,
                        'questions'     =>  [[
                            'question_id'       =>   $question->question_id,
                            'question_content'  =>   $question->question_content,
                            'answers'           =>   $answers,
                        ]],
                    ]],  
                ]
            );
        }
        //nếu kỹ năng đọc
        else if ($skill == 'Reading') {
            array_push($data_read, 
                [
                    'part_id'       =>    $part->part_id,
                    'part_name'     =>    $part->part_name,
                    'part_des'      =>    isset($part->part_des) ?  $part->part_des : null,
                    'topic'         =>    [[
                        'topic_id'          =>  $topic->topic_id,
                        'topic_name'        =>  $topic->topic_name,
                        'topic_content'     =>  $topic->topic_content,
                        'topic_image'       =>  $topic->topic_image,
                        'questions'         =>  [[
                            'question_id'       =>   $question->question_id,
                            'question_content'  =>   $question->question_content,
                            'answers'           =>   $answers,
                        ]],
                    ]],  
                ]
            );
        }
        //nếu kỹ năng đọc
        else if ($skill == 'Writting') {
            array_push($data_write, 
                [
                    'part_id'       =>    $part->part_id,
                    'part_name'     =>    $part->part_name,
                    'part_des'      =>    isset($part->part_des) ? $part->part_des : null,
                    'topic'         =>    [[
                        'topic_id'        =>  $topic->topic_id,
                        'topic_name'      =>  $topic->topic_name,
                        'topic_content'   =>  $topic->topic_content,
                        'topic_image'       =>  $topic->topic_image,
                        'questions'       =>  [[
                            'question_id'       =>   $question->question_id,
                            'question_content'  =>   $question->question_content,

                        ]],
                    ]],  
                ]
            );
        }
        //nếu kỹ năng đọc
        else if ($skill == 'Speaking') {
            array_push($data_speak, 
                [
                    'part_id'       =>    $part->part_id,
                    'part_name'     =>    $part->part_name,
                    'part_des'      =>    isset($part->part_des) ? $part->part_des : null,
                    'topic'         =>    [[
                        'topic_id'          =>  $topic->topic_id,
                        'topic_name'        =>  $topic->topic_name,
                        'topic_content'     =>  $topic->topic_content,
                        'topic_image'       =>  $topic->topic_image,
                        'questions'         =>  [[
                            'question_id'       =>   $question->question_id,
                            'question_content'  =>   $question->question_content,

                        ]],
                    ]],  
                ]
            );
        }
    }


        // =================================LISTENING=================================

    //gom part 
    $j = 1;
    $count_listen = count($data_listen);
    for($i = 0; $i < $count_listen ; $i = isset($key_listen)?$key_listen:$i){
        if ($j == $count_listen) {
            break;
        }
        if ($data_listen[$i]['part_id'] == $data_listen[$j]['part_id']) {
            array_push($data_listen[$i]['topic'], $data_listen[$j]['topic'][0]);
            unset($data_listen[$j]);
            
        }else{
            $key_listen = $j; 
        }
        $j++;
    }

    //gom topic
    foreach($data_listen as $key => $data_listen_s){

        $l = 0;
        $count_topic_listen = count($data_listen[$key]['topic']);
        for($j = 1; $j < $count_topic_listen ; $j++){

            if ($data_listen[$key]['topic'][$l]['topic_id'] == $data_listen[$key]['topic'][$j]['topic_id']) {
                array_push($data_listen[$key]['topic'][$l]['questions'], $data_listen[$key]['topic'][$j]['questions'][0]);
                unset($data_listen[$key]['topic'][$j]);
            }else{
                $l = $j;
            }
        }
    }

    // =================================READING=================================

    //gom part 
    $j = 1;
    $count_read = count($data_read);
    for($i = 0; $i < $count_read ; $i = isset($key_read)?$key_read:$i){
        if ($j == $count_read) {
            break;
        }
        if ($data_read[$i]['part_id'] == $data_read[$j]['part_id']) {
            array_push($data_read[$i]['topic'], $data_read[$j]['topic'][0]);
            unset($data_read[$j]);
            
        }else{
            $key_read = $j; 
        }
        $j++;
    }

    //gom topic
    foreach($data_read as $key => $data_read_s){

        $l = 0;
        $count_topic_read = count($data_read[$key]['topic']);
        for($j = 1; $j < $count_topic_read ; $j++){

            if ($data_read[$key]['topic'][$l]['topic_id'] == $data_read[$key]['topic'][$j]['topic_id']) {
                array_push($data_read[$key]['topic'][$l]['questions'], $data_read[$key]['topic'][$j]['questions'][0]);
                unset($data_read[$key]['topic'][$j]);
            }else{
                $l = $j;
            }
        }
    }

    // =================================WRITTING=================================

    //gom part 
    $j = 1;
    $count_write = count($data_write);
    for($i = 0; $i < $count_write ; $i = isset($key_write)?$key_write:$i){
        if ($j == $count_write) {
            break;
        }
        if ($data_write[$i]['part_id'] == $data_write[$j]['part_id']) {
            array_push($data_write[$i]['topic'], $data_write[$j]['topic'][0]);
            unset($data_write[$j]);
            
        }else{
            $key_write = $j; 
        }
        $j++;
    }

    //gom topic
    foreach($data_write as $key => $data_write_s){

        $l = 0;
        $count_topic_write = count($data_write[$key]['topic']);
        for($j = 1; $j < $count_topic_write ; $j++){

            if ($data_write[$key]['topic'][$l]['topic_id'] == $data_write[$key]['topic'][$j]['topic_id']) {
                array_push($data_write[$key]['topic'][$l]['questions'], $data_write[$key]['topic'][$j]['questions'][0]);
                unset($data_write[$key]['topic'][$j]);
            }else{
                $l = $j;
            }
        }
    }

    // =================================SPEAKING=================================

    //gom part 
    $j = 1;
    $count_speak = count($data_speak);
    for($i = 0; $i < $count_speak ; $i = isset($key_speak)?$key_speak:$i){
        if ($j == $count_speak) {
            break;
        }
        if ($data_speak[$i]['part_id'] == $data_speak[$j]['part_id']) {
            array_push($data_speak[$i]['topic'], $data_speak[$j]['topic'][0]);
            unset($data_speak[$j]);
            
        }else{
            $key_speak = $j; 
        }
        $j++;
    }

    //gom topic
    foreach($data_speak as $key => $data_speak_s){

        $l = 0;
        $count_topic_speak = count($data_speak[$key]['topic']);
        for($j = 1; $j < $count_topic_speak ; $j++){

            if ($data_speak[$key]['topic'][$l]['topic_id'] == $data_speak[$key]['topic'][$j]['topic_id']) {
                array_push($data_speak[$key]['topic'][$l]['questions'], $data_speak[$key]['topic'][$j]['questions'][0]);
                unset($data_speak[$key]['topic'][$j]);
            }else{
                $l = $j;
            }
        }
    }

    $data['Listening']  = $data_listen;
    $data['Reading']    = $data_read;
    $data['Writting']   = $data_write;
    $data['Speaking']   = $data_speak;
    
    $lesson_status = Lesson::find($lesson_id)->lesson_status;

    $lesson_id = $lesson_id;
    $result_id = $result_id;
    return View('pages.Example_test.show_example',compact('data','filter_id','filter_status','lesson_status','lesson_id','result_id','amountquesListen','amountquesread','amountqueswrite','amountquesspeak'));

}

public function results_example_test($result_id)
{   

        $lesson_id = $_POST['lesson_id'];

        $check_re = Result::find($result_id)->lesson_content->count();
        $check_lesson_cont = LessonContent::whereLessonId($lesson_id)->count();

        if ($check_re < $check_lesson_cont) {

            foreach($_POST['nameSpeak'] as $key_speak => $v){
                $data_speak[] = $key_speak;
            }

            $lesson_cont = LessonContent::whereLessonId($lesson_id)->whereNotIn('question_id',$data_speak)->get('lesson_content_id')->toArray();

            $re_new = Result::find($result_id);

            $re_new->lesson_content()->attach($lesson_cont, 
                [
                    'ans_id_stu'        =>  null,
                    'ans_task'          =>  null,
                    'note'              =>  null,
                    'mark'              =>  null,
                ]);

        }

        $lesson_id = AnswerStudent::join('lesson_contents','lesson_contents.lesson_content_id','=','answer_students.lesson_content_id')
        ->where('answer_students.result_id',$result_id)->get('lesson_contents.lesson_id')->toArray();
        foreach ($lesson_id as $key => $value) {
            $lesson_id = $value['lesson_id'];
        }

    $array_question_listen = [];

    if(empty($_POST['nameListen'])){
        $countListen =0;
        $tampListen=0;
    }else if(isset($_POST['nameListen'])){
        $countListen =0;
        $tampListen=0;
        foreach ($_POST['nameListen'] as $key => $value) {

           $check_listen=Answer::where('answer_id','=',$value)->get()->toArray();

           foreach($check_listen as $k => $v)
           {
            $array_question_listen[] = $v['question_id']; 
            $ans_true = $v['answer_true'];
            $question_id=$v['question_id'];
            $question_mark= Question::where('question_id',$question_id)->get('question_mark')->toArray();

            foreach($question_mark as $k =>$question_marks)
            {
                $mark=$question_marks['question_mark'];
            }

            $les_content_id = LessonContent::where([['lesson_id',$lesson_id],['question_id',$question_id]])->get('lesson_content_id')->toArray();
                    
            foreach ($les_content_id as $key => $value) {
                $les_content_id = $value['lesson_content_id'];
            }

            if($ans_true==1)
            {
                $mark_true = $mark;
                $countListen++;
                $tampListen += $mark;
            }else{
                $mark_true = 0;
            }

            $update_ans_stu = AnswerStudent::where([['lesson_content_id',$les_content_id],['result_id',$result_id]])
            ->update(['ans_id_stu' => $v['answer_id'],'mark' => $mark_true ]);
        } 
    }
}

    //xử lý câu hỏi không chọn đáp án
    foreach(Lesson::find($lesson_id)->questions as $ques){
        $topic_id = Question::find($ques->question_id)->topics->topic_id;
        $part_id = Topic::find($topic_id)->parts->part_id;
        $skill = Part::find($part_id)->skills->skill_name;

        if ($skill == 'Listening' && !in_array($ques->question_id, $array_question_listen)) {

            $les_content_id = LessonContent::where('lesson_id', $lesson_id)->where('question_id', $ques->question_id)->first()->toArray();

            $update_ans_stu = AnswerStudent::where([['lesson_content_id',$les_content_id['lesson_content_id']],['result_id',$result_id]])
            ->update(['ans_id_stu' => null,'mark' => '0' ]);
        }
    }


$array_question_read = [];

if(empty($_POST['nameRead'])){
    $countRead=0;
    $tampRead=0;
}else{
    $countRead=0;
    $tampRead=0;
    
    foreach ($_POST['nameRead'] as $key => $value) {

        $check_read=Answer::where('answer_id','=',$value)->get()->toArray();
        foreach($check_read as $k => $v)
        {
            $array_question_read[] = $v['question_id'];
            $ans_true = $v['answer_true'];
            $question_id=$v['question_id'];
            $question_mark= Question::where('question_id',$question_id)->get('question_mark')->toArray();
                   
            foreach($question_mark as $k =>$question_marks)
            {
                $mark=$question_marks['question_mark'];
            }
            $les_content_id = LessonContent::where([['lesson_id',$lesson_id],['question_id',$question_id]])->get('lesson_content_id')->toArray();
                   
            foreach ($les_content_id as $key => $les_content_id) {
                $les_content_id = $les_content_id['lesson_content_id'];
            }
              


            if($ans_true==1)
            {
                $mark_true = $mark;
                $countRead++;
                $tampRead += $mark;
            }else{
                $mark_true = 0;
            }

            $update_ans_stu = AnswerStudent::where([['lesson_content_id',$les_content_id],['result_id',$result_id]])
            ->update(['ans_id_stu' => $v['answer_id'],'mark' => $mark_true]);

        } 
    }
}

    //xử lý câu hỏi không chọn đáp án
    foreach(Lesson::find($lesson_id)->questions as $ques){
        $topic_id = Question::find($ques->question_id)->topics->topic_id;
        $part_id = Topic::find($topic_id)->parts->part_id;
        $skill = Part::find($part_id)->skills->skill_name;
        if ($skill == 'Reading' && !in_array($ques->question_id, $array_question_read)) {

            $les_content_id = LessonContent::where('lesson_id', $lesson_id)->where('question_id', $ques->question_id)->first()->toArray();

            $update_ans_stu = AnswerStudent::where([['lesson_content_id',$les_content_id['lesson_content_id']],['result_id',$result_id]])
            ->update(['ans_id_stu' => null,'mark' => '0' ]);
        }
    }

         //point writing
if(isset($_POST['nameWrite'])){
           
    foreach ($_POST['nameWrite'] as $key => $value) {
                
        $question_id=$key;
        $question_mark= Question::where('question_id',$question_id)->get('question_mark')->toArray();

        foreach($question_mark as $k =>$question_marks)
        {
            $mark=$question_marks['question_mark'];
        }
        
        
                  //them answer_student
        $les_content_id = LessonContent::where([['lesson_id',$lesson_id],['question_id',$question_id]])->get('lesson_content_id')->toArray();
                
        foreach ($les_content_id as $key => $les_content_id) {
            $les_content_id = $les_content_id['lesson_content_id'];
        }
                
        $update_ans_stu = AnswerStudent::where([['lesson_content_id',$les_content_id],['result_id',$result_id]])
        ->update(
            [
                'ans_task' => $value,
                'mark'     => Result::find($result_id)->fee == 0 ? 0 : null,
            ]);
        
    }
}

$total = $tampListen + $tampRead;

$result = Result::find($result_id);

//nếu bài thi không thu phí
if (Result::find($result_id)->fee == 0) {

    //xử lý điểm nếu có phần nói, viết
    foreach(Lesson::find($lesson_id)->questions as $ques){
        $topic_id = Question::find($ques->question_id)->topics->topic_id;
        $part_id = Topic::find($topic_id)->parts->part_id;
        $skill = Part::find($part_id)->skills->skill_name;
        if ($skill == 'Writting' || $skill == 'Speaking') {

            $les_content_id = LessonContent::where('lesson_id', $lesson_id)->where('question_id', $ques->question_id)->first()->toArray();

            $update_ans_stu = AnswerStudent::where([['lesson_content_id',$les_content_id['lesson_content_id']],['result_id',$result_id]])
            ->update(['mark' => '0']);
        }
    }
    $result->total_mark = $total;
    
}
    $result->submit = 1;
    $result->save(); 

return view('pages.Example_test.results_test')
->with('countListen',$countListen)
->with('tampListen',$tampListen)
->with('countRead',$countRead)
->with('tampRead',$tampRead)
->with('total',$total)
->with('result_id',$result_id);
}

public function show_result_example($result_id)
{   

    $data = array();
    $data_listen = array();
    $data_read = array();
    $data_write = array();
    $data_speak = array();
    $result = Result::find($result_id);
    $lesson_contents = $result->lesson_content;
    foreach($lesson_contents as $lesson_cont){
        $lesson_id = $lesson_cont->lesson_id;
        $question = Question::find($lesson_cont->question_id);
        $answers = $question->answers()->get(['answer_id','answer_content','answer_true']);
        $topic = Topic::find($question->topic_id);
        $part = $topic->parts;
        $skill = Part::find($part->part_id)->skills->skill_name;

        //nếu là nghe
        if ($skill == 'Listening') {
            array_push($data_listen, 
                [
                    'part_id'       =>    $part->part_id,
                    'part_name'     =>    $part->part_name,
                    'part_des'      =>    isset($part->part_des) ? $part->part_des : null,
                    'topic'         =>    [[
                        'topic_id'        =>  $topic->topic_id,
                        'topic_name'      =>  $topic->topic_name,
                        'topic_audio'     =>  $topic->topic_audio,
                        'topic_image'     =>  $topic->topic_image,
                        'questions'       =>  [[
                            'question_id'       =>   $question->question_id,
                            'question_content'  =>   $question->question_content,
                            'answers'           =>   $answers,
                            'ans_id_stu'        =>   $lesson_cont->pivot->ans_id_stu,
                        ]],
                    ]],  
                ]
            );
        }
        //nếu là đọc
        else if ($skill == 'Reading') {
            array_push($data_read, 
                [
                    'part_id'       =>    $part->part_id,
                    'part_name'     =>    $part->part_name,
                    'part_des'      =>    isset($part->part_des) ? $part->part_des : null,
                    'topic'         =>    [[
                        'topic_id'        =>  $topic->topic_id,
                        'topic_name'      =>  $topic->topic_name,
                        'topic_content'   =>  $topic->topic_content,
                        'topic_image'     =>  $topic->topic_image,
                        'questions'       =>  [[
                            'question_id'       =>   $question->question_id,
                            'question_content'  =>   $question->question_content,
                            'answers'           =>   $answers,
                            'ans_id_stu'        =>   $lesson_cont->pivot->ans_id_stu,
                            
                        ]],
                    ]],  
                ]
            );
        }
        //nếu là viết
        else if ($skill == 'Writting') {
            array_push($data_write, 
                [
                    'part_id'       =>    $part->part_id,
                    'part_name'     =>    $part->part_name,
                    'part_des'      =>    isset($part->part_des) ? $part->part_des : null,
                    'topic'         =>    [[
                        'topic_id'        =>  $topic->topic_id,
                        'topic_name'      =>  $topic->topic_name,
                        'topic_content'   =>  $topic->topic_content,
                        'topic_image'     =>  $topic->topic_image,
                        'questions'       =>  [[
                            'question_id'       =>   $question->question_id,
                            'question_content'  =>   $question->question_content,
                            'ans_task'          =>   $lesson_cont->pivot->ans_task,
                            'note'              =>   $lesson_cont->pivot->note,
                            'mark'              =>   $lesson_cont->pivot->mark,
                        ]],
                    ]],  
                ]
            );
            $check_write = $lesson_cont->pivot->mark;

        }
        //nếu kỹ năng đọc
        else if ($skill == 'Speaking') {
            array_push($data_speak, 
                [
                    'part_id'       =>    $part->part_id,
                    'part_name'     =>    $part->part_name,
                    'part_des'      =>    isset($part->part_des) ? $part->part_des : null,
                    'topic'         =>    [[
                        'topic_id'          =>  $topic->topic_id,
                        'topic_name'        =>  $topic->topic_name,
                        'topic_content'     =>  $topic->topic_content,
                        'topic_image'       =>  $topic->topic_image,
                        'questions'         =>  [[
                            'question_id'       =>   $question->question_id,
                            'question_content'  =>   $question->question_content,
                            'ans_task'          =>   $lesson_cont->pivot->ans_task,
                            'note'              =>   $lesson_cont->pivot->note,
                            'mark'              =>   $lesson_cont->pivot->mark,
                        ]],
                    ]],  
                ]
            );
        }
    }

     // =================================LISTENING=================================

    //gom part 
    $j = 1;
    $count_listen = count($data_listen);
    for($i = 0; $i < $count_listen ; $i = isset($key_listen)?$key_listen:$i){
        if ($j == $count_listen) {
            break;
        }
        if ($data_listen[$i]['part_id'] == $data_listen[$j]['part_id']) {
            array_push($data_listen[$i]['topic'], $data_listen[$j]['topic'][0]);
            unset($data_listen[$j]);
            
        }else{
            $key_listen = $j; 
        }
        $j++;
    }

    //gom topic
    foreach($data_listen as $key => $data_listen_s){

        $l = 0;
        $count_topic_listen = count($data_listen[$key]['topic']);
        for($j = 1; $j < $count_topic_listen ; $j++){

            if ($data_listen[$key]['topic'][$l]['topic_id'] == $data_listen[$key]['topic'][$j]['topic_id']) {
                array_push($data_listen[$key]['topic'][$l]['questions'], $data_listen[$key]['topic'][$j]['questions'][0]);
                unset($data_listen[$key]['topic'][$j]);
            }else{
                $l = $j;
            }
        }
    }
     // =================================READING=================================

    //gom part 
    $j = 1;
    $count_read = count($data_read);
    for($i = 0; $i < $count_read ; $i = isset($key_read)?$key_read:$i){
        if ($j == $count_read) {
            break;
        }
        if ($data_read[$i]['part_id'] == $data_read[$j]['part_id']) {
            array_push($data_read[$i]['topic'], $data_read[$j]['topic'][0]);
            unset($data_read[$j]);
            
        }else{
            $key_read = $j; 
        }
        $j++;
    }

    //gom topic
    foreach($data_read as $key => $data_read_s){

        $l = 0;
        $count_topic_read = count($data_read[$key]['topic']);
        for($j = 1; $j < $count_topic_read ; $j++){

            if ($data_read[$key]['topic'][$l]['topic_id'] == $data_read[$key]['topic'][$j]['topic_id']) {
                array_push($data_read[$key]['topic'][$l]['questions'], $data_read[$key]['topic'][$j]['questions'][0]);
                unset($data_read[$key]['topic'][$j]);
            }else{
                $l = $j;
            }
        }
    }
    // =================================WRITTING=================================

    //gom part 
    $j = 1;
    $count_write = count($data_write);
    for($i = 0; $i < $count_write ; $i = isset($key_write)?$key_write:$i){
        if ($j == $count_write) {
            break;
        }
        if ($data_write[$i]['part_id'] == $data_write[$j]['part_id']) {
            array_push($data_write[$i]['topic'], $data_write[$j]['topic'][0]);
            unset($data_write[$j]);
            
        }else{
            $key_write = $j; 
        }
        $j++;
    }

    //gom topic
    foreach($data_write as $key => $data_write_s){

        $l = 0;
        $count_topic_write = count($data_write[$key]['topic']);
        for($j = 1; $j < $count_topic_write ; $j++){

            if ($data_write[$key]['topic'][$l]['topic_id'] == $data_write[$key]['topic'][$j]['topic_id']) {
                array_push($data_write[$key]['topic'][$l]['questions'], $data_write[$key]['topic'][$j]['questions'][0]);
                unset($data_write[$key]['topic'][$j]);
            }else{
                $l = $j;
            }
        }
    }

    // =================================SPEAKING=================================

    //gom part 
    $j = 1;
    $count_speak = count($data_speak);
    for($i = 0; $i < $count_speak ; $i = isset($key_speak)?$key_speak:$i){
        if ($j == $count_speak) {
            break;
        }
        if ($data_speak[$i]['part_id'] == $data_speak[$j]['part_id']) {
            array_push($data_speak[$i]['topic'], $data_speak[$j]['topic'][0]);
            unset($data_speak[$j]);
            
        }else{
            $key_speak = $j; 
        }
        $j++;
    }

    //gom topic
    foreach($data_speak as $key => $data_speak_s){

        $l = 0;
        $count_topic_speak = count($data_speak[$key]['topic']);
        for($j = 1; $j < $count_topic_speak ; $j++){

            if ($data_speak[$key]['topic'][$l]['topic_id'] == $data_speak[$key]['topic'][$j]['topic_id']) {
                array_push($data_speak[$key]['topic'][$l]['questions'], $data_speak[$key]['topic'][$j]['questions'][0]);
                unset($data_speak[$key]['topic'][$j]);
            }else{
                $l = $j;
            }
        }
    }

    $data['Listening']  = $data_listen;
    $data['Reading']    = $data_read;
    $data['Writting']   = $data_write;
    $data['Speaking']   = $data_speak;

    return view('pages.Example_test.show_result_example', compact('data'))
    ->with('check_write',isset($check_write) ? $check_write:null)
    ->with('fee',Result::find($result_id)->fee);
}

public function start_exercise(Request $re)
{   

    $student_id = Session::get('student_id');

    $struc = new FilterStructure();
    $struc->filter_name=$student_id;
    $struc->filter_status=0;
    $struc->save();
    $filter_id=$struc->filter_id;

    $level_id=Level::inRandomOrder()->limit(1)->get('level_id');
    foreach ($level_id as $key => $level_id) {
        $level_id=$level_id->level_id;
    }

    $values = $re->values;
        
    $index=0;
    foreach ($values as $key => $value) {
        foreach ($value as $k => $v) {

            if ($k == 1) {

                $fil_part = new FilterPart();
                $fil_part->part_id = $v;
                $fil_part->filter_id = $filter_id;
                $fil_part->filter_part_amount_topic = 1;
                $fil_part->filter_topic_level = $level_id;
                $fil_part->save();

            }else if($k == 2 && $v != 'random_level') {

                $fil_part->update(['filter_topic_level' => $v]);
            }else if($k == 3) {
               $fil_part->update(['filter_part_amount_topic' => $v]);
               $index++;
           }

       }
   }

   return response()->json($filter_id);
         
}
public function check_filter(Request $re)
{

    $part_id = $re->part_id;
    $level_id =$re->level_id;
    $level_name =$re->level_name;

    $amountQuess=Part::where('part_id',$part_id)->get();
    foreach ($amountQuess as $key => $va) {
        $amountQues = $va['part_amount_ques_per_topic'];
        $amountMax = $va['part_topic_max'];
    }
    $all_quess = Question::join('topics','topics.topic_id','=','questions.topic_id')
    ->where([['topics.part_id',$part_id],['topics.level_id',$level_id]])
    ->get(['questions.question_id','questions.topic_id']);

    $all_topics = Topic::where([['part_id',$part_id],['level_id',$level_id]])->get();
    $count=0;
    foreach ($all_topics as $k => $all_topic) {
        $index=0;
            // $count++;
        foreach ($all_quess as $key => $all_ques) {
            if ($all_ques['topic_id'] == $all_topic['topic_id']) {
                $index++; 
                if($index >= $amountQues)
                {
                    $count++;
                }
            }

        }
    }

    return response()->json(['check'=>$count,
        'part_id'=>$part_id,
        'level_id'=>$level_id,
        'level_name'=>$level_name,
        'amountQuess'=> $amountQues,
        'amountMax'=>$amountMax,
    ]);


        // return response()->json($all_quess);
}

public function check_filter_err(Request $re)
{
    $error_part = $re->error_level;
    $err_part = Part::whereIn('part_id', $error_part)->get('part_name');
    return response()->json($err_part);
}


public function save_src(Request $re)
{
    $arrsrc = $re->arrsrc;
    $result_id = $re->result_id;

    $allques = LessonContent::join('answer_students','lesson_contents.lesson_content_id','=','answer_students.lesson_content_id')
    ->where('answer_students.result_id',$result_id)
    ->get(['lesson_contents.question_id','lesson_contents.lesson_content_id'])->toArray();
       

    foreach ($allques as $key => $allque) {
        foreach ($arrsrc as $key => $arrsrcs) {

            if($allque['question_id'] == $arrsrcs[0]){

                $update_ans_speak = AnswerStudent::where('answer_students.lesson_content_id',$allque['lesson_content_id'])
                ->update(
                    [
                        'answer_students.ans_task' => (isset($arrsrcs[2]) && Result::find($result_id)->fee > 0) ? $key.time().".wav" : null,
                        'answer_students.mark'     => Result::find($result_id)->fee == 0 ? 0 : null,  
                    ]);

                if(isset($arrsrcs[2]) && Result::find($result_id)->fee > 0){
                  $audio = $arrsrcs[2];
                  $audio = str_replace('data:audio/wav;base64,', '', $audio);
                  $decoded = base64_decode($audio);
                  $file_location = "./file/answer_record/".$key.time().".wav";

                  file_put_contents($file_location, $decoded);
              }
          }  
      }
  }

  return response()->json(['arrsrc'=>$arrsrc]);
}

//bài học mẫu
public function lesson_sample(){
    $no = 1;
    $data = array();
    $data_skill = Skill::whereIn('skill_name', ['Writting','Speaking'])->get('skill_id')->toArray();

    $filters = FilterStructure::whereNotIn('filter_status', [0, -1])->get();

    foreach($filters as $filter){
        $filter_lesson = FilterStructure::find($filter->filter_id);
        $filter_part = $filter_lesson->parts()->whereIn('skill_id' ,$data_skill);
        
        $j = 1;
        $diff = [];
        foreach($filter_part->get(['skill_id']) as $k => $fil_part){
            if ($j == $filter_part->count()) {
                break;
            }

            if ($k == 0) {
                $diff[] = Skill::find($fil_part['skill_id'])->skill_name;
            }

            if ($filter_part->get(['skill_id'])[$k]['skill_id'] != $filter_part->get(['skill_id'])[$j]['skill_id']) {
                $diff[] = Skill::find($filter_part->get(['skill_id'])[$j]['skill_id'])->skill_name;
            }
            
            $j++;
        }

        
        $lessons = $filter_lesson->lessons()->where('lesson_status', 1)->get();

        foreach($lessons as $key_lesson => $lesson){

         $lesson_cont_id = LessonContent::where('lesson_id',$lesson->lesson_id)->first('lesson_content_id');
         $result = LessonContent::find($lesson_cont_id['lesson_content_id'])->results()->whereStudentId(session()->get('student_id'));
        
         array_push($data, 
            [
                'lesson_id'     =>  $lesson->lesson_id, 
                'no'            =>  $no++,
                'fee'           =>  $result->count() > 0 ? $result->first()->fee : null,
                'free'          =>  $filter_part->count() > 0 ? 0 : 1,  
                'skill_pay'     =>  count($diff) > 0 ? $diff : null, 
                'finish'        =>  ($result->count() > 0 && $result->first()->submit == 1) ? 1 : 0,
                'result'        =>  $result->count() > 0 ? $result->first()->result_id : null, 
            ]
        );
     }
 }

 return View('pages.lesson_sample.lesson_sample', compact('data'));
}

//tạo result
public function result_sample(){
    $result_new = new Result;
    $result_new->student_id = session()->get('student_id');
    $result_new->fee = $_GET['fee'];
    $result_new->submit = 0;
    $result_new->save();
    $result_id_new = $result_new->result_id;

    $lesson_id = $_GET['lesson'];

    $lesson_content = LessonContent::whereLessonId($lesson_id)->get();
    
    $re_new = Result::find($result_id_new);

    foreach($lesson_content as $lesson_cont){

        $re_new->lesson_content()->attach($lesson_cont->lesson_content_id, 
        [
            'ans_id_stu'        =>  null,
            'ans_task'          =>  null,
            'note'              =>  null,
            'mark'              =>  null,
        ]);
    }

    return response()->json($result_id_new);
    
}


public function show_lesson_sample($lesson_id){

    $data = array();
    $data_listen = array();
    $data_read = array();
    $data_write = array();
    $data_speak = array();
    $lesson = Lesson::find($lesson_id);
    $lesson_contents = $lesson->questions;
    foreach($lesson_contents as $question){
        $answers = Question::find($question->question_id)->answers()->inRandomOrder()->get(['answer_content','answer_id']);
        
        $topic = Topic::find($question->topic_id);
        $part = $topic->parts;
        $skill = Part::find($part->part_id)->skills->skill_name;
        //nếu kỹ năng nghe
        if ($skill == 'Listening') {
            array_push($data_listen, 
                [
                    'part_id'       =>    $part->part_id,
                    'part_name'     =>    $part->part_name,
                    'part_des'      =>    isset($part->part_des) ? $part->part_des : null,
                    'topic'         =>    [[
                        'topic_id'      =>  $topic->topic_id,
                        'topic_name'    =>  $topic->topic_name,
                        'topic_audio'   =>  $topic->topic_audio,
                        'topic_image'   =>  $topic->topic_image,
                        'questions'     =>  [[
                            'question_id'       =>   $question->question_id,
                            'question_content'  =>   $question->question_content,
                            'answers'           =>   $answers,
                        ]],
                    ]],  
                ]
            );
        }
        //nếu kỹ năng đọc
        else if ($skill == 'Reading') {
            array_push($data_read, 
                [
                    'part_id'       =>    $part->part_id,
                    'part_name'     =>    $part->part_name,
                    'part_des'      =>    isset($part->part_des) ? $part->part_des : null,
                    'topic'         =>    [[
                        'topic_id'          =>  $topic->topic_id,
                        'topic_name'        =>  $topic->topic_name,
                        'topic_content'     =>  $topic->topic_content,
                        'topic_image'       =>  $topic->topic_image,
                        'questions'         =>  [[
                            'question_id'       =>   $question->question_id,
                            'question_content'  =>   $question->question_content,
                            'answers'           =>   $answers,
                        ]],
                    ]],  
                ]
            );
        }
        //nếu kỹ năng đọc
        else if ($skill == 'Writting') {
            array_push($data_write, 
                [
                    'part_id'       =>    $part->part_id,
                    'part_name'     =>    $part->part_name,
                    'part_des'      =>    isset($part->part_des) ? $part->part_des : null,
                    'topic'         =>    [[
                        'topic_id'        =>  $topic->topic_id,
                        'topic_name'      =>  $topic->topic_name,
                        'topic_content'   =>  $topic->topic_content,
                        'topic_image'     =>  $topic->topic_image,
                        'questions'       =>  [[
                            'question_id'       =>   $question->question_id,
                            'question_content'  =>   $question->question_content,

                        ]],
                    ]],  
                ]
            );
        }
        //nếu kỹ năng đọc
        else if ($skill == 'Speaking') {
            array_push($data_speak, 
                [
                    'part_id'       =>    $part->part_id,
                    'part_name'     =>    $part->part_name,
                    'part_des'      =>    isset($part->part_des) ? $part->part_des : null,
                    'topic'         =>    [[
                        'topic_id'          =>  $topic->topic_id,
                        'topic_name'        =>  $topic->topic_name,
                        'topic_content'     =>  $topic->topic_content,
                        'topic_image'       =>  $topic->topic_image,
                        'questions'         =>  [[
                            'question_id'       =>   $question->question_id,
                            'question_content'  =>   $question->question_content,

                        ]],
                    ]],  
                ]
            );
        }
    }


        // =================================LISTENING=================================

    //gom part 
    $j = 1;
    $count_listen = count($data_listen);
    for($i = 0; $i < $count_listen ; $i = isset($key_listen)?$key_listen:$i){
        if ($j == $count_listen) {
            break;
        }
        if ($data_listen[$i]['part_id'] == $data_listen[$j]['part_id']) {
            array_push($data_listen[$i]['topic'], $data_listen[$j]['topic'][0]);
            unset($data_listen[$j]);
            
        }else{
            $key_listen = $j; 
        }
        $j++;
    }

    //gom topic
    foreach($data_listen as $key => $data_listen_s){

        $l = 0;
        $count_topic_listen = count($data_listen[$key]['topic']);
        for($j = 1; $j < $count_topic_listen ; $j++){

            if ($data_listen[$key]['topic'][$l]['topic_id'] == $data_listen[$key]['topic'][$j]['topic_id']) {
                array_push($data_listen[$key]['topic'][$l]['questions'], $data_listen[$key]['topic'][$j]['questions'][0]);
                unset($data_listen[$key]['topic'][$j]);
            }else{
                $l = $j;
            }
        }
    }

    // =================================READING=================================

    //gom part 
    $j = 1;
    $count_read = count($data_read);
    for($i = 0; $i < $count_read ; $i = isset($key_read)?$key_read:$i){
        if ($j == $count_read) {
            break;
        }
        if ($data_read[$i]['part_id'] == $data_read[$j]['part_id']) {
            array_push($data_read[$i]['topic'], $data_read[$j]['topic'][0]);
            unset($data_read[$j]);
            
        }else{
            $key_read = $j; 
        }
        $j++;
    }

    //gom topic
    foreach($data_read as $key => $data_read_s){

        $l = 0;
        $count_topic_read = count($data_read[$key]['topic']);
        for($j = 1; $j < $count_topic_read ; $j++){

            if ($data_read[$key]['topic'][$l]['topic_id'] == $data_read[$key]['topic'][$j]['topic_id']) {
                array_push($data_read[$key]['topic'][$l]['questions'], $data_read[$key]['topic'][$j]['questions'][0]);
                unset($data_read[$key]['topic'][$j]);
            }else{
                $l = $j;
            }
        }
    }

    // =================================WRITTING=================================

    //gom part 
    $j = 1;
    $count_write = count($data_write);
    for($i = 0; $i < $count_write ; $i = isset($key_write)?$key_write:$i){
        if ($j == $count_write) {
            break;
        }
        if ($data_write[$i]['part_id'] == $data_write[$j]['part_id']) {
            array_push($data_write[$i]['topic'], $data_write[$j]['topic'][0]);
            unset($data_write[$j]);
            
        }else{
            $key_write = $j; 
        }
        $j++;
    }

    //gom topic
    foreach($data_write as $key => $data_write_s){

        $l = 0;
        $count_topic_write = count($data_write[$key]['topic']);
        for($j = 1; $j < $count_topic_write ; $j++){

            if ($data_write[$key]['topic'][$l]['topic_id'] == $data_write[$key]['topic'][$j]['topic_id']) {
                array_push($data_write[$key]['topic'][$l]['questions'], $data_write[$key]['topic'][$j]['questions'][0]);
                unset($data_write[$key]['topic'][$j]);
            }else{
                $l = $j;
            }
        }
    }

    // =================================SPEAKING=================================

    //gom part 
    $j = 1;
    $count_speak = count($data_speak);
    for($i = 0; $i < $count_speak ; $i = isset($key_speak)?$key_speak:$i){
        if ($j == $count_speak) {
            break;
        }
        if ($data_speak[$i]['part_id'] == $data_speak[$j]['part_id']) {
            array_push($data_speak[$i]['topic'], $data_speak[$j]['topic'][0]);
            unset($data_speak[$j]);
            
        }else{
            $key_speak = $j; 
        }
        $j++;
    }

    //gom topic
    foreach($data_speak as $key => $data_speak_s){

        $l = 0;
        $count_topic_speak = count($data_speak[$key]['topic']);
        for($j = 1; $j < $count_topic_speak ; $j++){

            if ($data_speak[$key]['topic'][$l]['topic_id'] == $data_speak[$key]['topic'][$j]['topic_id']) {
                array_push($data_speak[$key]['topic'][$l]['questions'], $data_speak[$key]['topic'][$j]['questions'][0]);
                unset($data_speak[$key]['topic'][$j]);
            }else{
                $l = $j;
            }
        }
    }

    $data['Listening']  = $data_listen;
    $data['Reading']    = $data_read;
    $data['Writting']   = $data_write;
    $data['Speaking']   = $data_speak;
    
    $lesson_id = $lesson_id;
    return View('pages.lesson_sample.show_lesson_sample',compact('data','lesson_id'));

}

public function list_test(){
    $no = 0;
    $data = [];
    $results = Result::whereNotIn('fee', [0])->where('submit',1)->whereNull('total_mark')->orderbyDESC('created_at')->get();

    foreach($results as $result){

        $lesson_content_id = Result::find($result->result_id)->lesson_content()->first()->lesson_content_id;
        $lesson = LessonContent::find($lesson_content_id)->lessons;
        $lesson_status = Lesson::find($lesson->lesson_id)->lesson_status;
        $filter_status = FilterStructure::find($lesson->filter_id)->filter_status;
        
        $filter_name = 'Undefined';

        if ($filter_status == 0) {
            $filter_name = 'User';
        }else if($filter_status == 1 && $lesson_status == 0){

            $filter_name = 'Standard';
            
        }else if($filter_status == 3 && $lesson_status == 0){
            $filter_name = 'Beginner';
        }

        else if($filter_status == 2 && $lesson_status == 1) {
            $filter_name = 'Sample';
        }
        else if($lesson_status == 2){
            $filter_name = 'Route';
        }

        $data[] = 
        [
            'no'        =>  ++$no,
            'result_id' =>  $result->result_id,
            'student'   =>  Student::find($result->student_id)->student_name,
            'type'      =>  $filter_name,
            'time'      =>  date_format($result->created_at, "d/m/Y H:i:s"),
        ];

    }
    
    if (!session()->has('id_gv')) {
        return back();
    }
    
    //phúc kháo
    $remark = [];
    $data_remark = Result::where('result_status', 1)->whereTeacherId(session()->get('id_gv'))->orderByDESC('updated_at')->get();

    foreach($data_remark as $fetch_remark){

        $lesson_content_id = Result::find($fetch_remark->result_id)->lesson_content()->first()->lesson_content_id;
        $lesson = LessonContent::find($lesson_content_id)->lessons;
        $lesson_status = Lesson::find($lesson->lesson_id)->lesson_status;
        $filter_status = FilterStructure::find($lesson->filter_id)->filter_status;
        
        if ($filter_status == 0) {
            $filter_name = 'User';
        }else if($filter_status == 1){

            if ($lesson_status == 0) {
                $filter_name = 'Standard';
            }else if($lesson_status == 1){
                $filter_name = 'Sample';
            }
            
        }

        $remark[] = 
            [
                'no'        =>  ++$no,
                'result_id' =>  $fetch_remark->result_id,
                'type'      =>  $filter_name,
                'student'   =>  Student::find($fetch_remark->student_id)->student_name,
                'time'      =>  date_format($fetch_remark->created_at, "d/m/Y H:i:s"),
            ];
    }

    return View('pages.teacher.list_test', compact('data','remark'));
}

public function show_test($result_id){

    if (!session()->has('id_gv')) {
        return back();
    }

    $data = array();
    $data_write = array();
    $data_speak = array();
    $result = Result::find($result_id);
    $lesson_contents = $result->lesson_content;
    foreach($lesson_contents as $lesson_cont){
        $lesson_id = $lesson_cont->lesson_id;
        $question = Question::find($lesson_cont->question_id);
        $topic = Topic::find($question->topic_id);
        $part = $topic->parts;
        $skill = Part::find($part->part_id)->skills->skill_name;
        if ($skill == 'Writting') {
            array_push($data_write, 
                [
                    'part_id'       =>    $part->part_id,
                    'part_name'     =>    $part->part_name,
                    'part_des'      =>    isset($part->part_des) ?  $part->part_des : null,
                    'topic'         =>    [[
                        'topic_id'        =>  $topic->topic_id,
                        'topic_name'      =>  $topic->topic_name,
                        'topic_content'   =>  $topic->topic_content,
                        'topic_image'     =>  $topic->topic_image,
                        'questions'       =>  [[
                            'question_id'       =>   $question->question_id,
                            'question_content'  =>   $question->question_content,
                            'question_mark'     =>   $question->question_mark,
                            'ans_task'          =>   $lesson_cont->pivot->ans_task,
                            'mark'              =>   $lesson_cont->pivot->mark !== null ? $lesson_cont->pivot->mark : null,
                            'note'              =>   $lesson_cont->pivot->note !== null ? $lesson_cont->pivot->note : null,
                        ]],
                    ]],  
                ]
            );
        }
        //nếu kỹ năng đọc
        else if ($skill == 'Speaking') {
            array_push($data_speak, 
                [
                    'part_id'       =>    $part->part_id,
                    'part_name'     =>    $part->part_name,
                    'part_des'      =>    isset($part->part_des) ?  $part->part_des : null,
                    'topic'         =>    [[
                        'topic_id'          =>  $topic->topic_id,
                        'topic_name'        =>  $topic->topic_name,
                        'topic_content'     =>  $topic->topic_content,
                        'topic_image'       =>  $topic->topic_image,
                        'questions'         =>  [[
                            'question_id'       =>   $question->question_id,
                            'question_content'  =>   $question->question_content,
                            'question_mark'     =>   $question->question_mark,
                            'ans_task'          =>   $lesson_cont->pivot->ans_task,
                            'mark'              =>   $lesson_cont->pivot->mark !== null ? $lesson_cont->pivot->mark : null,
                            'note'              =>   $lesson_cont->pivot->note !== null ? $lesson_cont->pivot->note : null,
                        ]],
                    ]],  
                ]
            );
        }
    }
    // =================================WRITTING=================================

    //gom part 
    $j = 1;
    $count_write = count($data_write);
    for($i = 0; $i < $count_write ; $i = isset($key_write)?$key_write:$i){
        if ($j == $count_write) {
            break;
        }
        if ($data_write[$i]['part_id'] == $data_write[$j]['part_id']) {
            array_push($data_write[$i]['topic'], $data_write[$j]['topic'][0]);
            unset($data_write[$j]);
            
        }else{
            $key_write = $j; 
        }
        $j++;
    }

    //gom topic
    foreach($data_write as $key => $data_write_s){

        $l = 0;
        $count_topic_write = count($data_write[$key]['topic']);
        for($j = 1; $j < $count_topic_write ; $j++){

            if ($data_write[$key]['topic'][$l]['topic_id'] == $data_write[$key]['topic'][$j]['topic_id']) {
                array_push($data_write[$key]['topic'][$l]['questions'], $data_write[$key]['topic'][$j]['questions'][0]);
                unset($data_write[$key]['topic'][$j]);
            }else{
                $l = $j;
            }
        }
    }

    // =================================SPEAKING=================================

    //gom part 
    $j = 1;
    $count_speak = count($data_speak);
    for($i = 0; $i < $count_speak ; $i = isset($key_speak)?$key_speak:$i){
        if ($j == $count_speak) {
            break;
        }
        if ($data_speak[$i]['part_id'] == $data_speak[$j]['part_id']) {
            array_push($data_speak[$i]['topic'], $data_speak[$j]['topic'][0]);
            unset($data_speak[$j]);
            
        }else{
            $key_speak = $j; 
        }
        $j++;
    }

    //gom topic
    foreach($data_speak as $key => $data_speak_s){

        $l = 0;
        $count_topic_speak = count($data_speak[$key]['topic']);
        for($j = 1; $j < $count_topic_speak ; $j++){

            if ($data_speak[$key]['topic'][$l]['topic_id'] == $data_speak[$key]['topic'][$j]['topic_id']) {
                array_push($data_speak[$key]['topic'][$l]['questions'], $data_speak[$key]['topic'][$j]['questions'][0]);
                unset($data_speak[$key]['topic'][$j]);
            }else{
                $l = $j;
            }
        }
    }

    $data['Writting']   = $data_write;
    $data['Speaking']   = $data_speak;
    
    $result_id = $result_id;
    return View('pages.teacher.show_test', compact('data','result_id','lesson_id'));

}

public function remark($result_id){
    $result = Result::find($result_id);
    $result->result_status = 1;
    $result->save();

    return back()->with('success', 'Your request was sent!');
}


public function update_mark(Request $request ,$result_id){

    $result = Result::find($result_id);
    $lesson = Lesson::find($request->lesson_id);

    //nếu bài đã được chấm điểm
    if ($result->total_mark !== null) {
        return redirect('/list-test')->with('error','Lesson was graded by other teacher !');
    }

    foreach($request->question as $question){
        $a = LessonContent::where('lesson_id', $request->lesson_id)->where('question_id', $question)->first();

        $result->lesson_content()->updateExistingPivot($a->lesson_content_id, 
            [
                'mark' => round($request->input('mark_'.$question), 2), 
                'note' => $request->input('note_'.$question),
            ]
        );
    }

    $s = 0;
    $re_less = $result->lesson_content;
    foreach ($re_less as $key => $res) {
        $s += $res->pivot->mark;
    }

    if (Result::find($result_id)->result_status == 1) {
        $result->result_status = 2;
    }

    $result->teacher_id = session()->get('id_gv');
    $result->total_mark = $s;
    $result->save();

    //send mail

    $student = Student::find($result->student_id);
    $student_email = $student->student_email;
    $student_name = $student->student_name;

    
    $date = date('d/m/Y', strtotime(Result::find($result_id)->created_at));
    
    $data = [
        'student'     => $student_name,
        'date'        => $date,
        'total'       => $s,
        'result_id'   => $result_id,
    ];
    
    Mail::to($student_email)->send(new SendMail($data));

    return redirect('/list-test')->with('success', 'Updated Mark Successfully!');
}


public function contact(){
    return View('pages.contact.contact');
}

public function contact_control(Request $request){
    $validator = Validator::make($request->all(),[
        'email' => 'required',
        'name'  => 'required',
        'comments' => 'required',
    ],
    [
        'email.required'    =>  'Email is empty!',
        'name.required'     =>  'Name is empty!',
        'comments.required' =>  'Comment is empty!',
    ]
);
    if ($validator->fails()) {
        return response()->json(['status' => 0,'fail' => $validator->errors()->toArray()]);
    }else{
        $data = [
            'email'     =>      $request->email,
            'name'      =>      $request->name,
            'comments'  =>      $request->comments,
        ];

        Mail::to('testemailwebclothing@gmail.com')->send(new contactMail($data));
    }
    return response()->json(['status' => 1, 'success' => 'Thanks for feedback!']);
}

public function study_route()
    {
        $student_id = Session::get('student_id');
        $filters = FilterStructure::whereFilterStatus(3)->get();
        $finished =[];
        foreach ($filters as $key => $filter) {
            $lessons = Lesson::where('filter_id',$filter->filter_id)->get()->toArray();
            foreach($lessons as $key_lesson => $lesson){
                $lesson_cont_id = LessonContent::where('lesson_id',$lesson['lesson_id'])->first('lesson_content_id');
                $finished = LessonContent::find($lesson_cont_id['lesson_content_id'])->results()->where('student_id',$student_id)->get()->toArray();
                if(count($finished)>0){break;}
            }
        }
        
        $ques_mark_max =0.0;
        if($filters = []){
            return redirect('/home')->with('nodata', 'No Data. Please again!');
        }
        elseif( $finished != [])
        {
            foreach ($finished as $key => $finish) {
                $route_id = $finish['route_id'];
                $result_total_mark = $finish['total_mark'];
                $lessons = Result::find($finish['result_id'])->lesson_content()->get()->toArray();
                foreach ($lessons as $key => $lesson) {
                    $arr_ques_marks = Question::where('question_id',$lesson['question_id'])->get('question_mark')->toArray();
                    foreach ($arr_ques_marks as $key => $arr_ques_mark) {
                        $ques_mark_max += $arr_ques_mark['question_mark'];
                    }
                }
            }
            $GPA = round((($result_total_mark*10)/$ques_mark_max),2);
            $percent = 1;
            if($GPA >= 7.0  && $GPA <= 9.0){
                $percent = 20;
            }elseif($GPA > 9.0  && $GPA <=10.0){
                $percent = 30;
            }
            $list_routes = Route::all();
            $detail_routes = DetailRoute::whereRouteId($route_id)->orderBy('detail_route_level')->get()->toArray();

            $data_detail_routes = array();
            $list_skill = Skill::whereIn('skill_name', ['Writting','Speaking'])->get('skill_id')->toArray();

            foreach ($detail_routes as $key => $detail_route) {
                $filter = FilterStructure::Find($detail_route['filter_id']);
                $filter_skills = $filter->parts()->whereIn('skill_id',$list_skill);
                $skill_names = [];
                $skill_name_tmp = '';
                foreach ($filter_skills->get(['skill_id']) as $key => $filter_skill) {
                    $skill_name = Skill::find($filter_skill['skill_id'])->skill_name;
                    if($skill_name_tmp != $skill_name){
                        $skill_names[] =  $skill_name;
                        $skill_name_tmp = $skill_name;
                    }
                }
                $lessons_routes = $filter->lessons()->where('lesson_status', 2)->get();
                $result_route_tests = [];
                $result_total_mark = 0;
                $list_results = [];
                foreach($lessons_routes as $key_lesson => $lessons_route){
                    $lesson_cont = LessonContent::where('lesson_id',$lessons_route->lesson_id)->first('lesson_content_id');
                    $result_route_tests[] = LessonContent::find($lesson_cont['lesson_content_id'])->results()->where([['student_id',$student_id],['route_id',$route_id]])->get()->toArray();
                    // dd($result_route_tests);
                    foreach ($result_route_tests as $result_route_test ) {
                        // dd($result_route_test);
                        foreach ($result_route_test as $k => $v) {
                            // dd($v['total_mark']);
                             $GPA =null;
                            if( $v['total_mark'] > $result_total_mark)
                            {
                                //dd($result_total_mark);
                                $result_total_mark = $v['total_mark'];
                            }
                            if( $v['total_mark']!==null )
                            {
                                $GPA = 1;
                                $result_total =$v['total_mark'];
                            }
                            $ques_mark_max =0.0;
                            $arr_ques_marks = Lesson::find($lessons_route->lesson_id)->questions()->get()->toArray();
                            foreach ($arr_ques_marks as $key => $arr_ques_mark) {
                                $ques_mark_max += $arr_ques_mark['question_mark'];
                            }
                           
                            if($GPA != null){
                                $GPA = round((($result_total*10)/$ques_mark_max),2) ;
                                $GPA =($GPA > 10.0) ? floor($GPA) : $GPA;
                            }
                            $v['total_mark'] = $GPA;
                            
                            if($list_results == []){
                                array_push($list_results,$v);
                            }
                            elseif($v != []  ){
                                $index =0;
                                foreach ($list_results as $k_list => $list_result) {
                                    $index++;
                                    if($list_result['result_id'] == $v['result_id'] ){
                                        break;
                                    }elseif($index == count($list_results)){
                                        array_push($list_results,$v);
                                    }
                                }
                            }
                        }
                    };
                    $ques_mark_max_route =0.0;
                    $arr_ques_mark_routes = Lesson::find($lessons_route['lesson_id'])->questions()->get()->toArray();
                    
                    foreach ($arr_ques_mark_routes as $key => $arr_ques_mark_route) {
                        $ques_mark_max_route += $arr_ques_mark_route['question_mark'];
                    }
                }
                // dd(array_reverse($result_route_tests),$list_results);
                $GPA_route =($result_route_tests != [])? round((($result_total_mark*10)/$ques_mark_max_route),2) : 0;
                array_push($data_detail_routes,
                    [
                        'filter_id'             => $detail_route['filter_id'],
                        'route_id'              => $detail_route['route_id'],
                        'skill_name'            => $skill_names,
                        'detail_route_level'    => $detail_route['detail_route_level'],
                        'GPA_route'             => $GPA_route,
                        'list_results'          => array_reverse($list_results)
                    ]
                );
            

            }

            $count_level_route = count($detail_routes);
            $level_route = floor(($percent*$count_level_route)/100);
            return view('pages.Study_route.study_route')
                    ->with('list_routes',$list_routes)
                    ->with('finished',$finished)
                    ->with('data_detail_routes',$data_detail_routes)
                    ->with('level_route',$level_route);
        }
        // elseif(empty($finished) ){
            
        //     return redirect('/home')->with('nodata', 'No Data. Please again!');
               
        // }
        else{
            $list_routes = Route::all();
            return view('pages.Study_route.study_route')
                ->with('list_routes',$list_routes)
                ->with('finished',$finished);
        }

        
    }
    public function input_route()
    {
        $fee = 0;
        $student_id = Session::get('student_id');
        $filters = FilterStructure::whereFilterStatus(3)->get();
        foreach ($filters as $key => $filter) {
            $lessons = Lesson::where('filter_id',$filter->filter_id)->get()->toArray();
            
            foreach($lessons as $key_lesson => $lesson){
                $lesson_cont_id = LessonContent::where('lesson_id',$lesson['lesson_id'])->first('lesson_content_id');
                $finished = LessonContent::find($lesson_cont_id['lesson_content_id'])->results()->where('student_id',$student_id)->get()->toArray();
                if(count($finished)){break;}
            }
        }
        if(isset($finished) && count($finished) > 0){
            return Redirect('/study-route');
        }
        $filter_input_test = FilterStructure::where('filter_status',3)->get('filter_id')->first();
        if($filter_input_test == null){
            return redirect('/home')->with('nodata', 'No Data. Please again!');
            
        }else{
            $filter_part = $filter_input_test->parts;
        
            foreach($filter_part as $part){
                $skill[] = Part::find($part->part_id)->skills->skill_name;
            }
            $unique = array_unique($skill);

            foreach ($unique as $skill_uni) {
                if ($skill_uni == 'Writting' || $skill_uni == 'Speaking') {
                    ++$fee;
                }
            }

            return view('pages.Study_route.input_test',compact('fee'))
            ->with('filter_input_test',$filter_input_test);
        }
        
    }
    public function start_route($route_id)
    {
        $student_id = Session::get('student_id');
        $filters = FilterStructure::whereFilterStatus(3)->get();
        foreach ($filters as $key => $filter) {
            $lessons = Lesson::where('filter_id',$filter->filter_id)->get()->toArray();
            foreach($lessons as $key_lesson => $lesson){
                $lesson_cont_id = LessonContent::where('lesson_id',$lesson['lesson_id'])->first('lesson_content_id');
                $finished = LessonContent::find($lesson_cont_id['lesson_content_id'])->results()->whereStudentId($student_id)->get()->toArray();
                if(count($finished)){break;}
            }
        }
        $ques_mark_max =0.0;
        $result_total_mark =1;
        foreach ($finished as $key => $finish) {
            $result_total_mark = $finish['total_mark'];
            $lessons = Result::find($finish['result_id'])->lesson_content()->get()->toArray();

            $update_re = Result::find($finish['result_id']);
            $update_re['route_id'] = $route_id;
            $update_re->save();

            foreach ($lessons as $key => $lesson) {

                $arr_ques_marks = Question::where('question_id',$lesson['question_id'])->get('question_mark')->toArray();
                foreach ($arr_ques_marks as $key => $arr_ques_mark) {
                    $ques_mark_max += $arr_ques_mark['question_mark'];
                }
            }
        }
        $GPA = round((($result_total_mark*10)/$ques_mark_max),2);
        $percent = 1;
        if($GPA >= 7.0  && $GPA <= 9.0){
            $percent = 20;
        }elseif($GPA > 9.0  && $GPA <=10.0){
            $percent = 30;
        }
        foreach ($filters as $key => $filter) {
            $lessons = Lesson::where('filter_id',$filter->filter_id)->get()->toArray();
            foreach($lessons as $key_lesson => $lesson){
                $lesson_cont_id = LessonContent::where('lesson_id',$lesson['lesson_id'])->first('lesson_content_id');
                $finished = LessonContent::find($lesson_cont_id['lesson_content_id'])->results()->whereStudentId($student_id)->get()->toArray();
                if(count($finished)){break;}
            }
        }
  
        $list_routes = Route::all();
        $detail_routes = DetailRoute::whereRouteId($route_id)->orderBy('detail_route_level')->get()->toArray();

        $data_detail_routes = array();
        $list_skill = Skill::whereIn('skill_name', ['Writting','Speaking'])->get('skill_id')->toArray();

        foreach ($detail_routes as $key => $detail_route) {
            $filter = FilterStructure::Find($detail_route['filter_id']);
            $filter_skills = $filter->parts()->whereIn('skill_id',$list_skill);
            $skill_names = [];
            $skill_name_tmp = '';
            foreach ($filter_skills->get(['skill_id']) as $key => $filter_skill) {
                $skill_name = Skill::find($filter_skill['skill_id'])->skill_name;
                if($skill_name_tmp != $skill_name){
                    $skill_names[] =  $skill_name;
                    $skill_name_tmp = $skill_name;
                }
            }
            $lessons_routes = $filter->lessons()->where('lesson_status', 2)->get();
            $result_route_tests = [];
            $result_total_mark = 0;
            $list_results = [];
            foreach($lessons_routes as $key_lesson => $lessons_route){
                $lesson_cont = LessonContent::where('lesson_id',$lessons_route->lesson_id)->first('lesson_content_id');
                $result_route_tests[] = LessonContent::find($lesson_cont['lesson_content_id'])->results()->where([['student_id',$student_id],['route_id',$route_id]])->get()->toArray();
                // dd($result_route_tests);
                foreach ($result_route_tests as $key => $result_route_test) {
                    // dd($result_route_test);
                    foreach ($result_route_test as $k => $v) {
                        // dd($v['total_mark']);
                        $GPA =null;
                        if( $v['total_mark'] > $result_total_mark)
                        {
                            //dd($result_total_mark);
                            $result_total_mark = $v['total_mark'];
                        }
                         
                        if( $v['total_mark']!==null )
                        {
                            $GPA = 1;
                            $result_total =$v['total_mark'];
                        }
                        $ques_mark_max =0.0;
                        $arr_ques_marks = Lesson::find($lessons_route->lesson_id)->questions()->get()->toArray();
                        foreach ($arr_ques_marks as $key => $arr_ques_mark) {
                            $ques_mark_max += $arr_ques_mark['question_mark'];
                        }
                       
                        if($GPA != null){
                            $GPA = round((($result_total*10)/$ques_mark_max),2) ;
                            $GPA =($GPA > 10.0) ? floor($GPA) : $GPA;
                        }
                        $v['total_mark'] = $GPA;
                    
                        if($list_results == []){
                            array_push($list_results,$v);
                        }
                        elseif($v != []  ){
                            $index =0;
                            foreach ($list_results as $k_list => $list_result) {
                                $index++;
                                if($list_result['result_id'] == $v['result_id'] ){
                                    break;
                                }elseif($index == count($list_results)){
                                    array_push($list_results,$v);
                                }
                            }
                        }
                    }
                };
                $ques_mark_max_route =0.0;
                $arr_ques_mark_routes = Lesson::find($lessons_route['lesson_id'])->questions()->get()->toArray();
                
                foreach ($arr_ques_mark_routes as $key => $arr_ques_mark_route) {
                    $ques_mark_max_route += $arr_ques_mark_route['question_mark'];
                }
            }
            // dd($result_route_tests);
            $GPA_route =($result_route_tests != [])? round((($result_total_mark*10)/$ques_mark_max_route),2) : 0;
            array_push($data_detail_routes,
                [
                    'filter_id'             => $detail_route['filter_id'],
                    'route_id'              => $detail_route['route_id'],
                    'skill_name'            => $skill_names,
                    'detail_route_level'    => $detail_route['detail_route_level'],
                    'GPA_route'             => $GPA_route,
                    'list_results'          => $list_results
                ]
            );

        }


        $count_level_route = count($detail_routes);
        $level_route = floor(($percent*$count_level_route)/100);
        //dd($ques_mark_max,$GPA,$percent);
        
        return View('pages.study_route.study_route')
                ->with('list_routes',$list_routes)
                ->with('finished',$finished)
                ->with('data_detail_routes',$data_detail_routes)
                ->with('level_route',$level_route);
                
    }
}   
?>
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Student;
use App\Models\Skill;
use App\Models\Part;
use App\Models\Topic;
use App\Models\Question;
use App\Models\Role;
use App\Models\Staff;
use App\Models\Lesson;
use App\Models\Result;
use App\Models\LessonContent;
use App\Models\FilterStructure;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(){
        $data = array();
        $staffs = Staff::all();
        foreach($staffs as $key => $staff){
            array_push($data,['staff_id'=>$staff->staff_id, 'staff_name'=>$staff->staff_name]);
            $roles = Staff::find($staff->staff_id)->roles;
            foreach($roles as $role){
                array_push($data[$key], ['role_id'=>$role->role_id, 'role_name'=>$role->role_name]);
            }
        }
        
        return View('admin.staff.staff',compact('data'));
    }

    public function dashboard()
    {
        //report
        $report = array( 
            'student'           =>      Student::all()->count(),
            'results'           =>      Result::all()->count(),
            'result_not_mark'   =>      Result::whereNull('total_mark')->count(), 
            'structure'         =>      FilterStructure::all()->count(),
            'money'             =>      Result::sum('fee'),
        );
        
        //structure
        $filters = FilterStructure::whereNotIn('filter_status',[0,-1])->get();
        foreach($filters as $filter){
            $res = array();
            $lessons = FilterStructure::find($filter->filter_id)->lessons;

            foreach($lessons as $lesson){

                if (LessonContent::whereLessonId($lesson->lesson_id)->count() > 0) {
                    
                    $lesson_cont = LessonContent::whereLessonId($lesson->lesson_id)->first()->toArray();
                    $results = LessonContent::find($lesson_cont['lesson_content_id'])->results->count();
                    
                    if (LessonContent::find($lesson_cont['lesson_content_id'])->lessons->lesson_status == 0 && $filter->filter_status == 1) {

                        $result_standard = LessonContent::find($lesson_cont['lesson_content_id'])->results()->whereNotNull('total_mark');

                        if ($result_standard->count() > 0) {
                            $array_result_standard[] = $result_standard->get(); 
                        }   
                    }

                    array_push($res, $results);

                }
            }
            
            if (isset($res)) {
                $s = array_sum($res);
            }
            
            $like_struc[] = array(
                'total'         =>      isset($s) ? $s : null,
                'filter_id'     =>      $filter->filter_id,
                'filter_name'   =>      $filter->filter_name,
            );
        }

        if(isset($like_struc) && (count($like_struc) > 0)){
            
            array_splice($like_struc, 5);
            rsort($like_struc);
            
        }
        
        //xử lý xếp hạng điểm
        if(isset($array_result_standard)){
            $f = 0;
            $b1 = 0;
            $b2 = 0;
            $c1 = 0;

            foreach($array_result_standard as $result_stand){

                $dtb = round(($result_stand[0]->total_mark / 4), 1);
                //lọc điểm
                if($dtb < 4){
                    ++$f;
                }else if($dtb >= 4 && $dtb <6){
                    ++$b1;
                }else if($dtb >=6 && $dtb <8.5){
                    ++$b2;
                }else if($dtb >=8.5 && $dtb <10){
                    ++$c1;
                }
            }


        //tong ket ket qua 
            $rank = 
            [
                'No Rank'     =>      $f,
                'B1'          =>      $b1,
                'B2'          =>      $b2,
                'C1'          =>      $c1,
            ]; 

            foreach($rank as $key_rank => $xh){
                $kq[] = 
                [
                    'value'     =>      round(($xh / count($array_result_standard)) * 100, 1),
                    'label'     =>      $key_rank,
                    'formatted' =>      round(($xh / count($array_result_standard)) * 100, 1).'%',
                ];
            }
           
        }
        //data
        $skills = Skill::all();
        foreach($skills as $key => $skill){
            $parts = Skill::find($skill->skill_id)->parts()->orderBy('part_no')->get();
            $count_part = count($parts);
            $data_skill[] = 
            [
                'skill_name'   =>      $skill->skill_name,
                'count_part'   =>      $count_part,
            ];
            foreach($parts as $part){
                $topics = Part::find($part->part_id)->topics;
                $count_ques = 0;
                foreach($topics as $topic){
                    $questions = Topic::find($topic->topic_id)->questions->count();
                    $count_ques += $questions;
                }
                $data_part[] = 
                [
                    'part_name'     =>      $part->part_name,
                    'topics'        =>      count($topics),
                    'questions'     =>      $count_ques,
                ];         
            }
        }
       
        return View('admin.layout.dashboard',compact(isset($like_struc)?'like_struc':null,isset($data_skill)?'data_skill':null,isset($data_part)?'data_part':null,isset($report)?'report':null, isset($kq)?'kq':null));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(){
        $roles = Role::whereNotIn('role_name',['Admin'])->get();
        return View('admin.staff.add_staff',compact('roles'));
    }

    public function login()
    {
        if (Auth::id()) {
            return redirect('/admin/dashboard');
        }
        return View('admin.layout.login');
    }

    public function login_control(Request $request){
        if (Auth::attempt(['staff_email'=> $request->staff_email, 'staff_password'=> $request->staff_password])) {
            $roles = Staff::find(Auth::id())->roles;
            foreach($roles as $role){
                //nếu chỉ là giáo viên
                if (($role->role_name == 'Teacher') && count($roles) < 2) {
                    Auth::logout();
                    return back()->with('err', 'You dont have permission login here! Please can you contact with admin');
                }
            }
            return redirect('/admin/dashboard');
        }else{
            return redirect('/admin')->with('err', 'Email or Password incorrect!');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/admin');
    }


    public function imper_staff($id){
        session()->put('imper', $id);
        return redirect('/admin/dashboard');
    }

    public function stop_imper(){
        session()->forget('imper');
        return redirect('/admin/staff');
    }


    public function profile($id){
        $staff = Staff::find($id);
        $roles = $staff->roles;
        return View('admin.profile.profile',compact('staff','roles'));
    }

    public function change_password($id){
        $staff = Staff::find($id);
        return View('admin.profile.change_password', compact('staff'));
    }

    public function change_password_control(Request $request, $id){
        $err = array();
        $staff = Staff::find($id);
        $validator = Validator::make($request->all(),
            [
                'old_password'=>'required',
                'new_password'=>'required',
                'confirm_password'=>'required',
            ],
            [
                'old_password.required'=>'Password is empty!',
                'new_password.required'=>'New Password is empty!',
                'confirm_password.required'=>'Confirm Password is empty!',
            ]
        );
        if ($validator->fails()) {
            array_push($err, $validator->errors()->toArray());
        }

        //nếu khớp mật khẩu hiện tại
        if ($staff->staff_password != md5($request->old_password)) {
            array_push($err, 'Password incorrect!');
        }else{
            if (md5($request->new_password) != md5($request->confirm_password)) {
                array_push($err, 'New Password or Confirm Password not match!');
            }
        }

        if (count($err) > 0) {

            return redirect()->back()->with('err', $err);
        }

        $staff->staff_password = md5($request->new_password);
        $staff->save();
        return redirect('/admin/profile/'.$id)->with('success', 'Change Password Successfully!');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $err = array();
        $staffs = Staff::all();
        $validator = Validator::make($request->all(),
            [
                'staff_name'=>'required',
                'staff_email'=>'required|email',
                'staff_password'=>'required',
                'staff_role'=>'required',        
            ],
            [
                'staff_name.required'=>'Name is empty!',
                'staff_email.required'=>'Email is empty!',
                'staff_email.email'=>'Format Email incorrect!',
                'staff_password.required'=>'Password is empty!',
                'staff_role.required'=>'Role is empty!',
            ]
        );
        if ($validator->fails()) {
            array_push($err,$validator->errors()->toArray());
        }

        //kiểm tra trùng email
        foreach($staffs as $staff){
            if ($staff->staff_email == $request->staff_email) {
                array_push($err, 'Email already exists!');
            }
        }

        if (count($err) > 0) {
            return redirect()->back()->with('err', $err);
        }

        $staff_new = new Staff;
        $staff_new->staff_name = $request->staff_name;
        $staff_new->staff_email = $request->staff_email;
        $staff_new->staff_password = md5($request->staff_password);
        $staff_new->save();
        $staff_role = Staff::find($staff_new->staff_id);

        $staff_role->roles()->attach($request->staff_role);
        return redirect()->back()->with('success', 'Added Staff Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = array();
        $staff = Staff::find($id);
        $roles = $staff->roles;
        $data['staff_name'] = $staff->staff_name;
        $data['staff_email'] = $staff->staff_email;
        foreach($roles as $role){
            array_push($data, ['role_name' => $role->role_name]);
        }
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role_tmp = array();
        $data = array();
        $staff = Staff::find($id);
        $user_role = $staff->roles;
        foreach($user_role as $user){
            array_push($role_tmp, $user->role_id);
        }
        $roles = Role::whereNotIn('role_name',['Admin'])->get();
        foreach($roles as $role){
            if (in_array($role->role_id, $role_tmp)) {
                array_push($data, ['role_id'=>$role->role_id, 'role_name'=>$role->role_name, 'role_chose'=>1]);
            }else{
                array_push($data, ['role_id'=>$role->role_id, 'role_name'=>$role->role_name, 'role_chose'=>0]);
            }
        }
        
        return View('admin.staff.update_staff',compact('data','staff'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $err = array();
        $staffs = Staff::all();
        $staff = Staff::find($id);
        $validator = Validator::make($request->all(),[
            'staff_name'=>'required',
            'staff_email'=>'required|email',
        ],
        [
            'staff_name.required'=>'Name is empty!',
            'staff_email.required'=>'Email is empty!',
            'staff_email.email'=>'Format Email incorrect!',
        ]
    );
        if ($validator->fails()) {
            array_push($err, $validator->errors()->toArray());
        }

        if (isset($request->change_pass)) {
            $validate = Validator::make($request->all(),[
                'staff_password'=>'required',
            ],
            [
                'staff_password.required'=>'Password is empty!',
            ]
        );
            if ($validate->fails()) {
                array_push($err, $validate->errors()->toArray());
            }
        }

        //kiểm tra trùng email
        if ($request->staff_email != $staff->staff_email) {
            foreach($staffs as $staff_all){
                if ($request->staff_email == $staff_all->staff_email) {
                    array_push($err, 'Email already exists!');
                }
            }
        }

        if (count($err) > 0) {
            return redirect()->back()->with('err' , $err);
        }

        $staff->staff_name = $request->staff_name;
        $staff->staff_email = $request->staff_email;
        $staff->staff_password = isset($request->staff_password)?$request->staff_password:$staff->staff_password;
        $staff->save();

        $staff->roles()->detach();

        if (isset($request->staff_role)) {
            $staff->roles()->attach($request->staff_role);
        }
        return redirect('/admin/staff')->with('success', 'Updated Staff Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $staff = Staff::find($id);
        $staff->roles()->detach();
        $staff->delete();
        return redirect()->back()->with('success', 'Deleted Staff Successfully!');
    }
}

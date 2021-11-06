<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Skill;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('admin.skill.skills')->with('skills', Skill::orderByDesc('skill_id')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('admin.skill.add_skill');
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
        $validator = Validator::make($request->all(),[
            'skill_name'=>'required|max:255',
        ],
        [
            'skill_name.max'=>'Skill name must not be greater than 255 characters.',
            'skill_name.required'=>'Please could you fill Name again!',
        ],
    );
        if ($validator->fails()) {
            $err[] = $validator->errors()->toArray();
        }

        // kiểm tra đủ 4 kỹ năng
        $check = Skill::whereIn('skill_name', ['Listening','Reading','Writting','Speaking'])->count();
        if ($check < 4) {
            if (($request->skill_name != 'Listening') && ($request->skill_name != 'Reading') && ($request->skill_name != 'Writting') && ($request->skill_name != 'Speaking')) {
                $err[] = 'Priority insert 4 skills basic: Listening, Reading, Writting, Speaking!';
            }
        }

        //kiểm tra trùng
        $skills = Skill::all();
        foreach($skills as $skills){
            if ($skills->skill_name == $request->skill_name) {
                $err[] = 'Skill already exists!';

            }
        }
        

        if (count($err) > 0) {
            return back()->with('error', $err)->withInput();
        }
        $skill = new Skill;
        $skill->skill_name = $request->skill_name;
        $skill->save();

        return redirect()->back()->with('success', 'Add Skill Successfully!'); 
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Skill::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return View('admin.skill.update_skill')->with('skills', Skill::find($id));
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
        $err = array();
        $validator = Validator::make($request->all(),[
            'skill_name'=>'required|max:255',
        ],
        [
            'skill_name.max'=>'Skill name must not be greater than 255 characters.',
            'skill_name.required'=>'Please could you fill Name again!',
        ]
    );

        if ($validator->fails()) {
            $err[] = $validator->errors()->toArray();
        }
        //kiểm tra trùng
        $skills = Skill::all();
        $skill = Skill::find($id);
        //nếu có thay đổi
        if ($skill->skill_name != $request->skill_name) {      
            foreach($skills as $skills){
                if ($skills->skill_name == $request->skill_name) {
                    $err[] = 'Skill already exists!';
                }
            }

            if(($skill->skill_name == 'Listening') || ($skill->skill_name == 'Reading') || ($skill->skill_name == 'Speaking') || ($skill->skill_name == 'Writting')){
                $err[] = $skill->skill_name.' is a skill default!';
            }
        }

        if (count($err) > 0) {
            return back()->with('error', $err);
        }

        $skill->skill_name = $request->skill_name;
        $skill->save();
        return redirect('/admin/skills')->with('success', 'Updated Skill Successfully!'); 
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $skill = Skill::find($id)->skill_name;
        if (($skill == 'Listening') || ($skill == 'Reading') || ($skill == 'Writting') || ($skill == 'Speaking')) {
            return back()->with('fail',$skill.' is a skill default!');
        }

        if (Skill::find($id)->parts()->count() == 0) {
            $delete = Skill::find($id)->delete();
            return redirect()->back()->with('success','Deleted Skill Successfully!');
        }
        return back()->with('fail', 'Deleted Skill Fail!');
    }
}

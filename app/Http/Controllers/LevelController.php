<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Level;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('admin.level.levels')->with('levels', Level::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('admin.level.add_level');
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
            'level_name'=>'required|max:255',
        ],
        [
            'level_name.max'=>'Level name must not be greater than 255 characters.',
            'level_name.required'=>'Please could you fill Name again!',
        ],
    );
        if ($validator->fails()) {
            $err[] = $validator->errors()->toArray();
        }
            //kiểm tra trùng
            $levels = Level::all();
            foreach($levels as $levels){
                if ($levels->level_name == $request->level_name) {
                    $err[] = 'Level already exists!';
                    
                }
            }

            if (count($err) > 0) {
                return back()->with('error', $err);
            }
            $level = new Level;
            $level->level_name = $request->level_name;
            $level->save();

            return redirect()->back()->with('success', 'Add Level Successfully!'); 
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Level::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return View('admin.level.update_level')->with('level', Level::find($id));
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
            'level_name'=>'required|max:255',
        ],
        [
            'level_name.max'=>'Level name must not be greater than 255 characters.',
            'level_name.required'=>'Please could you fill Name again!',
        ]
    );
        if ($validator->fails()) {
            $err[] = $validator->errors()->toArray();
        }
            //kiểm tra trùng
            $levels = Level::all();
            $level = Level::find($id);
            //nếu có thay đổi
            if ($level->level_name != $request->level_name) {      
                foreach($levels as $levels){
                    if ($levels->level_name == $request->level_name) {
                        $err[] = 'Level already exists!';
                        
                    }
                }
            }

            if(count($err) > 0){
                return back()->with('error', $err);
            }

            $level->level_name = $request->level_name;
            $level->save();
            return redirect('/admin/levels')->with('success', 'Updated Level Successfully!'); 
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Level::find($id)->topics()->count() == 0) {
            $delete = Level::find($id)->delete();
            return redirect()->back()->with('success','Deleted Level Successfully!');
        }
        return back()->with('fail', 'Deleted Level Fail!');
    }
}

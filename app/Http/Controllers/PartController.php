<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Skill;
use App\Models\Part;

class PartController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
     {
        $data_part = array();
        $parts = Part::orderByDesc('part_id')->get();
        foreach($parts as $part){
            $skill_name = Part::find($part->part_id)->skills->skill_name;
            $tempData['part_id'] = $part->part_id;
            $tempData['skill_name'] = $skill_name;
            $tempData['part_no'] = $part->part_no;
            $tempData['part_name'] = $part->part_name;
            $tempData['part_amount_ques_per_topic'] = $part->part_amount_ques_per_topic;
            array_push($data_part, $tempData);
        }
        // dd($data_part);
        return View('admin.part.parts')->with('parts', $data_part);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('admin.part.add_part')->with('skills', Skill::all());
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
            'skill_id'=>'required',
            'part_topic_max'=>'required',
            'part_name'=>'required|max:255',
            'part_no'=>'required',
            'part_amount_ques_per_topic'=>'required'
        ],
        [
            'part_name.max'=>'Part name must not be greater than 255 characters.',
            'skill_id.required'=>'Please could you chose Skill again!',
            'part_topic_max.required'=>'Please could you fill Topic Max again!',
            'part_name.required'=>'Please could you fill Name again!',
            'part_no.required'=>'Please could you chose Ordinal numbers again!',
            'part_amount_ques_per_topic.required'=>'Plase could you chose amount quesion in a topic!',
        ],
    );
        if ($validator->fails()) {
            $err[] = $validator->errors()->toArray();
        }
            //ki???m tra tr??ng
            $skill = Skill::find($request->skill_id)->skill_name;
            $parts = Part::all();
            foreach($parts as $parts){
                    //t???n t???i part + th??? t??? part trong k??? n??ng
                if (($parts->skill_id == $request->skill_id)&&($parts->part_name == $request->part_name)&&($parts->part_no == $request->part_no)) {
                    $err[] = 'Part & Ordinal numbers already exists in '.Part::find($parts->part_id)->skills->skill_name.' !';
                }
                    //t???n t???i part - ko t???n t???i th??? t??? part trong k??? n??ng
                elseif (($parts->skill_id == $request->skill_id)&&($parts->part_name == $request->part_name)&&($parts->part_no != $request->part_no)) {
                    $err[] = 'Part already exists in '.Part::find($parts->part_id)->skills->skill_name.' !';
                }
                    //ko t???n t???i part - t???n t???i th??? t??? part trong k??? n??ng
                elseif (($parts->skill_id == $request->skill_id)&&($parts->part_name != $request->part_name)&&($parts->part_no == $request->part_no)) {
                    $err[] = 'Ordinal numbers already exists in '.Part::find($parts->part_id)->skills->skill_name.' !';
                }
            }

            if(count($err) > 0){
                return back()->with('error', $err)->withInput();
            }

            $part = new Part;
            $part->skill_id = $request->skill_id;
            $part->part_name = $request->part_name;
            $part->part_no = $request->part_no;
            $part->part_topic_max = $request->part_topic_max;
            $part->part_des = isset($request->part_des)?$request->part_des:null;
            $part->part_amount_ques_per_topic = $request->part_amount_ques_per_topic;
            $part->save();

            return redirect()->back()->with('success', 'Add Part Successfully!'); 
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data_part = array();
        $part = Part::find($id);
        $skill_name = Part::find($id)->skills->skill_name;
        $tempData['part_id'] = $part->part_id;
        $tempData['skill_name'] = $skill_name;
        $tempData['part_name'] = $part->part_name;
        $tempData['part_topic_max'] = $part->part_topic_max;
        $tempData['part_no'] = $part->part_no;
        $tempData['part_des'] = isset($part->part_des)?$part->part_des:null;
        $tempData['part_amount_ques_per_topic'] = $part->part_amount_ques_per_topic;
        array_push($data_part, $tempData);
        return response()->json($data_part);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       return View('admin.part.update_part')->with('part', Part::find($id))->with('skills', Skill::all());
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
            'skill_id'=>'required',
            'part_topic_max'=>'required',
            'part_name'=>'required|max:255',
            'part_no'=>'required',
            'part_amount_ques_per_topic'=>'required'
        ],
        [
            'part_name.max'=>'Part name must not be greater than 255 characters.',
            'skill_id.required'=>'Please could you chose Skill again!',
            'part_topic_max.required'=>'Please could you fill Topic Max again!',
            'part_name.required'=>'Please could you fill Name again!',
            'part_no.required'=>'Please could you chose Ordinal numbers again!',
            'part_amount_ques_per_topic.required'=>'Plase could you chose amount quesion in a topic!',
        ],
    );
        if ($validator->fails()) {
            $err[] = $validator->errors()->toArray();
        }
            //ki???m tra tr??ng
            $parts = Part::all();
            
            foreach($parts as $parts){
                $part = Part::find($id);
                //n???u ?????i k??? n??ng - ?????i part - ?????i s??? th??? t??? part
                if (($part->skill_id != $request->skill_id)&&($part->part_name != $request->part_name)&&($part->part_no != $request->part_no)) {  
                    //t???n t???i part + th??? t??? part trong k??? n??ng
                    if (($parts->skill_id == $request->skill_id)&&($parts->part_name == $request->part_name)&&($parts->part_no == $request->part_no)) {
                        $err[] = 'Part & Ordinal numbers already exists in '.Part::find($parts->part_id)->skills->skill_name.' !';
                    }
                    //t???n t???i part - ko t???n t???i th??? t??? part trong k??? n??ng
                    elseif (($parts->skill_id == $request->skill_id)&&($parts->part_name == $request->part_name)&&($parts->part_no != $request->part_no)) {
                        $err[] = 'Part already exists in '.Part::find($parts->part_id)->skills->skill_name.' !';
                    }
                    //ko t???n t???i part - t???n t???i th??? t??? part trong k??? n??ng
                    elseif (($parts->skill_id == $request->skill_id)&&($parts->part_name != $request->part_name)&&($parts->part_no == $request->part_no)) {
                        $err[] = 'Ordinal numbers already exists in '.Part::find($parts->part_id)->skills->skill_name.' !';
                    }
                }
            //n???u ?????i k??? n??ng - ko ?????i part - ko ?????i s??? th??? t??? part
                elseif (($part->skill_id != $request->skill_id)&&($part->part_name == $request->part_name)&&($part->part_no == $request->part_no)) {  
                    //t???n t???i part + th??? t??? part trong k??? n??ng
                    if (($parts->skill_id == $request->skill_id)&&($parts->part_name == $request->part_name)&&($parts->part_no == $request->part_no)) {
                        $err[] = 'Part & Ordinal numbers already exists in '.Part::find($parts->part_id)->skills->skill_name.' !';
                        
                    }
                    //t???n t???i part - ko t???n t???i th??? t??? part trong k??? n??ng
                    elseif (($parts->skill_id == $request->skill_id)&&($parts->part_name == $request->part_name)&&($parts->part_no != $request->part_no)) {
                        $err[] = 'Part already exists in '.Part::find($parts->part_id)->skills->skill_name.' !';
                       
                    }
                    //ko t???n t???i part - t???n t???i th??? t??? part trong k??? n??ng
                    elseif (($parts->skill_id == $request->skill_id)&&($parts->part_name != $request->part_name)&&($parts->part_no == $request->part_no)) {
                        $err[] = 'Ordinal numbers already exists in '.Part::find($parts->part_id)->skills->skill_name.' !';
                       
                    }
                }
            //n???u ?????i k??? n??ng - ?????i part - ko ?????i s??? th??? t??? part
                elseif (($part->skill_id != $request->skill_id)&&($part->part_name != $request->part_name)&&($part->part_no == $request->part_no)) {  
                    //t???n t???i part + th??? t??? part trong k??? n??ng
                    if (($parts->skill_id == $request->skill_id)&&($parts->part_name == $request->part_name)&&($parts->part_no == $request->part_no)) {
                        $err[] = 'Part & Ordinal numbers already exists in '.Part::find($parts->part_id)->skills->skill_name.' !';
                        
                    }
                    //t???n t???i part - ko t???n t???i th??? t??? part trong k??? n??ng
                    elseif (($parts->skill_id == $request->skill_id)&&($parts->part_name == $request->part_name)&&($parts->part_no != $request->part_no)) {
                        $err[] = 'Part already exists in '.Part::find($parts->part_id)->skills->skill_name.' !';
                       
                    }
                    //ko t???n t???i part - t???n t???i th??? t??? part trong k??? n??ng
                    elseif (($parts->skill_id == $request->skill_id)&&($parts->part_name != $request->part_name)&&($parts->part_no == $request->part_no)) {
                        $err[] = 'Ordinal numbers already exists in '.Part::find($parts->part_id)->skills->skill_name.' !';
                        
                    }
                }
            //n???u ?????i k??? n??ng - ko ?????i part - ?????i s??? th??? t??? part
                elseif (($part->skill_id != $request->skill_id)&&($part->part_name == $request->part_name)&&($part->part_no != $request->part_no)) {  
                    //t???n t???i part + th??? t??? part trong k??? n??ng
                    if (($parts->skill_id == $request->skill_id)&&($parts->part_name == $request->part_name)&&($parts->part_no == $request->part_no)) {
                        $err[] = 'Part & Ordinal numbers already exists in '.Part::find($parts->part_id)->skills->skill_name.' !';
                        
                    }
                    //t???n t???i part - ko t???n t???i th??? t??? part trong k??? n??ng
                    elseif (($parts->skill_id == $request->skill_id)&&($parts->part_name == $request->part_name)&&($parts->part_no != $request->part_no)) {
                        $err[] = 'Part already exists in '.Part::find($parts->part_id)->skills->skill_name.' !';
                        
                    }
                    //ko t???n t???i part - t???n t???i th??? t??? part trong k??? n??ng
                    elseif (($parts->skill_id == $request->skill_id)&&($parts->part_name != $request->part_name)&&($parts->part_no == $request->part_no)) {
                        $err[] = 'Ordinal numbers already exists in '.Part::find($parts->part_id)->skills->skill_name.' !';
                        
                    }
                }
            //n???u ko ?????i k??? n??ng - ?????i part - ?????i s??? th??? t??? part
                elseif (($part->skill_id == $request->skill_id)&&($part->part_name != $request->part_name)&&($part->part_no != $request->part_no)) {  
                    //t???n t???i part + th??? t??? part trong k??? n??ng
                    if (($parts->skill_id == $request->skill_id)&&($parts->part_name == $request->part_name)&&($parts->part_no == $request->part_no)) {
                        $err[] = 'Part & Ordinal numbers already exists in '.Part::find($parts->part_id)->skills->skill_name.' !';
                        
                    }
                    //t???n t???i part - ko t???n t???i th??? t??? part trong k??? n??ng
                    elseif (($parts->skill_id == $request->skill_id)&&($parts->part_name == $request->part_name)&&($parts->part_no != $request->part_no)) {
                        $err[] = 'Part already exists in '.Part::find($parts->part_id)->skills->skill_name.' !';
                        
                    }
                    //ko t???n t???i part - t???n t???i th??? t??? part trong k??? n??ng
                    elseif (($parts->skill_id == $request->skill_id)&&($parts->part_name != $request->part_name)&&($parts->part_no == $request->part_no)) {
                        $err[] = 'Ordinal numbers already exists in '.Part::find($parts->part_id)->skills->skill_name.' !';
                        
                    }
                }
            //n???u ko ?????i k??? n??ng -  ko ?????i part - ?????i s??? th??? t??? part
                elseif (($part->skill_id == $request->skill_id)&&($part->part_name == $request->part_name)&&($part->part_no != $request->part_no)) {  
                    //t???n t???i th??? t??? part trong k??? n??ng
                    if (($parts->skill_id == $request->skill_id)&&($parts->part_no == $request->part_no)) {
                        $err[] = 'Ordinal numbers already exists in '.Part::find($parts->part_id)->skills->skill_name.' !';
                        
                    }
                }
                //n???u ko ?????i k??? n??ng - ?????i part - ko ?????i s??? th??? t??? part
                elseif (($part->skill_id == $request->skill_id)&&($part->part_name != $request->part_name)&&($part->part_no == $request->part_no)) {  
                    //t???n t???i part trong k??? n??ng
                    if (($parts->skill_id == $request->skill_id)&&($parts->part_name == $request->part_name)) {
                        $err[] = 'Part already exists in '.Part::find($parts->part_id)->skills->skill_name.' !';
                        
                    }
                }
            }
            
            if (count($err) > 0) {
                return back()->with('error', $err);
            }

            $part->skill_id = $request->skill_id;
            $part->part_name = $request->part_name;
            $part->part_no = $request->part_no;
            $part->part_topic_max = $request->part_topic_max;
            $part->part_des = isset($request->part_des)?$request->part_des:null;
            $part->part_amount_ques_per_topic = $request->part_amount_ques_per_topic;
            $part->save();
            return redirect('/admin/parts')->with('success', 'Updated Part Successfully!'); 
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Part::find($id)->topics()->count() == 0) {
            $delete = Part::find($id)->delete();
            return redirect()->back()->with('success','Deleted Part Successfully!');
        }
        return back()->with('fail', 'Deleted Part Fail!');
    }
}

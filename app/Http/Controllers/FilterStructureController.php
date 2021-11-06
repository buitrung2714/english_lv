<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Skill;
use App\Models\Part;
use App\Models\Level;
use App\Models\Topic;
use App\Models\Question;
use App\Models\Lesson;
use App\Models\FilterStructure;
use App\Models\FilterPart;

class FilterStructureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $struc = FilterStructure::whereNotIn('filter_status', [0])->orderByDesc('filter_id')->get();
        return View('admin.structure.structures', compact('struc'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();
        $skills = Skill::all();
        $levels = Level::all();
        $listen = array();
        $read = array();
        $write = array();
        $speak = array();
        foreach($skills as $key => $skill){
            $parts = Skill::find($skill->skill_id)->parts;
            foreach($parts as $part){
                if ($skill->skill_name == 'Listening') {
                    array_push($listen, [$part->part_name, $part->part_id, $part->part_amount_ques_per_topic, $part->part_topic_max]);
                }

                else if ($skill->skill_name == 'Reading') {
                   array_push($read, [$part->part_name, $part->part_id, $part->part_amount_ques_per_topic, $part->part_topic_max]);
               }

               else if ($skill->skill_name == 'Writting') {
                   array_push($write, [$part->part_name, $part->part_id, $part->part_amount_ques_per_topic, $part->part_topic_max]);        
               }

               else if ($skill->skill_name == 'Speaking') {
                   array_push($speak, [$part->part_name, $part->part_id, $part->part_amount_ques_per_topic, $part->part_topic_max]);
               }
           }

           if ($skill->skill_name == 'Listening') {
               $data['Listening'] = $listen;
           }elseif ($skill->skill_name == 'Reading') {
               $data['Reading'] = $read;
           }elseif ($skill->skill_name == 'Writting') {
               $data['Writting'] = $write;
           }elseif ($skill->skill_name == 'Speaking') {
               $data['Speaking'] = $speak;
           }  
       }

     //kiểm tra 4 kỹ năng
     // $total = Skill::whereIn('skill_name', ['Listening', 'Reading', 'Writting', 'Speaking'])->count();
     // if ($total < 4) {
     //     return View('admin.structure.add_structure')->with('fail_data', "Please insert 4 skill basic: Listening, Reading, Writting, Speaking");
     // }


     // dd($data);
       return View('admin.structure.add_structure', compact('data','levels'));
   }

   // kiểm tra cấu trúc
   public function check_struc(Request $request){
    $err = array();
    $pos_listen = array();
    $pos_read = array();
    $pos_write = array();
    $pos_speak = array();
    $skills = Skill::all();
    $strucs = FilterStructure::all();
    $validator = Validator::make($request->all(),
        [

            'filter_status'=>'required',
        ],
        [

            'filter_status.required'=>'Please could you chose Filter Status again!',
        ]
    );

    if ($validator->fails()) {
        array_push($err, $validator->errors()->toArray());
    }

    if (isset($request->edit_id)) {
        $struc = FilterStructure::find($request->edit_id);
        if ($struc->filter_name != $request->filter_name) {
            //kiểm tra trùng tên cấu trúc
            foreach($strucs as $struc_info){
                if ($struc_info->filter_name == $request->filter_name) {
                    array_push($err, 'Structure Name already exists!');
                }
            }
        }

        if (($struc->filter_status != $request->filter_status) && ($request->filter_status == 1)) {

            //kiểm tra tồn tại đề chuẩn
            $check_status = FilterStructure::whereFilterStatus(1)->count();
            if ($check_status > 0) {
                array_push($err, 'Standard Structure already exists!');
            }
        }
    }else{
        foreach($strucs as $filter){
            if ($request->filter_name == $filter->filter_name) {
                array_push($err, 'Structure Name already exists!');
            }
        }

        //kiểm tra tồn tại đề chuẩn
        $check_status = FilterStructure::whereFilterStatus(1)->count();
        if (($check_status > 0) && ($request->filter_status == 1)) {
            array_push($err, 'Standard Structure already exists!');
        }
    }

     //lấy vị tri
    foreach($request->part_id as $key => $part_id){
        $skill_name = Part::find($part_id)->skills->skill_name;
            //kỹ năng nghe
        if ($skill_name == 'Listening') {
            array_push($pos_listen, $key);
        }
            //kỹ năng đọc
        else if ($skill_name == 'Reading') {
            array_push($pos_read, $key);
        }
            //kỹ năng viết
        else if ($skill_name == 'Writting') {
            array_push($pos_write, $key);
        }
            //kỹ năng nói
        else{
            array_push($pos_speak, $key);
        }
    }
     //BẮT LỖI
    foreach($request->level_id as $keys => $level){
    //nếu là kỹ năng nghe
        if ($request->skill_name[$keys] == 'Listening') {
            foreach($pos_listen as $pos_listen_a){
                //nếu ko đủ topic 
                $topics = Part::find($request->part_id[$pos_listen_a])->topics()->where('level_id', $level)->get();
                if (count($topics) < $request->amount_topic[$pos_listen_a]) {
                    array_push($err, 'Topic Level '.Level::find($level)->level_name.' in '.Part::find($request->part_id[$pos_listen_a])->part_name.' '.Part::find($request->part_id[$pos_listen_a])->skills->skill_name.' exists '.count($topics).' !');
                }else{
                    //nếu số topic trong db = số topic yêu cầu
                    if (count($topics) == $request->amount_topic[$pos_listen_a]) {
                        foreach($topics as $topic){
                            $questions = Topic::find($topic->topic_id)->questions;
                            //nếu câu hỏi/topic ko đủ số lượng part quy định
                            if (count($questions) < Part::find($request->part_id[$pos_listen_a])->part_amount_ques_per_topic) {
                                // array_push($err, 'Question of Topic in '.Part::find($request->part_id[$pos_listen_a])->part_name.' '.Part::find($request->part_id[$pos_listen_a])->skills->skill_name.' not enough!');
                                array_push($err, 'Amount Topic passed not enough '.$request->amount_topic[$pos_listen_a].' topics in '.Part::find($request->part_id[$pos_listen_a])->part_name.' '.Part::find($request->part_id[$pos_listen_a])->skills->skill_name.'!');
                            }
                        }
                    }
                    //nếu lớn hơn 
                    else{
                        $count_topic = 0;
                        $ex = count($topics) - $request->amount_topic[$pos_listen_a];
                        foreach($topics as $topic){
                            $questions = Topic::find($topic->topic_id)->questions;
                            //nếu câu hỏi/topic ko đủ số lượng part quy định
                            if (count($questions) < Part::find($request->part_id[$pos_listen_a])->part_amount_ques_per_topic) {
                                $count_topic++;
                                if ($count_topic > $ex) {
                                    // array_push($err, 'Question of Topic in '.Part::find($request->part_id[$pos_listen_a])->part_name.' '.Part::find($request->part_id[$pos_listen_a])->skills->skill_name.' not enough!');
                                    array_push($err, 'Amount Topic passed not enough '.$request->amount_topic[$pos_listen_a].' topics in '.Part::find($request->part_id[$pos_listen_a])->part_name.' '.Part::find($request->part_id[$pos_listen_a])->skills->skill_name.'!');
                                } 
                            }
                        }
                    }
                } 
            }
        }
//nếu là kỹ năng đọc
        else if ($request->skill_name[$keys] == 'Reading') {
            foreach($pos_read as $pos_read_a){
            //nếu ko đủ topic 
                $topics = Part::find($request->part_id[$pos_read_a])->topics()->where('level_id', $level)->get();
                if (count($topics) < $request->amount_topic[$pos_read_a]) {
                 array_push($err, 'Topic Level '.Level::find($level)->level_name.' in '.Part::find($request->part_id[$pos_read_a])->part_name.' '.Part::find($request->part_id[$pos_read_a])->skills->skill_name.' exists '.count($topics).' !');
             }else{
                    //nếu số topic trong db = số topic yêu cầu
                if (count($topics) == $request->amount_topic[$pos_read_a]) {
                    foreach($topics as $topic){
                        $questions = Topic::find($topic->topic_id)->questions;
                            //nếu câu hỏi/topic ko đủ số lượng part quy định
                        if (count($questions) < Part::find($request->part_id[$pos_read_a])->part_amount_ques_per_topic) {
                            // array_push($err, 'Question of Topic in '.Part::find($request->part_id[$pos_read_a])->part_name.' '.Part::find($request->part_id[$pos_read_a])->skills->skill_name.' not enough!');
                            array_push($err, 'Amount Topic passed not enough '.$request->amount_topic[$pos_read_a].' topics in '.Part::find($request->part_id[$pos_read_a])->part_name.' '.Part::find($request->part_id[$pos_read_a])->skills->skill_name.'!');
                        }
                    }
                }
        //nếu lớn hơn 
                else{
                    $count_topic = 0;
                    $ex = count($topics) - $request->amount_topic[$pos_read_a];
                    foreach($topics as $topic){
                        $questions = Topic::find($topic->topic_id)->questions;
                            //nếu câu hỏi/topic ko đủ số lượng part quy định
                        if (count($questions) < Part::find($request->part_id[$pos_read_a])->part_amount_ques_per_topic) {
                            $count_topic++;
                            if ($count_topic > $ex) {
                                // array_push($err, 'Question of Topic in '.Part::find($request->part_id[$pos_read_a])->part_name.' '.Part::find($request->part_id[$pos_read_a])->skills->skill_name.' not enough!');
                                array_push($err, 'Amount Topic passed not enough '.$request->amount_topic[$pos_read_a].' topics in '.Part::find($request->part_id[$pos_read_a])->part_name.' '.Part::find($request->part_id[$pos_read_a])->skills->skill_name.'!');
                            } 
                        }
                    }
                }
            }
        }
    }
   //nếu là kỹ năng viết
    else if ($request->skill_name[$keys] == 'Writting') {
        foreach($pos_write as $pos_write_a){
            //nếu ko đủ topic 
            $topics = Part::find($request->part_id[$pos_write_a])->topics()->where('level_id', $level)->get();
            if (count($topics) < $request->amount_topic[$pos_write_a]) {
             array_push($err, 'Topic Level '.Level::find($level)->level_name.' in '.Part::find($request->part_id[$pos_write_a])->part_name.' '.Part::find($request->part_id[$pos_write_a])->skills->skill_name.' exists '.count($topics).' !');
         }else{
                    //nếu số topic trong db = số topic yêu cầu
            if (count($topics) == $request->amount_topic[$pos_write_a]) {
                foreach($topics as $topic){
                    $questions = Topic::find($topic->topic_id)->questions;
                            //nếu câu hỏi/topic ko đủ số lượng part quy định
                    if (count($questions) < Part::find($request->part_id[$pos_write_a])->part_amount_ques_per_topic) {
                        // array_push($err, 'Question of Topic in '.Part::find($request->part_id[$pos_write_a])->part_name.' '.Part::find($request->part_id[$pos_write_a])->skills->skill_name.' not enough!');
                        array_push($err, 'Amount Topic passed not enough '.$request->amount_topic[$pos_write_a].' topics in '.Part::find($request->part_id[$pos_write_a])->part_name.' '.Part::find($request->part_id[$pos_write_a])->skills->skill_name.'!');
                    }
                }
            }
        //nếu lớn hơn 
            else{
                $count_topic = 0;
                $ex = count($topics) - $request->amount_topic[$pos_write_a];
                foreach($topics as $topic){
                    $questions = Topic::find($topic->topic_id)->questions;
                            //nếu câu hỏi/topic ko đủ số lượng part quy định
                    if (count($questions) < Part::find($request->part_id[$pos_write_a])->part_amount_ques_per_topic) {
                        $count_topic++;
                        if ($count_topic > $ex) {
                            // array_push($err, 'Question of Topic in '.Part::find($request->part_id[$pos_write_a])->part_name.' '.Part::find($request->part_id[$pos_write_a])->skills->skill_name.' not enough!');
                            array_push($err, 'Amount Topic passed not enough '.$request->amount_topic[$pos_write_a].' topics in '.Part::find($request->part_id[$pos_write_a])->part_name.' '.Part::find($request->part_id[$pos_write_a])->skills->skill_name.'!');
                        } 
                    }
                }
            }
        }
    }
}
   //nếu là kỹ năng nói
else if ($request->skill_name[$keys] == 'Speaking') {
    foreach($pos_speak as $pos_speak_a){
        //nếu ko đủ topic 
        $topics = Part::find($request->part_id[$pos_speak_a])->topics()->where('level_id', $level)->get();
        if (count($topics) < $request->amount_topic[$pos_speak_a]) {
         array_push($err, 'Topic Level '.Level::find($level)->level_name.' in '.Part::find($request->part_id[$pos_speak_a])->part_name.' '.Part::find($request->part_id[$pos_speak_a])->skills->skill_name.' exists '.count($topics).' !');
     }else{
                    //nếu số topic trong db = số topic yêu cầu
        if (count($topics) == $request->amount_topic[$pos_speak_a]) {
            foreach($topics as $topic){
                $questions = Topic::find($topic->topic_id)->questions;
                            //nếu câu hỏi/topic ko đủ số lượng part quy định
                if (count($questions) < Part::find($request->part_id[$pos_speak_a])->part_amount_ques_per_topic) {
                    // array_push($err, 'Question of Topic in '.Part::find($request->part_id[$pos_speak_a])->part_name.' '.Part::find($request->part_id[$pos_speak_a])->skills->skill_name.' not enough!');
                    array_push($err, 'Amount Topic passed not enough '.$request->amount_topic[$pos_speak_a].' topics in '.Part::find($request->part_id[$pos_speak_a])->part_name.' '.Part::find($request->part_id[$pos_speak_a])->skills->skill_name.'!');
                }
            }
        }
        //nếu lớn hơn 
        else{
            $count_topic = 0;
            $ex = count($topics) - $request->amount_topic[$pos_speak_a];
            foreach($topics as $topic){
                $questions = Topic::find($topic->topic_id)->questions;
                //nếu câu hỏi/topic ko đủ số lượng part quy định
                if (count($questions) < Part::find($request->part_id[$pos_speak_a])->part_amount_ques_per_topic) {
                    $count_topic++;
                    if ($count_topic > $ex) {
                        // array_push($err, 'Question of Topic in '.Part::find($request->part_id[$pos_speak_a])->part_name.' '.Part::find($request->part_id[$pos_speak_a])->skills->skill_name.' not enough!');
                        array_push($err, 'Amount Topic passed not enough '.$request->amount_topic[$pos_speak_a].' topics in '.Part::find($request->part_id[$pos_speak_a])->part_name.' '.Part::find($request->part_id[$pos_speak_a])->skills->skill_name.'!');
                    } 
                }
            }
        }
    }
}
}  
}
//nếu có lỗi
if (count($err) > 0) {
   return response()->json([ 'error' => array_unique($err)]);
}else{
    return response()->json();
}
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pos_listen = array();
        $pos_read = array();
        $pos_write = array();
        $pos_speak = array();

//lấy vị tri
        foreach($request->part_id as $key => $part_id){
            $skill_name = Part::find($part_id)->skills->skill_name;
            //kỹ năng nghe
            if ($skill_name == 'Listening') {
                array_push($pos_listen, $key);
            }
            //kỹ năng đọc
            else if ($skill_name == 'Reading') {
                array_push($pos_read, $key);
            }
            //kỹ năng viết
            else if ($skill_name == 'Writting') {
                array_push($pos_write, $key);
            }
            //kỹ năng nói
            else{
                array_push($pos_speak, $key);
            }
        }

        $filter = new FilterStructure;
        $filter->filter_name = $request->filter_name;
        $filter->filter_status = $request->filter_status;
        $filter->save();
        $struc = FilterStructure::find($filter->filter_id);
        foreach($request->level_id as $keys => $level){
    //nếu là kỹ năng nghe
            if ($request->skill_name[$keys] == 'Listening') {
                foreach($pos_listen as $pos_listen_s){
                    $struc->parts()->attach($request->part_id[$pos_listen_s], [
                        'filter_topic_level'=> $level,
                        'filter_part_amount_topic'=>$request->amount_topic[$pos_listen_s],
                    ]);
                }
            }
    //nếu là kỹ năng đọc
            else if ($request->skill_name[$keys] == 'Reading') {
                foreach($pos_read as $pos_read_s){
                    $struc->parts()->attach($request->part_id[$pos_read_s], [
                        'filter_topic_level'=> $level,
                        'filter_part_amount_topic'=>$request->amount_topic[$pos_read_s],
                    ]);
                }
            }
    //nếu là kỹ năng viết
            else if ($request->skill_name[$keys] == 'Writting') {
                foreach($pos_write as $pos_write_s){
                    $struc->parts()->attach($request->part_id[$pos_write_s], [
                        'filter_topic_level'=> $level,
                        'filter_part_amount_topic'=>$request->amount_topic[$pos_write_s],
                    ]);
                }
            }
    //nếu là kỹ năng nói
            else if ($request->skill_name[$keys] == 'Speaking') {
                foreach($pos_speak as $pos_speak_s){
                    $struc->parts()->attach($request->part_id[$pos_speak_s], [
                        'filter_topic_level'=> $level,
                        'filter_part_amount_topic'=>$request->amount_topic[$pos_speak_s],
                    ]);
                }
            }
        }
        return redirect()->back()->with('success', 'Created Structure Successfully!');
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
        $levels = Level::all();
        $data_tmp = FilterStructure::find($id)->parts;

        //lấy id level
        foreach($levels as $level){
            if ($level->level_name == 'Easy') {
                $level_easy = $level->level_id;
            }
            else if ($level->level_name == 'Standard') {
                $level_medium = $level->level_id;
            }
            else if ($level->level_name == 'Hard') {
                $level_hard = $level->level_id;
            }
        }
        //xử lý data
        foreach($data_tmp as $data_tmp){
            $temp['part_name'] = Part::find($data_tmp->part_id)->part_name;
            $temp['amount_topic'] = $data_tmp->pivot->filter_part_amount_topic;
            $temp['skill_name'] = Part::find($data_tmp->part_id)->skills->skill_name;
            $level = $data_tmp->pivot->filter_topic_level;
            if($level == $level_easy){
                $temp['level'] = 'Easy';
            }
            else if($level == $level_medium){
                $temp['level'] = 'Standard';
            }
            else if($level == $level_hard){
                $temp['level'] = 'Hard';
            }
            array_push($data, $temp);
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
        $data = array();
        $data_struc = array();
        $data_skill = array();
        $skills = Skill::all();
        $struc = FilterStructure::find($id);
        $levels = Level::all();
        $parts = Part::all();
        $part_listen = array();
        $part_read = array();
        $part_write = array();
        $part_speak = array();
        $details = $struc->parts;
        foreach($parts as $part){
            $skill = Part::find($part->part_id)->skills->skill_name;
            if ($skill == 'Listening') {
                array_push($part_listen, [$part->part_id,$part->part_name,$part->part_amount_ques_per_topic, $part->part_topic_max]);
            }
            else if ($skill == 'Reading') {
               array_push($part_read, [$part->part_id,$part->part_name,$part->part_amount_ques_per_topic, $part->part_topic_max]);
           }
           else if ($skill == 'Writting') {
             array_push($part_write, [$part->part_id,$part->part_name,$part->part_amount_ques_per_topic, $part->part_topic_max]);
         }
         else {
             array_push($part_speak, [$part->part_id,$part->part_name,$part->part_amount_ques_per_topic, $part->part_topic_max]);
         }
     }

     foreach($skills as $key => $skill){
        $parts = Skill::find($skill->skill_id)->parts;
        array_push($data_skill, $skill->skill_name);
        $ar = array();
        foreach($parts as $part){
            array_push($ar, [$part->part_name, $part->part_id, $part->part_amount_ques_per_topic]);
        }
        array_push($data_skill, $ar);

        if ($skill->skill_name == 'Listening') {
            $pos_listen = 'Listening';
        }elseif ($skill->skill_name == 'Reading') {
            $pos_read = 'Reading';
        }elseif ($skill->skill_name == 'Writting') {
            $pos_write = 'Writting';
        }elseif ($skill->skill_name == 'Speaking') {
            $pos_speak = 'Speaking';
        }
    }
    foreach($details as $detail){
        $tempData['skill_name'] = Part::find($detail->part_id)->skills->skill_name;
        $tempData['part_id'] = $detail->part_id;
        $tempData['amount_topic'] = $detail->pivot->filter_part_amount_topic;
        $tempData['level'] = $detail->pivot->filter_topic_level;
        array_push($data_struc, $tempData);
    }

    $data = array();
    $count_part_listen = array();
    $count_part_read = array();
    $count_part_write = array();
    $count_part_speak = array();
    for($i = 0; $i < count($data_struc) ;$i++){
        if($data_struc[$i]['skill_name'] == 'Listening'){
            array_push($count_part_listen, [$data_struc[$i]['level'],$data_struc[$i]['amount_topic'],$data_struc[$i]['part_id']]);
        }
        else if($data_struc[$i]['skill_name'] == 'Reading'){

            array_push($count_part_read, [$data_struc[$i]['level'],$data_struc[$i]['amount_topic'],$data_struc[$i]['part_id']]);
        }
        else if($data_struc[$i]['skill_name'] == 'Writting'){

            array_push($count_part_write, [$data_struc[$i]['level'],$data_struc[$i]['amount_topic'],$data_struc[$i]['part_id']]);
        }
        else{

            array_push($count_part_speak, [$data_struc[$i]['level'],$data_struc[$i]['amount_topic'],$data_struc[$i]['part_id']]);
        }

    }

//lấy level
    if (count($count_part_listen) == 0) {
        $level_listen = -1;
    }else{
        foreach ($count_part_listen as $lv) {
            $level_listen = $lv[0];
        }
    }

    if (count($count_part_read) == 0) {
        $level_read = -1;
    }else{
        foreach ($count_part_read as $lv) {
            $level_read = $lv[0];
        }
    }

    if (count($count_part_write) == 0) {
        $level_write = -1;
    }else{
        foreach ($count_part_write as $lv) {
            $level_write = $lv[0];
        }
    }

    if (count($count_part_speak) == 0) {
        $level_speak = -1;
    }else{
        foreach ($count_part_speak as $lv) {
            $level_speak = $lv[0];
        }
    }

    isset($pos_listen) ? $data['Listening,'.$level_listen] = $part_listen : null;
    isset($pos_read) ? $data['Reading,'.$level_read] = $part_read : null;
    isset($pos_write) ? $data['Writting,'.$level_write] = $part_write : null;
    isset($pos_speak) ? $data['Speaking,'.$level_speak] = $part_speak : null;

    if (isset($data['Listening,'.$level_listen])) {

        foreach($data['Listening,'.$level_listen] as $key => $data_listen_s){
            foreach($count_part_listen as $count_listen){
                if ($data_listen_s[0] == $count_listen[2]) {
                    foreach($count_listen as $listen){
                        array_push($data['Listening,'.$level_listen][$key], $listen);
                    }
                }
            }
        }

    }
    if (isset($data['Reading,'.$level_read])) {

        foreach($data['Reading,'.$level_read] as $key => $data_read_s){
            foreach($count_part_read as $count_read){
                if ($data_read_s[0] == $count_read[2]) {
                    foreach($count_read as $read){
                        array_push($data['Reading,'.$level_read][$key], $read);
                    }
                }
            }
        }

    }
    if (isset($data['Writting,'.$level_write])) {

        foreach($data['Writting,'.$level_write] as $key => $data_write_s){
            foreach($count_part_write as $count_write){
                if ($data_write_s[0] == $count_write[2]) {
                    foreach($count_write as $write){
                        array_push($data['Writting,'.$level_write][$key], $write);
                    }
                }
            }
        }

    }
    if (isset($data['Speaking,'.$level_speak])) {

        foreach($data['Speaking,'.$level_speak] as $key => $data_speak_s){
            foreach($count_part_speak as $count_speak){
                if ($data_speak_s[0] == $count_speak[2]) {
                    foreach($count_speak as $speak){
                        array_push($data['Speaking,'.$level_speak][$key], $speak);
                    }
                }
            }
        }

    }

    return View('admin.structure.update_structure',compact('struc','data','levels'));
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

        $pos_listen = array();
        $pos_read = array();
        $pos_write = array();
        $pos_speak = array();
        $struc_all = FilterStructure::all();
        $struc = FilterStructure::find($id);
        $details = $struc->parts;

        //lấy vị trí
        foreach($request->part_id as $key => $part_id){
            $skill_name = Part::find($part_id)->skills->skill_name;
            if ($skill_name == 'Listening') {
                array_push($pos_listen, $key);
            }
            else if ($skill_name == 'Reading') {
                array_push($pos_read, $key);
            }
            else if ($skill_name == 'Writting') {
                array_push($pos_write, $key);
            }
            else{
                array_push($pos_speak, $key);
            }
        }

// ===========================================XOÁ CÂU HỎI BÀI HỌC ĐÃ TẠO===========================================  
        $lessons = $struc->lessons;
        if (count($lessons) > 0) {
            foreach($lessons as $lesson){
                $lesson_cont = Lesson::find($lesson->lesson_id);
                foreach ($lesson_cont->questions as $question) {
                    $part_id = Topic::find($question->topic_id)->parts->part_id;
                    if (!in_array($part_id, $request->part_id)) {
                        $lesson_cont->questions()->detach($question->question_id);
                    }
                }
            }
        }
// ===========================================XOÁ CÂU HỎI BÀI HỌC ĐÃ TẠO===========================================

        $struc->filter_name = $request->filter_name;
        $struc->filter_status = $request->filter_status;
        $struc->save();

//nếu dữ liệu cũ ko chọn => xoá
        foreach($details as $del){
            $struc->parts()->detach([$del->part_id]);
        }

//sửa
        foreach($request->level_id as $keys => $level){
    //nếu là kỹ năng nghe
            if ($request->skill_name[$keys] == 'Listening') {
                foreach($pos_listen as $pos_listen_s){
                    $struc->parts()->attach($request->part_id[$pos_listen_s], [
                        'filter_topic_level'=> $level,
                        'filter_part_amount_topic'=>$request->amount_topic[$pos_listen_s],
                    ]);
                }
            }
    //nếu là kỹ năng đọc
            else if ($request->skill_name[$keys] == 'Reading') {
                foreach($pos_read as $pos_read_s){
                    $struc->parts()->attach($request->part_id[$pos_read_s], [
                        'filter_topic_level'=> $level,
                        'filter_part_amount_topic'=>$request->amount_topic[$pos_read_s],
                    ]);
                }
            }
    //nếu là kỹ năng viết
            else if ($request->skill_name[$keys] == 'Writting') {
                foreach($pos_write as $pos_write_s){
                    $struc->parts()->attach($request->part_id[$pos_write_s], [
                        'filter_topic_level'=> $level,
                        'filter_part_amount_topic'=>$request->amount_topic[$pos_write_s],
                    ]);
                }
            }
    //nếu là kỹ năng nói
            else if ($request->skill_name[$keys] == 'Speaking') {
                foreach($pos_speak as $pos_speak_s){
                    $struc->parts()->attach($request->part_id[$pos_speak_s], [
                        'filter_topic_level'=> $level,
                        'filter_part_amount_topic'=>$request->amount_topic[$pos_speak_s],
                    ]);
                }
            }
        }
        return redirect('/admin/structures')->with('success', 'Updated Structure Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status_structure($id, $status)
    {
        $filter =  FilterStructure::find($id);

        if ($status == -1 && $filter->filter_status == 1) {
            return back()->with('error', 'Update Status Fail!');
        }else{
            $filter->filter_status = $status;
            $filter->save();
            return redirect()->back()->with('success','Updated Status Successfully!');
        }
    }
}

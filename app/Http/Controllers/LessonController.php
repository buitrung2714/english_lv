<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use PDF;
use App\Models\Skill;
use App\Models\Part;
use App\Models\Topic;
use App\Models\FilterStructure;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\LessonContent;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $lessons = Lesson::whereIn('lesson_status',[1,-1])->orderByDesc('lesson_id')->get();
        foreach($lessons as $lesson){
            $filter_name = Lesson::find($lesson->lesson_id)->filter_structure->filter_name;
            $tempData['lesson_id'] = $lesson->lesson_id;
            $tempData['status'] = $lesson->lesson_status;
            $tempData['date'] = $lesson->created_at;
            $tempData['filter_name'] = $filter_name;
            array_push($data, $tempData);
        }   
        
        
        return View('admin.lesson.lessons',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();
        $skills = array();
        $part_listen = array(); 
        $part_read = array(); 
        $part_write = array(); 
        $part_speak = array();
        $skills_data = Skill::all();
        $parts = Part::all(); 
        $strucs = FilterStructure::whereNotIn('filter_status', [0,-1])->get();

        //sắp xếp skill
        for($j = 0; $j < count($skills_data) ; $j++){
            if ($skills_data[$j]->skill_name == 'Listening') {
                $pos_listen = $j;
            }
            else if($skills_data[$j]->skill_name == 'Reading'){
                $pos_read = $j;
            }
            else if($skills_data[$j]->skill_name == 'Writting'){
                $pos_write = $j;
            }
            else if ($skills_data[$j]->skill_name == 'Speaking') {
                $pos_speak = $j;
            }
        }

        // if (!isset($pos_listen) || !isset($pos_read) || !isset($pos_write) || !isset($pos_speak)) {
        //    $fail_skill = "Please insert 4 skills basic: Listening, Reading, Writting, Speaking";
        //     return View('admin.lesson.add_lesson',compact('fail_skill'));
        // }

        isset($pos_listen) ? $skills[0] = $skills_data[$pos_listen]->skill_name : null;
        isset($pos_read) ? $skills[1] = $skills_data[$pos_read]->skill_name : null;
        isset($pos_write) ? $skills[2] = $skills_data[$pos_write]->skill_name : null;
        isset($pos_speak) ? $skills[3] = $skills_data[$pos_speak]->skill_name : null;

        //chi tiết part
        foreach($parts as $part){
            $skill = Part::find($part->part_id)->skills->skill_name;
            if ($skill == 'Listening') {
                array_push($part_listen, [$part->part_id, $part->part_name, $part->part_amount_ques_per_topic]);
            }
            else if ($skill == 'Reading') {
                array_push($part_read, [$part->part_id, $part->part_name, $part->part_amount_ques_per_topic]);
            }
            else if ($skill == 'Writting') {
                array_push($part_write, [$part->part_id, $part->part_name, $part->part_amount_ques_per_topic]);
            }
            else{
                array_push($part_speak, [$part->part_id, $part->part_name, $part->part_amount_ques_per_topic]);
            }
        }
        isset($pos_listen) ? $data['Listening'] = $part_listen : null;
        isset($pos_read) ? $data['Reading'] = $part_read : null;
        isset($pos_write) ? $data['Writting'] = $part_write : null;
        isset($pos_speak) ? $data['Speaking'] = $part_speak : null;
        return View('admin.lesson.add_lesson',compact('strucs','data','skills'));
    }

    public function get_filter_struc($id){
        $data = array();
        $err = array();
        $data_listen = array();
        $data_read = array();
        $data_write = array();
        $data_speak = array();
        $details = FilterStructure::find($id)->parts;
        foreach($details as $detail){
            $part_id = $detail->pivot->part_id;
            $skill_name = Part::find($part_id)->skills->skill_name;
            if ($skill_name == 'Listening') {
                $topics_listen = Part::find($part_id)->topics()->where('level_id',$detail->pivot->filter_topic_level)->get();
                //nếu ko đủ số lượng topic của cấu trúc
                if (count($topics_listen) < $detail->pivot->filter_part_amount_topic) {
                    array_push($err, 'Topic dont have enough to get part '.$detail->part_name.' in '.Part::find($detail->part_id)->skills->skill_name.'!');
                }
                //nếu đủ số lượng topic
                else{
                    $count_topic_listen = 0;
                    foreach($topics_listen as $topic){
                        $questions = Topic::find($topic->topic_id)->questions;
                        //nếu ko đủ câu hỏi
                        if (count($questions) < $detail->part_amount_ques_per_topic) {
                    //nếu số topic trong db == số topic yêu cầu cấu trúc
                            if (count($topics_listen) == $detail->pivot->filter_part_amount_topic) {
                                array_push($err, 'Topic dont have enough to get part '.$detail->part_name.' in '.Part::find($detail->part_id)->skills->skill_name.'!');
                            }
                    //nếu số topic trong db > số topic yêu cầu
                            else if (count($topics_listen) > $detail->pivot->filter_part_amount_topic){
                                $ex = count($topics_listen) - $detail->pivot->filter_part_amount_topic;
                                $count_topic_listen++;
                                if ($count_topic_listen > $ex) {
                                    array_push($err, 'Topic dont have enough to get part '.$detail->part_name.' in '.Part::find($detail->part_id)->skills->skill_name.'!');
                                }
                            }
                        }
                //nếu đủ câu hỏi
                        else{
                            array_push($data_listen, [$detail->part_id, $detail->part_name, $detail->part_amount_ques_per_topic, $detail->pivot->filter_part_amount_topic, [[$topic->topic_id, $topic->topic_name]]]);
                        }
                    }             
                }  
            }
            else if ($skill_name == 'Reading') {
                $topics_read = Part::find($part_id)->topics()->where('level_id',$detail->pivot->filter_topic_level)->get();
                //nếu ko đủ số lượng topic của cấu trúc
                if (count($topics_read) < $detail->pivot->filter_part_amount_topic) {
                   array_push($err, 'Topic dont have enough to get part '.$detail->part_name.' in '.Part::find($detail->part_id)->skills->skill_name.'!');
               }
                //nếu đủ số lượng topic
               else{
                $count_topic_read = 0;
                foreach($topics_read as $topic){
                    $questions = Topic::find($topic->topic_id)->questions;
                    //nếu ko đủ câu hỏi
                    if (count($questions) < $detail->part_amount_ques_per_topic) {
                    //nếu số topic trong db == số topic yêu cầu cấu trúc
                        if (count($topics_read) == $detail->pivot->filter_part_amount_topic) {
                            array_push($err, 'Topic dont have enough to get part '.$detail->part_name.' in '.Part::find($detail->part_id)->skills->skill_name.'!');
                        }
                    //nếu số topic trong db > số topic yêu cầu
                        else if (count($topics_read) > $detail->pivot->filter_part_amount_topic){
                            $ex = count($topics_read) - $detail->pivot->filter_part_amount_topic;
                            $count_topic_read++;
                            if ($count_topic_read > $ex) {
                                array_push($err, 'Topic dont have enough to get part '.$detail->part_name.' in '.Part::find($detail->part_id)->skills->skill_name.'!');
                            }
                        }
                    }
                //nếu đủ câu hỏi
                    else{
                        array_push($data_read, [$detail->part_id, $detail->part_name, $detail->part_amount_ques_per_topic, $detail->pivot->filter_part_amount_topic, [[$topic->topic_id, $topic->topic_name]]]);
                    }
                }
            }
        }
        else if ($skill_name == 'Writting') {
            $topics_write = Part::find($part_id)->topics()->where('level_id',$detail->pivot->filter_topic_level)->get();

                //nếu ko đủ số lượng topic của cấu trúc
            if (count($topics_write) < $detail->pivot->filter_part_amount_topic) {
                array_push($err, 'Topic dont have enough to get part '.$detail->part_name.' in '.Part::find($detail->part_id)->skills->skill_name.'!');
            }
                //nếu đủ số lượng topic
            else{
                $count_topic_write = 0;
                foreach($topics_write as $topic){
                    $questions = Topic::find($topic->topic_id)->questions;
                    //nếu ko đủ câu hỏi
                    if (count($questions) < $detail->part_amount_ques_per_topic) {
                    //nếu số topic trong db == số topic yêu cầu cấu trúc
                        if (count($topics_write) == $detail->pivot->filter_part_amount_topic) {
                            array_push($err, 'Topic dont have enough to get part '.$detail->part_name.' in '.Part::find($detail->part_id)->skills->skill_name.'!');
                        }
                    //nếu số topic trong db > số topic yêu cầu
                        else if (count($topics_write) > $detail->pivot->filter_part_amount_topic){
                            $ex = count($topics_write) - $detail->pivot->filter_part_amount_topic;
                            $count_topic_write++;
                            if ($count_topic_write > $ex) {
                                array_push($err, 'Topic dont have enough to get part '.$detail->part_name.' in '.Part::find($detail->part_id)->skills->skill_name.'!');
                            }
                        }
                    }
                //nếu đủ câu hỏi
                    else{
                        array_push($data_write, [$detail->part_id, $detail->part_name, $detail->part_amount_ques_per_topic, $detail->pivot->filter_part_amount_topic, [[$topic->topic_id, $topic->topic_name]]]);
                    }
                }      
            }
        }
        else{
         $topics_speak = Part::find($part_id)->topics()->where('level_id',$detail->pivot->filter_topic_level)->get();

                //nếu ko đủ số lượng topic của cấu trúc
         if (count($topics_speak) < $detail->pivot->filter_part_amount_topic) {
            array_push($err, 'Topic dont have enough to get part '.$detail->part_name.' in '.Part::find($detail->part_id)->skills->skill_name.'!');
        }

        //nếu đủ số lượng topic
        else{
            $count_topic_speak = 0;
            foreach($topics_speak as $topic){
                $questions = Topic::find($topic->topic_id)->questions;
                //nếu ko đủ câu hỏi
                if (count($questions) < $detail->part_amount_ques_per_topic) {
                    //nếu số topic trong db == số topic yêu cầu cấu trúc
                    if (count($topics_speak) == $detail->pivot->filter_part_amount_topic) {
                        array_push($err, 'Topic dont have enough to get part '.$detail->part_name.' in '.Part::find($detail->part_id)->skills->skill_name.'!');
                    }
                    //nếu số topic trong db > số topic yêu cầu
                    else if (count($topics_speak) > $detail->pivot->filter_part_amount_topic){
                        $ex = count($topics_speak) - $detail->pivot->filter_part_amount_topic;
                        $count_topic_speak++;
                        if ($count_topic_speak > $ex) {
                            array_push($err, 'Topic dont have enough to get part '.$detail->part_name.' in '.Part::find($detail->part_id)->skills->skill_name.'!');
                        }
                    }
                }
                //nếu đủ câu hỏi
                else{
                    array_push($data_speak, [$detail->part_id, $detail->part_name, $detail->part_amount_ques_per_topic, $detail->pivot->filter_part_amount_topic, [[$topic->topic_id, $topic->topic_name]]]);
                }
            }        
        }
    }
}

$j = 1;
$count_listen_dt = count($data_listen);
for($i = 0; $i < $count_listen_dt; $i = isset($key_listen)?$key_listen:$i){
    if ($j == $count_listen_dt) {
        break;
    }    
    if ($data_listen[$i][0] == $data_listen[$j][0]) {
        array_push($data_listen[$i][4],$data_listen[$j][4][0]);
        unset($data_listen[$j]);
    }else{
        $key_listen = $j;
    }
    $j++;
}

$j = 1;
$count_read_dt = count($data_read);
for($i = 0; $i < $count_read_dt; $i = isset($key_read)?$key_read:$i){
    if ($j == $count_read_dt) {
        break;
    }    
    if ($data_read[$i][0] == $data_read[$j][0]) {
        array_push($data_read[$i][4],$data_read[$j][4][0]);
        unset($data_read[$j]);
    }else{
        $key_read = $j;   
    }
    $j++;
}

$j = 1;
$count_write_dt = count($data_write);
for($i = 0; $i < $count_write_dt; $i = isset($key_write)?$key_write:$i){
    if ($j == $count_write_dt) {
        break;
    }    
    if ($data_write[$i][0] == $data_write[$j][0]) {
        array_push($data_write[$i][4],$data_write[$j][4][0]);
        unset($data_write[$j]);
    }else{
        $key_write = $j;
    }
    $j++;
}

$j = 1;
$count_speak_dt = count($data_speak);
for($i = 0; $i < $count_speak_dt; $i = isset($key_speak)?$key_speak:$i){
    if ($j == $count_speak_dt) {
        break;
    }    
    if ($data_speak[$i][0] == $data_speak[$j][0]) {
        array_push($data_speak[$i][4],$data_speak[$j][4][0]);
        unset($data_speak[$j]);
    }else{
        $key_speak = $j;
    }
    $j++;
}

$data['Listening'] = $data_listen;
$data['Reading'] = $data_read;
$data['Writting'] = $data_write;
$data['Speaking'] = $data_speak;

if (count($err) > 0) {
    return response()->json(['status'=>0,'error'=>$err]);
}else{
    return response()->json($data); 
}
}


public function get_ques_topic($id){
    $questions = Topic::find($id)->questions;
    return response()->json($questions);
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
        $data_listen = array();
        $data_read = array();
        $data_write = array();
        $data_speak = array();
        $lessons = Lesson::all();
        $part_all = Part::all();
        $validator = Validator::make($request->all(),
            [
                'filter_id'=>'required',
            ],
            [
                'filter_id.required'=>'Structure is empty!',
            ]
        );
        if ($validator->fails()) {
            array_push($err, $validator->errors()->toArray());
        }

        if (count($err) > 0) {
            return redirect()->back()->with('error', $err);
        }

        $str = explode(",", $request->question_id);

        $lesson = new Lesson;
        $lesson->lesson_status = 1;
        $lesson->filter_id = $request->filter_id;        
        $lesson->save();

        $lesson_cont = Lesson::find($lesson->lesson_id);

        foreach($part_all as $part_s){
            $topics = Part::find($part_s->part_id)->topics;

            foreach($topics as $topic){

                foreach($str as $question){
                    $topic_id = Question::find($question)->topics->topic_id;
                    $part_id = Topic::find($topic_id)->parts->part_id;
                    $skill_name = Part::find($part_id)->skills->skill_name;

                    if (($skill_name == 'Listening') && ($part_s->part_id == $part_id) && ($topic->topic_id == $topic_id)) {
                        array_push($data_listen, $question);
                    }
                    else if (($skill_name == 'Reading') && ($part_s->part_id == $part_id) && ($topic->topic_id == $topic_id)) {
                        array_push($data_read, $question);
                    }
                    else if (($skill_name == 'Writting') && ($part_s->part_id == $part_id) && ($topic->topic_id == $topic_id)) {
                        array_push($data_write, $question);
                    }
                    else if (($skill_name == 'Speaking') && ($part_s->part_id == $part_id) && ($topic->topic_id == $topic_id)){
                        array_push($data_speak, $question);
                    }
                }

            }

        }

        $lesson_cont->questions()->attach($data_listen);
        $lesson_cont->questions()->attach($data_read);
        $lesson_cont->questions()->attach($data_write);
        $lesson_cont->questions()->attach($data_speak);
        return redirect()->back()->with('success', 'Created Lesson Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($lesson_id)
    {
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
                            'path'          =>  $topic->path,
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
        
        $pdf = PDF::loadView('admin.lesson.viewPDF', compact('data'));
        return $pdf->stream();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $err = array();
        $data = array();
        $data_part = array();
        $data_listen = array();
        $data_read = array();
        $data_write = array();
        $data_speak = array();
        $part_listen = array();
        $part_read = array();
        $part_write = array();
        $part_speak = array();
        $topic_listen = array();
        $topic_read = array();
        $topic_write = array();
        $topic_speak = array();
        $array_topic_listen = array();
        $array_topic_read = array();
        $array_topic_write = array();
        $array_topic_speak = array();
        $skill = array();
        $skills_data = Skill::all();
        $lesson = Lesson::find($id);
        $lesson_cont = $lesson->questions;
        $filter_name = $lesson->filter_structure->filter_name;
        $struc = FilterStructure::find($lesson->filter_id)->parts;
        //sắp xếp skill
        for($j = 0; $j < count($skills_data) ; $j++){
            if ($skills_data[$j]->skill_name == 'Listening') {
                $pos_listen = $j;
            }
            else if($skills_data[$j]->skill_name == 'Reading'){
                $pos_read = $j;
            }
            else if($skills_data[$j]->skill_name == 'Writting'){
                $pos_write = $j;
            }
            else if($skills_data[$j]->skill_name == 'Speaking'){
                $pos_speak = $j;
            }
        }
        isset($pos_listen) ? $skills[0] = $skills_data[$pos_listen]->skill_name : null;
        isset($pos_read) ? $skills[1] = $skills_data[$pos_read]->skill_name : null;
        isset($pos_write) ? $skills[2] = $skills_data[$pos_write]->skill_name : null;
        isset($pos_speak) ? $skills[3] = $skills_data[$pos_speak]->skill_name : null;
        
        //gom dữ liệu theo kỹ năng
        foreach($lesson_cont as $question){
            $part_id = Topic::find($question->topic_id)->parts->part_id;
            $skill_name = Part::find($part_id)->skills->skill_name;
            if ($skill_name == 'Listening') {
                array_push($data_listen, $question->question_id);
                array_push($topic_listen, $question->topic_id);
            }
            else if ($skill_name == 'Reading') {
                array_push($data_read, $question->question_id);
                array_push($topic_read, $question->topic_id);
            }
            else if ($skill_name == 'Writting') {
                array_push($data_write, $question->question_id);
                array_push($topic_write, $question->topic_id);
            }
            else if($skill_name == 'Speaking'){
                array_push($data_speak, $question->question_id);
                array_push($topic_speak, $question->topic_id);
            }
        }

        //lấy dữ liệu cấu trúc
        foreach($struc as $struc_info){
            $skill_struc = Part::find($struc_info->part_id)->skills->skill_name;
            $topics = Part::find($struc_info->part_id)->topics()->where('level_id',$struc_info->pivot->filter_topic_level)->get();
            //nếu đủ số lượng topic
            if (count($topics) >= $struc_info->pivot->filter_part_amount_topic) {
                $count_topic = 0;
                foreach($topics as $topic){
                    $ques_list = Topic::find($topic->topic_id)->questions;
                    //nếu đủ số lượng câu hỏi
                    if (count($ques_list) >= $struc_info->part_amount_ques_per_topic) {
                        if ($skill_struc == 'Listening') {
                            if (in_array($topic->topic_id, $topic_listen)) {
                                array_push($part_listen, [$struc_info->part_id, $struc_info->part_name, $struc_info->part_amount_ques_per_topic, $struc_info->pivot->filter_part_amount_topic, [[$topic->topic_id,$topic->topic_name,$topic->topic_id]]]);
                            }else{
                                array_push($part_listen, [$struc_info->part_id, $struc_info->part_name, $struc_info->part_amount_ques_per_topic, $struc_info->pivot->filter_part_amount_topic, [[$topic->topic_id,$topic->topic_name]]]);
                            }
                        }
                        else if ($skill_struc == 'Reading') {
                            if (in_array($topic->topic_id, $topic_read)) {
                                array_push($part_read, [$struc_info->part_id, $struc_info->part_name, $struc_info->part_amount_ques_per_topic, $struc_info->pivot->filter_part_amount_topic, [[$topic->topic_id,$topic->topic_name,$topic->topic_id]]]);
                            }else{
                             array_push($part_read, [$struc_info->part_id, $struc_info->part_name, $struc_info->part_amount_ques_per_topic, $struc_info->pivot->filter_part_amount_topic, [[$topic->topic_id,$topic->topic_name]]]);
                         }

                     }
                     else if ($skill_struc == 'Writting') {
                        if (in_array($topic->topic_id, $topic_write)) {
                            array_push($part_write, [$struc_info->part_id, $struc_info->part_name, $struc_info->part_amount_ques_per_topic, $struc_info->pivot->filter_part_amount_topic, [[$topic->topic_id,$topic->topic_name,$topic->topic_id]]]);
                        }else{
                         array_push($part_write, [$struc_info->part_id, $struc_info->part_name, $struc_info->part_amount_ques_per_topic, $struc_info->pivot->filter_part_amount_topic, [[$topic->topic_id,$topic->topic_name]]]);
                     }

                 }
                 else if($skill_struc == 'Speaking'){
                    if (in_array($topic->topic_id, $topic_speak)) {
                        array_push($part_speak, [$struc_info->part_id, $struc_info->part_name, $struc_info->part_amount_ques_per_topic, $struc_info->pivot->filter_part_amount_topic, [[$topic->topic_id,$topic->topic_name,$topic->topic_id]]]);
                    }else{
                     array_push($part_speak, [$struc_info->part_id, $struc_info->part_name, $struc_info->part_amount_ques_per_topic, $struc_info->pivot->filter_part_amount_topic, [[$topic->topic_id,$topic->topic_name]]]);
                 }

             }
         }
         //nếu ko đủ câu hỏi
         else{
            //nếu số topic = số topic yêu cầu của cấu trúc
            if (count($topics) == $struc_info->pivot->filter_part_amount_topic){
                array_push($err, 'Data dont have enough Topic to update for structure '.FilterStructure::find($struc_info->pivot->filter_id)->filter_name.' in Part '.Part::find($struc_info->part_id)->part_name.' '.$skill_struc.'!');
            }
                        //nếu số topic > số topic yêu cầu của cấu trúc
            else if (count($topics) > $struc_info->pivot->filter_part_amount_topic){
                $count_topic++;
                $ex = count($topics) - $struc_info->pivot->filter_part_amount_topic;
                if ($count_topic > $ex) {
                 array_push($err, 'Data dont have enough Topic to update for structure '.FilterStructure::find($struc_info->pivot->filter_id)->filter_name.' in Part '.Part::find($struc_info->part_id)->part_name.' '.$skill_struc.'!');
             }
         }
     }
 }  
}

//nếu ko đủ 
else{
    array_push($err, 'Data dont have enough Topic to update for structure '.FilterStructure::find($struc_info->pivot->filter_id)->filter_name.' in Part '.Part::find($struc_info->part_id)->part_name.' '.$skill_struc.'!');
}
}

if (count($part_listen) > 1) {
    $j = 1;
    $count_listen_dt = count($part_listen);
    for($i = 0; $i < $count_listen_dt; $i = isset($key_listen)?$key_listen:$i){
        if ($j == $count_listen_dt) {
            break;
        }    
        if ($part_listen[$i][0] == $part_listen[$j][0]) {
            array_push($part_listen[$i][4],$part_listen[$j][4][0]);
            unset($part_listen[$j]);
        }else{
            $key_listen = $j;
        }
        $j++;
    }
}
if (count($part_read) > 1) {
 $j = 1;
 $count_read_dt = count($part_read);
 for($i = 0; $i < $count_read_dt; $i = isset($key_read)?$key_read:$i){
    if ($j == $count_read_dt) {
        break;
    }    
    if ($part_read[$i][0] == $part_read[$j][0]) {
        array_push($part_read[$i][4],$part_read[$j][4][0]);
        unset($part_read[$j]);
    }else{
        $key_read = $j;
    }
    $j++;
}
}
if (count($part_write) > 1) {
 $j = 1;
 $count_write_dt = count($part_write);
 for($i = 0; $i < $count_write_dt; $i = isset($key_write)?$key_write:$i){
    if ($j == $count_write_dt) {
        break;
    }    
    if ($part_write[$i][0] == $part_write[$j][0]) {
        array_push($part_write[$i][4],$part_write[$j][4][0]);
        unset($part_write[$j]);
    }else{
        $key_write = $j;
    }
    $j++;
}
}

if (count($part_speak) > 1) {
   $j = 1;
   $count_speak_dt = count($part_speak);
   for($i = 0; $i < $count_speak_dt; $i = isset($key_speak)?$key_speak:$i){
    if ($j == $count_speak_dt) {
        break;
    }    
    if ($part_speak[$i][0] == $part_speak[$j][0]) {
        array_push($part_speak[$i][4],$part_speak[$j][4][0]);
        unset($part_speak[$j]);
    }else{
        $key_speak = $j;
    }
    $j++;
}
}

        //lấy danh sách câu hỏi nghe
foreach($part_listen as $keys => $data_part_listen){
    foreach($part_listen[$keys] as $listen_detail){
        foreach($part_listen[$keys][4] as $key => $topic_ques){
            $listen_ques = Topic::find($topic_ques[0])->questions;
            array_push($array_topic_listen, [$keys,$key,$topic_ques[0]]);
        }
    }
}


$array_tmp = array();
$unique_listen = array_map("unserialize", array_unique(array_map("serialize", $array_topic_listen)));
foreach($unique_listen as $array_listen){
    $count_ques = 0;
    $question_list = Topic::find($array_listen[2])->questions;

    foreach($question_list as $list_ques_listen){
        array_push($array_tmp, $list_ques_listen->question_id);
    }
    foreach($data_listen as $listen_quess){
        $topic_ques = Question::find($listen_quess)->topics->topic_id;
        $question_content = Question::find($listen_quess)->question_content;
        if (($array_listen[2] == $topic_ques) && in_array($listen_quess, $array_tmp)) {
           array_push($part_listen[$array_listen[0]][4][$array_listen[1]], [$listen_quess,$question_content, 1]);
           $count_ques++;
       }     
   }
   foreach($array_tmp as $listen_tmp){
    $topic_tmp = Question::find($listen_tmp)->topics->topic_id;
    $question_cont = Question::find($listen_tmp)->question_content;
    if (!in_array($listen_tmp, $data_listen) && ($array_listen[2] == $topic_tmp)) {
        array_push($part_listen[$array_listen[0]][4][$array_listen[1]], [$listen_tmp,$question_cont]);
    }
}

$part_listen[$array_listen[0]][4][$array_listen[1]]["count_question"] = $count_ques;
}

        //lấy danh sách câu hỏi đọc
foreach($part_read as $keys => $data_part_read){
    foreach($part_read[$keys] as $read_detail){
        foreach($part_read[$keys][4] as $key => $topic_ques){
            $read_ques = Topic::find($topic_ques[0])->questions;
            array_push($array_topic_read, [$keys,$key,$topic_ques[0]]);
        }
    }
}

$array_tmp = array();
$unique_read = array_map("unserialize", array_unique(array_map("serialize", $array_topic_read)));
foreach($unique_read as $array_read){
    $count_ques = 0;
    $question_list = Topic::find($array_read[2])->questions;

    foreach($question_list as $list_ques_read){
        array_push($array_tmp, $list_ques_read->question_id);

    }
    foreach($data_read as $read_quess){
        $topic_ques = Question::find($read_quess)->topics->topic_id;
        $question_content = Question::find($read_quess)->question_content;
        if (($array_read[2] == $topic_ques) && in_array($read_quess, $array_tmp)) {
           array_push($part_read[$array_read[0]][4][$array_read[1]], [$read_quess,$question_content, 1]);
           $count_ques++;
       }
   }

   foreach($array_tmp as $read_tmp){
    $topic_tmp = Question::find($read_tmp)->topics->topic_id;
    $question_cont = Question::find($read_tmp)->question_content;
    if (!in_array($read_tmp, $data_read) && ($array_read[2] == $topic_tmp)) {
        array_push($part_read[$array_read[0]][4][$array_read[1]], [$read_tmp,$question_cont]);
    }
} 
$part_read[$array_read[0]][4][$array_read[1]]["count_question"] = $count_ques;
}

        //lấy danh sách câu hỏi viết
foreach($part_write as $keys => $data_part_write){
    foreach($part_write[$keys] as $write_detail){
        foreach($part_write[$keys][4] as $key => $topic_ques){
            $write_ques = Topic::find($topic_ques[0])->questions;
            array_push($array_topic_write, [$keys,$key,$topic_ques[0]]);
        }
    }
}

$array_tmp = array();
$unique_write = array_map("unserialize", array_unique(array_map("serialize", $array_topic_write)));
foreach($unique_write as $array_write){
    $count_ques = 0;
    $question_list = Topic::find($array_write[2])->questions;

    foreach($question_list as $list_ques_write){
        array_push($array_tmp, $list_ques_write->question_id);

    }
    foreach($data_write as $write_quess){
        $topic_ques = Question::find($write_quess)->topics->topic_id;
        $question_content = Question::find($write_quess)->question_content;
        if (($array_write[2] == $topic_ques) && in_array($write_quess, $array_tmp)) {
           array_push($part_write[$array_write[0]][4][$array_write[1]], [$write_quess,$question_content, 1]);
           $count_ques++;
       }
   }

   foreach($array_tmp as $write_tmp){
    $topic_tmp = Question::find($write_tmp)->topics->topic_id;
    $question_cont = Question::find($write_tmp)->question_content;
    if (!in_array($write_tmp, $data_write) && ($array_write[2] == $topic_tmp)) {
        array_push($part_write[$array_write[0]][4][$array_write[1]], [$write_tmp,$question_cont]);
    }
} 

$part_write[$array_write[0]][4][$array_write[1]]["count_question"] = $count_ques;
}

        //lấy danh sách câu hỏi nói
foreach($part_speak as $keys => $data_part_speak){
    foreach($part_speak[$keys] as $speak_detail){
        foreach($part_speak[$keys][4] as $key => $topic_ques){
            $speak_ques = Topic::find($topic_ques[0])->questions;
            array_push($array_topic_speak, [$keys,$key,$topic_ques[0]]);
        }
    }
}

$array_tmp = array();
$unique_speak = array_map("unserialize", array_unique(array_map("serialize", $array_topic_speak)));
foreach($unique_speak as $array_speak){
    $count_ques = 0;
    $question_list = Topic::find($array_speak[2])->questions;

    foreach($question_list as $list_ques_speak){
        array_push($array_tmp, $list_ques_speak->question_id);

    }
    foreach($data_speak as $speak_quess){
        $topic_ques = Question::find($speak_quess)->topics->topic_id;
        $question_content = Question::find($speak_quess)->question_content;
        if (($array_speak[2] == $topic_ques) && in_array($speak_quess, $array_tmp)) {
           array_push($part_speak[$array_speak[0]][4][$array_speak[1]], [$speak_quess,$question_content, 1]);
           $count_ques++;
       }
   }

   foreach($array_tmp as $speak_tmp){
    $topic_tmp = Question::find($speak_tmp)->topics->topic_id;
    $question_cont = Question::find($speak_tmp)->question_content;
    if (!in_array($speak_tmp, $data_speak) && ($array_speak[2] == $topic_tmp)) {
        array_push($part_speak[$array_speak[0]][4][$array_speak[1]], [$speak_tmp,$question_cont]);
    }
}

$part_speak[$array_speak[0]][4][$array_speak[1]]["count_question"] = $count_ques;  
}

isset($pos_listen) ? $data_part['Listening'] = $part_listen : null;
isset($pos_read) ? $data_part['Reading'] = $part_read : null;
isset($pos_write) ? $data_part['Writting'] = $part_write : null;
isset($pos_speak) ? $data_part['Speaking'] = $part_speak : null;

if (count($err) > 0) {
    return View('admin.lesson.update_lesson', compact('err'));
}

return View('admin.lesson.update_lesson', compact('lesson','filter_name','skills','data_part'));
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
       $data_listen = array();
       $data_read = array();
       $data_write = array();
       $data_speak = array();
       $lesson = Lesson::find($id);
       $details = $lesson->questions;
       $lessons = Lesson::all();
       $parts = Part::all();

       $str = explode(",", $request->question_id);

       $lesson_content_id = LessonContent::where('lesson_id', $id)->first('lesson_content_id')->toArray(); 
    
       if (LessonContent::find($lesson_content_id['lesson_content_id'])->results->count() > 0) {
           return back()->with('error','Updated Fail!');
       }else{
            $lesson->questions()->detach();
       }

    foreach($parts as $part){
        $topics = Part::find($part->part_id)->topics;
       $skill = Part::find($part->part_id)->skills->skill_name;

       foreach($topics as $topic){

           foreach($str as $question){
            $topic_id = Question::find($question)->topics->topic_id;
            $part_ques = Topic::find($topic_id)->parts->part_id;
            if (($skill == 'Listening') && ($part_ques == $part->part_id) && ($topic->topic_id == $topic_id)) {
                array_push($data_listen, $question);
            }
            else if (($skill == 'Reading') && ($part_ques == $part->part_id) && ($topic->topic_id == $topic_id)) {
               array_push($data_read, $question);
           }
           else if (($skill == 'Writting') && ($part_ques == $part->part_id) && ($topic->topic_id == $topic_id)) {
                array_push($data_write, $question);
            }
            else if (($skill == 'Speaking') && ($part_ques == $part->part_id) && ($topic->topic_id == $topic_id)){
                array_push($data_speak, $question);
            }
        }

    }
}
$lesson->questions()->attach($data_listen);
$lesson->questions()->attach($data_read);
$lesson->questions()->attach($data_write);
$lesson->questions()->attach($data_speak);
return redirect('/admin/lessons')->with('success','Updated Lesson Successfully!');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status_lesson($id, $status)
    {
        $lesson = Lesson::find($id);
        $lesson->lesson_status = $status;
        $lesson->save();
        return redirect()->back()->with('success','Updated Lesson Status Successfully!');
    }
}

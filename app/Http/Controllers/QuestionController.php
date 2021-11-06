<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Excel;
use Storage;
use App\Imports\QuestionImport;
use App\Exports\QuestionExport;
use App\Models\Skill;
use App\Models\Part;
use App\Models\Level;
use App\Models\Topic;
use App\Models\Question;
use App\Models\Answer;

class QuestionController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
     {
        $data_question = array();
        $skills = Skill::all();
        $levels = Level::all();
        $questions = Question::orderBy('question_id')->get();
        foreach($questions as $question){
            $topic_part = Topic::find($question->topic_id)->parts->part_id;
            $skill_name = Part::find($topic_part)->skills->skill_name;
            $tempData['skill_name'] = $skill_name;
            $tempData['question_id'] = $question->question_id;
            $tempData['question_content'] = $question->question_content;
            array_push($data_question, $tempData);
        }
        return View('admin.question.questions', compact('skills','levels'))->with('questions', $data_question);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('admin.question.add_question')->with('skills', Skill::all())->with('levels', Level::all())->with('levels_edit', Level::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $err_array = array();
        $error = array();
        $directory = Storage::disk('google');
        $directory_img = Storage::disk('google1');
        $validator = Validator::make($request->all(),[
            'skill_id'=>'required',
            'part_id'=>'required',
            'topic_method'=>'required',
            'question_content'=>'required',
            'question_mark'=>'required',
        ],
        [
            'skill_id.required'=>'Please could you chose Skill again!',
            'part_id.required'=>'Please could you chose Part again!',
            'topic_method.required'=>'Please could you chose Method again!',
            'question_content.required'=>'Please could you fill Question again!',
            'question_mark.required'=>'Please could you fill Mark again!',
        ],
    ); 
        if ($validator->fails()) {
            array_push($error, $validator->errors()->toArray());
        }

        $skills = Skill::all();
        $topics = Topic::all();
        $questions = Question::all();
        $skill_name = Skill::find($request->skill_id)->skill_name;

        //nếu chọn chủ đề có sẵn
        if ($request->topic_method == 1) {
            $validator = Validator::make($request->all(),[
                'topic_id'=>'required',
            ],
            [
                'topic_id.required'=>'Please could you chose Topic again!',
            ]
        );
            if ($validator->fails()) {
                array_push($error, $validator->errors()->toArray());
            }

            //kiểm tra câu hỏi trùng
            foreach($questions as $question){

                if (($question->question_content == ucfirst($request->question_content)) && ($question->topic_id == $request->topic_id)) {
                    array_push($error, 'Question already exists!');
                }
            }
        //nếu thêm chủ đề mới
        }else{
            $validator = Validator::make($request->all(),[
                'topic_name'=>'required|max:255',
                'level_id'=>'required',
                'topic_image'=>'image|max:2048',
            ],
            [
                'topic_name.max'=>'Topic name must not be greater than 255 characters.',
                'topic_name.required'=>'Please could you fill Topic again!',
                'level_id.required'=>'Please could you chose Level again!',
                'topic_image.image'=>'Only use .jpg, .jpeg, .png, .gif!',
                'topic_image.uploaded'=>'The image must be < 2MB',
            ]
        );
            if ($validator->fails()) {
                array_push($error, $validator->errors()->toArray());
            }
                //kiểm tra trùng title chủ đề
            foreach($topics as $topic){
                if ($topic->topic_name == $request->topic_name) {
                    array_push($error,'Topic already exists!');
                }
            }
                //nếu là kỹ năng nghe
            if ($skill_name == 'Listening') {
                $validator = Validator::make($request->all(),[
                    'topic_audio'=>'required|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',
                ],
                [
                    'topic_audio.required'=>'Please could you chose Audio again!',
                    'topic_audio.mimes'=>'Only use .mpeg, .mpga, .mp3, .wav!',
                ]
            );
                if ($validator->fails()) {
                    array_push($error, $validator->errors()->toArray());
                }

                    //kỹ năng đọc, viết, nói
            }else{
             $validator = Validator::make($request->all(),[
                'topic_content'=>'required',
            ],
            [
                'topic_content.required'=>'Please could you fill Content again!',
            ]
        );
             if ($validator->fails()) {
               array_push($error, $validator->errors()->toArray());
           }

       }
            //trả lỗi
       if (count($error) > 0) {
        return redirect()->back()->with('error',$error);
    }
            //nếu có file hình ảnh
    if ($request->file('topic_image') !== null) {
        $topic_image =time().'.'.$request->file('topic_image')->getClientOriginalExtension();
        $request->file('topic_image')->move('file/image', $topic_image);

        $directory_img->put($request->topic_name.'_img.'.$request->file('topic_image')->getClientOriginalExtension(), file_get_contents(public_path('file/image/'.$topic_image)));
        $path_img = $directory_img->url($request->topic_name.'_img.'.$request->file('topic_image')->getClientOriginalExtension());
    }
            //nếu có audio
    if ($request->file('topic_audio') !== null) {
        $topic_audio =time().'.'.$request->file('topic_audio')->getClientOriginalExtension();
        $request->file('topic_audio')->move('file/audio', $topic_audio);

        $directory->put($request->topic_name.'.'.$request->file('topic_audio')->getClientOriginalExtension(), file_get_contents(public_path('file/audio/'.$topic_audio)));
        $path = $directory->url($request->topic_name.'.'.$request->file('topic_audio')->getClientOriginalExtension());
    }

    $topic = new Topic;
    $topic->part_id = $request->part_id;
    $topic->level_id = $request->level_id;
    $topic->topic_name = $request->topic_name;
    $topic->path = isset($path)?$path:null;
    $topic->path_img = isset($path_img)?$path_img:null;
    $topic->topic_audio = isset($topic_audio)?$topic_audio:null;
    $topic->topic_image = isset($topic_image)?$topic_image:null;
    $topic->topic_content = isset($request->topic_content)?$request->topic_content:null;
    $topic->save();
    $topic_id = $topic->topic_id;

}
if (count($error) > 0) {
    return redirect()->back()->with('error',$error);
}
$question = new Question;
$question->topic_id = isset($topic_id)?$topic_id:$request->topic_id;
$question->question_content = ucfirst($request->question_content);
$question->question_mark = $request->question_mark;
$question->save();
$question_id = $question->question_id;
    //thêm đáp án cho kỹ năng nghe, đọc
if ($skill_name == 'Listening' || $skill_name == 'Reading') {
    foreach($request->answer_content as $keys => $answer_content){
        $answer = new Answer;
        $answer->answer_content = $request->answer_content[$keys];
        $answer->answer_true = $request->answer_true[$keys]=='on'?1:0;
        $answer->question_id = $question_id;
        $answer->save();
    }
}             
return redirect()->back()->with('success','Add Question Successfully!');
}

// ====================IMPORT EXCEL====================

// CÁCH 1:
public function storeExcel(Request $request)
{   
    $validator = Validator::make($request->all(),[
        'excel_file'=>'required|mimes:xls,xlsx|max:2048',
    ],
    [
        'excel_file.required'=>'Please could you chose Excel File again!',
        'excel_file.mimes'=>'Only use .xls, .xlxs!',
        'excel_file.uploaded'=>'This file must be < 2MB',
    ]
);
    if ($validator->passes()) {

        //kiểm tra tên file excel
        $excel = $request->file('excel_file')->getClientOriginalName();
        $excel_name = explode("_", current(explode(".", $excel)));
        if (count($excel_name) != 3) {
            return response()->json(['status' => 0, 'errors' => 'File invalid formatting!']);
        }
        //nếu tên file đúng định dạng
        else{
            
            $part_name = str_split($excel_name[1]);
            foreach($part_name as $k_pt => $pt){
                if(is_numeric($pt)){
                    array_splice($part_name, $k_pt , 0, " ");
                    break;
                }
            }
            
            $skill = Skill::whereSkillName($excel_name[0]);
            $level = Level::whereLevelName($excel_name[2]);

            //kiểm tra kỹ năng & part thuộc kĩ năng dó
            if ($skill->count() < 1) {
                return response()->json(['status' => 0, 'errors' => 'Skill not exist!']);
            }else{

                $part = Part::wherePartName(implode("", $part_name))->whereSkillId($skill->first()->skill_id);

                if ($part->count() < 1) {
                   return response()->json(['status' => 0, 'errors' => 'Part in '.$excel_name[0].' not exist!']);
                }

                $part_id = $part->whereSkillId($skill->first()->skill_id)->first()->part_id;
            } 
            
            //kiểm tra level
            if ($level->count() < 1) {
                return response()->json(['status' => 0, 'errors' => 'Level not exist!']);
            }
            $level_id = $level->first()->level_id;
        }

        $data = (new QuestionImport)->toArray($request->file('excel_file'));
        
        // loại trùng trong Excel
        foreach($data[0] as $key => $detail){

            //kiểm tra rỗng trong Excel
            if (trim($detail[0]) == null || trim($detail[4]) == null || trim($detail[5]) == null) {
                $err[] = "Data error line ".($key + 1).' in Excel!';
            }
            //nếu ko rỗng
            else{
                $data_no_empty[] = 
                [
                    'line'      =>      $key + 1,
                    'ok'        =>      $detail,
                ];
            }
        }

        //tồn tại dữ liệu không rỗng
        if (isset($data_no_empty)) {
            $key_err[] = -1;

            //kiểm tra trùng câu hỏi trong excel
            for($i = 0; $i < count($data_no_empty); $i++){
                for ($j = $i + 1; $j < count($data_no_empty); $j++) { 
                    if (($data_no_empty[$i]['ok'][4] == $data_no_empty[$j]['ok'][4]) && ($data_no_empty[$i]['ok'][0] == $data_no_empty[$j]['ok'][0])) {
                        $err[] = "Question duplicate line ".$data_no_empty[$j]['line']." with line ".$data_no_empty[$i]['line']." in Excel!";
                        $key_err[] = $data_no_empty[$j]['line'] - 1;
                    }
                }
            }

            foreach($data_no_empty as $ki => $dt){

        // =========================================LẤY DỮ LIỆU CHỦ ĐỀ + CÂU HỎI=====================================
                    
                    $list_topic = [];
                    $list_question = [];
                    $topics = Topic::all();
                    $questions = Question::all();

                    //lấy danh sách chủ đề
                    foreach($topics as $topic){
                        $list_topic[] = $topic->topic_name;
                    }

                    //lấy danh sách câu hỏi
                    foreach($questions as $question){
                        $list_question[] = $question->question_content;
                    }

    // =========================================LẤY DỮ LIỆU CHỦ ĐỀ + CÂU HỎI=====================================
                    
                    //nếu không nằm trong key lỗi
                    if (!in_array($ki, $key_err)) {   
                    $directory = Storage::disk('google');
                    $directory_img = Storage::disk('google1');
                    $permit_img = ['jpg','jpeg','png','gif'];
                    $permit_audio = ['mp3','mp4','wav'];
                    $permit_answer = [1,2,3,4];
                    $skill_content = ['Reading','Writting','Speaking'];
                    $direc_gg = 'https://drive.google.com/';
                    $skill = Part::find($part_id)->skills->skill_name;

                    //VALIDATE đáp án kỹ năng nghe, đọc
                    if ($skill == 'Listening' || $skill == 'Reading') {

                            //nếu trống trường đáp án
                        if ((!isset($data_no_empty[$ki]['ok'][6]) || !isset($data_no_empty[$ki]['ok'][7]) || !isset($data_no_empty[$ki]['ok'][8]) || !isset($data_no_empty[$ki]['ok'][9]) || !isset($data_no_empty[$ki]['ok'][10])) || (trim($data_no_empty[$ki]['ok'][6]) == null || trim($data_no_empty[$ki]['ok'][7]) == null || trim($data_no_empty[$ki]['ok'][8]) == null || trim($data_no_empty[$ki]['ok'][9]) == null || trim($data_no_empty[$ki]['ok'][10]) == null)) {

                            $err[] = 'Answer error line '.$data_no_empty[$ki]['line'].' in Excel!';
                            continue;
                        }
                            //nếu đủ đáp án
                        else{
                            $answer_array = [$data_no_empty[$ki]['ok'][6], $data_no_empty[$ki]['ok'][7], $data_no_empty[$ki]['ok'][8], $data_no_empty[$ki]['ok'][9]];

                                //nếu đúng cú pháp đáp án đúng
                            if (in_array($data_no_empty[$ki]['ok'][10], $permit_answer)) {
                                    //nếu có đáp án trùng trong câu hỏi
                                if (count(array_unique($answer_array)) < count($answer_array)) {
                                    $err[] = 'Answer error line '.$data_no_empty[$ki]['line'].' in Excel!';
                                    continue;
                                }
                            }
                                //nếu không đúng cú pháp đáp án đúng
                            else{
                                $err[] = 'Answer true error line '.$data_no_empty[$ki]['line'].' in Excel!';
                                continue;
                            }
                        }
                    }

                    //nếu trùng câu hỏi
                    if (in_array(ucfirst($data_no_empty[$ki]['ok'][4]), $list_question)){
                        $question_check = Question::whereQuestionContent(ucfirst($data_no_empty[$ki]['ok'][4]));

                        //PHÂN BIỆT CÂU HỎI TRÙNG VỚI CHỦ ĐỀ KHÁC
                        if ($question_check->count() > 0) {
                            $err[] = 'Question already exists DB error line '.$data_no_empty[$ki]['line'].' in Excel!';
                            continue;
                        }
                    }
// ==================================================PROCESS==================================================

                    //nếu đã tồn tại topic
                    if(in_array($data_no_empty[$ki]['ok'][0], $list_topic)){

                        $topic_dt = Topic::whereTopicName($data_no_empty[$ki]['ok'][0])->first();
                        $topic = Topic::find($topic_dt->topic_id);
                    }
                    //nếu chưa có topic
                    else {
                        $topic = new Topic;

                    }     

                    $topic->part_id = $part_id;
                    $topic->level_id = $level_id;
                    $topic->topic_name = $data_no_empty[$ki]['ok'][0];

                    //NẾU TOPIC ĐÃ CÓ HÌNH VÀ NHẬP LINK DRIVE => KIỂM TRA TRÙNG KHỚP
                    if (($topic->path_img != null) && ($topic->path_img != $data_no_empty[$ki]['ok'][3]) && strlen(strstr($data_no_empty[$ki]['ok'][3], $direc_gg)) > 0) {
                        $err[] = 'Image path not match line '.$data_no_empty[$ki]['line'].' in Excel!';
                        continue;
                    }

                    //nếu chủ đề có hình ảnh
                    if (trim($data_no_empty[$ki]['ok'][3]) != null && strlen(strstr($data_no_empty[$ki]['ok'][3], $direc_gg)) < 1) {

                            //nếu có file
                        if (file_exists($data_no_empty[$ki]['ok'][3])) {
                            $file_img = file_get_contents($data_no_empty[$ki]['ok'][3]);
                            $sub_img = explode("/", $data_no_empty[$ki]['ok'][3]);
                            $filename_img = explode(".", end($sub_img));

                                //nếu sai đúng định dạng ảnh
                            if (!in_array($filename_img[1], $permit_img)) {
                                $err[] = 'Image error line '.$data_no_empty[$ki]['line'].' in Excel!';
                                continue;
                            }
                        }
                            //nếu không tồn tại file
                        else{
                            $err[] = 'Image not exist line '.$data_no_empty[$ki]['line'].' in Excel!';
                            continue;
                        }

                    }

                    //NẾU NHẬP LINK DRIVE HÌNH CHO TOPIC MỚI
                    if ($topic->topic_image == null && strlen(strstr($data_no_empty[$ki]['ok'][3], $direc_gg)) > 0) {
                        $err[] = 'Image not exist line '.$data_no_empty[$ki]['line'].' in Excel!';
                        continue;
                    }

                    if ($skill == 'Listening') { 

                        //NẾU ĐÃ CÓ TOPIC VÀ NHẬP LINK DRIVE => KIỂM TRA TRÙNG KHỚP
                        if (($topic->path != null) && ($topic->path != $data_no_empty[$ki]['ok'][1]) && strlen(strstr($data_no_empty[$ki]['ok'][1], $direc_gg)) > 0) {
                            $err[] = 'Audio path not match line '.$data_no_empty[$ki]['line'].' in Excel!';
                            continue;
                        }

                            // nếu có nhập audio
                        if (trim($data_no_empty[$ki]['ok'][1]) != null && strlen(strstr($data_no_empty[$ki]['ok'][1], $direc_gg)) < 1) {                   
                            //nếu tồn tại file audio
                            if (file_exists($data_no_empty[$ki]['ok'][1])) {
                                $file = file_get_contents($data_no_empty[$ki]['ok'][1]);
                                $sub = explode("/", $data_no_empty[$ki]['ok'][1]);

                                $filename = explode(".", end($sub));

                                //nếu sai extension audio
                                if(!in_array($filename[1], $permit_audio)){
                                    $err[] = 'Audio error line '.$data_no_empty[$ki]['line'].' in Excel!';
                                    continue;
                                }
                                //nếu đúng extension audio
                                else{

                                    //nếu đã có audio
                                    if($topic->topic_audio != null){

                                        if (file_exists(public_path("file/audio/".$topic->topic_audio))) {
                                            unlink("file/audio/".$topic->topic_audio);
                                        }
                                    
                                        //xoá trên gg drive
                                        $list = collect($directory->listContents('/',false));
                                        foreach($list as $item){
                                            if ($topic->path == $directory->url($item['path'])) {
                                                $directory->delete($item['path']);
                                            }
                                        }
                                    }

                                    $new_audio = time().$data_no_empty[$ki]['line'].'.'.$filename[1];
                                    $destination = public_path("file/audio/".$new_audio); 
                                    file_put_contents($destination, $file);

                                    //thêm vào gg drive
                                    $directory->put($data_no_empty[$ki]['ok'][0].'.'.$filename[1], $file);

                                    $topic->topic_audio = $new_audio;
                                    $topic->path = $directory->url($data_no_empty[$ki]['ok'][0].'.'.$filename[1]);
                                }
                            }
                            //nếu không tồn tại file
                            else{
                                $err[] = 'Audio not exist line '.$data_no_empty[$ki]['line'].' in Excel!';
                                continue;
                            }
                        }
                            //nếu không nhập audio
                        elseif(trim($data_no_empty[$ki]['ok'][1]) == null && $topic->topic_audio == null){
                            $err[] = 'Audio empty line '.$data_no_empty[$ki]['line'].' in Excel!';
                            continue;
                        }

                        //TOPIC MỚI VÀ NHẬP LINK GG
                        if($topic->topic_audio == null && trim($data_no_empty[$ki]['ok'][1]) != null){
                            $err[] = 'Audio not exist line '.$data_no_empty[$ki]['line'].' in Excel!';
                            continue;
                        }
                    }
                        //nếu kỹ năng đọc, nói, viết
                    elseif(in_array($skill, $skill_content)){

                        //nếu không có nội dung chủ đề
                        if (trim($data_no_empty[$ki]['ok'][2]) == null && $topic->topic_content == null) {
                            $err[] = 'Topic Content empty line '.$data_no_empty[$ki]['line'].' in Excel!';
                            continue;
                        }
                            //nếu có nội dung
                        else if(trim($data_no_empty[$ki]['ok'][2]) != null){
                            $topic->topic_content = $data_no_empty[$ki]['ok'][2];
                        }
                    }

                    //nếu chủ đề có hình ảnh
                    if (trim($data_no_empty[$ki]['ok'][3]) != null && strlen(strstr($data_no_empty[$ki]['ok'][3], $direc_gg)) < 1) {

                        //nếu đã có hình ảnh
                        if ($topic->topic_image != null) {

                            if (file_exists(public_path("file/image/".$topic->topic_image))) {
                                    unlink("file/image/".$topic->topic_image);
                                }
                            
                            //xoá trên gg 
                            $list_img = collect($directory_img->listContents('/',false));
                            foreach($list_img as $image){
                                if ($topic->path_img == $directory_img->url($image['path'])) {
                                    $directory_img->delete($image['path']);
                                }
                            }
                        }

                        $new_img = time().$data_no_empty[$ki]['line'].'.'.$filename_img[1];
                        $destination_img = public_path("file/image/".$new_img); 
                        file_put_contents($destination_img, $file_img);

                        $directory_img->put($data_no_empty[$ki]['ok'][0].'_img.'.$filename_img[1], $file_img);
                        $path_img = $directory_img->url($data_no_empty[$ki]['ok'][0].'_img.'.$filename_img[1]);

                        $topic->path_img = $path_img;
                        $topic->topic_image = $new_img;
                           
                    }

                    $topic->save();
                    $topic_id_save = $topic->topic_id;

                    $question = new Question;
                    $question->topic_id = $topic_id_save;
                    $question->question_mark = $data_no_empty[$ki]['ok'][5];
                    $question->question_content = ucfirst($data_no_empty[$ki]['ok'][4]);
                    $question->save();
                    $question_id_save = $question->question_id;

                        //INSERT đáp án là kỹ năng nghe, đọc
                    if ($skill == 'Listening' || $skill == 'Reading') {

                        foreach($answer_array as $key_ans => $ans){
                            $answer = new Answer;
                            $answer->question_id = $question_id_save;
                            $answer->answer_content = $ans;

                            if ($data_no_empty[$ki]['ok'][10] == ($key_ans + 1)) {
                                $answer->answer_true = 1;
                            }else{
                                $answer->answer_true = 0;
                            }

                            $answer->save();
                        }
                    }
                }
            }
        }

    //nếu có lỗi
        if (isset($err)) {
            $uniq = array_unique($err);
            return response()->json(['status' => 1, 'error' => $uniq]);
        }else{
            return response()->json(['status' => 1]);
        }

    }else{
        return response()->json(['status'=>0,'errors'=>$validator->errors()->toArray()]);
    }
}

// ====================IMPORT EXCEL====================

public function showExcel(Request $request){
    $data = $request->all();

    $part_name = Part::wherePartId($data['part_export'])->whereSkillId($data['skill_export'])->first()->part_name;
    $level_name = Level::find($data['level_export'])->level_name;
    $data_topic = Topic::wherePartId($data['part_export'])->whereLevelId($data['level_export']);
    
    //nếu có topic
    if ($data_topic->count() > 0) {
        $count = 0;
        foreach($data_topic->get() as $key => $topic){
            if (Topic::find($topic->topic_id)->questions()->count() > 0) {
                ++$count;
            }

            if(($key + 1) == $data_topic->count() && $count == 0){
                return back()->with('error','Export Failed!');
            }
        }

        return Excel::download(new QuestionExport($data_topic->get()), Skill::find($data['skill_export'])->skill_name.'_'.str_replace(" ", "", $part_name).'_'.$level_name.'.xlsx');
    }   
    //nếu ko có topic
    else{
        return back()->with('error','Export Failed!');
    } 
}

//hướng dẫn sử dụng excel
public function use_excel(){
    return View('admin.question.use_excel');
}

    //lấy danh sách part
public function get_list_part_ques($id){
    return response()->json(Skill::find($id)->parts);
}
    //lấy chi tiết kỹ năng
public function get_skill_ques($id){
    return response()->json(Skill::find($id));
}
    //lấy danh sách topic
public function get_topic_ques($id){
    $topics = Part::find($id)->topics;
    $skill_name = Part::find($id)->skills->skill_name;
    return response()->json($topics);
}
    //lấy thông tin topic
public function get_detail_topic_ques($id){
    return response()->json(Topic::find($id));
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::find($id);
        $topic = $question->topics;
        $part = Topic::find($topic->topic_id)->parts;
        $skill_name = Part::find($part->part_id)->skills->skill_name;
        $tempData['skill_name'] = $skill_name;
        $tempData['part_name'] = $part->part_name;
        $tempData['topic_name'] = $topic->topic_name;
        $tempData['path'] = $topic->path;
        //nếu không phải chủ đề audio - có hình
        if (($topic->topic_content != null) && ($topic->topic_image != null)) {
            $tempData['topic_content'] = $topic->topic_content;
            $tempData['topic_image'] = $topic->topic_image;
        }else if(($topic->topic_content != null) && ($topic->topic_image == null)){
            $tempData['topic_content'] = $topic->topic_content;
        }
        //nếu là chủ đề audio - có hình
        if (($topic->topic_audio != null) && ($topic->topic_image != null)) {
            $tempData['topic_audio'] = $topic->topic_audio;
            $tempData['topic_image'] = $topic->topic_image;
        }else if(($topic->topic_audio != null) && ($topic->topic_image == null)){
            $tempData['topic_audio'] = $topic->topic_audio;
        }
        //lấy từng đáp án đối với kỹ năng nghe - đọc
        if (($skill_name == 'Listening') || ($skill_name == 'Reading')) {
            $answers = $question->answers;
            foreach($answers as $key => $answer){
                $tempAns[$key] = $answer;   
            }
            array_push($tempData, $tempAns);
        }
        return response()->json($tempData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $levels = Level::all();
        $question = Question::find($id);
        $ques_topic = $question->topics;
        $topic_part = Topic::find($ques_topic->topic_id)->parts;
        $part_skill = Part::find($topic_part->part_id)->skills;
        $parts = Skill::find($part_skill->skill_id)->parts;
        $part_topic = Part::find($topic_part->part_id)->topics;
        $level_edit = Level::all();
        //đáp án kỹ năng nghe và đọc
        if (($part_skill->skill_name == 'Listening') || ($part_skill->skill_name == 'Reading')) {
           $answers = $question->answers;
       }
       return View('admin.question.update_question')
       ->with('skill', $part_skill)
       ->with('part', $topic_part)
       ->with('parts', $parts)
       ->with('topics', $part_topic)
       ->with('levels', $levels)
       ->with('levels_edit', $level_edit)
       ->with('answers', isset($answers)?$answers:null)
       ->with('question', $question);
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

        $error = array();
        $err_array = array();
        $directory = Storage::disk('google');
        $directory_img = Storage::disk('google1');
        $validator = Validator::make($request->all(),[
            'topic_method'=>'required',
            'question_content'=>'required',
            'question_mark'=>'required',
            'part_id'=>'required',
        ],
        [
            'topic_method.required'=>'Please could you chose Method again!',
            'question_content.required'=>'Please could you fill Question again!',
            'question_mark.required'=>'Please could you fill Mark again!',
            'part_id.required'=>'Please could you chose Part again!',
        ]
    );
        if ($validator->fails()) {
            array_push($error, $validator->errors()->toArray());  
        }

        $questions = Question::all();
        $topics = Topic::all();
        $question = Question::find($id);
        $answers = $question->answers;
        $skill_name = Part::find($request->part_id)->skills->skill_name;

        //nếu chọn chủ đề có sẵn
        if ($request->topic_method == 1) {
            $validator = Validator::make($request->all(),[
                'topic_id'=>'required',
            ],
            [
                'topic_id.required'=>'Please could you chose Topic again!',
            ]
        );
            if ($validator->fails()) {          
                array_push($error, $validator->errors()->toArray()); 
            }

            //nếu ko thay đổi nội dung câu hỏi
            if ($question->question_content != ucfirst($request->question_content)) {
                //kiểm tra trùng câu hỏi
                foreach($questions as $questions){
                    if (($questions->question_content == ucfirst($request->question_content)) && ($question->topic_id == $request->topic_id)) {
                        array_push($error, 'Question already exists!');
                    }
                }
            }
            $question->topic_id = $request->topic_id; 
            
        }
        //nếu chọn chủ đề mới
        else if ($request->topic_method == 2){
           $validator = Validator::make($request->all(),[
            'topic_name'=>'required|max:255',
            'level_id'=>'required',
            'topic_image'=>'image|max:2048'
        ],
        [
            'topic_name.max'=>'Topic name must not be greater than 255 characters.',
            'topic_name.required'=>'Please could you fill Topic again!',
            'level_id.required'=>'Please could you chose Level again!',
            'topic_image.image'=>'Only use .jpg, .jpeg, .png, .gif!',
            'topic_image.uploaded'=>'This image must be < 2MB!',
        ]
    );
           if ($validator->fails()) {
               array_push($error, $validator->errors()->toArray());
           }

        //kiểm tra trùng chủ đề
           foreach($topics as $topic){
            if ($topic->topic_name == $request->topic_name) {
                array_push($error, 'Topic already exists!');
            }
        }
        //nếu là kỹ năng nghe
        if ($skill_name == 'Listening') {
         $validator = Validator::make($request->all(),[
            'topic_audio'=>'required|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav'
        ],
        [
            'topic_audio.required'=>'Please could you chose Audio again!',
            'topic_audio.mimes'=>'Only use .mpeg, .mpga, .mp3, .wav!',
        ]
    );
         if ($validator->fails()) {
           array_push($error, $validator->errors()->toArray());
       }
   }
    //kỹ năng đọc, nói viết
   else{
    $validator = Validator::make($request->all(),[
        'topic_content'=>'required'
    ],
    [
        'topic_content.required'=>'Please could you fill Content again!',
    ]
);
    if ($validator->fails()) {
        array_push($error, $validator->errors()->toArray());
    }

}
//nếu có lỗi ràng buộc
if (count($error) > 0) {      
    return redirect()->back()->with('error', $error);
}
//nếu có file hình ảnh
if ($request->file('topic_image') !== null) {
    $topic_image = time().'.'.$request->file('topic_image')->getClientOriginalExtension();
    $request->file('topic_image')->move('file/image', $topic_image);

    $directory_img->put($request->topic_name.'_img.'.$request->file('topic_image')->getClientOriginalExtension(), file_get_contents('file/image/'.$topic_image));
    $path_img = $directory_img->url($request->topic_name.'_img.'.$request->file('topic_image')->getClientOriginalExtension());
}
//nếu có file audio
if ($request->file('topic_audio') !== null) {
    $topic_audio = time().'.'.$request->file('topic_audio')->getClientOriginalExtension();
    $request->file('topic_audio')->move('file/audio', $topic_audio);

    $directory->put($request->topic_name.'.'.$request->file('topic_audio')->getClientOriginalExtension(), file_get_contents('file/audio/'.$topic_audio));
    $path = $directory->url($request->topic_name.'.'.$request->file('topic_audio')->getClientOriginalExtension());
}
//thêm chủ đề         
$topic = new Topic;
$topic->level_id = $request->level_id;
$topic->part_id = $request->part_id;
$topic->topic_name = $request->topic_name;
$topic->path = isset($path)?$path:null;
$topic->path_img = isset($path_img)?$path_img:null;
$topic->topic_content = isset($request->topic_content)?$request->topic_content:null;
$topic->topic_audio = isset($topic_audio)?$topic_audio:null;
$topic->topic_image = isset($topic_image)?$topic_image:null;
$topic->save();
$topic_id = $topic->topic_id;
$question->topic_id = $topic_id;
}

//nếu có lỗi ràng buộc
if (count($error) > 0) {      
    return redirect()->back()->with('error', $error);
}
//nếu có đáp án dành cho kỹ năng nghe, đọc
if ($request->answer_content != null) {
    //xử lý đáp án
    foreach($request->answer_content as $keys => $ans){
        $answer = Answer::find($request->answer_id[$keys]);
        $answer->answer_content = $request->answer_content[$keys];
        $answer->answer_true = $request->answer_id[$keys] == $request->answer_true ? 1:0;
        $answer->question_id = $question->question_id;
        $answer->save();
    }
}
$question->question_content = ucfirst($request->question_content);
$question->question_mark = $request->question_mark;
$question->save();
return redirect('/admin/questions')->with('success', 'Updated Question Successfully!');

}

//cập nhật topic
public function update_topic(Request $request ,$id){
    $err = array();
    $directory = Storage::disk('google');
    $directory_img = Storage::disk('google1');
    $topic = Topic::find($id);
    $part_id = $topic->parts->part_id;
    $skill = Part::find($part_id)->skills->skill_name;
    $topics = Topic::all();
    //kiểm tra validate
    $validate = Validator::make($request->all(),[
        'level_id_edit'=>'required',
        'topic_name_edit'=>'required|max:255',
        'edit_image'=>'required',
    ],
    [
        'topic_name_edit.max'=>'Topic name must not be greater than 255 characters.',
        'level_id_edit.required'=>'Please could you chose Level again!',
        'topic_name_edit.required'=>'Please could you fill Topic again!',
        'edit_image.required'=>'Please could you chose Action Image again!',
    ]
);
    if ($validate->fails()) {
        $err[] = $validate->errors()->toArray();
    }
        //nếu là kỹ năng nghe
    if ($skill == 'Listening') {
            //nếu có thay đổi title 
        if ($topic->topic_name != $request->topic_name_edit) {
                //kiểm tra trùng title 
            foreach($topics as $topics){
                if ($topics->topic_name == $request->topic_name_edit) {
                    $err[] = 'Topic already exists!';
                }
            }
        }
            //nếu đổi audio - ko đổi hình
        if (($request->edit_audio == 2) && ($request->edit_image == 1)){
            $validator = Validator::make($request->all(),[
                'topic_audio_edit'=>'required|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',
            ],
            [
                'topic_audio_edit.required'=>'Please could you chose Audio again!',
                'topic_audio_edit.mimes'=>'Only use .mpeg, .mpga, .mp3, .wav!',
            ]
        );
            if ($validator->fails()) {
                $err[] = $validator->errors()->toArray();
            }

            if (count($err) > 0) {
                return response()->json(['status'=>0, 'error' => $err]);
            }

            //xử lý audio
            if (file_exists(public_path('file/audio/'.$topic->topic_audio))) {
                unlink('file/audio/'.$topic->topic_audio);
            }
            
            $topic_audio = time().'.'.$request->file('topic_audio_edit')->getClientOriginalExtension();
            $request->file('topic_audio_edit')->move('file/audio', $topic_audio);

            $topic->topic_audio = $topic_audio;

            //nếu ko đổi audio - đổi hình
        }else if (($request->edit_audio == 1) && ($request->edit_image == 2)){
            $validator = Validator::make($request->all(),[
                'topic_image_edit'=>'required|image|max:2048',
            ],
            [
                'topic_image_edit.required'=>'Please could you chose Image again!',
                'topic_image_edit.image'=>'Only use .jpeg, .jpg, .png, .gif!',
                'topic_image_edit.uploaded'=>'This image must be < 2MB!',
            ]
        );
            if ($validator->fails()) {
                $err[] = $validator->errors()->toArray();
            }

            if (count($err) > 0) {
                return response()->json(['status'=>0, 'error' => $err]);
            }
                    //nếu topic đã có hình
            if ($topic->topic_image != null) {

                //xử lý image
                if (file_exists(public_path('file/image/'.$topic->topic_image))) {
                    unlink('file/image/'.$topic->topic_image);
                }
               
           }    
           $topic_image = time().'.'.$request->file('topic_image_edit')->getClientOriginalExtension();
           $request->file('topic_image_edit')->move('file/image', $topic_image);

           $topic->topic_image = $topic_image;

            //nếu đổi audio - đổi hình
       }else if (($request->edit_audio == 2) && ($request->edit_image == 2)){
        $validator = Validator::make($request->all(),[
            'topic_image_edit'=>'required|image|max:2048',
            'topic_audio_edit'=>'required|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',
        ],
        [
            'topic_image_edit.required'=>'Please could you chose Image again!',
            'topic_image_edit.image'=>'Only use .jpeg, .jpg, .png, .gif!',
            'topic_image_edit.uploaded'=>'This image must be < 2MB!',
            'topic_audio_edit.required'=>'Please could you chose Audio again!',
            'topic_audio_edit.mimes'=>'Only use .mpeg, .mpga, .mp3, .wav!',
        ]
    );
        if ($validator->fails()) {
            $err[] = $validator->errors()->toArray();
        }

        if (count($err) > 0) {
            return response()->json(['status'=>0, 'error' => $err]);
        }

        //xử lý audio
        if (file_exists(public_path('file/audio/'.$topic->topic_audio))) {
            unlink('file/audio/'.$topic->topic_audio);
        }

        $topic_audio = time().'.'.$request->file('topic_audio_edit')->getClientOriginalExtension();
        $request->file('topic_audio_edit')->move('file/audio', $topic_audio);
                //nếu topic đã có hình
        if ($topic->topic_image != null) {

            //xử lý image
            if (file_exists(public_path('file/image/'.$topic->topic_image))) {
                unlink('file/image/'.$topic->topic_image);
            }
            
        }
        $topic_image = time().'.'.$request->file('topic_image_edit')->getClientOriginalExtension();
        $request->file('topic_image_edit')->move('file/image', $topic_image);

        $topic->topic_audio = $topic_audio;
        $topic->topic_image = $topic_image;
        
    }else if (($request->edit_audio == 1) && ($request->edit_image == 3)){

        if (count($err) > 0) {
            return response()->json(['status'=>0, 'error' => $err]);
        }

        //xử lý image
        if (file_exists(public_path('file/image/'.$topic->topic_image))) {
            unlink('file/image/'.$topic->topic_image);
        }

        //check và xoá trong gg drive
        $images = collect($directory_img->listContents('/',false));
        if(count($images) > 0){
            foreach($images as $image){
                $url_file = $directory_img->url($image['path']);
                if ($url_file == $topic->path_img) {
                    $directory_img->delete($image['path']);
                }
            }
        }

        $topic->topic_image = null;
        //nếu đổi audio - xoá hình
    }else if (($request->edit_audio == 2) && ($request->edit_image == 3)){
       $validator = Validator::make($request->all(),[
        'topic_audio_edit'=>'required|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',
    ],
    [
        'topic_audio_edit.required'=>'Please could you chose Audio again!',
        'topic_audio_edit.mimes'=>'Only use .mpeg, .mpga, .mp3, .wav!',
    ]
);
       if ($validator->fails()) {
        $err[] = $validator->errors()->toArray();
    }

    if (count($err) > 0) {
        return response()->json(['status'=>0, 'error' => $err]);
    }

    //xử lý audio
    if (file_exists(public_path('file/audio/'.$topic->topic_audio))) {
        unlink('file/audio/'.$topic->topic_audio);
    }

    $topic_audio = time().'.'.$request->file('topic_audio_edit')->getClientOriginalExtension();
    $request->file('topic_audio_edit')->move('file/audio', $topic_audio);

    //xoá hình
    if (file_exists(public_path('file/image/'.$topic->topic_image))) {
        unlink('file/image/'.$topic->topic_image);
    }

    //check và xoá trong gg drive
    $images = collect($directory_img->listContents('/',false));
    if(count($images) > 0){
        foreach($images as $image){
            $url_file = $directory_img->url($image['path']);
            if ($url_file == $topic->path_img) {
                $directory_img->delete($image['path']);
            }
        }
    }

    $topic->topic_audio = $topic_audio;
    $topic->topic_image = null;

}
        //nếu là kỹ năng đọc, nói, viết
}else{
   $validator = Validator::make($request->all(),[
    'topic_content'=>'required',
],
[
    'topic_content.required'=>'Please could you fill Content again!',
]
);
   if ($validator->fails()) {
    $err[] = $validator->errors()->toArray();
}

if($topic->topic_name != $request->topic_name_edit){
    foreach($topics as $topics){
        if ($topics->topic_name == $request->topic_name_edit) {
            $err[] = 'Topic already exists!';
        }
    }
}

    //nếu đổi hình ảnh    
if ($request->edit_image == 2){
    $validator = Validator::make($request->all(),[
        'topic_image_edit'=>'required|image|max:2048',
    ],
    [
        'topic_image_edit.required'=>'Please could you chose Image again!',
        'topic_image_edit.image'=>'Only use .jpg, .jpeg, .png, .gif!',
        'topic_image_edit.uploaded'=>'This image must be < 2MB!',
    ]
);
    if ($validator->fails()) {
        $err[] = $validator->errors()->toArray();
    }

    if (count($err) > 0) {
        return response()->json(['status'=>0, 'error' => $err]);
    }
            //nếu topic đã có hình ảnh
    if ($topic->topic_image != null) {

        //xoá hình
        if (file_exists(public_path('file/image/'.$topic->topic_image))) {
            unlink('file/image/'.$topic->topic_image);
        }
    }
    $topic_image = time().'.'.$request->file('topic_image_edit')->getClientOriginalExtension();
    $request->file('topic_image_edit')->move('file/image', $topic_image);

    $topic->topic_image = $topic_image;       

        //nếu xoá hình ảnh
}else if($request->edit_image == 3){

    if (count($err) > 0) {
        return response()->json(['status'=>0, 'error' => $err]);
    }

    //xoá hình
    if (file_exists(public_path('file/image/'.$topic->topic_image))) {
        unlink('file/image/'.$topic->topic_image);
    }

    //check và xoá trong gg drive
    $images = collect($directory_img->listContents('/',false));
    if(count($images) > 0){
        foreach($images as $image){
            $url_file = $directory_img->url($image['path']);
            if ($url_file == $topic->path_img) {
                $directory_img->delete($image['path']);
            }
        }
    }
    $topic->topic_image = null;
}
$topic->topic_content = $request->topic_content;

}

if (count($err) > 0) {
    return response()->json(['status'=>0, 'error' => $err]);
}

if(isset($topic_audio)){
    $files = collect($directory->listContents('/',false));

    if (count($files) > 0) {
        foreach($files as $file){
            $url_file = $directory->url($file['path']);
            if ($url_file == $topic->path) {
                $directory->delete($file['path']);
            }
        }
    }

    $directory->put($request->topic_name_edit.'.'.$request->file('topic_audio_edit')->getClientOriginalExtension(), file_get_contents(public_path('file/audio/'.$topic_audio)));

    $path = $directory->url($request->topic_name_edit.'.'.$request->file('topic_audio_edit')->getClientOriginalExtension());
    $topic->path = $path;
}

if(isset($topic_image)){
    $images = collect($directory_img->listContents('/',false));

    if (count($images) > 0) {
        foreach($images as $image){
            $url_file = $directory_img->url($image['path']);
            if ($url_file == $topic->path_img) {
                $directory_img->delete($image['path']);
            }
        }
    }
    
    $directory_img->put($request->topic_name_edit.'_img.'.$request->file('topic_image_edit')->getClientOriginalExtension(), file_get_contents(public_path('file/image/'.$topic_image)));

    $path_img = $directory_img->url($request->topic_name_edit.'_img.'.$request->file('topic_image_edit')->getClientOriginalExtension());
    $topic->path_img = $path_img;
}

$topic->part_id = $part_id;
$topic->level_id = $request->level_id_edit;
$topic->topic_name = $request->topic_name_edit;
$topic->save();
return response()->json(['status'=>1,$topic]); 


}
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::find($id);

        if ($question->lessons()->count() == 0) {
            $question->answers()->delete();
            $question->delete();
            return redirect()->back()->with('success','Deleted Question Successfully!');
        }
         return redirect()->back()->with('error','Deleted Question Fail!');
    }
}

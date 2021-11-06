<?php

namespace App\Imports;

use App\Models\Question;
use App\Models\Answer;
use App\Models\Topic;
use App\Models\Part;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

// class QuestionImport implements ToCollection{
    
    // public function collection(Collection $collection){
       
//         // $question_array = array();
//         $answer_array = array();
//         $topics = Topic::all();
//         $questions = Question::all();
//         $pos = array();
//         $get_data = array();
//         //xử lý câu hỏi trùng excel
//         for($i = 0; $i < count($collection) ;$i++){
//             for($j = $i+1; $j < count($collection) ;$j++){
//                 if ($collection[$i][1] == $collection[$j][1]) {
//                     print_r("Trùng câu hỏi ".$collection[$j][1]);
//                     array_push($pos, $j);
//                 }      
//             }
//             if (!in_array($i, $pos)) {
//                 array_push($get_data, $collection[$i]);
//             } 
//         }

//        //kiểm tra trùng câu hỏi trong db
//         $data_ques = array();
//         $data_ques_tmp = array();
//         $data_name = array();
//         foreach($questions as $question){
//             array_push($data_ques_tmp, $question->question_content);
//         }
//         foreach($get_data as $data){
//          if (!in_array($data[1],$data_ques_tmp)) {
//              array_push($data_ques, $data);
//          }
//      }

//       //tổng đáp án
//      foreach($data_ques as $collect){
//         $ch = array();
//         if (($collect[3] != null) && ($collect[4] != null) && ($collect[5] != null) && ($collect[6] != null) && ($collect[7] != null)) {
//             array_push($ch, $collect[3]);
//             array_push($ch, $collect[4]);
//             array_push($ch, $collect[5]);
//             array_push($ch, $collect[6]);
//         }
//         array_push($answer_array, $ch);
//     }
//         //xử lý dữ liệu
//     foreach($data_ques as $keys => $data){
//             //duyệt ds topic
//         foreach($topics as $topic){
//                 //nếu tồn tại topic
//             if ($topic->topic_name == $data[0]) {
//                 $part_id = Topic::find($topic->topic_id)->parts->part_id;
//                 $skill_name = Part::find($part_id)->skills->skill_name;
//                     //nếu là kỹ năng nghe, đọc
//                 if ($skill_name == 'Listening' || $skill_name == 'Reading') {
//                     $question = new Question;
//                     $question->topic_id = $topic->topic_id;
//                     $question->question_content = $data[1];
//                     $question->question_mark = $data[2];
//                         //duyệt mảng đáp án
//                     foreach($answer_array as $answer){
//                         //nếu câu hỏi có đáp án đủ
//                         if (count($answer_array[$keys]) > 0) {
//                             $question->save();
//                             $question_id = $question->question_id;
//                             //duyệt từng đáp án
//                             foreach($answer as $key => $answer){
//                                 $answer_add = new Answer;
//                                 $answer_add->question_id = $question_id;
//                                 $answer_add->answer_content = $answer;
//                                 if ($data[7] == '1') {
//                                     if ($key == 0) {
//                                         $answer_add->answer_true = 1;
//                                     }else{
//                                         $answer_add->answer_true = 0;
//                                     }
//                                 }else if ($data[7] == '2') {
//                                     if ($key == 1) {
//                                         $answer_add->answer_true = 1;
//                                     }else{
//                                         $answer_add->answer_true = 0;
//                                     }
//                                 }else if ($data[7] == '3') {
//                                     if ($key == 2) {
//                                         $answer_add->answer_true = 1;
//                                     }else{
//                                         $answer_add->answer_true = 0;
//                                     }
//                                 }else{
//                                     if ($key == 3) {
//                                         $answer_add->answer_true = 1;
//                                     }else{
//                                         $answer_add->answer_true = 0;
//                                     }
//                                 }
//                                 $answer_add->save();
//                             }
//                             break;
//                         }
//                     }
                    
//                 }
//                     //nếu kỹ năng nói, viết
//                 else{
//                     $question = new Question;
//                     $question->topic_id = $topic->topic_id;
//                     $question->question_content = $data[1];
//                     $question->question_mark = $data[2];
//                     $question->save();
//                 }
//             }
//                 //ko tồn tai topic
//             else{
//                 print_r("Topic not available!");
//             }
//         }
//     }
// }
// }



class QuestionImport implements ToModel
{
    use Importable;
    // *
    // * @param array $row
    // *
    // * @return \Illuminate\Database\Eloquent\Model|null
    
    public function model(array $row)
    {
        
        // return new Question([

        // ]);

    }
}

<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Part;
use App\Models\Topic;
use App\Models\Question;
use App\Models\Answer;

class QuestionExport implements FromCollection, WithHeadings
{
    protected $data_topic;

    function __construct($data_topic){
        $this->data = $data_topic;
    }

    public function headings():array{
        return [
            'Topic',
            'Audio',
            'Content',
            'Image',
            'Question',
            'Mark',
            'A',
            'B',
            'C',
            'D',
            'True',
        ];
    }
    public function collection(){
        $key_tmp = 0;
        $skill_content = ['Reading','Writting','Speaking'];
        $key_ans = ['A','B','C','D'];
        foreach($this->data as $key_topic => $topic){
            $part_id = Topic::find($topic->topic_id)->parts->part_id;
            $skill = Part::find($part_id)->skills->skill_name;
            $questions = Topic::find($topic->topic_id)->questions;

            //câu hỏi
            foreach($questions as $key_ques => $question){

            //nếu là kỹ năng nghe
                if ($skill == 'Listening') {
                    $audio = $topic->path;
                }
                //nếu là kỹ năng đọc, nói, viết
                else if (in_array($skill, $skill_content)) {
                    $content = $topic->topic_content;
                }

                //nếu chủ đề có hình
                if ($topic->topic_image != null) {
                    $image = $topic->path_img;
                }

                $data[] = 
                [
                    'topic'     =>      $topic->topic_name,
                    'audio'     =>      isset($audio)   ? $audio : null,
                    'content'   =>      isset($content) ? $content : null,
                    'image'     =>      isset($image)   ? $image : null,
                    'question'  =>      $question->question_content,
                    'mark'      =>      $question->question_mark,
                ];

                if (isset($audio)) {
                    unset($audio);
                }elseif (isset($content)) {
                    unset($content);
                }

                if (isset($image)) {
                    unset($image);
                }

                //lấy đáp án kĩ năng nghe, đọc
                if ($skill == 'Listening' || $skill == 'Reading') {
                    $answers = Question::find($question->question_id)->answers;

                    foreach($answers as $k => $answer){
                        $data[$key_tmp == 0 ? $key_ques : $key_tmp][$key_ans[$k]] = $answer->answer_content;
                        $true = $answer->answer_true;
                    }
                    $data[$key_tmp == 0 ? $key_ques : $key_tmp]['true'] = $true + 1;
                }

                $key_tmp++;
            }
        }
        
        return collect($data);
    }
}

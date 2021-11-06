<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;
use App\Models\Part;
use App\Models\Level;
use App\Models\Topic;
use Validator;
use Storage;
use File;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data_topic = array();
        $topics = Topic::orderByDesc('topic_id')->get();
        foreach($topics as $topics){
            $part_id = Topic::find($topics->topic_id)->parts->part_id;
            $part_name = Topic::find($topics->topic_id)->parts->part_name;
            $level_name = Topic::find($topics->topic_id)->levels->level_name;
            $skill_name = Part::find($part_id)->skills->skill_name;
            $tempData['skill_name'] = $skill_name;
            $tempData['part_name'] = $part_name;
            $tempData['level_name'] = $level_name;
            $tempData['topic_id'] = $topics->topic_id;
            $tempData['topic_name'] = $topics->topic_name;
            $tempData['topic_audio'] = $topics->topic_audio;
            $tempData['topic_content'] = $topics->topic_content;
            $tempData['topic_image'] = $topics->topic_image;
            $tempData['path'] = $topics->path;
            array_push($data_topic, $tempData);
        }
        return View('admin.topic.topics')->with('topics', $data_topic);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('admin.topic.add_topic')->with('levels', Level::all())->with('skills', Skill::all());
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
        //lấy id từng kỹ năng
        $skills = Skill::all();
        foreach($skills as $skills){  
            if ($skills->skill_name == 'Listening') {
                $skill_listen = $skills->skill_id;
            }else if ($skills->skill_name == 'Reading') {
                $skill_read = $skills->skill_id;
            }else if ($skills->skill_name == 'Writting') {
                $skill_write = $skills->skill_id;
            }else if ($skills->skill_name == 'Speaking') {
                $skill_speak = $skills->skill_id;
            }
        }
        
         //kiểm tra validate
        $validate = Validator::make($request->all(),[
            'skill_id'=>'required',
            'level_id'=>'required',
            'part_id'=>'required',
            
        ],
        [
            'skill_id.required'=>'Please could you chose Skill again!',
            'level_id.required'=>'Please could you chose Level again!',
            'part_id.required'=>'Please could you chose Part again!',
            
        ],
    );
        if ($validate->fails()) {
            $err[] = $validate->errors()->toArray();
        }
        //nếu là kỹ năng nghe
        if ($skill_listen == $request->skill_id) {
            //kiểm tra validation
            $validator = Validator::make($request->all(),[
                'topic_name'=>'required|max:255',
                'topic_audio'=>'required|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',
                'topic_image'=>'mimes:jpeg,jpg,png,gif|max:2048',
            ],
            [
                'topic_name.max'=>'Topic name must not be greater than 255 characters.',
                'topic_name.required'=>'Please could you fill Topic again!',
                'topic_audio.required'=>'Please could you chose Audio again!',
                'topic_audio.mimes'=>'Only use .mpeg, .mpga, .mp3, .wav',
                'topic_image.mimes'=>'Only use .jpg, .jpeg, .png, .gif',
                'topic_image.uploaded'=>'This image must be < 2MB',
            ],
        );
            if ($validator->fails()) {
                $err[] = $validator->errors()->toArray();
            }
                //kiểm tra trùng
            $topics = Topic::all();
            foreach($topics as $topic){
                if ($topic->topic_name == $request->topic_name) {
                    $err[] = 'Topic already exists!';
                }
            } 

            if (count($err) > 0) {
              return back()->with('error', $err);
          }  
                //nếu có hình ảnh
          if ($request->file('topic_image') !== null) {
            $topic_image = time().'.'.$request->file('topic_image')->getClientOriginalExtension();
            $request->file('topic_image')->move('file/image', $topic_image);

            $directory_img = Storage::disk('google1');
            $directory_img->put($request->topic_name.'_img.'.$request->file('topic_image')->getClientOriginalExtension(), file_get_contents(public_path('file/image/'.$topic_image)));
            $path_img = $directory_img->url($request->topic_name.'_img.'.$request->file('topic_image')->getClientOriginalExtension());
        }else{
            $topic_image = null;
        }

                //xử lý audio
        $topic_audio = time().'.'.$request->file('topic_audio')->getClientOriginalExtension();
        $request->file('topic_audio')->move('file/audio', $topic_audio); 
        $directory = Storage::disk('google');

        $directory->put($request->topic_name.'.'.$request->file('topic_audio')->getClientOriginalExtension(), file_get_contents(public_path('file/audio/'.$topic_audio)));

        $topic = new Topic;
        $topic->topic_audio = $topic_audio;
        $topic->topic_image = $topic_image;
        $topic->part_id = $request->part_id;
        $topic->level_id = $request->level_id;
        $topic->topic_name = $request->topic_name;
        $topic->path = $directory->url($request->topic_name.'.'.$request->file('topic_audio')->getClientOriginalExtension());
        $topic->path_img = isset($path_img) ? $path_img : null;
        $topic->save();

        return redirect()->back()->with('success', 'Add Topic Successfully!');


        //còn lại (reading, writting, speaking)
    }else{
            //kiểm tra validation
        $validator = Validator::make($request->all(),[
            'topic_name'=>'required|max:255',
            'topic_content'=>'required',
            'topic_image'=>'mimes:jpeg,jpg,png,gif|max:2048',
        ],
        [
            'topic_name.max'=>'Topic name must not be greater than 255 characters.',
            'topic_name.required'=>'Please could you fill Topic again!',
            'topic_content.required'=>'Please could you fill Content again!',
            'topic_image.mimes'=>'Only use .jpg, .jpeg, .png, .gif',
            'topic_image.uploaded'=>'This image must be < 2MB',
        ],
    );
        if ($validator->fails()) {
            $err[] = $validator->errors()->toArray();
        }
                //kiểm tra trùng chủ đề
        $topics = Topic::all();
        foreach($topics as $topic){
        
            if ($topic->topic_name == $request->topic_name) {
                $err[] = 'Topic already exists!';

            }
        }   

        if (count($err) > 0) {
            return back()->with('error', $err);
        }
                    //nếu có hình ảnh
        if ($request->file('topic_image') !== null) {
            $topic_image = time().'.'.$request->file('topic_image')->getClientOriginalExtension();
            $request->file('topic_image')->move('file/image', $topic_image);

            $directory_img = Storage::disk('google1');
            $directory_img->put($request->topic_name.'_img.'.$request->file('topic_image')->getClientOriginalExtension(), file_get_contents(public_path('file/image/'.$topic_image)));
            $path_img = $directory_img->url($request->topic_name.'_img.'.$request->file('topic_image')->getClientOriginalExtension());
        }else{
            $topic_image = null;
        }

        $topic = new Topic;
        $topic->topic_content = $request->topic_content;
        $topic->topic_image = $topic_image;
        $topic->part_id = $request->part_id;
        $topic->level_id = $request->level_id;
        $topic->topic_name = $request->topic_name;
        $topic->path_img = isset($path_img) ? $path_img : null;
        $topic->save();
        return redirect()->back()->with('success', 'Add Topic Successfully!');

    } 

}

    //lấy danh sách part bởi kỹ năng
public function get_list_part_topic($id){
    return response()->json(Skill::find($id)->parts);
}

    //lấy thông tin kỹ năng
public function get_skill_topic($id){
    return response()->json(Skill::find($id));
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Topic::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $topic = Topic::find($id);
        $part_id = $topic->parts->part_id;
        $skill = Part::find($part_id)->skills;
        $parts = Skill::find($skill->skill_id)->parts;
        return View('admin.topic.update_topic')
        ->with('skill', $skill)
        ->with('topic', $topic)
        ->with('parts', $parts)
        ->with('levels', Level::all());
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
        $directory_img = Storage::disk('google1');
        $topic = Topic::find($id);
        $skill = Part::find($request->part_id)->skills->skill_name;
        $topics = Topic::all();
        //kiểm tra validate
        $validate = Validator::make($request->all(),[
            'part_id'=>'required',
            'level_id'=>'required',
            'topic_name'=>'required|max:255',
            'edit_image'=>'required',
        ],
        [
            'topic_name.max'=>'Topic name must not be greater than 255 characters.',
            'part_id.required'=>'Please could you chose Part again!',
            'level_id.required'=>'Please could you chose Level again!',
            'topic_name.required'=>'Please could you fill Title again!',
            'edit_image.required'=>'Please could you chose Action Image again!',
        ]
    );
        if ($validate->fails()) {
            $err[] = $validate->errors()->toArray();
        }
        //nếu là kỹ năng nghe
        if ($skill == 'Listening') {
                //nếu có thay đổi title 
            if ($topic->topic_name != $request->topic_name) {
                        //kiểm tra trùng title 
                foreach($topics as $topics){
                    if ($topics->topic_name == $request->topic_name) {
                        $err[] = 'Topic already exists!';
                        
                    }
                }
            }
            //nếu đổi audio - ko đổi hình
            if (($request->edit_audio == 2) && ($request->edit_image == 1)){
                $validator = Validator::make($request->all(),[
                    'edit_audio'=>'required',
                    'topic_audio'=>'required|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',
                ],
                [
                    'edit_audio.required'=>'Please could you chose Action Audio again!',
                    'topic_audio.required'=>'Please could you chose Audio again!',
                    'topic_audio.mimes'=>'Only use .mpeg, .mpga, .mp3, .wav!',
                ]
            );
                if ($validator->fails()) {
                    $err[] = $validator->errors()->toArray();
                }

                if (count($err) > 0) {
                    return back()->with('error', $err);
                }

                //xử lý audio

                unlink('file/audio/'.$topic->topic_audio);     
                $topic_audio = time().'.'.$request->file('topic_audio')->getClientOriginalExtension();
                $request->file('topic_audio')->move('file/audio', $topic_audio);

                $topic->topic_audio = $topic_audio;

            //nếu ko đổi audio - đổi hình
            }else if (($request->edit_audio == 1) && ($request->edit_image == 2)){
                $validator = Validator::make($request->all(),[
                    'topic_image'=>'required|image|max:2048',
                ],
                [
                    'topic_image.required'=>'Please could you chose Image again!',
                    'topic_image.image'=>'Only use .jpeg, .jpg, .png, .gif!',
                    'topic_image.uploaded'=>'This image must be < 2MB!',
                ]
            );
                if ($validator->fails()) {
                    $err[] = $validator->errors()->toArray();
                }

                if (count($err) > 0) {
                    return back()->with('error', $err);
                }

                //nếu topic đã có hình
                if ($topic->topic_image != null) {
                    unlink('file/image/'.$topic->topic_image);
                 }    

             $topic_image = time().'.'.$request->file('topic_image')->getClientOriginalExtension();
             $request->file('topic_image')->move('file/image', $topic_image);

             $topic->topic_image = $topic_image;

            //nếu đổi audio - đổi hình
         }else if (($request->edit_audio == 2) && ($request->edit_image == 2)){
            $validator = Validator::make($request->all(),[
                'topic_image'=>'required|image|max:2048',
                'edit_audio'=>'required',
                'topic_audio'=>'required|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',
            ],
            [
                'topic_image.required'=>'Please could you chose Image again!',
                'topic_image.image'=>'Only use .jpeg, .jpg, .png, .gif!',
                'topic_image.uploaded'=>'This image must be < 2MB!',
                'edit_audio.required'=>'Please could you chose Action Audio again!',
                'topic_audio.required'=>'Please could you chose Audio again!',
                'topic_audio.mimes'=>'Only use .mpeg, .mpga, .mp3, .wav!',
            ]
        );
            if ($validator->fails()) {
                $err[] = $validator->errors()->toArray();
            }

            if (count($err) > 0) {
                return back()->with('error', $err);
            }

                    //xử lý audio
            unlink('file/audio/'.$topic->topic_audio);
            $topic_audio = time().'.'.$request->file('topic_audio')->getClientOriginalExtension();
            $request->file('topic_audio')->move('file/audio', $topic_audio);
                    //nếu topic đã có hình
            if ($topic->topic_image != null) {
                unlink('file/image/'.$topic->topic_image);
            }
            $topic_image = time().'.'.$request->file('topic_image')->getClientOriginalExtension();
            $request->file('topic_image')->move('file/image', $topic_image);

            $topic->topic_audio = $topic_audio;
            $topic->topic_image = $topic_image;

        }else if (($request->edit_audio == 1) && ($request->edit_image == 3)){

         if (count($err) > 0) {
            return back()->with('error', $err);
        }

                //xử lý hình 
        unlink('file/image/'.$topic->topic_image);
        $images = collect($directory_img->listContents('/',false));

        if (count($images) > 0) {
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
        'edit_audio'=>'required',
        'topic_audio'=>'required|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',
    ],
    [
        'edit_audio.required'=>'Please could you chose Action Audio again!',
        'topic_audio.required'=>'Please could you chose Audio again!',
        'topic_audio.mimes'=>'Only use .mpeg, .mpga, .mp3, .wav!',
    ]
);
       if ($validator->fails()) {
        $err[] = $validator->errors()->toArray();
    }

    if (count($err) > 0) {
        return back()->with('error', $err);
    }

                //xử lý audio
    unlink('file/audio/'.$topic->topic_audio);
    $topic_audio = time().'.'.$request->file('topic_audio')->getClientOriginalExtension();
    $request->file('topic_audio')->move('file/audio', $topic_audio);
                //xoá hình
    unlink('file/image/'.$topic->topic_image);

    $images = collect($directory_img->listContents('/',false));

    if (count($images) > 0) {
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

if ($topic->topic_name != $request->topic_name) {
    foreach($topics as $topics){
        if ($topics->topic_name == $request->topic_name) {
            $err[] = 'Topic already exists!';
        }
    }
}

        //nếu đổi hình ảnh    
if ($request->edit_image == 2){
    $validator = Validator::make($request->all(),[
        'topic_image'=>'required|image|max:2048',
    ],
    [
        'topic_image.required'=>'Please could you chose Image again!',
        'topic_image.image'=>'Only use .jpg, .jpeg, .png, .gif!',
        'topic_image.uploaded'=>'This image must be < 2MB!',
    ]
);
    if ($validator->fails()) {
        $err[] = $validator->errors()->toArray();
    }

    if (count($err) > 0) {
        return back()->with('error', $err);
    }
 //nếu topic đã có hình ảnh
    if ($topic->topic_image != null) {
        unlink('file/image/'.$topic->topic_image);
    }
    $topic_image = time().'.'.$request->file('topic_image')->getClientOriginalExtension();
    $request->file('topic_image')->move('file/image', $topic_image);

    $topic->topic_image = $topic_image;       

        //nếu xoá hình ảnh
}else if($request->edit_image == 3){

 if (count($err) > 0) {
    return back()->with('error', $err);
}

unlink('file/image/'.$topic->topic_image);
$images = collect($directory_img->listContents('/',false));

    if (count($images) > 0) {
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
    return back()->with('error', $err);
}

if (isset($topic_audio)) {
    $directory = Storage::disk('google');
    $files = collect($directory->listContents('/',false));

    if (count($files) > 0) {
        foreach($files as $file){
            $url_file = $directory->url($file['path']);
            if ($url_file == $topic->path) {
                $directory->delete($file['path']);
            }
        }
    }

    $directory->put($request->topic_name.'.'.$request->file('topic_audio')->getClientOriginalExtension(), file_get_contents(public_path('file/audio/'.$topic_audio)));

    $topic->path = $directory->url($request->topic_name.'.'.$request->file('topic_audio')->getClientOriginalExtension());
}

if (isset($topic_image)) {
    $directory_img = Storage::disk('google1');
    $images = collect($directory_img->listContents('/',false));

    if (count($images) > 0) {
        foreach($images as $image){
            $url_file = $directory_img->url($image['path']);
            if ($url_file == $topic->path_img) {
                $directory_img->delete($image['path']);
            }
        }
    }

    $directory_img->put($request->topic_name.'_img.'.$request->file('topic_image')->getClientOriginalExtension(), file_get_contents(public_path('file/image/'.$topic_image)));

    $topic->path_img = $directory_img->url($request->topic_name.'_img.'.$request->file('topic_image')->getClientOriginalExtension());
}
$topic->part_id = $request->part_id;
$topic->level_id = $request->level_id;
$topic->topic_name = $request->topic_name;
$topic->save();
return redirect('/admin/topics')->with('success', 'Updated Topic Successfully!'); 

}

public function download_audio($id){
    $topic = Topic::find($id);

    $directory = Storage::disk('google');
    $files = collect($directory->listContents('/',false));

    $check_file = $files->where('name',$topic->topic_name)->first();

    if ($check_file == null) {
        return back()->with('fail_download','File not exist!');
    }

    if (count($files) > 0) {
        foreach($files as $file){
            $url_file = $directory->url($file['path']);
            if ($url_file == $topic->path) {
                $content = $directory->get($file['path']);

                return response($content)
                ->header('Content-Type', $file['mimetype'])
                ->header('Content-Disposition', "attachment; filename=".$file['name']);
            }
        } 
    }  
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $topic = Topic::find($id);

        if ($topic->questions()->count() == 0) { 
            $directory = Storage::disk('google');
            $directory_img = Storage::disk('google1');
            $files = collect($directory->listContents('/',false));
            $images = collect($directory_img->listContents('/',false));
            //nếu topic có hình
            if ($topic->topic_image != null) {
                //check và xoá trong gg drive
                if(count($images) > 0){
                    foreach($images as $image){
                        $url_file = $directory_img->url($image['path']);
                        if ($url_file == $topic->path_img) {
                            $directory_img->delete($image['path']);
                        }
                    }
                }
                unlink('file/image/'.$topic->topic_image);
            }
            //nếu topic có audio 
            if ($topic->topic_audio != null) {
                //check và xoá trong gg drive
                if(count($files) > 0){
                    foreach($files as $file){
                        $url_file = $directory->url($file['path']);
                        if ($url_file == $topic->path) {
                            $directory->delete($file['path']);
                        }
                    }
                }
                unlink('file/audio/'.$topic->topic_audio);
            }
            $topic->delete();
            return redirect()->back()->with('success','Deleted Topic Successfully!');
        }
        return back()->with('error','Deleted Topic Fail!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Video;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    protected $inputs;

    public function __construct()
    {
        $courses = Course::all()->pluck('title', 'id');
        $chapters = Chapter::all()->pluck('title', 'id');
        $videos = Video::all()->pluck('title', 'id');
        $lesson_types = (new Lesson())->types;

        $all_types = array_keys($lesson_types);

        $this->inputs = [
            'title' => [
                'label' => 'Title',
                'type' => 'text',
                'required' => true,
                'for_types' => $all_types,
                'show_in' => ['create', 'edit'],
                'hidden' => false,
            ],
            'slug' => [
                'label' => 'Slug',
                'type' => 'slug',
                'slug' => 'title',
                'required' => true,
                'for_types' => $all_types,
                'show_in' => ['create'],
                'hidden' => true,
            ],
            'content' => [
                'label' => 'Content',
                'type' => 'textarea',
                'required' => true,
                'for_types' => $all_types,
                'show_in' => ['create', 'edit'],
                'hidden' => false,
            ],
            'type' => [
                'label' => 'Type',
                'type' => 'select',
                'required' => true,
                'options' => $lesson_types,
                'for_types' => $all_types,
                'show_in' => ['create'],
                'hidden' => true,
            ],
            'image_id' => [
                'label' => 'Image ID',
                'type' => 'text',
                'required' => true,
                'for_types' => $all_types,
                'show_in' => ['create', 'edit'],
                'hidden' => false,
            ],
            'video_id' => [
                'label' => 'Video',
                'type' => 'select',
                'required' => true,
                'options' => $videos,
                'for_types' => ['video'],
                'show_in' => ['create', 'edit'],
                'hidden' => false,
            ],
            'course_id' => [
                'label' => 'Course',
                'type' => 'select',
                'required' => true,
                'options' => $courses,
                'for_types' => $all_types,
                'show_in' => ['create'],
                'hidden' => false,
            ],
            'chapter_id' => [
                'label' => 'Chapter',
                'type' => 'select',
                'required' => true,
                'options' => $chapters,
                'for_types' => $all_types,
                'show_in' => ['create', 'edit'],
                'hidden' => false,
            ],
            'is_free' => [
                'label' => 'Is free',
                'type' => 'checkbox',
                'hidden' => false,
                'for_types' => $all_types,
                'show_in' => ['create', 'edit'],
            ],
            'is_downloadable' => [
                'label' => 'Is downloadable',
                'type' => 'checkbox',
                'hidden' => false,
                'for_types' => ['multimedia', 'audio', 'download'],
                'show_in' => ['create', 'edit'],
            ],
            'questions' => [
                'label' => 'Questions',
                'type' => 'repeatable',
                'hidden' => false,
                'for_types' => ['quiz', 'survey'],
                'show_in' => ['create', 'edit'],
            ],
        ];
    }

    private function getInputs($type = 'all', $method = 'create')
    {
        if ($type === 'all') return $this->inputs;

        $inputs = [];

        foreach ($this->inputs as $key => $input) {
            if (in_array($method, $input['show_in']) && in_array($type, $input['for_types'])) {
                $inputs[$key] = $input;
            }
        }

        return $inputs;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $chapters = Chapter::where('course_id', 1)->with('lessons')->get();
//        $chapters = Lesson::with('chapter', 'course')->get()->groupBy('chapter.id');
        return view('lessons.index')->with(compact('chapters'));
    }

    public function create($type)
    {
        return view('lessons.create')->with([
            'inputs' => $this->getInputs($type, 'create'),
            'type' => $type
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required',
            'content' => 'required',
            'type' => 'required',
            'image_id' => 'required',
            'video_id' => 'required',
            'course_id' => 'required',
            'chapter_id' => 'required',
        ]);

        $lesson = Lesson::create([
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'content' => $request->input('content'),
            'type' => $request->input('type'),
            'image_id' => $request->input('image_id'),
            'video_id' => $request->input('video_id'),
            'course_id' => $request->input('course_id'),
            'chapter_id' => $request->input('chapter_id'),
        ]);

        notify()->success("Lesson \"$lesson->title\" was created.", 'Success');

        return redirect()->to(route('lessons.show', $lesson));
    }

    public function show(Lesson $lesson)
    {
        return view('lessons.show')->with(compact('lesson'));
    }

    public function edit(Lesson $lesson)
    {
        return view('lessons.edit')->with([
            'lesson' => $lesson,
            'inputs' => $this->getInputs($lesson->type, 'edit')
        ]);
    }

    public function update(Request $request, Lesson $lesson)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'type' => 'required',
            'image_id' => 'required',
            'video_id' => 'required',
            'course_id' => 'required',
        ]);

        $lesson->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'type' => $request->input('type'),
            'image_id' => $request->input('image_id'),
            'video_id' => $request->input('video_id'),
            'course_id' => $request->input('course_id'),
        ]);

        notify()->success("Lesson \"$lesson->title\" was updated.", 'Success');

        return redirect()->to(route('lessons.show', $lesson));
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();
        notify()->success("Lesson \"$lesson->title\" was deleted.", 'Success');
        return redirect()->back();
    }
}

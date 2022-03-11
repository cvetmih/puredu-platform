<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function __construct()
    {

    }

    private function getInputs()
    {
        $courses = Course::all()->pluck('title', 'id');
        $chapters = Chapter::all()->pluck('title', 'id');

        return [
            'title' => [
                'label' => 'Title',
                'type' => 'text',
                'required' => true
            ],
            'slug' => [
                'label' => 'Slug',
                'type' => 'text',
                'required' => true
            ],
            'description' => [
                'label' => 'Description',
                'type' => 'textarea',
                'required' => true
            ],
            'type' => [
                'label' => 'Type',
                'type' => 'text',
                'required' => true
            ],
            'image_id' => [
                'label' => 'Image ID',
                'type' => 'text',
                'required' => true
            ],
            'video_id' => [
                'label' => 'Video ID',
                'type' => 'text',
                'required' => true
            ],
            'course_id' => [
                'label' => 'Course',
                'type' => 'select',
                'required' => true,
                'options' => $courses
            ],
            'chapter_id' => [
                'label' => 'Chapter',
                'type' => 'select',
                'required' => true,
                'options' => $chapters
            ],
        ];
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

    public function create()
    {
        return view('lessons.create')->with([
            'inputs' => $this->getInputs()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'type' => 'required',
            'image_id' => 'required',
            'video_id' => 'required',
            'course_id' => 'required',
            'chapter_id' => 'required',
        ]);

        $lesson = Lesson::create([
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'description' => $request->input('description'),
            'type' => $request->input('type'),
            'image_id' => $request->input('image_id'),
            'video_id' => $request->input('video_id'),
            'course_id' => $request->input('course_id'),
            'chapter_id' => $request->input('chapter_id'),
        ]);

        notify()->success("Lesson \"$lesson->title\" was created.", 'Success');

        return redirect()->to(route('lessons.show', $lesson))->with([
            'message' => 'New lesson created.'
        ]);
    }

    public function show(Lesson $lesson)
    {
        return view('lessons.show')->with(compact('lesson'));
    }

    public function edit(Lesson $lesson)
    {
        return view('lessons.edit')->with([
            'lesson' => $lesson,
            'inputs' => $this->getInputs()
        ]);
    }

    public function update(Request $request, Lesson $lesson)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'type' => 'required',
            'image_id' => 'required',
            'video_id' => 'required',
            'course_id' => 'required',
        ]);

        $lesson->update([
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'description' => $request->input('description'),
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

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

class VideoController extends Controller
{
    private function getInputs()
    {
        $courses = Course::all()->pluck('title', 'id');
        $chapters = Chapter::all()->pluck('title', 'id');

        return [
            'title' => [
                'label' => 'Title',
                'type' => 'text',
                'required' => true,
                'hidden' => false
            ],
            'vimeo_id' => [
                'label' => 'Vimeo ID',
                'type' => 'text',
                'required' => true,
                'hidden' => false
            ],
            'image_id' => [
                'label' => 'Image ID',
                'type' => 'text',
                'required' => true,
                'hidden' => false
            ],
            'play_count' => [
                'label' => 'Play Count',
                'type' => 'text',
                'required' => false,
                'hidden' => false
            ],
            'last_watched' => [
                'label' => 'Last Watched',
                'type' => 'text',
                'required' => false,
                'hidden' => false
            ],
        ];
    }

    public function index()
    {
        $videos = Video::all();
        return view('videos.index')->with(compact('videos'));
    }

    public function create()
    {
        return view('videos.create')->with([
            'inputs' => $this->getInputs()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'vimeo_id' => 'required',
            'image_id' => 'required'
        ]);

        $video = Video::create([
            'title' => $request->input('title'),
            'vimeo_id' => $request->input('vimeo_id'),
            'image_id' => $request->input('image_id')
        ]);

        notify()->success("Lesson \"$video->title\" was created.", 'Success');

        return redirect()->to(route('videos.show', $video));
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

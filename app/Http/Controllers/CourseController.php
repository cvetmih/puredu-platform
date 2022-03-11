<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    private $inputs;
    private $inputs_quick_edit;

    public function __construct()
    {
        $this->inputs = [
            'title' => [
                'label' => 'Title',
                'type' => 'text',
                'required' => true,
                'quick_edit' => true,
            ],
            'slug' => [
                'label' => 'Slug',
                'type' => 'slug',
                'slug' => 'title',
                'required' => true,
                'quick_edit' => false,
            ],
            'excerpt' => [
                'label' => 'Excerpt',
                'type' => 'textarea',
                'required' => true,
                'quick_edit' => true,
            ],
            'description' => [
                'label' => 'Description',
                'type' => 'textarea',
                'required' => true,
                'quick_edit' => false,
            ],
            'price' => [
                'label' => 'Price',
                'type' => 'text',
                'required' => true,
                'quick_edit' => true,
            ],
            'image_id' => [
                'label' => 'Image ID',
                'type' => 'text',
                'required' => true,
                'quick_edit' => false,
            ],
            'is_active' => [
                'label' => 'Is active',
                'type' => 'checkbox',
                'quick_edit' => true,
            ],
        ];

        $inputs_quick_edit = [];
        foreach ($this->inputs as $name => $input) {
            if ($input['quick_edit']) {
                $inputs_quick_edit[$name] = $input;
            }
        }

        $this->inputs_quick_edit = $inputs_quick_edit;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $courses = Course::all();
        return view('courses.index')->with(compact('courses'));
    }

    public function create()
    {
        return view('courses.create')->with([
            'inputs' => $this->inputs
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required',
            'excerpt' => 'required',
            'description' => 'required',
            'price' => 'required',
//            'is_active' => 'required',
            'image_id' => 'required',
        ]);

        $course = Course::create([
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'excerpt' => $request->input('excerpt'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'is_active' => $request->input('is_active') === 'on',
            'image_id' => $request->input('image_id'),
        ]);

        notify()->success("Course \"$course->title\" was created.", 'Success');

        return redirect()->to(route('courses.show', $course));
    }

    public function show(Course $course)
    {
        return view('courses.show')->with([
            'course' => $course,
            'inputs' => $this->inputs_quick_edit
        ]);
    }

    public function edit(Course $course)
    {
        return view('courses.edit')->with([
            'course' => $course,
            'inputs' => $this->inputs
        ]);
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required',
            'excerpt' => 'required',
            'description' => 'required',
            'price' => 'required',
//            'is_active' => 'required',
            'image_id' => 'required',
        ]);

        $course->update([
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'excerpt' => $request->input('excerpt'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'is_active' => $request->input('is_active') === 'on',
            'image_id' => $request->input('image_id'),
        ]);

        notify()->success("Course \"$course->title\" was updated.", 'Success');

        return redirect()->to(route('courses.show', $course));
    }

    public function destroy(Course $course)
    {
        $course->delete();
        notify()->success("Course was deleted.", 'Success');
        return redirect()->back();
    }
}

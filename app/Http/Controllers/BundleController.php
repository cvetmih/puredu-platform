<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BundleController extends Controller
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
                'hidden' => false
            ],
            'slug' => [
                'label' => 'Slug',
                'type' => 'slug',
                'slug' => 'title',
                'required' => true,
                'quick_edit' => false,
                'hidden' => true
            ],
            'excerpt' => [
                'label' => 'Excerpt',
                'type' => 'textarea',
                'required' => true,
                'quick_edit' => true,
                'hidden' => false
            ],
            'description' => [
                'label' => 'Description',
                'type' => 'textarea',
                'required' => true,
                'quick_edit' => false,
                'hidden' => false
            ],
            'price' => [
                'label' => 'Price',
                'type' => 'text',
                'required' => true,
                'quick_edit' => true,
                'hidden' => false
            ],
            'image_id' => [
                'label' => 'Image ID',
                'type' => 'text',
                'required' => true,
                'quick_edit' => false,
                'hidden' => false
            ],
            'is_active' => [
                'label' => 'Is active',
                'type' => 'checkbox',
                'quick_edit' => true,
                'hidden' => false
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
        $bundles = Bundle::all();
        return view('bundles.index')->with(compact('bundles'));
    }

    public function create()
    {
        return view('bundles.create')->with([
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

        $bundle = Bundle::create([
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'excerpt' => $request->input('excerpt'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'is_active' => $request->input('is_active') === 'on',
            'image_id' => $request->input('image_id'),
        ]);

        notify()->success("Bundle \"$bundle->title\" was created.", 'Success');

        return redirect()->to(route('bundles.show', $bundle));
    }

    public function show(Bundle $bundle)
    {
        return view('bundles.show')->with([
            'bundle' => $bundle,
            'inputs' => $this->inputs_quick_edit
        ]);
    }

    public function edit(Bundle $bundle)
    {
        return view('bundles.edit')->with([
            'bundle' => $bundle,
            'inputs' => $this->inputs
        ]);
    }

    public function update(Request $request, Bundle $bundle)
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

        $bundle->update([
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'excerpt' => $request->input('excerpt'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'is_active' => $request->input('is_active') === 'on',
            'image_id' => $request->input('image_id'),
        ]);

        notify()->success("Bundle \"$bundle->title\" was updated.", 'Success');

        return redirect()->to(route('bundles.show', $bundle));
    }

    public function destroy(Bundle $bundle)
    {
        $bundle->delete();
        notify()->success("Bundle was deleted.", 'Success');
        return redirect()->back();
    }
}

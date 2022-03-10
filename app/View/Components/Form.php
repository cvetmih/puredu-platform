<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Form extends Component
{
    protected $inputs;
    protected $data;
    protected $submit;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($inputs = [], $data = [], $submit = 'Submit')
    {
        $this->inputs = $inputs;
        $this->data = is_array($data) ? (object) $data : $data;
        $this->submit = $submit;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form')->with([
            'inputs' => $this->inputs,
            'data' => $this->data,
            'submit' => $this->submit
        ]);
    }
}

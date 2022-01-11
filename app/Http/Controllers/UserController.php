<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    private $inputs;

    public function __construct()
    {
        $this->inputs = [
            'name' => [
                'label' => 'Name',
                'type' => 'text',
                'required' => true
            ],
            'email' => [
                'label' => 'E-mail',
                'type' => 'text',
                'required' => true
            ],
            'password' => [
                'label' => 'Password',
                'type' => 'password',
                'required' => true
            ],
            'password_confirmation' => [
                'label' => 'Password confirmation',
                'type' => 'password',
                'required' => true
            ],
        ];
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $users = User::with(['orders', 'courses'])->where('id', '!=', Auth::id())->get();
        return view('users.index')->with(compact('users'));
    }

    public function create()
    {
        return view('users.create')->with([
            'inputs' => $this->inputs
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return redirect()->to(route('users.show', $user))->with([
            'message' => 'New user created.'
        ]);
    }

    public function show(User $user)
    {
        $courses = Course::all()->pluck('title', 'id');
        return view('users.show')->with(compact('user', 'courses'));
    }

    public function edit(User $user)
    {
        return view('users.edit')->with([
            'user' => $user,
            'inputs' => $this->inputs
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => ['present', 'confirmed']
        ]);
//        $request->validate();

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        return redirect()->back()->with([
            'message' => 'User was updated.'
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with([
            'message' => 'User was deleted.'
        ]);
    }

    public function enroll(User $user, Request $request)
    {
        $request->validate([
            'course_id' => 'required'
        ]);

        if ($user->courses->where('id', $request->course_id)->count() === 0) {
            DB::table('course_user')->insert([
                'course_id' => $request->course_id,
                'user_id' => $user->id
            ]);
        }

        return redirect()->back()->with([
            'message' => 'User was enrolled.'
        ]);
    }
}

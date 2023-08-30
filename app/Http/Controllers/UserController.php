<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
    public function index(Request $request)
    {
//        $users = User::with(['courses'])
//            ->where('id', '!=', Auth::id())
//            ->orderBy('id', 'desc')
//            ->paginate(25);

        $query = $request->get('search');

        $users = User::query();

        if ($query) {
            $users->where('name', 'LIKE', '%' . $query . '%')
                ->orWhere('email', 'LIKE', '%' . $query . '%')
                ->orWhere('id', 'LIKE', '%' . $query . '%');
        }

        $users = $users->with('courses')
            ->paginate(25)
            ->withQueryString();


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

        notify()->success("User $user->name was created.", 'Success');

        return redirect()->to(route('users.show', $user));
    }

    public function show(User $user)
    {
        $courses = Course::all()->pluck('title', 'id');
        $total_spent = $user->orders()->where('status', '=', 'success')->sum('price');
        $last_order_at = $user->orders->last() ? $user->orders->last()->created_at : null;
        $trackers = $user->trackers()->paginate(25)->withQueryString();

        return view('users.show')->with(compact('user', 'courses', 'total_spent', 'last_order_at', 'trackers'));
    }

    public function edit(User $user)
    {
        return view('users . edit')->with([
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

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        notify()->success("User $user->name was created.", 'Success');

        return redirect()->back();
    }

    public function destroy(User $user)
    {
        $user->delete();
        notify()->success("User was deleted.", 'Success');
        return redirect()->back();
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

        notify()->success("User was enrolled.", 'Success');

        return redirect()->back();
    }
}

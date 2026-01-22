<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\FileUploader;
use App\Models\User;
use App\Models\ZapierSetting;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */

    public function create($type = "student"): View
    {
        return view('auth.register', ['type' => $type]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'phone'    => 'required|string|max:50',
            'password' => ['required', Rules\Password::defaults()],

            // حقول المدرس
            'skills'   => 'nullable|string|max:255',
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'biography_file' => 'nullable|file|mimes:pdf,doc,docx|max:4096',
            'description' => 'nullable|string',
            'academic_degree' => 'nullable|string|max:255',
            'has_saudi_curriculum_experience' => 'nullable|boolean',
        ]);

        /* =========================
       تسجيل مدرس
    ========================= */
        if ($request->type === 'instructor') {

            $data = [
                'name'  => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'skills' => $request->skills,
                'about' => $request->description,

                'role' => 'instructor',
                'status' => 0, // بانتظار الموافقة
                'password' => Hash::make($request->password),
            ];

            /* صورة شخصية */
            if ($request->hasFile('photo')) {
                $path = 'uploads/users/instructor/photos/' .
                    time() . '_' . $request->photo->getClientOriginalName();

                $request->photo->move(public_path('uploads/users/instructor/photos'), basename($path));
                $data['photo'] = $path;
            }

            /* CV / Biography */
            if ($request->hasFile('biography_file')) {
                $path = 'uploads/users/instructor/cv/' .
                    time() . '_' . $request->biography_file->getClientOriginalName();

                $request->biography_file->move(public_path('uploads/users/instructor/cv'), basename($path));
                $data['biography'] = $path;
            }

            $user = User::create($data);

            $user->sendEmailVerificationNotification();

            Auth::login($user);
            Session::flash('success', get_phrase('Instructor registered successfully'));

            return redirect()->route('instructor.dashboard');
        }

        /* =========================
       تسجيل طالب
    ========================= */
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'student',
            'status'   => 1,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}

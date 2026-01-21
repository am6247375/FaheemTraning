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
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'phone' => 'required',
            'password' => ['required', Rules\Password::defaults()],
            'an_instructor' => 'nullable|boolean',
        ]);
        $anInstructor = $request->boolean('an_instructor');


        if ($anInstructor) {
            $data = [
                'name'        => $request->name,
                'about'       => $request->about,
                'phone'       => $request->phone,
                'address'     => $request->address,
                'email'       => $request->email,
                'facebook'    => $request->facebook,
                'twitter'     => $request->twitter,
                'website'     => $request->website,
                'linkedin'    => $request->linkedin,
                'paymentkeys' => json_encode($request->paymentkeys),
                'status'      => '1',
                'password'    => Hash::make($request->password),
                'role'        => 'instructor',
            ];

            if ($request->hasFile('photo')) {
                $path = "uploads/users/instructor/" . nice_file_name($request->name, $request->photo->extension());
                FileUploader::upload($request->photo, $path, 400, null, 200, 200);
                $data['photo'] = $path;
            }
            if ($request->email_verified == 1) {
                $data['email_verified_at'] = date('Y-m-d H:i:s');
            }
            $user = User::create($data);

            if ($request->email_verified != 1) {
                $user->sendEmailVerificationNotification();
            }

            Session::flash('success', get_phrase('Instructor added successfully'));

            // تسجيل الدخول تلقائياً بعد التسجيل (اختياري حسب رغبتك)
            Auth::login($user);

            return redirect()->route('admin.instructor.index');
        }

        // جزء الطالب (Student)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'student', // يفضل تحديد الـ role هنا أيضاً
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}

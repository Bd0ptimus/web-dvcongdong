<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Services\AuthService;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $authService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AuthService $authService)
    {
        // $this->middleware('guest');
        $this->authService = $authService;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function index(Request $request){
        if($request->isMethod('POST')){
            $validator = $this->authService->registerValidate($request->all());
            if ($validator->fails()) {
                //dd($validator);
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            } else {
                $user = User::where('username', '=', $request->username)->first();
                if(isset($user)){
                    return redirect()->back()->withErrors($validator->errors()->add('username', 'Username đã tồn tại, hãy chọn username khác'))->withInput($request->all());
                }

                $user = User::where('email', '=', $request->email)->first();
                if(isset($user)){
                    return redirect()->back()->withErrors($validator->errors()->add('email', 'Email đã tồn tại, hãy chọn email khác'))->withInput($request->all());
                }

                if(!str_contains($request->registerSubmit, '+')){
                    $validator->errors()->add('phone', 'Định dạng số điện thoại không đúng');
                    return redirect()->back()->withErrors($validator)->withInput($request->all());
                }
                $this->authService->createAccount($request, ROLE_USER);
                return view('auth.registerConfirm');

            }
        }
        return view('auth.register');
    }
}

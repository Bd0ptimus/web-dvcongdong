<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Services\AuthService;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
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
        $this->authService = $authService;
        // $this->middleware('guest')->except('logout');
    }

    public function index(Request $request){
        if($request->isMethod('POST')){
            $validator = $this->authService->loginValidate($request->all());
            if ($validator->fails()) {
                //dd($validator);
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            } else {
                $user = User::where('username', '=', $request->username)->first();
                if(isset($user)){
                    if(Hash::check($request->password, $user->password)){
                        Auth::guard('web')->attempt(['username'=>$request->username,'password'=>$request->password]);
                        // dd(Admin::user()->inRoles([ROLE_ADMIN]));
                        return redirect()->route('home');
                    }
                    return redirect()->back()->withErrors($validator->errors()->add('password', 'Mật khẩu không đúng'))->withInput($request->all());
                }
                return redirect()->back()->withErrors($validator->errors()->add('username', 'username không tồn tại'))->withInput($request->all());

            }
        }
        return view('auth.login');
    }
}

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
use App\Services\AttachmentService;
use App\Admin;

use Socialite;
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
    protected $attachmentService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AuthService $authService, AttachmentService $attachmentService)
    {
        $this->authService = $authService;
        $this->attachmentService = $attachmentService;
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
                        if($user->active == USER_SUSPENDED){
                            return view('warnings.accountSuspended');
                        }
                        Auth::guard('web')->attempt(['username'=>$request->username,'password'=>$request->password], $request->remember);
                        // dd(Admin::user()->inRoles([ROLE_ADMIN]));
                        // dd(Admin::user());
                        return redirect()->route('home');
                    }
                    return redirect()->back()->withErrors($validator->errors()->add('password', 'Mật khẩu không đúng'))->withInput($request->all());
                }
                return redirect()->back()->withErrors($validator->errors()->add('username', 'username không tồn tại'))->withInput($request->all());

            }
        }
        return view('auth.login');
    }

    public function googleLogin(Request $request){
        return Socialite::driver('google')->redirect();
    }

    public function googleLoginedCallback(Request $request){
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('auth/login');
        }

        $userOverLap = User::where('email', $user->email)->first();

        if($userOverLap){
            if($userOverLap->third_party_type == GOOGLE){
                Auth::login($userOverLap);
            }else{
                return view('warnings.accountExistedInDifferentType',['user'=>$userOverLap]);
            }
        }else{
            $data = $this->attachmentService->takeDownloadPicByUrl($user->avatar);
            // dd($data);
            $newUser= User::create([
                'name' => $user->name,
                'email' => $user->email,
                'user_avatar' => $data['avatar'],
                'user_role' => ROLE_USER,
                'username' =>  $data['name'],
                'password' => Hash::make($data['name']),
                'third_party_type' => GOOGLE,
                'active' => USER_ACTIVATED,
            ]);
            Auth::login($newUser);
        }
        return redirect()->route('home');
    }


    public function facebookLogin(Request $request){
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookLoginCallback(Request $request){
        try {
            $user = Socialite::driver('facebook')->user();
        } catch (\Exception $e) {
            return redirect('auth/login');
        }
        // dd($user);
        $userOverLap = User::where('email', $user->email)->first();

        if($userOverLap){
            if($userOverLap->third_party_type == FACEBOOK){
                Auth::login($userOverLap);
            }else{
                return view('warnings.accountExistedInDifferentType',['user'=>$userOverLap]);
            }
        }else{
            $data = $this->attachmentService->takeDownloadPicByUrl($user->avatar);
            // dd($data);
            $newUser= User::create([
                'name' => $user->name,
                'email' => $user->email,
                'user_avatar' => $data['avatar'],
                'user_role' => ROLE_USER,
                'username' =>  $data['name'],
                'password' => Hash::make($data['name']),
                'third_party_type' => FACEBOOK,
                'active' => USER_ACTIVATED,
            ]);
            Auth::login($newUser);
        }
        return redirect()->route('home');
    }
}

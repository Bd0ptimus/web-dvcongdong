<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        // dd('abc');
        return Socialite::driver('google')->redirect();
    }

    public function googleLoginedCallback(Request $request){
        // dd('abc');
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('auth/login');
        }

        $userOverLap = User::where('email', $user->email)->first();

        if($userOverLap){
            if($userOverLap->third_party_type == GOOGLE && $userOverLap['3_party_db_id'] == $user->id){
                Auth::login($userOverLap);
            }
            // else{
            //     return view('warnings.accountExistedInDifferentType',['user'=>$userOverLap]);
            // }
        }else{
            $data = $this->attachmentService->takeDownloadPicByUrl($user->avatar);
            // dd($data);
            $newUser= User::create([
                'name' => $user->name,
                'email' => $user->email,
                '3_party_db_id' => $user->id,
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
            Log::debug('error in take facebook user : ' . $e);
            return redirect('auth/login');
        }
        dd($user);
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




    // public function vkLogin(Request $request){
    //     $data=[
    //         env('VK_CLIENT_ID'),
    //         env('VK_CLIENT_SECRET'),
    //         route('auth.vk.vkLoginCallback')
    //     ];
    //     // dd($data);
    //     $url = 'https://oauth.vk.com/authorize';
    //     $data = ['client_id' => env('VK_CLIENT_ID'),
    //             'client_secret'=>env('VK_CLIENT_SECRET'),
    //             'response_type' => 'code',
    //             'redirect_uri'=>route('auth.vk.vkLoginCallback')];

    //     // use key 'http' even if you send the request to https://...
    //     $options = array(
    //         'http' => array(
    //             'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
    //             'method'  => 'POST',
    //             'content' => http_build_query($data)
    //         )
    //     );
    //     $context  = stream_context_create($options);
    //     $result = file_get_contents($url, false, $context);
    //     if ($result === FALSE) { /* Handle error */ }

    //     dd($result);

    //     // return Socialite::driver('vk')->redirect();
    // }

    // public function vkLoginCallback(Request $request){
    //     dd($request);
    //     try {
    //         $user = Socialite::driver('vk')->user();
    //     } catch (\Exception $e) {
    //         Log::debug('error in take vk user : ' . $e);
    //         return redirect('auth/login');
    //     }
    //     dd($user);
    //     $userOverLap = User::where('email', $user->email)->first();

    //     if($userOverLap){
    //         if($userOverLap->third_party_type == VK){
    //             Auth::login($userOverLap);
    //         }else{
    //             return view('warnings.accountExistedInDifferentType',['user'=>$userOverLap]);
    //         }
    //     }else{
    //         $data = $this->attachmentService->takeDownloadPicByUrl($user->avatar);
    //         // dd($data);
    //         $newUser= User::create([
    //             'name' => $user->name,
    //             'email' => $user->email,
    //             'user_avatar' => $data['avatar'],
    //             'user_role' => ROLE_USER,
    //             'username' =>  $data['name'],
    //             'password' => Hash::make($data['name']),
    //             'third_party_type' => VK,
    //             'active' => USER_ACTIVATED,
    //         ]);
    //         Auth::login($newUser);
    //     }
    //     return redirect()->route('home');
    // }



    public function zaloLogin(Request $request){
        // dd('abc');
        return Socialite::driver('zalo')->redirect();
    }

    public function zaloLoginedCallback(Request $request){
        // dd('abc');
        try {
            $user = Socialite::driver('zalo')->user();
        } catch (\Exception $e) {
            return redirect('auth/login');
        }
        // dd($user);

        $userOverLap = User::where('3_party_db_id', $user->id)->first();

        if($userOverLap){
                if ($userOverLap->third_party_type == ZALO) {
                    Auth::login($userOverLap);
                }
            // }else{
            //     return view('warnings.accountExistedInDifferentType',['user'=>$userOverLap]);
            // }
        }else{
            $data = $this->attachmentService->takeDownloadPicByUrl($user->avatar);
            // dd($data);
            $newUser= User::create([
                'name' => $user->name,
                // 'email' => $user->email,
                '3_party_db_id'=>$user->id,
                'user_avatar' => $data['avatar'],
                'user_role' => ROLE_USER,
                'username' =>  $data['name'],
                'password' => Hash::make($data['name']),
                'third_party_type' => ZALO,
                'active' => USER_ACTIVATED,
            ]);
            Auth::login($newUser);
        }
        return redirect()->route('home');
    }
}

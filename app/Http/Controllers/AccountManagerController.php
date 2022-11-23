<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;

//Models
use App\Models\User;

//services
use App\Services\AdminService;
use App\Services\AuthService;

class AccountManagerController extends Controller
{
    protected $adminService;
    protected $authService;
    public function __construct(AdminService $adminService,
    AuthService $authService){
        $this->middleware('user.auth');
        $this->middleware('admin.permission');
        $this->adminService=$adminService;
        $this->authService=$authService;
    }

    public function index(Request $request){
        // if(Admin::user() !==null && !Admin::user()->inRoles([ROLE_ADMIN, ROLE_SUPER_ADMIN])){
        //     return view('warnings.notPermissionToAccessPage');
        // }
        $data = $this->adminService->takeAllForAccountManager();
        return view('accounts.accountManager',[
            'admins' => $data['adminsAcc'],
            'users'=>$data['usersAcc']
        ]);
    }

    public function changeAction(Request $request){
        try{
            $this->adminService->changeAccountAction(request('userId'), request('actionStatus'));

        }catch(\Exception $e){
            response()->json(['error' => 1, 'msg' => 'Đã có lỗi']);
        }
        return response()->json(['error' => 0, 'msg' => 'change action thành công', ]);
    }

    public function createAccount(Request $request, $accountType){
        if ($request ->isMethod('POST')){
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
                    return redirect()->back()->withErrors($validator->errors()->add('email', 'Email đã tồn tại, hãy chọn username khác'))->withInput($request->all());
                }
                $this->authService->createAccount($request, $accountType);
                return view('accounts.createAccountCompleteConfirm');

            }
        }
        return view('accounts.createAccount',['accountType'=>$accountType]);
    }
}

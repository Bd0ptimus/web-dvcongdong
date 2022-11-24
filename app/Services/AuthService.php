<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Str;
use Carbon\Carbon;

//model

//repo
use App\Repositories\UserRepository;

use Exception;
class AuthService
{
    protected $userRepo;

    public function __construct(UserRepository $userRepo){
        $this->userRepo = $userRepo;
    }

    public function loginValidate($request){
        $messages = [
            'required' => ':attribute bắt buộc phaỉ được nhập.',
            'min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'username.max' => 'Email chỉ có tối đa 255 ký tự',
            'password.max' => 'Mật khẩu chỉ có tối đa 255 ký tự',
            'regex' => 'Mật khẩu phải bao gồm ký tự viết hoa, ký tự viết thường, số'

        ];

        $validator = Validator::make($request, [
            'username'    => 'required|max:255',
            'password' => [
                'required',
                'min:8',
                'max:255',
                'regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/',
            ],

        ], $messages);

        return $validator;
    }


    public function registerValidate($request){
        $messages = [
            'required' => ':attribute bắt buộc phải được nhập.',
            'min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'username.max' => 'Email chỉ có tối đa 255 ký tự',
            'password.max' => 'Mật khẩu chỉ có tối đa 255 ký tự',
            'regex' => 'Mật khẩu phải bao gồm ký tự viết hoa, ký tự viết thường, số',
            'email'    => ':attribute không đúng định dạng',
            'email.max' => 'Email chỉ có tối đa 255 ký tự',
            'confirmed' => 'Mật khẩu xác nhận không trùng khớp',
        ];

        $validator = Validator::make($request, [
            'username'    => 'required|max:255',
            'email'    => 'required|email|max:255',
            'password' => [
                'required',
                'min:8',
                'max:255',
                'regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/',
                'confirmed'
            ],
            'password_confirmation' => 'required|min:8',
            'phone' => 'required',
        ], $messages);

        return $validator;
    }

    public function createAccount($data, $accountType){
        $this->userRepo->addNewUser($data,  $accountType);
    }

}

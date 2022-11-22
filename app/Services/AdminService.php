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
class AdminService
{
    protected $userRepo;

    public function __construct(UserRepository $userRepo){
        $this->userRepo = $userRepo;
    }

    public function takeAllForAccountManager(){
        $data['adminsAcc'] = $this->userRepo->findAccountsWithCondition('user_role', ROLE_ADMIN);
        $data['usersAcc'] = $this->userRepo->findAccountsWithCondition('user_role', ROLE_USER);
        return $data;
    }


    public function changeAccountAction($userId, $actionStatus){
        $this->userRepo->changeAccountActionStatus($userId, $actionStatus);
    }




}

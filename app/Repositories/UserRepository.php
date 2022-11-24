<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;
//use Your Model
use App\Admin;

use App\Models\User;
/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository
{
    protected $model;
    public function __construct(User $model)
    {
        $this->model = $model;
    }
    /**
     * @return string
     *  Return the model
     */


    public function addNewUser($data,  $accountType){
        $this->model->create([
            'username'=>$data->username,
            'name' => $data->name,
            'email' => $data->email,
            'password' =>Hash::make($data->password),
            'user_role'=>$accountType,
            'active'=>USER_ACTIVATED,
            'phone_number' =>$data->registerSubmit,
        ]);
    }


    public function findAccountsWithCondition($column, $condition){
        return $this->model->where($column, $condition)->get();
    }

    public function changeAccountActionStatus($userId, $actionStatus){
        $this->model->where('id', $userId)->update([
            'active'=>$actionStatus,
        ]);
    }

    public function isUser($userId){
        $user = $this->model->where('id', $userId)->where('active', USER_ACTIVATED)->first();
        if(isset($user)){
            return $user->user_role == ROLE_USER;
        }
        return false;
    }

}

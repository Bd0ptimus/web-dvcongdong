<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

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

    public function updateUserAvatar($userId, $avatarPath){
        $user =  $this->model->where('id', $userId)->first();
        if(File::exists(public_path($user->user_avatar))){
            File::delete(public_path($user->user_avatar));
        }
        $this->model->where('id', $userId)->update([
            'user_avatar'=>$avatarPath,
        ]);
    }

    public function updateDescription($userId, $des){
        $this->model->where('id', $userId)->update([
            'user_description' => $des,
        ]);
    }

    public function updateMainInfo($userId, $request){
        $user = $this->model->where('id', $userId)->first();
        if($user->email == null ||$user->email=='' ){
            $user->update([
                'name' => $request->userInfoName,
                'phone_number' => $request -> userInfoPhone,
                'email'=>$request->userInfoEmail,
            ]);
        }else{
            $user->update([
                'name' => $request->userInfoName,
                'phone_number' => $request -> userInfoPhone,
            ]);
        }


    }

    public function checkUserPassword($userId, $oldPassword){
        $user =  $this->model->where('id', $userId)->first();
        if(Hash::check($oldPassword, $user->password)){
            return true;
        }
        return false;

    }

    public function updateUserPassword($userId,$newPassword){
        $this->model->where('id', $userId)->update([
            'password' => Hash::make($newPassword),
        ]);
    }

    public function searchUser($searchText){
        if($searchText == '') {
            return 0;
        }
        $query = $this->model;
        $findWithName = $query->where('name','LIKE','%'. $searchText.'%')->get();
        if(count($findWithName)!=0){
            return $findWithName;
        }

        $findWithUsername = $query->where('username','LIKE','%'. $searchText.'%')->get();
        if(count($findWithUsername)!=0){
            return $findWithUsername;
        }

        $findWithEmail = $query->where('email','LIKE', '%'.$searchText.'%')->get();
        if(count($findWithEmail)!=0){
            return $findWithEmail;
        }

        if(is_numeric($searchText)){
            $searchText = substr($searchText, 1);
        }
        $findWithPhone = $query->where('phone_number','LIKE','%'. $searchText.'%')->get();
        if(count($findWithPhone)!=0){
            return $findWithPhone;
        }

        return 0;
    }


}

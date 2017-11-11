<?php

namespace App\Http\Controllers\Auth;

use App\CollectionClassification;
use App\FollowClassification;
use App\Role;
use App\User;
use App\Http\Controllers\Controller;
use App\UserMessage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home/p/index';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->active = 0;
        $user->save();

        $adminUserMessage = new UserMessage();
        $adminUserMessage->pic = 'images/upload/default.png';
        $adminUserMessage->sex = 0;
        $adminUserMessage->introduction = 'hello!'.$user->name;
        $adminUserMessage->user_id = $user->id;
        $adminUserMessage->save();

        $adminFollowClassification = new FollowClassification();
        $adminFollowClassification->name = '默认';
        $adminFollowClassification->user_id = $user->id;
        $adminFollowClassification->save();

        $collectionFollowClassification = new CollectionClassification();
        $collectionFollowClassification->name = '默认';
        $collectionFollowClassification->user_id = $user->id;
        $collectionFollowClassification->save();
        
        $roles = Role::whereIn('id', [18,19,20,21,22,23,24])
            ->get();
        foreach ($roles as $role) {
            $user->attachRole($role);
        }

        return $user;
    }
}

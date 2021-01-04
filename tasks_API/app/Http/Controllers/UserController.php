<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\SharedTask;

class UserController extends Controller
{


    public function register(Request $request)
    {
        $input = $request->all();
        print_r($input);
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        return $user;
    }


    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            $user = Auth::user();
            $data['token'] = $user->createToken(env('TOKEN_KEYWORD'))->accessToken;
            $data['user'] = $user;
            return response()->json(['success' => true, 'data' => $data, 'error' => false], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Wrong username or password'], 401);
        }
    }
    public function logout(Request $request)
    {
        Auth::user()->token()->delete();
    }


    public function getUsers(Request $request)
    {
        return User::all();
    }

    //Get all users except for the current user with indication about shared/not shared of current task
    public function getAllUsers(Request $request)
    {
        //Extract the paramenters
        $user_id = $request->input('user_id');
        $task_id = $request->input('task_id');

        //Get all the users except for the current user:
        $users = User::where('id', '<>', $user_id)->get();

        //Get the shared tasks existing for other users:
        $shared_tasks = SharedTask::where('user_id', '<>', $user_id)
            ->where('task_id', '=', $task_id)->get();

        //Add is_shared property for each user and set it based on the shared_tasks list
        foreach ($users as $user) {
            $user->is_shared = 0;
            foreach ($shared_tasks as $shared_task) {

                if ($user->id == $shared_task->user_id) {
                    $user->is_shared = 1;
                }
            }
        }
        return $users;
    }
}




        //Auth::logout();
        //print_r('mm'); die();



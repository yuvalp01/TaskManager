<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\SharedTask;
use App\Models\Task;

class SharedTaskController extends Controller
{

    public function index()
    {
        return SharedTask::all();

    }

    public function share(Request $request) //user_id , task_id
    {

        //Make sure required field sent
        $messages = array();
        $validator = Validator::make($request->input(), [
            'task_id' => 'required|exists:tasks,id',
            'user_id' => 'required|exists:users,id'
        ], $messages);


        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->first(),
                'success' => false
            ]);
        }
///

//Extract the fields from the requests and get the shared task if exists
        $user_id = $request->input('user_id');
        $task_id = $request->input('task_id');

        $shared_tasks =  SharedTask::where('user_id', $user_id)
            ->where('task_id', $task_id)
            ->get();

//Only if not exist, we can add it to the table
        if ($shared_tasks->count() == 0) {
            //Add new line to 
            SharedTask::create($request->all()); 
            //And update the task row with the new status to show (blue or red in the UI)
            $task = Task::find($task_id);
            $task->is_shared = true;
            $task->save();

            return $task;
        } else {
            return response()->json(['error' => true, 'message' => 'Task is already shared'], 404);
        }
    }




    public function unshare(Request $request) //user_id , task_id
    {

        //Make sure required field sent
        // $this->validateParams($request);
        $messages = array();
        $validator = Validator::make($request->input(), [
            'task_id' => 'required|exists:tasks,id',
            'user_id' => 'required|exists:users,id'
        ], $messages);


        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->first(),
                'success' => false
            ]);
        }

        $user_id = $request->input('user_id');
        $task_id = $request->input('task_id');
//Extract the fields from the requests and delete it
        $shared_task =  SharedTask::where('user_id', $user_id)
            ->where('task_id', $task_id)
            ->delete();
//Check if there are still more shares on this task after the delete:
        $shared_tasks_count =  SharedTask::where('task_id', $task_id)
            ->count();

//And update the task accodingly (if it should have color or not)
        $task = Task::find($task_id);

        if ($shared_tasks_count > 0) {
            $task->is_shared = 1;
        } else {
            $task->is_shared = 0;
        }
        $task->save();
    }
}

    // private function validateParams($request)
    // {
    //     print_r($request);
    //     $messages = array();
    //     $validator = Validator::make($request->input(), [
    //         'task_id' => 'required|exists:tasks,id',
    //         'user_id' => 'required|exists:users,id'
    //     ], $messages);


    //     if ($validator->fails()) {
    //         return response()->json([
    //             'error' => true,
    //             'message' => $validator->errors()->first(),
    //             'success' => false
    //         ]);
    //     } 
    // }




    //0: if exists throuh
    //TODO 1 : add a new  shared task row
    //2 update the task is_shared
    // return Task::create($request->all());

        // echo $task_id;
        // print_r($task);
        // die();
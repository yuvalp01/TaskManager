<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\SharedTask;
use App\Models\Summary;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class TaskController extends Controller
{
    //(for testing purposes)
    public function index()
    {
        return Task::all();
    }

    public function showUserTasks($user_id)
    {
        //Get the user's tasks
        $selfTasks =  DB::table('tasks')
            ->select(
                'tasks.id',
                'tasks.user_id',
                'tasks.title',
                'tasks.is_shared',
                'tasks.is_done'
            )
            ->where('user_id', '=', $user_id);

        //Get tasks that were shared with the user
        $sharedTasks =  DB::table('tasks')
            ->select(
                'tasks.id',
                'tasks.user_id',
                'tasks.title',
                'tasks.is_shared',
                'tasks.is_done'
            )
            ->join('shared_tasks', 'shared_tasks.task_id', '=', 'tasks.id')
            ->where('shared_tasks.user_id', '=', $user_id);

        //Combine the two
        $allTasks = $selfTasks->union($sharedTasks)->get();

        $total = $allTasks->count();
        $done = $allTasks->where('is_done','=',1)->count();
        // $not_done = $total-$done;

        $summary = new Summary;
        $summary->tasks = $allTasks;
        $summary->total = $total;
        $summary->done = $done;
        $summary->not_done = $total-$done;

        return $summary;
    }

    public function add(Request $request)
    {
        return Task::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update($request->all());
        return $task;
    }

    public function delete(Request $request, $id)
    {
        //If I had more time, I'd put it in a transaction or cascading delete to make sure it's all or nothing
        $task = Task::findOrFail($id);
        $task->delete();
        //Delete also the shared task table if exists
        $shared_tasks =  SharedTask::where('task_id', $id);
        if($shared_tasks->get()->count()>0)
        {
            $shared_tasks->delete();
        }

        return 204;
    }


}

 
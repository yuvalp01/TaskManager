<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\SharedTask;
use App\Models\Summary;


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
        $selfTasks =  Task::where('user_id', $user_id)
            ->select(
                'tasks.id',
                'tasks.user_id',
                'tasks.title',
                'tasks.is_shared',
                'tasks.is_done'
            );
        //Get tasks that are shared with the users
        $sharedTasks = Task::where('shared_tasks.user_id', $user_id)
            ->select(
                'tasks.id',
                'tasks.user_id',
                'tasks.title',
                'tasks.is_shared',
                'tasks.is_done'
            )
            ->join('shared_tasks', 'shared_tasks.task_id', '=', 'tasks.id');

        //Combine the two
        $allTasks = $selfTasks->union($sharedTasks)->get();

        //Clac statistics
        $total = $allTasks->count();
        $done = $allTasks->where('is_done', 1)->count();

        $summary = new Summary;
        $summary->tasks = $allTasks;
        $summary->total = $total;
        $summary->done = $done;
        $summary->not_done = $total - $done;

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
        $task = Task::findOrFail($id);
        $task->delete();
        //Delete also the shared task table if exists
        $shared_tasks =  SharedTask::where('task_id', $id);
        if ($shared_tasks->get()->count() > 0) {
            $shared_tasks->delete();
        }

        return 204;
    }


    public function restoreAll()
    {
        Task::onlyTrashed()
            ->restore();
        return 204;
    }
    public function hardDelete()
    {
        Task::onlyTrashed()
            ->forceDelete();
        return 204;
    }
}

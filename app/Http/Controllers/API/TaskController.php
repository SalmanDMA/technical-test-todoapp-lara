<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\CommonTrait;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    use CommonTrait;

    public function index()
    {
        $tasks = Task::all();

        return $this->sendResponse($tasks, 'Tasks retrieved successfully.');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|string|in:low,medium,high',
        ]);

        if ($validator->fails()) {
            return $this->failsValidate($validator->errors());
        }

        $request['user_id'] = auth()->user()->id;

        $task = Task::create($request->all());
        return $this->sendResponse($task, 'Task created successfully.');
    }

    public function show($id)
    {
        $task = Task::find($id);

        if (is_null($task)) {
            return $this->sendError('Task not found.');
        }

        return $this->sendResponse($task, 'Task retrieved successfully.');
    }

    public function update(Request $request, $id)
    {

        $task = Task::find($id);

        if (is_null($task)) {
            return $this->sendError('Task not found.');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|string|in:low,medium,high',
        ]);

        if ($validator->fails()) {
            return $this->failsValidate($validator->errors());
        }

        $request['user_id'] = auth()->user()->id;

        $task->update($request->all());

        return $this->sendResponse($task, 'Task updated successfully.');
    }

    public function update_status_complete(Request $request, $id)
    {
        $task = Task::find($id);

        if (is_null($task)) {
            return $this->sendError('Task not found.');
        }

        $task->update([
            'completed' => true,
        ]);

        return $this->sendResponse($task, 'Task updated successfully.');
    }

    public function update_status_uncomplete(Request $request, $id)
    {
        $task = Task::find($id);

        if (is_null($task)) {
            return $this->sendError('Task not found.');
        }

        $task->update([
            'completed' => false,
        ]);

        return $this->sendResponse($task, 'Task updated successfully.');
    }

    public function destroy($id)
    {
        $task = Task::find($id);

        if (is_null($task)) {
            return $this->sendError('Task not found.');
        }

        $task->delete();

        return $this->sendResponse($task, 'Task deleted successfully.');
    }
}

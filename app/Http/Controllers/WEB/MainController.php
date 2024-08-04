<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiHelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    use ApiHelperTrait;

    public function __construct()
    {
        $this->initializeApiHelper();
    }

    public function index()
    {
        $data_login = $this->isAuthorized();

        if (!$data_login) {
            return redirect()->route('v_login');
        }

        $response = $this->fetchData('/api/v1/tasks');
        $tasks = collect($response->data ?? []);

        return view('welcome', [
            'tasks' => $tasks,
            'token' => session('token'),
            'csrf' => csrf_token(),
        ]);
    }

    public function store(Request $request)
    {
        $data_login = $this->isAuthorized();

        if (!$data_login) {
            return redirect()->route('v_login');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'nullable|boolean',
            'due_date' => 'nullable|date',
            'priority' => 'required|string|in:low,medium,high',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $response = $this->postData('/api/v1/tasks', $request->all(), 'json', true);

        if ($response->success) {
            return redirect()->route('home')->with('success', $response->message);
        }

        return redirect()->back()->withInput()->with('error', $response->message);
    }

    public function update(Request $request, $id)
    {
        $data_login = $this->isAuthorized();

        if (!$data_login) {
            return redirect()->route('v_login');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'nullable|boolean',
            'due_date' => 'nullable|date',
            'priority' => 'required|string|in:low,medium,high',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $response = $this->putData('/api/v1/tasks/' . $id, $request->all(), 'json', true);

        if ($response->success) {
            return redirect()->route('home')->with('success', $response->message);
        }

        return redirect()->back()->withInput()->with('error', $response->message);
    }

    public function destroy($id)
    {
        $data_login = $this->isAuthorized();

        if (!$data_login) {
            return redirect()->route('v_login');
        }

        $response = $this->deleteData('/api/v1/tasks/' . $id);

        if ($response->success) {
            return redirect()->route('home')->with('success', $response->message);
        }

        return redirect()->back()->withInput()->with('error', $response->message);
    }

    public function multiple_complete(Request $request)
    {
        $data_login = $this->isAuthorized();

        if (!$data_login) {
            return redirect()->route('v_login');
        }

        $request->merge(['ids' => json_decode($request->ids, true)]);

        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $responses = [];
        foreach ($request->ids as $id) {
            $response = $this->putData('/api/v1/tasks/' . $id . '/complete', [], 'json', true);
            $responses[] = $response;
        }

        $success = true;
        $message = '';

        foreach ($responses as $response) {
            if (!$response->success) {
                $success = false;
                $message = $response->message;
                break;
            }
        }

        if ($success) {
            $message = 'Tasks marked as completed successfully!';
            return redirect()->route('home')->with('success', $message);
        }

        return redirect()->back()->withInput()->with('error', $message);
    }

    public function multiple_uncomplete(Request $request)
    {
        $data_login = $this->isAuthorized();

        if (!$data_login) {
            return redirect()->route('v_login');
        }

        $request->merge(['ids' => json_decode($request->ids, true)]);

        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $responses = [];
        foreach ($request->ids as $id) {
            $response = $this->putData('/api/v1/tasks/' . $id . '/uncomplete', [], 'json', true);
            $responses[] = $response;
        }

        $success = true;
        $message = '';

        foreach ($responses as $response) {
            if (!$response->success) {
                $success = false;
                $message = $response->message;
                break;
            }
        }

        if ($success) {
            $message = 'Tasks marked as uncompleted successfully!';
            return redirect()->route('home')->with('success', $message);
        }

        return redirect()->back()->withInput()->with('error', $message);
    }

    public function multiple_delete(Request $request)
    {
        $data_login = $this->isAuthorized();

        if (!$data_login) {
            return redirect()->route('v_login');
        }

        $request->merge(['ids' => json_decode($request->ids, true)]);

        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $responses = [];
        foreach ($request->ids as $id) {
            $response = $this->deleteData('/api/v1/tasks/' . $id);
            $responses[] = $response;
        }

        $success = true;
        $message = '';

        foreach ($responses as $response) {
            if (!$response->success) {
                $success = false;
                $message = $response->message;
                break;
            }
        }

        if ($success) {
            $message = 'Tasks deleted successfully!';
            return redirect()->route('home')->with('success', $message);
        }

        return redirect()->back()->withInput()->with('error', $message);
    }
}

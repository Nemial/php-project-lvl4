<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStatusStoreRequest;
use App\Models\Task;
use App\Models\TaskStatus;

class TaskStatusController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $taskStatuses = TaskStatus::paginate();
        return view('task_status.index', compact('taskStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $taskStatus = new TaskStatus();
        return view('task_status.create', compact('taskStatus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TaskStatusStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TaskStatusStoreRequest $request)
    {
        $data = $request->validated();
        $taskStatus = new TaskStatus();
        $taskStatus->fill($data);
        $taskStatus->save();
        flash(__('flash.task_status.stored'))->success();
        return redirect()->route('task_statuses.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\TaskStatus $taskStatus
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(TaskStatus $taskStatus)
    {
        return view('task_status.edit', compact('taskStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TaskStatusStoreRequest $request
     * @param \App\Models\TaskStatus $taskStatus
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TaskStatusStoreRequest $request, TaskStatus $taskStatus)
    {
        $data = $request->validated();
        $taskStatus->fill($data);
        $taskStatus->save();
        flash(__('flash.task_status.edited'))->success();
        return redirect()->route('task_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\TaskStatus $taskStatus
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(TaskStatus $taskStatus)
    {
        if (Task::where('status_id', $taskStatus->id)->exists()) {
            flash(__('flash.task_status.used'))->error();
            return redirect()->route('task_statuses.index');
        }
        $taskStatus->delete();
        flash(__('flash.task_status.destroyed'))->success();
        return redirect()->route('task_statuses.index');
    }
}

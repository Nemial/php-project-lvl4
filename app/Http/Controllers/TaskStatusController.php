<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $taskStatuses = TaskStatus::paginate();
        return view('task_status.index', ['taskStatuses' => $taskStatuses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $taskStatus = new TaskStatus();
        return view('task_status.create', ['taskStatus' => $taskStatus]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $this->validate(
            $request,
            [
                'name' => 'required'
            ]
        );
        $taskStatus = new TaskStatus();
        $taskStatus->fill($data);
        $taskStatus->save();
        return redirect()->route('task_statuses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\TaskStatus $taskStatus
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(TaskStatus $taskStatus)
    {
        return view('task_status.show', ['taskStatus' => $taskStatus]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\TaskStatus $taskStatus
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(TaskStatus $taskStatus)
    {
        return view('task_status.edit', ['taskStatus' => $taskStatus]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TaskStatus $taskStatus
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, TaskStatus $taskStatus)
    {
        $data = $this->validate(
            $request,
            [
                'name' => 'required'
            ]
        );
        $taskStatus->fill($data);
        $taskStatus->save();
        flash('Status has been edited')->success();
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
        $taskStatus->delete();
        flash('Status has been deleted')->success();
        return redirect()->route('task_statuses.index');
    }
}

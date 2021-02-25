<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = QueryBuilder::for(Task::class)->allowedFilters(
            [
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id')
            ]
        )->paginate();
        $statuses = Task::leftJoin('task_statuses', 'tasks.status_id', '=', 'task_statuses.id')->select(
            'task_statuses.id as status_id',
            'task_statuses.name as status_name'
        )->distinct()->pluck('status_name', 'status_id');
        $executors = Task::leftJoin('users', 'tasks.assigned_to_id', '=', 'users.id')->select(
            'users.id as executor_id',
            'users.name as executor_name'
        )->distinct()->pluck('executor_name', 'executor_id');
        $authors = Task::leftJoin('users', 'tasks.created_by_id', '=', 'users.id')->select(
            'users.id as author_id',
            'users.name as author_name'
        )->distinct()->pluck('author_name', 'author_id');
        return view(
            'task.index',
            ['tasks' => $tasks, 'authors' => $authors, 'executors' => $executors, 'statuses' => $statuses]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task();
        $statuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');
        return view('task.create', ['task' => $task, 'statuses' => $statuses, 'users' => $users, 'labels' => $labels]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TaskStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(TaskStoreRequest $request)
    {
        $data = $request->validated();
        $data['created_by_id'] = $request->user()->id;
        $task = new Task();
        $task->fill($data);
        $task->save();

        if ($request->exists('labels')) {
            $labels = $request->input('labels');
            collect($labels)->map(
                function ($labelId) use ($task) {
                    DB::table('task_label')->insert(['task_id' => $task->id, 'label_id' => $labelId]);
                }
            );
        }

        flash('Task has been stored')->success();
        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Task $task
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('task.show', ['task' => $task]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Task $task
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $statuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');
        return view('task.edit', ['task' => $task, 'statuses' => $statuses, 'users' => $users, 'labels' => $labels]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TaskStoreRequest $request
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(TaskStoreRequest $request, Task $task)
    {
        $data = $request->validated();
        $task->fill($data);
        $task->save();
        if ($request->exists('labels')) {
            $updatedLabels = $request->input('labels');
            $oldLabel = $task->labels()->pluck('label_id');
            $newLabel = array_diff($updatedLabels, $oldLabel->toArray());
            if (!empty($newLabel)) {
                collect($newLabel)->map(
                    function ($labelId) use ($task) {
                        DB::table('task_label')->insert(['task_id' => $task->id, 'label_id' => $labelId]);
                    }
                );
            }
            DB::table('task_label')->whereNotIn('label_id', $updatedLabels)->delete();
        }

        flash('Task has been edited')->success();
        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Task $task)
    {
        $task->delete();
        flash('Task has been destroyed')->success();
        return redirect()->route('tasks.index');
    }
}

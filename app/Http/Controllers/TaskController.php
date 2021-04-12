<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tasks = QueryBuilder::for(Task::class)->allowedFilters(
            [
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id')
            ]
        )->paginate();
        $statuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $filter = $request->input('filter', []);
        return view('task.index', compact('tasks', 'users', 'statuses', 'filter'));
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
        return view('task.create', compact('task', 'statuses', 'users', 'labels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $data = $this->validate(
            $request,
            [
                'name' => 'required|string',
                'description' => 'max:1000|string|nullable',
                'status_id' => 'required|integer',
                'assigned_to_id' => 'integer'
            ]
        );
        $user = Auth::user();
        $haveUser = !is_null($user);
        if ($haveUser) {
            $data['created_by_id'] = $user->id;
            $task = new Task();
            $task->fill($data);
            $task->save();

            if ($request->exists('labels')) {
                $labels = $request->input('labels');
                collect($labels)->map(
                    fn($labelId) => $task->labels()->attach($labels)
                );
            }

            flash(__('flash.task.stored'))->success();
            return redirect()->route('tasks.index');
        } else {
            throw new \Exception('User not authorized');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Task $task
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('task.show', compact('task'));
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
        return view('task.edit', compact('task', 'statuses', 'users', 'labels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Task $task)
    {
        $data = $this->validate(
            $request,
            [
                'name' => 'required|string',
                'description' => 'max:1000|string|nullable',
                'status_id' => 'required|integer',
                'assigned_to_id' => 'integer'
            ]
        );
        $task->fill($data);
        $task->save();
        $allLabelIds = $task->labels()->pluck('label_id');
        if ($request->exists('labels')) {
            $updatedLabelsIds = $request->input('labels');
            $newLabelIds = array_diff($updatedLabelsIds, $allLabelIds->toArray());
            $removeLabelIds = array_diff($allLabelIds->toArray(), $updatedLabelsIds);
            if (count($newLabelIds) > 0) {
                collect($newLabelIds)->map(
                    fn($labelId) => $task->labels()->attach($labelId)
                );
            }
                $task->labels()->detach($removeLabelIds);
        } else {
            $task->labels()->detach($allLabelIds->toArray());
        }

        flash(__('flash.task.edited'))->success();
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
        $this->authorize('delete', $task);
        $task->delete();
        flash(__('flash.task.destroyed'))->success();
        return redirect()->route('tasks.index');
    }
}

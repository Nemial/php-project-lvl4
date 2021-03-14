<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabelStoreRequest;
use App\Models\Label;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $labels = Label::paginate();
        return view('label.index', ['labels' => $labels]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $label = new Label();
        return view('label.create', ['label' => $label]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LabelStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LabelStoreRequest $request)
    {
        $data = $request->validated();
        $label = new Label();
        $label->fill($data);
        $label->save();
        flash(__('flash.label.stored'))->success();
        return redirect()->route('labels.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Label $label
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Label $label)
    {
        return view('label.show', ['label' => $label]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Label $label
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Label $label)
    {
        return view('label.edit', ['label' => $label]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param LabelStoreRequest $request
     * @param \App\Models\Label $label
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(LabelStoreRequest $request, Label $label)
    {
        $data = $request->validated();
        $label->fill($data);
        $label->save();
        flash(__('flash.label.edited'))->success();
        return redirect()->route('labels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Label $label
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Label $label)
    {
        if (\DB::table('task_label')->where('label_id', $label->id)->exists()) {
            flash(__('flash.label.used'))->error();
            return redirect()->route('labels.index');
        }
        $label->delete();
        flash(__('flash.label.destroyed'))->success();
        return redirect()->route('labels.index');
    }
}

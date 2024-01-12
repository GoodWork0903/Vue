<?php

namespace App\Http\Controllers;


use App\Http\Requests\LockRequest;
use App\Models\Lock;

class LockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('locks.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LockRequest $request)
    {
        // duplicate lock title check
        $duplicate_title = Lock::where('title', $request->get('title'))
            ->first();
        if (count($duplicate_title) > 0)
        {
            session()->flash('messageError', 'Такой замок уже существует!');
            return redirect()->back();
        }
        else
        {
            Lock::create($request->all());
            session()->flash('message', 'Замок создан');
        }

        return redirect()->route('lock.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lock  $lock
     * @return \Illuminate\Http\Response
     */
    public function edit($lock_id)
    {
        $lock = Lock::findOrFail($lock_id);
        return view('locks.edit', compact('lock'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lock  $lock
     * @return \Illuminate\Http\Response
     */
    public function update(LockRequest $request, $lock_id)
    {
        Lock::findOrFail($lock_id)->update($request->all());

        session()->flash('message', 'Замок обновлен');
        return redirect()->back();
    }

    //=ajax - for getting all locks
    public function locks()
    {
        $locks = Lock::latest()
            ->paginate(10);

        return compact('locks');
    }

    //=ajax - for showing lock - by lock_id
    public function show($lock_id)
    {
        $lock = Lock::findOrFail($lock_id);

        return compact('lock');
    }

    //ajax - delete lock by lock_id
    public function destroy($lock_id)
    {
        Lock::destroy($lock_id);

        return response()->json([
            'message' => 'Сотрудник удален!'
        ]);
    }
}

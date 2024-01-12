<?php

namespace App\Http\Controllers;

use App\Http\Requests\KeyRequest;
use App\Models\Employee;
use App\Models\Key;

class KeyController extends Controller
{
    //ajax - displaying all keys by lock_id
    public function index($lock_id)
    {
        $keys = Key::where('lock_id', $lock_id)
            ->latest()
            ->paginate(10);

        return compact('keys');
    }

    //ajax - key store
    public function store(KeyRequest $request)
    {

        Key::create($request->all());

        return response()->json([
            'message' => 'Ключ создан'
        ]);
    }

    //ajax - key destroy
    public function destroy($key_id)
    {
        $key = Key::findOrFail($key_id);
        $key->delete();

        return response()->json([
            'message' => 'Ключ удален'
        ]);
    }

    //ajax - key show by id and all employees
    public function show($key_id)
    {
        $key = Key::findOrFail($key_id);
        $employees = Employee::all();

        return view('locks.key.show', compact('key', 'employees'));
    }

}

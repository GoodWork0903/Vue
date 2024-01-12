<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeKeyRequest;
use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Models\Key;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('employees.index');
    }

    /**
     * Store a newly created resource in storage.
     * @param EmployeeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(EmployeeRequest $request)
    {
        // duplicate employee name check
        $duplicate_name = Employee::where('name', $request->get('name'))->first();
        if (count($duplicate_name) > 0)
        {
            session()->flash('messageError', 'Такой сотрудник уже существует!');
            return redirect()->back();
        }
        else
        {
            Employee::create($request->all());
            session()->flash('message', 'Сотрудник создан');
        }

        return redirect()->route('employee.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);

        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, $id)
    {

        Employee::findOrFail($id)->update($request->all());

        session()->flash('message', 'Сотрудник обновлен');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */

    //ajax - displaying all employees
    public function employees()
    {
        $employees = Employee::latest()
            ->paginate(10);

        return compact('employees');
    }

    // ajax - getting all keys and employee by employee_id
    public function show($id)
    {
        $employee = Employee::with(['keys', 'keys.lock'])->findOrFail($id);
        $keys = Key::with(['lock', 'employees'])->get();

        return compact('employee', 'keys');
    }

    //ajax - delete employee
    public function destroy($id)
    {
        Employee::destroy($id);

        return response()->json([
            'message' => 'Сотрудник удален!'
        ]);
    }


    ///////////////////////////////////////////////////////////////Employee Key

    //ajax - employee_key store attach
    public function employee_key_store(EmployeeKeyRequest $request)
    {
        $key_id = $request->get('key_id');
        $employee_id = $request->get('employee_id');
        $employee = Employee::findOrFail($employee_id);
        $employee->keys()->attach($key_id);

        return response()->json([
            'message' => 'Ключ сотрудника создан!'
        ]);
    }

    //ajax - employee_key destroy detach
    public function employee_key_destroy($employee_id, $key_id)
    {
        $employee = Employee::findOrFail($employee_id);
        $employee->keys()->detach($key_id);

        return response()->json([
            'message' => 'Ключ сотрудника удален!'
        ]);
    }
}

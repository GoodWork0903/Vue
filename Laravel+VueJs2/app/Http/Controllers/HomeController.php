<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Key;
use App\Models\Lock;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $count_employees = Employee::with('keys')->get()->count();
        $count_locks = Lock::all()->count();
        $keys = Key::with(['employees'])->get();
        //finding free keys
        $keys_has_employee = [];
        foreach ($keys as $key) {
            if (!($key->employees)->isEmpty()) {
                $keys_has_employee[] = $key->employees;
            }
        }

        $count_keys = count($keys_has_employee);
        $count = count($keys);
        $free_keys = $count -  $count_keys;

        return view('home.index', compact( 'count_employees', 'count_locks', 'free_keys'));
    }

    public function main() {
        $employees = Employee::with(['keys', 'keys.lock'])
            ->get();
        return compact('employees');
    }
}

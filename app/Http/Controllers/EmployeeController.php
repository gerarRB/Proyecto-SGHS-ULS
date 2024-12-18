<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Place;
use App\Models\Department;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::select('employees.id', 'employees.name', 'email', 'phone','carnet','total_hours','student_hours','description',
            DB::raw('(total_hours - student_hours) as remaining_hours'), // Campo calculado
            'department_id', 'departments.name as department', 'place_id', 'places.name as place', 'year_id', 'years.name as year')
            ->join('departments', 'departments.id', '=', 'employees.department_id')
            ->join('places', 'places.id', '=', 'employees.place_id')
            ->join('years', 'years.id', '=', 'employees.year_id')
            
            ->paginate(4);

        $departments = Department::all();
        $places = Place::all();
        $years = Year::all();

        return Inertia::render('Employees/Index', [
            'employees' => $employees,
            'departments' => $departments,
            'places' => $places,
            'years' => $years,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:150',
            'email' => 'required|max:80',
            'phone' => 'required|max:15',
            'carnet' => 'required|max:10',
            'total_hours' => 'required|max:4',
            'student_hours' => 'required|max:4',
            'description' => 'required|max:1000',
            'department_id' => 'required|numeric',
            'place_id' => 'required|numeric',
            'year_id' => 'required|numeric',
        ]);

        $employee = new Employee($request->input());
        $employee->save();
        return to_route('employees.index');
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|max:150',
            'email' => 'required|max:80',
            'phone' => 'required|max:15',
            'carnet' => 'required|max:10',
            'total_hours' => 'required|max:4',
            'student_hours' => 'required|max:4',
            'description' => 'required|max:1000',
            'department_id' => 'required|numeric',
            'place_id' => 'required|numeric',
            'year_id' => 'required|numeric',
        ]);

        $employee->update($request->input());
        return to_route('employees.index');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return to_route('employees.index');
    }

    /*
    public function EmployeeByDepartment()
    {
        // Conteo de empleados por departamento
        $data = Employee::select(DB::raw('count(employees.id) as count, departments.name'))
            ->join('departments', 'departments.id', '=', 'employees.department_id')
            ->groupBy('departments.name')->get();
        return Inertia::render('Employees/Graphic', ['data' => $data]);
    }
    */

    public function EmployeeByPlace()
    {
        // Conteo de empleados por lugar
        $data = Employee::select(DB::raw('count(employees.id) as count, places.name'))
            ->join('places', 'places.id', '=', 'employees.place_id')
            ->groupBy('places.name')->get();
        return Inertia::render('Employees/Graphic', ['data' => $data]);
    }

    public function EmployeeByYear()
    {
        // Conteo de empleados por año
        $data = Employee::select(DB::raw('count(employees.id) as count, years.name'))
            ->join('years', 'years.id', '=', 'employees.year_id')
            ->groupBy('years.name')->get();
        return Inertia::render('Employees/Graphic', ['data' => $data]);
    }


    public function reports()
    {
        // Obtiene empleados junto con departamentos y lugares
        $employees = Employee::select('employees.id', 'employees.name', 'email', 'phone','carnet','total_hours','student_hours','description',
            'department_id', 'departments.name as department', 'place_id', 'places.name as place', 'year_id', 'years.name as year')
            ->join('departments', 'departments.id', '=', 'employees.department_id')
            ->join('places', 'places.id', '=', 'employees.place_id')
            ->join('years', 'years.id', '=', 'employees.year_id')
            ->get();

        $departments = Department::all();
        $places = Place::all();
        $years = Year::all();

        return Inertia::render('Employees/Reports', [
            'employees' => $employees,
            'departments' => $departments,
            'places' => $places,
            'years' => $years,
        ]);
    }
}


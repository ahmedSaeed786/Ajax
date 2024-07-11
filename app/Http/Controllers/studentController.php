<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\student;
class studentController extends Controller
{
    //

    public function all(Request $request)
    {

      
    $students = student::all();

    // Check if the request is an AJAX request
    if ($request->ajax()) {
        return response()->json(['statusCode' => 200, 'students' => $students]);
    }

    // Return the view for non-AJAX requests
    return view('student', ['students' => $students]);

    }
    public function store(Request $request)
    {

 
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:students',
            'age' => 'required|integer|min:1',
            'class' => 'required|string|max:255',
        ]);
    
        try {
            $student = Student::create($validatedData);
            return response()->json(['statusCode' => 200, 'student' => $student]);
        } catch (\Exception $e) {
            return response()->json(['statusCode' => 500, 'error' => $e->getMessage()]);
        }

    }
}

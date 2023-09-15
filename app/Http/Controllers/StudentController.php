<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Exception;

class StudentController extends Controller
{
    public function create(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:students,email',
                'grade' => 'required|numeric|between:0,10',
                'registration' =>  'required|string|unique:students,registration'
            ]);

            $student = new Student();
            $student->name = $validated['name'];
            $student->email = $validated['email'];
            $student->grade = $validated['grade'];
            $student->registration = $validated['registration'];

            $student->save();

            return response()->json([
                'message' => 'Student created successfully.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function list()
    {
        return response()->json([
            'data' => Student::all(),
        ], 200);
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'grade' => 'required|numeric|between:0,10',
                'registration' =>  'required|string',
            ]);

            $student = Student::findOrFail($id);

            $otherStudent = Student::where('registration', $validated['registration'])
                ->first();

            if($otherStudent->id != $student->id)
                throw new Exception('Registration number already exists.', 500);

            $student->name = $validated['name'];
            $student->email = $validated['email'];
            $student->grade = $validated['grade'];
            $student->registration = $validated['registration'];
            $student->save();

            return response()->json([
                'message' => 'Student updated successfully.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

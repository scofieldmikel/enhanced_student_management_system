<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\StudentGrade;
use App\Models\Subject;
use Illuminate\Http\Request;

class StudentGradeController extends Controller
{
    public function index(Request $request)
    {

        $student_grades = StudentGrade::where('teacher_id', $request->user()->teacher->id)->with('class', 'teacher', 'subject', 'student', 'user')->latest()->paginate(10);

        return view('backend.result.index', compact('student_grades'));
    }

    public function create(Request $request)
    {
        $classes = Grade::latest()->get();
        $subjects = Subject::where('teacher_id', $request->user()->teacher->id)->latest()->get();
        $students = Student::with('class')->latest()->get();

        return view('backend.result.create', compact('classes','subjects', 'students'));
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'student_id'          => 'required|numeric',
            'subject_id'  => 'required|numeric',
            'score'    => 'required|numeric',
        ]);

        // Check if the student + subject already exists
        $exists = StudentGrade::where('student_id', $request->student_id)
        ->where('subject_id', $request->subject_id)
        ->exists();

        if ($exists) {
            return back()->withErrors(['student_id' => 'A grade for this student and subject already exists.'])
            ->withInput();
        }

        $class_id = Student::find($request->student_id)->class_id;

        $score = $request->score;

        $letter_grade = match (true) {
            $score >= 80 => 'A',
            $score >= 65 => 'B',
            $score >= 50 => 'C',
            $score >= 40 => 'D',
            default => 'F',
        };

        StudentGrade::create([
            'student_id'          => $request->student_id,
            'subject_id'  => $request->subject_id,
            'teacher_id'    => $user->teacher->id,
            'grade_id'   => $class_id,
            'score'   => $request->score,
            'grade'   => $letter_grade
        ]);

        return redirect()->route('student.grade.index');
    }
}

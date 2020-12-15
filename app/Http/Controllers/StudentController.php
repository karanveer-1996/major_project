<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Models\Course;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $student = Student::with('course')->get();
        return view("student.index", compact('student'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $course = Course::get();
        return view('student.create', compact('course'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'gender' => 'required',
            'roll_number' => 'required',
            'course_id' => 'required',
        ]);


        if($request->has('image'))
        {
            $pic = $request->file('image');
            $updated_name = rand() . "." . $pic->getClientOriginalExtension();
            $pic->move(public_path('student_image'), $updated_name);
        }
        else{
            $updated_name = 'no-image.jpg';
        }
       
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'contact' => $request->contact,
            'address' => $request->address,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'image' => $updated_name,
            'role' => 'Student',
        ]);

        $user_id = User::where('email', $request->email)->first();

        Student::create([
            'user_id' => $user_id->id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'contact' => $request->contact,
            'roll_number' => $request->roll_number,
            'address' => $request->address,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'image' => $updated_name,
            'course_id' => $request->course_id,
            'semester' => $request->semester,
            'father_name' => $request->father_name,
            'nationality' => $request->nationality
        ]);
        return redirect()->route('student.create')->with('success', 'Record Insert Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = Student::findorfail($id);
        $course = Course::get();

        return view('student.edit', compact('student', 'course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $updated_name = $request->hidden_image;
        $pic = $request->file('image');
        if ($pic != '') {
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'gender' => 'required',
                'roll_number' => 'required',
                'course_id' => 'required',
            ]);

            $updated_name = rand() . "." . $pic->getClientOriginalExtension();
            $pic->move(public_path('student_image'), $updated_name);
        } else {
            $request->validate([
                'name' => 'required',

            ]);
        }
        Student::whereId($id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'address' => $request->address,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'image' => $updated_name,
            'course_id' => $request->course_id,
            'semester' => $request->semester,
            'father_name' => $request->father_name,
            'nationality' => $request->nationality
        ]);

        return redirect()->route('student.index')->with('success', 'Record Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::findorfail($id);
        $user = $student->user_id;
        if($student->image != null)
        {
            $image_path = public_path('/student_image') . '/' . $student->image;
        
            if ( \File::exists( 'student_image/'.$student->image ) ) {
                unlink('student_image/'.$student->image);
            }
        }
        $student->delete();
        User::where('id',$user)->delete();
        return redirect()->route('student.index')->with('success', 'Record Deleted Successfully');
    }
}

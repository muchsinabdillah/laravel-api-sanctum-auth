<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
class StudentController extends Controller
{
    // REGISTER API ->Request -> bisa akses semua data yang di input kan atau dikirim
    public function registerStudent(Request $request){
        // validate
            $request->validate([
                "name" => "required",
                "email" => "required|email|unique:students",
                "password" => "required|confirmed"
            ]);
        //create data
            $student = new Student();

            $student->name = $request->name;
            $student->email = $request->email;
            $student->password = Hash::make($request->password);
            $student->phone_no = isset($request->phone_no) ? $request->phone_no : "";

            $student->save();
        // send response
            return response()->json([
                "status" =>1,
                "message" => "Student Save Successfully."
            ]);


    }
    // LOGIN API ->Request -> bisa akses semua data yang di input kan atau dikirim
    public function loginStudent(Request $request){
        //validation
        $request->validate([ 
            "email" => "required|email",
            "password" => "required"
        ]);
        // ceck student
        $student = Student::where("email","=",$request->email)->first();
        if(isset($student->id)){
            if(Hash::check($request->password, $student->password)){
                // create a token
                $token = $student->createToken("auth_token")->plainTextToken;
                // send response
                return response()->json([
                    "status" => 1,
                    "message" => "Student Login Successfully",
                    "access_token" => $token
                ]);
            } else {
                return response()->json([
                    "status" => 0,
                    "message" => "Password didn't match"
                ]);
            }
            
        }else{
            return response()->json([
                "status" => 0,
                "message" => "Student Not Found"
            ]);
        }
    }
    // PROFILE API ->Request -> bisa akses semua data yang di input kan atau dikirim
    public function profileStudent(){
        return response()->json([
            "status" => 1,
            "message" => "Student Profile Information",
            "data" =>auth()->user()
        ]); 
    }
    // LOGOUT API ->Request -> bisa akses semua data yang di input kan atau dikirim
    public function logoutStudent(){
        auth()->user()->tokens()->delete();
        return response()->json([
            "status" => 1,
            "message" => "Student Logged out successfully"  
        ]); 
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Hash;

class ProjectController extends Controller
{
    // CREATE PROJECT API
    public function createProject(Request $request){
        // validate
        $request->validate([ 
            "name" => "required",
            "description" => "required",
            "duration" => "required"
        ]);

        // student id + create data
        $student_id = auth()->user()->id;

        $project = new Project();

        $project->student_id = $student_id;
        $project->name = $request->name;
        $project->description = $request->description;
        $project->duration = $request->duration; 

        $project->save();

        // send response
        return response()->json([
            "status" => 1,
            "message" => "Project Save Successfully."
        ]);
    }
    // lst PROJECT API
    public function listProject(){
        $student_id = auth()->user()->id;

        $project = Project::where("student_id",$student_id)->get();

        return response()->json([
            "status" => 1,
            "message" => "Projects",
            "data" => $project
        ]); 
    }
    // SINGLE PROJECT API
    public function singleProject($id){
        $student_id = auth()->user()->id;

        if(Project::where([
            "id" =>$id,
            "student_id"=> $student_id 
        ])->exists()){
            $details = Project::where([
                "id" => $id,
                "student_id" => $student_id
            ])->first();
            return response()->json([
                "status" => 1,
                "message" => "Project Found",
                "data" => $details
            ]); 
        }else{
            return response()->json([
                "status" => 0,
                "message" => "Project not Found" 
            ]); 
        }
    }
    // DELETE PROJECT API
    public function deleteProject($id){

        $student_id = auth()->user()->id;

        if(Project::where([
            "id" =>$id,
            "student_id" => $student_id
        ])->exists()){

            $project = Project::where([
                "id" => $id,
                "student_id" => $student_id
            ])->first();
            
            $project->delete();

            return response()->json([
                "status" => 1,
                "message" => "Project Has been Deleted Successfully"
            ]); 
        }else{
            return response()->json([
                "status" => 0,
                "message" => "Project not Found"
            ]); 
        }
    }
}

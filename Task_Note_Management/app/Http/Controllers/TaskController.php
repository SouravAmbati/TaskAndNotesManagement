<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Task;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    public function create(Request $req)
    {
        //set rules for validating fields
        $rules = [
            'title' => 'required|min:10',
            'description' => 'required|max:200'
        ];
        $validation = Validator::make($req->all(), $rules);
        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validation->errors()
            ], 422);
        }
        //add data to the table
        $task = Task::create([
            'title' => $req->title,
            'description' => $req->description,
            'is_completed' => false,
            'user_id' => Auth::id()
        ]);
        //send the response in json structure
        return response()->json([
            'success' => true,
            'data' => $task,
            'message' => 'Task Created Successfully'
        ]);
    }

    public function complete(Task $task)
{
   

    //in this line it defines logged in user can only access his own data not other's data
    Gate::authorize('access', $task);

    //update the is_completed to true
    $task->is_completed = true;
    //save the changes
    $task->save();
    //send the response
    return response()->json([
        'success' => true,
        'message' => 'Task completed'
    ]);
}


    public function Tasks(Task $task)
    {
        //get the data of the logged in user
        $tasks = Task::where('user_id', Auth::id())->get();
        //send the response
        return response()->json([
            'success' => true,
            'data' => $tasks
        ]);
    }

    public function UpdateTask(Request $req, Task $task)
{
    ////in this line it defines logged in user can only update his own data not other's data
    Gate::authorize('update', $task);
    //validate the fields
    $validated = $req->validate([
        'title' => 'sometimes|string|min:10',
        'description' => 'sometimes|string|max:200'
    ]);
    //update the table based on the field
    $task->update($validated);
    //send the response
    return response()->json([
        'success' => true,
        'message' => 'Task updated successfully',
        'data' => $task
    ]);
}


    public function DeleteTask(Task $task)
{
    //in this line it defines logged in user can only delete his own data not other's data
    Gate::authorize('delete', $task);
    //delete the data
    $task->delete();
    //send the response
    return response()->json([
        'success' => true,
        'message' => 'Task Deleted'
    ]);
}


    public function addNote(Request $req, Task $task)
{
    //in this line it defines logged in user can only access his own data not other's data
    Gate::authorize('access', $task);

    //check if the task available in the table or not
    if (!$task) {
        return response()->json([
            'success' => false,
            'message' => 'Task not found'
        ], 404);
    }

    //validate the fields
    $validated = $req->validate([
        'note' => 'required|string|max:500'
    ]);
    //add data to the table
    $note = Note::create([
        'note' => $validated['note'],
        'task_id' => $task->id
    ]);
    //send the response
    return response()->json([
        'success' => true,
        'task' => $task->title,
        'data' => $note,
        'message' => 'Note added successfully'
    ]);
}

}
?>
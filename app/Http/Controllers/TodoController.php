<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Todo;

class TodoController extends Controller
{
    public function index(){
        $todo = Todo::all();
        // return response()->json($todo, 200);
        if ($todo){
            return response()->json(['status' => true, 'message' => "Get success", 'data' => $todo], 200);
        }
        else{
            $messageError = "Can't get the data";
            return response()->json(['status' => false, 'message' => $messageError, 'data' => null], 400); 
        }

    }

    // public function create(){
    //     return view('create');// why only this part is todos.create
    // }

    public function store(Request $request){
        //I can specify required data
        try{
            $request->validate([
                'name' => 'required',
                'description' => 'required',
            ]);
        }
        catch (ValidationException $exception) {
            $errorMessages = $exception->validator->getMessageBag()->getMessages();
            return $errorMessages;
        }

        $data = $request->all();//取得所有input
        

        $todo = new Todo();//OOP - 呼叫 model
        $todo->name = $data['name'];
        $todo->description = $data['description'];
        // $todo->save();
        if ($todo->save()){
            return response()->json(['status' => true, 'message' => "Create success!"], 201);
        }
        else{
            $messageError = "Fail to create.";
            return response()->json(['status' => false, 'message' => $messageError], 400); 
        }


        // return redirect('/');

    }


    public function details($id){
        // $todo = Todo::findOrFail($id); //throw 404 not found error
        $todo = Todo::find($id);
        if ($todo){
            return response()->json(['status' => true, 'message' => "Get details success", 'data' => $todo], 200);
        }
        else{
            $messageError = "Can't find the data";
            return response()->json(['status' => false, 'message' => $messageError, 'data' => null], 400); 
        }
    }
    
    // public function edit(){
    //     return view('edit');
    // }

    public function update(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);//405 not found error, so it will not process upcoming requests

        $data = $request->all();
        
        $todo->name = $data['name'];
        $todo->description = $data['description'];

        if ($todo->save()){
            return response()->json(['status' => true, 'message' => "Update success!"], 200);
        }
        else{
            $messageError = "Fail to update.";
            return response()->json(['status' => false, 'message' => $messageError], 400); 
        }
    }

    public function delete($id){

        $todo = Todo::findOrFail($id);
 
        if ($todo->delete()){
            return response()->json(['status' => true, 'message' => "Delete success!"], 204);
        }
        else{
            $messageError = "Fail to delete";
            return response()->json(['status' => false, 'message' => $messageError, 'data' => null], 400); 
        }
    }

    public function deleteAll(){
 
        if (Todo::truncate()){
            return response()->json(['status' => true, 'message' => "Delete success!"], 204);
        }
        else{
            $messageError = "Fail to delete";
            return response()->json(['status' => false, 'message' => $messageError, 'data' => null], 400); 
        }

    }
}

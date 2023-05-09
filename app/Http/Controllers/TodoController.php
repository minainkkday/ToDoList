<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Todo;

class TodoController extends Controller
{
    public function index(){
        $todo = Todo::all();
        if ($todo){
            return response()->json(['status' => true, 'message' => "Get success", 'data' => $todo], 200);
        }
        
        $messageError = "Can't get the data";
        return response()->json(['status' => false, 'message' => $messageError, 'data' => null], 400); 
    
    }

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
        //try catch -> 為了執行後面的流程
        //error handle -》 改 json 的 format 來改緊啊

        $data = $request->all();//取得所有input
        

        $todo = new Todo();//OOP - 呼叫 model
        $todo->name = $data['name'];
        $todo->description = $data['description'];
        
        //fail comes first， ans success comes last
        if ($todo->save()){
            return response()->json(['status' => true, 'message' => "Create success!"], 201);
        }
        else{
            $messageError = "Fail to create.";
            return response()->json(['status' => false, 'message' => $messageError], 400); 
        }
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
        //need to validate integer type, SQL injection - required
        //url 上面的寫法， input 進來的 parameter， 可以做到多細 是我能決定的部分

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

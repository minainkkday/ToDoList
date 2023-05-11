<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Todo;
use Illuminate\Support\Facades\DB;

class TodoController extends Controller
{
    public function index(){
        $todo = Todo::all();
        return $this->responseSuccess($todo);
    }

    public function store(Request $request){
        //I can specify required data
        //感覺可以再改進，像自己設 validation rules，error message 的部分
        try{
            $request->validate([
                'name' => 'required',
                'description' => 'required',
            ]);
        }
        catch (ValidationException $exception) {
            $errorMessages = $exception->validator->getMessageBag()->getMessages();
            return response()->json($errorMessages);
        }

        $data = $request->all();//取得所有input

        $todo = new Todo();//OOP - 呼叫 model
        $todo->name = $data['name'];
        $todo->description = $data['description'];

        $saved = $todo->save();

        if(!$saved){
            return $this->responseFail();
        }

        return $this->responseSuccess($todo);
    }


    public function details($id){
        $todo = Todo::find($id);

        //Fail to find a data
        if(!$todo){
            return $this->responseNotfound();
        }

        return $this->responseSuccess($todo);
    }


    public function update(Request $request, $id)
    {
        $todo = Todo::find($id);

        if(!$todo){
            return $this->responseNotfound();
        }
        
        $data = $request->all();
        
        $todo->name = $data['name'];
        $todo->description = $data['description'];

        $saved = $todo->save();

        if(!$saved){
            return $this->responseFail();
        }

        return $this->responseSuccess($todo);
    }

    public function delete($id){
        $todo = Todo::find($id);
        if(!$todo){
            return $this->responseNotfound();
        }
        
        $deleted = $todo->delete();

        if (!$deleted){
            return $this->responseFail();
        }

        return $this->responseSuccess();
    }

    public function deleteAll(){
        $deleted = Todo::truncate();
        if (!$deleted){
            return $this->responseFail(); 
        }

        return $this->responseSuccess();
    }
}

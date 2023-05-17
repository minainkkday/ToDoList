<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TodoController extends Controller
{
    public function index()
    {
        //User::find(Auth::id())->todos, this will get colletion type as a return.
        $todos = User::find(Auth::id())->todos;
        //If  I don't add values()->all(), it will return itself's indices, so I can't return the correct format
        //use the values method to reset the keys to consecutively numbered indexes:
        $sorted = $todos->sortByDesc('created_at')->values()->all();//To show recently created first
        // dd($sorted);
        return $this->responseSuccess($sorted);
    }

    public function store(Request $request)
    {
        //I can specify required data
        //感覺可以再改進，像自己設 validation rules，error message 的部分
        try{
            $request->validate([
                'name' => 'required | max:255',
                'description' => 'required | max:1000',
            ]);
        }
        catch (ValidationException $exception) {
            $errorMessages = $exception->validator->getMessageBag()->getMessages();
            return $this->responseFail($errorMessages);
        }

        $data = $request->all();//取得所有input

        $todo = new Todo();//OOP - 呼叫 model
        $todo->user_id = Auth::id();
        $todo->name = $data['name'];
        $todo->description = $data['description'];

        //try catch 
        $saved = $todo->save();

        if(!$saved){
            return $this->responseFail();
        }

        return $this->responseSuccess($todo);
    }

    public function details(int $id)
    {
        $todo = User::find(Auth::id())->todos->find($id);
        // $todo = Todo::find($id);

        //Fail to find a data
        if(!$todo){
            return $this->responseNotfound();
        }

        return $this->responseSuccess($todo);
    }

    public function update(Request $request, int $id)
    {
        $todo = User::find(Auth::id())->todos->find($id);
        if(!$todo){
            return $this->responseNotfound();
        }

        try{
            $request->validate([
                'name' => 'required | max:255',
                'description' => 'required | max:1000',
            ]);
        }
        catch (ValidationException $exception) {
            $errorMessages = $exception->validator->getMessageBag()->getMessages();
            //exception handler ->  看情況
            return $this->responseFail($errorMessages);
        }
        
        $data = $request->all();
        // try{
        //     $todo->name = $data['name'];
        //     $todo->description = $data['description'];
    
        //     //try catch, 噴錯誤是我想要的輸出的格式 顯示我想要的格式
        //     $saved = $todo->save();
        // }
        // catch(Exception $error){

        //     return $this->responseFail();
        // }
        
        $todo->name = $data['name'];
        $todo->description = $data['description'];
        $saved = $todo->save();

        if(!$saved){
            return $this->responseFail();
        }

        return $this->responseSuccess($todo);
    }

    public function delete(int $id)
    {
        $todo = User::find(Auth::id())->todos->find($id);
        if(!$todo){
            return $this->responseNotfound();
        }
        
        $deleted = $todo->delete();

        if (!$deleted){
            return $this->responseFail();
        }

        return $this->responseSuccess();
    }


    public function deleteAll()
    {
        //collection cannot use truncate, I guess cuz it's not the table
        //卡很久
        $todos = User::find(Auth::id())->todos->pluck('id')->toArray();
        $deleted = Todo::destroy($todos);
        
        if (!$deleted){
            return $this->responseFail(); 
        }

        return $this->responseSuccess();
    }
}
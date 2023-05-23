<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TodoController extends Controller
{
    public function index()
    {
        if(!Auth::check()){
            $msg = "Login First";
            return $this->responseNotfound($msg);
        }

        $todos = User::find(Auth::id())->todos;//return type: collection
        //If  I don't add values()->all(), it will return itself generated indices, so I can't return the correct format
        //use the values method to reset the keys to consecutively numbered indexes:
        $sorted = $todos->sortByDesc('created_at')->values()->all();//To show recently created first
        
        return $this->responseSuccess($sorted);
    }

    public function store(Request $request)
    {
        if(!Auth::check()){
            $msg = "Login First";
            return $this->responseNotfound($msg);
        }
        //사용자의 입력 데이터 유효성 검사
        $request->validate([
            'name' => 'required | max:255',
            'description' => 'required | max:1000',
        ]);

        $data = $request->all();//取得所有input

        //It doesn't throw an error to me.
        try{
            $todo = Todo::create([
                'user_id' => Auth::id(),
                'name' => $data['name'],
                'description' => $data['description']
            ]);
        } catch(\Exception $e){
            $this->responseFail($e->getMessage());
        }

        return $this->responseSuccess($todo);
    }

    public function details(int $id)
    {
        if(!Auth::check()){
            $msg = "Login First";
            return $this->responseNotfound($msg);
        }
        $todo = User::find(Auth::id())->todos->find($id);

        //Fail to find a data
        if(!$todo){
            return $this->responseNotfound();
        }

        return $this->responseSuccess($todo);
    }

    public function update(Request $request, int $id)
    {
        if(!Auth::check()){
            $msg = "Login First";
            return $this->responseNotfound($msg);
        }

        $todo = User::find(Auth::id())->todos->find($id);

        if(!$todo){
            return $this->responseNotfound();
        }

        $request->validate([
            'name' => 'required | max:255',
            'description' => 'required | max:1000',
        ]);
        
        $data = $request->all();

        //It doesn't throw an error to me.
        try{
            $todo->fill(
                [
                    'name' => $data['name'],
                    'description' => $data['description']
                ]
            );
            $todo->save();
        } catch(\Exception $e){
            $this->responseFail($e->getMessage());
        }

        return $this->responseSuccess($todo);
    }

    public function delete(int $id)
    {
        if(!Auth::check()){
            $msg = "Login First";
            return $this->responseNotfound($msg);
        }

        $todo = User::find(Auth::id())->todos->find($id);
        if(!$todo){
            return $this->responseNotfound();
        }
        //shoud I check if it is successful or not?
        $todo->delete();
        
        return $this->responseSuccess();
    }


    public function deleteAll()
    {
        if(!Auth::check()){
            $msg = "Login First";
            return $this->responseNotfound($msg);
        }
        //collection cannot use truncate, I guess cuz it's not the table
        $todos = User::find(Auth::id())->todos->pluck('id')->toArray();

        if(!$todos){
            return $this->responseNotfound();
        }
        //shoud I check if it is successful or not?
        Todo::destroy($todos);
  
        return $this->responseSuccess();
    }
}
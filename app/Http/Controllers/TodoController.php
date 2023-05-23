<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TodoRequest;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Auth::user()->todos;//return type: collection

        //If  I don't add values()->all(), it will return itself generated indices, so I can't return the correct format
        //use the values method to reset the keys to consecutively numbered indexes:
        $sorted = $todos->sortByDesc('created_at')->values()->all();//To show recently created first

        return $this->responseSuccess($sorted);
    }

    public function store(TodoRequest $request)
    {
        //사용자의 입력 데이터 유효성 검사
        $data = $request->post();
    
        //Handled by Exceptions/Handler
        $todo = Todo::create([
            'user_id' => Auth::id(),
            'name' => $data['name'],
            'description' => $data['description']
        ]);  

        return $this->responseSuccess($todo);
    }

    public function details(int $id)
    {
        $todo = Auth::user()->todos->find($id);

        //Fail to find the data
        if (!$todo){
            return $this->responseNotfound();
        }

        return $this->responseSuccess($todo);
    }

    public function update(TodoRequest $request, int $id)
    {
        $todo = Auth::user()->todos->find($id);
        if (!$todo){
            return $this->responseNotfound();
        }

        $data = $request->validated();
        
        //Handled by Exceptions\Handler
        $todo->fill(
            [
                'name' => $data['name'],
                'description' => $data['description']
            ]
        );
        $todo->save();

        return $this->responseSuccess($todo);
    }

    public function delete(int $id)
    {
        $todo = Auth::user()->todos->find($id);
        if(!$todo){
            return $this->responseNotfound();
        }

        //todo 를 찾았으니까, 사실은 정상적으로 처리가 되어야 하는게 맞음.
        //근데 DB 고장남, 예기치 못한 상황. -> Exceptions/Handler 
        //보통 try & catch 는 예상 범위의 예외에서 그런 처리를 함. 
        $todo->delete();
        
        return $this->responseSuccess();
    }


    public function deleteAll()
    {
        //collection cannot use truncate, I guess cuz it's not the table
        $todos = Auth::user()->todos->pluck('id')->toArray();
        if(!$todos){
            return $this->responseNotfound();
        }
        
        Todo::destroy($todos);
  
        return $this->responseSuccess();
    }
}
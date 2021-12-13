<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return response(['tasks' => $user->tasks()->get()],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = array_merge($request->all(),['creator_id'=>Auth::id()]);
        $task = Task::create($data);
        $task->exists ?
            $response = ['message' => 'Задача успешно создана!', 'status' => 201] :
            $response = ['message' => 'Не удалось создать задачу', 'status' => 500];
        return response(['message' => $response['message'], 'task' => $task ], $response['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Task::findOrFail($id)->update($request->all());
        $task = Task::find($id);
        return response(['message' => 'Задание успешно обновлено', 'task' => $task], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = Task::destroy($id);
        $destroy ?
            $response = ['message' => 'Задача успешно удалена', 'status' => 200] :
            $response = ['message' => 'Не удалось удалить задачу', 'status' => 500];
        return response(['message' => $response['message']], $response['status']);
    }
}

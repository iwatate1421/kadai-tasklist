<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Task; 

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザーを取得
            $user = \Auth::user();
            // ユーザーの投稿の一覧を作成日時の降順で取得
            // （後のChapterで他ユーザーの投稿も取得するように変更しますが、現時点ではこのユーザーの投稿のみ取得します）
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
        }
        
        // dashboardビューでそれらを表示
        return view('dashboard', $data);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $task = new Task;

        // メッセージ作成ビューを表示
        return view('tasks.create', ['task' => $task, ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        
        $validator = Validator::make($request->all(), [
            'status' => 'required|max:10',
            'content' => 'required|max:255',
            
        ], [
            'status.required' => 'ステータスを入力してください。',
            'status.max' => 'ステータスは10文字以内で入力してください。',
            'content.required' => 'タスク内容を入力してください。',
            'content.max' => 'タスク内容は255文字以内で入力してください。',
        ]);
    
        if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator)
                ->withInput();
        }
        
        // 認証済みユーザー（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        $request->user()->tasks()->create([
            'content' => $request->content,
            'status' => $request->status
        ]);
        // 前のURLへリダイレクトさせる
        return back();
        
        // トップページへリダイレクトさせる
        // return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);
        
        // 認証済みユーザーがタスクの所有者でない場合、トップページにリダイレクト
        if (\Auth::id() !== $task->user_id) {
            return redirect('/')->with('error', '他人のタスクは閲覧できません。');
        }
        
        // メッセージ詳細ビューでそれを表示
        return view('tasks.show', ['task' => $task,]);
    }

    /**
     * Show the form for editing the specified resource.
     *    public function edit(string $id)
     */
    public function edit(Task $task)
    {
        // idの値でメッセージを検索して取得
        //$task = Task::findOrFail($id);
        
        // 認証済みユーザーがタスクの所有者でない場合、トップページにリダイレクト
        if (\Auth::id() !== $task->user_id) {
            return redirect('/')->with('error', '他人のタスクは閲覧できません。');
        }

        // メッセージ編集ビューでそれを表示
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     * public function update(Request $request, string $id)
     */
    public function update(Request $request, Task $task)
    {

        $validator = Validator::make($request->all(), [
            'status' => 'required|max:10',
            'content' => 'required|max:255',
            
        ], [
            'status.required' => 'ステータスを入力してください。',
            'status.max' => 'ステータスは10文字以内で入力してください。',
            'content.required' => 'タスク内容を入力してください。',
            'content.max' => 'タスク内容は255文字以内で入力してください。',
        ]);

    
        if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator)
                ->withInput();
        }
    
        // idの値でメッセージを検索して取得
        //$task = Task::findOrFail($id);
        // メッセージを更新
        $task->content = $request->content;
        $task->status = $request->status;
        $task->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        
        // 認証済みユーザー（閲覧者）がその投稿の所有者である場合は投稿を削除
        if (\Auth::id() === $task->user_id) {
            // idの値でメッセージを検索して取得
            // $task = Task::findOrFail($id);
            // メッセージを削除
            $task->delete();
            return back()
                ->with('success','Delete Successful');
        }

    }
}

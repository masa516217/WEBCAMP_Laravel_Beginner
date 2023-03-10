<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRegisterPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Task as TaskModel;

class TaskController extends Controller
{
    /**
     * タスク一覧ページを表示
     * 
     * @return \Illuminate\View\View
     */
     public function list()
     {
        //一覧の取得
        $list = TaskModel::get();
$sql = TaskModel::toSql();
echo "<pre>\n"; var_dump($sql, $list); exit;
        return view('task.list');
     }
     
     /**
      * タスクの新規登録
      */
    public function register(TaskRegisterPostRequest $request)
    {
        //validate済みのデータの取得
        $datum = $request->validated();
        //
        //$user = Auth::user();
        //$id = Auth::id();
        //var_dump($datum, $user, $id); exit;
        
        // user_idの追加
        $datum['user_id'] = Auth::id();
        
        // テーブルへのINSERT
        try {
        $r = TaskModel::create($datum);
        
    } catch(\Throwable $e) {
        // XXX 本当はログ等に各処理をする。今回は一端出力するだけ
        echo $e->getMessage();
        exit;
    }
    
    // タスク塘路k成功
    $request->session()->flash('front.task_register_success', true);
    //
    return redirect('/task/list');
    }
}
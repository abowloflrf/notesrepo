<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Note;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use function foo\func;

class FolderController extends Controller
{
    private $author;
    private $categoryName;
    
    //构造函数，该控制器的所有方法均需要请求用户的email与需要操作的文件夹名
    public function __construct(Request $request)
    {
        if (auth()->check()) {
            $this->author = auth()->user()->email;
        }
        $this->categoryName = $request->get('category');
        $this->middleware('auth:api');
    }

    //新建一个文件夹，实现即为新建一篇笔记带有指定的category属性
    public function createFolder()
    {
        //该用户下已经存在同名文件夹
        if (count(Note::where('category', $this->categoryName)->where('author', $this->author)->get()) != 0) {
            return response()->json(array(
                'status' => 'ERROR',
                'msg' => 'Fodername already exsited.'
            ));
        }
        //下面新建
        try {
            $uuid = Uuid::uuid1()->toString();
        } catch (UnsatisfiedDependencyException $e) {
            return response()->json(array(
                'status' => 'ERROR',
                'msg' => 'UUID exception: ' . $e->getMessage()
            ));
        }
        $note = new Note;
        $note->uuid = $uuid;
        $note->author = $this->author;
        $note->title = "未命名笔记";
        $note->content = "# Note in " . $this->categoryName;
        $note->category = $this->categoryName;
        if ($note->save()) {
            return response()->json(array(
                'status' => 'SUCCESS',
                'msg' => 'Successfully created a folder.',
                'note' => array(
                    'title' => $note['title'],
                    'uuid' => $note['uuid'],
                    'author' => $note['author'],
                    'created_at' => $note['created_at'],
                    'category' => $note['category'],
                    'content' => $note['content']
                )
            ));
        } else {
            return response()->json(array(
                'status' => 'ERROR',
                'msg' => 'Failed to create a folder.'
            ));
        }
    }

    public function renameFolder(Request $request)
    {
        //获取传入的新文件夹名
        $newCategory = $request->get('newCategory');
        if (Note::where('author', $this->author)
            ->where('category', $this->categoryName)
            ->update(['category' => $newCategory])) {
            return response()->json(array(
                'status' => 'SUCCESS',
                'msg' => 'Successfully renamed a folder.'
            ));
        } else {
            return response()->json(array(
                'status' => 'ERROR',
                'msg' => 'Failed to rename a folder.'
            ));
        }
    }

    public function emptyFolder()
    {
        if (Note::where('category', $this->categoryName)->where('author', $this->author)->delete()) {
            return response()->json(array(
                'status' => 'SUCCESS',
                'msg' => 'Successfully empty a folder.'
            ));
        } else {
            return response()->json(array(
                'status' => 'ERROR',
                'msg' => 'Failed to empty a folder.'
            ));
        }
    }
}

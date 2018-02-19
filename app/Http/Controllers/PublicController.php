<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Note;

class PublicController extends Controller
{
    public function index($uuid)
    {
        if ($note = Note::where("uuid", $uuid)->first()) {
            $Parsedown = new \Parsedown();
            $noteParsed = $Parsedown->text($note['content']);
            return view('post', compact("note", "noteParsed"));
        } else {
            abort(404);
        }
    }
}

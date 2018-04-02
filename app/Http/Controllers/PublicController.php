<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Note;

class PublicController extends Controller
{
    public function index($uuid)
    {
        if ($note = Note::where("uuid", $uuid)->first()) {
            if ($note->is_public) {
                $Parsedown = new \Parsedown();
                $noteParsed = $Parsedown->text($note['content']);
                return view('post', compact("note", "noteParsed"));
            }
        }
        abort(404);
    }
}

<?php

namespace App\Http\Controllers\parideCtrl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RedisUser;

class DocNotesController extends Controller
{
    public function index(Request $req) {
        if(in_array(RedisUser::get('role'), ['client'])){
            return redirect()->to('/');
        }
        return view('parideViews.docNotes.index');
    }
}

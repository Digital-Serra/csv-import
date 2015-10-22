<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }


    /**
     * Import contacts
     */
    public function getImport(){
        return view('dashboard.emails.import')->with('user',$this->user->name);
    }

    /**
     *
     * Handle post Import contacts
     */
    public function postImport(){
        return view('dashboard.emails.import');
    }
}

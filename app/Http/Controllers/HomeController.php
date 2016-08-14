<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::guest()){
            return view('welcome');
        }else{
            $this->show();
        }
    }

    public function show()
    {
        $surveys = Auth::user()->surveys()->get();
        //$surveys = Auth::user()->surveys()->all();
        return view('survey.mySurveys', ['surveys' => $surveys]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class statsController extends Controller
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
  public function index($id)
  {
      return view('/project/statistics',['id' => $id]);
  }
}

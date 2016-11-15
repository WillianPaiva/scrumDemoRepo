<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Image;

 class UserController extends Controller
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
	public function userProfile()
	{      

		return view('profile',array('user'=>Auth::user(),'memberOf'=>Auth::user()->memberOf()->get(),'owns'=>Auth::user()->owns()->get()));
	}
  public function update_avatar(Request $request){
     	// Handle the user upload of avatar
     	if($request->hasFile('avatar')){
     		$avatar = $request->file('avatar');
     		$filename = time() . '.' . $avatar->getClientOriginalExtension();
     		Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' . $filename));
     		$user = Auth::user();
     		$user->avatar = $filename;
     		$user->save();
     	}
     	return view('profile',array('user'=>Auth::user(),'memberOf'=>Auth::user()->memberOf()->get(),'owns'=>Auth::user()->owns()->get()));
     }


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Permission;


class UsersController extends Controller
{
    public function index()
    {
    	$users = User::all();
    	return $users;
    }

    public function userProfile()
    {
    	$user = User::where('id',Auth::user()->id)->first();
    	return $user;
    }

    public function updateProfile(Request $request)
    {
    	$user = Auth::user()->id;
    	$user = User::find($user);
    	$input = $request->all();
    	return $user->update($input);
    }

    public function avatar(Request $request)

    {
    	//Upload profile image logic here
    }

    public function userRoles()
    {
    	$user = User::with('roles')->where('id',Auth::user()->id)->first();
    	return $user;
    }

    public function userPermissions()
    {
    	$user = User::with('permissions')->where('id',Auth::user()->id)->first();
    	return $user;
    }
}

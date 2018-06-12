<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Input;
use JWTFactory;

class APIAuthController extends Controller
{
    public function register(Request $request)
    {
       $user = new User;
    $user->email = $request->input('email');
    $user->name = $request->input('name');
    $user->password = bcrypt($request->input('password'));
    $user->save();
    //Assign default role
        $user = User::where('email', '=', $request->input('email'))->first();

        $role = Role::where('name', '=', '_default')->first();
        $user->attachRole($role->id);
        //The mailing logic to be transfered to event handler
        $to = $request->input('email');
        $password = $request->input('password');

        Mail::to($to)->send(new NewUser($user,$password)); 
    return response([
        'status' => 'success',
        'data' => $user
       ], 200);

    }

    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');
    if ( ! $token = JWTAuth::attempt($credentials)) {
            return response([
                'status' => 'error',
                'error' => 'invalid.credentials',
                'msg' => 'Invalid Credentials.'
            ], 400);
    }


    return response([
            'status' => 'success'
        ]) ->header('Authorization', $token);
}

public function user(Request $request)
{
    $user = User::find(Auth::User()->id);
   return response([
            'status' => 'success',
            'data' => $user
        ]);
        return $user;
}
    

    

    public function assignRole(Request $request){
         // Todo

        $user = User::where('email', '=', $request->input('user'))->first();

        $role = Role::where('name', '=', $request->input('role'))->first();
       $user_has_role = DB::table('role_user')
                        ->where('user_id',$user->id)->first();
                if($user_has_role===null)
                {
                  $user->attachRole($role->id);  
                }
                else
                {
         DB::update('update role_user set role_id=? where user_id =?',[$role->id,$user->id]);
    
                }
        
      $message = 'User role updated to '.$request->input('role');
                Session::flash('message', $message);

    return 'User Role Updated!';
    }

    public function assignPermissionForm($id)
    {
        
        $role = Role::where('id',$id)->first();
        $privillages = Permission::all();
        $current_privillages = DB::table('permission_role')
                            ->leftjoin('permissions','permission_id',
                                'permissions.id','permission_role.permission_id')
        ->where('permission_role.role_id',$role->id)->get();
          $current_privillages_array=[];     
         foreach($current_privillages as $cp)
        {
        $current_privillages_array[] = $cp->name;
    }
   
                     
        return view('auth.users.edit_user_privillages',
            array('role'=>$role,'title'=>'Edit User Privillages',
                'privillages'=>$privillages,'current_privillages'=>$current_privillages_array));
    }

    public function attachPermission(Request $request){
        // Todo
        $permissions = Input::get('permission'); 
        //Get role Id from the roles table based on submitted role name
        $role = Role::where('name', '=', $request->input('role'))->first();
      //Delete all permissions already assgined to the role if any
         DB::table('permission_role')->where('role_id', '=', $role->id)->delete();
       //Extract key values from the submitted permissions in an array
        for($i=0;$i<count($permissions);$i++)
        {

        $role = Role::where('name', '=', $request->input('role'))->first();
        $permission = Permission::where('name', '=', $permissions[$i])->first();
       // $role->permission()->sync($permissions); 
       // Assign new permissions   
        $role->attachPermission($permission);
    }

// Return back with response message
return 'Permissions attached successfuly';
     
         
    }
  

    //Change user password
public function changePasswordRules(array $data)
{
    $messages = [
    'current-password.required' => 'Please enter current password',
    'password.required' => 'Please enter password',
  ];

  $validator = Validator::make($data, [
    'current-password' => 'required',
    'password' => 'required|same:password',
    'password_confirmation' => 'required|same:password',     
  ], $messages);

  return $validator;
}
public function changePassword(Request $request)
{
  if(Auth::Check())
  {
    $request_data = $request->All();
    $validator = $this->changePasswordRules($request_data);
    if($validator->fails())
    {
    return $validator->messages();
    }
    else
    {  
      $current_password = Auth::User()->password;           
      if(\Hash::check($request_data['current-password'], $current_password))
      {           
        $user_id = Auth::User()->id;                       
        $obj_user = User::find($user_id);
        $obj_user->password = Hash::make($request_data['password']);;
        $obj_user->save(); 
        return 'Password was successfuly changed';
        
      }
      else
      {           
        $error = array('current-password' => 'Please enter correct current password');
        return response()->json(array('error' => $error), 400);   
      }
    }        
  }
  else
  {
    return redirect()->to('/');
  }    
}
public function admin()

{
    $users = count(User::all());
    $banned =count(DB::table('users')->where('banned',1)->get());
    $active = count(DB::table('users')->where('activated',1)->get());
    $pending = count(DB::table('users')->where('activated',0)->get());;
    /*return view ('admin.index',['title'=>'Admin Panel',
        'pending'=>$pending,'users'=>$users,'banned'=>$banned,
        'active'=>$active]);*/
}

public function bannedUsers()
{
        $banned =DB::table('users')->where('banned',1)->get();
        return $banned;
       
        

}

public function activeUsers()
{
        $active =DB::table('users')->where('activated','=',1)->get();

      return $active;

      
}

public function pendingUsers()
{
        $pending =DB::table('users')->where('activated',0)->get();
      
        return $pending;
        

}
public function rolesWithPermissions($id)

{   
  

    $roles= DB::table('roles')
        ->leftjoin('permission_role','roles.id',
            'permission_role.role_id','roles.id')
        ->leftjoin('permissions','permission_role.permission_id',
            'permissions.id','permission_role.permission_id')
        ->select(DB::raw('roles.id'),DB::raw('roles.name'),DB::raw('roles.display_name'),
            DB::raw('roles.description'),DB::raw('permissions.name as permissions'))
        ->where('roles.id',$id)
        ->get();

    $role = Role::where('id',$id)->first();
        $roles =[$roles,$role];

    return $roles;
}

public function usersWithRoles()

{   
     $users= DB::table('users')
        ->leftjoin('role_user','id',
            'role_user.user_id','users.id')
        ->leftjoin('roles','role_user.role_id',
            'roles.id','role_user.role_id')
        ->select(DB::raw('users.id'),DB::raw('users.name'),
            DB::raw('users.email'),
            DB::raw('roles.name as role'),DB::raw('roles.display_name'),
            DB::raw('roles.description'))            
             ->get();
        return $users;


   


}

public function APIlogout()
{
    JWTAuth::invalidate();
    return response([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
}



}

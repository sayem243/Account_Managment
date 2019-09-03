<?php


namespace App\Http\Controllers;


use App\Company;
use App\Project;
use App\UserProfile;
use App\UserProject;
use App\UserType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::orderBy('id','DESC')->paginate(5);
        return view('users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }
    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $usertypes=UserType::all();

        // return view('auth.register', compact('usertypes'));
        //return view('auth.register')->with('usertypes',$usertypes);

        $companies=Company::all();
        $userProjects=Project::all();
        return view('auth.register',['usertypes'=>$usertypes ,'companies'=>$companies,'projects'=>$userProjects]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        var_dump('ok');die;
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
//            'password' => 'required|same:confirm-password',
        ]);

        $data = array(
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'username'=> $request->username,
            'user_types_id'=> $request->user_types_id,
            'company_id'=>$request->company_id,
        );

        $user = User::create($data);

        $user->assignRole($request->input('roles'));


        $profile= New UserProfile ;

//        $user->userProfile()->create();

        $profile->fname=$request->fname;
        $profile->lname=$request->lname;
        $profile->email=$request->email;
        $profile->mothername=$request->mothername;
        $profile->fathername=$request->fathername;
        $profile->p_address=$request->p_address;
        $profile->address=$request->address;
        $profile->company_id=$request->company_id;
        $profile->joindate=$request->joindate;
        $profile->nid=$request->nid;
        $profile->mobile=$request->mobile;
        $profile->company_id=$request->company_id;

        $user->UserProfile()->save($profile);


        $project = Project::find($request->user_projects);
        $user->projects()->attach($project);

        return redirect()->route('userprofile')
            ->with('success','User created successfully');
    }

    public function projectByUser($id){

        $user = User::find($id);

        $userProjects = $user->projects;
//        var_dump($userProjects);die;
        $data = array();
        if($userProjects){

            foreach ($userProjects as $userProject){
                $data[]=array(
                    'id'=> $userProject->id,
                    'name'=> $userProject->p_name,
                );
            }
        }
        return response()->json($data);

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();


        return view('users.edit',compact('user','roles','userRole'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);


        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));
        }


        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();


        $user->assignRole($request->input('roles'));


        return redirect()->route('users.index')
            ->with('success','User updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success','User deleted successfully');
    }
}
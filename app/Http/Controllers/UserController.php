<?php


namespace App\Http\Controllers;


use App\Company;
use App\Payment;
use App\Payment_details;
use App\Project;
use App\UserProfile;
use App\UserProject;
use App\UserType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use Hash;


class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if(auth()->user()->can('users')){
            $data = User::withTrashed()->orderBy('id','DESC')->paginate(20);
            return view('users.index',compact('data'))
                ->with('i', ($request->input('page', 1) - 1) * 20);
        }
        return redirect()->route('payment')->with('error', 'Error! This are not permitted.');


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
        if (auth()->user()->can('users')) {
            $usertypes = UserType::all();
            $roles = Role::pluck('name', 'id')->all();

            //return view('roles.create',compact('permission'));
            $companies = Company::all();
            $userProjects = Project::all();
            return view('auth.register', ['roles' => $roles, 'usertypes' => $usertypes, 'companies' => $companies, 'projects' => $userProjects]);
        }
        return redirect()->route('payment')->with('error', 'Error! This are not permitted.');

    }

    public function userprofileEdit($id)
    {
        if (auth()->user()->can('users')) {
            $users = User::find($id);
            $roles = Role::pluck('name', 'name')->all();
            //$roles = Role::pluck('name','name')->all();
            $userRole = $users->roles->pluck('name', 'name')->all();


            $projects = Project::withTrashed()->get();
            $usertypes = UserType::all();
            $companies = Company::withTrashed()->get();

            return view('auth.edit', ['roles' => $roles, 'users' => $users, 'projects' => $projects, 'usertypes' => $usertypes, 'companies' => $companies, 'userRole' => $userRole]);

        }
        return redirect()->route('payment')->with('error', 'Error! This are not permitted.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'username' => 'required',
            'fname' => 'required',
            'email' => 'required|email|unique:users,email',
//            'password' => 'required|same:confirm-password',
        ]);

        $data = array(
            'name' => $request->fname.' '.$request->lname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'username'=> $request->username,
            'user_types_id'=> $request->user_types_id,
            'company_id'=>$request->company_id,
        );
        $user = User::create($data);
        //$user->assignRole($request->input('roles'));

        //DB::table('model_has_roles')->where('model_id')->delete();
        $user->assignRole($request->input('roles'));



        $profile= New UserProfile ;

//       $user->userProfile()->create();

        $profile->fname=$request->fname;
        $profile->lname=$request->lname;
        $profile->mothername=$request->mothername;
        $profile->fathername=$request->fathername;
        $profile->p_address=$request->p_address;
        $profile->address=$request->address;
        $profile->company_id=$request->company_id;
        $profile->joindate=$request->joindate;
        $profile->nid=$request->nid;
        $profile->mobile=$request->mobile;

       // $role = New Role;



        $user->UserProfile()->save($profile);
        $project = Project::find($request->user_projects);
        $user->projects()->attach($project);

        return redirect()->route('users.index')
            ->with('success','User created successfully');
    }

    public function userprofileUpdate(Request $request,$id){

        $user=User::find($id);
        $user->name=$request->fname. ' '.$request->lname;
        $user->email=$request->email;

//        $user->password=bcrypt($request->password);
        $user->username=$request->username;
        $user->user_types_id=$request->user_types_id;
      // $user->company_id=$request->company_id;

       // $user->User()->save($data);
//        $user->save();

//        $profile=UserProfile::find($user->UserProfile);

        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('roles'));

        $user->UserProfile->fname=$request->fname;
        $user->UserProfile->lname=$request->lname;
        $user->UserProfile->mothername=$request->mothername;
        $user->UserProfile->fathername=$request->fathername;
        $user->UserProfile->p_address=$request->p_address;
        $user->UserProfile->address=$request->address;
        $user->UserProfile->company_id=$request->company_id;
        $user->UserProfile->joindate=$request->joindate;
        $user->UserProfile->nid=$request->nid;
        $user->UserProfile->mobile=$request->mobile;

       // $profile->save();

        $user->push();

        $user->projects()->sync($request->user_projects);

        return redirect()->route('users.index')
            ->with('success','User Update successfully');

    }


    public function passwordChange(Request $request, $id){

        $user=User::find($id);
        $authUserId = Auth::user()['id'];
        if ($user->id==$authUserId){

            if($request->has('submit')){
                $user->password=bcrypt($request->password);
                $user->push();
                return redirect()->route('users.index')
                    ->with('success','Password Change successfully');
            }
            return view('auth.reset',['user'=>$user]);
        }
        return redirect()->route('payment')->with('error', 'Error! This are not permitted.');

    }
    public function passwordUpdate(Request $request, $id){

        $user=User::find($id);
        if($request->has('submit')){
            $user->password=bcrypt($request->password);
            $user->push();
            if(auth()->user()->hasRole('superadmin')){

                return redirect()->route('users.index')
                    ->with('success','Password Change successfully');
            }
            return redirect()->route('admin_index')
                ->with('success','Password Change successfully');
        }
        return view('auth.reset',['user'=>$user]);

    }

    public function projectByUser(Request $request, $id){

//        var_dump($request->company_id);die;

        $company = Company::find($request->company_id);
        $companyProjects = $company->project;

        $companyData = array();
        if($companyProjects){

            foreach ($companyProjects as $companyProject){
                $companyData[$companyProject->id]=array(
                    'id'=> $companyProject->id,
                    'name'=> $companyProject->p_name,
                );
            }
        }

        $user = User::find($id);
        $userProjects = $user->projects;

        $data = array();
        if($userProjects){

            foreach ($userProjects as $userProject){
                $data[$userProject->id]=array(
                    'id'=> $userProject->id,
                    'name'=> $userProject->p_name,
                );
            }
        }

        $creatorUserProjects = auth()->user()->projects;
        $creatorUserData = array();
        if($creatorUserProjects){
            foreach ($creatorUserProjects as $creatorUserProject){
                $creatorUserData[$creatorUserProject->id]=array(
                    'id'=> $creatorUserProject->id,
                    'name'=> $creatorUserProject->p_name,
                );
            }
        }
        $result=array_intersect_key($data,$creatorUserData,$companyData);

        $keys = array_column($result, 'name');

        array_multisort($keys, SORT_ASC, $result);

        return response()->json($result);
    }
//voucher payment id
    public function vocherAmount($id){

        $user=User::find($id);
//        $userPayments = $user->Payment;
        $userPayments = Payment::where('user_id', $id)->where('status', '=', 4)->get();
        $datas=array();
        if($userPayments){
            foreach ($userPayments as $userPayment){
                $datas[]=array(
                    'id'=>$userPayment->id,
                    'payment_id'=>$userPayment->payment_id,
                );
            }
        }
        return response()->json($datas);
    }

    public function voucherProject($id){

        $payment=Payment::find($id);
        $paymentProjects=$payment->Payment_details;

        $data=array();
        if($paymentProjects){
            foreach ($paymentProjects as $paymentProject){
                $project=Project::find($paymentProject->project_id);
                $data[]=array(
                    'id'=> $project->id,
                    'project'=> $project->p_name,
                );
            }
        }
        return response()->json($data);
    }

//paid
    public function paidAmount($payment, $project){

        $total_amount=0;

        $paymentDetails = DB::table('payment_details')
            ->where([
                ['payment_id', '=', $payment],
                ['project_id', '=', $project],
            ])
            ->get();
        $data=array();
        if($paymentDetails){
            $amount=0;
            foreach ($paymentDetails as $paymentDetail){

//                var_dump($PaidAmount->id);die;
                $amount+=$paymentDetail->paid_amount;
            }
            $data['amount']=$amount;
        }

        $amendmentDetails=DB::table('ammendments')->where([
            ['payment_id','=',$payment],
            ['project_id','=',$project],
        ])->get();

        $value=array();
        $datas=array();
        if($amendmentDetails){
            $tk=0;
            foreach ($amendmentDetails as $amendmentDetail){

                $tk+=$amendmentDetail->amendment_amount;
            }
            $value['tk']=$tk;
        }

        $datas['total_amount']=$data['amount']+$value['tk'];


        return response()->json($datas);
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
    //users delete method

    public function delete($id){
        $user=User::find($id);
        $user->delete();
        return redirect()->route('users.index')->with('success','User deleted successfully');
    }
    //users restore method

    public function userRestore($id){
        User::withTrashed()
            ->where('id', $id)
            ->restore();
        return redirect()->route('users.index')->with('success','User restored successfully');
    }
}
<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Mail\UserCreated;
use App\Models\User;
use App\Transformers\UserTransformer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('client.credentials')->only(['resend']);
        $this->middleware('auth:api')->except([ 'store', 'verify', 'resend']);

        $this->middleware('transform.input:' . UserTransformer::class)->only(['update']);
        $this->middleware('scope:manage-account')->only(['show', 'update']);

        $this->middleware('can:view,user')->only('show');
        $this->middleware('can:update,user')->only('update');
        $this->middleware('can:delete,user')->only('destroy');

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users=User::all();
        return $this->showall($users);
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,User $user)
    {
        $rules=[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|confirmed',

        ];
        $this->validate($request,$rules);
        $data=$request->all();
        $data['password']=bcrypt($request->password);
        $data['verified']=User::UNVERIFIED_USER;
        $data['verification_token']=User::generateVerificationCode();
        $data['admin']=User::REGULAR_USER;
        $user=User::create($data);
        return $this->showone($user,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user=User::findOrFail($id);
        return response()->json(["data"=>$user],200);
    }

    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $user=User::findOrFail($id);
        $rules=[

            'email'=>'email|unique:users,email,'.$user->id,
            'password'=>'min:6|confirmed',
            'admin'=>'in:'.User::ADMIN_USER.','. User::REGULAR_USER,



        ];
        $this->validate($request,$rules);
        if($request->has('name')){
          $user->name=$request->name;

        };
        if($request->has('email')&& $user->email != $request->email){
            $user->verified=User::UNVERIFIED_USER;
            $user->verification_token=User::generateVerificationCode();
            $user->email=$request->email;

        }
        if($request->has('admin')){
            if(!$user->isVerified()) {
                return  $this->errorResponse( 'only verified user can modify the admin filed', 409);

            }
            $user->admin=$request->admin;
        }
        if(!$user->isDirty()){
         return $this->errorResponse( 'you need to specify a different value to update', 422);

        }
        $user->save();
return $this->showone($user);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user=User::findOrFail($id);
        $user->delete();
        return response()->json(['data'=>$user],200);
    }

    public function me(Request $request)
    {
        $user = $request->user();

        return $this->showOne($user);
    }

    public function verify($token){
        $user=User::where('verification_token',$token)->firstOrFail();
        $user->verified=User::VERIFIED_USER;
        $user->verification_token=null;
        $user->save();
        return $this->showMessage('the account has been verified');

    }

    public function resend(User $user){
        if ($user->isVerified()) {
            return $this->errorResponse('This user is already verified', 409);

        }
        Mail::to($user)->send(new UserCreated($user));

        return $this->showMessage('The verification email has been resend');
    }
}

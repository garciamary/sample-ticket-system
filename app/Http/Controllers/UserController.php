<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;



class UserController extends Controller
{
    public function index(Request $request){
        // var_dump($request->query());
        $searchbox = $request->query('searchbox');
        if ($searchbox == ''){
            $users = User::All();
        }else{
            $users = User::where('name', 'Like','%'.$searchbox.'%') ->get();
        }
        return view('users.index', ['users' => $users]);
    }

    public function create(){
        return view('users.create');
    }



    /**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        var_dump($request ->input());
        $name =  $request->input('name');
        $email =  $request->input('email');
        $role =  $request->input('role');
        $password = Hash::make($request->input('password'));

        var_dump([$name,$email,$role,$password]);

        $user = new User;
        // $book->title = $request->title;
        $user->name = $name;
        $user->email = $email;
        $user->role = $role;
        $user->password = $password;
        $user->save();
      return Redirect::route('users.index');
        // $name = $request->input('name');

    }

    public function show($id, Request $request){
        // var_dump($id);
        $user = User::where('id', $id) ->first();
        // var_dump($book);
        return view('users.show', ['user' => $user]);
    }

    public function update($id, Request $request){
        $user = User::find($id);
        $user->name = $request->input('name');
        // $user->password = $request->input('password');
        if ($request->password != ''){
            $user->password = Hash::make($request->password);
        }
        $user->save();
        // die;
        return Redirect::route('users.index');
    }


    public function destroy($id, Request $request){
        // var_dump($id);
        User::destroy($id);
        // die;
        return Redirect::route('users.index');
    }

    public function apiGetAll(){

        $users = User::all();

        return response()->json($users,200);
    }

    public function apiGetOne($id){

        try {

            $users = User::where('id',$id)->firstOrFail();

        } catch (\Throwable $th) {

            return response()->json('User Not Found',404);

        }

        return response()->json($users,200);
    }

    public function apiCreateUser(Request $request){

        $validator = Validator::make($request->all(),[
            'email' => 'required | email | max:200 | unique:users,email',
            'name' => 'required | max:100',
            'role' => 'required | in:Member,Admin',
            'password' => 'required | min:5'
        ]);

        $data = $request->only([
            'name',
            'email',
            'role',
            'password'
        ]);

        if($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors, 400);
        }

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        if($user) {
            $responseData = [
                'status' => 'success',
                'message' => 'User Created'
            ];
            return response()->json($responseData, 200);

        } else {
            return response()->json('Unable to create user', 400);
        }

        return response()->json('',200);
    }


    public function apiUpdateUser($id, Request $request ) {

        $validator = Validator::make($request->all(),[
            'email' => 'required | email | max:200 | exists:users,email',
            'name' => 'required | max:100',
            'role' => 'required | in:Member,Admin',
            'password' => 'required | min:5'
        ]);

        if($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors, 400);
        }

        try {

            $userData = $request->only([
                'email',
                'name',
                'role',
                'password'
            ]);

            $userData['password'] = Hash::make($userData['password']);

            User::find($id)->update($userData);

            return response()->json($userData, 200);

        } catch (\Throwable $th) {

            return response()->json('User not created', 400);
        }

    }

    public function apiDestroy ($id, Request $request) {

        $users = User::all();

        User::destroy($id);

        return response()->json('User deleted', 400);
    }

    public function profile(Request $request){
        return $request->user();
    }


}

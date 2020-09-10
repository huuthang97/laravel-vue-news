<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;


class UserController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth:api');
    }

    public function findUsers(Request $request) {
        $search = $request->q;

        if ($search) {
            $users = User::where(function($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%")
                        ->orWhere('email', 'LIKE', "%$search%")
                        ->orWhere('type', 'LIKE', "%$search%");
            })->paginate(20);
        }
        else{
            $users = User::latest()->paginate(20);
        }
        
        return $users;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $this->authorize('isAdmin');
        if( \Gate::allows('isAdmin') || \Gate::allows('isAuthor') ) {
            return User::latest()->paginate(20);
        }
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
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6',
        ]);

        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'type' => $request['type'],
            'bio' => $request['bio'],
            'photo' => $request['photo'],
            'password' => Hash::make($request['password'])
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    
    public function updateProfile(Request $request)
    {
        // return $request->all();
        $user = auth('api')->user();
        $currentPhoto = $user->photo;
        $photo = $request->photo;
        $password = $request->password;

        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|required|min:6',
        ]);
        
        if ($photo != $currentPhoto) {
            $name = time() . '.' . explode(';', explode('/', $photo)[1])[0];
            // explode('/', explode(':', substr($photo, 0, strpos($photo, ';')))[1])[1];
            Image::make($photo)->save(public_path('img/profile/').$name);
            $request->merge(['photo' => $name]);
            $pathCurrentPhoto = public_path('img/profile/') . $currentPhoto;

            if ( file_exists($pathCurrentPhoto) ) {
                unlink($pathCurrentPhoto);
            }
        }

        if ( !empty($password) ) {
            $password = Hash::make($password);
            $request->merge(['password' => $password]);
        }
        $user->update($request->all());
        return ['message' => 'successed'];
    }


    public function profile()
    {
        return auth('api')->user();
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
        $user = User::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|min:6',
        ]);
        $user->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return ['message' => "Deleted a user"];
    }
}

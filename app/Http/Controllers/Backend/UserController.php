<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Datatables;
use File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDataTable $dataTable)
    {
        // return view('backend.user.index');
        return $dataTable->render('backend.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Role::orderBy('name')->get();
        $gender = User::gender();
        return view('backend.user.create', compact('role', 'gender'));
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
            'name' => 'required|string',
            'date_of_birth' => 'required|string',
            'gender' => 'required|string',
            'phone' => 'required|numeric|digits_between:10,13',
            'address' => 'required|string',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg',
            'email' => 'required|email|confirmed|unique:users,email',
            'password' => 'required|string|confirmed',
            'role' => 'required|string|exists:roles,name'
        ]);

        try {
            $dt = explode('/', $request->date_of_birth);
            $date = $dt[2] . '-' . $dt[1] . '-' . $dt[0]; 

            $image = null;
            if ($request->hasFile('photo')) {
                $image = time() . rand(100, 999) . '.' . $request->file('photo')->getClientOriginalExtension();
                $request->file('photo')->storeAs('users', $image, 'image');
            }

            $user = User::firstOrCreate([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'date_of_birth' => $date,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'address' => $request->address,
                'photo' => $image,
            ]);
            $user->assignRole($request->role);

            session()->flash('success', 'Data Berhasil di-Tambahkan !');
            return redirect(route('User.index'));
        } catch (\Exception $e) {
            dd($e);
            session()->flash('error', 'Terjadi Kesalahan !');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return view('backend.user.show', compact('user'));
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi Kesalahan !');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $user = User::findOrFail($id);
            $role = Role::orderBy('name', 'ASC')->get();
            $gender = User::gender();
            return view('backend.user.edit', compact('user', 'role', 'gender'));
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi Kesalahan !');
            return redirect()->back();
        }
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
        try {
            $user = User::findOrFail($id);
            $email = $user->email;
            $password = $user->password;

            $this->validate($request, [
                'name' => 'required|string',
                'date_of_birth' => 'required|string',
                'gender' => 'required|string',
                'phone' => 'required|numeric|digits_between:10,13',
                'address' => 'required|string',
                'photo' => 'nullable|image|mimes:jpg,png,jpeg',
                'role' => 'required|string|exists:roles,name'
            ]);
    
            if ($request->email != null) {
                $this->validate($request, [                
                    'email' => 'required|email|confirmed|unique:users,email',
                ]);
    
                $email = $request->email;
            }
    
            if ($request->password != null) {
                $this->validate($request, [
                    'password' => 'required|string|confirmed',
                ]);
    
                $password = bcrypt($request->password);
            }

            $dt = explode('/', $request->date_of_birth);
            $date = $dt[2] . '-' . $dt[1] . '-' . $dt[0];

            $image = null;
            if ($request->hasFile('photo')) {
                if ($user->photo != null) {
                    $path = 'images/users/'.$user->photo;
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                }

                $image = time() . rand(100, 999) . '.' . $request->file('photo')->getClientOriginalExtension();
                $request->file('photo')->storeAs('users', $image, 'image'); 
            }

            $user->update([
                'name' => $request->name,
                'email' => $email,
                'password' => $password,
                'date_of_birth' => $date,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'address' => $request->address,
                'photo' => $image,
            ]);
            $user->assignRole($request->role);

            session()->flash('success', 'Data Berhasil di-Ubah !');
            return redirect(route('User.index'));
        } catch (\Exception $e) {
            dd($e);
            session()->flash('error', 'Terjadi Kesalahan !');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            if ($user->photo != null) {
                $path = 'images/users/'.$user->photo;
                if (File::exists($path)) {
                    File::delete($path);
                }
            }

            session()->flash('warning', 'Data Berhasil di-Hapus !');
            return redirect(route('User.index'));
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi Kesalahan !');
            return redirect()->back();
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\Client;

class UsuarioclienteController extends Controller
{
    public function index()
    {
        $usuarios = User::role('Cliente')->get();
        $clientes = Client::all()->sortBy('razon_social')->pluck('razon_social', 'id');
        return view('admin.usuarioscliente.index', compact('usuarios', 'clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'email' =>'required',
            'pass' =>'required|min:8',
            'client_id' =>'required',
        ]);

        $passhash = Hash::make($request->pass);

        $us = User::create([
            'name' => $request->nombre,
            'email' => $request->email,
            'password' => $passhash,
            'client_id' => $request->client_id,
        ]);

        $us->roles()->sync(6);

        return redirect()->route('admin.usuarioscliente.index')->with('info', 'Usuario agregado con éxito');
    }


    public function edit($userv)
    {
        $user = User::find($userv);
        $clientes = Client::all()->sortBy('razon_social')->pluck('razon_social', 'id');
        return view('admin.usuarioscliente.edit', compact('user', 'clientes'));
    }

    public function update(Request $request, $userM)
    {
        $user = User::find($userM);

        $request->validate([
            'name' => 'required',
            'email' =>'required',
            'pass' =>'nullable|min:8',
            'client_id' =>'required',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        
        if($request->pass != null){
            $passhash = Hash::make($request->pass);
            $user->password = $passhash;
        }

        $user->client_id = $request->client_id;

        $user->save();

        return redirect()->route('admin.usuarioscliente.index')->with('info', 'Usuario modificado con éxito');

    }

    public function destroy(User $usuario)
    {
       $usuario->delete();
       return redirect()->route('admin.usuarioscliente.index')->with('info', 'Usuario eliminado con éxito');
    }
}

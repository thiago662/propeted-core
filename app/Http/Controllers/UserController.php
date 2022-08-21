<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Lista e filtra todos os usuarios.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::with(['role']);

        if ($request->active) {
            $users->where('active', $request->active);
        }

        if ($request->role_id) {
            $users->where('role_id', $request->role_id);
        }

        if ($request->email) {
            $users->where('email', 'ilike', '%' . $request->email . '%');
        }

        if ($request->name) {
            $users->where('name', 'ilike', '%' . $request->name . '%');
        }

        return $users->paginate($request->per_page);
    }

    /**
     * Retornar as opções de usuarios.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function option()
    {
        return User::all();
    }

    /**
     * Cria um usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        User::create($request->all());
    }

    /**
     * Exibe um usuario pelo id.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Atualizar um usuario pelo id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->all());
    }

    /**
     * Deleta um usuario pelo id.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
    }
}

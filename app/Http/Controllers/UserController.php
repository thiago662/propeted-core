<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;

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
        return User::select([
            'id',
            'name',
        ])->get();
    }

    /**
     * Cria um usuario.
     *
     * @param  \App\Http\Requests\UserStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $request->merge([
            'email' => Str::lower($request->email),
            'password' => Hash::make($request->password),
        ]);

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
     * @param  \App\Http\Requests\UserUpdateRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $request->merge([
            'email' => Str::lower($request->email),
        ]);

        if ($request->password) {
            $request->merge([
                'password' => Hash::make($request->password),
            ]);
        } else {
            unset($request['password']);
        }

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

    public function profile()
    {
        return Auth::user();
    }
}

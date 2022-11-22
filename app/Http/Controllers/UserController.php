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
        $user = Auth::user();

        if ($user->role_id == 4) {
            return User::query()
                ->with(['role'])
                ->where('id', $user->id)
                ->paginate($request->per_page);
        }

        $users = User::query()
            ->with(['role'])
            ->when($user->role_id != 1, function ($query) {
                $query->whereIn('role_id', [2,3,4]);
            });

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function option(Request $request)
    {
        $user = Auth::user();

        return User::select([
            'id',
            'name',
        ])
            ->when($user->role_id != 1, function ($query) {
                $query->whereIn('role_id', [2,3,4]);
            })
            ->when(!is_null($request->role_ids), function ($query) use ($request) {
                $query->whereIn('role_id', $request->role_ids);
            })
            ->get();
    }

    /**
     * Cria um usuario.
     *
     * @param  \App\Http\Requests\UserStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $userAuth = Auth::user();

        if ($userAuth->role_id == 4) {
            return [];
        }

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
        $userAuth = Auth::user();

        if (($userAuth->role_id == 4 && $userAuth->id != $user->id) || ($userAuth->role_id != 1 && $user->role_id == 1)) {
            return [];
        }

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
        $userAuth = Auth::user();

        if (($userAuth->role_id == 4 && $userAuth->id != $user->id) || ($userAuth->role_id != 1 && $user->role_id == 1)) {
            return [];
        }

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

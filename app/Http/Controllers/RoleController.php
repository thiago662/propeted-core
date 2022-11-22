<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Lista e filtra todos as funções.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Role::paginate($request->per_page);
    }

    /**
     * Retornar as opções de função.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function option()
    {
        $user = Auth::user();

        return Role::query()
            ->when($user->role_id != 1, function ($query) {
                $query->whereIn('id', [2,3,4]);
            })
            ->get();
    }

    /**
     * Cria uma função.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Role::create($request->all());
    }

    /**
     * Exibe uma função pelo id.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return $role;
    }

    /**
     * Atualizar uma função pelo id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $role->update($request->all());
    }

    /**
     * Atualizar uma função pelo id.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
    }
}

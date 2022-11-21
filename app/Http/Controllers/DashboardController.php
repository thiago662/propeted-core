<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;

class DashboardController extends Controller
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
}

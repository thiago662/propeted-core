<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Animal;
use App\Models\Owner;
use App\Models\Schedule;

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
        $user = Auth::user();

        $animals = Animal::query()->count();
        $owners = Owner::query()->count();
        $users = User::query()->when(in_array($user->role_id, [2,3,4]), function ($query) {
            $query->whereIn('role_id', [2,3,4]);
        })->count();
        $openSchedules = Schedule::query()
            ->when($user->role_id == 3, function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where(function ($query) {
                $query->where('finished', false)
                ->orWhere('finished', null);
            })
            ->count();
        $closedSchedulesNotDone = Schedule::query()
            ->when($user->role_id == 3, function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('finished', true)
            ->where(function ($query) {
                $query->where('answered', false)
                    ->orWhere('answered', null);
            })
            ->count();
        $closeDoSchedules = Schedule::query()
            ->when($user->role_id == 3, function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('finished', true)
            ->where('answered', true)
            ->count();

        return [
            'animals_count' => $animals,
            'owners_count' => $owners,
            'users_count' => $users,
            'open_schedules_count' => $openSchedules,
            'closed_schedules_not_done_count' => $closedSchedulesNotDone,
            'closed_schedules_done_count' => $closeDoSchedules,
        ];
    }
}

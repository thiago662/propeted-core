<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\Schedule;
use App\Models\Interection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\OwnerStoreRequest;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $schedules = Schedule::query()
            ->with(['interection', 'user', 'animal']);

        if ($user->role_id == 3) {
            $schedules->where('user_id', $user->id);
        }

        if ($request->title) {
            $schedules->where('title', 'ilike', '%' . $request->title . '%');
        }

        if ($request->animal_id) {
            $schedules->where('animal_id', $request->animal_id);
        }

        if ($request->user_id) {
            $schedules->where('user_id', $request->user_id);
        }

        if ($request->schedule_at) {
            $schedules->whereDate('schedule_at', $request->schedule_at);
        }

        if ($request->finished) {
            if ($request->finished == 'true') {
                $schedules->where('finished', true);
            } else {
                $schedules->where(function ($query) {
                    $query->where('finished', false)
                        ->orWhere('finished', null);
                });
            }
        }

        if ($request->answered) {
            if ($request->answered == 'true') {
                $schedules->where('answered', true);
            } else {
                $schedules->where(function ($query) {
                    $query->where('answered', false)
                        ->orWhere('answered', null);
                });
            }
        }

        return $schedules->orderBy('schedule_at', 'DESC')->paginate($request->per_page);
    }

    /**
     * Retornar as opções de usuarios.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function option()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $params = $request->all();

        unset($params['id']);

        $user = Auth::user();

        $params = array_merge($params, ['created_by' => $user->id]);

        $interection = Interection::create($params);

        $schedule = $interection->schedule()->create($params);

        return $schedule;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        return $schedule;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        $schedule->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        $interection = $schedule->interection();

        $interection->delete();

        $schedule->delete();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function finish(Request $request, Schedule $schedule)
    {
        $schedule->update([
            'finished' => true,
            'finish_at' => new Carbon(),
            'answered' => $request->answered,
            'response_message' => $request->response_message,
            'response_body' => $request->response_body,
        ]);
    }
}

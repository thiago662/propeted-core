<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\OwnerStoreRequest;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $owners = Owner::query();

        if ($request->active) {
            $owners->where('active', $request->active);
        }

        if ($request->name) {
            $owners->where('name', 'ilike', '%' . $request->name . '%');
        }

        if ($request->email) {
            $owners->where('email', 'ilike', '%' . $request->email . '%');
        }

        if ($request->person_id) {
            $owners->where('person_id', 'ilike', '%' . $request->person_id . '%');
        }

        if ($request->phone_number) {
            $owners->where('phone_number', 'ilike', '%' . $request->phone_number . '%');
        }

        if ($request->cell_phone_number) {
            $owners->where('cell_phone_number', 'ilike', '%' . $request->cell_phone_number . '%');
        }

        if ($request->zip_code) {
            $owners->where('zip_code', 'ilike', '%' . $request->zip_code . '%');
        }

        if ($request->state) {
            $owners->where('state', 'ilike', '%' . $request->state . '%');
        }

        if ($request->city) {
            $owners->where('city', 'ilike', '%' . $request->city . '%');
        }

        if ($request->neighborhood) {
            $owners->where('neighborhood', 'ilike', '%' . $request->neighborhood . '%');
        }

        if ($request->street) {
            $owners->where('street', 'ilike', '%' . $request->street . '%');
        }

        if ($request->house_number) {
            $owners->where('house_number', 'ilike', '%' . $request->house_number . '%');
        }

        if ($request->address_reference) {
            $owners->where('address_reference', 'ilike', '%' . $request->address_reference . '%');
        }

        return $owners->paginate($request->per_page);
    }

    /**
     * Retornar as opções de usuarios.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function option(Request $request)
    {
        return Owner::select([
            'id',
            'name',
        ])
            ->when(!is_null($request->animal_id), function ($query) use ($request) {
                $animal = Animal::find($request->animal_id);

                $owners = $animal->owners->pluck('id');

                $query->whereIn('id', $owners);
            })
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\OwnerStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OwnerStoreRequest $request)
    {
        $user = Auth::user();

        $owner = Owner::create($request->all());

        $pivot = [];

        foreach ($request->animals as $animal) {
            $pivot[] = $animal['animal_id'];
        }

        $pivot = array_filter(array_unique($pivot));

        $owner->animals()->sync($pivot);

        $interection = $owner->interections()->create([
            'created_by' => $user->id,
            'type' => 'create',
        ]);

        $message = $interection->message()->create([
            'title' => 'criado',
            'message' => 'criado',
            'user_id' => $user->id,
            'owner_id' => $owner->id,
        ]);

        return $owner;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Owner  $owner
     * @return \Illuminate\Http\Response
     */
    public function show(Owner $owner)
    {
        return $owner->load(['interections' => function($query) {
            $query->with(['message'])->orderBy('created_at', 'DESC');
        }, 'animals']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Owner  $owner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Owner $owner)
    {
        $owner->update($request->all());

        $pivot = [];

        foreach ($request->animals as $animal) {
            $pivot[] = $animal['animal_id'];
        }

        $pivot = array_filter(array_unique($pivot));

        $owner->animals()->sync($pivot);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Owner  $owner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Owner $owner)
    {
        $owner->delete();
    }
}

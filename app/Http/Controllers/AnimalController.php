<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $animals = Animal::query();

        if ($request->active) {
            $animals->where('active', $request->active);
        }

        if ($request->name) {
            $animals->where('name', 'ilike', '%' . $request->name . '%');
        }

        if ($request->species) {
            $animals->where('species', 'ilike', '%' . $request->species . '%');
        }

        if ($request->breed) {
            $animals->where('breed', 'ilike', '%' . $request->breed . '%');
        }

        return $animals->paginate($request->per_page);
    }

    /**
     * Retornar as opções de usuarios.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function option()
    {
        return Animal::select([
            'id',
            'name',
        ])->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $animal = Animal::create($request->all());

        $pivot = [];

        foreach ($request->owners as $owner) {
            $pivot[] = $owner['owner_id'];
        }

        $pivot = array_filter(array_unique($pivot));

        $animal->owners()->sync($pivot);

        $interection = $animal->interections()->create([
            'user_id' => $user->id,
        ]);

        $message = $interection->message()->create([
            'title' => 'criado',
            'message' => 'criado',
            'user_id' => $user->id,
            'animal_id' => $animal->id,
        ]);

        return $animal;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function show(Animal $animal)
    {
        return $animal->load(['interections' => function($query) {
            $query->with(['message'])->orderBy('created_at', 'DESC');
        }, 'owners']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Animal $animal)
    {
        $animal->update($request->all());

        $pivot = [];

        foreach ($request->owners as $owner) {
            $pivot[] = $owner['owner_id'];
        }

        $pivot = array_filter(array_unique($pivot));

        $animal->owners()->sync($pivot);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Animal $animal)
    {
        $animal->delete();
    }
}

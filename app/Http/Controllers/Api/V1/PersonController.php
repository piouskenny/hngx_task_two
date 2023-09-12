<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PersonStoreRequest;
use App\Models\Person;
use App\Http\Resources\Api\V1\PersonResource;
use App\Http\Resources\Api\V1\PersonCollection;


class PersonController extends Controller
{
    public function index()
    {
        $person = Person::paginate(15);

        if (count($person) < 1) {
            return response()->json("No Persons has been added to the database yet");
        }
        return new PersonCollection($person);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(PersonStoreRequest $request)
    {
        $request->validated();

        $person = Person::create([
            'name' => $request->name
        ]);

        if ($person) {
            $message = [
                'response_message' => "Person Created successfuly",
                'status' => 200
            ];

            return response()->json($message);
        }
        return response()->json(['message' => 'sorry cannot add person at the moment', 'status' => 200]);
    }

    /**
     * Display the specified resource.
     */
    public function find(string $id)
    {
        $person = Person::find($id);

        return new PersonResource($person);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PersonStoreRequest $request, string $id)
    {
        $person = Person::find($id);

        $request->validated();
        
        $update = $person->update($request->all());
        if ($update) {
            return response()->json(['message' => 'Details has been updated successfully', 'status' => 200]);
        }
        return response()->json(['message' => 'Details was not updated', 'status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $person_delete = Person::destroy($id);

        if($person_delete) {
            return response()->json(['message' => "Person with id $id was deleted successfuly", 'status' => 200]);
        }   
    }
}

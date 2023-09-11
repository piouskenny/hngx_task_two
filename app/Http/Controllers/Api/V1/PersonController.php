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
    public function store(PersonStoreRequest $request)
    {
        $request->validated();

        $person = Person::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address
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
    public function show(string $id)
    {
        $person = Person::find($id);

        return new PersonResource($person);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $person = Person::find($id);

        $request->validate([
            'name' => 'regex:/^[a-zA-Z0-9\s]+$/',
            'email' => 'email',
            'address' => 'regex:/^[a-zA-Z0-9\s]+$/|nullable',
        ]);

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
        $person = Person::destroy($id);
    }
}

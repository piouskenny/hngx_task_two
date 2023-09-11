<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PersonStoreRequest;
use App\Models\Person;
use App\Http\Resources\Api\V1\PersonResource;


class PersonController extends Controller
{
    public function index()
    {
        $person = Person::all();

        if (count($person) < 1) {
            return response()->json("No Persons has been added to the database yet");
        }
        return response()->json($person);
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
        return response()->json("Failed to create Person");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // return response()->json("Working");
        $person = Person::find($id);

        return new PersonResource($person);
        // return response()->json($person);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $person = Person::find($id);
        $person->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $person = Person::destroy($id);
    }
}

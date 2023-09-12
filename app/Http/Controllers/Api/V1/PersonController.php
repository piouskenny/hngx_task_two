<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PersonStoreRequest;
use App\Models\Person;
use App\Http\Resources\Api\V1\PersonResource;
use App\Http\Resources\Api\V1\PersonCollection;
use Illuminate\Support\Facades\DB;



class PersonController extends Controller
{
    public function checkDatabaseConnection()
    {
        try {
            DB::table('hngx_task_two')->get();
            return "Database connection successful!";
        } catch (\Exception $e) {
            return "Database connection failed: " . $e->getMessage();
        }
    }

    public function showDatabaseConnectionStatus()
    {
        $message = $this->checkDatabaseConnection();

        return view('database_status', ['message' => $message]);
    }
    public function index()
    {
        $person = Person::paginate(15);

        if (count($person) < 1) {
            $message = [
                'response_message' => "Collection of All Persons",
                'status' => 200
            ];
            return response()->json($message);
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
                'status' => 201
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

        if ($person_delete) {
            return response()->json(['message' => "Person with id $id was deleted successfuly", 'status' => 200]);
        }
    }
}

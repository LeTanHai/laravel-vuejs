<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function search(Request $request) {
        switch ($request->type) {
            case "combo_box":
                $user = User::select('users.*', 'locations.origin', 'locations.id as location_id')
                            ->leftJoin('locations', 'users.id', '=', 'locations.user_id')
                            ->where('users.name', 'like', "%{$request->keySearch}%")
                            ->orWhere('users.email', 'like', "%{$request->keySearch}%")
                            ->limit(10)->get()->sortByDesc("id");
                $data = array_reduce($user->toArray(), function(&$listData, $item) {
                    $tmp = new \stdClass();
                    $tmp->id = $item["id"];
                    $tmp->name = $item["name"];
                    $tmp->email = $item["email"];
                    $tmp->origin = $item["origin"];
                    $tmp->location_id = $item["location_id"];
                    $listData[] = $tmp;
                    return $listData;
                }, []);
                return response()->json($data);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Location;

class LocationController extends Controller
{
    public function getLocation() {
        $location = Location::where('user_id', Auth::user()->id)
                            ->get();
        $data = array_reduce($location->toArray(), function(&$list, $item) {
            $tmp = new \stdClass;
            $tmp->user_id = $item["user_id"];
            $tmp->origin["lat"] = floatval(explode(",", $item["origin"])[0]);
            $tmp->origin["lng"] = floatval(explode(",", $item["origin"])[1]);
            $tmp->destination["lat"] = floatval(explode(",", $item["destination"])[0]);
            $tmp->destination["lng"] = floatval(explode(",", $item["destination"])[1]);
            $tmp->status = $item["status"];
            $list = $tmp;
            return $list;
        }, []);
        return response()->json($data);
    }

    public function updateOriginLocation(Request $request) {
        $lat = $request->lat;
        $lng = $request->lng;
        $origin = $lat.','.$lng;
        $temp="";
        $locations = Location::where("origin", "like", "%$temp%")->update(['origin' => $origin]);
        return response()->json($locations);
    }

    // public function updateLocation(Request $request) {
    //     $location = Location::find($request->user_id);
    //     $location->location_new = $request->location_new;
    //     return response()->json(["location" => $location,
    //                             "status" => $location->save(),
    //                             "number" => 201]);
    // }
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

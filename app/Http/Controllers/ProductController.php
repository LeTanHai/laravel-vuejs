<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderShipped;


use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function getProduct(Request $request) {
        switch ($request->type){
            case "none":
                $product = Product::where('user_id', Auth::user()->id)
                            ->get();
                foreach($product as $item) {                    
                    $resData = new \stdClass;
                    $resData->name = $item->name;
                    $resData->code = $item->code;
                    $resData->user_id = $item->user_id;
                    $resData->description = $item->description;
                    $resData->origin["lat"] = floatval(explode(",", $item->location->origin)[0]);
                    $resData->origin["lng"] = floatval(explode(",", $item->location->origin)[1]);
                    $resData->destination["lat"] = floatval(explode(",", $item->location->destination)[0]);
                    $resData->destination["lng"] = floatval(explode(",", $item->location->destination)[1]);
                    $resData->location_new["lat"] = floatval(explode(",", $item->location_new)[0]);
                    $resData->location_new["lng"] = floatval(explode(",", $item->location_new)[1]);
                    $resData->status = $item->status;
                    $resData->pickup = $item->pickup;
                    $list[] = $resData;
                }
                return response()->json($list);
            case "view":
                $item = Product::find($request->id);                  
                $resData = new \stdClass;
                $resData->id = $item->id;
                $resData->name = $item->name;
                $resData->code = $item->code;
                $resData->user_id = $item->user_id;
                $resData->description = $item->description;
                $resData->origin["lat"] = floatval(explode(",", $item->location->origin)[0]);
                $resData->origin["lng"] = floatval(explode(",", $item->location->origin)[1]);
                $resData->destination["lat"] = floatval(explode(",", $item->location->destination)[0]);
                $resData->destination["lng"] = floatval(explode(",", $item->location->destination)[1]);
                $resData->location_new["lat"] = floatval(explode(",", $item->location_new)[0]);
                $resData->location_new["lng"] = floatval(explode(",", $item->location_new)[1]);
                $resData->status = $item->status;
                $resData->pickup = $item->pickup;
                $list[] = $resData;
                return response()->json($list);
            case "admin":
                $product = Product::get();
                foreach($product as $item) {                  
                    $resData = new \stdClass;
                    $resData->id = $item->id;
                    $resData->name = $item->name;
                    $resData->code = $item->code;
                    $resData->user_id = $item->user_id;
                    $resData->description = $item->description;
                    $resData->origin["lat"] = floatval(explode(",", $item->location->origin)[0]);
                    $resData->origin["lng"] = floatval(explode(",", $item->location->origin)[1]);
                    $resData->destination["lat"] = floatval(explode(",", $item->location->destination)[0]);
                    $resData->destination["lng"] = floatval(explode(",", $item->location->destination)[1]);
                    $resData->location_new["lat"] = floatval(explode(",", $item->location_new)[0]);
                    $resData->location_new["lng"] = floatval(explode(",", $item->location_new)[1]);
                    $resData->status = $item->status;
                    $resData->pickup = $item->pickup;
                    $list[] = $resData;
                }
                return response()->json($list);
        }
    }

    public function getInfoItem(Request $request) {
        $product = Product::where('user_id', 1)
                            ->get();
        foreach($product as $item) {                    
            $resData = new \stdClass;
            $resData->name = $item->name;
            $resData->code = $item->code;
            $resData->description = $item->description;
            $resData->origin["lat"] = floatval(explode(",", $item->location->origin)[0]);
            $resData->origin["lng"] = floatval(explode(",", $item->location->origin)[1]);
            $resData->destination["lat"] = floatval(explode(",", $item->location->destination)[0]);
            $resData->destination["lng"] = floatval(explode(",", $item->location->destination)[1]);
            $resData->location_new["lat"] = floatval(explode(",", $item->location_new)[0]);
            $resData->location_new["lng"] = floatval(explode(",", $item->location_new)[1]);
            $resData->status = $item->status;
            $resData->pickup = $item->pickup;
            $list = $resData;
        }
        return response()->json($list);
    }

    public function updateStatus(Request $request) {
        $product = Product::where('code',$request->code)->get();
        $product[0]->status = $request->status;
        $product[0]->pickup = $request->pickup;
        // if ($request->status === 2 && $request->pickup === 0) {
        //     //event(new OrderShipped($request->status));
        //     Mail::to(Auth::user()->email)->send(new OrderShipped($request->status));
        // }
        return response()->json(["product" => $product,
                                "status" => $product[0]->save(),
                                "number" => 201]);
    }

    public function updateLocationProduct(Request $request) {
        $product = Product::where('code', $request->code)->get();
        $product[0]->location_new = $request->location_new;
        return response()->json(["product" => $product,
                                "status" => $product[0]->save(),
                                "number" => 201]);
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

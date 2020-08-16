<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Collection;
use App\Mail\OrderShipped;


use Illuminate\Http\Request;
use App\Product;
use App\GlobalConfig;
use Maatwebsite\Excel\Facades\Excel;


class ProductController extends Controller
{   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProduct(Request $request) {
        switch ($request->type){
            case "none":
                $product = Product::where('user_id', Auth::user()->id)
                            ->get();
                foreach($product as $item) {                    
                    $objTmp = new \stdClass;
                    $objTmp->name = $item->name;
                    $objTmp->code = $item->code;
                    $objTmp->user_id = $item->user_id;
                    $objTmp->description = $item->description;
                    $objTmp->origin["lat"] = floatval(explode(",", $item->location->origin)[0]);
                    $objTmp->origin["lng"] = floatval(explode(",", $item->location->origin)[1]);
                    $objTmp->destination["lat"] = floatval(explode(",", $item->location->destination)[0]);
                    $objTmp->destination["lng"] = floatval(explode(",", $item->location->destination)[1]);
                    $objTmp->location_new["lat"] = $objTmp->origin["lat"];
                    $objTmp->location_new["lng"] = $objTmp->origin["lng"];
                    if (!empty($item->location_new)) {
                        $objTmp->location_new["lat"] = floatval(explode(",", $item->location_new)[0]);
                        $objTmp->location_new["lng"] = floatval(explode(",", $item->location_new)[1]);
                    }
                    $objTmp->status = $item->status;
                    $objTmp->pickup = $item->pickup;
                    $list = $objTmp;
                }
                return response()->json($list);
            case "slide_bar":
                $product = Product::where('user_id', Auth::user()->id)
                            ->get();
                foreach($product as $item) {                    
                    $objTmp = new \stdClass;
                    $objTmp->id = $item->id;
                    $objTmp->name = $item->name;
                    $objTmp->code = $item->code;
                    $objTmp->user_id = $item->user_id;
                    $list[] = $objTmp;
                }
                return response()->json($list);
            case "view":
            case "user":
                $item = Product::find($request->id);                  
                $objTmp = new \stdClass;
                $objTmp->id = $item->id;
                $objTmp->name = $item->name;
                $objTmp->code = $item->code;
                $objTmp->user_id = $item->user_id;
                $objTmp->email = $item->user->email;
                $objTmp->description = $item->description;
                $objTmp->origin["lat"] = floatval(explode(",", $item->location->origin)[0]);
                $objTmp->origin["lng"] = floatval(explode(",", $item->location->origin)[1]);
                $objTmp->destination["lat"] = floatval(explode(",", $item->location->destination)[0]);
                $objTmp->destination["lng"] = floatval(explode(",", $item->location->destination)[1]);
                $objTmp->location_new["lat"] = $objTmp->origin["lat"];
                $objTmp->location_new["lng"] = $objTmp->origin["lng"];
                if (!empty($item->location_new)) {
                    $objTmp->location_new["lat"] = floatval(explode(",", $item->location_new)[0]);
                    $objTmp->location_new["lng"] = floatval(explode(",", $item->location_new)[1]);   
                }
                $objTmp->status = $item->status;
                $objTmp->pickup = $item->pickup;
                return response()->json($objTmp);
            case "admin":
                $product = Product::select('products.*', 'users.email as email')
                                ->leftJoin('users', 'users.id', '=', 'products.user_id')
                                ->where('email', 'like', "%{$request->keySearch}%")
                                ->orWhere('products.name', 'like', "%{$request->keySearch}%")
                                ->orWhere('products.code', 'like', "%{$request->keySearch}%")
                                ->orWhere('products.status', 'like', "%{$request->keySearch}%");
                $totalRecord = $product->count();
                if ($request->limit == "*") {
                    $listProduct = $product->offset(0);
                }
                else {
                    $offset = (intval($request->currentPage) - 1) * intval($request->limit);
                    $listProduct = $product->offset($offset)->limit(intval($request->limit));
                }
                $listProduct = $product->get()->sortBy("products.id");
                $list = [];
                foreach($listProduct as $item) {                  
                    $objTmp = new \stdClass;
                    $objTmp->id = $item->id;
                    $objTmp->name = $item->name;
                    $objTmp->code = $item->code;
                    $objTmp->user_id = $item->user_id;
                    $objTmp->email = $item->email;
                    $objTmp->description = $item->description;
                    $objTmp->pickup = $item->pickup;
                    $objTmp->origin["lat"] = floatval(explode(",", $item->location->origin)[0]);
                    $objTmp->origin["lng"] = floatval(explode(",", $item->location->origin)[1]);
                    $objTmp->destination["lat"] = floatval(explode(",", $item->location->destination)[0]);
                    $objTmp->destination["lng"] = floatval(explode(",", $item->location->destination)[1]);
                    $objTmp->location_new["lat"] = $objTmp->origin["lat"];
                    $objTmp->location_new["lng"] = $objTmp->origin["lng"];
                    if (!empty($item->location_new)) {
                        $objTmp->location_new["lat"] = floatval(explode(",", $item->location_new)[0]);
                        $objTmp->location_new["lng"] = floatval(explode(",", $item->location_new)[1]);
                    } 
                    $objTmp->status = GlobalConfig::getListStatus()[$item->status];
                    $objTmp->created_at = new \DateTime($item["created_at"]);
                    $objTmp->created_at = $objTmp->created_at->format(env('DATETIMEFORMAT', 'm/d/Y h:i A'));
                    $objTmp->updated_at = $item["updated_at"];
                    if (!empty($item["updated_at"])) {
                        $objTmp->updated_at = new \DateTime($item["updated_at"]);
                        $objTmp->updated_at = $objTmp->updated_at->format(env('DATETIMEFORMAT', 'm/d/Y h:i A'));
                    }
                    $list[] = $objTmp;
                }
                return response()->json(["listProduct" => $list,
                                        "totalRecord" => $totalRecord,
                                        "from_date" => $request->from_date,
                                        "to_date"=> $request->to_date]);
            case "export":
                return Excel::download(new ExportController($request), 'products.xlsx');
        }
    }

    public function modifyProduct(Request $request) {
        switch($request->type) {
            case "new":
                $product = [
                    'name' => $request->name,
                    'code' => $request->code,
                    'description' => $request->description,
                    'user_id' => intval($request->user_id),
                    'location_id' => intval($request->location_id)
                ];
                try {
                    $data = Product::create($product);
                    if (!$data) {
                        return response()->json(["error" => "products.errors.motify.new"]);    
                    }
                    return response()->json(["error" => "", "data" => $data->id]);
                }
                catch(\Illuminate\Database\QueryException $e) {
                    return response()->json(["error" => "products.errors.motify.new"]);   
                }
            case "edit":
                try {
                    $newProduct = $request->except(['id', 'type', 'email', 'origin', 'destination', 'location_new', 'status', 'pickup']);
                    $oldProduct = Product::find($request->id);
                    $diff = array_diff_assoc($newProduct, $oldProduct->toArray());
                    if (empty($diff)) {
                        return response()->json(["error" => "", "status" => true]);
                    }
                    $oldProduct->fill($diff);
                    return response()->json(["error" => "", "status" => $oldProduct->save()]);
                }
                catch(\Illuminate\Database\QueryException $e) {
                    return response()->json(["error" => "products.errors.motify.edit"]);
                }
            case "delete":
                try{
                    $product = Product::find($request->id)->delete();
                    if (!$product) {
                        return response()->json(["error" => "products.errors.motify.delete"]);
                    }
                    return response()->json(["error" => ""]);
                }
                catch(\Illuminate\Database\QueryException $e) {
                    return response()->json(["error" => "products.errors.motify.delete"]);
                }
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInfoItem(Request $request) {
        $product = Product::where('user_id', 1)
                            ->get();
        foreach($product as $item) {                    
            $objTmp = new \stdClass;
            $objTmp->name = $item->name;
            $objTmp->code = $item->code;
            $objTmp->description = $item->description;
            $objTmp->origin["lat"] = floatval(explode(",", $item->location->origin)[0]);
            $objTmp->origin["lng"] = floatval(explode(",", $item->location->origin)[1]);
            $objTmp->destination["lat"] = floatval(explode(",", $item->location->destination)[0]);
            $objTmp->destination["lng"] = floatval(explode(",", $item->location->destination)[1]);
            $objTmp->location_new["lat"] = floatval(explode(",", $item->location_new)[0]);
            $objTmp->location_new["lng"] = floatval(explode(",", $item->location_new)[1]);
            $objTmp->status = $item->status;
            $objTmp->pickup = $item->pickup;
            $list = $objTmp;
        }
        return response()->json($list);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request) {
        $product = Product::where('code',$request->code)->get();
        $product[0]->status = $request->status;
        $product[0]->pickup = $request->pickup;
        if ($request->status == 1) {
            $product[0]->description = "shipping";
        }
        else if ($request->status == 2) {
            $product[0]->description = "delivered";
        }
        return response()->json(["product" => $product,
                                "status" => $product[0]->save(),
                                "number" => 201]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateLocationProduct(Request $request) {
        $product = Product::where('code', $request->code)->get();
        $product[0]->location_new = $request->location_new;
        $description = $product[0]->description;
        //send mail.....
        $status = $product[0]->status;
        $user_email = $product[0]->user->email;
        $data = array('name'=>"ABCD");
        // Path or name to the blade template to be rendered
        $template_path = 'email_template';
        $content = $product[0]->name;
        if ($status == 1 && $description != "shipping") {
            Mail::send($template_path, $data, function($message) use ($user_email, $content) {
                $message->to($user_email, 'Receiver Name')->subject('Orders are being delivered');
                $message->from('ims_merchandise@outlook.com.vn',"{$content}".' is comming!');
            });
            $product[0]->description = "shipping";
            return response()->json(["product" => $product,
                                "status" => $product[0]->save(),
                                "number" => 201]);
        }
        if ($status == 2 && $description != "delivered") {
            Mail::send($template_path, $data, function($message) use ($user_email, $content) {
                $message->to($user_email, 'Receiver Name')->subject('Orders has been shipped');
                $message->from('ims_merchandise@outlook.com.vn',"{$content}".' has been shipped!');
            });
            $product[0]->description = "delivered";
            return response()->json(["product" => $product,
                                "status" => $product[0]->save(),
                                "number" => 201]);
        }
        return response()->json(["product" => $product,
                                "status" => $product[0]->save(),
                                "number" => 201]);
    }

    public function sendMail(Request $request) {
        try {
            $product = Product::where('code', $request->code)->get();
            $user_email = $product[0]->user->email;
            $data = array('name'=>"ABCD");
            // Path or name to the blade template to be rendered
            $template_path = 'email_template';
            Mail::send($template_path, $data, function($message) use ($user_email, $content) {
                // Set the receiver and subject of the mail.
                $message->to($user_email, 'Receiver Name')->subject('TEST SEND MAIL');
                // Set the sender
                $message->from('ims_merchandise@outlook.com.vn',"{$content}");
            });
            return response()->json($product);
        }
        catch(Exception $e) {
            return response()->json($product);
        }
        
    }
}

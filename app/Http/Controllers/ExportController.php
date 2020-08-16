<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

use App\Product;

class ExportController extends Controller implements FromCollection,WithHeadings,WithMapping
{   
    public function __construct($request)
    {
        $this->limit = $request->limit;
        $this->currentPage = $request->currentPage;
        $this->keySearch = $request->keySearch;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $product = Product::select('products.*', 'users.email as email')
                        ->leftJoin('users', 'users.id', '=', 'products.user_id')
                        ->where('email', 'like', "%{$this->keySearch}%")
                        ->orWhere('products.name', 'like', "%{$this->keySearch}%")
                        ->orWhere('products.code', 'like', "%{$this->keySearch}%")
                        ->orWhere('products.status', 'like', "%{$this->keySearch}%");
        $totalRecord = $product->count();
        if ($this->limit == "*") {
            $listProduct = $product->offset(0);
        }
        else {
            $offset = (intval($this->currentPage) - 1) * intval($this->limit);
            $listProduct = $product->offset($offset)->limit(intval($this->limit));
        }
        $listProduct = $product->get()->sortBy("products.id");
        return $listProduct;
    }
    /**
     * Returns headers for report
     * @return array
     */
    public function headings(): array {
        return [
            'Name',
            'Email',
            'Code',
            'Description',
            'Status',    
            "Created",
            "Updated"
            
        ];
    }
 
    public function map($listProduct): array {
        if ($listProduct->status == 0) {
            $listProduct->status = "Not Pickup";
        }
        else if($listProduct->status == 1) {
            $listProduct->status = "Shipping";
        }
        else {
            $listProduct->status = "Delivered";
        }
        return [
            $listProduct->name,
            $listProduct->email,
            $listProduct->code,
            $listProduct->description,
            $listProduct->status,
            $listProduct->created_at,
            $listProduct->updated_at
        ];
    }

}

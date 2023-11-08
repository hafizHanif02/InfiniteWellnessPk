<?php

namespace App\Imports\Purchase;

use App\Models\Log;
use App\Models\Inventory\Vendor;
use App\Models\Inventory\Product;
use Illuminate\Support\Collection;
use App\Models\Purchase\Requistion;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase\RequistionProduct;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class RequistionImport implements SkipsEmptyRows, ToCollection, WithHeadingRow, WithValidation
{
    public function rules(): array
    {
        return [
            'vendor' => ['required', 'exists:vendors,contact_person', 'max: 255'],
            'remarks' => ['nullable', 'string', 'max:255'],
            'delivery_date' => ['nullable','date_format:Y/m/d'],
            'product_name' => ['required', 'string', 'max:255', 'exists:products,product_name'],
            'limit' => ['required', 'string', 'in:unit_quantity,box_quantity'],
            'price_per_unit' => ['required', 'numeric', 'min:0'],
            'total_piece' => ['required', 'numeric', 'min:1'],
            'total_amount' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $requistion = Requistion::create([
                'vendor_id' => Vendor::where('contact_person', $row['vendor'])->pluck('id')->first(),
                'remarks' => $row['remarks'],
                'delivery_date' => $row['delivery_date']
            ]);
            $user = Auth::user();
            $requistionproductlogs = 'Requistion No. '.$requistion->id.' Products:{[produc_id, qty],';
            $product = Product::where('product_name', $row['product_name'])->first();
            RequistionProduct::create([
                'requistion_id' => $requistion->id,
                'product_id' => $product->id,
                'limit' => $row['limit'] == 'unit_quantity' ? 1 : 0,
                'price_per_unit' => $row['price_per_unit'],
                'total_piece' => $row['total_piece'],
                'total_amount' => $row['total_amount'],
            ]);
            $requistionproductlogs .= '['.$product->id.','.$row['total_piece'].'],'; 
        }
        $requistionproductlogs .= '}';
        $logs = Log::create([
            'action' => 'Requistion Has Been Created Requistion No.'.$requistion->id ,
            'action_by_user_id' => $user->id,
        ]);
        $fileName = 'requistion/' . $logs->id . '.txt'; 
        $filePath = public_path($fileName); 
        $directory = dirname($filePath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        file_put_contents($filePath, $requistionproductlogs);
    }
}

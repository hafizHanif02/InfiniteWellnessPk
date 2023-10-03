<?php

namespace App\Exports;

use App\Models\Shift\TransferProduct;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StockOutExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    public function headings(): array
    {
        return [
            // 'Group',
            'Generic Formula',
            'Category',
            'Manufacturer',
            // 'Vendor',
            'Code',
            'Product Name',
            'Package Detail',
            'Least Unit',
            'Trade Price Percentage',
            'Number Of Pack',
            'Pieces Per Pack',
            'Packing',
            'Trade Price',
            'Unit Retail',
            'Fixed Discount',
            'Manufacturer Retail Price',
            'Unit Trade',
            'Sale Tax',
            'Discount Trade Price',
            'Cost Price',
            'Barcode',
            'Date',
        ];
    }

    public function map($stockOut): array
    {
        return [
            // $stockOut->product->group->name,
            $stockOut->product->generic->formula,
            $stockOut->product->productCategory->name,
            $stockOut->product->manufacturer->company_name,
            // $stockOut->product->vendor->account_title,
            $stockOut->product->code,
            $stockOut->product->product_name,
            $stockOut->product->package_detail,
            $stockOut->product->least_unit == '1' ? 'Piece' : 'Pack',
            $stockOut->product->trade_price_percentage,
            $stockOut->product->number_of_pack,
            $stockOut->product->pieces_per_pack,
            $stockOut->product->packing,
            $stockOut->product->trade_price,
            $stockOut->product->unit_retail,
            $stockOut->product->fixed_discount,
            $stockOut->product->manufacturer_retail_price,
            $stockOut->product->unit_trade,
            $stockOut->product->sale_tax,
            $stockOut->product->discount_trade_price,
            $stockOut->product->cost_price,
            $stockOut->product->barcode,
            $stockOut->transfer->created_at->format('d M Y'),
        ];
    }

    public function collection()
    {
        return TransferProduct::with(['product', 'product.generic', 'product.vendor', 'product.manufacturer', 'product.productCategory', 'transfer'])->get();
    }
}

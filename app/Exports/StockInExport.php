<?php

namespace App\Exports;

use App\Models\Inventory\StockIn;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StockInExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    public function headings(): array
    {
        return [
            'Group',
            'Generic Formula',
            'Category',
            'Manufacturer',
            'Vendor',
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

    public function map($stockIn): array
    {
        return [
            $stockIn->group->name,
            $stockIn->generic->formula,
            $stockIn->productCategory->name,
            $stockIn->manufacturer->company_name,
            $stockIn->vendor->account_title,
            $stockIn->code,
            $stockIn->product_name,
            $stockIn->package_detail,
            $stockIn->least_unit == '1' ? 'Piece' : 'Pack',
            $stockIn->trade_price_percentage,
            $stockIn->number_of_pack,
            $stockIn->pieces_per_pack,
            $stockIn->packing,
            $stockIn->trade_price,
            $stockIn->unit_retail,
            $stockIn->fixed_discount,
            $stockIn->manufacturer_retail_price,
            $stockIn->unit_trade,
            $stockIn->sale_tax,
            $stockIn->discount_trade_price,
            $stockIn->cost_price,
            $stockIn->barcode,
            $stockIn->created_at->format('d M Y'),
        ];
    }

    public function collection()
    {
        return StockIn::with(['group', 'generic', 'vendor', 'manufacturer', 'productCategory'])->get();
    }
}

<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ProductQuantityInRange implements Rule
{
    public function passes($attribute, $value)
    {
        // $attribute is the name of the attribute being validated (e.g., 'products.0.product_quantity')
        $parts = explode('.', $attribute);
        $index = $parts[1]; // Get the index of the product in the array

        $totalStock = request()->input("products.$index.total_stock");

        return is_numeric($value) && $value >= 1 && $value <= $totalStock;

    }

    public function message()
    {
        return 'Product quantity must be between 1 and total stock for each product.';
    }
}



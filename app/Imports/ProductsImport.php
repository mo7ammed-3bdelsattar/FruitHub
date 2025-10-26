<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // dd($row);
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        return new Product([
            'title' => $row['title'] ?? 'product',
            'description' => $row['description'] ?? "description",
            'price' => $row['price'] ?? 0,
            'category_id' => $row['category_id'] ?? 2,
            'discount' => $row['discount'] ?? 0,
        ]);
    }
    public function chunkSize(): int
    {
        return 1000; // يقرأ كل مرة 1000 صف بس
    }
}

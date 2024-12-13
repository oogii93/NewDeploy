<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ProductImport implements ToModel
{
    public function model(array $row)
    {
        // Skip header row
        if ($row[0] === '営業所') {
            return null;
        }

        // Skip completely empty rows
        if ($this->isRowEmpty($row)) {
            return null;
        }

        // Sanitize input values
        $officeName = $this->sanitizeString($row[0]);
        $makerName = $this->sanitizeString($row[1]);
        $productNumber = $this->sanitizeString($row[2]);
        $productName = $this->sanitizeString($row[3]);
        $pieces = $this->sanitizeNumeric($row[4]);
        $icmNet = $this->sanitizeNumeric($row[5]);
        $purchaseDate = $this->transformDate($row[6]);
        $purchasedFrom = $this->sanitizeString($row[7]);
        $listPrice = $this->sanitizeNumeric($row[8]);
        $remarks = $this->sanitizeString($row[9]);

        // Find existing product with multiple matching criteria
        $existingProduct = Product::where(function ($query) use (
            $officeName, $makerName, $productNumber, $productName,
            $pieces, $icmNet, $purchaseDate, $purchasedFrom, $listPrice
        ) {
            $query->where('office_name', $officeName)
                  ->where('maker_name', $makerName)
                  ->where('product_number', $productNumber)
                  ->where('product_name', $productName)
                  ->where('pieces', $pieces)
                  ->where('icm_net', $icmNet)
                  ->where('purchase_date', $purchaseDate)
                  ->where('purchased_from', $purchasedFrom)
                  ->where('list_price', $listPrice);
        })->first();

        // If an exact match is found, skip
        if ($existingProduct) {
            return null;
        }

        // If no exact match, check for a similar product
        $similarProduct = Product::where(function ($query) use (
            $officeName, $makerName, $productNumber, $productName
        ) {
            $query->where('office_name', $officeName)
                  ->where('maker_name', $makerName)
                  ->where(function ($subQuery) use ($productNumber, $productName) {
                      $subQuery->where('product_number', $productNumber)
                               ->orWhere('product_name', $productName);
                  });
        })->first();

        // If a similar product is found, update it
        if ($similarProduct) {
            $similarProduct->update([
                'pieces' => $pieces,
                'icm_net' => $icmNet,
                'purchase_date' => $purchaseDate,
                'purchased_from' => $purchasedFrom,
                'list_price' => $listPrice,
                'remarks' => $remarks
            ]);

            return null;
        }

        // Create new product if no similar product exists
        return new Product([
            'office_name' => $officeName,
            'maker_name' => $makerName,
            'product_number' => $productNumber,
            'product_name' => $productName,
            'pieces' => $pieces,
            'icm_net' => $icmNet,
            'purchase_date' => $purchaseDate,
            'purchased_from' => $purchasedFrom,
            'list_price' => $listPrice,
            'remarks' => $remarks
        ]);
    }

    // Existing helper methods remain the same...
    private function sanitizeString($value)
    {
        return isset($value) && is_string($value) && trim($value) !== '' ? trim($value) : null;
    }

    private function sanitizeNumeric($value)
    {
        return isset($value) && is_numeric($value) ? (int)floor((float)$value) : null;
    }

    private function transformDate($dateValue)
    {
        try {
            if (is_numeric($dateValue)) {
                return Date::excelToDateTimeObject($dateValue)->format('Y-m-d');
            }
            return date('Y-m-d', strtotime($dateValue));
        } catch (\Exception $e) {
            return null;
        }
    }

    private function isRowEmpty(array $row)
    {
        foreach ($row as $value) {
            if (!is_null($this->sanitizeString($value)) || !is_null($this->sanitizeNumeric($value))) {
                return false;
            }
        }
        return true;
    }
}

<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ProductImport implements ToModel
{
    public function model(array $row)
    {
        if ($row[0] === '営業所') {
            return null; // Skip the header row
        }

        try {
            return new Product([
                'office_name' => $this->sanitizeString($row[0]),
                'maker_name' => $this->sanitizeString($row[1]),
                'product_number' => $this->sanitizeString($row[2]),
                'product_name' => $this->sanitizeString($row[3]),
                'pieces' => $this->sanitizeNumeric($row[4]),
                'icm_net' => $this->sanitizeNumeric($row[5]),
                'purchase_date' => $this->transformDate($row[6]),
                'purchased_from' => $this->sanitizeString($row[7]),
                'list_price' => $this->sanitizeNumeric($row[8]),
                'remarks' => $this->sanitizeString($row[9]),
            ]);
        } catch (\Exception $e) {
            return null;
        }
    }

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
        foreach ($row as $value)
        {
            if(!is_null($this->sanitizeString($value)) || !is_null($this->sanitizeNumeric($value)))
            {
                return false;
            }
        }
        return true;
    }
}

// Controller Method


<?php

namespace App\Http\Controllers;


use App\Models\Product;
use Illuminate\Http\Request;
use App\Imports\ProductImport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Services\NetworkFileImportService;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;



class ProductController extends Controller
{








    protected $networkImportService;

    public function __construct(NetworkFileImportService $networkImportService)
    {
        $this->networkImportService=$networkImportService;
    }

    public function autoImport()
    {
        return $this->networkImportService->autoImport();
    }

    public function index(Request $request)
    {
        $searchQuery = $request->input('search');

        $products = Product::query();

        if ($searchQuery) {
            $products->where(function ($query) use ($searchQuery) {
                $query->where('office_name', 'like', '%' . $searchQuery . '%')
                      ->orWhere('maker_name', 'like', '%' . $searchQuery . '%')
                      ->orWhere('product_number', 'like', '%' . $searchQuery . '%')
                      ->orWhere('product_name', 'like', '%' . $searchQuery . '%')
                      ->orWhere('pieces', 'like', '%' . $searchQuery . '%')
                      ->orWhere('icm_net', 'like', '%' . $searchQuery . '%')
                      ->orWhere('purchase_date', 'like', '%' . $searchQuery . '%')
                      ->orWhere('purchased_from', 'like', '%' . $searchQuery . '%')
                      ->orWhere('list_price', 'like', '%' . $searchQuery . '%')
                      ->orWhere('remarks', 'like', '%' . $searchQuery . '%');
            });
        }

        $products = $products->paginate(100);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'office_name' => 'nullable|string|max:255',
            'maker_name' => 'nullable|string|max:255',
            'product_number' => 'nullable|string|max:255',
            'product_name' => 'nullable|string|max:255',
            'pieces' => 'nullable|integer',
            'icm_net' => 'nullable|integer',
            'purchase_date' => 'nullable|date',
            'purchased_from' => 'nullable|string|max:255',
            'list_price' => 'nullable|integer',
            'remarks' => 'nullable|string'
        ]);

        // Create the product
        $product = Product::create($validatedData);

        return redirect()->route('products.index')
            ->with('success', '製品が正常に作成されました。');
    }

    // public function store(Request $request)
    // {
    //     $product = Product::create($request->all());
    //     return redirect()->route('products.index')->with('success', 'Product created successfully.');
    // }
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }


    public function update(Request $request, $id)
    {
        // Find the product
        $product = Product::findOrFail($id);

        // Validate the request
        $validatedData = $request->validate([
            'office_name' => 'nullable|string|max:255',
            'maker_name' => 'nullable|string|max:255',
            'product_number' => 'nullable|string|max:255',
            'product_name' => 'nullable|string|max:255',
            'pieces' => 'nullable|integer',
            'icm_net' => 'nullable|integer',
            'purchase_date' => 'nullable|date',
            'purchased_from' => 'nullable|string|max:255',
            'list_price' => 'nullable|integer',
            'remarks' => 'nullable|string'
        ]);

        // Update the product
        $product->update($validatedData);

        return redirect()->route('products.index')
            ->with('success', '製品が正常に更新されました。');
    }


    public function destroy($id)
    {
        // Find the product
        $product = Product::findOrFail($id);

        // Delete the product
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', '製品が正常に削除されました。');
    }



    public function importData(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            $file = $request->file('excel_file');
            Excel::import(new ProductImport, $file);

            return redirect()->route('products.index')
                ->with('success', '製品は正常にインポートされました。');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            return redirect()->back()
                ->withErrors($failures)
                ->with('error', 'There were some issues with the import.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'An error occurred during import: ' . $e->getMessage());
        }
    }
   /**
    * Export products to an Excel file.
    *
    * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
    */

    public function export()
    {
        // $networkFilePath = '//172.16.153.8/出勤簿/1.xlsx';
        $networkFilePath = '\\\\172.16.153.8\\出勤簿\\1.xlsx';
        try {
            // Define the network file path


            // Check if the network file exists
            if (!file_exists($networkFilePath)) {
                return redirect()->back()
                    ->with('error', 'File not found at the specified network location.');
            }

            // Load the existing file
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($networkFilePath);

            // Get the active sheet
            $sheet = $spreadsheet->getActiveSheet();

            // Clear existing data, keeping headers intact
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $sheet->removeRow(2, $highestRow - 1);

            // Fetch updated products from the database
            $products = \App\Models\Product::all();

            // Start writing products at row 2
            $row = 2;

            foreach ($products as $product) {
                $sheet->setCellValue("A{$row}", $product->office_name)
                      ->setCellValue("B{$row}", $product->maker_name)
                      ->setCellValue("C{$row}", $product->product_number)
                      ->setCellValue("D{$row}", $product->product_name)
                      ->setCellValue("E{$row}", $product->pieces)
                      ->setCellValue("F{$row}", $product->icm_net)
                      ->setCellValue("G{$row}", $product->purchase_date)
                      ->setCellValue("H{$row}", $product->purchased_from)
                      ->setCellValue("I{$row}", $product->list_price)
                      ->setCellValue("J{$row}", $product->remarks);

                $row++;
            }

            // Save the updated file back to the network location
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save($networkFilePath);

            return redirect()->back()
                ->with('success', 'Products exported successfully to the network file.');

        } catch (\Exception $e) {
            // Log the error and return an appropriate message
            \Log::error('Export error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An error occurred during export: ' . $e->getMessage());
        }
    }












}

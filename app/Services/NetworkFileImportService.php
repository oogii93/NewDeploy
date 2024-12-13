<?php

namespace App\Services;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class NetworkFileImportService
{
    /**
     * Automatically import Excel file from a network location
     *
     * @return \Illuminate\Http\RedirectResponse
     */

    //  public function autoImport()
    //  {
    //      try {
    //          // Local file path - use forward slashes or double backslashes
    //          $localFilePath = 'C:\\Users\\RPC120\\Pictures\\過剰在庫品(2020.08.20時点）.xlsx';

    //          // Alternative method using Storage facade
    //          // $localFilePath = storage_path('app/imported_file.xlsx');

    //          // Check if file exists
    //          if (!file_exists($localFilePath)) {
    //              Log::error('File not found: ' . $localFilePath);
    //              return redirect()->back()
    //                  ->with('error', 'File not found: ' . $localFilePath);
    //          }

    //          // Import the file
    //          Excel::import(new ProductImport, $localFilePath);

    //          return redirect()->route('products.index')
    //              ->with('success', 'Products imported automatically from local file.');

    //      } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
    //          // Handle Excel import validation errors
    //          $failures = $e->failures();

    //          Log::error('Import validation errors', [
    //              'failures' => $failures
    //          ]);

    //          return redirect()->back()
    //              ->withErrors($failures)
    //              ->with('error', 'There were some issues with the automatic import.');

    //      } catch (\Exception $e) {
    //          // Log full error details
    //          Log::error('Automatic import error', [
    //              'message' => $e->getMessage(),
    //              'file' => $e->getFile(),
    //              'line' => $e->getLine()
    //          ]);

    //          return redirect()->back()
    //              ->with('error', 'An error occurred during automatic import: ' . $e->getMessage());
    //      }
    //  }

    private function getNetworkFilePath()
    {
        $paths = [
            '//172.16.153.8/出勤簿/1.xlsx',        // Network style
            '\\\\172.16.153.8\出勤簿\1.xlsx',      // Windows UNC path
            '/mnt/network/出勤簿/1.xlsx',          // Potential Linux mount
            'Z:/出勤簿/1.xlsx',                    // Mapped drive
            '/var/www/network/1.xlsx'              // Potential server mount point
        ];

        foreach ($paths as $path) {
            // Normalize path separators
            $normalizedPath = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $path);

            if (file_exists($normalizedPath)) {
                return $normalizedPath;
            }
        }

        throw new \Exception('Network file not found: ' . implode(', ', $paths));
    }
    public function autoImport()
    {
        try {
            // Get network file path
            $networkFilePath = $this->getNetworkFilePath();

            // Log details for debugging
            \Log::info('Importing from path: ' . $networkFilePath);
            \Log::info('File exists: ' . (file_exists($networkFilePath) ? 'Yes' : 'No'));
            \Log::info('Current working directory: ' . getcwd());
            \Log::info('Server OS: ' . PHP_OS);

            // Import the file
            Excel::import(new ProductImport, $networkFilePath);

            return redirect()->route('products.index')
                ->with('success', 'Products imported automatically from network location.');

        } catch (\Exception $e) {
            // Comprehensive error logging
            \Log::error('Automatic import error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return redirect()->back()
                ->with('error', 'Automatic import failed: ' . $e->getMessage());
        }
    }



    /**
     * Determine the full path to the network file
     *
     * @return string
     */

}

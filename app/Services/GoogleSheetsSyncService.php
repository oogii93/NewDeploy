<?

namespace App\Services;

use Google\Client;
use App\Models\Product;
use Google\Service\Sheets;
use Illuminate\Support\Facades\Log;
use Google\Service\Sheets\ValueRange;
use PhpOffice\PhpSpreadsheet\IOFactory;


class GoogleSheetsSyncService
{
    protected $client;
    protected $sheetsService;
    protected $spreadsheetId;
    protected $networkFilePath;


    public function __construct()
    {


        $this->networkFilePath = '\\\\172.16.153.8\\出勤簿\\1.xlsx';


      $this->client = new \Google_Client();
        $this->client->setAuthConfig(storage_path('google_credentials.json'));
        $this->client->addScope(Sheets::SPREADSHEETS);


        $this->sheetsService = new Sheets($this->client);
        $this->spreadsheetId = env('GOOGLE_SHEETS_SPREADSHEET_ID');


    }

     // Pull data from Local Server Excel to Google Sheets
     public function pullFromLocalServerToGoogleSheets()
     {
         try {
             // Check if network file exists
             if (!file_exists($this->networkFilePath)) {
                 throw new \Exception('Network file not found');
             }

             // Load the Excel file
             $spreadsheet = IOFactory::load($this->networkFilePath);
             $worksheet = $spreadsheet->getActiveSheet();
             $data = $worksheet->toArray();

             // Prepare data for Google Sheets (skip header)
             $values = [
                 ['営業所', 'メーカー', '商品番号', '商品名', '数量', 'ICM Net', '購入日', '購入先', '定価', '備考']
             ];

             // Start from row 2 to skip header
             for ($i = 1; $i < count($data); $i++) {
                 $row = $data[$i];
                 $values[] = [
                     $row[0] ?? null,   // office_name
                     $row[1] ?? null,   // maker_name
                     $row[2] ?? null,   // product_number
                     $row[3] ?? null,   // product_name
                     $row[4] ?? null,   // pieces
                     $row[5] ?? null,   // icm_net
                     $row[6] ?? null,   // purchase_date
                     $row[7] ?? null,   // purchased_from
                     $row[8] ?? null,   // list_price
                     $row[9] ?? null,   // remarks
                 ];
             }

             // Update Google Sheets
             $body = new ValueRange([
                 'values' => $values
             ]);

             $params = [
                 'valueInputOption' => 'RAW'
             ];

             $this->sheetsService->spreadsheets_values->update(
                 $this->spreadsheetId,
                 'Sheet1!A1',
                 $body,
                 $params
             );

             return 'Successfully pulled data from local server to Google Sheets';
         } catch (\Exception $e) {
             Log::error('Pull from Local Server Error: ' . $e->getMessage());
             throw $e;
         }
     }

     // Push data from Google Sheets to Local Server Excel
     public function pushFromGoogleSheetsToLocalServer()
     {
         try {
             // Fetch data from Google Sheets
             $response = $this->sheetsService->spreadsheets_values->get(
                 $this->spreadsheetId,
                 'Sheet1!A:J'
             );
             $values = $response->getValues();

             // Remove header row
             array_shift($values);

             // Load existing spreadsheet
             $spreadsheet = IOFactory::load($this->networkFilePath);
             $worksheet = $spreadsheet->getActiveSheet();

             // Clear existing data (keeping header)
             $highestRow = $worksheet->getHighestRow();
             $worksheet->removeRow(2, $highestRow - 1);

             // Write data to spreadsheet
             $row = 2;
             foreach ($values as $value) {
                 $worksheet->fromArray($value, null, "A{$row}");
                 $row++;
             }

             // Save the updated file back to the network location
             $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
             $writer->save($this->networkFilePath);

             return 'Successfully pushed data from Google Sheets to local server';
         } catch (\Exception $e) {
             Log::error('Push to Local Server Error: ' . $e->getMessage());
             throw $e;
         }
     }

    public function importFromGoogleSheets()
    {
        try{
            $response=$this->sheetsService->spreadsheets_values->get(
                $this->spreadsheetId,
                'Sheet1!A2:J' // Adjust range as needed
            );

            $values=$response->getValues();

               // Clear existing data
               Product::truncate();

                     // Import data
            foreach ($values as $row) {
                Product::create([
                    'office_name' => $row[0] ?? null,
                    'maker_name' => $row[1] ?? null,
                    'product_number' => $row[2] ?? null,
                    'product_name' => $row[3] ?? null,
                    'pieces' => $row[4] ?? null,
                    'icm_net' => $row[5] ?? null,
                    'purchase_date' => $row[6] ?? null,
                    'purchased_from' => $row[7] ?? null,
                    'list_price' => $row[8] ?? null,
                    'remarks' => $row[9] ?? null,
                ]);
            }

            return true;

        }
        catch (\Exception $e) {
            \Log::error('Google Sheets Import Error: ' . $e->getMessage());
            return false;
        }
    }


    public function exportToGoogleSheets()
    {
        try {
            // Fetch products
            $products = Product::all();

            // Prepare data for Google Sheets
            $values = [
                ['営業所', 'メーカー', '商品番号', '商品名', '数量', 'ICM Net', '購入日', '購入先', '定価', '備考']
            ];

            foreach ($products as $product) {
                $values[] = [
                    $product->office_name,
                    $product->maker_name,
                    $product->product_number,
                    $product->product_name,
                    $product->pieces,
                    $product->icm_net,
                    $product->purchase_date,
                    $product->purchased_from,
                    $product->list_price,
                    $product->remarks
                ];
            }

            // Update Google Sheets
            $body = new \Google_Service_Sheets_ValueRange([
                'values' => $values
            ]);

            $params = [
                'valueInputOption' => 'RAW'
            ];

            $this->sheetsService->spreadsheets_values->update(
                $this->spreadsheetId,
                'Sheet1!A1',
                $body,
                $params
            );

            return true;
        } catch (\Exception $e) {
            \Log::error('Google Sheets Export Error: ' . $e->getMessage());
            return false;
        }
    }
}

?>

<?php
namespace App\Http\Controllers;

use App\Models\NameCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use thiagoalessio\TesseractOCR\TesseractOCR;

class NameCardController extends Controller
{



    public function diagnostics()
{
    $checks = [
        'php_version' => PHP_VERSION,
        'tesseract_version' => shell_exec('tesseract --version 2>&1'),
        'tesseract_path' => shell_exec('where tesseract'),
        'php_extensions' => get_loaded_extensions(),
        'tessdata_dir' => glob('C:\Program Files\Tesseract-OCR\tessdata\*')
    ];

    return response()->json($checks);
}





public function testOCR()
{
    try {
        // Explicitly set Tesseract path for XAMPP
        $tesseractPath = 'C:\Program Files\Tesseract-OCR\tesseract.exe';

        // Create a test image for OCR (create a simple text image)
        $testImagePath = storage_path('app/test_ocr.png');

        // Create a simple image with text (you might want to create this separately)
        $im = imagecreate(200, 50);
        $background = imagecolorallocate($im, 255, 255, 255);
        $textColor = imagecolorallocate($im, 0, 0, 0);
        imagestring($im, 5, 10, 10, "Test OCR Text", $textColor);
        imagepng($im, $testImagePath);
        imagedestroy($im);

        // Perform OCR
        $tesseract = new \thiagoalessio\TesseractOCR\TesseractOCR($testImagePath);

        // Explicitly set the executable path
        $tesseract->executable($tesseractPath);

        // Run OCR
        $text = $tesseract->run();

        // Delete test image
        unlink($testImagePath);

        // Return or log the extracted text
        \Log::info('OCR Test Result: ' . $text);
        return "OCR Test Successful. Extracted Text: " . $text;
    } catch (\Exception $e) {
        // Log the full error
        \Log::error('OCR Test Error: ' . $e->getMessage());
        return "OCR Test Failed: " . $e->getMessage();
    }
}
    public function index()
    {

        $namecards = NameCard::all();

        return view('namecards.index', compact('namecards'));
    }

    public function create()
    {
        return view('namecards.create');
    }
    public function store(Request $request)
    {
        try {
            // Validate the incoming request
            $validatedData = $request->validate([
                'image_data' => 'required|string', // Base64 image string
            ]);

            // Decode the Base64 image data
            $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $validatedData['image_data']);
            $imageData = base64_decode($imageData);

            // Save the image to storage
            $filename = 'namecard_' . uniqid() . '.png';
            $path = storage_path('app/public/namecards/' . $filename);

            // Ensure directory exists
            if (!is_dir(storage_path('app/public/namecards'))) {
                mkdir(storage_path('app/public/namecards'), 0755, true);
            }

            file_put_contents($path, $imageData);

            // Perform OCR on the saved image
            $tesseract = new TesseractOCR($path);
            $tesseract->lang('eng', 'jpn');
            $extractedText = $tesseract->run();

            // Parse the extracted text into fields
            $extractedData = $this->parseNameCardText($extractedText);

            // Create a new NameCard record
            $nameCard = new NameCard();

            // Map extracted data to model fields
            $nameCard->name = $extractedData['name'] ?? null;
            $nameCard->company = $extractedData['company'] ?? null;
            $nameCard->address = $extractedData['address'] ?? null;
            $nameCard->phone = $extractedData['phone'] ?? null;
            $nameCard->email = $extractedData['email'] ?? null;

            // Store the original image filename
            $nameCard->image_path = $filename;

            // Save the name card to database
            $nameCard->save();

            // Return the extracted data as JSON
            return response()->json([
                'success' => true,
                'message' => 'Name card processed and saved successfully',
                'extractedData' => $extractedData,
                'nameCard' => $nameCard
            ]);
        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            \Log::error('Error in NameCard OCR and Storage: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to process and store the name card. ' . $e->getMessage(),
            ], 500);
        }
    }

    // Parse text to extract name, company, email, phone, address
    private function parseNameCardText($text)
    {
        $data = [];

        // Updated patterns for Japanese name cards
        $patterns = [
            'name' => [
                '/^[ぁ-んァ-ヶ一-龯a-zA-Z\s\.\-]+$/u'
            ],
        'company' => [
    '/(?:株式会社|有限会社|合同会社|企業)?\s*[ぁ-んァ-ヶ一-龯\s]+(?:株式会社|有限会社|合同会社|企業)?/u'
],

            'phone' => [
                '/TEL\s*[:：]?\s*([\d\-]+)/u', // Match phone numbers
                '/携帯\s*[:：]?\s*([\d\-]+)/u' // Match mobile numbers
            ],
         'email' => [
   '/\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}\b/u'
         ],
         'address' => [
            '/〒\d{3}-\d{4}\s*(?:[ぁ-んァ-ヶ一-龯]+(?:県|都|道|府))?[ぁ-んァ-ヶ一-龯\d\s\-]+/u'
                ],
        ];

        $lines = preg_split('/\R/', $text);

        foreach ($patterns as $key => $patternSet) {
            foreach ($lines as $line) {
                foreach ($patternSet as $pattern) {
                    \Log::info("Trying pattern for $key: $pattern on line: $line");

                    if (preg_match($pattern, $line, $matches)) {
                        // Different handling for email and other fields
                        $data[$key] = $key === 'email'
                            ? trim($matches[0])
                            : ($key === 'phone' && isset($matches[1])
                                ? trim($matches[1])
                                : trim($matches[0]));

                        \Log::info("Matched $key: " . $data[$key]);
                        break 2; // Break out of both inner loops
                    }
                }
            }
        }

        // Log final extracted data
        \Log::info('Final extracted data: ' . print_r($data, true));

        return $data;
    }


    public function show(NameCard $namecard)
    {
        return view('namecards.show', [
            'namecard' => $namecard
        ]);
    }



}

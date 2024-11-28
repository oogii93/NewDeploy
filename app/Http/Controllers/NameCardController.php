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
                '/([ぁ-んァ-ヶ一-龯]+\s*[ぁ-んァ-ヶ一-龯]+)/u' // Match full names
            ],
            'company' => [
                '/(?:株式会社|有限会社|合同会社|企業)\s*[ぁ-んァ-ヶ一-龯]+/u' // Match company names with common suffixes
            ],
            'address' => [
                '/〒\s*[:：]?\s*([\d\-]+)/u' // Match postal code and address
            ],
            'phone' => [
                '/TEL\s*[:：]?\s*([\d\-]+)/u', // Match phone numbers
                '/携帯\s*[:：]?\s*([\d\-]+)/u' // Match mobile numbers
            ],
            'email' => [
                '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/u' // Match email addresses
            ]
        ];

        foreach ($patterns as $key => $patternSet) {
            foreach ($patternSet as $pattern) {
                if (preg_match($pattern, $text, $matches)) {
                    $data[$key] = trim($matches[1]);
                    break;
                }
            }
        }

        return $data;
    }


    public function show(NameCard $namecard)
    {
        return view('namecards.show', [
            'namecard' => $namecard
        ]);
    }



}

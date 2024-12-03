<?php
namespace App\Http\Controllers;

use App\Models\NameCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Intervention\Image\Facades\Image;
use Tesseract\Tesseract;
use Illuminate\Support\Facades\Log;

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
public function index(Request $request)
{
    $searchQuery = $request->input('search');

    $nameCardData = NameCard::when($searchQuery, function ($query, $searchQuery) {
        $query->where('name', 'like', '%' . $searchQuery . '%')
              ->orWhere('email', 'like', '%' . $searchQuery . '%')
              ->orWhere('phone', 'like', '%' . $searchQuery . '%')
              ->orWhere('mobile', 'like', '%' . $searchQuery . '%')
              ->orWhere('company', 'like', '%' . $searchQuery . '%')
              ->orWhere('address', 'like', '%' . $searchQuery . '%');
    })->paginate(20);

    return view('namecards.index', compact('nameCardData'));
}


    public function create()
    {
        return view('namecards.create');
    }


public function process(Request $request)
{
    try {
        $validatedData = $request->validate([
            'image_data' => 'required|string', // Base64 image string
        ]);

        // Decode Base64 image data
        $imageData = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $validatedData['image_data']));

        // Save image temporarily for OCR processing
        $tempFilename = 'temp_namecard_' . uniqid() . '.png';
        $tempPath = storage_path('app/public/namecards/' . $tempFilename);

        if (!is_dir(storage_path('app/public/namecards'))) {
            mkdir(storage_path('app/public/namecards'), 0755, true);
        }

        file_put_contents($tempPath, $imageData);

        // Perform OCR
        $tesseract = new TesseractOCR($tempPath);
        $tesseract->lang('eng', 'jpn');
        $extractedText = $tesseract->run();

        // Parse the extracted text into fields
        $extractedData = $this->parseNameCardText($extractedText);

        // Remove the temporary file after processing
        unlink($tempPath);




        return response()->json([
            'success' => true,
            'message' => 'Data extracted successfully',
            'extractedData' => $extractedData,
        ]);
    } catch (\Exception $e) {
        \Log::error('Error during OCR: ' . $e->getMessage() . PHP_EOL . $e->getTraceAsString());

        return response()->json([
            'success' => false,
            'message' => 'Failed to process the image. Please try again later.',
        ], 500);
    }
}

private function parseNameCardText($text)
{
    $data = [
        'name' => null,
        'company' => null,
        'phone' => null,
        'mobile' => null,
        'fax' => null,
        'email' => null,
        'postal_code' => null,
        'prefecture' => null,
        'address_detail' => null,
    ];

    $patterns = [
        'name' => [
            '/(?:株式会社|有限会社|合同会社|企業)?\s*[ぁ-んァ-ヶ一-龯\s]+(?:株式会社|有限会社|合同会社|企業)?/u',
        ],
        'company' => [
            '/(?:株式会社|有限会社|合同会社|企業)?\s*[ぁ-んァ-ヶ一-龯\s]+(?:株式会社|有限会社|合同会社|企業)?/u',
            '/[ぁ-んァ-ヶ一-龯a-zA-Z\s\.\-]{2,}/u',
            '/(?:氏|さん|様)?[ぁ-んァ-ヶ一-龯a-zA-Z\s\.\-]+(?:氏|さん|様)?/u',
        ],
        'phone' => [
            '/TEL\s*[:：]?\s*([\d\-]+)/u',
            '/携帯\s*[:：]?\s*([\d\-]+)/u',
        ],
        'moblie' => [
            '/Mobile\s*[:：]?\s*([\d\-]+)/u',
            '/携帯\s*[:：]?\s*([\d\-]+)/u',
        ],
        'fax' => [
            '/FAX \s*[:：]?\s*([\d\-]+)/u',

        ],
        'email' => [
            '/\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}\b/u',
        ],
        'address' => [
            '/\〒*[:：]?\s*([\d\-]+)/u',


        ],
    ];

    $lines = preg_split('/\R/', $text);

    foreach ($patterns as $key => $patternSet) {
        foreach ($lines as $line) {
            foreach ($patternSet as $pattern) {
                if (preg_match($pattern, $line, $matches)) {
                    if ($key === 'address' && count($matches) > 2) {
                        $data['postal_code'] = $matches[1];
                        $data['prefecture'] = $matches[2] ?? '';
                        $data['address_detail'] = $matches[3];
                    } else {
                        $data[$key] = $key === 'email'
                            ? trim($matches[0])
                            : ($key === 'phone' && isset($matches[1])
                                ? trim($matches[1])
                                : trim($matches[0]));
                    }
                    break 2;
                }
            }
        }
    }

    // Log the final extracted data
    \Log::info('Final extracted data: ' . print_r($data, true));
    return $data;
}





public function storeConfirmedData(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'nullable|string|max:255',
        'company' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:20',
        'mobile' => 'nullable|string|max:20',
        'fax' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'image_data' => 'nullable|string',
    ]);

    $nameCard = new NameCard();
    $nameCard->fill($validatedData);

    // Optional: Save base64 image to storage if needed
    if (!empty($validatedData['image_data'])) {
        $imageData = $this->saveNameCardImage($validatedData['image_data']);
        $nameCard->image_path = $imageData['path'];
    }

    $nameCard->save();

    return redirect()->route('namecards.index')->with('success', 'Name card saved successfully.');
}

private function saveNameCardImage($imageData)
{
    $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $imageData);
    $imageFilename = 'namecard_' . uniqid() . '.png';
    $imagePath = storage_path('app/public/namecards/' . $imageFilename);

    file_put_contents($imagePath, base64_decode($imageData));

    return [
        'path' => 'namecards/' . $imageFilename,
        'filename' => $imageFilename,
    ];
}




    public function show(NameCard $namecard)
    {
        return view('namecards.show', [
            'namecard' => $namecard
        ]);
    }

    public function destroy(NameCard $namecard)
    {
        $namecard->delete();

        return redirect()->route('namecards.index')->with('success', 'NameCard deleted successfully.');
    }

    public function edit(NameCard $namecard)
{
    return view('namecards.edit', [
        'namecard' => $namecard
    ]);
}

public function update(Request $request, NameCard $namecard)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'image_path' => 'nullable|image|max:2048',
        // Add any other validation rules for your NameCard model
    ]);

    // Update the NameCard model with the validated data
    $namecard->update($validatedData);

    // Redirect the user to the appropriate page, e.g., the show page for the updated NameCard
    return redirect()->route('namecards.index', $namecard)->with('success', 'NameCard updated successfully.');
}








}

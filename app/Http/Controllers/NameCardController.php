<?php

namespace App\Http\Controllers;

use thiagoalessio\TesseractOCR\TesseractOCR;
use App\Models\NameCard;
use Illuminate\Http\Request;

class NameCardController extends Controller
{





    public function create()
    {
        return view('namecards.create');
    }

    public function index()
    {
        $namecards = NameCard::latest()->get();
        return view('namecards.index', compact('namecards'));
    }

    public function store(Request $request)
    {
        try {
            // Check if this is an OCR request or final form submission
            $isOcrRequest = $request->has('ocr_only');
            // Process the base64 image
            $image_data = $request->input('image_data');
            $image_data = preg_replace('#^data:image/\w+;base64,#i', '', $image_data);
            $image_data = base64_decode($image_data);

            // Generate unique filename
            $filename = 'namecard_' . time() . '_' . uniqid() . '.png';
            $uploads_dir = public_path('uploads');

            // Create directory if it doesn't exist
            if (!file_exists($uploads_dir)) {
                mkdir($uploads_dir, 0777, true);
            }

            // Save the image
            $file_path = $uploads_dir . '/' . $filename;
            file_put_contents($file_path, $image_data);

            // Perform OCR
            $tesseract = new TesseractOCR($file_path);
            $tesseract->lang('jpn', 'eng')  // Support both Japanese and English
            ->psm(3)
            ->oem(1);

            $extracted_text = $tesseract->run();
            $extracted_data = $this->extractFields($extracted_text);

            // If this is just an OCR request, return the extracted data
            if ($isOcrRequest) {
                return response()->json([
                    'success' => true,
                    'extracted_data' => $extracted_data,
                    'full_text' => $extracted_text
                ]);
            }

            // For final form submission, validate the request
            $request->validate([
                'name' => 'required',
                'address' => 'required',
                'company' => 'required',
                'phone' => 'required',
                'email' => 'required|email',
            ]);

            // Create namecard record with form input data
            NameCard::create([
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'company' => $request->input('company'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'image' => 'uploads/' . $filename,
                'ocr_text' => $extracted_text
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Name card saved successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error processing name card: ' . $e->getMessage()
            ], 500);
        }
    }

    private function extractFields($text)
    {
        $patterns = [
            'name' => [
                '/name[\s:]+([\w\s]+)/i',
                '/([\w\s]+)\b(?=\s*(?:CEO|Manager|Director|MD|President))/i',
            ],
            'email' => [
                '/[\w\.-]+@[\w\.-]+\.\w+/',
                '/email[\s:]+([\w\.-]+@[\w\.-]+\.\w+)/i',
            ],
            'phone' => [
                '/(?:phone|tel|mobile)[\s:]*([\+\d\s\-\(\)]{10,})/i',
                '/(\+?\d{1,3}[-.\s]?\(?\d{3}\)?[-.\s]?\d{3}[-.\s]?\d{4})/',
            ],
            'address' => [
                '/address[\s:]+([\w\s,.-]+)/i',
                '/([\w\s,.-]+\b(?:street|road|avenue|lane|boulevard|st|rd|ave|ln|blvd)[\w\s,.-]+)/i',
            ],
            'company' => [
                '/(?:company|organization)[\s:]+([\w\s,.-]+)/i',
                '/([\w\s&]+(?:Inc\.|LLC|Ltd\.|Corp\.|Corporation|Company))/i',
            ],
        ];

        $extracted = [];
        foreach ($patterns as $field => $fieldPatterns) {
            $extracted[$field] = null;
            foreach ($fieldPatterns as $pattern) {
                if (preg_match($pattern, $text, $matches)) {
                    $extracted[$field] = trim($matches[1] ?? $matches[0]);
                    break;
                }
            }
        }

        return $extracted;
    }
}


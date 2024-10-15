<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PDFCompany;
use App\Models\PDF;
use Illuminate\Support\Facades\Storage;

class PDFController extends Controller


{

    public function import(Request $request, PDFCompany $pdfCompany)
{
    try {
        $submitType = $request->input('submit_type');

        if ($submitType === 'file') {
            $request->validate([
                'pdf' => 'required|file|mimes:pdf,pptx|max:10240',
            ]);

            if ($request->hasFile('pdf') && $request->file('pdf')->isValid()) {
                $file = $request->file('pdf');
                $extension = $file->getClientOriginalExtension();
                $path = $file->store('documents');
                $filename = $file->getClientOriginalName();

                $pdf = new PDF([
                    'filename' => $filename,
                    'path' => $path,
                    'type' => $extension,
                ]);
                $pdfCompany->pdfs()->save($pdf);

                return redirect()->route('pdfCompany.show', $pdfCompany)
                    ->with('success', ucfirst($extension) . 'ファイルのインポートに成功しました');
            }

            return back()->with('error', 'ファイルのアップロードに失敗しました');

        } elseif ($submitType === 'youtube') {
            $request->validate([
                'youtube_link' => 'required|url',
            ]);

            $pdf = new PDF([
                'filename' => 'YouTube Video',
                'path' => $request->youtube_link,
                'type' => 'youtube',
            ]);

            $pdfCompany->pdfs()->save($pdf);

            return redirect()->route('pdfCompany.show', $pdfCompany)
                ->with('success', 'YouTubeリンクの追加に成功しました');
        }

        return back()->with('error', '不正なコンテンツタイプです');
    } catch (\Exception $e) {

    }
}





public function view(PDF $pdf)
{
    if ($pdf->type === 'pdf') {
        $path = Storage::disk('public')->path($pdf->path);
        if (!file_exists($path)) {
            \Log::error("File not found: " . $path);
            return back()->with('error', 'ファイルが見つかりません');
        }
        return response()->file($path);
    } elseif ($pdf->type === 'pptx') {
        $viewUrl = Storage::disk('public')->url($pdf->path);
        $downloadUrl = route('pdf.download', $pdf);
        return view('pdfCompany.pptx-viewer', [
            'fileUrl' => $viewUrl,
            'downloadUrl' => $downloadUrl,
            'filename' => $pdf->filename
        ]);
    } elseif ($pdf->type === 'youtube') {
        return redirect()->away($pdf->path);
    } else {
        return back()->with('error', 'サポートされていないファイルタイプ');
    }
}





    public function download(PDF $pdf)
    {
        if($pdf->type === 'pptx')
        {
            return response()->download(storage_path('app/' . $pdf->path), $pdf->filename);
        }
        elseif($pdf->type === 'youtube')
        {
            return redirect()->away($pdf->path);
        }else{
            return back()->with('error', 'サポートされていないファイルタイプ');
        }
    }


    // {
    //   $request->validate([
    //     'pdf'=>'required|mimes:pdf,pptx|max:10240',
    //   ]);

    //   if($request->file('pdf')->isValid())
    //   {
    //     $file=$request->file('pdf');
    //     $extension=$file->getClientOriginalExtension();

    //     $path=$file->store('documents');
    //     $filename=$file->getClientOriginalName();

    //     $pdf=new PDF([
    //         'filename'=>$filename,
    //         'path'=>$path,
    //         'type'=>$extension,

    //     ]);


    //     $pdfCompany->pdfs()->save($pdf);

    //     return redirect()->route('pdfCompany.show', $pdfCompany)
    //     ->with('success', ucfirst($extension) . 'ファイルのインポートに成功しました');

    //   }
    //   return back()->with('error', 'failed to upload');
    // }



    // public function view(PDF $pdf)
    // {
    //     if($pdf->type ==='pdf')
    //     {
    //         return response()->file(storage_path('app/' .$pdf->path));
    //     }

    //     else{
    //         return back()->with('error', 'サポートされていないファイルタイプ');
    //     }

    // }

    public function destroy(PDF $pdf)
    {
        Storage::delete($pdf->path);
        $pdf->delete();

        return back()->with('success', 'PDF が正常に削除されました');
    }


}

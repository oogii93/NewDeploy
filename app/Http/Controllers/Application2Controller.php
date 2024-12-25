<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Office;
use App\Models\Division;
use App\Models\Application;
use App\Models\Forms\FormA;
use App\Models\Application2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Application2Controller extends Controller
{

    public function index()
    {
        $application2 = Application2::  where('applicationable2_type', '!=', 'App\Models\ComputerFormType01Z')
                                        ->latest()
                                        ->paginate(10);

        // Using relationships
        $users = User::whereHas('corp', function($query) {
                        $query->where('corp_name', '太成HD');
                    })
                    ->whereHas('office', function($query) {
                        $query->where('office_name', '本社');
                    })
                    ->get();

                    // dd($users);


        return view('applications2.index', compact('application2', 'users'));
    }


            public function computer()
            {

                $application2=Application2::where('applicationable2_type', 'App\Models\ComputerFormType01Z')
                                                ->latest()
                                                ->paginate(10);

                $users=User::whereHas('corp', function($query){
                                                $query->where('corp_name', '太成HD');

                                                })
                                                ->whereHas('office', function($query){
                                                    $query->where('office_name', '本社');
                                                })
                                                ->get();





                    if(auth()->user()->division_id== [6,9]){
                        Application2::uncheckedHrNotifications()
                        ->update(['hr_checked' => true, 'hr_checked_by' => auth()->id(), 'hr_checked_at' => now()]);
                    }

                    // \Log::info($application2);

                return view('applications2.computer', compact('application2','users'));

            }

    public function show($id)
    {
        $application2 = Application2::with('applicationable2')->findOrFail($id);
        $form = $application2->applicationable2;

        // Get the full class name of the form
        $formClass = get_class($form);

        // Extract the form type from the class name
        if (preg_match('/(\d*[A-Z])$/', $formClass, $matches)) {
            $formType = $matches[1];
        } else {
            $formType = 'Default';
        }


        $viewPath = "forms2.show.type{$formType}";

        // Check if the view exists
        if (!view()->exists($viewPath)) {
            // Fallback to a default view if the specific view doesn't exist
            $viewPath = 'forms2.show.default';
        }

        return view('applications2.show', compact('application2', 'form', 'formType'))
            ->with('formView', $viewPath);
    }

    public function check(Request $request, Application2 $application2)
{
    try {
        DB::beginTransaction();

        $application2->update([
            'is_checked' => true,
            'checked_by' => $request->checker_id,
            'checked_at' => now(),
            'hr_checked' => true,
        ]);

        DB::commit();

        return response()->json([
            'success' => true,
            'checker_name' => User::find($request->checker_id)->name,
            'checked_at' => $application2->checked_at->format('Y-m-d H:i:s'),
            'hr_checked' => $application2->hr_checked,
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Error updating record'
        ], 500);
    }
}


public function updateComment(Request $request, Application2 $application2)
{
    try {
        $validatedData = $request->validate([
            'comment' => 'nullable|string|max:1000'
        ]);

        $application2->update([
            'comment' => $request->input('comment')
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Comment updated successfully'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error updating comment',
            'error' => $e->getMessage()
        ], 500);
    }
}


}


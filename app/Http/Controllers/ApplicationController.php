<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Office;
use App\Models\Division;
use App\Models\Application;
use App\Models\Forms\FormA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{



    public function checkApplication(Application $application, Request $request)
    {
        $isChecked = $request->input('is_checked');

        if ($isChecked && !$application->is_checked) {
            $application->update([
                'is_checked' => true,
                'checked_by' => auth()->id(),
                'checked_at' => now(),
                'hr_checked' => true,

            ]);

            return response()->json([
                'success' => true,
                'checked_by' => auth()->user()->name,
                'checked_at' => now()->format('Y-m-d H:i'),
                'hr_checked' => true,

            ]);
        }

        return response()->json(['success' => false]);
    }

    public function index(Request $request)
    {
        $query = Application::where('user_id', auth()->id())->with('boss', 'user');

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%$search%")
                    ->orWhere('status', 'like', "%$search%")
                    ->orWhere('applicationable_id', 'like', "%$search%")
                    ->orWhereHas('boss', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    })
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    });
            });
        }

        if ($request->filled(['from_date', 'to_date'])) {
            $query->whereBetween('created_at', [$request->get('from_date'), $request->get('to_date')]);
        }

        $applications = $query->paginate(20);



        if ($request->ajax()) {
            return view('applications.table', compact('applications'))->render();
        }

        return view('applications.index', compact('applications'));
    }

    public function search(Request $request)
    {
        $query = Application::where('user_id', auth()->id())->with('boss');

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%$search%")
                    ->orWhere('status', 'like', "%$search%")
                    ->orWhereHas('boss', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    });
            });
        }

        if ($request->filled(['from_date', 'to_date'])) {
            $query->whereBetween('created_at', [$request->get('from_date'), $request->get('to_date')]);
        }

        $applications = $query->paginate(20);

        return view('applications.table', compact('applications'));
    }

    public function bossIndex(Request $request)
    {
        $userDivisionId = auth()->user()->division_id;

        $query = Application::with('user')
            ->where(function ($q) use ($userDivisionId) {
                $q->where('division_id', $userDivisionId)
                    ->orWhere('boss_id', auth()->id());
            });

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%$search%")
                    ->orWhere('status', 'like', "%$search%")
                    ->orWhere('applicationable_id', 'like', "%$search%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    });
            });
        }

        if ($request->filled(['from_date', 'to_date'])) {
            $query->whereBetween('created_at', [$request->get('from_date'), $request->get('to_date')]);
        }

        $applications = $query->paginate(20);
        $divisions = Division::whereIn('name', ['経理課'])->get();
        // '人事課',

        if ($request->ajax()) {
            return view('applications.boss_table', compact('applications', 'divisions'))->render();
        }

        return view('applications.boss_index', compact('applications', 'divisions'));
    }



    public function show($id)
    {
        $application = Application::with('applicationable')->findOrFail($id);
        $form = $application->applicationable;

        // Get the full class name of the form
        $formClass = get_class($form);

        // Extract the form type from the class name
        if (preg_match('/(\d*[A-Z])$/', $formClass, $matches)) {
            $formType = $matches[1];
        } else {
            $formType = 'Default';
        }

        $bosses = User::where('is_boss', true)->get();

        $viewPath = "forms.show.type{$formType}";

        // Check if the view exists
        if (!view()->exists($viewPath)) {
            // Fallback to a default view if the specific view doesn't exist
            $viewPath = 'forms.show.default';
        }

        return view('applications.show', compact('application', 'form', 'formType', 'bosses'))
            ->with('formView', $viewPath);
    }

    public function store(Request $request, $type)
    {
        $formClass = 'App\\Models\\Forms\\Form' . ucfirst($type);

        if (!class_exists($formClass)) {
            abort(404, 'Form type not found');
        }

        // Common validation rules
        $validationRules = [
            'boss_id' => 'required',
        ];



        $validatedData = $request->validate($validationRules);

        $form = new $formClass();
        $form->fill($validatedData);
        $form->save();

        $application = new Application();
        $application->user_id = auth()->id();
        $application->status = "pending";
        $application->boss_id = $validatedData['boss_id'];
        $application->hr_checked = false;
        $application->applicationable()->associate($form);
        $application->save();

        Log::info('Creating new application', [
            'hr_checked' => false,
            'status' => 'pending'
        ]);

        return redirect()->route('applications.show', $application->id);
    }
    public function updateStatus(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        $formType = substr(class_basename($application->applicationable), -1);

        if ($formType === 'C') {
            if (!$application->is_first_approval) {
                // First approval for Type C
                $status = $request->input('status');

                if (!in_array($status, ['approved', 'denied'])) {
                    return back()->with('error', 'Invalid status');
                }

                if ($status === 'approved') {
                    $application->status = 'partially_approved';
                    $application->is_first_approval = true;
                } else {
                    $application->status = 'denied';
                }

                $application->save();

                $message = $status === 'approved' ? 'Application partially approved. Waiting for user update.' : 'Application denied.';
                return redirect()->route('applications.boss_index')->with('success', $message);
            } else {
                // Second approval for Type C
                $status = $request->input('status');
                $divisionId = $request->input('division');

                if (!in_array($status, ['approved', 'denied'])) {
                    return back()->with('error', 'Invalid status');
                }
                if (!$divisionId) {
                    return back()->with('error', 'Please select a division');
                }

                $application->status = $status;
                $application->division_id = $divisionId;
                $application->save();

                return redirect()->route('applications.boss_index')->with('success', 'Application ' . $status . ' and assigned to division');
            }
        } else {
            // Existing logic for other form types
            $status = $request->input('status');
            $divisionId = $request->input('division');

            if (!in_array($status, ['approved', 'denied'])) {
                return back()->with('error', 'Invalid status');
            }
            if (!$divisionId) {
                return back()->with('error', 'Please select a division');
            }

            $application->status = $status;
            $application->division_id = $divisionId;
            $application->save();

            return redirect()->route('applications.boss_index')->with('success', 'Application ' . $status . ' and assigned to division');
        }
    }


    public function updateTypeC(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        $form = $application->applicationable;

        if (!($form instanceof \App\Models\ApplicationTypeC)) {
            return back()->with('error', 'Invalid form type');
        }

        $validatedData = $request->validate([
            'office' => 'nullable',
            'real_start_time' => 'required',
            'real_end_time' => 'required|after:real_start_time',
            'substitute_day' => 'required|date',
            'reason' => 'required',
            'boss_id' => 'nullable|exists:users,id',
        ]);

   $formData=array_diff_key($validatedData, array_flip(['boss_id']));
   $form->update($formData);

//    $application->boss_id = $validatedData['boss_id'];
   $application->save();

        return redirect()->route('applications.show', $application->id)->with('success', 'Application updated successfully');
    }
}


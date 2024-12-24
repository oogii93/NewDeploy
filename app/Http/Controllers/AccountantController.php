<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class AccountantController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware(['auth', 'check.ac']);
    // }

    // public function index()
    // {
    //     return view('hr.hr_dashboard');
    // }

    public function index(Request $request)
{
    $query = Application::with('user');



    // Search functionality
    if ($request->filled('search')) {
        $search = $request->get('search');
        $query->where(function($q) use ($search) {
            $q->where('id', 'like', "%$search%")
              ->orWhere('status', 'like', "%$search%")
              ->orWhere('applicationable_id', 'like', "%$search%")
              ->orWhereHas('user', function($q) use ($search) {
                  $q->where('name', 'like', "%$search%");
              });
        });
    }

    // Date range filter
    if ($request->filled(['from_date', 'to_date'])) {
        $query->whereBetween('created_at', [
            $request->get('from_date'),
            $request->get('to_date')
        ]);
    }

    $applications = $query->latest()->paginate(20);

    if ($request->ajax()) {
        return view('ac.ac_dashboard', compact('applications'))->render();
    }

    return view('ac.ac_dashboard', compact('applications'));
}


    // public function Index(Request $request)
    // {
    //     $acDivisionId = 2; // Assuming HR division has id 1

    //     $query = Application::with('user')
    //         ->where('division_id', $acDivisionId);

    //     if ($request->filled('search')) {
    //         $search = $request->get('search');
    //         $query->where(function($q) use ($search) {
    //             $q->where('id', 'like', "%$search%")
    //               ->orWhere('status', 'like', "%$search%")
    //               ->orWhere('applicationable_id', 'like', "%$search%")
    //               ->orWhereHas('user', function($q) use ($search) {
    //                   $q->where('name', 'like', "%$search%");
    //               });
    //         });
    //     }

    //     if ($request->filled(['from_date', 'to_date'])) {
    //         $query->whereBetween('created_at', [$request->get('from_date'), $request->get('to_date')]);
    //     }

    //     $applications = $query->paginate(20);

    //     if ($request->ajax()) {
    //         return view('ac.ac_dashboard', compact('applications'))->render();
    //     }

    //     return view('ac.ac_dashboard', compact('applications'));
    // }


    public function search(Request $request)
    {
        $query = Application::where('user_id', auth()->id())->with('boss');

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%$search%")
                  ->orWhere('status', 'like', "%$search%")
                  ->orWhereHas('boss', function($q) use ($search) {
                      $q->where('name', 'like', "%$search%");
                  });
            });
        }

        if ($request->filled(['from_date', 'to_date'])) {
            $query->whereBetween('created_at', [$request->get('from_date'), $request->get('to_date')]);
        }

        $applications = $query->paginate(20);

        return view('hr.table', compact('applications'));
    }
}

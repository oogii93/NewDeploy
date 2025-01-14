<?php

namespace App\Http\Controllers;


use App\Models\Corp;
use App\Models\User;
use App\Models\Office;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{


    // public function detail($id)
    // {

    //     $corps=Corp::all();
    //     $roles = Role::pluck('name', 'name')->all();
    //     $offices = Office::all();

    //     $user =User::findOrFail($id);
    //     return view('admin.user-details.show', compact('roles','corps', 'offices','user'));
    // }

    public function index(Request $request){
        $search=$request->input('search');
        $authUser=auth()->user();

        $query=User::with('office.corp');

  // If user is from Yumeya, only show Yumeya users
        if($authUser->corp->corp_name ==='ユメヤ'){
            $query->whereHas('office.corp', function($q){
                $q->where('corp_name', 'ユメヤ');
            });
        }

        if($search){
            $query->where(function($q) use($search, $authUser){
                $q->where('name', 'like',"%$search%")
                        ->orWhere('id', $search)
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('employer_id', 'like', "%$search%");

                          // If user is from Yumeya, only search within Yumeya offices

                        if($authUser->corp->corp_name ==='ユメヤ'){
                            $q->orWhereHas('office', function ($q2) use ($search){

                                $q2->where('office_name', 'like', "%$search%");
                            });


                        }else{
                            $q->orWhereHas('office.corp', function($q2) use ($search){
                                $q2->where('corp_name', 'like', "%$search%")
                                    ->orWhere('office_name', 'like', "%$search%");
                            });
                        }
            });
        }

        $users=$query->paginate(15);

        return view('admin.role-permission.user.index', compact('users','search'));
    }

    // public function index(Request $request)
    // {
    //     $search = $request->input('search');

    //     $users = User::with('office.corp')
    //         ->when($search, function ($query, $search) {
    //             return $query->where('name', 'like', "%$search%")
    //                 ->orWhere('id', $search)
    //                 ->orWhere('email', 'like', "%$search%")
    //                 ->orWhereHas('office.corp', function ($q2) use ($search) {
    //                     $q2->where('corp_name', 'like', "%$search%")
    //                         ->orWhere('office_name', 'like', "%$search%")
    //                         ->orWhere('employer_id', 'like', "%$search%");
    //                 });
    //         })
    //         ->paginate(15);

    //     return view('admin.role-permission.user.index', compact('users', 'search'));
    // }
    public function create()
    {


        $corps=Corp::all();
        $roles = Role::pluck('name', 'name')->all();
        $offices = Office::all();


        return view('admin.role-permission.user.create', compact('roles','corps', 'offices',));
    }

    public function generateEmployerId($corpId)
{
    // Fetch the last created user for the given corp and increment employer ID.
    $lastUser = User::where('corp_id', $corpId)->orderBy('employer_id', 'desc')->first();

    // If no user exists for this corp, start with the base number (e.g., 100001)
    if (!$lastUser) {
        $newEmployerId = 00001; // Starting number for new users
    } else {
        // Increment the last employer ID
        $newEmployerId = intval($lastUser->employer_id) + 1;
    }

    return response()->json(['employer_id' => $newEmployerId]);
}

    public function getOfficesForCorp($corpId)
    {
        $offices = Office::where('corp_id', $corpId)->get();
        return response()->json($offices);
    }

    public function getDivisionsForOffice($officeId)
{
    $divisions = Division::where('office_id', $officeId)->get();
    return response()->json($divisions);
}



public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'corp_id' => 'required|exists:corps,id',
            'office_id' => 'required|exists:offices,id',
            'division_id' => 'required|exists:divisions,id',
            'name' => 'required|string|max:255',
            'furigana' => 'required|string|max:255',
            'gender' => 'required|in:男性,女性',
            'birthdate' => 'required|date',
            'post_number' => 'required|string|max:8',
            'address' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => 'required|string|min:8|max:20',
            'roles' => 'required|array',
            'is_boss' => 'boolean',
            'employer_id' => 'required|string|max:255|unique:users,employer_id',
        ]);

        $userData = [
            'corp_id' => $validated['corp_id'],
            'office_id' => $validated['office_id'],
            'division_id' => $validated['division_id'],
            'name' => $validated['name'],
            'furigana' => $validated['furigana'],
            'gender' => $validated['gender'],
            'birthdate' => $validated['birthdate'],
            'post_number' => $validated['post_number'],
            'address' => $validated['address'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_boss' => $request->boolean('is_boss'),
            'employer_id' => $validated['employer_id'],
        ];

        $user = User::create($userData);
        $user->syncRoles($validated['roles']);

        return redirect('/admin/role-permission/users')->with('success', 'ユーザーが正常に登録されました');
    } catch (ValidationException $e) {
        return redirect()->back()->withErrors($e->errors())->withInput();
    }
}



public function edit($userId)
{
    $user = User::findOrFail($userId);
    $roles = Role::pluck('name', 'name')->all();
    $userRoles = $user->roles->pluck('name')->toArray();
    $corps = Corp::all();
    $offices = Office::where('corp_id', $user->corp_id)->get();
    $divisions = Division::where('office_id', $user->office_id)->get();

    return view('admin.role-permission.user.edit', compact('user', 'roles', 'userRoles', 'corps', 'offices', 'divisions'));
}

public function update(Request $request, $userId)
{
    $user = User::findOrFail($userId);

    try {
        $validated = $request->validate([
            'corp_id' => 'required|exists:corps,id',
            'office_id' => 'required|exists:offices,id',
            'division_id' => 'required|exists:divisions,id',
            'name' => 'required|string|max:255',
            'furigana' => 'required|string|max:255',
            'gender' => 'required|in:男性,女性',
            'birthdate' => 'required|date',
            'post_number' => 'required|string|max:8',
            'address' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|max:20',
            'roles' => 'required|array',
            'is_boss' => 'boolean',
            'employer_id' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        $data = [
            'corp_id' => $validated['corp_id'],
            'office_id' => $validated['office_id'],
            'division_id' => $validated['division_id'],
            'name' => $validated['name'],
            'furigana' => $validated['furigana'],
            'gender' => $validated['gender'],
            'birthdate' => $validated['birthdate'],
            'post_number' => $validated['post_number'],
            'address' => $validated['address'],
            'email' => $validated['email'],
            'employer_id' => $validated['employer_id'],
            'is_boss' => $request->boolean('is_boss'),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);
        $user->syncRoles($validated['roles']);

        return redirect()->route('admin.role-permission.user.index')->with('success', 'ユーザーが正常に変更されました');
    } catch (ValidationException $e) {
        return redirect()->back()->withErrors($e->errors())->withInput();
    }
}

// public function edit($userId)
// {
//     $user = User::findOrFail($userId);
//     $roles = Role::pluck('name', 'name')->all();
//     $userRoles = $user->roles->pluck('name')->toArray();
//     $corps = Corp::all();
//     $offices = Office::all(); // Load all offices
//     $divisions = Division::all(); // Load all divisions

//     // dd($corps);

//     return view('admin.role-permission.user.edit', compact('user', 'roles', 'userRoles', 'corps', 'offices', 'divisions'));
// }

//     public function update(Request $request, $userId)
// {
//     $user = User::findOrFail($userId);

//     try {
//         $validated = $request->validate([
//             'corp_id' => 'required|exists:corps,id',
//             'office_id' => 'required|exists:offices,id',
//             'division_id' => 'required|exists:divisions,id',
//             'name' => 'required|string|max:255',
//             'furigana' => 'required|string|max:255',
//             'gender' => 'required|in:男性,女性',
//             'birthdate' => 'required|date',
//             'post_number' => 'required|string|max:8',
//             'address' => 'required|string|max:255',
//             'email' => [
//                 'required',
//                 'email',
//                 'max:255',
//                 Rule::unique('users')->ignore($user->id),
//             ],
//             'password' => 'nullable|string|min:8|max:20',
//             'roles' => 'required|array',
//             'is_boss' => 'boolean',
//             'employer_id' => [
//                 'required',
//                 'string',
//                 'max:255',
//                 Rule::unique('users')->ignore($user->id),
//             ],
//         ]);



//         $data=[
//             'corp_id'=>$validated['corp_id'],
//             'office_id'=>$validated['office_id'],
//             'division_id'=>$validated['division_id'],
//             'name'=>$validated['name'],
//             'furigana'=>$validated['furigana'],
//             'gender'=>$validated['gender'],
//             'birthdate'=>$validated['birthdate'],
//             'post_number'=>$validated['post_number'],
//             'address'=>$validated['address'],
//             'email'=>$validated['email'],
//             'employer_id'=>$validated['employer_id'],
//         ];

//         if ($request->filled('password')) {
//             $data['password'] = Hash::make($validated['password']);
//         }

//         $user->update($data);
//         $user->syncRoles($validated['roles']);

//         return redirect()->route('admin.role-permission.user.index')->with('success', 'ユーザーが正常に変更されました');
//     } catch (ValidationException $e) {
//         return redirect()->back()->withErrors($e->errors())->withInput();
//     }
// }
    public function show(Request $request)
    {
        $users = User::onlyTrashed()->get();
        return view('admin.role-permission.user.restore.index', compact('users'));
    }

    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        return redirect('/admin/role-permission/users')->with('success', 'ユーザーが正常にソフトデリートされました');
    }


    public function restoreIndex()
    {
        $users = User::onlyTrashed()->get();
        return view('admin.role-permission.user.restore.index', compact('users'));
    }
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('admin.role-permission.user.index')->with('sucess', 'ユーザーが正常に復元された');
    }
}

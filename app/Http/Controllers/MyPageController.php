<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use App\Models\UserFamily;

use App\Models\UserBankDetails;
use Illuminate\Support\Facades\Validator;

class MyPageController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load(['corp', 'office', 'division','userDetail']);

        return view('myPage.index', compact('user'));
    }


    public function showAndUpdate(Request $request)
    {
        $user=auth()->user()->load('userDetail');

        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [



                'phone_number' => 'nullable|string|max:255',
                'mobile_number' => 'nullable|string|max:255',
                'mobile_email' => 'nullable|email|max:255',
                'driver_license' => 'required|string|in:有,無',
                'previous_name'=>'nullable|string|max:255',
                'household_name' => 'nullable|string|max:255',
                'household_relation' => 'nullable|string|max:255',
                'oneway_comute_distance' => 'nullable|string|max:255',


                // Add any other fields you want the user to be able to update
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $validatedData = $validator->validated();

            $user->userDetail()->updateOrCreate(
                ['user_id' => $user->id],
                $validatedData
            );


            // dd($user);

            return redirect()->route('mypage.show-update')
                ->with('success', '正常に更新されました');
        }


        return view('myPage.show-update', compact('user'));
    }





   public function showAndUpdateBank(Request $request)
    {
        $user=auth()->user()->load('userBankDetail');

        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [


                'salary_bank_order_1'=>'nullable|string|max:255',
                'salary_payment_method_1'=>'required|string|in:銀行振込',
                'salary_payment_type1'=>'required|string|in:全額,定額,残額',
                'salary_payment_amount1'=>'nullable|string|max:255',
                'salary_bank1'=>'nullable|string|max:255',
                'salary_bank_branch1'=>'nullable|string|max:255',
                'salary_account_type1'=>'required|string|in:普通',
                'salary_account_address1'=>'nullable|string|max:255',
                //2 salary
                'salary_bank_order_2'=>'nullable|string|max:255',
                'salary_payment_method_2'=>'nullable|string|in:銀行振込',
                'salary_payment_type2'=>'nullable|string|in:全額,定額,残額',
                'salary_payment_amount2'=>'nullable|string|max:255',
                'salary_bank2'=>'nullable|string|max:255',
                'salary_bank_branch2'=>'nullable|string|max:255',
                'salary_account_type2'=>'nullable|string|in:普通',
                'salary_account_address2'=>'nullable|string|max:255',


                //3 salary
                'salary_bank_order_3'=>'nullable|string|max:255',
                'salary_payment_method_3'=>'nullable|string|in:銀行振込',
                'salary_payment_type3'=>'nullable|string|in:全額,定額,残額',
                'salary_payment_amount3'=>'nullable|string|max:255',
                'salary_bank3'=>'nullable|string|max:255',
                'salary_bank_branch3'=>'nullable|string|max:255',
                'salary_account_type3'=>'nullable|string|in:普通',
                'salary_account_address3'=>'nullable|string|max:255',
                //1 bonus
                'bonus_bank_order_1'=>'nullable|string|max:255',
                'bonus_payment_method_1'=>'nullable|string|in:銀行振込',
                'bonus_payment_type1'=>'nullable|string|in:全額,定額,残額',
                'bonus_payment_amount1'=>'nullable|string|max:255',
                'bonus_bank1'=>'nullable|string|max:255',
                'bonus_bank_branch1'=>'nullable|string|max:255',
                'bonus_account_type1'=>'nullable|string|in:普通',
                'bonus_account_address1'=>'nullable|string|max:255',
                //2 bonus
                'bonus_bank_order_2'=>'nullable|string|max:255',
                'bonus_payment_method_2'=>'nullable|string|in:銀行振込',
                'bonus_payment_type2'=>'nullable|string|in:全額,定額,残額',
                'bonus_payment_amount2'=>'nullable|string|max:255',
                'bonus_bank2'=>'nullable|string|max:255',
                'bonus_bank_branch2'=>'nullable|string|max:255',
                'bonus_account_type2'=>'nullable|string|in:普通',
                'bonus_account_address2'=>'nullable|string|max:255',
                //3 bonus
                'bonus_bank_order_3'=>'nullable|string|max:255',
                'bonus_payment_method_3'=>'nullable|string|in:銀行振込',
                'bonus_payment_type3'=>'nullable|string|in:全額,定額,残額',
                'bonus_payment_amount3'=>'nullable|string|max:255',
                'bonus_bank3'=>'nullable|string|max:255',
                'bonus_bank_branch3'=>'nullable|string|max:255',
                'bonus_account_type3'=>'nullable|string|in:普通',
                'bonus_account_address3'=>'nullable|string|max:255',


                // Add any other fields you want the user to be able to update
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $validatedData = $validator->validated();

            $user->userBankDetail()->updateOrCreate(
                ['user_id' => $user->id],
                $validatedData
            );


            // dd($user);

            return redirect()->route('mypage.bank-show-update')
                ->with('success', '更新されました');
        }


        return view('myPage.bank-show-update', compact('user'));
    }










     public function family(Request $request)
    {
        $user=auth()->user()->load('userFamily');
        $familyMembers = $user->familyMembers; // Assuming you have a relationship set up
        // dd($user);
        return view('mypage.family-index', compact('user', 'familyMembers'));
    }

//     public function family()
// {
//     $user = auth()->user()->load('userFamily');
//     return view('mypage.family-index', compact('user'));
// }



    public function create(Request $request)
    {
        $user = auth()->user(); // Get the authenticated user

        return view('mypage.family-create', compact('user')); // Pass the user to the view
    }



    public function familyStore(Request $request)
{
    $user=auth()->user();

    if ($request->isMethod('post')) {
        $validator = Validator::make($request->all(), [
            'family_name' => 'nullable|string|max:255',
            'family_relationship' => 'nullable|string|max:255',
            'family_birthdate' => 'nullable|date',



            'family_address_type' => 'nullable|string|in:社員と同一,別居',
            'family_address' => 'nullable|string|max:255',
            'family_estimated_income' => 'nullable|string|max:255',
            'family_insurance_status' => 'nullable|string|in:被扶養者,対象外',
            'family_name_furigana' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create a new UserFamily record
        $user->userFamily()->create($validator->validated());

        return redirect()->route('myPage.family')->with('success', '家族メンバーが正常に追加されました');
    }

    // If it's not a POST request, you might want to return a view
    return view('mypage.family-index', compact('user'));
}


public function edit($id)
{
    $user=auth()->user();
    $familyMember=$user->userFamily()->findOrFail($id);
    return view('myPage.family-edit', compact('user','familyMember'));
}


public function update(Request $request, $id)
{
    $user = auth()->user();
    $familyMember = $user->userFamily()->findOrFail($id);

    $validator = Validator::make($request->all(), [
        'family_name' => 'nullable|string|max:255',
        'family_relationship' => 'nullable|string|max:255',
        'family_birthdate' => 'nullable|date',
        'family_address_type' => 'nullable|string|in:社員と同一,別居',
        'family_address' => 'nullable|string|max:255',
        'family_estimated_income' => 'nullable|string|max:255',
        'family_insurance_status' => 'nullable|string|in:被扶養者,対象外',
        'family_name_furigana' => 'nullable|string|max:255',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    $familyMember->update($validator->validated());

    return redirect()->route('myPage.family')->with('success', '家族メンバー情報が正常に更新されました');
}

public function destroy($id)
{
    $user = auth()->user();
    $familyMember = $user->userFamily()->findOrFail($id);
    $familyMember->delete();

    return redirect()->route('myPage.family')->with('success', '家族メンバーが正常に削除されました');
}



















}

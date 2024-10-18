<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

use App\Models\BusinessCard;

class RequestController extends Controller
{

    protected $formModels = [
        'A' => BusinessCard::class,

    ];
    protected $formTypes = [
        'BusinessCard' => ['title' => '名刺作成依頼', 'view' => 'request.BusinessCard'],
        'Uniform' => ['title' => '制服注文依頼', 'view' => 'request.Uniform'],
        'MobilePhone' => ['title' => '携帯支給依頼', 'view' => 'request.MobilePhone'],
        'Computer' => ['title' => 'PC支給・返却依頼', 'view' => 'request.Computer'],
        'CompanyInfo' => ['title' => '会社案内、封筒依頼', 'view' => 'request.CompanyInfo'],
        'ClubActivity' => ['title' => '同好会 参加申込、活動状況', 'view' => 'request.ClubActivity'],
        'Exiv' => ['title' => 'エクシブの申し込み', 'view' => 'request.Exiv'],
    ];

    public function index()
    {
        return view('request.index', ['formTypes' => $this->formTypes]);
    }

    public function showForm($type)
    {
        if (!array_key_exists($type, $this->formTypes)) {
            abort(404);
        }

        return view($this->formTypes[$type]['view'], [
            'type' => $type,
            'title' => $this->formTypes[$type]['title']
        ]);
    }

    protected $formValidationRules = [
        'BusinessCard' => [
            'corp' => 'nullable|string|max:255',
            'office' => 'nullable|string|max:255',
            'division' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'piece' => 'nullable|string|max:255',
            'change_status' => 'nullable|string|max:255',
            'change_details' => 'nullable|string|max:255',
            'comment' => 'nullable|string|max:255',
            'boss_id' => 'required',
        ],
        // Add validation rules for other form types here
    ];


    public function store(Request $request, $type)
    {
        // Validate based on request type
        $validated = $this->validateRequest($request, $type);

        try {
            switch ($type) {
                case 'BusinessCard':
                    BusinessCard::create($validated);

                $businessCard=BusinessCard::create($validated);





                return redirect()->route('requests.index')
                ->with('success', '名刺作成依頼が正常に送信されました。');

                // case 'Uniform':
                //     Uniform::create($validated);
                //     $message = '制服注文依頼が送信されました';
                //     break;

                // case 'MobilePhone':
                //     MobilePhone::create($validated);
                //     $message = '携帯支給依頼が送信されました';
                //     break;

                // case 'Computer':
                //     Computer::create($validated);
                //     $message = 'PC支給・返却依頼が送信されました';
                //     break;

                // case 'CompanyInfo':
                //     CompanyInfo::create($validated);
                //     $message = '会社案内、封筒依頼が送信されました';
                //     break;

                // case 'ClubActivity':
                //     ClubActivity::create($validated);
                //     $message = '同好会申込が送信されました';
                //     break;

                // case 'Exiv':
                //     Exiv::create($validated);
                //     $message = 'エクシブの申し込みが送信されました';
                //     break;

                default:
                    return redirect()->back()->with('error', '無効なリクエストタイプです');
            }

            // return redirect()->route('requests.index')->with('success');

        } catch (\Exception $e) {


            return redirect()->back()
                ->with('error', '申し込み処理中にエラーが発生しました')
                ->withInput();
        }
    }

    protected function validateRequest(Request $request, $type)
    {
        $rules = [
            'BusinessCard' => [
                'corp' => 'nullable|string|max:255',
                'office' => 'nullable|string|max:255',
                'division' => 'nullable|string|max:255',
                'name' => 'nullable|string|max:255',
                'piece' => 'nullable|string|max:255',
                'change_status' => 'nullable|string|max:255',
                'change_details' => 'nullable|string|max:255',
                'comment' => 'nullable|string|max:255',
            ],
            'Uniform' => [
                // Add validation rules for Uniform
            ],
            'MobilePhone' => [
                // Add validation rules for MobilePhone
            ],
            'Computer' => [
                // Add validation rules for Computer
            ],
            'CompanyInfo' => [
                // Add validation rules for CompanyInfo
            ],
            'ClubActivity' => [
                // Add validation rules for ClubActivity
            ],
            'Exiv' => [
                // Add validation rules for Exiv
            ],
        ];

        return $request->validate($rules[$type] ?? []);
    }
}

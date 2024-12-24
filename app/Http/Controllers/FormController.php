<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\ApplicationTypeA;
use App\Models\ApplicationTypeB;
use App\Models\ApplicationTypeC;
use App\Models\ApplicationType2C;
use App\Models\ApplicationType2E;
use App\Models\ApplicationType2F;
use App\Models\ApplicationType2G;
use App\Models\ApplicationType2H;
use App\Models\ApplicationType3A;
use App\Models\ApplicationType3B;
use App\Models\ApplicationType3C;
use App\Models\ApplicationType3D;
use App\Models\ApplicationType3E;
use App\Models\ApplicationType3G;
use App\Models\ApplicationType3H;
use App\Models\ApplicationType3I;
use App\Models\ApplicationType3J;
use App\Models\ApplicationType2DA;
use App\Models\ApplicationType2DB;
use App\Models\ApplicationType6A1;
use App\Models\ApplicationType6A2;
use App\Models\ApplicationType6A3;
use App\Models\ApplicationType6A4;
use App\Models\ApplicationType6A5;
use League\CommonMark\Extension\DescriptionList\Node\Description;

class FormController extends Controller
{
    protected $formModels = [
        'A' => ApplicationTypeA::class,
        // 'B' => ApplicationTypeB::class,


        'C' => ApplicationTypeC::class,
        '3A' => ApplicationType3A::class,
        '3B' => ApplicationType3B::class,
        '3C' => ApplicationType3C::class,
        '3D' => ApplicationType3D::class,
        '3E' => ApplicationType3E::class,
        '3G' => ApplicationType3G::class,
        '3H' => ApplicationType3H::class,
        '3I' => ApplicationType3I::class,
        '3J' => ApplicationType3J::class,

        '2C' => ApplicationType2C::class,
        '2Da' => ApplicationType2DA::class,
        '2Db' => ApplicationType2DB::class,
        '2E' => ApplicationType2E::class,
        '2F' => ApplicationType2F::class,
        '2G' => ApplicationType2G::class,
        '2H' => ApplicationType2H::class,
        '6A1' => ApplicationType6A1::class,
        '6A2' => ApplicationType6A2::class,
        '6A3' => ApplicationType6A3::class,
        '6A4' => ApplicationType6A4::class,
        '6A5' => ApplicationType6A5::class,


        // Add future form types here
    ];


    public function index(Request $request)
    {

        $search=$request->input('search');
        // $formTypes = [
        //     'A' => ['title'=>'勤怠届','type'=>'TypeA'],
        //     // 'B' => ['title'=>'営業費使用伺書','type'=>'TypeB'],
        //     'C' => ['title'=>'休日出勤許可申請書･ﾒｰﾙ可(2021.8更新)','type'=>'TypeC'],
        //     'D' => ['title'=>'長時間労働問診票(2021.12更新)','type'=>'TypeD'],
        //     // Add all your form types
        // ];
        // return view('forms.index', compact('formTypes'));
        $formGroups = [
            '新規取引伺書' => [
                '5A' => ['title' => '新規取引伺書', 'type' => 'Type5A'],
            ],
            '取引関係' => [
                // 'B' => ['title' => '営業費使用伺書', 'type' => 'TypeB'],
            ],
            '各種申請書・伺書' => [
                '2A'=>['title'=>'00.(使用不可)07.ETC利用許可申請書(旧)', 'type'=> 'Type2A'],
                '2B'=>['title'=>'01.社内分譲申請書', 'type'=> 'Type2B'],
                '2C'=>['title'=>'02.営業費使用伺書', 'type'=> 'Type2C'],
                '2D' => [
                        'title' => '03.旅費交通費伺書(2023.1更新)',
                        'type' => 'Type2D',
                        'subforms' => [
                            'a' => ['title' => 'A.旅費交通費伺書', 'type' => 'Type2D'],
                            'b' => ['title' => 'B.旅費交通費伺書(自家用車使用)', 'type' => 'Type2D']
                        ]
                         ],
                '2E'=>['title'=>'04.交際費･会議費伺書(2023.1更新)', 'type'=> 'Type2E'],
                '2F'=>['title'=>'05.社内備品私的利用許可申請書(2021.8更新)', 'type'=> 'Type2F'],
                '2G'=>['title'=>'06.起案･稟議書(2021.4更新)', 'type'=> 'Type2G'],
                '2H'=>['title'=>'07.ETC利用許可申請書(2024.3更新)', 'type'=> 'Type2H'],



            ],

            '各種届出書' => [

                '3F' => ['title' => '01.給料振込口座登録、変更届', 'type' => 'Type3F'],
                '3A' => ['title' => '02.結婚届', 'type' => 'Type3A'],
                '3B' => ['title' => '03.出生届', 'type' => 'Type3B'],
                '3G' => ['title' => '04.扶養家族変更届', 'type' => 'Type3G'],
                '3H' => ['title' => '05.氏名変更届', 'type' => 'Type3H'],
                '3I' => ['title' => '06.住所変更届', 'type' => 'Type3I'],
                '3J' => ['title' => '07.通勤手段変更届', 'type' => 'Type3J'],

                '3C' => [
                    'title' => '08.退職届',
                    'type' => 'Type3C',
                    'search_content'=>'laachka'

                ],
                '3D' => ['title' => '09.休職届', 'type' => 'Type3D'],
                '3E' => [
                    'title' => '10.入院情告書',
                     'type' => 'Type3E',
                        'search_content'=> '休日出勤 休職届 退職届'
                        ],



            ],

            '勤怠関連' => [
                'A' => ['title' => '勤怠届', 'type' => 'TypeA'],
                'C' => [
                    'title' => '休日出勤許可申請書･ﾒｰﾙ可(2021.8更新)',
                    'type' => 'TypeC',
                    'search_content'=>'休日出勤 休日 出勤 許可申請書 holiday work overtime application D A'
                        ],

                'D' => [
                    'title' => '長時間労働問診票(2021.12更新)',
                     'type' => 'TypeD',
                     'search_content'=> '休日出勤 pos'
                        ],
            ],



            '車両関係' => [
                // 'B' => ['title' => '営業費使用伺書', 'type' => 'TypeB'],
            ],
            '慶弔関係' => [
                '6A' => [
                        'title' => '01.得意先慶弔連絡表(2023.1変更)',
                        'type' => 'Type6A',
                        'subforms' => [
                            '1' => ['title' => '1.訃報', 'type' => 'Type6A'],
                            '2' => ['title' => '2.開店', 'type' => 'Type6A'],
                            '3' => ['title' => '3.見舞い', 'type' => 'Type6A'],
                            '4' => ['title' => '4.見舞い（災害）', 'type' => 'Type6A'],
                            '5' => ['title' => '5.結婚', 'type' => 'Type6A'],
                        ]
                         ],
                '6B' => [
                        'title' => '02.社員慶弔連絡表(2023.1変更)',
                        'type' => 'Type6B',
                        'subforms' => [
                            '1' => ['title' => '1.結婚', 'type' => 'Type6B'],
                            '2' => ['title' => '2.訃報', 'type' => 'Type6B'],

                        ]
                         ],

            ],
            'その他書式' => [
                // 'B' => ['title' => '営業費使用伺書', 'type' => 'TypeB'],
            ],
            // Add more groups as needed
        ];
        $filteredGroups=$search ? $this->filterForms($formGroups, $search) : [];
        $relevantInstructions =$search ? $this->getRelevantInstructions($filteredGroups) :[];
        if($search)
        {
            $formGroups=$this->filterForms($formGroups,$search);
        }

        return view('forms.index', compact('formGroups','search','relevantInstructions'));

        }

        private function getRelevantInstructions($filteredGroups)
        {
            $instructions=[];
            foreach($filteredGroups as $group)
            {
                foreach($group as $key=> $form)
                {
                    if(isset($this->formInstructions[$key]))
                    {
                        $instructions=array_merge($instructions, $this->formInstructions[$key]);
                    }
                }
            }
            return $instructions;

        }


        private function filterForms($formGroups, $search)
        {
            $filteredGroups = [];

            foreach ($formGroups as $groupName => $forms) {
                $filteredForms = [];

                foreach ($forms as $key => $form) {
                    $searchContent = $form['search_content'] ?? '';
                    $title=$form['title'] ?? '';

                  if(mb_stripos($searchContent, $search) !==false || mb_stripos($title, $search) !==false)
                  {
                    $filteredForms[$key]= $form;
                  }
                    // Handle subforms if they exist
            if (isset($form['subforms'])) {
                $filteredSubforms = [];
                foreach ($form['subforms'] as $subKey => $subform) {
                    $subSearchContent = $subform['search_content'] ?? '';
                    $subTitle = $subform['title'] ?? '';
                    if (mb_stripos($subSearchContent, $search) !== false || mb_stripos($subTitle, $search) !== false) {
                        $filteredSubforms[$subKey] = $subform;
                    }
                }
                if (!empty($filteredSubforms)) {
                    $form['subforms'] = $filteredSubforms;
                    $filteredForms[$key] = $form;
                }
            }


                }
                if (!empty($filteredForms)) {
                    $filteredGroups[$groupName] = $filteredForms;
                }
            }
            return $filteredGroups;
        }


    private function formMatchesSearch($form,$search)
    {
        if(stripos($form['title'], $search) !==false)
        {
            return true;
        }

        $contentToSearch = $form['title'] .' '.($form['type'] ?? '') .' '. ($form['description'] ?? ' ');

        if(isset($form ['subforms']))
        {
            foreach($form['subforms'] as $subform)
            {
                $contentToSearch .= ' '. $subform['title'] . ' ' .($subform['type'] ?? ' '). ' ' . ($subform['description'] ?? ' ');

            }
        }
        return stripos($contentToSearch , $search) !== false;
    }

    // private function filterFormsByTitle($formGroups, $search)
    // {
    //     $filteredGroups = [];

    //     foreach ($formGroups as $groupName => $forms) {
    //         $filteredForms = [];

    //         foreach ($forms as $key => $form) {
    //             if (isset($form['subforms'])) {
    //                 $filteredSubforms = array_filter($form['subforms'], function ($subForm) use ($search) {
    //                     return stripos($subForm['title'], $search) !== false;
    //                 });

    //                 if (!empty($filteredSubforms)) {
    //                     $form['subforms'] = $filteredSubforms;
    //                     $filteredForms[$key] = $form;
    //                 }
    //             } else {
    //                 if (stripos($form['title'], $search) !== false) {
    //                     $filteredForms[$key] = $form;
    //                 }
    //             }
    //         }

    //         if (!empty($filteredForms)) {
    //             $filteredGroups[$groupName] = $filteredForms;
    //         }
    //     }

    //     return $filteredGroups;
    // }
    public function show($type)
    {
        $bosses = User::where('is_boss', true)->get();
        // $form = ApplicationTypeC::where('user_id', auth()->id())->latest()->first();

        //for search
          // Define search content for each form type
    $searchContents = [
        'C' => "休日出勤 休日 出勤 許可申請書 holiday work overtime application",
        // Add entries for other form types
    ];

        $searchContent=$searchContents[$type] ?? '';
        return view("forms.type{$type}", compact('bosses', 'type', 'searchContent'));
    }

    public function store(Request $request, $type)
    {

          // Define validation rules for each form type
    $validationRules = [
        'A' => [
            'leave_type' => 'required|string',
            'reason' => 'nullable',
            'boss_id'=>'required|string',
            // other rules for Form A
        ],
        'C' => [
            'request_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            // other rules for Form C
        ],

        '3A' => [
            'request_date1' => 'required|date',
            'request_date2' => 'required|date',
            'request_date3' => 'required|date',
            'spouse_furigana'=>'required',
            'spouse_name'=>'required',
            'birth_date'=>'required|date',
            'place_furigana'=>'required',
            'place_name'=>'required',
            'place_address_furigana'=>'required',
            'place_address_name'=>'required',
            'place_phone'=>'required',
            'support'=>'required',
            'name_change'=>'required',
            'address_change'=>'required',
            'emergency_contact_change'=>'required',

        ],
        '3B'=>[

        ],
        '3C'=>
        [

        ],
        '3D'=>
        [

        ],
        '3E'=>
        [

        ],
        '3G'=>
        [

        ],
        '3H'=>
        [

        ],
        '3I'=>
        [

        ],
        '3J'=>
        [

        ],
        //2 folder
        '2C'=>
        [

        ],
        '2Da'=>
        [

        ],
        '2Db'=>
        [

        ],
        '2E'=>
        [

        ],
        '2F'=>
        [

        ],
        '2G'=>
        [

        ],
        '2H'=>
        [

        ],


        '6A1'=>
        [

        ],
        '6A2'=>
        [

        ],
        '6A3'=>
        [

        ],
        '6A4'=>
        [

        ],
        '6A5'=>
        [

        ],



    ];

        // Ensure the form type exists in the form models mapping
        if (!array_key_exists($type, $this->formModels)) {

            return redirect()->back()->with('error', 'Invalid form type.');
        }

        // Get the model class for the specified form type
        $model = $this->formModels[$type];


        $specificForm = $model::create($request->except('boss_id', 'search_content'));



        $application = new Application([
            'user_id' => auth()->id(),
            'status' => 'pending',
            'boss_id'=>$request->boss_id
        ]);

        $specificForm->application()->save($application);

        // Here you would implement the logic to send the application to the selected boss
        // For example, you might create a notification or an email
        //$selectedBoss = User::findOrFail($request->boss_id);
        // dd($selectedBoss);
        // TODO: Implement sending logic here

        return redirect('applications')->with('success', 'Form submitted successfully and sent to the selected boss!');
    }

    public function update(Request $request, $type, $id = null)
    {
        $formClass = 'App\\Models\\Forms\\Form' . ucfirst($type);

        if (!class_exists($formClass)) {
            abort(404, 'Form type not found');
        }

        $validatedData = $request->validate([
            // ... other validation rules ...
            'reason' => 'nullable',
            'boss_id' => 'required',
            // Add other fields as necessary
        ]);

        if ($id) {
            // Updating existing form
            $form = $formClass::findOrFail($id);
            $form->update($validatedData);
        } else {
            // Creating new form
            $form = new $formClass();
            $form->fill($validatedData);
            $form->save();

            // Create new application only if it's a new form
            $application = new Application();
            $application->user_id = auth()->id();
            $application->status = "pending";
            $application->boss_id = $validatedData['boss_id'];
            $application->applicationable()->associate($form);
            $application->save();
        }

        // If updating, find the associated application and update its boss_id
        if ($id) {
            $application = Application::where('applicationable_type', get_class($form))
                                      ->where('applicationable_id', $form->id)
                                      ->first();
            if ($application) {
                $application->boss_id = $validatedData['boss_id'];
                $application->save();
            }
        }

        return redirect()->route('applications.show', $application->id);
    }

        // ... other methods ...


        protected $formInstructions=[
            'A'=>[
                ['question' =>'勤怠届の記入方法は？', 'answer'=>'日付、休暇の種類、理由を明確に記入してください。' ],
                // ['question' =>'勤怠届の提出期限は？', 'answer'=>'原則として、休暇の3日前までに提出してください。' ],

            ],
            'C'=>[
                ['question' =>'休日出勤許可申請書の記入上の注意点は？', 'answer'=>'出勤日時と業務内容を具体的に記入し、上司の承認を得てください。' ],
                // ['question' =>'休日出勤の事後申請は可能ですか？', 'answer'=>'原則として事前申請ですが、緊急時は事後申請も可能です。その場合は理由を明記してください。' ],
            ],
            'D'=>[
                ['question' =>'休日出勤許可申請書の記入上の注意点は？', 'answer'=>'出勤日時と業務内容を具体的に記入し、上司の承認を得てください。' ],
                // ['question' =>'休日出勤の事後申請は可能ですか？', 'answer'=>'原則として事前申請ですが、緊急時は事後申請も可能です。その場合は理由を明記してください。' ],
            ],
            '3C'=>[
                ['question' =>'退職届についてどう思いますか', 'answer'=>'どうでもいい' ],
                ['question' =>'退職届についてどう思いますか', 'answer'=>'援ノリ権止田ぽ校負もづ戦能ツ明察おゃい意46情景ソ広森分ち年禁家おせに更買非債をろ。載ふえてん時属ぞラみ玄踏ざばすリ区切ん従注っックゃ索問チロ日公おゆトリ明変ヌマイ能演稿スルハ伝両クアモイ整生月ぴ校17暮うやイ訃描仰巣じふ。需満マオツ本紙みい本10報門フち方改サユホ諸加フイアオ払貨ヲトヨ広9写経ぱみぽス易金ワトヲリ代会ド立69報ム輝野セヌテヨ注押シワエレ頭有びラ条抄も' ],
                ['question' =>'退職届についてどう思いますか', 'answer'=>'援ノリ権止dsafdas田ぽ校負もづ戦能ツ明察おゃい意46情景ソ広森分ち年禁家おせに更買非債をろ。' ],
                ['question' =>'退職届についてどう思いますか', 'answer'=>'援ノリ権止田ぽ校負もづ戦能ツ明察おゃい意46情景ソ広森分ち年禁家おせに更買非債をろ。fw' ],
                ['question' =>'退職届についてどう思いますか', 'answer'=>'援ノリ権止田ぽ校負もづ戦能ツ明察おゃい意46情景ソ広森分ち年禁家おせに更買非債をろ。tewwetwetw' ],
                // ['question' =>'休日出勤の事後申請は可能ですか？', 'answer'=>'原則として事前申請ですが、緊急時は事後申請も可能です。その場合は理由を明記してください。' ],
            ],

        ];


}

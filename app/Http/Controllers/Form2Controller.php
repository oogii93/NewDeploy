<?php

namespace App\Http\Controllers;

use App\Models\Application2;
use Illuminate\Http\Request;
use App\Models\Application2Type01A;
use App\Models\Application2Type03A;
use Illuminate\Foundation\Auth\User;

class Form2Controller extends Controller
{
    //

    protected $formModels = [
        // 'A' => ApplicationTypeA::class,

    ];


    // public function index(Request $request)
    // {

    //     $search=$request->input('search');

    //     $formGroups = [

    //         '各種申請書・伺書' => [



    //             '01A'=>['title'=>'001.名刺作成依頼', 'type'=> 'Type01A'],





    //         ],


    //     ];
    //     $filteredGroups=$search ? $this->filterForms($formGroups, $search) : [];
    //     $relevantInstructions =$search ? $this->getRelevantInstructions($filteredGroups) :[];

    //     return view('forms2.index', compact('formGroups','filteredGroups', 'search', 'relevantInstructions'));

    //     }

    public function index(Request $request)
{
    $search = $request->input('search');

    $forms = [
        '01A' => ['title' => '001.名刺作成依頼', 'type' => 'Type01A'],
        '02A' => ['title' => '002.制服注文依頼', 'type' => 'Type02A'],
        '03A' => ['title' => '003.会社案内、封筒依頼', 'type' => 'Type03A'],
        // Add other forms here as needed
    ];

    $filteredForms = $search ? $this->filterForms($forms, $search) : [];
    $relevantInstructions = $search ? $this->getRelevantInstructions($filteredForms) : [];

    return view('forms2.index', compact('forms', 'filteredForms', 'search', 'relevantInstructions'));
}




        private function filterForms($formGroups, $search)
        {
            $filteredGroups = [];

            foreach ($formGroups as $groupName => $forms) {
                $filteredForms = [];

                foreach ($forms as $key => $form) {
                    $searchContent = $form['search_content'] ?? '';
                    $title=$form['title'] ?? '';
                    $type = $form['type'] ?? '';



                  if(mb_stripos($searchContent, $search) !==false
                  || mb_stripos($title, $search) !==false
                  || mb_stripos($type, $search) !==false)

                  {
                    $filteredForms[$key]= $form;
                  }


                    // Handle subforms if they exist
            if (isset($form['subforms'])) {
                $filteredSubforms = [];
                foreach ($form['subforms'] as $subKey => $subform) {
                    $subSearchContent = $subform['search_content'] ?? '';
                    $subTitle = $subform['title'] ?? '';
                    $subType=$subform['type'] ?? '';
                    if (mb_stripos($subSearchContent, $search) !== false

                    || mb_stripos($subTitle, $search) !== false
                    || mb_stripos($subType, $search) !==false
                    ) {
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
        '01A' => "名刺作成依頼 business card request",

        // Add entries for other form types
    ];

        $searchContent=$searchContents[$type] ?? '';
        return view("forms2.type{$type}", compact('bosses', 'type', 'searchContent'));
    }

    // public function store(Request $request, $type)
    // {
    //     // Define validation rules for each form type
    //     $validationRules = [
    //         '01A' => [
    //             'corp' => 'nullable|string|max:255',
    //             'office' => 'nullable|string|max:255',
    //             'division' => 'nullable|string|max:255',
    //             'name' => 'nullable|string|max:255',
    //             'piece' => 'required|integer|min:1',
    //             'change_status' => 'required|in:change_status',
    //             'change_details' => 'required_if:change_status,change_status|nullable|string|max:255',
    //             'comment' => 'nullable|string|max:1000',
    //         ],
    //     ];

    //     // Validate the request data
    //     $validatedData = $request->validate($validationRules[$type]);

    //     // Create a new instance of the model based on the type
    //     switch ($type) {
    //         case '01A':
    //             $model = new Application2Type01A();
    //             break;
    //         // Add cases for other form types here
    //         default:
    //             return redirect()->back()->with('error', 'Invalid form type.');
    //     }

    //     // Fill the model with validated data and save
    //     $model->fill($validatedData);
    //     // $model->user_id = auth()->id();
    //     $model->save();

    //     // Create and save the associated Application2
    //     $application2 = new Application2([
    //         'user_id' => auth()->id(),
    //         'status' => 'pending',
    //     ]);
    //     $model->application2()->save($application2);

    //     return redirect('applications2')->with('success', 'Form submitted successfully!');
    // }


    public function store(Request $request, $type)
{
    // Define validation rules for each form type
    $validationRules = [
        '01A' => [
            'corp' => 'nullable|string|max:255',
            'office' => 'nullable|string|max:255',
            'division' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'piece' => 'required|integer|min:1',
            'change_status' => 'required|in:change_status,no_change',
            'change_details' => 'nullable|string|max:255',
            'comment' => 'nullable|string|max:1000',
        ],
        '03A' => [
            'corp' => 'nullable|string|max:255',
            'office' => 'nullable|string|max:255',
            'division' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'companyProfile' => 'nullable|integer|',
            'cover' => 'nullable|integer|',
            'order' => 'nullable|integer|',


            'comment' => 'nullable|string|max:1000',
        ],
        // Add validation rules for other form types here
    ];

    // Ensure the form type exists in the validation rules
    if (!array_key_exists($type, $validationRules)) {
        return redirect()->back()->with('error', 'Invalid form type.');
    }

    // Validate the request data
    $validatedData = $request->validate($validationRules[$type]);

    // Create a new instance of the model based on the type
    $model = $this->getModelForType($type);
    if (!$model) {
        return redirect()->back()->with('error', 'Invalid form type.');
    }

    // Fill the model with validated data and save
    $model->fill($validatedData);
    // $model->user_id = auth()->id();
    $model->save();

    // Create and save the associated Application2
    $application2 = new Application2([
        'user_id' => auth()->id(),
        'status' => 'pending',
    ]);
    $model->applicationable2()->save($application2);

    return redirect('forms2')->with('success', 'フォームが正常に送信されました。');
}

private function getModelForType($type)
{
    switch ($type) {
        case '01A':
            return new Application2Type01A();
        // Add cases for other form types here
        case '03A':  // Add this case for 03A
            return new Application2Type03A();


        default:
            return null;
    }
}
        // Get the model class for the specified form type
        // $model = $this->formModels[$type];


        // $specificForm = $model::create($request->except('boss_id', 'sarch_content'));



        // $application = new Application([
        //     'user_id' => auth()->id(),
        //     'status' => 'pending',
        //     'boss_id'=>$request->boss_id
        // ]);

        // $specificForm->application()->save($application);

        // Here you would implement the logic to send the application to the selected boss
        // For example, you might create a notification or an email
        //$selectedBoss = User::findOrFail($request->boss_id);
        // dd($selectedBoss);
        // TODO: Implement sending logic here

        // return redirect('applications')->with('success', 'Form submitted successfully and sent to the selected boss!');


    // public function update(Request $request, $type, $id = null)
    // {
    //     $formClass = 'App\\Models\\Forms\\Form' . ucfirst($type);

    //     if (!class_exists($formClass)) {
    //         abort(404, 'Form type not found');
    //     }

    //     $validatedData = $request->validate([
    //         // ... other validation rules ...
    //         'reason' => 'nullable',
    //         'boss_id' => 'required',
    //         // Add other fields as necessary
    //     ]);

    //     if ($id) {
    //         // Updating existing form
    //         $form = $formClass::findOrFail($id);
    //         $form->update($validatedData);
    //     } else {
    //         // Creating new form
    //         $form = new $formClass();
    //         $form->fill($validatedData);
    //         $form->save();

    //         // Create new application only if it's a new form
    //         $application = new Application();
    //         $application->user_id = auth()->id();
    //         $application->status = "pending";
    //         $application->boss_id = $validatedData['boss_id'];
    //         $application->applicationable()->associate($form);
    //         $application->save();
    //     }

    //     // If updating, find the associated application and update its boss_id
    //     if ($id) {
    //         $application = Application::where('applicationable_type', get_class($form))
    //                                   ->where('applicationable_id', $form->id)
    //                                   ->first();
    //         if ($application) {
    //             $application->boss_id = $validatedData['boss_id'];
    //             $application->save();
    //         }
    //     }

    //     return redirect()->route('applications.show', $application->id);
    // }

        // ... other methods ...




}

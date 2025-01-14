
<x-app-layout>

    <div class="mt-5 mb-5 flex justify-center">



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>問い合わせ</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<div class="w-full max-w-4xl bg-white shadow-lg rounded-xl p-6">



    <form action="{{ route('forms.update', ['type' => '5A', 'id' => $form->id]) }}" method="POST">
        @csrf
        @method('PUT')

            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">新規取引伺書</h1>
                <p class="text-gray-500 mt-2">※本書式を事前提出し社長認可を受けてから、売買契約書を作成すること。</p>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="office" class="block text-sm font-medium text-gray-700 mb-2">
                        会社
                    </label>
                    <input
                    readonly
                        id="corp"
                        name="corp"
                        value="{{ $form->corp }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                    >


                    </input>
                </div>
                <div>
                    <label for="office" class="block text-sm font-medium text-gray-700 mb-2">
                        営業所
                    </label>
                    <input
                    readonly
                        id="office"
                        name="office"
                        value="{{ $form->office }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                    >


                    </input>
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        名前
                    </label>
                    <input

                         readonly
                        type="text"
                        id="name"
                        name="name"
                        value="{{ $form->name }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        placeholder="Enter your full name"
                    >
                </div>


                <div>
                    <label for="occurrence_date" class="block text-sm font-medium text-gray-700 mb-2">
                 日付け
                    </label>
                    <input
                    type="date"
                    id="applied_date"
                    name="applied_date"
                    value="{{ $form->applied_date }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                    >
                </div>


                <div class="col-span-full">

                    <div class="text-center font-semibold text-gray-600 text-xl relative">
                        <label for="" class="">企業情報</label>
                        <div class="absolute inset-x-0 top-full mt-2 h-[2px] bg-blue-300"></div>
                    </div>
                </div>
            </div>

                <div class="grid md:grid-cols-2 gap-6 mt-5">



                    <div class="">
                        <label for="client_name" class="block text-sm font-medium text-gray-700 mb-2 mt-2">
                            取引先名（フリガナ）
                        </label>
                        <input

                        value="{{ $form->client_name_furigana }}"
                            id="client_name_furigana"
                            name="client_name_furigana"
                            value=""
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >


                        </input>
                    </div>

                    <div>
                        <label for="client_name" class="block text-sm font-medium text-gray-700 mb-2 mt-2">
                            取引先名（漢字、商号）
                        </label>
                        <input


                        value="{{ $form->client_name }}"
                            type="text"
                            id="client_name"
                            name="client_name"
                            value=""
                            placeholder="IC-Mへの登録名称になるので正式名称で入力して下さい。"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >


                        </input>
                    </div>
                    <div class="">
                        <label for="president_name" class="block text-sm font-medium text-gray-700 mb-2 mt-2">
                           代表者名
                        </label>
                        <input


                        value="{{ $form->president_name }}"
                            id="president_name"
                            name="president_name"
                            value=""
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >


                        </input>
                    </div>
                    <div>
                        <label for="president_birthdate" class="block text-sm font-medium text-gray-700 mb-2 mt-2">
                            代表者生年月日
                        </label>
                        <input


                            value="{{ $form->president_birthdate }}"
                            type="date"
                            id="president_birthdate"
                            name="president_birthdate"
                            value=""
                            placeholder=""
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >


                        </input>
                    </div>

                    <div class="w-1/3">
                        <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2 mt-2">
                            〒
                        </label>
                        <input
                        value="{{ $form->postal_code }}"
                        type="number"
                            id="postal_code"
                            name="postal_code"
                            value=""
                            class=" px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >


                        </input>
                    </div>

                    <div class="col-span-full mb-2">

                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2 mt-2">
                           住所
                        </label>
                        <input
                        value="{{ $form->address }}"
                            id="address"
                            name="address"
                            value=""
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >


                        </input>
                    </div>



                </div>
                <div class="grid md:grid-cols-2 gap-6">



                    <div class="mb-2">
                        <label for="tel_number" class="block text-sm font-medium text-gray-700 mb-2 mt-7">
                           TEL
                        </label>
                        <input

                        value="{{ $form->tel_number }}"

                        type="number"
                            id="tel_number"
                            name="tel_number"
                            value=""
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >


                        </input>
                    </div>
                    <div>
                        <label for="fax_number" class="block text-sm font-medium text-gray-700 mb-2 mt-7">
                            FAX
                        </label>
                        <input

                        value="{{ $form->fax_number }}"
                            type="number"
                            id="fax_number"
                            name="fax_number"
                            value=""
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >


                        </input>
                    </div>

                    <div class="">
                        <label for="office_description" class="block text-sm font-medium text-gray-700 mb-2 mt-2">
                            事業内容
                        </label>
                        <textarea

                            id="office_description"
                            name="office_description"
                            value=""
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >{{ $form->office_description }}


                        </textarea>
                    </div>


                    <div>
                        <label for="main_supplier" class="block text-sm font-medium text-gray-700 mb-2 mt-2">
                            主要  仕入先

                        </label>
                        <input
                            type="text"
                            id="main_supplier"
                            name="main_supplier"
                            value="{{ $form->main_supplier }}"
                            placeholder="IC-Mへの登録名称になるので正式名称で入力して下さい。"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >


                        </input>
                    </div>

                    <div class="">
                        <label for="annual_turnover" class="block text-sm font-medium text-gray-700 mb-2 mt-2">
                            年商

                        </label>
                        <input

                        type="number"
                            id="annual_turnover"
                            name="annual_turnover"
                            value="{{ $form->annual_turnover }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >


                        </input>
                    </div>
                    <div>
                        <label for="capital" class="block text-sm font-medium text-gray-700 mb-2 mt-2">
                            資本金

                        </label>
                        <input
                             type="number"
                            id="capital"
                            name="capital"
                            value="{{ $form->capital }}"
                            placeholder=""
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >


                        </input>
                    </div>
                    <div class="">
                        <label for="office" class="block text-sm font-medium text-gray-700 mb-2 mt-2">
                            企業形態

                        </label>
                        <select

                            id="company_type"
                            name="company_type"
                            value=""
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >
                        <option value="">リストから選択してください。</option>
                        <option value="株式会社" {{ $form->company_type === '株式会社' ? 'selected' : '' }}>株式会社</option>
                        <option  value="有限会社"{{ $form->company_type === '有限会社' ? 'selected' : '' }}>有限会社</option>
                        <option value="合同会社"{{ $form->company_type === '合同会社' ? 'selected' : '' }}>合同会社</option>
                        <option  value="合弁会社"{{ $form->company_type === '合弁会社' ? 'selected' : '' }}>合弁会社</option>
                        <option  value="財団法人"{{ $form->company_type === '財団法人' ? 'selected' : '' }}>財団法人</option>
                        <option  value="個人"{{ $form->company_type === '個人' ? 'selected' : '' }}>個人</option>
                        <option  value="その他"{{ $form->company_type === 'その他' ? 'selected' : '' }}>その他</option>


                        </select>
                    </div>
                    <div>
                        <label for="office" class="block text-sm font-medium text-gray-700 mb-2 mt-2">
                            電気工事組合

                        </label>
                        <select
                            type="text"
                            id="union"
                            name="union"
                            value=""
                            placeholder=""
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >
                        <option value="加入" {{ $form->union === "加入" ? 'selected' : '' }} >加入</option>
                        <option value="未加入" {{ $form->union === '未加入' ? 'selected' : '' }} >未加入</option>


                        </select>
                    </div>
                    <div class="">
                        <label for="male_worker" class="block text-sm font-medium text-gray-700 mb-2 mt-2">
                            企業員（男）

                        </label>
                        <input
                            type="number"
                            id="male_worker"
                            name="male_worker"
                            value="{{ $form->male_worker }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >


                        </input>
                    </div>
                    <div>
                        <label for="office" class="block text-sm font-medium text-gray-700 mb-2 mt-2">
                            企業員（女）

                        </label>
                        <input
                            type="number"
                            id="female_worker"
                            name="female_worker"
                            value="{{ $form->female_worker }}"
                            placeholder=""
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >


                        </input>
                    </div>
                    <div class="">
                        <label for="office" class="block text-sm font-medium text-gray-700 mb-2 mt-2">
                            知事登録（登録番号）

                        </label>
                        <input
                        type="text"
                            id="registration_number"
                            name="registration_number"
                            value="{{ $form->registration_number }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >


                        </input>
                    </div>
                </div>

                <div class="grid md:grid-cols-3 gap-6">

                    <div class="mt-4 mb-2">
                        <label for="" class="block text-gray-600 font-medium mb-2">店舗</label>
                        <div class="flex items-center space-x-4">
                            <label class="flex items-center space-x-2">
                                <input disabled type="radio" name="shop" value="賃借" class="form-radio text-blue-500" {{ $form->shop === '賃借' ? 'checked' : '' }}>
                                <span>賃借</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input disabled type="radio" name="shop" value="持ち家" class="form-radio text-blue-500" {{ $form->shop === '持ち家' ? 'checked' : '' }}>
                                <span>持ち家</span>
                            </label>
                        </div>
                    </div>

                        <div class="mt-4 mb-2">
                            <label for="" class="block text-gray-600 font-medium mb-2">担保設定</label>
                            <div class="flex items-center space-x-4">
                                <label class="flex items-center space-x-2">
                                    <input  type="radio" name="baritsaa" value="有" class="form-radio text-blue-500" {{ $form->baritsaa === '有' ? 'checked' : '' }}>
                                    <span>有</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input  type="radio" name="baritsaa" value="無" class="form-radio text-blue-500" {{ $form->baritsaa === '無' ? 'checked' : '' }}>
                                    <span>無</span>
                                </label>
                            </div>
                        </div>
                        <div class="mt-4 mb-2">
                            <label for="" class="block text-gray-600 font-medium mb-2">担保設定状況</label>
                            <div class="flex items-center space-x-4">
                                <label class="flex items-center space-x-2">
                                    <input  type="radio" name="baritsaa_status" value="銀行" class="form-radio text-blue-500" {{ $form->baritsaa_status === '銀行' ? 'checked' : '' }}>
                                    <span>銀行</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input  type="radio" name="baritsaa_status" value="ノンバンク" class="form-radio text-blue-500" {{ $form->baritsaa_status === 'ノンバンク' ? 'checked' : '' }}>
                                    <span>ノンバンク</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input  type="radio" name="baritsaa_status" value="他" class="form-radio text-blue-500" {{$form->baritsaa_status === '他' ? 'checked' : '' }}>
                                    <span>他</span>
                                </label>
                            </div>
                        </div>


                 </div>


                <div class="grid md:grid-cols-3 gap-6">

                        <div class="mt-4 mb-2">
                            <label for="" class="block text-gray-600 font-medium mb-2">社長自宅</label>
                            <div class="flex items-center space-x-4">
                                <label class="flex items-center space-x-2">
                                    <input  type="radio" name="president_home" value="賃借" class="form-radio text-blue-500" {{ $form->president_home === '賃借' ? 'checked' : '' }}>
                                    <span>賃借</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input  type="radio" name="president_home" value="持ち家" class="form-radio text-blue-500" {{ $form->president_home === '持ち家' ? 'checked' : '' }}>
                                    <span>持ち家</span>
                                </label>
                            </div>
                        </div>

                        <div class="mt-4 mb-2">
                            <label for="" class="block text-gray-600 font-medium mb-2">担保設定</label>
                            <div class="flex items-center space-x-2">
                                <label class="flex items-center space-x-2">
                                    <input   type="radio" name="president_baritsaa" value="有" class="form-radio text-blue-500" {{ $form->president_baritsaa === '有' ? 'checked' : '' }}>
                                    <span>有</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input   type="radio" name="president_baritsaa" value="無" class="form-radio text-blue-500" {{ $form->president_baritsaa === '無' ? 'checked' : '' }}>
                                    <span>無</span>
                                </label>
                            </div>
                        </div>

                        <div class="mt-4 mb-2">
                            <label for="" class="block text-gray-600 font-medium mb-2">担保設定状況</label>
                            <div class="">
                                <label class="flex items-center space-x-2">
                                    <input  type="radio" name="president_baritsaa_status" value="住宅ローン" class="form-radio text-blue-500" {{ $form->president_baritsaa_status === '住宅ローン' ? 'checked' : '' }}>
                                    <span>住宅ローン</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input  type="radio" name="president_baritsaa_status" value="銀行" class="form-radio text-blue-500" {{ $form->president_baritsaa_status === '銀行' ? 'checked' : '' }}>
                                    <span>銀行</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input  type="radio" name="president_baritsaa_status" value="ノンバンク" class="form-radio text-blue-500" {{ $form->president_baritsaa_status === 'ノンバンク' ? 'checked' : '' }}>
                                    <span>ノンバンク</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input   type="radio" name="president_baritsaa_status" value="他" class="form-radio text-blue-500" {{$form->president_baritsaa_status === '他' ? 'checked' : '' }}>
                                    <span>他</span>
                                </label>
                            </div>
                        </div>


                 </div>


                 <div class="col-span-full mb-4">

                    <div class="text-center font-semibold text-gray-600 text-xl relative">
                        <label for="" class="">取引条件</label>
                        <div class="absolute inset-x-0 top-full mt-2 h-[2px] bg-blue-300"></div>
                    </div>
                </div>
                <label for="office" class="block text-sm font-semibold text-gray-700 mb-2 mt-7 text-center">
                    回収条件
                </label>

                <div class="grid md:grid-cols-3 gap-6">



                    <div class="mb-2">
                        <label for="office" class="block text-sm font-medium text-gray-700 mb-2 mt-7">
                            締日
                        </label>
                        <input
                        type="date"

                            id="expire_date"
                            name="expire_date"
                            value="{{ $form->expire_date }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >


                        </input>
                    </div>

                    <div>
                        <label for="office" class="block text-sm font-medium text-gray-700 mb-2 mt-7">
                          支払月
                        </label>
                        <select


                            id="payment_day"
                            name="payment_day"

                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >

                        <option value="当月" {{ $form->payment_day === '当月' ? 'selected' : '' }}>当月</option>
                        <option value="翌月" {{ $form->payment_day === '翌月' ? 'selected' : '' }}>翌月</option>


                        </select>
                    </div>
                    <div>
                        <label for="office" class="block text-sm font-medium text-gray-700 mb-2 mt-7">
                            支払日
                        </label>
                        <input

                            type="number"
                            id="payment_date"
                            name="payment_date"
                            value="{{ $form->payment_date }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >



                        </input>
                    </div>


                </div>

                <div class="col-span-full mb-2">

                    <label for="office" class="block text-sm font-medium text-gray-700 mb-2 mt-2">
                       その他
                    </label>
                    <input

                        id="other_payment"
                        name="other_payment"
                        value="{{ $form->other_payment }}"
                    placeholder="支払いの条件が当月、翌月以外の場合は記入してください。"

                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                    >


                    </input>
                </div>
                <label for="office" class="block text-sm font-semibold text-gray-700 mb-2 mt-7 text-center">
                    回収方法
                </label>

                <div class="grid md:grid-cols-2 gap-6">



                    <div class="mb-2">
                        <label for="collection_method" class="block text-sm font-medium text-gray-700 mb-2 mt-7">
                            回収方法
                        </label>
                        <select
                        type=""
                            id="collection_method"
                            name="collection_method"
                            value=""
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >

                        <option   value="振込" {{ $form->collection_method === '振込' ? 'selected' : '' }}>振込</option>
                        <option   value="現金" {{ $form->collection_method === '現金' ? 'selected' : '' }}>現金</option>



                        </select>

                    </div>

                    <div>
                        <label for="cr_persent" class="block text-sm font-medium text-gray-700 mb-2 mt-7">
                            ＣＲ率
                        </label>
                        <input


                            id="cr_persent"
                            name="cr_persent"
                            placeholder="%"
                            value="{{ $form->cr_persent }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >



                    </input>
                    </div>

                    <div>
                        <label for="office" class="block text-sm font-medium text-gray-700 mb-2 mt-2">
                            手形 (手形サイト)
                        </label>
                        <input
                            type="number"
                            id="bill"
                            name="bill"
                            value="{{ $form->bill }}"

                            placeholder="日 (締日起算)"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >

                        </input>
                    </div>

                    <div >

                        <label for="office" class="block text-sm font-medium text-gray-700 mb-2 mt-2">
                           その他
                        </label>
                        <input


                            id="collection_other"
                            name="collection_other"
                            value="{{ $form->collection_other }}"
                        placeholder=""

                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >


                        </input>
                    </div>


                    <div class="mt-4 mb-2">
                        <label for="" class="block text-gray-600 font-medium mb-2">専用伝票</label>
                        <div class="flex items-center space-x-4">
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="special" value="有" class="form-radio text-blue-500" {{ $form->special === '有' ? 'checked' : '' }} >
                                <span>有</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="special" value="無" class="form-radio text-blue-500" {{ $form->special === '無' ? 'checked' : '' }} >
                                <span>無</span>
                            </label>
                        </div>
                    </div>

                    <div class="mt-4 mb-2">
                        <label for="" class="block text-gray-600 font-medium mb-2">取引契約書 取得（予定）日</label>
                        <div class="flex items-center space-x-4">
                            <label class="flex items-center space-x-2">
                                <input


                                type="date"
                                id="transaction_aggreement_date"
                                name="transaction_aggreement_date"
                                value="{{ $form->transaction_aggreement_date }}"
                                placeholder=""
                                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                            >


                            </input>

                            </label>

                        </div>
                    </div>



                </div>


                <div class="col-span-full">


                <div class="col-span-full">
                    <label for="remarks" class="block text-sm font-medium text-gray-700 mb-2">
                        備考
                    </label>
                    <textarea


                        id="remarks"
                        name="remarks"
                        rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        placeholder=""
                    >
                {{ $form->remarks }}</textarea>
                </div>
            </div>


            <div class="col-span-full mb-4 mt-5">

                <div class="text-center font-semibold text-gray-600 text-xl relative">
                    <label for="" class="">限度申請</label>
                    <div class="absolute inset-x-0 top-full mt-2 h-[2px] bg-blue-300"></div>
                </div>

            <div class="grid md:grid-cols-2 gap-6">

                <div class="mt-6">

                    <label for="expected_sales" class="block text-sm font-medium text-gray-700 mb-2 mt-2">
                        売上予定額／月
                    </label>
                    <div class="relative">
                        <input
                            type="number"

                            id="expected_sales"
                            name="expected_sales"
                            value="{{ $form->expected_sales }}"
                            class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                            万円
                        </div>
                    </div>

                </div>
                <div class="mt-6">

                    <label for="limit_amount" class="block text-sm font-medium text-gray-700 mb-2 mt-2">
                        信用限度申請額
                    </label>



                    <div class="relative">
                        <input
                            type="number"

                            id="limit_amount"
                            name="limit_amount"
                            value="{{ $form->limit_amount }}"
                            class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                            万円
                        </div>
                    </div>




                </div>


                <div class="mb-2">
                    <label for="" class="block text-gray-600 font-medium mb-2">連帯保証人(第三者)</label>
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center space-x-2">
                            <input  type="radio" name="3rdPerson" value="有" class="form-radio text-blue-500" onchange="toggleInput()" {{ $form['3rdPerson'] === '有' ? 'checked' : '' }}>
                            <span>有</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input  type="radio" name="3rdPerson" value="無" class="form-radio text-blue-500" onchange="toggleInput()" {{ $form['3rdPerson'] === '無' ? 'checked' : '' }}>
                            <span>無</span>
                        </label>
                    </div>

                    <div id="textInputContainer" class="mt-2 hidden">
                        <input type="text"  name="3rd_person_text" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" placeholder="保証人情報を入力">
                    </div>
                </div>

                <div class="mt-2">

                    <label for="office" class="block text-sm font-medium text-gray-700 mb-2">
                        信用限度設定額
                    </label>

                    <div class="relative">
                        <input
                            type="number"

                            id="decided_limit_amount"
                            name="decided_limit_amount"
                            value="{{ $form->decided_limit_amount }}"
                            class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                            万円
                        </div>
                    </div>


                </div>

                <div class="mt-2">

                    <label for="office" class="block text-sm font-medium text-gray-700 mb-2">
                        信用度
                    </label>
                    <select


                        id="trust_rate"
                        name="trust_rate"
                        value=""

                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                    >
                    <option value="A" {{ $form->trust_rate === 'A' ? 'selected' : '' }}>A</option>
                    <option value="B" {{ $form->trust_rate === 'B' ? 'selected' : '' }}>B</option>
                    <option value="C" {{ $form->trust_rate === 'C' ? 'selected' : '' }}>C</option>
                    <option value="D" {{ $form->trust_rate === 'D' ? 'selected' : '' }}>D</option>


                </select>


                </div>


                <div class="mt-2">

                    <label for="guarantor1" class="block text-sm font-medium text-gray-700 mb-2">
                        代表者と連帯保証人の関係
                    </label>

                    <label for="" class="block text-sm font-medium text-gray-700 mb-2">第一連帯保証人</label>


                    <select
                        id="guarantor1"
                        name="guarantor1"
                        value=""


                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300">

                    <option value="本人" {{ $form->guarantor1 === '本人' ? 'selected' : '' }}>本人</option>
                    <option value="親子" {{ $form->guarantor1 === '親子' ? 'selected' : '' }}>親子</option>
                    <option value="親戚" {{ $form->guarantor1 === '親戚' ? 'selected' : '' }}>親戚</option>
                    <option value="配偶者" {{ $form->guarantor1 === '配偶者' ? 'selected' : '' }}>配偶者</option>
                    <option value="兄弟" {{ $form->guarantor1 === '兄弟' ? 'selected' : '' }}>兄弟</option>
                    <option value="友人知人" {{ $form->guarantor1 === '友人知人' ? 'selected' : '' }}>友人知人</option>
                </select>




                <label for="" class="block text-sm font-medium text-gray-700 mb-1 mt-2">第二連帯保証人</label>
                    <select
                        id="guarantor2"
                        name="guarantor2"
                        value=""

                        class="mt-3 mb-3 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                    >
                    <option value="配偶者"{{ $form->guarantor2 === '配偶者' ? 'selected' : '' }} >配偶者</option>
                    <option value="親子" {{ $form->guarantor2 === '親子' ? 'selected' : '' }}>親子</option>
                    <option value="兄弟" {{ $form->guarantor2 === '兄弟' ? 'selected' : '' }}>兄弟</option>
                    <option value="親戚" {{ $form->guarantor2 === '親戚' ? 'selected' : '' }}>親戚</option>
                    <option value="友人知人" {{ $form->guarantor2 === '友人知人' ? 'selected' : '' }}>友人知人</option>


                </select>

                <label for="" class="block text-sm font-medium text-gray-700 mb-1 mt-2">第三連帯保証人</label>

                    <select
                        id="guarantor3"
                        name="guarantor3"
                        value=""

                        class="mt-3 mb-3 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                    >
                    <option value="配偶者" {{ $form->guarantor3 === '配偶者' ? 'selected' : '' }}>配偶者</option>
                    <option value="親子" {{ $form->guarantor3 === '親子' ? 'selected' : '' }}>親子</option>
                    <option value="兄弟" {{ $form->guarantor3 === '兄弟' ? 'selected' : '' }}>兄弟</option>
                    <option value="親戚" {{ $form->guarantor3 === '親戚' ? 'selected' : '' }}>親戚</option>
                    <option value="友人知人" {{ $form->guarantor3 === '友人知人' ? 'selected' : '' }}>友人知人</option>


                </select>



                </div>


            </div>


            <div class="col-span-full mt-2">
                <label for="advantages" class="block text-sm font-medium text-gray-700 mb-2">
                    所長所見
                </label>
                <textarea
                    id="advantages"
                    name="advantages"
                    rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                    placeholder=""
                >
                {{ $form->advantages }}
            </textarea>
            </div>


            <div class="col-span-full mt-2">
                <label for="how_trading_began" class="block text-sm font-medium text-gray-700 mb-2">
                    取引開始経緯等
                </label>
                <textarea

                    id="how_trading_began"
                    name="how_trading_began"
                    rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                    placeholder=""
                >
                {{ $form->how_trading_began }}
            </textarea>
            </div>


            <div class="col-span-full mt-2">
                <label for="comment_person_in_charge" class="block text-sm font-medium text-gray-700 mb-2">
                    担当所見
                </label>
                <textarea


                    id="comment_person_in_charge"
                    name="comment_person_in_charge"
                    rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                    placeholder=""
                >
                {{ $form->comment_person_in_charge }}
            </textarea>

            </div>

            <div class=" mt-5 h-[3px] bg-orange-300"></div>
            <div class="text-center font-semibold text-gray-600 text-xl relative mt-3">
                <label for="" class="">経理課入力</label>

            </div>
        </body>
        </div>


        <!--ONly holding deer-->



        <div class="bg-blue-100 p-4 rounded-md">
            <div class="w-2/5 mb-4 mt-5">
                <label for="comment_person_in_charge" class="block text-lg px-2 font-md text-gray-800 mb-2">
                    TSR確認
                </label>
                @if(auth()->check() && auth()->user()->corp && auth()->user()->corp->corp_name === '太成HD')
                    {{-- Editable select for Taisei users --}}
                    <select name="tsr_status" id="options" class="w-full p-2 border border-gray-300 rounded-md">
                        <option value="">選択</option>
                        <option value="yes" {{ $form->tsr_status === 'yes' ? 'selected' : '' }}>有</option>
                        <option value="no" {{ $form->tsr_status === 'no' ? 'selected' : '' }}>無し</option>
                    </select>
                @else
                    {{-- Read-only display for other users --}}
                    <div class="w-full p-2 border border-gray-300 rounded-md bg-gray-50">
                        {{ $form->tsr_status === 'yes' ? '有' : ($form->tsr_status === 'no' ? '無し' : '') }}
                    </div>
                    {{-- Hidden input to preserve the value when form is submitted --}}
                    <input type="hidden" name="tsr_status" value="{{ $form->tsr_status }}">
                @endif
            </div>
            {{-- <div class="w-2/5 mb-4 mt-5">
                <label for="comment_person_in_charge" class="block text-lg px-2 font-md text-gray-800 mb-2">
                    TSR確認
                </label>
                <select name="tsr_status" id="options" class="w-full p-2 border border-gray-300 rounded-md">

                    {{ !(auth()->check() && auth()->user()->corp && auth()->user()->corp->corp_name ==='太成HD') ? 'disabled' : '' }}
                    <option value="">選択</option>
                    <option value="yes"{{ $form->tsr_status === 'yes' ? 'selected' : '' }}>有</option>
                    <option value="no"{{ $form->tsr_status === 'no' ? 'selected' : ''}} >無し</option>
                </select>
            </div> --}}

            <!--Additional-field-->

            <div id="additional-fields" class="hidden mt-4 w-2/5">
                <label for="input1" class="block mb-2 mt-2">東証PRM上場企業かどうか</label>

                    @if(auth()->check() && auth()->user()->corp && auth()->user()->corp->corp_name === '太成HD')

                        <select name="prm_status" id="prmStatus" class="w-full p-2 border border-gray-300 rounded-md">
                            <option value="">選択</option>
                            <option value="yes" {{ $form->prm_status ==='yes' ? 'selected' : ''}} >はい</option>
                            <option value="no" {{ $form->prm_status === 'no' ? 'selected' : ''}} >いいえ</option>
                        </select>
                    @else
                    <div class="w-full p-2 border border-gray-300 rounded-md bg-gray-50">
                        {{ $form->prm_status === 'yes' ? 'はい' : ($form->prm_status ==='no' ? 'いいえ' : '') }}
                    </div>

                    <input type="hidden" name="prm_status" value="{{ $form->prm_status }}">
                    @endif

            </div>

             <!--No-field-->

            <div id="no" class="hidden mt-4 w-2/5">

                @if(auth()->check() && auth()->user()->corp && auth()->user()->corp->corp_name === '太成HD')

                        <label for="score" class="block mb-2 mt-2">評点</label>
                        <input type="text" id="score" name="score"
                        value="{{ $form->score }}"
                        class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300">

                        <label for="recent_sales" class="block mb-2 mt-2">直近の売上</label>
                        <input type="text" id="recent_sales"
                        value="{{ $form->recent_sales }}"
                        name="recent_sales" class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300">

                        <label for="profit" class="block mb-2 mt-2">利益</label>
                        <input type="text" id="profit" name="profit"
                        value="{{ $form->profit }}"
                        class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300">

                        <label for="own_value" class="block mb-2 mt-2">自己資本比率</label>
                        <input type="text" id="own_value"
                        value="{{ $form->own_value }}"
                        name="own_value" class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300">

                @else

                    <label for="score" class="block mb-2 mt-2">評点</label>
                    <div class="w-full p-2 border border-gray-300 rounded-md bg-gray-50">{{ $form->score }}</div>
                    <input type="hidden" name="score" value="{{ $form->score }}">

                    <label for="recent_sales" class="block mb-2 mt-2">直近の売上</label>
                    <div class="w-full p-2 border border-gray-300 rounded-md bg-gray-50">{{ $form->recent_sales }}</div>
                    <input type="hidden" name="recent_sales" value="{{ $form->recent_sales }}">

                    <label for="profit" class="block mb-2 mt-2">利益</label>
                    <div class="w-full p-2 border border-gray-300 rounded-md bg-gray-50">{{ $form->profit }}</div>
                    <input type="hidden" name="profit" value={{ $form->profit }}>

                    <label for="own_value" class="block mb-2 mt-2">自己資本比率</label>
                    <div class="w-full p-2 border border-gray-300 rounded-md bg-gray-50">{{ $form->own_value }}</div>
                    <input type="hidden" name="own_value" value="{{ $form->own_value }}">

                @endif



            </div>

            <!--tsr No Fierld-->

            <div id="tsr-no" class="hidden mt-4 w-2/5">

                @if(auth()->check() && auth()->user()->corp && auth()->user()->corp->corp_name ==='太成HD')

                        <div class="flex gap-4">
                            <div>
                                <input type="radio" id="corporate" name="entity_type" value="corporate" {{ $form->entity_type === 'corporate' ? 'checked' : '' }}>
                                <label for="corporate" class="ml-2">法人</label>
                            </div>
                            <div>
                                <input type="radio" id="individual" name="entity_type" value="individual" {{ $form->entity_type ==='individual' ? 'checked' : '' }}>
                                <label for="individual" class="ml-2">個人</label>
                            </div>
                        </div>



                            <!---hidden msg based on radio-->

                            <div id="corporate-text" class="hidden mt-3 text-orange-400">
                                商業登記簿、会社所在地、代表者自宅の土地登記簿を取得して下さい
                            </div>
                            <div id="individual-text" class="hidden mt-3 text-orange-400">
                                会社所在地の土地登記簿を取得して下さい
                            </div>


                            <!----->


                            <!--sonsoltuud--->


                            <label for="guarantor_type" class="block mb-2 mt-2">連帯保証人</label>
                            <select name="guarantor_type" id="" class="w-full p-2 border border-gray-300 rounded-md">
                                <option value="">選択</option>
                                <option value="1" {{ $form->guarantor_type === '1' ? 'selected' : '' }}>社長のみ又は同一生計家族</option>
                                <option value="2" {{ $form->guarantor_type === '2' ? 'selected' : ''}} >社長＋別成形親族または第三者</option>
                            </select>

                            <label for="home_ownership" class="block mb-2 mt-2">自宅土地の所有状況</label>
                            <select name="home_ownership" id="home_ownership" class="w-full p-2 border border-gray-300 rounded-md">
                                <option value="">選択</option>
                                <option value="1" {{ $form->home_ownership === '1' ? 'selected' : '' }}>個人所有</option>
                                <option value="2" {{ $form->home_ownership === '2' ? 'selected' : '' }} >賃借</option>
                            </select>

                            <label for="company_ownership" class="block mb-2 mt-2">会社土地の所有状況</label>
                            <select name="company_ownership" id="company_ownership" class="w-full p-2 border border-gray-300 rounded-md">
                                <option value="">選択</option>
                                <option value="1" {{ $form->company_ownership === '1' ? 'selected' : ''}}>個人所有または会社所有</option>
                                <option value="2" {{ $form->company_ownership ==='2' ? 'selected' : ''}}>賃借</option>
                            </select>

                @else
                            <div class="flex gap-4">
                                <div class="w-full p-2 border border-gray-300 rounded-md bg-gray-50">
                                    {{ $form->entity_type === 'corporate' ? '法人' : ($form->entity_type === 'individual' ? '個人' : '') }}
                                    {{-- {{ $form->entity_type === '1' ? 'checked' : ($form->entity_type === '2' ? 'checked' : '') }} --}}

                                </div>

                            </div>
                            <input type="hidden" name="entity_type" value="{{ $form->entity_type }}">

                            @if($form->entity_type ==='corporate')
                                <div class="mt-3 text-orange-400">
                                    商業登記簿、会社所在地、代表者自宅の土地登記簿を取得して下さい
                                </div>
                           @elseif($form->entity_type ==='individual')
                                <div class="mt-3 text-orange-400">
                                    会社所在地の土地登記簿を取得して下さい
                                </div>
                            @endif


                            <label for="guarantor_type" class="block mb-2 mt-2">連帯保証人</label>
                            <div class="w-full p-2 border border-gray-300 rounded-md bg-gray-50">
                                {{ $form->guarantor_type === '1' ? '社長のみ又は同一生計家族' : ($form->guarantor_type ==='2' ? '社長＋別成形親族または第三者' : '') }}

                            </div>
                            <input type="hidden" name="guarantor_type" value="{{ $form->guarantor_type }}">

                            <label for="home_ownership" class="block mb-2 mt-2">自宅土地の所有状況</label>
                            <div class="w-full p-2 border border-gray-300 rounded-md bg-gray-50">
                                {{ $form->home_ownership === '1' ? '個人所有' : ($form->home_ownership ==='2' ? '賃借' : '') }}

                            </div>
                            <input type="hidden" name="home_ownership" value="{{ $form->home_ownership }}">

                            <label for="company_ownership" class="block mb-2 mt-2">会社土地の所有状況</label>
                            <div class="w-full p-2 border border-gray-300 rounded-md bg-gray-50">
                                {{ $form->company_ownership === '1' ? '個人所有または会社所有' : ($form->company_ownership ==='2' ? '賃借' : '') }}

                            </div>
                            <input type="hidden" name="company_ownership" value="{{ $form->company_ownership }}">

                       @endif






            </div>




                <!--Result button Final-->
            <div class="flex items-center space-x-4 mt-5">

                <div>
                    <button class="px-2 py-2 bg-blue-500 hover:bg-blue-600 rounded-2xl mt-5" type="">
                        限度額判定
                    </button>
                </div>

                <div>
                    <input type="text mt-5"
                        id="result-input"

                        name="result_input"
                          class="border border-gray-500 px-4 py-2 rounded focus:outline-none focus:ring focus:ring-blue-200 focus:border-blue-500"

        >

                </div>

            </div>
            <div>
                <button class="px-2 py-2 bg-green-500 hover:bg-green-600 text-gray-700 rounded-2xl mt-5 hover:text-white font-semibold" type="submit">
                   保存
                </button>
            </div>
        </div>










        </form>



    </div>

    {{-- <script>

document.addEventListener('DOMContentLoaded', function(){

    const isTaiseiUser={{ auth()->check() && auth()->user()->corp && auth()->user()->corp->corp_name ==='太成HD' ? 'true' : 'false' }};

    const tsrStatus=document.querySelector('[name="tsr_status"]').value;
    const prmStatus=document.querySelector('[name="prm_status"]').value;
    const entityType=document.querySelector('input[name="entity_type"]:checked')?.value;


    // Show/hide sections based on initial TSR status

    // Show/hide initial sections based on values
    if (document.querySelector('[name="tsr_status"]').value === 'no') {
        document.getElementById('tsr-no').classList.remove('hidden');
    }

    // Only add event listeners for Taisei users
    if (isTaiseiUser) {
        // Entity type radio buttons
        document.querySelectorAll('input[name="entity_type"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const corporateText = document.getElementById('corporate-text');
                const individualText = document.getElementById('individual-text');

                if (this.value === '1') {
                    corporateText.classList.remove('hidden');
                    individualText.classList.add('hidden');
                } else if (this.value === '2') {
                    corporateText.classList.add('hidden');
                    individualText.classList.remove('hidden');
                }
            });
        });
    }

    if(tsrStatus === 'yes'){
        document.getElementById('additional-fields').classList.remove('hidden');
        if(prmStatus ==='no'){
            document.getElementById('no').classList.remove('hidden');

        }
    }else if (tsrStatus === 'no'){
        document.getElementById('tsr-no').classList.remove('hidden');
    }

    if(entityType === '1'){
        document.getElementById('corporate-text').classList.remove('hidden');
    }else if (entityType ==='2'){
        document.getElementById('individual-text').classList.remove('hidden');
    }

});



// deesh shine code

function toggleInput() {
    const selectedValue = document.querySelector('input[name="3rdPerson"]:checked')?.value;
    const inputContainer = document.getElementById('textInputContainer');

    if(selectedValue === '1') {
        inputContainer.classList.remove('hidden');  // Shows input when "有" is selected
    } else {
        inputContainer.classList.add('hidden');     // Hides input when "無" is selected
    }
}


document.getElementById('options').addEventListener('change', function (){
    const additionalFields=document.getElementById('additional-fields');
    const noDiv=document.getElementById('no');

    const tsrNo=document.getElementById('tsr-no');

        if(this.value === 'yes'){
            additionalFields.classList.remove('hidden');
            noDiv.classList.add('hidden');
            tsrNo.classList.add('hidden');
        }else{
            additionalFields.classList.add('hidden');
            noDiv.classList.add('hidden');
            tsrNo.classList.remove('hidden');
        }
});

//secondd dropdown
document.querySelector('#additional-fields select').addEventListener('change', function(){


    const noDiv=document.getElementById('no');

    //new here
    const resultInput=document.getElementById('result-input');
    const DecidedLimitAmountInput=document.getElementById('decided_limit_amount');

    if(this.value=== 'no'){
        noDiv.classList.remove('hidden');
        resultInput.value='';//empthy
    }else if(this.value ==='yes'){
        noDiv.classList.add('hidden');

        //copy
        if(DecidedLimitAmountInput){
            resultInput.value=DecidedLimitAmountInput.value + '万円';
        }
    }else{
        noDiv.classList.add('hidden');
        resultInput.value='';
    }
});



//radio event listener
document.querySelectorAll('input[name="entity_type"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const corporateText = document.getElementById('corporate-text');
        const individualText = document.getElementById('individual-text');

        if (this.value === '1') {
            corporateText.classList.remove('hidden');
            individualText.classList.add('hidden');
        } else if (this.value === '2') {
            corporateText.classList.add('hidden');
            individualText.classList.remove('hidden');
        }
    });
});






    </script> --}}

    <script>
      document.addEventListener('DOMContentLoaded', function(){
    const isTaiseiUser = {{ auth()->check() && auth()->user()->corp && auth()->user()->corp->corp_name === '太成HD' ? 'true' : 'false' }};

    // Initialize form state based on saved values
    const tsrStatus = document.querySelector('[name="tsr_status"]').value;
    const prmStatus = document.querySelector('[name="prm_status"]').value;
    const entityType = document.querySelector('input[name="entity_type"]:checked')?.value;

    // Show/hide initial sections based on values
    if (document.querySelector('[name="tsr_status"]').value === 'no') {
        document.getElementById('tsr-no').classList.remove('hidden');
    }

    // Initial visibility setup
    if(tsrStatus === 'yes'){
        document.getElementById('additional-fields').classList.remove('hidden');
        if(prmStatus === 'no'){
            document.getElementById('no').classList.remove('hidden');
        }
    } else if (tsrStatus === 'no'){
        document.getElementById('tsr-no').classList.remove('hidden');
    }

    if(entityType === '1'){
        document.getElementById('corporate-text').classList.remove('hidden');
    } else if (entityType === '2'){
        document.getElementById('individual-text').classList.remove('hidden');
    }

    // TSR Status Change Handler
    document.getElementById('options').addEventListener('change', function (){
        const additionalFields = document.getElementById('additional-fields');
        const noDiv = document.getElementById('no');
        const tsrNo = document.getElementById('tsr-no');

        if(this.value === 'yes'){
            additionalFields.classList.remove('hidden');
            noDiv.classList.add('hidden');
            tsrNo.classList.add('hidden');
        } else {
            additionalFields.classList.add('hidden');
            noDiv.classList.add('hidden');
            tsrNo.classList.remove('hidden');
        }
    });

    // PRM Status Change Handler
    document.querySelector('#additional-fields select').addEventListener('change', function(){
        const noDiv = document.getElementById('no');
        const resultInput = document.getElementById('result-input');
        const DecidedLimitAmountInput = document.getElementById('decided_limit_amount');

        if(this.value === 'no'){
            noDiv.classList.remove('hidden');
            resultInput.value = '';
        } else if(this.value === 'yes'){
            noDiv.classList.add('hidden');
            if(DecidedLimitAmountInput){
                resultInput.value = DecidedLimitAmountInput.value + '万円';
            }
        } else {
            noDiv.classList.add('hidden');
            resultInput.value = '';
        }
    });

    // Entity Type Change Handler
    document.querySelectorAll('input[name="entity_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const corporateText = document.getElementById('corporate-text');
            const individualText = document.getElementById('individual-text');

            if (this.value === 'corporate') {
                corporateText.classList.remove('hidden');
                individualText.classList.add('hidden');
            } else if (this.value === 'individual') {
                corporateText.classList.add('hidden');
                individualText.classList.remove('hidden');
            }
        });
    });

    // Limit Amount Calculation Logic
    const calculateLimitAmount = () => {
        const tsrStatus = document.querySelector('[name="tsr_status"]').value;
        const prmStatus = document.querySelector('[name="prm_status"]').value;
        const score = parseFloat(document.getElementById('score')?.value || '0');
        const ownValue = parseFloat(document.getElementById('own_value')?.value || '0');
        const recentSales = parseFloat(document.getElementById('recent_sales')?.value || '0');
        const profit = parseFloat(document.getElementById('profit')?.value || '0');
        const entityType = document.querySelector('input[name="entity_type"]:checked')?.value;
        const guarantorType = document.querySelector('[name="guarantor_type"]')?.value;
        const homeOwnership = document.querySelector('[name="home_ownership"]')?.value;
        const companyOwnership = document.querySelector('[name="company_ownership"]')?.value;

        let limitAmount = 0;

        // TSR Yes Cases
        if (tsrStatus === 'yes') {
            if (prmStatus === 'yes') {
                limitAmount = 500;
            } else {
                // Case 1
                if (score < 49 && ownValue <= 10) {
                    limitAmount = 160;
                }
                // Case 2
                else if (score >= 49 && score <= 64 && ownValue > 10) {
                    limitAmount = 200;
                }
                // Case 3
                else if (score > 64 && ownValue > 15) {
                    limitAmount = 300;
                }

                // Sales and profit adjustments
                if (recentSales > 1000 && profit > 50) {
                    limitAmount += 50;
                }
            }
        }
        // TSR No Cases
        else if (tsrStatus === 'no') {
            if (entityType === 'corporate') {
                limitAmount = 100;
                if (guarantorType === '2') {
                    limitAmount += 30;
                }
            } else if (entityType === 'individual') {
                limitAmount = 80;
            }

            // Property ownership adjustments
            if (homeOwnership === '1' && companyOwnership === '1') {
                limitAmount += 40;
            } else if (homeOwnership === '1' || companyOwnership === '1') {
                limitAmount += 20;
            }
        }

        return limitAmount;
    };

    // Add calculation button event listener
    const calculateButton = document.querySelector('.bg-blue-500');
    const resultInput = document.getElementById('result-input');

    calculateButton.addEventListener('click', function(e) {
        e.preventDefault();
        const amount = calculateLimitAmount();
        resultInput.value = amount > 0 ? `${amount}万円` : '';
    });
});
    </script>



</x-app-layout>



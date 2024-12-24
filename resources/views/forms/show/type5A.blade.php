
<x-app-layout>

    <div class="mt-5 mb-5 flex justify-center">



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>問い合わせ</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<div class="w-full max-w-4xl bg-white shadow-lg rounded-xl p-6">



 <div>

            @csrf

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
                    readonly
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

                <div class="grid md:grid-cols-2 gap-6">



                    <div class="mb-2">
                        <label for="customer_code" class="block text-sm font-medium text-gray-700 mb-2 mt-7">
                            顧客コード
                        </label>
                        <input
                        readonly
                        value="{{ $form->customer_code }}"
                            id="customer_code"
                            name="customer_code"
                            value=""
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >


                        </input>
                    </div>

                    <div>
                        <label for="icm_date" class="block text-sm font-medium text-gray-700 mb-2 mt-7">
                            IC-M 登録日
                        </label>
                        <input
                        readonly
                        value="{{ $form->icm_date }}"
                            type="date"
                            id="icm_date"
                            name="icm_date"
                            value=""
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >


                        </input>
                    </div>

                    <div class="">
                        <label for="client_name" class="block text-sm font-medium text-gray-700 mb-2 mt-2">
                            取引先名（フリガナ）
                        </label>
                        <input
                        readonly
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

                        readonly
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

                        readonly
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

                            readonly
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
                        readonly
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
                        readonly
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

                        readonly
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
                        readonly
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

                        readonly
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
                        readonly
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

                        readonly
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
                        readonly
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
                        <option value=""disabled>リストから選択してください。</option>
                        <option disabled value="株式会社" {{ $form->company_type === '株式会社' ? 'selected' : '' }}>株式会社</option>
                        <option disabled value="有限会社"{{ $form->company_type === '有限会社' ? 'selected' : '' }}>有限会社</option>
                        <option disabled value="合同会社"{{ $form->company_type === '合同会社' ? 'selected' : '' }}>合同会社</option>
                        <option disabled value="合弁会社"{{ $form->company_type === '合弁会社' ? 'selected' : '' }}>合弁会社</option>
                        <option disabled value="財団法人"{{ $form->company_type === '財団法人' ? 'selected' : '' }}>財団法人</option>
                        <option disabled value="個人"{{ $form->company_type === '個人' ? 'selected' : '' }}>個人</option>
                        <option disabled value="その他"{{ $form->company_type === 'その他' ? 'selected' : '' }}>その他</option>


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
                        <option value="加入" {{ $form->union === "加入" ? 'selected' : '' }} disabled>加入</option>
                        <option value="未加入" {{ $form->union === '未加入' ? 'selected' : '' }} disabled>未加入</option>


                        </select>
                    </div>
                    <div class="">
                        <label for="male_worker" class="block text-sm font-medium text-gray-700 mb-2 mt-2">
                            企業員（男）

                        </label>
                        <input
                        readonly
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
                        readonly
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
                        readonly
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
                                    <input  disabled type="radio" name="baritsaa" value="有" class="form-radio text-blue-500" {{ $form->baritsaa === '有' ? 'checked' : '' }}>
                                    <span>有</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input disabled type="radio" name="baritsaa" value="無" class="form-radio text-blue-500" {{ $form->baritsaa === '無' ? 'checked' : '' }}>
                                    <span>無</span>
                                </label>
                            </div>
                        </div>
                        <div class="mt-4 mb-2">
                            <label for="" class="block text-gray-600 font-medium mb-2">担保設定状況</label>
                            <div class="flex items-center space-x-4">
                                <label class="flex items-center space-x-2">
                                    <input disabled type="radio" name="baritsaa_status" value="銀行" class="form-radio text-blue-500" {{ $form->baritsaa_status === '銀行' ? 'checked' : '' }}>
                                    <span>銀行</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input disabled type="radio" name="baritsaa_status" value="ノンバンク" class="form-radio text-blue-500" {{ $form->baritsaa_status === 'ノンバンク' ? 'checked' : '' }}>
                                    <span>ノンバンク</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input disabled type="radio" name="baritsaa_status" value="他" class="form-radio text-blue-500" {{$form->baritsaa_status === '他' ? 'checked' : '' }}>
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
                                    <input disabled type="radio" name="president_home" value="賃借" class="form-radio text-blue-500" {{ $form->president_home === '賃借' ? 'checked' : '' }}>
                                    <span>賃借</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input disabled type="radio" name="president_home" value="持ち家" class="form-radio text-blue-500" {{ $form->president_home === '持ち家' ? 'checked' : '' }}>
                                    <span>持ち家</span>
                                </label>
                            </div>
                        </div>

                        <div class="mt-4 mb-2">
                            <label for="" class="block text-gray-600 font-medium mb-2">担保設定</label>
                            <div class="flex items-center space-x-2">
                                <label class="flex items-center space-x-2">
                                    <input  disabled type="radio" name="president_baritsaa" value="有" class="form-radio text-blue-500" {{ $form->president_baritsaa === '有' ? 'checked' : '' }}>
                                    <span>有</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input  disabled type="radio" name="president_baritsaa" value="無" class="form-radio text-blue-500" {{ $form->president_baritsaa === '無' ? 'checked' : '' }}>
                                    <span>無</span>
                                </label>
                            </div>
                        </div>

                        <div class="mt-4 mb-2">
                            <label for="" class="block text-gray-600 font-medium mb-2">担保設定状況</label>
                            <div class="">
                                <label class="flex items-center space-x-2">
                                    <input disabled type="radio" name="president_baritsaa_status" value="住宅ローン" class="form-radio text-blue-500" {{ $form->president_baritsaa_status === '住宅ローン' ? 'checked' : '' }}>
                                    <span>住宅ローン</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input disabled type="radio" name="president_baritsaa_status" value="銀行" class="form-radio text-blue-500" {{ $form->president_baritsaa_status === '銀行' ? 'checked' : '' }}>
                                    <span>銀行</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input disabled type="radio" name="president_baritsaa_status" value="ノンバンク" class="form-radio text-blue-500" {{ $form->president_baritsaa_status === 'ノンバンク' ? 'checked' : '' }}>
                                    <span>ノンバンク</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input  disabled type="radio" name="president_baritsaa_status" value="他" class="form-radio text-blue-500" {{$form->president_baritsaa_status === '他' ? 'checked' : '' }}>
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
                        readonly

                            id="expire_date"
                            name="expire_date"
                            value="{{ $form->expire_date }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >


                        </input>
                    </div>

                    <div>
                        <label for="office" class="block text-sm font-medium text-gray-700 mb-2 mt-7">
                          支払日
                        </label>
                        <select

                        disabled
                        readonly
                            id="payment_day"
                            name="payment_day"

                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >

                        <option disabled value="当月" {{ $form->payment_day === '当月' ? 'selected' : '' }}>当月</option>
                        <option disabled value="翌月" {{ $form->payment_day === '翌月' ? 'selected' : '' }}>翌月</option>


                        </select>
                    </div>
                    <div>
                        <label for="office" class="block text-sm font-medium text-gray-700 mb-2 mt-7">
                          日
                        </label>
                        <input

                            readonly
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
                    readonly

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
                        disabled
                            id="collection_method"
                            name="collection_method"
                            value=""
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >

                        <option  disabled value="振込" {{ $form->collection_method === '振込' ? 'selected' : '' }}>振込</option>
                        <option  disabled value="現金" {{ $form->collection_method === '現金' ? 'selected' : '' }}>現金</option>



                        </select>

                    </div>

                    <div>
                        <label for="cr_persent" class="block text-sm font-medium text-gray-700 mb-2 mt-7">
                            ＣＲ率
                        </label>
                        <input

                            readonly
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
                            readonly
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

                        readonly
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
                                <input type="radio" name="special" value="有" class="form-radio text-blue-500" {{ $form->special === '有' ? 'checked' : '' }} disabled>
                                <span>有</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="special" value="無" class="form-radio text-blue-500" {{ $form->special === '無' ? 'checked' : '' }} disabled>
                                <span>無</span>
                            </label>
                        </div>
                    </div>

                    <div class="mt-4 mb-2">
                        <label for="" class="block text-gray-600 font-medium mb-2">取引契約書 取得（予定）日</label>
                        <div class="flex items-center space-x-4">
                            <label class="flex items-center space-x-2">
                                <input

                                readonly
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

                    readonly
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
                            readonly
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
                            readonly
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
                            <input disabled type="radio" name="3rdPerson" value="有" class="form-radio text-blue-500" onchange="toggleInput()" {{ $form['3rdPerson'] === '有' ? 'checked' : '' }}>
                            <span>有</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input disabled type="radio" name="3rdPerson" value="無" class="form-radio text-blue-500" onchange="toggleInput()" {{ $form['3rdPerson'] === '無' ? 'checked' : '' }}>
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
                            readonly
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
                    readonly
                    disabled
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
                        disabled

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
                        disabled

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
                        disabled

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
                readonly
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

                    readonly
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

                    readonly

                    id="comment_person_in_charge"
                    name="comment_person_in_charge"
                    rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                    placeholder=""
                >
                {{ $form->comment_person_in_charge }}
            </textarea>
            </div>





        </form>
    </div>

    <script>



function toggleInput() {
    const selectedValue = document.querySelector('input[name="3rdPerson"]:checked')?.value;
    const inputContainer = document.getElementById('textInputContainer');

    if(selectedValue === '1') {
        inputContainer.classList.remove('hidden');  // Shows input when "有" is selected
    } else {
        inputContainer.classList.add('hidden');     // Hides input when "無" is selected
    }
}




    </script>
</body>

</div>
</x-app-layout>



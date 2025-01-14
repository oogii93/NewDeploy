
<x-app-layout>

    <div class="mt-5 mb-5 flex justify-center">



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>問い合わせ</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<div class="w-full max-w-4xl bg-white shadow-lg rounded-xl p-6">



    <form action="{{ route('forms.store', '5A') }}" method="POST">

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
                        value="{{ Auth::user()->corp->corp_name ?? '' }}"
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
                        value="{{ Auth::user()->office->office_name ?? '' }}"
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
                        value="{{ Auth::user()->name ?? '' }}"
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
                        >


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
                            value=""
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
                            value=""
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
                            value=""
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
                        <option value="株式会社">株式会社</option>
                        <option value="有限会社">有限会社</option>
                        <option value="合同会社">合同会社</option>
                        <option value="合弁会社">合弁会社</option>
                        <option value="財団法人">財団法人</option>
                        <option value="個人">個人</option>
                        <option value="その他">その他</option>


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
                        <option value="">選択</option>
                        <option value="加入">加入</option>
                        <option value="未加入">未加入</option>


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
                            value=""
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
                            value=""
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
                            value=""
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
                                <input type="radio" name="shop" value="賃借" class="form-radio text-blue-500">
                                <span>賃借</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="shop" value="持ち家" class="form-radio text-blue-500">
                                <span>持ち家</span>
                            </label>
                        </div>
                    </div>

                        <div class="mt-4 mb-2">
                            <label for="" class="block text-gray-600 font-medium mb-2">担保設定</label>
                            <div class="flex items-center space-x-4">
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="baritsaa" value="有" class="form-radio text-blue-500">
                                    <span>有</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="baritsaa" value="無" class="form-radio text-blue-500">
                                    <span>無</span>
                                </label>
                            </div>
                        </div>
                        <div class="mt-4 mb-2">
                            <label for="" class="block text-gray-600 font-medium mb-2">担保設定状況</label>
                            <div class="flex items-center space-x-4">
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="baritsaa_status" value="銀行" class="form-radio text-blue-500">
                                    <span>銀行</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="baritsaa_status" value="ノンバンク" class="form-radio text-blue-500">
                                    <span>ノンバンク</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="baritsaa_status" value="他" class="form-radio text-blue-500">
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
                                    <input type="radio" name="president_home" value="賃借" class="form-radio text-blue-500">
                                    <span>賃借</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="president_home" value="持ち家" class="form-radio text-blue-500">
                                    <span>持ち家</span>
                                </label>
                            </div>
                        </div>

                        <div class="mt-4 mb-2">
                            <label for="" class="block text-gray-600 font-medium mb-2">担保設定</label>
                            <div class="flex items-center space-x-2">
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="president_baritsaa" value="有" class="form-radio text-blue-500">
                                    <span>有</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="president_baritsaa" value="無" class="form-radio text-blue-500">
                                    <span>無</span>
                                </label>
                            </div>
                        </div>

                        <div class="mt-4 mb-2">
                            <label for="" class="block text-gray-600 font-medium mb-2">担保設定状況</label>
                            <div class="">
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="president_baritsaa_status" value="住宅ローン" class="form-radio text-blue-500">
                                    <span>住宅ローン</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="president_baritsaa_status" value="銀行" class="form-radio text-blue-500">
                                    <span>銀行</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="president_baritsaa_status" value="ノンバンク" class="form-radio text-blue-500">
                                    <span>ノンバンク</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="president_baritsaa_status" value="他" class="form-radio text-blue-500">
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
                            value=""
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >


                        </input>
                        <span class="text-orange-400 mt-1 text-sm">月末締めの場合は末と入力してください。</span>
                    </div>

                    <div>
                        <label for="office" class="block text-sm font-medium text-gray-700 mb-2 mt-7">
                            支払月
                        </label>
                        <select

                            id="payment_day"
                            name="payment_day"
                            value=""
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >
                        <option value="">月選択</option>
                        <option value="当月">当月</option>
                        <option value="翌月">翌月</option>


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
                            value=""
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >



                        </input>
                        <span class="text-orange-400 mt-1 text-sm">月末支払いは末と記入してください。30日払いではない</span>
                    </div>


                </div>

                <div class="col-span-full mb-2">

                    <label for="office" class="block text-sm font-medium text-gray-700 mb-2 mt-2">
                       その他
                    </label>
                    <input
                        id="other_payment"
                        name="other_payment"
                        value=""
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
                        <option value="">選択</option>
                        <option value="振込">振込</option>
                        <option value="現金">現金</option>



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
                            value=""
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >



                        </い>
                    </div>
                    <div>
                        <label for="office" class="block text-sm font-medium text-gray-700 mb-2 mt-2">
                            手形 (手形サイト)
                        </label>
                        <input
                            type="number"
                            id="bill"
                            name="bill"
                            value=""
                            placeholder="日 (締日起算)"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >

                        </input>
                        <span class="text-orange-400 mt-1 text-sm">締日から手形の支払い日までの期間を記入してください。</span>
                    </div>

                    <div >

                        <label for="office" class="block text-sm font-medium text-gray-700 mb-2 mt-2">
                           その他
                        </label>
                        <input
                            id="collection_other"
                            name="collection_other"
                            value=""
                        placeholder=""

                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >


                        </input>
                    </div>


                    <div class="mt-4 mb-2">
                        <label for="" class="block text-gray-600 font-medium mb-2">専用伝票</label>
                        <div class="flex items-center space-x-4">
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="special" value="有" class="form-radio text-blue-500">
                                <span>有</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="special" value="無" class="form-radio text-blue-500">
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
                                value=""
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
                    ></textarea>
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

                            class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                            万円
                        </div>
                    </div>


                    </input>
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

                            class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                            万円
                        </div>
                    </div>
                    <span class="text-orange-400 mt-1 text-sm">審査の上売買契約書の第12条の連帯保証の金額欄に記入しますので必ず記入してください。</span>

                </div>


                <div class="mb-2">
                    <label for="" class="block text-gray-600 font-medium mb-2">連帯保証人(第三者)</label>
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="3rdPerson" value="有" class="form-radio text-blue-500" onchange="toggleInput()">
                            <span>有</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="3rdPerson" value="無" class="form-radio text-blue-500" onchange="toggleInput()">
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

                            class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        >
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                            万円
                        </div>
                    </div>
                    <span class="text-orange-400 mt-1 text-sm">←本社記入</span>

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
                    <option value="">選択</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>


                </select>


                </div>
                <div class="mt-2">

                    <label for="guarantor1" class="block text-sm font-medium text-gray-700 mb-2">
                        代表者と連帯保証人の関係
                    </label>
                    <select
                        id="guarantor1"
                        name="guarantor1"
                        value=""

                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                    >
                    <option value="">第一連帯保証人</option>
                    <option value="本人">本人</option>
                    <option value="親子">親子</option>
                    <option value="親戚">親戚</option>
                    <option value="配偶者">配偶者</option>
                    <option value="兄弟">兄弟</option>
                    <option value="友人知人">友人知人</option>



                </select>
                    <select
                        id="guarantor2"
                        name="guarantor2"
                        value=""

                        class="mt-3 mb-3 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                    >
                    <option value="">第二連帯保証人</option>
                    <option value="配偶者">配偶者</option>
                    <option value="親子">親子</option>
                    <option value="兄弟">兄弟</option>
                    <option value="親戚">親戚</option>
                    <option value="友人知人">友人知人</option>


                </select>
                    <select
                        id="guarantor3"
                        name="guarantor3"
                        value=""

                        class="mt-3 mb-3 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                    >
                    <option value="">第三連帯保証人</option>
                    <option value="配偶者">配偶者</option>
                    <option value="親子">親子</option>
                    <option value="兄弟">兄弟</option>
                    <option value="親戚">親戚</option>
                    <option value="友人知人">友人知人</option>


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
            </textarea>
            </div>

            <div class="space-y-2">
                <label for="boss_id" class="block text-sm font-medium text-gray-700">上司を選択</label>
                <select name="boss_id" id="boss_id"
                    class="block w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    required>
                    <option value="">選択して下さい。</option>
                    @foreach ($bosses as $boss)
                        <option value="{{ $boss->id }}">{{ $boss->name }}</option>
                    @endforeach
                </select>
            </div>




            <div class="text-center mt-8 ">
                <button
                    type="submit"
                    class="flex justify-start px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300"
                >
                  申請する
                </button>
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



<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('application_type_5_a', function (Blueprint $table) {
            $table->id();
            $table->string('corp')->nullable();
            $table->string('office')->nullable();
            $table->string('name')->nullable();
            $table->date('applied_date')->nullable();
            $table->string('customer_code')->nullable();
            $table->date('icm_date')->nullable();
            $table->string('client_name_furigana')->nullable();
            $table->string('client_name')->nullable();
            $table->string('president_name')->nullable();
            $table->date('president_birthdate')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('address')->nullable();
            $table->string('tel_number')->nullable();
            $table->string('fax_number')->nullable();
            $table->text('office_description')->nullable();
            $table->string('main_supplier')->nullable();
            $table->string('annual_turnover')->nullable();
            $table->string('capital')->nullable();
            $table->enum('company_type',[
                '株式会社',
                '有限会社',
                '合同会社',
                '合弁会社',
                '財団法人',
                '個人',
                'その他'
            ])->nullable();

            $table->enum('union',[
                '加入',
                '未加入'
            ])->nullable();
            $table->string('male_worker')->nullable();
            $table->string('female_worker')->nullable();
            $table->string('registration_number')->nullable();
            $table->enum('shop',['賃借', '持ち家'])->nullable();
            $table->enum('baritsaa',['有','無'])->nullable();
            $table->enum('baritsaa_status',['銀行','ノンバンク','他'])->nullable();
            $table->enum('president_home', ['賃借', '持ち家'])->nullable();
            $table->enum('president_baritsaa', ['有', '無'])->nullable();
            $table->enum('president_baritsaa_status', ['住宅ローン','銀行', 'ノンバンク', '他'])->nullable();
            $table->date('expire_date')->nullable();
            $table->enum('payment_day',['当月','翌月'])->nullable();
            $table->string('payment_date')->nullable();
            $table->string('other_payment')->nullable();
            $table->enum('collection_method', [ '振込', '現金'])->nullable();
            $table->string('cr_persent')->nullable();
            $table->string('bill')->nullable();
            $table->string('collection_other')->nullable();
            $table->enum('special',['有','無'])->nullable();
            $table->date('transaction_aggreement_date')->nullable();
            $table->text('remarks')->nullable();
            $table->string('expected_sales')->nullable();
            $table->string('limit_amount')->nullable();
            $table->enum('3rdPerson', ['有', '無'])->nullable();
            $table->string('3rd_person_text')->nullable();
            $table->string('decided_limit_amount')->nullable();
            $table->enum('trust_rate',['A', 'B', 'C', 'D'])->nullable();
            $table->enum('guarantor1',['本人','親子','親戚','配偶者','兄弟','友人知人'])->nullable();
            $table->enum('guarantor2',['配偶者','親子','兄弟','親戚','友人知人'])->nullable();
            $table->enum('guarantor3',['配偶者','親子','兄弟','親戚','友人知人'])->nullable();
            $table->text('advantages')->nullable();
            $table->text('how_trading_began')->nullable();
            $table->text('comment_person_in_charge')->nullable();





            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_type_5_a');
    }
};

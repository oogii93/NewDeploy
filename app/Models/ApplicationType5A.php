<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationType5A extends Model
{
    use HasFactory;
    protected $table = 'application_type_5_a'; // Correct table name
    protected $guarded=[];

    public function application()
    {
        return $this->morphOne(Application::class, 'applicationable');
    }


    // protected $fillable = [
    //     'corp', 'office', 'name', 'applied_date', 'client_name_furigana',
    //     'client_name', 'president_name', 'president_birthdate', 'postal_code',
    //     'address', 'tel_number', 'fax_number', 'office_description',
    //     'main_supplier', 'annual_turnover', 'capital', 'company_type',
    //     'union', 'male_worker', 'female_worker', 'registration_number',
    //     'baritsaa', 'baritsaa_status', 'president_home', 'president_baritsaa',
    //     'president_baritsaa_status', 'expire_date', 'payment_day',
    //     'payment_date', 'other_payment', 'collection_method', 'cr_persent',
    //     'bill', 'collection_other', 'special', 'transaction_aggreement_date',
    //     'remarks', 'expected_sales', 'limit_amount', '3rdPerson',
    //     '3rd_person_text', 'decided_limit_amount', 'trust_rate',
    //     'guarantor1', 'guarantor2', 'guarantor3', 'advantages',
    //     'how_trading_began', 'comment_person_in_charge', 'tsr_status',
    //     'prm_status', 'score', 'recent_sales', 'profit', 'own_value',
    //     'guarantor_type', 'home_ownership', 'company_ownership', 'result-input'
    // ];


}

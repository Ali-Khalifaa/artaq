<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute کو قبول کرنا ضروری ہے۔',
    'accepted_if' => ':attribute کو قبول کرنا ضروری ہے جب :other :value ہو۔',
    'active_url' => ':attribute ایک درست URL ہونا چاہئے۔',
    'after' => ':attribute کی تاریخ :date کے بعد کی ہونی چاہئے۔',
    'after_or_equal' => ':attribute کی تاریخ :date کے بعد یا اس کے برابر ہونی چاہئے۔',
    'alpha' => ':attribute میں صرف حروف ہونے چاہئیں۔',
    'alpha_dash' => ':attribute میں صرف حروف، نمبر، ڈیش اور انڈر سکور ہونے چاہئیں۔',
    'alpha_num' => ':attribute میں صرف حروف اور نمبر ہونے چاہئیں۔',
    'array' => ':attribute ایک ارے ہونا چاہئے۔',
    'ascii' => ':attribute میں صرف سنگل بائٹ حروف اور علامات ہونے چاہئیں۔',
    'before' => ':attribute کی تاریخ :date سے پہلے کی ہونی چاہئے۔',
    'before_or_equal' => ':attribute کی تاریخ :date سے پہلے یا اس کے برابر ہونی چاہئے۔',
    'between' => [
        'array' => ':attribute میں :min اور :max آئٹمز کے درمیان ہونا چاہئے۔',
        'file' => ':attribute :min اور :max کلو بائٹس کے درمیان ہونا چاہئے۔',
        'numeric' => ':attribute :min اور :max کے درمیان ہونا چاہئے۔',
        'string' => ':attribute :min اور :max حروف کے درمیان ہونا چاہئے۔',
    ],
    'boolean' => ':attribute فیلڈ صحیح یا غلط ہونا چاہئے۔',
    'can' => ':attribute فیلڈ میں غیر مجاز قدر ہے۔',
    'confirmed' => ':attribute کی تصدیق مماثل نہیں ہے۔',
    'contains' => ':attribute میں ایک مطلوبہ قدر غائب ہے۔',
    'current_password' => 'پاس ورڈ غلط ہے۔',
    'date' => ':attribute ایک درست تاریخ ہونا چاہئے۔',
    'date_equals' => ':attribute کی تاریخ :date کے برابر ہونی چاہئے۔',
    'date_format' => ':attribute کا فارمیٹ :format کے مطابق ہونا چاہئے۔',
    'decimal' => ':attribute میں :decimal اعشاریہ مقامات ہونے چاہئیں۔',
    'declined' => ':attribute کو مسترد کرنا ضروری ہے۔',
    'declined_if' => ':attribute کو مسترد کرنا ضروری ہے جب :other :value ہو۔',
    'different' => ':attribute اور :other مختلف ہونے چاہئیں۔',
    'digits' => ':attribute :digits ہندسے ہونے چاہئیں۔',
    'digits_between' => ':attribute :min اور :max ہندسوں کے درمیان ہونا چاہئے۔',
    'dimensions' => ':attribute کی تصویر کے ابعاد غلط ہیں۔',
    'distinct' => ':attribute فیلڈ میں نقل قدر ہے۔',
    'doesnt_end_with' => ':attribute کا اختتام ان میں سے کسی ایک پر نہیں ہونا چاہئے: :values۔',
    'doesnt_start_with' => ':attribute کا آغاز ان میں سے کسی ایک پر نہیں ہونا چاہئے: :values۔',
    'email' => ':attribute ایک درست ای میل پتہ ہونا چاہئے۔',
    'ends_with' => ':attribute کا اختتام ان میں سے کسی ایک پر ہونا چاہئے: :values۔',
    'enum' => 'منتخب :attribute غلط ہے۔',
    'exists' => 'منتخب :attribute غلط ہے۔',
    'extensions' => ':attribute میں ان میں سے ایک توسیع ہونی چاہئے: :values۔',
    'file' => ':attribute ایک فائل ہونا چاہئے۔',
    'filled' => ':attribute فیلڈ میں ایک قدر ہونی چاہئے۔',
    'gt' => [
        'array' => ':attribute میں :value سے زیادہ آئٹمز ہونے چاہئیں۔',
        'file' => ':attribute :value کلو بائٹس سے زیادہ ہونا چاہئے۔',
        'numeric' => ':attribute :value سے زیادہ ہونا چاہئے۔',
        'string' => ':attribute :value حروف سے زیادہ ہونا چاہئے۔',
    ],
    'gte' => [
        'array' => ':attribute میں :value یا اس سے زیادہ آئٹمز ہونے چاہئیں۔',
        'file' => ':attribute :value کلو بائٹس یا اس سے زیادہ ہونا چاہئے۔',
        'numeric' => ':attribute :value یا اس سے زیادہ ہونا چاہئے۔',
        'string' => ':attribute :value حروف یا اس سے زیادہ ہونا چاہئے۔',
    ],
    'hex_color' => ':attribute ایک درست ہیکس کلر ہونا چاہئے۔',
    'image' => ':attribute ایک تصویر ہونا چاہئے۔',
    'in' => 'منتخب :attribute غلط ہے۔',
    'in_array' => ':attribute فیلڈ :other میں موجود ہونا چاہئے۔',
    'integer' => ':attribute ایک عدد ہونا چاہئے۔',
    'ip' => ':attribute ایک درست IP پتہ ہونا چاہئے۔',
    'ipv4' => ':attribute ایک درست IPv4 پتہ ہونا چاہئے۔',
    'ipv6' => ':attribute ایک درست IPv6 پتہ ہونا چاہئے۔',
    'json' => ':attribute ایک درست JSON سٹرنگ ہونا چاہئے۔',
    'list' => ':attribute ایک فہرست ہونا چاہئے۔',
    'lowercase' => ':attribute چھوٹے حروف میں ہونا چاہئے۔',
    'lt' => [
        'array' => ':attribute میں :value سے کم آئٹمز ہونے چاہئیں۔',
        'file' => ':attribute :value کلو بائٹس سے کم ہونا چاہئے۔',
        'numeric' => ':attribute :value سے کم ہونا چاہئے۔',
        'string' => ':attribute :value حروف سے کم ہونا چاہئے۔',
    ],
    'lte' => [
        'array' => ':attribute میں :value سے زیادہ آئٹمز نہیں ہونے چاہئیں۔',
        'file' => ':attribute :value کلو بائٹس سے زیادہ نہیں ہونا چاہئے۔',
        'numeric' => ':attribute :value سے زیادہ نہیں ہونا چاہئے۔',
        'string' => ':attribute :value حروف سے زیادہ نہیں ہونا چاہئے۔',
    ],
    'mac_address' => ':attribute ایک درست MAC پتہ ہونا چاہئے۔',
    'max' => [
        'array' => ':attribute میں :max سے زیادہ آئٹمز نہیں ہونے چاہئیں۔',
        'file' => ':attribute :max کلو بائٹس سے زیادہ نہیں ہونا چاہئے۔',
        'numeric' => ':attribute :max سے زیادہ نہیں ہونا چاہئے۔',
        'string' => ':attribute :max حروف سے زیادہ نہیں ہونا چاہئے۔',
    ],
    'max_digits' => ':attribute میں :max سے زیادہ ہندسے نہیں ہونے چاہئیں۔',
    'mimes' => ':attribute ایک فائل ہونی چاہئے: :values۔',
    'mimetypes' => ':attribute ایک فائل ہونی چاہئے: :values۔',
    'min' => [
        'array' => ':attribute میں کم از کم :min آئٹمز ہونے چاہئیں۔',
        'file' => ':attribute کم از کم :min کلو بائٹس ہونا چاہئے۔',
        'numeric' => ':attribute کم از کم :min ہونا چاہئے۔',
        'string' => ':attribute کم از کم :min حروف ہونا چاہئے۔',
    ],
    'min_digits' => ':attribute میں کم از کم :min ہندسے ہونے چاہئیں۔',
    'missing' => ':attribute فیلڈ غائب ہونا چاہئے۔',
    'missing_if' => ':attribute فیلڈ غائب ہونا چاہئے جب :other :value ہو۔',
    'missing_unless' => ':attribute فیلڈ غائب ہونا چاہئے جب تک :other :value نہ ہو۔',
    'missing_with' => ':attribute فیلڈ غائب ہونا چاہئے جب :values موجود ہو۔',
    'missing_with_all' => ':attribute فیلڈ غائب ہونا چاہئے جب :values موجود ہوں۔',
    'multiple_of' => ':attribute :value کا متعدد ہونا چاہئے۔',
    'not_in' => 'منتخب :attribute غلط ہے۔',
    'not_regex' => ':attribute کا فارمیٹ غلط ہے۔',
    'numeric' => ':attribute ایک نمبر ہونا چاہئے۔',
    'password' => [
        'letters' => ':attribute میں کم از کم ایک حرف ہونا چاہئے۔',
        'mixed' => ':attribute میں کم از کم ایک بڑا اور ایک چھوٹا حرف ہونا چاہئے۔',
        'numbers' => ':attribute میں کم از کم ایک نمبر ہونا چاہئے۔',
        'symbols' => ':attribute میں کم از کم ایک علامت ہونا چاہئے۔',
        'uncompromised' => 'دی گئی :attribute ایک ڈیٹا لیک میں ظاہر ہوئی ہے۔ براہ کرم مختلف :attribute منتخب کریں۔',
    ],
    'present' => ':attribute فیلڈ موجود ہونا چاہئے۔',
    'present_if' => ':attribute فیلڈ موجود ہونا چاہئے جب :other :value ہو۔',
    'present_unless' => ':attribute فیلڈ موجود ہونا چاہئے جب تک :other :value نہ ہو۔',
    'present_with' => ':attribute فیلڈ موجود ہونا چاہئے جب :values موجود ہو۔',
    'present_with_all' => ':attribute فیلڈ موجود ہونا چاہئے جب :values موجود ہوں۔',
    'prohibited' => ':attribute فیلڈ ممنوع ہے۔',
    'prohibited_if' => ':attribute فیلڈ ممنوع ہے جب :other :value ہو۔',
    'prohibited_unless' => ':attribute فیلڈ ممنوع ہے جب تک :other :values میں نہ ہو۔',
    'prohibits' => ':attribute فیلڈ :other کو موجود ہونے سے روکتا ہے۔',
    'regex' => ':attribute کا فارمیٹ غلط ہے۔',
    'required' => ':attribute فیلڈ ضروری ہے۔',
    'required_array_keys' => ':attribute فیلڈ میں انٹریز ہونی چاہئیں: :values۔',
    'required_if' => ':attribute فیلڈ ضروری ہے جب :other :value ہو۔',
    'required_if_accepted' => ':attribute فیلڈ ضروری ہے جب :other قبول ہو۔',
    'required_if_declined' => ':attribute فیلڈ ضروری ہے جب :other مسترد ہو۔',
    'required_unless' => ':attribute فیلڈ ضروری ہے جب تک :other :values میں نہ ہو۔',
    'required_with' => ':attribute فیلڈ ضروری ہے جب :values موجود ہو۔',
    'required_with_all' => ':attribute فیلڈ ضروری ہے جب :values موجود ہوں۔',
    'required_without' => ':attribute فیلڈ ضروری ہے جب :values موجود نہ ہو۔',
    'required_without_all' => ':attribute فیلڈ ضروری ہے جب :values میں سے کوئی بھی موجود نہ ہو۔',
    'same' => ':attribute اور :other مماثل ہونے چاہئیں۔',
    'size' => [
        'array' => ':attribute میں :size آئٹمز ہونے چاہئیں۔',
        'file' => ':attribute :size کلو بائٹس ہونا چاہئے۔',
        'numeric' => ':attribute :size ہونا چاہئے۔',
        'string' => ':attribute :size حروف ہونا چاہئے۔',
    ],
    'starts_with' => ':attribute کا آغاز ان میں سے کسی ایک سے ہونا چاہئے: :values۔',
    'string' => ':attribute ایک سٹرنگ ہونا چاہئے۔',
    'timezone' => ':attribute ایک درست ٹائم زون ہونا چاہئے۔',
    'unique' => ':attribute پہلے ہی لیا جا چکا ہے۔',
    'uploaded' => ':attribute اپلوڈ کرنے میں ناکام رہا۔',
    'uppercase' => ':attribute بڑے حروف میں ہونا چاہئے۔',
    'url' => ':attribute ایک درست URL ہونا چاہئے۔',
    'ulid' => ':attribute ایک درست ULID ہونا چاہئے۔',
    'uuid' => ':attribute ایک درست UUID ہونا چاہئے۔',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'share_location'        => 'مقام کا اشتراک کریں',
        'code_country'          => 'ملک کا کوڈ',
        'case_of_emergency'     => 'ہنگامی صورت حال میں',
        'location'              => 'مقام',
        'type'                  => 'قسم',
        'client_type'           => 'کلائنٹ کی قسم',
        'services' =>  'خدمات',
        'services.*' =>  'خدمات',
        'code_referral'         => 'حوالہ کوڈ',
        'status_type'           => 'حیثیت کی قسم',
        'status'                => 'حیثیت',
        'note_type'             => 'نوٹ کی قسم',
        'note'                  => 'نوٹ',
        'image_type'            => 'تصویر کی قسم',
        'car_id'                => 'گاڑی کا شناختی نمبر',
        'manufacture_year'      => 'تیاری کا سال',
        'car_number'            => 'گاڑی کا نمبر',
        'serial_number'         => 'سیریل نمبر',
        "language"              => "زبان",
        "key"                   => "کلید",

        "brand_id"              => "گاڑی کا برانڈ",
        "model_id"              => "گاڑی کا ماڈل",
        "from_date"             => "تاریخ سے",
        "to_date"               => "تاریخ تک",
        "category"              => "زمرہ",
        "from_time"             => "وقت سے",
        "to_time"               => "وقت تک",
        "yesterday"             => "کل",
        "is_trainer"            => "ٹرینر",

        'data' => [
            'phone'    => 'فون',
            'name'     => 'نام',
            'email'    => 'ای میل',
            "image"    => 'تصویر',
            'gender'   => 'صنف',
            "birthday" => 'سالگرہ',
        ],
        "branch_id"             => "برانچ",
        "dish_id"               => "ڈش",
        "delivery_time"         => "ترسیل کا وقت",
        "delivery_date"         => "ترسیل کی تاریخ",
        "received_date"         => "موصول ہونے کی تاریخ",
        "received_time"         => "موصول ہونے کا وقت",
        "showroom_id"           => "شو روم",
        "vehicle_id"            => "گاڑی",
    ],

];

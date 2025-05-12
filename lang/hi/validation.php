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

    'accepted' => ':attribute को स्वीकार किया जाना चाहिए।',
    'accepted_if' => ':attribute को स्वीकार किया जाना चाहिए जब :other :value हो।',
    'active_url' => ':attribute एक मान्य URL होना चाहिए।',
    'after' => ':attribute :date के बाद की तारीख होनी चाहिए।',
    'after_or_equal' => ':attribute :date के बाद या उसके बराबर की तारीख होनी चाहिए।',
    'alpha' => ':attribute में केवल अक्षर होने चाहिए।',
    'alpha_dash' => ':attribute में केवल अक्षर, संख्याएँ, डैश और अंडरस्कोर होने चाहिए।',
    'alpha_num' => ':attribute में केवल अक्षर और संख्याएँ होनी चाहिए।',
    'array' => ':attribute एक सरणी होनी चाहिए।',
    'ascii' => ':attribute में केवल सिंगल-बाइट अल्फ़ान्यूमेरिक वर्ण और प्रतीक होने चाहिए।',
    'before' => ':attribute :date से पहले की तारीख होनी चाहिए।',
    'before_or_equal' => ':attribute :date से पहले या उसके बराबर की तारीख होनी चाहिए।',
    'between' => [
        'array' => ':attribute में :min और :max आइटम होने चाहिए।',
        'file' => ':attribute :min और :max किलोबाइट्स के बीच होना चाहिए।',
        'numeric' => ':attribute :min और :max के बीच होना चाहिए।',
        'string' => ':attribute :min और :max वर्णों के बीच होना चाहिए।',
    ],
    'boolean' => ':attribute फ़ील्ड सही या गलत होना चाहिए।',
    'can' => ':attribute फ़ील्ड में एक अनधिकृत मान है।',
    'confirmed' => ':attribute पुष्टिकरण मेल नहीं खाता।',
    'contains' => ':attribute फ़ील्ड में एक आवश्यक मान गायब है।',
    'current_password' => 'पासवर्ड गलत है।',
    'date' => ':attribute एक मान्य तारीख होनी चाहिए।',
    'date_equals' => ':attribute :date के बराबर की तारीख होनी चाहिए।',
    'date_format' => ':attribute :format प्रारूप से मेल खाना चाहिए।',
    'decimal' => ':attribute में :decimal दशमलव स्थान होने चाहिए।',
    'declined' => ':attribute को अस्वीकार किया जाना चाहिए।',
    'declined_if' => ':attribute को अस्वीकार किया जाना चाहिए जब :other :value हो।',
    'different' => ':attribute और :other अलग होने चाहिए।',
    'digits' => ':attribute :digits अंक होने चाहिए।',
    'digits_between' => ':attribute :min और :max अंकों के बीच होना चाहिए।',
    'dimensions' => ':attribute में अमान्य छवि आयाम हैं।',
    'distinct' => ':attribute फ़ील्ड में डुप्लिकेट मान है।',
    'doesnt_end_with' => ':attribute निम्नलिखित में से किसी एक के साथ समाप्त नहीं होना चाहिए: :values।',
    'doesnt_start_with' => ':attribute निम्नलिखित में से किसी एक के साथ शुरू नहीं होना चाहिए: :values।',
    'email' => ':attribute एक मान्य ईमेल पता होना चाहिए।',
    'ends_with' => ':attribute निम्नलिखित में से किसी एक के साथ समाप्त होना चाहिए: :values।',
    'enum' => 'चयनित :attribute अमान्य है।',
    'exists' => 'चयनित :attribute अमान्य है।',
    'extensions' => ':attribute में निम्नलिखित एक्सटेंशन में से एक होना चाहिए: :values।',
    'file' => ':attribute एक फ़ाइल होनी चाहिए।',
    'filled' => ':attribute फ़ील्ड में एक मान होना चाहिए।',
    'gt' => [
        'array' => ':attribute में :value से अधिक आइटम होने चाहिए।',
        'file' => ':attribute :value किलोबाइट्स से अधिक होना चाहिए।',
        'numeric' => ':attribute :value से अधिक होना चाहिए।',
        'string' => ':attribute :value वर्णों से अधिक होना चाहिए।',
    ],
    'gte' => [
        'array' => ':attribute में :value आइटम या अधिक होने चाहिए।',
        'file' => ':attribute :value किलोबाइट्स या अधिक होना चाहिए।',
        'numeric' => ':attribute :value या अधिक होना चाहिए।',
        'string' => ':attribute :value वर्णों या अधिक होना चाहिए।',
    ],
    'hex_color' => ':attribute एक मान्य हेक्साडेसिमल रंग होना चाहिए।',
    'image' => ':attribute एक छवि होनी चाहिए।',
    'in' => 'चयनित :attribute अमान्य है।',
    'in_array' => ':attribute फ़ील्ड :other में मौजूद होना चाहिए।',
    'integer' => ':attribute एक पूर्णांक होना चाहिए।',
    'ip' => ':attribute एक मान्य IP पता होना चाहिए।',
    'ipv4' => ':attribute एक मान्य IPv4 पता होना चाहिए।',
    'ipv6' => ':attribute एक मान्य IPv6 पता होना चाहिए।',
    'json' => ':attribute एक मान्य JSON स्ट्रिंग होनी चाहिए।',
    'list' => ':attribute एक सूची होनी चाहिए।',
    'lowercase' => ':attribute लोअरकेस होना चाहिए।',
    'lt' => [
        'array' => ':attribute में :value से कम आइटम होने चाहिए।',
        'file' => ':attribute :value किलोबाइट्स से कम होना चाहिए।',
        'numeric' => ':attribute :value से कम होना चाहिए।',
        'string' => ':attribute :value वर्णों से कम होना चाहिए।',
    ],
    'lte' => [
        'array' => ':attribute में :value से अधिक आइटम नहीं होने चाहिए।',
        'file' => ':attribute :value किलोबाइट्स से कम या बराबर होना चाहिए।',
        'numeric' => ':attribute :value से कम या बराबर होना चाहिए।',
        'string' => ':attribute :value वर्णों से कम या बराबर होना चाहिए।',
    ],
    'mac_address' => ':attribute एक मान्य MAC पता होना चाहिए।',
    'max' => [
        'array' => ':attribute में :max से अधिक आइटम नहीं होने चाहिए।',
        'file' => ':attribute :max किलोबाइट्स से अधिक नहीं होना चाहिए।',
        'numeric' => ':attribute :max से अधिक नहीं होना चाहिए।',
        'string' => ':attribute :max वर्णों से अधिक नहीं होना चाहिए।',
    ],
    'max_digits' => ':attribute में :max से अधिक अंक नहीं होने चाहिए।',
    'mimes' => ':attribute एक प्रकार की फ़ाइल होनी चाहिए: :values।',
    'mimetypes' => ':attribute एक प्रकार की फ़ाइल होनी चाहिए: :values।',
    'min' => [
        'array' => ':attribute में कम से कम :min आइटम होने चाहिए।',
        'file' => ':attribute कम से कम :min किलोबाइट्स का होना चाहिए।',
        'numeric' => ':attribute कम से कम :min होना चाहिए।',
        'string' => ':attribute कम से कम :min वर्णों का होना चाहिए।',
    ],
    'min_digits' => ':attribute में कम से कम :min अंक होने चाहिए।',
    'missing' => ':attribute फ़ील्ड गायब होना चाहिए।',
    'missing_if' => ':attribute फ़ील्ड गायब होना चाहिए जब :other :value हो।',
    'missing_unless' => ':attribute फ़ील्ड गायब होना चाहिए जब तक :other :value न हो।',
    'missing_with' => ':attribute फ़ील्ड गायब होना चाहिए जब :values मौजूद हो।',
    'missing_with_all' => ':attribute फ़ील्ड गायब होना चाहिए जब :values मौजूद हों।',
    'multiple_of' => ':attribute :value का गुणज होना चाहिए।',
    'not_in' => 'चयनित :attribute अमान्य है।',
    'not_regex' => ':attribute प्रारूप अमान्य है।',
    'numeric' => ':attribute एक संख्या होनी चाहिए।',
    'password' => [
        'letters' => ':attribute में कम से कम एक अक्षर होना चाहिए।',
        'mixed' => ':attribute में कम से कम एक अपरकेस और एक लोअरकेस अक्षर होना चाहिए।',
        'numbers' => ':attribute में कम से कम एक संख्या होनी चाहिए।',
        'symbols' => ':attribute में कम से कम एक प्रतीक होना चाहिए।',
        'uncompromised' => 'दिया गया :attribute डेटा लीक में पाया गया है। कृपया एक अलग :attribute चुनें।',
    ],
    'present' => ':attribute फ़ील्ड मौजूद होना चाहिए।',
    'present_if' => ':attribute फ़ील्ड मौजूद होना चाहिए जब :other :value हो।',
    'present_unless' => ':attribute फ़ील्ड मौजूद होना चाहिए जब तक :other :value न हो।',
    'present_with' => ':attribute फ़ील्ड मौजूद होना चाहिए जब :values मौजूद हो।',
    'present_with_all' => ':attribute फ़ील्ड मौजूद होना चाहिए जब :values मौजूद हों।',
    'prohibited' => ':attribute फ़ील्ड निषिद्ध है।',
    'prohibited_if' => ':attribute फ़ील्ड निषिद्ध है जब :other :value हो।',
    'prohibited_unless' => ':attribute फ़ील्ड निषिद्ध है जब तक :other :values में न हो।',
    'prohibits' => ':attribute फ़ील्ड :other को मौजूद होने से रोकता है।',
    'regex' => ':attribute फ़ील्ड प्रारूप अमान्य है।',
    'required' => ':attribute फ़ील्ड आवश्यक है।',
    'required_array_keys' => ':attribute फ़ील्ड में निम्नलिखित प्रविष्टियाँ होनी चाहिए: :values।',
    'required_if' => ':attribute फ़ील्ड आवश्यक है जब :other :value हो।',
    'required_if_accepted' => ':attribute फ़ील्ड आवश्यक है जब :other स्वीकार किया गया हो।',
    'required_if_declined' => ':attribute फ़ील्ड आवश्यक है जब :other अस्वीकार किया गया हो।',
    'required_unless' => ':attribute फ़ील्ड आवश्यक है जब तक :other :values में न हो।',
    'required_with' => ':attribute फ़ील्ड आवश्यक है जब :values मौजूद हो।',
    'required_with_all' => ':attribute फ़ील्ड आवश्यक है जब :values मौजूद हों।',
    'required_without' => ':attribute फ़ील्ड आवश्यक है जब :values मौजूद न हो।',
    'required_without_all' => ':attribute फ़ील्ड आवश्यक है जब :values में से कोई भी मौजूद न हो।',
    'same' => ':attribute और :other मेल खाना चाहिए।',
    'size' => [
        'array' => ':attribute में :size आइटम होने चाहिए।',
        'file' => ':attribute :size किलोबाइट्स का होना चाहिए।',
        'numeric' => ':attribute :size होना चाहिए।',
        'string' => ':attribute :size वर्णों का होना चाहिए।',
    ],
    'starts_with' => ':attribute निम्नलिखित में से किसी एक के साथ शुरू होना चाहिए: :values।',
    'string' => ':attribute एक स्ट्रिंग होनी चाहिए।',
    'timezone' => ':attribute एक मान्य समय क्षेत्र होना चाहिए।',
    'unique' => ':attribute पहले से लिया जा चुका है।',
    'uploaded' => ':attribute अपलोड करने में विफल रहा।',
    'uppercase' => ':attribute अपरकेस होना चाहिए।',
    'url' => ':attribute एक मान्य URL होना चाहिए।',
    'ulid' => ':attribute एक मान्य ULID होना चाहिए।',
    'uuid' => ':attribute एक मान्य UUID होना चाहिए।',

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
        'share_location'        => 'स्थान साझा करें',
        'code_country'          => 'देश कोड',
        'case_of_emergency'     => 'आपात स्थिति में',
        'location'              => 'स्थान',
        'type'                  => 'प्रकार',
        'client_type'           => 'ग्राहक प्रकार',
        'services'              => 'सेवाएं',
        'services.*'            => 'सेवाएं',
        'code_referral'         => 'रेफरल कोड',
        'status_type'           => 'स्थिति प्रकार',
        'status'                => 'स्थिति',
        'note_type'             => 'नोट प्रकार',
        'note'                  => 'नोट',
        'image_type'            => 'छवि प्रकार',
        'car_id'                => 'कार आईडी',
        'manufacture_year'      => 'निर्माण वर्ष',
        'car_number'            => 'कार नंबर',
        'serial_number'         => 'सीरियल नंबर',
        'language'              => 'भाषा',
        'key'                   => 'कुंजी',

        'brand_id'              => 'कार ब्रांड',
        'model_id'              => 'कार मॉडल',
        'from_date'             => 'तारीख से',
        'to_date'               => 'तारीख तक',
        'category'              => 'श्रेणी',
        'from_time'             => 'समय से',
        'to_time'               => 'समय तक',
        'yesterday'             => 'कल',
        'is_trainer'            => 'प्रशिक्षक',

        'data' => [
            'phone'             => 'फोन',
            'name'              => 'नाम',
            'email'             => 'ईमेल',
            'image'             => 'छवि',
            'gender'            => 'लिंग',
            'birthday'          => 'जन्मदिन',
        ],
        'branch_id'             => 'शाखा',
        'dish_id'               => 'डिश',
        'delivery_time'         => 'वितरण समय',
        'delivery_date'         => 'वितरण तिथि',
        'received_date'         => 'प्राप्त तिथि',
        'received_time'         => 'प्राप्त समय',
        'showroom_id'           => 'शोरूम',
        'vehicle_id'            => 'वाहन',
    ],

];

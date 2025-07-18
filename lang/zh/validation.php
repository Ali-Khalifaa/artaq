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

    'accepted' => ':attribute 必须被接受。',
    'accepted_if' => '当 :other 是 :value 时，:attribute 必须被接受。',
    'active_url' => ':attribute 不是一个有效的网址。',
    'after' => ':attribute 必须是 :date 之后的日期。',
    'after_or_equal' => ':attribute 必须是 :date 之后或相同的日期。',
    'alpha' => ':attribute 只能包含字母。',
    'alpha_dash' => ':attribute 只能包含字母、数字、破折号和下划线。',
    'alpha_num' => ':attribute 只能包含字母和数字。',
    'array' => ':attribute 必须是一个数组。',
    'ascii' => ':attribute 只能包含单字节字母数字字符和符号。',
    'before' => ':attribute 必须是 :date 之前的日期。',
    'before_or_equal' => ':attribute 必须是 :date 之前或相同的日期。',
    'between' => [
        'array' => ':attribute 必须有 :min 到 :max 项。',
        'file' => ':attribute 必须在 :min 到 :max 千字节之间。',
        'numeric' => ':attribute 必须在 :min 到 :max 之间。',
        'string' => ':attribute 必须在 :min 到 :max 个字符之间。',
    ],
    'boolean' => ':attribute 字段必须为 true 或 false。',
    'can' => ':attribute 字段包含未经授权的值。',
    'confirmed' => ':attribute 确认不匹配。',
    'contains' => ':attribute 字段缺少必需的值。',
    'current_password' => '密码不正确。',
    'date' => ':attribute 不是一个有效的日期。',
    'date_equals' => ':attribute 必须是等于 :date 的日期。',
    'date_format' => ':attribute 与格式 :format 不匹配。',
    'decimal' => ':attribute 必须有 :decimal 位小数。',
    'declined' => ':attribute 必须被拒绝。',
    'declined_if' => '当 :other 是 :value 时，:attribute 必须被拒绝。',
    'different' => ':attribute 和 :other 必须不同。',
    'digits' => ':attribute 必须是 :digits 位数字。',
    'digits_between' => ':attribute 必须在 :min 和 :max 位数字之间。',
    'dimensions' => ':attribute 图片尺寸无效。',
    'distinct' => ':attribute 字段有重复值。',
    'doesnt_end_with' => ':attribute 不能以以下之一结尾：:values。',
    'doesnt_start_with' => ':attribute 不能以以下之一开头：:values。',
    'email' => ':attribute 必须是一个有效的电子邮件地址。',
    'ends_with' => ':attribute 必须以以下之一结尾：:values。',
    'enum' => '所选的 :attribute 无效。',
    'exists' => '所选的 :attribute 无效。',
    'extensions' => ':attribute 必须是以下扩展名之一：:values。',
    'file' => ':attribute 必须是一个文件。',
    'filled' => ':attribute 字段必须有一个值。',
    'gt' => [
        'array' => ':attribute 必须有多于 :value 项。',
        'file' => ':attribute 必须大于 :value 千字节。',
        'numeric' => ':attribute 必须大于 :value。',
        'string' => ':attribute 必须大于 :value 个字符。',
    ],
    'gte' => [
        'array' => ':attribute 必须有 :value 项或更多。',
        'file' => ':attribute 必须大于或等于 :value 千字节。',
        'numeric' => ':attribute 必须大于或等于 :value。',
        'string' => ':attribute 必须大于或等于 :value 个字符。',
    ],
    'hex_color' => ':attribute 必须是一个有效的十六进制颜色。',
    'image' => ':attribute 必须是图片。',
    'in' => '所选的 :attribute 无效。',
    'in_array' => ':attribute 字段在 :other 中不存在。',
    'integer' => ':attribute 必须是整数。',
    'ip' => ':attribute 必须是一个有效的 IP 地址。',
    'ipv4' => ':attribute 必须是一个有效的 IPv4 地址。',
    'ipv6' => ':attribute 必须是一个有效的 IPv6 地址。',
    'json' => ':attribute 必须是一个有效的 JSON 字符串。',
    'list' => ':attribute 必须是一个列表。',
    'lowercase' => ':attribute 必须是小写。',
    'lt' => [
        'array' => ':attribute 必须少于 :value 项。',
        'file' => ':attribute 必须小于 :value 千字节。',
        'numeric' => ':attribute 必须小于 :value。',
        'string' => ':attribute 必须小于 :value 个字符。',
    ],
    'lte' => [
        'array' => ':attribute 不能多于 :value 项。',
        'file' => ':attribute 必须小于或等于 :value 千字节。',
        'numeric' => ':attribute 必须小于或等于 :value。',
        'string' => ':attribute 必须小于或等于 :value 个字符。',
    ],
    'mac_address' => ':attribute 必须是一个有效的 MAC 地址。',
    'max' => [
        'array' => ':attribute 不能多于 :max 项。',
        'file' => ':attribute 不能大于 :max 千字节。',
        'numeric' => ':attribute 不能大于 :max。',
        'string' => ':attribute 不能大于 :max 个字符。',
    ],
    'max_digits' => ':attribute 不能多于 :max 位数字。',
    'mimes' => ':attribute 必须是以下类型的文件：:values。',
    'mimetypes' => ':attribute 必须是以下类型的文件：:values。',
    'min' => [
        'array' => ':attribute 至少有 :min 项。',
        'file' => ':attribute 至少为 :min 千字节。',
        'numeric' => ':attribute 至少为 :min。',
        'string' => ':attribute 至少为 :min 个字符。',
    ],
    'min_digits' => ':attribute 至少有 :min 位数字。',
    'missing' => ':attribute 字段必须缺失。',
    'missing_if' => '当 :other 是 :value 时，:attribute 字段必须缺失。',
    'missing_unless' => '除非 :other 是 :value，否则 :attribute 字段必须缺失。',
    'missing_with' => '当 :values 存在时，:attribute 字段必须缺失。',
    'missing_with_all' => '当 :values 存在时，:attribute 字段必须缺失。',
    'multiple_of' => ':attribute 必须是 :value 的倍数。',
    'not_in' => '所选的 :attribute 无效。',
    'not_regex' => ':attribute 格式无效。',
    'numeric' => ':attribute 必须是一个数字。',
    'password' => [
        'letters' => ':attribute 必须包含至少一个字母。',
        'mixed' => ':attribute 必须包含至少一个大写字母和一个小写字母。',
        'numbers' => ':attribute 必须包含至少一个数字。',
        'symbols' => ':attribute 必须包含至少一个符号。',
        'uncompromised' => '给定的 :attribute 已出现在数据泄露中。请选择不同的 :attribute。',
    ],
    'present' => ':attribute 字段必须存在。',
    'present_if' => '当 :other 是 :value 时，:attribute 字段必须存在。',
    'present_unless' => '除非 :other 是 :value，否则 :attribute 字段必须存在。',
    'present_with' => '当 :values 存在时，:attribute 字段必须存在。',
    'present_with_all' => '当 :values 存在时，:attribute 字段必须存在。',
    'prohibited' => ':attribute 字段被禁止。',
    'prohibited_if' => '当 :other 是 :value 时，:attribute 字段被禁止。',
    'prohibited_unless' => '除非 :other 在 :values 中，否则 :attribute 字段被禁止。',
    'prohibits' => ':attribute 字段禁止 :other 存在。',
    'regex' => ':attribute 格式无效。',
    'required' => ':attribute 字段是必需的。',
    'required_array_keys' => ':attribute 字段必须包含以下条目：:values。',
    'required_if' => '当 :other 是 :value 时，:attribute 字段是必需的。',
    'required_if_accepted' => '当 :other 被接受时，:attribute 字段是必需的。',
    'required_if_declined' => '当 :other 被拒绝时，:attribute 字段是必需的。',
    'required_unless' => '除非 :other 在 :values 中，否则 :attribute 字段是必需的。',
    'required_with' => '当 :values 存在时，:attribute 字段是必需的。',
    'required_with_all' => '当 :values 存在时，:attribute 字段是必需的。',
    'required_without' => '当 :values 不存在时，:attribute 字段是必需的。',
    'required_without_all' => '当 :values 都不存在时，:attribute 字段是必需的。',
    'same' => ':attribute 和 :other 必须匹配。',
    'size' => [
        'array' => ':attribute 必须包含 :size 项。',
        'file' => ':attribute 必须是 :size 千字节。',
        'numeric' => ':attribute 必须是 :size。',
        'string' => ':attribute 必须是 :size 个字符。',
    ],
    'starts_with' => ':attribute 必须以以下之一开头：:values。',
    'string' => ':attribute 必须是一个字符串。',
    'timezone' => ':attribute 必须是一个有效的时区。',
    'unique' => ':attribute 已经被占用。',
    'uploaded' => ':attribute 上传失败。',
    'uppercase' => ':attribute 必须是大写。',
    'url' => ':attribute 必须是一个有效的网址。',
    'ulid' => ':attribute 必须是一个有效的 ULID。',
    'uuid' => ':attribute 必须是一个有效的 UUID。',

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
        'share_location'        => '共享位置',
        'code_country'          => '国家代码',
        'case_of_emergency'     => '紧急情况',
        'location'              => '位置',
        'type'                  => '类型',
        'client_type'           => '客户类型',
        'services'              => '服务',
        'services.*'            => '服务',
        'code_referral'         => '推荐代码',
        'status_type'           => '状态类型',
        'status'                => '状态',
        'note_type'             => '备注类型',
        'note'                  => '备注',
        'image_type'            => '图片类型',
        'car_id'                => '车辆ID',
        'manufacture_year'      => '制造年份',
        'car_number'            => '车牌号',
        'serial_number'         => '序列号',
        'language'              => '语言',
        'key'                   => '键',

        'brand_id'              => '汽车品牌',
        'model_id'              => '汽车型号',
        'from_date'             => '开始日期',
        'to_date'               => '结束日期',
        'category'              => '类别',
        'from_time'             => '开始时间',
        'to_time'               => '结束时间',
        'yesterday'             => '昨天',
        'is_trainer'            => '培训师',

        'data' => [
            'phone'    => '电话',
            'name'     => '姓名',
            'email'    => '电子邮件',
            'image'    => '图片',
            'gender'   => '性别',
            'birthday' => '生日',
        ],
        'branch_id'             => '分支',
        'dish_id'               => '菜肴',
        'delivery_time'         => '送货时间',
        'delivery_date'         => '送货日期',
        'received_date'         => '接收日期',
        'received_time'         => '接收时间',
        'showroom_id'           => '展厅',
        'vehicle_id'            => '车辆',
    ],

];

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="utf-8">
    <title>تسجيل الدخول بواسطة رمز التحقق - ارتقي</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f7f7f7;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 6px;
            padding: 24px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            direction: rtl;
            text-align: right;
        }
        .logo {
            text-align: center;
            margin-bottom: 18px;
        }
        h1 {
            color: #2b6cb0;
            font-size: 20px;
            margin: 0 0 12px 0;
        }
        p {
            margin: 8px 0;
            color: #333333;
            font-size: 14px;
        }
        .otp {
            display: block;
            width: fit-content;
            margin: 16px auto;
            background: #f1f5f9;
            padding: 12px 18px;
            border-radius: 6px;
            font-size: 22px;
            letter-spacing: 6px;
            font-weight: bold;
            color: #111827;
            text-align: center;
        }
        .note {
            font-size: 13px;
            color: #6b7280;
        }
        .footer {
            margin-top: 22px;
            font-size: 13px;
            color: #6b7280;
            text-align: center;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="https://ertaqi.stocktecharabia.com/assets/images/brand-logos/center.png" alt="ارتقي" style="height:70px">
        </div>

        <h1>رمز التحقق لتسجيل الدخول</h1>

        <p>مرحبًا {{ $userName ?? '' }}،</p>

        <p>لقد طلبت تسجيل الدخول إلى تطبيق <strong>ارتقي</strong> باستخدام رمز التحقق. الرجاء استخدام الرمز التالي لإكمال عملية التسجيل/تسجيل الدخول:</p>

        <div class="otp">{{ $otp }}</div>

        <p class="note">ملاحظة: هذا الرمز صالح لمدة دقيقة فقط. إذا لم تطلب رمز التحقق، فتجاهل هذه الرسالة أو تواصل مع الدعم.</p>

        <p>لا تقم بمشاركة رمز التحقق مع أي شخص للحفاظ على أمان حسابك.</p>

        <p>مع التحية،<br>فريق تطبيق ارتقي</p>

        <div class="footer">
            <p>إن احتجت للمساعدة، قم بالرد على هذه الرسالة أو تواصل مع فريق الدعم.</p>
        </div>
    </div>
</body>
</html>

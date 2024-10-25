<?php
$resetEmail = '<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Password reset request from Alyoum</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <table width="100%" align="center">
        <tr>
            <td>
                <table width="600" align="center" bgcolor="#F6F6F6" style="max-width: 100%;">
                    <tr>
                        <td></td>
                    </tr>
                    <tr bgcolor="#006a38">
                        <td>
                            <table width="522" align="center" style="max-width: 100%; text-align: center;">
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><img src="https://alyoumpromo.com/assets/images/alyoum-logo-mail.png" alt="Alyoum" style="max-width: 130px;" width="100px;"></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="522" align="center" style="max-width: 100%; text-align: center; font-family: \'Open Sans\', sans-serif;">
                                <tr></tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><h2 style="color: #006a38; font-size: 26px;">أعد تعيين كلمة المرور الخاصة بك  </h2></td>
                                </tr>
                                
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr dir="ltr">
                                    <td>
                                        <p>عزيزي/عزيزتي   ' . $fullName . ',</p>
                                        <p>نرسل لك هذا البريد الإلكتروني لأنك طلبت إعادة تعيين كلمة المرور. انقر على هذا الرابط لإنشاء كلمة مرور جديدة:  </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr dir="ltr">
                                    <td>
                                         <a href="' . $reset_link . '" target="_blank" >
                                                        <img src="https://alyoumpromo.com/assets/images/reset-password-en.png" alt="Alyoum" style="max-width: 180px;" width="180px;">
                                                        

                                                    </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>أو انسخ الرابط والصقه في متصفحك:  </p>
                                        <p>' . $reset_link . '</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr dir="ltr">
                                    <td>
                                        <p>إذا لم تطلب إعادة تعيين كلمة المرور، يمكنك تجاهل هذا البريد الإلكتروني. لن يتم تغيير كلمة مرورك.  </p><br>
                                        <p>أطيب التحيات،<br>بالنيابة عن "اليوم"</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';

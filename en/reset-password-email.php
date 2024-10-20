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
                                    <td><h2 style="color: #006a38; font-size: 26px;">RESET YOUR PASSWORD</h2></td>
                                </tr>
                                
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr dir="ltr">
                                    <td>
                                        <p>Dear ' . $fullName . ',</p>
                                        <p>We\'re sending you this email because you requested a password reset. Click on this link to create a new password:</p>
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
                                        <p>Or copy and paste the URL into your browser:</p>
                                        <p>' . $reset_link . '</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr dir="ltr">
                                    <td>
                                        <p>If you didn\'t request a password reset, you can ignore this email. Your password will not be changed.</p><br>
                                        <p>Warm regards,<br>On Behalf of Alyoum</p>
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

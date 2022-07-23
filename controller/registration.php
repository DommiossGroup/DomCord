<?php

if (isset($_SESSION['id'])) {

    echo '<meta http-equiv="refresh" content="0;URL=?page=account">';
    die();
}

if (isset($_POST['create_account'])) {


    $username = htmlspecialchars($_POST['nametag']);
    $mail = htmlspecialchars($_POST['mail']);
    $pass1 = htmlspecialchars($_POST['pass']);
    $pass2 = htmlspecialchars($_POST['passVerify']);
    $pass = sha1($pass1);
    $passVerify = sha1($pass2);
    $passNoHash = htmlspecialchars($pass1);
    $passNoHash2 = htmlspecialchars($pass2);
    $passLenght = strlen($passNoHash);

    if (!empty($username) and !empty($mail) and !empty($pass1) and !empty($pass2)) {



        if ($passLenght >= 5) {



            if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {


                $reqMail = $bdd->prepare('SELECT * FROM ' . $_Config_['Database']['table_prefix'] . '_members WHERE MAIL = ?');

                $reqMail->execute(array($mail));


                if ($reqMail->rowCount() == 0) {

                    $reqIP = $bdd->prepare('SELECT * FROM ' . $_Config_['Database']['table_prefix'] . '_members WHERE IP_ADRESS = ?');

                    $reqIP->execute(array($_SERVER['REMOTE_ADDR']));
                    $reqIP = $reqIP->rowCount();

                    if ($reqIP < $_Config_['Security']['max_account_per_ip']) {
                        if ($pass1 == $pass2) {

                            $insert = $bdd->prepare('INSERT INTO `' . $_Config_['Database']['table_prefix'] . '_members`(`NAMETAG`, `MAIL`, `PASSWORD`, `LAST_LOGIN`, `DATE_CREATION`, `IP_ADRESS`, `STATUS`, `ABOUT`, `AVATAR_PATH`, `RANK_ID`) VALUES (?,?,?,NOW(),NOW(),?,1,?,?,?)');

                            $insert->execute(array($username, $mail, $pass, $_SERVER['REMOTE_ADDR'], "No description given", "default.png", "1"));
                            $error = "<div class='alert alert-success'><b>Congratulations !</b> Your account has been created !  Redirection...</div><meta http-equiv='REFRESH' content='1;url=?page=login'>";

                            function passgen2($nbChar)
                            {
                                return substr(str_shuffle(
                                    'abcdefghijklmnopqrstuvwxyzABCEFGHIJKLMNOPQRSTUVWXYZ0123456789'
                                ), 1, $nbChar);
                            }
                            /*
                            $code = passgen2(20);

                            $insertcode = $bdd->prepare("INSERT INTO `" . $_Config_['Database']['table_prefix'] . "_emailcode`(`TYPE`, `CODE`, `USER_MAIL`) VALUES (?,?,?)");
                            $insertcode->execute(array("VERIFYMAIL", $code, $mail));

                            $link = "https://" . $_SERVER['HTTP_HOST'] . "" . $_SERVER['REQUEST_URI'] . "?page=verification&code=" . $code;
                            $link = str_replace("?page=register", "", $link);
                            $to  = $mail;

                            $subject = $_Config_['General']['name'] . ' - Verify your email';

                            $message = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xmlns:o='urn:schemas-microsoft-com:office:office' style='width:100%;font-family:roboto, 'helvetica neue', helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0'>
<head>
<meta charset='UTF-8'>
<meta content='width=device-width, initial-scale=1' name='viewport'>
<meta name='x-apple-disable-message-reformatting'>
<meta http-equiv='X-UA-Compatible' content='IE=edge'>
<meta content='telephone=no' name='format-detection'>
<title>Nouveau modèle de courrier électronique 2021-07-11</title>
<!--[if (mso 16)]>
<style type='text/css'>
a {text-decoration: none;}
</style>
<![endif]-->
<!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]-->
<!--[if gte mso 9]>
<xml>
<o:OfficeDocumentSettings>
<o:AllowPNG></o:AllowPNG>
<o:PixelsPerInch>96</o:PixelsPerInch>
</o:OfficeDocumentSettings>
</xml>
<![endif]-->
<!--[if !mso]><!-- -->
<link href='https://fonts.googleapis.com/css?family=Roboto:400,400i,700,700i' rel='stylesheet'>
<!--<![endif]-->
<style type='text/css'>
#outlook a {
padding:0;
}
.ExternalClass {
width:100%;
}
.ExternalClass,
.ExternalClass p,
.ExternalClass span,
.ExternalClass font,
.ExternalClass td,
.ExternalClass div {
line-height:100%;
}
.es-button {
mso-style-priority:100!important;
text-decoration:none!important;
}
a[x-apple-data-detectors] {
color:inherit!important;
text-decoration:none!important;
font-size:inherit!important;
font-family:inherit!important;
font-weight:inherit!important;
line-height:inherit!important;
}
.es-desk-hidden {
display:none;
float:left;
overflow:hidden;
width:0;
max-height:0;
line-height:0;
mso-hide:all;
}
.es-button-border:hover a.es-button, .es-button-border:hover button.es-button {
background:#3498db!important;
border-color:#3498db!important;
}
.es-button-border:hover {
border-color:#42d159 #42d159 #42d159 #42d159!important;
background:#3498db!important;
}
[data-ogsb] .es-button {
border-width:0!important;
padding:10px 40px 10px 40px!important;
}
[data-ogsb] .es-button.es-button-1 {
padding:10px 99px!important;
}
@media only screen and (max-width:600px) {p, ul li, ol li, a { line-height:150%!important } h1 { font-size:26px!important; text-align:center; line-height:120%!important } h2 { font-size:24px!important; text-align:center; line-height:120%!important } h3 { font-size:20px!important; text-align:center; line-height:120%!important } .es-header-body h1 a, .es-content-body h1 a, .es-footer-body h1 a { font-size:26px!important } .es-header-body h2 a, .es-content-body h2 a, .es-footer-body h2 a { font-size:24px!important } .es-header-body h3 a, .es-content-body h3 a, .es-footer-body h3 a { font-size:20px!important } .es-menu td a { font-size:13px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:13px!important } .es-content-body p, .es-content-body ul li, .es-content-body ol li, .es-content-body a { font-size:14px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:13px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:11px!important } *[class='gmail-fix'] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:block!important } a.es-button, button.es-button { font-size:14px!important; display:block!important; border-left-width:0px!important; border-right-width:0px!important } .es-btn-fw { border-width:10px 0px!important; text-align:center!important } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0px!important } .es-m-p0r { padding-right:0px!important } .es-m-p0l { padding-left:0px!important } .es-m-p0t { padding-top:0px!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } tr.es-desk-hidden, td.es-desk-hidden, table.es-desk-hidden { width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } tr.es-desk-hidden { display:table-row!important } table.es-desk-hidden { display:table!important } td.es-desk-menu-hidden { display:table-cell!important } .es-menu td { width:1%!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } }
</style>
</head>
<body style='width:100%;font-family:roboto, 'helvetica neue', helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0'>
<div class='es-wrapper-color' style='background-color:#2980D9'>
<!--[if gte mso 9]>
<v:background xmlns:v='urn:schemas-microsoft-com:vml' fill='t'>
<v:fill type='tile' color='#2980d9'></v:fill>
</v:background>
<![endif]-->
<table class='es-wrapper' width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top'>
<tr style='border-collapse:collapse'>
<td valign='top' style='padding:0;Margin:0'>
<table class='es-content' cellspacing='0' cellpadding='0' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%'>
<tr style='border-collapse:collapse'>
<td align='center' style='padding:0;Margin:0'>
<table class='es-content-body' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px' cellspacing='0' cellpadding='0' bgcolor='transparent' align='center'>
<tr style='border-collapse:collapse'>
<td style='padding:0;Margin:0;padding-top:25px;background-position:center top' align='left'>
<table width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
<tr style='border-collapse:collapse'>
<td valign='top' align='center' style='padding:0;Margin:0;width:600px'>
<table width='100%' cellspacing='0' cellpadding='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
<tr style='border-collapse:collapse'>
<td align='center' style='padding:0;Margin:0;font-size:0'><a target='_blank' href='https://domcord.dommioss.fr/' style='-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#2980D9;font-size:14px'><img class='adapt-img' src='themes/uploaded/favicon.ico' alt style='display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic' width='600'></a></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
<tr style='border-collapse:collapse'>
<td style='padding:0;Margin:0;background-position:center bottom' align='left'>
<table width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
<tr style='border-collapse:collapse'>
<td valign='top' align='center' style='padding:0;Margin:0;width:600px'>
<table style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-position:center bottom;background-color:#ffffff' width='100%' cellspacing='0' cellpadding='0' bgcolor='#ffffff' role='presentation'>
<tr style='border-collapse:collapse'>
<td class='es-m-txt-l' bgcolor='transparent' align='left' style='Margin:0;padding-bottom:5px;padding-top:10px;padding-left:20px;padding-right:20px'><h3 style='Margin:0;line-height:24px;mso-line-height-rule:exactly;font-family:roboto, 'helvetica neue', helvetica, arial, sans-serif;font-size:20px;font-style:normal;font-weight:bold;color:#2980d9'>Dear " . $username . ",</h3></td>
</tr>
<tr style='border-collapse:collapse'>
<td bgcolor='transparent' align='left' style='padding:0;Margin:0;padding-top:10px;padding-left:20px;padding-right:20px'><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:roboto, 'helvetica neue', helvetica, arial, sans-serif;line-height:21px;color:#666666;font-size:14px'>We are so glad to meet you ! Thanks to register into our forum.</p></td>
</tr>
<tr style='border-collapse:collapse'>
<td bgcolor='transparent' align='left' style='padding:0;Margin:0;padding-top:5px;padding-left:20px;padding-right:20px'><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:roboto, 'helvetica neue', helvetica, arial, sans-serif;line-height:21px;color:#666666;font-size:14px'>To be able to connect, please verify your email address by clicking on the button below.</p></td>
</tr>
<tr style='border-collapse:collapse'>
<td bgcolor='transparent' align='left' style='Margin:0;padding-top:5px;padding-bottom:5px;padding-left:20px;padding-right:20px'><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:roboto, 'helvetica neue', helvetica, arial, sans-serif;line-height:21px;color:#666666;font-size:14px'>We have put the connection information at the bottom of this email. If it isn't you, ignore this email.</p></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
<tr style='border-collapse:collapse'>
<td style='padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px;background-color:#ffffff' bgcolor='#ffffff' align='left'>
<!--[if mso]><table style='width:560px' cellpadding='0' cellspacing='0'><tr><td style='width:270px' valign='top'><![endif]-->
<table class='es-left' cellspacing='0' cellpadding='0' align='left' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left'>
<tr style='border-collapse:collapse'>
<td class='es-m-p20b' align='left' style='padding:0;Margin:0;width:270px'>
<table width='100%' cellspacing='0' cellpadding='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
<tr style='border-collapse:collapse'>
<td align='right' style='padding:10px;Margin:0'><a href='" . $link . "'>" . $link . "</a></td>
</tr>
</table></td>
</tr>
</table>
<!--[if mso]></td></tr></table><![endif]--></td>
</tr>
<tr style='border-collapse:collapse'>
<td style='padding:0;Margin:0;background-position:center bottom' align='left'>
<table width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
<tr style='border-collapse:collapse'>
<td valign='top' align='center' style='padding:0;Margin:0;width:600px'>
<table style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:separate;border-spacing:0px;background-position:center bottom;background-color:#ffffff;border-radius:0px 0px 5px 5px' width='100%' cellspacing='0' cellpadding='0' bgcolor='#ffffff' role='presentation'>
<tr style='border-collapse:collapse'>
<td height='32' align='center' style='padding:0;Margin:0'></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table>
<table class='es-content' cellspacing='0' cellpadding='0' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%'>
<tr style='border-collapse:collapse'>
<td align='center' style='padding:0;Margin:0'>
<table class='es-content-body' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px' cellspacing='0' cellpadding='0' bgcolor='transparent' align='center'>
<tr style='border-collapse:collapse'>
<td style='padding:0;Margin:0;padding-top:20px;padding-bottom:20px;background-position:center bottom' align='left'>
<table width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
<tr style='border-collapse:collapse'>
<td align='left' style='padding:0;Margin:0;width:600px'>
<table style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:separate;border-spacing:0px;background-color:#ffffff;border-radius:5px 5px 0px 0px' width='100%' cellspacing='0' cellpadding='0' bgcolor='#ffffff' role='presentation'>
<tr style='border-collapse:collapse'>
<td style='padding:0;Margin:0'>
<table class='es-table-not-adapt' cellspacing='0' cellpadding='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
<tr style='border-collapse:collapse'>
<td valign='top' align='left' style='Margin:0;padding-bottom:5px;padding-top:10px;padding-right:10px;padding-left:20px;font-size:0'><img src='https://lvhhrt.stripocdn.email/content/guids/CABINET_b748f68723c08ea6110c059c05f4df42/images/48681566985721743.png' alt style='display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic' width='18'></td>
<td align='left' style='padding:0;Margin:0'>
<table width='100%' cellspacing='0' cellpadding='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
<tr style='border-collapse:collapse'>
<td align='center' style='padding:0;Margin:0;padding-top:5px;padding-bottom:5px'><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:roboto, 'helvetica neue', helvetica, arial, sans-serif;line-height:17px;color:#666666;font-size:14px'><font><font color='#333333' style='font-size:15px'>Register informations</font><br></font></p>
<div style='text-align:center'>
<font><font color='#808080' style='font-size:13px'>It's not you ? Ignore this mail</font></font>
</div><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:roboto, 'helvetica neue', helvetica, arial, sans-serif;line-height:21px;color:#666666;font-size:14px'></p></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
<tr style='border-collapse:collapse'>
<td align='center' style='padding:20px;Margin:0;font-size:0'>
<table border='0' width='100%' height='100%' cellpadding='0' cellspacing='0' role='presentation' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px'>
<tr style='border-collapse:collapse'>
<td style='padding:0;Margin:0;border-bottom:1px solid #cccccc;background:none;height:1px;width:100%;margin:0px'></td>
</tr>
</table></td>
</tr>
<tr style='border-collapse:collapse'>
<td align='center' style='padding:0;Margin:0'><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:roboto, 'helvetica neue', helvetica, arial, sans-serif;line-height:21px;color:#666666;font-size:14px'>IP Adress: " . $_SERVER['REMOTE_ADDR'] . "<br>Email Adress: " . $mail . "</p></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table>
<table class='es-footer' cellspacing='0' cellpadding='0' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top'>
<tr style='border-collapse:collapse'>
<td align='center' style='padding:0;Margin:0'>
<table class='es-footer-body' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px' cellspacing='0' cellpadding='0' bgcolor='#FFFFFF' align='center'>
<tr style='border-collapse:collapse'>
<td style='Margin:0;padding-top:5px;padding-bottom:20px;padding-left:20px;padding-right:20px;background-position:center bottom;background-color:transparent' bgcolor='transparent' align='left'>
<!--[if mso]><table style='width:560px' cellpadding='0' cellspacing='0'><tr><td style='width:270px' valign='top'><![endif]-->
<table class='es-left' cellspacing='0' cellpadding='0' align='left' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left'>
<tr style='border-collapse:collapse'>
<td valign='top' align='center' style='padding:0;Margin:0;width:270px'>
<table style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-position:center top' width='100%' cellspacing='0' cellpadding='0' role='presentation'>
<tr style='border-collapse:collapse'>
<td class='es-m-txt-c' align='left' style='padding:0;Margin:0;padding-top:5px;padding-bottom:15px'><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:roboto, 'helvetica neue', helvetica, arial, sans-serif;line-height:21px;color:#EFEFEF;font-size:14px'>This email was sent automatically. Please do not reply.</p></td>
</tr>
</table></td>
</tr>
</table>
<!--[if mso]></td><td style='width:20px'></td><td style='width:270px' valign='top'><![endif]-->
<table class='es-right' cellspacing='0' cellpadding='0' align='right' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right'>
<tr style='border-collapse:collapse'>
<td align='left' style='padding:0;Margin:0;width:270px'>
<table style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-position:center top' width='100%' cellspacing='0' cellpadding='0' role='presentation'>
<tr style='border-collapse:collapse'>
<td class='es-m-txt-c' align='center' style='padding:0;Margin:0'><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:roboto, 'helvetica neue', helvetica, arial, sans-serif;line-height:21px;color:#EFEFEF;font-size:14px'><strong>&nbsp;2021&nbsp;© DomCord<br>Your Forum Solution</strong></p></td>
</tr>
</table></td>
</tr>
</table>
<!--[if mso]></td></tr></table><![endif]--></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table>
</div>
</body>
</html>";*/

                            // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
                            $headers[] = 'MIME-Version: 1.0';
                            $headers[] = 'Content-type: text/html; charset=iso-8859-1';

                            // En-têtes additionnels

                            // Envoi
                            // mail($to, $subject, $message, implode("\r\n", $headers));

                        } else {

                            $error = "<div class='alert alert-danger'><b><i class='fas fa-exclamation-circle text-danger'></i></b> Passwords does not match !</div>";
                        }
                    } else {

                        $error = "<div class='alert alert-danger'><b><i class='fas fa-exclamation-circle text-danger'></i></b> You have reached the limit of accounts creatable by ip address</div>";
                    }
                } else {

                    $error = "<div class='alert alert-danger'><b><i class='fas fa-exclamation-circle text-danger'></i></b> This email is already used by another user.</div>";
                }
            } else {

                $error = "<div class='alert alert-danger'><b><i class='fas fa-exclamation-circle text-danger'></i></b> Invalid email adress</div>";
            }
        } else {

            $error = "<div class='alert alert-danger'><b><i class='fas fa-exclamation-circle text-danger'></i></b> Your password must contains more then 5 characters (Currently " . $passLenght . ")</div>";
        }
    } else {

        $error = "<div class='alert alert-danger'><b><i class='fas fa-exclamation-circle text-danger'></i></b> Please complete all required files</div>";
    }
}

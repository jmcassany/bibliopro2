<?php
require_once (dirname(__FILE__) . '/PHPmailer/class.phpmailer.php');

// La variable $to pot tenir els seguents valors
// 'correu' -> s'envia a l'adreça passada
// array('correu', 'correu') -> s'envia a totes les adreçes del array
// array('name' => 'nom', 'email' => 'correu') -> s'envia a totes les adreçes del array, afegint el literal del nom
function sendMail($to, $subject, $body, $from = '', $adjunts = null, $html = false, $bcc = null) {
    global $mail_sendtype, $mail_port, $mail_host, $mail_SMTPAuth;
    global $mail_username, $mail_password, $mail_hostName, $mail_defaultFrom;
    global $mail_html, $mail_encode;

    $mail = new PHPMailer();

    if ($mail_sendtype == null || $mail_sendtype == 'none') {
        return true;
    }

    if ($mail_sendtype == 'smtp') {
        $mail->Mailer = 'smtp';
        $mail->PluginDir = dirname(__FILE__) . '/PHPmailer/';

        if ($mail_port != null) {
            $mail->Port = $mail_port;
        }

        if ($mail_host != null) {
            $mail->Host = $mail_host;
        } else {
            return false;
        }

        if ($mail_SMTPAuth) {
            $mail->SMTPAuth = true;

            if ($mail_username != null && $mail_password != null) {
                $mail->Username = $mail_username;
                $mail->Password = $mail_password;
            } else {
                return false;
            }
        }
    } else {
        $mail->Mailer = 'mail';
    }
    $mail->CharSet = $mail_encode;

    $from = ($from != '') ? $from : $mail_defaultFrom;
    preg_match_all("/([^<]+)<*([^>]*)>*/",$from,$out, PREG_PATTERN_ORDER);
    if ($out[2][0]=="") {
        $mail->From = $from;
        $mail->Sender = $from;
        $mail->FromName = '';
    } else {
        $mail->From = $out[2][0];
        $mail->Sender = $out[2][0];
        $mail->FromName = $out[1][0];
    }
    /*
    $mail->From = $from;
    $mail->Sender = $from;
    $mail->FromName = '';
    */

    if (is_array($to)) {
        foreach ($to as $value) {
            if (is_array($value)) {
                $name = '';
                if (isset($value['name'])) {
                    $name = $value['name'];
                }
                if (isset($value['email'])) {
                    $mail->AddAddress($value['email'], $name);
                }
            }
            else {
                $mail->AddAddress($value);
            }
        }
    } else {
        $mail->AddAddress($to);
    }

	if ($bcc != null) {
		if (is_array($bcc)) {
			foreach ($bcc as $value) {
				if (is_array($value)) {
					$name = '';
					if (isset($value['name'])) {
						$name = $value['name'];
					}
					if (isset($value['email'])) {
						$mail->AddBCC($value['email'], $name);
					}
				}
				else {
					$mail->AddBCC($value);
				}
			}
		}
		else {
			$mail->AddBCC($bcc);
		}
	}

    if ($mail_encode != 'utf-8') {
        $mail->Subject = iconv('utf-8', $mail_encode, $subject);
    }
    else {
        $mail->Subject = $subject;
    }

    $mail->IsHTML($html);
    if ($mail_encode != 'utf-8') {
        $body = iconv('utf-8', $mail_encode, $body);
    }

    $mail->Body = $body;
    if ($html) {
        $mail->AltBody = strip_tags($body);
    }

    if ($adjunts != null) {

        foreach($adjunts as $value) {
            $mail->AddAttachment($value['path'], $value['name']);
        }
    }

    /*fer diversos intents per enviar el correu*/
    $i = 1;
    $sended = $mail->Send();

    while ((!$sended) && ($i < 5)) {
        sleep(5);
        $sended = $mail->Send();
        $i++;
    }


    return $sended;
}
?>

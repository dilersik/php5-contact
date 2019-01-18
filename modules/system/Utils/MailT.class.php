<?php

class MailT {

    public static function sendMailerAuth(PHPMailer $PHPMailer) {
        $PHPMailer->isSMTP();
        $PHPMailer->CharSet = 'utf-8';
        $PHPMailer->SMTPAuth = true;
        $PHPMailer->SMTPSecure = PHPMAILER_SMTP_SECURE;
        $PHPMailer->Port = PHPMAILER_PORT;
        $PHPMailer->Host = PHPMAILER_HOST;
        $PHPMailer->Username = PHPMAILER_USERNAME;
        $PHPMailer->Password = PHPMAILER_PASSWORD;
        $PHPMailer->setFrom(PHPMAILER_SETFROM, PHPMAILER_SETFROM_NAME);

        return $PHPMailer->send() ? true : $PHPMailer->ErrorInfo;
    }

    public static function sendMail(PHPMailer $PHPMailer) {
        $PHPMailer->isMail();
        $PHPMailer->CharSet = 'utf-8';
        $PHPMailer->setFrom(PHPMAILER_SETFROM, PHPMAILER_SETFROM_NAME);

        return $PHPMailer->send() ? true : $PHPMailer->ErrorInfo;
    }

}

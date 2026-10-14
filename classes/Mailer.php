<?php

class Mailer{
    public function sendText($recipient, $subject, $message){
        if(!filter_var($recipient, FILTER_VALIDATE_EMAIL)){
            error_log("CampusFind email notification skipped: recipient address is invalid.");
            return false;
        }

        $sender = getenv('CAMPUSFIND_FROM_EMAIL') ?: 'noreply@campusfind.ng';
        if(!filter_var($sender, FILTER_VALIDATE_EMAIL)){
            error_log("CampusFind email notification failed: CAMPUSFIND_FROM_EMAIL is invalid.");
            return false;
        }

        $headers = [
            'From' => $sender,
            'Content-Type' => 'text/plain; charset=UTF-8'
        ];
        $encodedSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';

        if(!function_exists('mail') || !mail($recipient, $encodedSubject, $message, $headers)){
            error_log("CampusFind email notification could not be sent; check the PHP mail configuration.");
            return false;
        }

        return true;
    }
}

<?php

namespace App\Services;

use SendinBlue\Client\Configuration;
use SendinBlue\Client\Api\TransactionalEmailsApi;
use SendinBlue\Client\Model\SendSmtpEmail;
use GuzzleHttp\Client;

class BrevoMailService
{
    public function send($to, $subject, $htmlContent)
    {
        $config = Configuration::getDefaultConfiguration()
            ->setApiKey('api-key', config('services.brevo.api_key'));

        $apiInstance = new TransactionalEmailsApi(new Client(), $config);

        $sendSmtpEmail = new SendSmtpEmail([
            'subject' => $subject,
            'htmlContent' => $htmlContent,
            'sender' => [
                'name' => config('services.brevo.from_name'),
                'email' => config('services.brevo.from_email'),
            ],
            'to' => [['email' => $to]],
        ]);

        try {
            $apiInstance->sendTransacEmail($sendSmtpEmail);
        } catch (\Exception $e) {
            logger()->error("Brevo API Email Error: " . $e->getMessage());
        }
    }
}

<?php

namespace ApiBundle\Service;

use SendGrid;

class EmailService
{
    private $apiKey = '';
    private $twig;

    public function setTwig($twig)
    {
        $this->twig = $twig;
    }

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param $email
     * @param $name
     * @param $registerConfirmToken
     * @return mixed
     */
    public function sendRegisterConfirmEmail($email, $name, $registerConfirmToken)
    {
        echo $this->apiKey;die;
        $from = new SendGrid\Email(null, "no-reply@hgm.com");
        $subject = "Invitation to the HGM Platform";
        $to = new SendGrid\Email(null, $email);

        $appendToUrl = http_build_query(array(
            'registerConfirmToken' => $registerConfirmToken,
            'email' => $email,
        ));

        $html = $this->twig->render('emails/user_register_confirm_email.html.twig',
            array(
                'name' => $name,
                'appendToUrl' => $appendToUrl,
            )
        );

        $content = new SendGrid\Content("text/html", $html);
//        $content = new SendGrid\Content("text/plain", 'Hello Mr. Email');
        $mail = new SendGrid\Mail($from, $subject, $to, $content);

        $sg = new \SendGrid($this->apiKey);

        $response = $sg->client->mail()->send()->post($mail);
        return $response;
    }
}
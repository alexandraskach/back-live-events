<?php

namespace App\Email;

use App\Entity\Users;
use Exception;
use Swift_Message;
use \Twig\Environment;

class Mailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $twig;

    public function __construct(
        \Swift_Mailer $mailer,
        \Twig\Environment $twig
    )
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }


    public function sendConfirmationEmail(Users $user)
    { 
        try{
        $body = $this->twig->render(
            'email/confirmation.html.twig',
            [
                'user' => $user
            ]
        );

        $message = (new Swift_Message('Please confirm your account!'))
            ->setFrom('alexandracuren@gmail.com')
            ->setTo($user->getMail())
            ->setBody($body, 'text/html');

        $this->mailer->send($message);
        
    echo 'Email has been sent.';
    }catch(Exception $e) {
        echo $e->getMessage();
    }
    }
}
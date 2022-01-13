<?php

namespace App\Model\Email;

use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;
use Nette\Mail\SmtpMailer;
use Tracy\Debugger;

final class MailSender
{

    /** @var string */
    private $username;

    /** @var string */
    private $password;

    /** @var string */
    private $host;

    /** @var SmtpMailer */
    private $mailer;

    /**
     * @param string $username
     * @param string $password
     * @param string $host
     */
    public function __construct(string $username, string $password, string $host)
    {
        $this->username = $username;
        $this->password = $password;
        $this->host = $host;
    }

    private function getMailer() : SmtpMailer
    {
        Debugger::barDump( [
            'host' => $this->host,
            'username' => $this->username,
            'password' => $this->password
        ]);

        if (!$this->mailer) {
            $this->mailer = new SmtpMailer(
                [
                    'host' => $this->host,
                    'username' => $this->username,
                    'password' => $this->password
                ]
            );
        }

        return $this->mailer;
    }

    public function send(Message $message) : void
    {
        $this->getMailer()->send($message);
    }
}
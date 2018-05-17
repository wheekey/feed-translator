<?php
/**
 * Created by PhpStorm.
 * User: ermakov
 * Date: 17.05.18
 * Time: 14:07
 */

namespace kymbrik\src\helper;


use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Psr\Log\LoggerInterface;

class Mailer
{
    private $mail;
    private $logger;

    /**
     * Mailer constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->mail = new PHPMailer(true);
        $this->logger = $logger;
    }

    public function send(string $subject, string $message, array $recipients)
    {
        try {
            $this->mail->isSMTP();
            $this->mail->Host = getenv("MAIL_SMTP_HOST");
            $this->mail->SMTPAuth = true;
            $this->mail->Username = getenv("MAIL_USERNAME");
            $this->mail->Password = getenv("MAIL_PASSWORD");
            $this->mail->Port = getenv("MAIL_SMTP_PORT");
            $this->mail->SMTPSecure = getenv("MAIL_SMTP_SECURE");
            $this->mail->SMTPAutoTLS = false;
            $this->mail->CharSet = 'UTF-8';
            $this->mail->setFrom(getenv("MAIL_FROM"), getenv("MAIL_FROM_NAME"));
            foreach ($recipients as $key => $recipient) {
                $this->mail->addAddress($recipient);
            }
            $this->mail->Subject = $subject;
            $this->mail->Body = $message;
            $this->mail->send();
            $this->logger->info("Сообщение отправлено");
        } catch (Exception $ex) {
            $this->logger->error($ex);
        }

    }

}
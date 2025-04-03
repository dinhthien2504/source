<?php
namespace app\mail;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use app\configs\MailerConfig;
class Mailer
{
    private $mail;
    private $config;

    public function __construct()
    {
        $this->config = new MailerConfig;
        $this->config = $this->config::getConfig();
        $this->mail = new PHPMailer(true);

        try {
            // Cấu hình SMTP
            $this->mail->isSMTP();
            $this->mail->Host = $this->config['host'];
            $this->mail->SMTPAuth = true;
            $this->mail->Username = $this->config['username'];
            $this->mail->Password = $this->config['password'];
            $this->mail->Port = $this->config['port'];
            $this->mail->setFrom($this->config['from_email'], $this->config['from_name']);
        } catch (Exception $e) {
            die("Mailer Error: " . $e->getMessage());
        }
    }

    public function sendMail($to, $name, $subject, $body, $cc = [])
    {
        try {
            $this->mail->addAddress($to, $name);

            // Thêm CC nếu có
            if (!empty($cc)) {
                foreach ($cc as $ccEmail) {
                    $this->mail->addCC($ccEmail);
                }
            }

            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;

            return $this->mail->send();
        } catch (Exception $e) {
            return "Không thể gửi email: {$this->mail->ErrorInfo}";
        }
    }
}

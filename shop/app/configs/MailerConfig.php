<?php
namespace app\configs;
class MailerConfig
{
    private $mail;
    public static function getConfig()
    {
        return [
            'host' => 'smtp.gmail.com',
            'username' => 'laptrinh05.net@gmail.com',
            'password' => 'wfiaeejcozztcekp',
            'port' => 587,
            'from_name' => 'Shop',
            'from_email' => 'laptrinh05.net@gmail.com'
        ];

    }
}

<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public string $fromEmail  = '';
    public string $fromName   = '';
    public string $recipients = '';

    public string $userAgent  = 'CodeIgniter';
    public string $protocol   = 'smtp';
    public string $mailPath   = '/usr/sbin/sendmail';

    public string $SMTPHost   = '';
    public string $SMTPUser   = '';
    public string $SMTPPass   = '';
    public int    $SMTPPort   = 587;
    public string $SMTPCrypto = 'tls';

    public int  $SMTPTimeout  = 10;
    public bool $SMTPKeepAlive = false;

    public bool   $wordWrap   = true;
    public int    $wrapChars  = 76;
    public string $mailType   = 'html';
    public string $charset    = 'UTF-8';
    public bool   $validate   = true;

    public int    $priority   = 3;
    public string $CRLF       = "\r\n";
    public string $newline    = "\r\n";

    public bool   $BCCBatchMode = false;
    public int    $BCCBatchSize = 200;
    public bool   $DSN          = false;

    public function __construct()
    {
        $this->fromEmail  = env('EMAIL_FROM');
        $this->fromName   = env('EMAIL_FROM_NAME');
        $this->SMTPHost   = env('EMAIL_HOST');
        $this->SMTPUser   = env('EMAIL_USER');
        $this->SMTPPass   = env('EMAIL_PASS');
        $this->SMTPPort   = (int) env('EMAIL_PORT');
        $this->SMTPCrypto = env('EMAIL_CRYPTO');
    }
}

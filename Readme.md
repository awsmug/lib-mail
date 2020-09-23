# Awesome Lib Mail

Easy and clean mail creation and transportation.

![](https://github.com/awsmug/lib-mail/workflows/PHPUnit/badge.svg)

Version 1.0.0-beta-1

This little library allows you to create email objects easy sent by a selected transporter (PHP mail function, WordPress, etc.).

## Example

```php
<?php

use AWSM\LibMail\Transporter\PhpMail;
use AWSM\LibMail\Mail;
use AWSM\LibMail\MailException;


$mail = new Mail();
$transporter = new PhpMail();

try {
    $mail->addToEmail( 'john.doe@dummy.com' );
    $mail->setFromName( 'Developer' );
    $mail->setFromEmail( 'developer@dummy.com' );
    $mail->setSubject( 'Read my mail!' );
    $mail->setContent( 'Hello John! Greetings from the developer!' );

    $transporter->setMail( $mail );
    $transporter->send();
} catch ( MailException $e ) {
    echo $e->getMessage();
}
```
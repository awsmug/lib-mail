# Awesome Lib Mail

![](https://github.com/awsmug/lib-mail/workflows/PHPUnit/badge.svg)

Version 1.0.0-beta-1

The mail wrapper allows the sending of mails, with its interfaces i

## Example

```php
<?php

use AWSM\Lib_Mail\Transporter\PHP_Mail;
use AWSM\Lib_Mail\Mail;
use AWSM\Lib_Mail\Mail_Exception;


$mail = new Mail();
$transporter = new PHP_Mail();

try {
    $mail->add_to_email( 'john.doe@dummy.com' );
    $mail->set_from_name( 'Developer' );
    $mail->set_from_email( 'developer@dummy.com' );
    $mail->set_subject( 'Read my mail!' );
    $mail->set_content( 'Hello John! Greetings from the developer!' );

    $transporter->set_mail( $mail );
    $transporter->send();
} catch ( Mail_Exception $e ) {
    echo $e->getMessage();
}
```
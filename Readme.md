# Awesome Mail-Wrapper

![](https://github.com/awsmug/mail-wrapper/workflows/PHPUnit/badge.svg)

Version 1.0.0-beta-1

The mail wrapper allows the sending of mails, independent of the used system. 
In this case, the drivers used for this are responsible for sending with the correct mailing functions.

## Use of the mail wrapper

First create an email object and add data for email.

```php
<?php

use awsm\Mail_Wrapper\Mail;

$mail = new Mail();
```

Then the functions from the mail class can be used.

```php
<?php

use awsm\Mail_Wrapper\Dispatcher\PHP_Mail;
use awsm\Mail_Wrapper\Mail;
use awsm\Mail_Wrapper\Mail_Exception;


$mail = new Mail();
$dispatcher = new PHP_Mail();

try {
    $mail->add_to_email( 'john.doe@dummy.com' );
    $mail->set_from_name( 'Developer' );
    $mail->set_from_email( 'developer@dummy.com' );
    $mail->set_subject( 'Read my mail!' );
    $mail->set_content( 'Hello John! Greetings from the developer!' );

    $dispatcher->set_mail( $mail );
    $dispatcher->send();       
} catch ( Mail_Exception $e ) {
    echo $e->getMessage();
}
```
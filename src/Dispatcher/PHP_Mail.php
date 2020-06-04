<?php

namespace awsm\Mail_Wrapper\Dispatcher;

use awsm\Mail_Wrapper\Mail_Dispatcher_Trait;
use awsm\Mail_Wrapper\Mail_Exception;
use awsm\Mail_Wrapper\Mail_Dispatcher_Interface;

/**
 * Class PHP_Mail.
 *
 * @package awsm\Mail_Wrapper\Dispatcher
 *
 * @since 1.0.0
 */
class PHP_Mail implements Mail_Dispatcher_Interface {
	use Mail_Dispatcher_Trait;

	/**
	 * Send Mail.
	 *
	 * @return bool True if sent, false if not.
	 *
	 * @throws Mail_Exception Error on sending mail.
	 *
	 * @since 1.0.0
	 */
	public function send() : bool {
		$to = implode( ',', $this->mail->get_to_emails() );

		if( mail( $to, $this->mail->get_subject(), $this->mail->get_body(), $this->mail->get_header() ) ) {
			return true;
		}

		$this->errors[] = 'Could not send email with PHP mail function.';

		return false;
	}
}
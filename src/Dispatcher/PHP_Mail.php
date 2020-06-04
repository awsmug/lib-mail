<?php

namespace AWSM\Lib_Mail\Dispatcher;

use AWSM\Lib_Mail\Model\Mail_Dispatcher_Trait;
use AWSM\Lib_Mail\Model\Mail_Dispatcher_Interface;
use AWSM\Lib_Mail\Mail_Exception;

/**
 * Class PHP_Mail.
 *
 * @package AWSM\Lib_Mail\Dispatcher
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
		$to_emails = implode( ',', $this->mail->get_to_emails() );

		if( mail( $to_emails, $this->mail->get_subject(), $this->mail->get_body(), $this->mail->get_header() ) ) {
			return true;
		}

		$this->errors[] = 'Could not send email with PHP mail function.';

		return false;
	}
}
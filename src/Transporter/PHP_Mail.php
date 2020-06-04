<?php

namespace AWSM\Lib_Mail\Transporter;

use AWSM\Lib_Mail\Model\Mail_Transporter_Trait;
use AWSM\Lib_Mail\Model\Mail_Transporter_Interface;
use AWSM\Lib_Mail\Mail_Exception;

/**
 * Class PHP_Mail.
 *
 * @package AWSM\Lib_Mail\Transporter
 *
 * @since 1.0.0
 */
class PHP_Mail implements Mail_Transporter_Interface {
	use Mail_Transporter_Trait;

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
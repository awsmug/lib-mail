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
	 * @throws Mail_Exception Error on sending mail with PHP mail function.
	 *
	 * @since 1.0.0
	 */
	public function send(): void {
		$to_emails = implode( ',', $this->mail->get_to_emails() );

		if ( ! mail( $to_emails, $this->mail->get_subject(), $this->mail->get_body(), $this->mail->get_header() ) ) {
			throw new Mail_Exception( 'Could not send email with PHP mail function.' );
		}
	}
}
<?php

namespace awsm\Mail_Wrapper\Driver;

use awsm\Mail_Wrapper\Mail_Dispatcher_Interface;
use awsm\Mail_Wrapper\Mail_Dispatcher_Trait;
use awsm\Mail_Wrapper\Mail_Exception;

/**
 * Class WordPress.
 *
 * @package awsm\Mail_Wrapper\Driver
 *
 * @since 1.0.0
 */
class WordPress implements Mail_Dispatcher_Interface {
	use Mail_Dispatcher_Trait;

	/**
	 * Send mail.
	 *
	 * @return bool
	 *
	 * @throws Mail_Exception
	 *
	 * @since 1.0.0
	 */
	public function send() : bool {
		if ( ! function_exists( 'wp_mail' ) ) {
			throw new Mail_Exception( 'wp_mail function does not exists. Make sure you working on a WordPress installation.' );
		}

		if( wp_mail( $this->mail->get_to_emails(), $this->mail->get_subject(), $this->mail->get_content(), $this->mail->get_header(), $this->mail->get_attachments() ) ) {
			return true;
		}

		$this->errors[] = 'Could not send email with wp_mail function.';

		return false;
	}
}
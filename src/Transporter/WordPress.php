<?php

namespace AWSM\Lib_Mail\Transporter;

use AWSM\Lib_Mail\Model\Mail_Transporter_Trait;
use AWSM\Lib_Mail\Model\Mail_Transporter_Interface;
use AWSM\Lib_Mail\Mail_Exception;

/**
 * Class WordPress.
 *
 * @package AWSM\Lib_Mail\Driver
 *
 * @since 1.0.0
 */
class WordPress implements Mail_Transporter_Interface {
	use Mail_Transporter_Trait;

	/**
	 * Send mail.
	 *
	 * @throws Mail_Exception Error on sending mail with wp_mail function.
	 *
	 * @since 1.0.0
	 */
	public function send(): void {
		if ( ! function_exists( 'wp_mail' ) ) {
			throw new Mail_Exception( 'wp_mail function does not exists. Make sure you working on a WordPress installation.' );
		}

		if ( ! wp_mail( $this->mail->get_to_emails(), $this->mail->get_subject(), $this->mail->get_content(), $this->mail->get_header( false ), $this->mail->get_attachments() ) ) {
			throw new Mail_Exception( 'Could not send email with wp_mail function.' );
		}
	}
}
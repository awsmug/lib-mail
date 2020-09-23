<?php

namespace AWSM\LibMail\Transporter;

use AWSM\LibMail\Model\MailTransporterTrait;
use AWSM\LibMail\Model\MailTransporterInterface;
use AWSM\LibMail\MailException;

/**
 * Class WordPress.
 *
 * @package AWSM\LibMail\Driver
 *
 * @since 1.0.0
 */
class WordPress implements MailTransporterInterface {
	use MailTransporterTrait;

	/**
	 * Send mail.
	 *
	 * @throws MailException Error on sending mail with wp_mail function.
	 *
	 * @since 1.0.0
	 */
	public function send(): void {
		if ( ! function_exists( 'wp_mail' ) ) {
			throw new MailException( 'wp_mail function does not exists. Make sure you working on a WordPress installation.' );
		}

		if ( ! wp_mail( $this->mail->toEmails(), $this->mail->subject(), $this->mail->content(), $this->mail->header( false ), $this->mail->attachments() ) ) {
			throw new MailException( 'Could not send email with wp_mail function.' );
		}
	}
}
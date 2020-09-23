<?php

namespace AWSM\LibMail\Transporter;

use AWSM\LibMail\Model\MailTransporterTrait;
use AWSM\LibMail\Model\MailTransporterInterface;
use AWSM\LibMail\MailException;

/**
 * Class PhpMail.
 *
 * @package AWSM\LibMail\Transporter
 *
 * @since 1.0.0
 */
class PhpMail implements MailTransporterInterface {
	use MailTransporterTrait;

	/**
	 * Send Mail.
	 *
	 * @throws MailException Error on sending mail with PHP mail function.
	 *
	 * @since 1.0.0
	 */
	public function send(): void {
		$toEmails = implode( ',', $this->mail->toEmails() );

		if ( ! mail( $toEmails, $this->mail->subject(), $this->mail->body(), $this->mail->header() ) ) {
			throw new MailException( 'Could not send email with PHP mail function.' );
		}
	}
}
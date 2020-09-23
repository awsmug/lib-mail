<?php

namespace AWSM\LibMail\Model;

/**
 * Interface MailTransporterInterface
 *
 * @package AWSM\LibMail
 *
 * @since 1.0.0
 */
interface MailTransporterInterface {
	/**
	 * Set Mail.
	 *
	 * @param MailInterface $mail Mail based on MailInterface.
	 *
	 * @since 1.0.0
	 */
	public function setMail( MailInterface $mail ) : void;

	/**
	 * Send mail.
	 *
	 * @return bool True if sent, false if not.
	 *
	 * @since 1.0.0
	 */
	public function send() : void;
}
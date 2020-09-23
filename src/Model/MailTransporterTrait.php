<?php

namespace AWSM\LibMail\Model;

trait MailTransporterTrait {
	/**
	 * Mail address.
	 *
	 * @var MailInterface
	 *
	 * @since 1.0.0
	 */
	private $mail;

	/**
	 * Errors.
	 *
	 * @var array
	 *
	 * @since 1.0.0
	 */
	private $errors = array();

	/**
	 * Set mail object.
	 *
	 * @param MailInterface $mail Mail object.
	 *
	 * @since 1.0.0
	 */
	public function setMail( MailInterface $mail ) : void {
		$this->mail = $mail;
	}
}
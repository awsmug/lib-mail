<?php

namespace AWSM\Lib_Mail\Model;

/**
 * Interface Mail_Transporter_Interface
 *
 * @package AWSM\Lib_Mail
 *
 * @since 1.0.0
 */
interface Mail_Transporter_Interface {
	/**
	 * Set Mail.
	 *
	 * @param Mail_Interface $mail Mail based on Mail_Interface.
	 *
	 * @since 1.0.0
	 */
	public function set_mail( Mail_Interface $mail ) : void;

	/**
	 * Send mail.
	 *
	 * @return bool True if sent, false if not.
	 *
	 * @since 1.0.0
	 */
	public function send() : void;
}
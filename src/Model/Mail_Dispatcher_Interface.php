<?php

namespace awsm\Mail_Wrapper\Model;

/**
 * Interface Mail_Dispatcher_Interface
 *
 * @package awsm\Mail_Wrapper
 *
 * @since 1.0.0
 */
interface Mail_Dispatcher_Interface {
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
	public function send() : bool;

	/**
	 * Get errors on sending email.
	 *
	 * @return array
	 *
	 * @since 1.0.0
	 */
	public function get_errors() : array;
}
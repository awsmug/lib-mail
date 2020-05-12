<?php

namespace awsm\Mail_Wrapper\Driver;

use awsm\Mail_Wrapper\Mail;

/**
 * Interface Mail_Wrapper.
 *
 * @package awsm\Mail_Wrapper
 *
 * @since 1.0.0
 */
interface Driver_Interface {
	/**
	 * Set Mail.
	 *
	 * @param Mail $mail Mail object.
	 *
	 * @return mixed
	 */
	public function set_mail( Mail $mail );

	/**
	 * Send mail.
	 *
	 * @return bool
	 *
	 * @since 1.0.0
	 */
	public function send() : bool;
}
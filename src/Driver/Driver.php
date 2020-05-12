<?php

namespace awsm\Mail_Wrapper\Driver;

use awsm\Mail_Wrapper\Mail;

/**
 * Mailer parent class.
 *
 * @package awsm\Mail_Wrapper\Mailer
 *
 * @since 1.0.0
 */
abstract class Driver implements Driver_Interface {
	/**
	 * Mail object.
	 *
	 * @var Mail
	 *
	 * @since 1.0.0
	 */
	protected $mail;
}
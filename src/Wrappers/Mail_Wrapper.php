<?php

namespace awsm\Mail_Wrapper\Wrappers;

/**
 * Interface Mail_Wrapper.
 *
 * @package awsm\Mail_Wrapper
 *
 * @since 1.0.0
 */
interface Mail_Wrapper {
	/**
	 * Send mail.
	 *
	 * @return bool
	 *
	 * @since 1.0.0
	 */
	public function send();
}
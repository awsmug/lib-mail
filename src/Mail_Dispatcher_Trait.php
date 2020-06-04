<?php

namespace awsm\Mail_Wrapper;

trait Mail_Dispatcher_Trait {
	/**
	 * Mail address.
	 *
	 * @var Mail_Interface
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
	 * @param Mail_Interface $mail Mail object.
	 *
	 * @since 1.0.0
	 */
	public function set_mail( Mail_Interface $mail ) : void {
		$this->mail = $mail;
	}

	/**
	 * Get errors.
	 *
	 * @return array
	 *
	 * @since 1.0.0
	 */
	public function get_errors(): array {
		return $this->errors;
	}
}
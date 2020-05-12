<?php

namespace awsm\Mail_Wrapper;

use awsm\Mail_Wrapper\Driver\Driver as Mail_Driver;

/**
 * Class Mail
 *
 * @package awsm\Mail_Wrapper
 *
 * @since 1.0.0
 */
class Mail {
	/**
	 * From email.
	 *
	 * @var string $from_email
	 *
	 * @since 1.0.0
	 */
	private $from_email;

	/**
	 * From name.
	 *
	 * @var string $from_email
	 *
	 * @since 1.0.0
	 */
	private $from_name;

	/**
	 * To email adresses.
	 *
	 * @var array $to_emails
	 *
	 * @since 1.0.0
	 */
	private $to_emails = array();

	/**
	 * CC email adresses.
	 *
	 * @var array $cc_emails
	 *
	 * @since 1.0.0
	 */
	private $cc_emails = array();

	/**
	 * BCC email adresses.
	 *
	 * @var array $bcc_emails
	 *
	 * @since 1.0.0
	 */
	private $bcc_emails = array();

	/**
	 * Email attachments.
	 *
	 * @var array $to_emails
	 *
	 * @since 1.0.0
	 */
	private $attachements = array();

	/**
	 * Mail driver.
	 *
	 * @var Mail_Driver $mail_driver;
	 *
	 * @since 1.0.0
	 */
	private $mail_driver;

	/**
	 * Mail constructor.
	 *
	 * @param Mail_Driver $mail_driver Mail driver object (PHP or WordPress).
	 *
	 * @since 1.0.0
	 */
	public function __construct( Mail_Driver $mail_driver ) {
		$this->mail_driver = $mail_driver;
	}

	/**
	 * Get mail wrapper.
	 *
	 * @return Mail_Driver
	 *
	 * @since 1.0.0
	 */
	public function get_driver() : Mail_Driver {
		return $this->mail_driver;
	}

	/**
	 * Set from email.
	 *
	 * @param string $email Email address.
	 *
	 * @since 1.0.0
	 */
	public function set_from_email( string $email ) {
		if( ! $this->validate_email( $email ) ) {
			throw new Exception ( 'Invalid email-address.', 1 );
		}

		$this->from_email = $email;
	}

	/**
	 * Get from email.
	 *
	 * @return string Email address.
	 *
	 * @since 1.0.0
	 */
	public function get_from_email() : string {
		return $this->from_email;
	}

	/**
	 * Set from name.
	 *
	 * @param string $name From name.
	 *
	 * @since 1.0.0
	 */
	public function set_from_name( string $name ) {
		$this->from_name = $name;
	}

	/**
	 * Get from name.
	 *
	 * @return string From name.
	 *
	 * @since 1.0.0
	 */
	public function get_from_name() : string {
		return $this->from_name;
	}

	/**
	 * Add to email addresses.
	 *
	 * @param string $email
	 * @param int $position
	 *
	 * @return bool
	 * @throws Exception
	 *
	 * @since 1.0.0
	 */
	public function add_to_email( string $email, int $position = -1 ) {
		return $this->add_email_to_array( $email, $this->to_emails, $position );
	}

	public function get_to_emails() : array {
		return $this->to_emails;
	}

	private function add_email_to_array( string $email, array &$array, int $position = -1 ) : bool {
		if( ! $this->validate_email( $email ) ) {
			throw new Exception ( 'Invalid email-address.', 1 );
		}

		if( -1 === $position ) {
			$array[] = $email;
			return true;
		}

		$array[ $position ] = $email;

		return true;
	}

	/**
	 * Send Mail.
	 *
	 * @return bool
	 *
	 * @since 1.0.0
	 */
	public function send() : bool {
		$this->mail_driver->set_mail( $this );
		return $this->mail_driver->send();
	}

	/**
	 * Validate email address.
	 *
	 * @param string $email Email address.
	 *
	 * @return bool True if email is valid, false if not.
	 */
	private function validate_email( $email ) : bool {
		if( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
			return false;
		}

		return true;
	}
}
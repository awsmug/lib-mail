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
	 * Subject of mail.
	 *
	 * @var string $subject
	 *
	 * @since 1.0.0
	 */
	private $subject;

	/**
	 * Content of mail.
	 *
	 * @var string $content
	 *
	 * @since 1.0.0
	 */
	private $content;

	/**
	 * Email attachments.
	 *
	 * @var array $attachements
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
	 * @param string $email    Email address to add.
	 * @param int    $position
	 * @throws Exception
	 *
	 * @since 1.0.0
	 */
	public function add_to_email( string $email, int $position = -1 ) {
		$this->add_email_to_array( $email, $this->to_emails, $position );
	}

	/**
	 * Get to email adresses.
	 *
	 * @return array Email adresses.
	 *
	 * @since 1.0.0
	 */
	public function get_to_emails() : array {
		return $this->to_emails;
	}

	/**
	 * Add CC email addresses.
	 *
	 * @param string $email    Email address to add.
	 * @param int    $position Position in array.
	 * @throws Exception
	 *
	 * @since 1.0.0
	 */
	public function add_cc_email( string $email, int $position = -1 ) {
		$this->add_email_to_array( $email, $this->cc_emails, $position );
	}

	/**
	 * Get CC email adresses.
	 *
	 * @return array Email adresses.
	 *
	 * @since 1.0.0
	 */
	public function get_cc_emails() : array {
		return $this->cc_emails;
	}

	/**
	 * Add BCC email addresses.
	 *
	 * @param string $email    Email address to add.
	 * @param int    $position Position in array.
	 * @throws Exception
	 *
	 * @since 1.0.0
	 */
	public function add_bcc_email( string $email, int $position = -1 ) {
		$this->add_email_to_array( $email, $this->bcc_emails, $position );
	}

	/**
	 * Get BCC email adresses.
	 *
	 * @return array Email adresses.
	 *
	 * @since 1.0.0
	 */
	public function get_bcc_emails() : array {
		return $this->bcc_emails;
	}

	/**
	 * Add email to array.
	 *
	 * @param string $email    Email address to add.
	 * @param array  $array    Array where adress have to be added.
	 * @param int    $position Position in array.
	 *
	 * @throws Exception Invalid email address.
	 *
	 * @since 1.0.0
	 */
	private function add_email_to_array( string $email, array &$array, int $position = -1 ) : void {
		if( ! $this->validate_email( $email ) ) {
			throw new Exception ( 'Invalid email-address.', 1 );
		}

		$this->add_to_array( $email, $array, $position );
	}

	/**
	 * Add value to array.
	 *
	 * @param mixed $content  Content to add.
	 * @param array $array    Array where content have to be added.
	 * @param int   $position Position in array.
	 *
	 * @since 1.0.0
	 */
	private function add_to_array( $content, array &$array, int $position = -1 ) {
		if( -1 === $position ) {
			$array[] = $content;
		}

		$array[ $position ] = $content;
	}

	/**
	 * Set subject.
	 *
	 * @param string $subject
	 *
	 * @since 1.0.0
	 */
	public function set_subject( string $subject ) : void {
		$this->subject = $subject;
	}

	/**
	 * Get subject.
	 *
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public function get_subject() : string {
		return $this->subject;
	}

	/**
	 * Set content.
	 *
	 * @param string $content
	 *
	 * @since 1.0.0
	 */
	public function set_content( string $content ) : void {
		$this->content = $content;
	}

	/**
	 * Get subject.
	 *
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public function get_content() : string {
		return $this->content;
	}

	/**
	 * Add attachment to email.
	 *
	 * @param string $attachment Attachment file (path not url!).
	 *
	 * @throws Exception Invalid email address.
	 *
	 * @since 1.0.0
	 */
	public function add_attachment ( string $attachment ) : void {
		if( ! $this->validate_attachment( $attachment ) ) {
			throw new Exception ( 'Invalid attachment file.', 1 );
		}

		$this->add_to_array( $attachment, $this->attachements );
	}

	/**
	 * Get attachments.
	 *
	 * @return array Attachments.
	 *
	 * @since 1.0.0
	 */
	public function get_attachments() : array {
		return $this->attachements;
	}

	/**
	 * Send Mail.
	 *
	 * @return bool True if sent, false if not.
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
	 *
	 * @since 1.0.0
	 */
	private function validate_email( string $email ) : bool {
		if( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Validate email attachment.
	 *
	 * @param string $attachment Attachment file (path not url!).
	 *
	 * @return bool True if attachment is valid, false if not.
	 *
	 * @since 1.0.0
	 */
	private function validate_attachment( string $attachment ) : bool {
		if( ! file_exists( $attachment ) ) {
			return false;
		}

		return true;
	}
}
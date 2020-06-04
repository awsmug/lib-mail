<?php

namespace awsm\Mail_Wrapper;

/**
 * Trait Mail_Header_Trait.
 *
 * @package awsm\Mail_Wrapper
 *
 * @since 1.0.0
 */
class Mail implements Mail_Interface {
	/**
	 * UID.
	 *
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $uid;

	/**
	 * Mime boundary.
	 *
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $mime_boundary;

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
	 * @var string $subject Mail subject.
	 *
	 * @since 1.0.0
	 */
	private $subject;

	/**
	 * Content of mail.
	 *
	 * @var string $content Mail content.
	 *
	 * @since 1.0.0
	 */
	private $content;

	/**
	 * Email attachments.
	 *
	 * @var array $attachments
	 *
	 * @since 1.0.0
	 */
	private $attachments = array();

	/**
	 * Mail constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->uid           = md5( uniqid( time() ) );
		$this->mime_boundary = "==Multipart_Boundary_x{$this->uid}x";
	}

	/**
	 * Set from email.
	 *
	 * @param string $email Email address.
	 *
	 * @since 1.0.0
	 */
	public function set_from_email( string $email ): void {
		if ( ! $this->validate_email( $email ) ) {
			throw new Mail_Exception ( 'Invalid email-address.', 1 );
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
	public function get_from_email(): string {
		return $this->from_email;
	}

	/**
	 * Set from name.
	 *
	 * @param string $name From name.
	 *
	 * @return Mail Mail object.
	 *
	 * @since 1.0.0
	 */
	public function set_from_name( string $name ): void {
		$this->from_name = $name;
	}

	/**
	 * Get from name.
	 *
	 * @return string From name.
	 *
	 * @since 1.0.0
	 */
	public function get_from_name(): string {
		return $this->from_name;
	}

	/**
	 * Add to email addresses.
	 *
	 * @param string $email Email address to add.
	 * @param int $position
	 *
	 * @throws Mail_Exception
	 *
	 * @since 1.0.0
	 */
	public function add_to_email( string $email, int $position = - 1 ): void {
		$this->add_email_to_array( $email, $this->to_emails, $position );
	}

	/**
	 * Get to email adresses.
	 *
	 * @return array Email adresses.
	 *
	 * @since 1.0.0
	 */
	public function get_to_emails(): array {
		return $this->to_emails;
	}

	/**
	 * Add CC email addresses.
	 *
	 * @param string $email Email address to add.
	 * @param int $position Position in array.
	 *
	 * @return Mail Mail object.
	 *
	 * @throws Mail_Exception
	 *
	 * @since 1.0.0
	 */
	public function add_cc_email( string $email, int $position = - 1 ): void {
		$this->add_email_to_array( $email, $this->cc_emails, $position );
	}

	/**
	 * Get CC email adresses.
	 *
	 * @return array Email adresses.
	 *
	 * @since 1.0.0
	 */
	public function get_cc_emails(): array {
		return $this->cc_emails;
	}

	/**
	 * Add BCC email addresses.
	 *
	 * @param string $email Email address to add.
	 * @param int $position Position in array.
	 *
	 * @throws Mail_Exception Invalid email address.
	 *
	 * @since 1.0.0
	 */
	public function add_bcc_email( string $email, int $position = - 1 ): void {
		$this->add_email_to_array( $email, $this->bcc_emails, $position );
	}

	/**
	 * Get BCC email adresses.
	 *
	 * @return array Email adresses.
	 *
	 * @since 1.0.0
	 */
	public function get_bcc_emails(): array {
		return $this->bcc_emails;
	}

	/**
	 * Set mail subject.
	 *
	 * @param string $subject Mail subject.
	 *
	 * @since 1.0.0
	 */
	public function set_subject( string $subject ): void {
		$this->subject = $subject;
	}

	/**
	 * Get mail subject.
	 *
	 * @return string Mail subject.
	 *
	 * @since 1.0.0
	 */
	public function get_subject(): string {
		return $this->subject;
	}

	/**
	 * Set mail content.
	 *
	 * @param string $content Mail content.
	 *
	 * @since 1.0.0
	 */
	public function set_content( string $content ): void {
		$this->content = $content;
	}

	/**
	 * Get mail content.
	 *
	 * @return string Mail content.
	 *
	 * @since 1.0.0
	 */
	public function get_content(): string {
		return $this->content;
	}

	/**
	 * Get mail body.
	 *
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public function get_body(): string {
		$body = "--{$this->mime_boundary}\r\n";
		$body .= "Content-Type: {$this->get_content_type()}; charset=ISO-8859-1\r\n";
		$body .= "Content-Transfer-Encoding: base64\r\n\r\n";
		$body .= chunk_split( base64_encode( $this->content ) );

		if ( count( $this->attachments ) > 0 ) {
			foreach ( $this->attachments as $attachment ) {
				$file_name = basename( $attachment );
				$file_size = filesize( $attachment );

				$body .= "--{$this->mime_boundary}\n";
				$fp   = fopen( $attachment, 'rb' );
				$data = fread( $fp, $file_size );

				fclose( $fp );

				$data = chunk_split( base64_encode( $data ) );

				$body .= "Content-Type: application/octet-stream; name=\"" . $file_name . "\"\n" .
				         "Content-Description: " . $file_name . "\n" .
				         "Content-Disposition: attachment;\n" . " filename=\"" . $file_name . "\"; size=" . $file_size . ";\n" .
				         "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
			}

			$body .= "--{$this->mime_boundary}--";
		}

		return $body;
	}

	/**
	 * Get header.
	 *
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public function get_header(): string {
		$headers = array();

		if ( ! empty( $this->from_name ) && ! empty( $this->from_email ) ) {
			$headers[] = "From: {$this->from_name} <{$this->from_email}>";
		} elseif ( ! empty( $this->from_email ) ) {
			$headers[] = "From: {$this->from_email}";
		}

		if ( count( $this->to_emails ) > 0 ) {
			$this->to_emails = implode( ', ', $this->to_emails );
			$headers[]       = "To: {$this->to_emails}";
		}

		if ( count( $this->cc_emails ) > 0 ) {
			$this->cc_emails = implode( ', ', $this->cc_emails );
			$headers[]       = "Cc: {$this->cc_emails}";
		}

		if ( count( $this->bcc_emails ) > 0 ) {
			$bcc       = implode( ', ', $this->bcc_emails );
			$headers[] = "Bcc: {$this->bcc_emails}";
		}

		if ( count( $this->attachments ) > 0 ) {
			$uid = md5( uniqid( time() ) );

			// Headers for attachment
			$headers[] = 'MIME-Version: 1.0';
			$headers[] = 'Content-Type: multipart/mixed;';
			$headers[] = " boundary=\"{$this->mime_boundary}\"";
		}

		$headers = implode( ' \r\n', $headers );

		return $headers;
	}

	/**
	 * Add attachment to email.
	 *
	 * @param string $attachment Attachment file (path only).
	 *
	 * @return Mail Mail object.
	 *
	 * @throws Mail_Exception Invalid email address.
	 *
	 * @since 1.0.0
	 */
	public function add_attachment( string $attachment ): void {
		if ( ! $this->validate_attachment( $attachment ) ) {
			throw new Mail_Exception ( 'Invalid attachment file.', 1 );
		}

		$this->add_to_array( $attachment, $this->attachments );
	}

	/**
	 * Get attachments.
	 *
	 * @return array Attachments.
	 *
	 * @since 1.0.0
	 */
	public function get_attachments(): array {
		return $this->attachments;
	}

	/**
	 * Set content type.
	 *
	 * @param string $content_type
	 *
	 * @since 1.0.0
	 */
	public function set_content_type( string $content_type ): void {
		$this->content_type = $content_type;
	}

	/**
	 * Get content type.
	 *
	 * @return string Content type.
	 *
	 * @since 1.0.0
	 */
	public function get_content_type(): string {
		if ( ! empty( $this->content_type ) ) {
			return $this->content_type;
		}

		if ( $this->content !== strip_tags( $this->content ) ) {
			return $this->content_type = 'text/html';
		} else {
			return $this->content_type = 'text/plain';
		}
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
	private function validate_email( string $email ): bool {
		if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
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
	private function validate_attachment( string $attachment ): bool {
		if ( ! file_exists( $attachment ) ) {
			return false;
		}

		return true;
	}


	/**
	 * Add email to array.
	 *
	 * @param string $email Email address to add.
	 * @param array $array Array where adress have to be added.
	 * @param int $position Position in array.
	 *
	 * @throws Mail_Exception Invalid email address.
	 *
	 * @since 1.0.0
	 */
	private function add_email_to_array( string $email, array &$array, int $position = - 1 ): void {
		if ( ! $this->validate_email( $email ) ) {
			throw new Mail_Exception ( 'Invalid email-address.', 1 );
		}

		$this->add_to_array( $email, $array, $position );
	}

	/**
	 * Add value to array.
	 *
	 * @param mixed $content Content to add.
	 * @param array $array Array where content have to be added.
	 * @param int $position Position in array.
	 *
	 * @since 1.0.0
	 */
	private function add_to_array( $content, array &$array, int $position = - 1 ) {
		if ( - 1 === $position ) {
			$array[] = $content;
		}

		$array[ $position ] = $content;
	}
}
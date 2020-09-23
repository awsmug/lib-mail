<?php

namespace AWSM\LibMail;

use AWSM\LibMail\Model\MailInterface;

/**
 * Trait Mail_Header_Trait.
 *
 * @package AWSM\LibMail
 *
 * @since 1.0.0
 */
class Mail implements MailInterface {
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
	private $mimeBoundary;

	/**
	 * From email.
	 *
	 * @var string $fromEmail
	 *
	 * @since 1.0.0
	 */
	private $fromEmail;

	/**
	 * From name.
	 *
	 * @var string $fromEmail
	 *
	 * @since 1.0.0
	 */
	private $fromName;

	/**
	 * To email adresses.
	 *
	 * @var array $toEmails
	 *
	 * @since 1.0.0
	 */
	private $toEmails = array();

	/**
	 * CC email adresses.
	 *
	 * @var array $ccEmails
	 *
	 * @since 1.0.0
	 */
	private $ccEmails = array();

	/**
	 * BCC email adresses.
	 *
	 * @var array $bccEmails
	 *
	 * @since 1.0.0
	 */
	private $bccEmails = array();

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
		$this->mimeBoundary = "==Multipart_Boundary_x{$this->uid}x";
	}

	/**
	 * Set from email.
	 *
	 * @param string $email Email address.
	 *
	 * @since 1.0.0
	 */
	public function setFromEmail( string $email ): void {
		if ( ! $this->validateEmail( $email ) ) {
			throw new MailException ( 'Invalid email-address.', 1 );
		}

		$this->fromEmail = $email;
	}

	/**
	 * Get from email.
	 *
	 * @return string Email address.
	 *
	 * @since 1.0.0
	 */
	public function getFromEmail(): string {
		return $this->fromEmail;
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
	public function setFromName( string $name ): void {
		$this->fromName = $name;
	}

	/**
	 * Get from name.
	 *
	 * @return string From name.
	 *
	 * @since 1.0.0
	 */
	public function getFromName(): string {
		return $this->fromName;
	}

	/**
	 * Add to email addresses.
	 *
	 * @param string $email Email address to add.
	 * @param int $position
	 *
	 * @throws MailException
	 *
	 * @since 1.0.0
	 */
	public function addToEmail( string $email, int $position = - 1 ): void {
		$this->addEmailToArray( $email, $this->toEmails, $position );
	}

	/**
	 * Get to email adresses.
	 *
	 * @return array Email adresses.
	 *
	 * @since 1.0.0
	 */
	public function toEmails(): array {
		return $this->toEmails;
	}

	/**
	 * Add CC email addresses.
	 *
	 * @param string $email Email address to add.
	 * @param int $position Position in array.
	 *
	 * @return Mail Mail object.
	 *
	 * @throws MailException
	 *
	 * @since 1.0.0
	 */
	public function addCcEmail( string $email, int $position = - 1 ): void {
		$this->addEmailToArray( $email, $this->ccEmails, $position );
	}

	/**
	 * Get CC email adresses.
	 *
	 * @return array Email adresses.
	 *
	 * @since 1.0.0
	 */
	public function getCcEmails(): array {
		return $this->ccEmails;
	}

	/**
	 * Add BCC email addresses.
	 *
	 * @param string $email Email address to add.
	 * @param int $position Position in array.
	 *
	 * @throws MailException Invalid email address.
	 *
	 * @since 1.0.0
	 */
	public function addBccEmail( string $email, int $position = - 1 ): void {
		$this->addEmailToArray( $email, $this->bccEmails, $position );
	}

	/**
	 * Get BCC email adresses.
	 *
	 * @return array Email adresses.
	 *
	 * @since 1.0.0
	 */
	public function getBccEmails(): array {
		return $this->bccEmails;
	}

	/**
	 * Set mail subject.
	 *
	 * @param string $subject Mail subject.
	 *
	 * @since 1.0.0
	 */
	public function setSubject( string $subject ): void {
		$this->subject = $subject;
	}

	/**
	 * Get mail subject.
	 *
	 * @return string Mail subject.
	 *
	 * @since 1.0.0
	 */
	public function subject(): string {
		return $this->subject;
	}

	/**
	 * Set mail content.
	 *
	 * @param string $content Mail content.
	 *
	 * @since 1.0.0
	 */
	public function setContent( string $content ): void {
		$this->content = $content;
	}

	/**
	 * Get mail content.
	 *
	 * @return string Mail content.
	 *
	 * @since 1.0.0
	 */
	public function content(): string {
		return $this->content;
	}

	/**
	 * Get mail body.
	 *
	 * @param bool $addAttachments True if attachments have to be added, false if not.
	 *
	 * @return string Email body.
	 *
	 * @since 1.0.0
	 */
	public function body( bool $addAttachments = true ) : string {
		$body = "--{$this->mimeBoundary}\r\n";
		$body .= "Content-Type: {$this->contentType()}; charset=ISO-8859-1\r\n";
		$body .= "Content-Transfer-Encoding: base64\r\n\r\n";
		$body .= chunk_split( base64_encode( $this->content ) );

		if ( count( $this->attachments ) > 0 && $addAttachments ) {
			foreach ( $this->attachments as $attachment ) {
				$file_name = basename( $attachment );
				$file_size = filesize( $attachment );

				$body .= "--{$this->mimeBoundary}\n";
				$fp   = fopen( $attachment, 'rb' );
				$data = fread( $fp, $file_size );

				fclose( $fp );

				$data = chunk_split( base64_encode( $data ) );

				$body .= "Content-Type: application/octet-stream; name=\"" . $file_name . "\"\n" .
				         "Content-Description: " . $file_name . "\n" .
				         "Content-Disposition: attachment;\n" . " filename=\"" . $file_name . "\"; size=" . $file_size . ";\n" .
				         "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
			}

			$body .= "--{$this->mimeBoundary}--";
		}

		return $body;
	}

	/**
	 * Get header.
	 *
	 * @param bool $addAttachments True if attachments have to be added, false if not.
	 *
	 * @return string Email Header.
	 *
	 * @since 1.0.0
	 */
	public function header( bool $addAttachments = true ): string {
		$headers = array();

		if ( ! empty( $this->fromName ) && ! empty( $this->fromEmail ) ) {
			$headers[] = "From: {$this->fromName} <{$this->fromEmail}>";
		} elseif ( ! empty( $this->fromEmail ) ) {
			$headers[] = "From: {$this->fromEmail}";
		}

		if ( count( $this->toEmails ) > 0 ) {
			$this->toEmails = implode( ', ', $this->toEmails );
			$headers[]      = "To: {$this->toEmails}";
		}

		if ( count( $this->ccEmails ) > 0 ) {
			$this->ccEmails = implode( ', ', $this->ccEmails );
			$headers[]      = "Cc: {$this->ccEmails}";
		}

		if ( count( $this->bccEmails ) > 0 ) {
			$this->bccEmails = implode( ', ', $this->bccEmails );
			$headers[] = "Bcc: {$this->bccEmails}";
		}

		if ( count( $this->attachments ) > 0 && $addAttachments ) {
			$uid = md5( uniqid( time() ) );

			// Headers for attachment
			$headers[] = 'MIME-Version: 1.0';
			$headers[] = 'Content-Type: multipart/mixed;';
			$headers[] = " boundary=\"{$this->mimeBoundary}\"";
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
	 * @throws MailException Invalid email address.
	 *
	 * @since 1.0.0
	 */
	public function addAttachments( string $attachment ): void {
		if ( ! $this->validateAttachment( $attachment ) ) {
			throw new MailException ( 'Invalid attachment file.', 1 );
		}

		$this->addToArray( $attachment, $this->attachments );
	}

	/**
	 * Get attachments.
	 *
	 * @return array Attachments.
	 *
	 * @since 1.0.0
	 */
	public function attachments(): array {
		return $this->attachments;
	}

	/**
	 * Set content type.
	 *
	 * @param string $contentType
	 *
	 * @since 1.0.0
	 */
	public function setContentType( string $contentType ): void {
		$this->contentType = $contentType;
	}

	/**
	 * Get content type.
	 *
	 * @return string Content type.
	 *
	 * @since 1.0.0
	 */
	public function contentType(): string {
		if ( ! empty( $this->contentType ) ) {
			return $this->contentType;
		}

		if ( $this->content !== strip_tags( $this->content ) ) {
			return $this->contentType = 'text/html';
		} else {
			return $this->contentType = 'text/plain';
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
	private function validateEmail( string $email ): bool {
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
	private function validateAttachment( string $attachment ): bool {
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
	 * @throws MailException Invalid email address.
	 *
	 * @since 1.0.0
	 */
	private function addEmailToArray( string $email, array &$array, int $position = - 1 ): void {
		if ( ! $this->validateEmail( $email ) ) {
			throw new MailException ( 'Invalid email-address.', 1 );
		}

		$this->addToArray( $email, $array, $position );
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
	private function addToArray( $content, array &$array, int $position = - 1 ) {
		if ( - 1 === $position ) {
			$array[] = $content;
		}

		$array[ $position ] = $content;
	}
}
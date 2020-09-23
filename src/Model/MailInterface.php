<?php

namespace AWSM\LibMail\Model;

/**
 * Interface MailInterface
 *
 * @package AWSM\LibMail
 *
 * @since 1.0.0
 */
interface MailInterface {
	/**
	 * Get mail header.
	 *
	 * @param bool $addAttachments True if attachments have to be added, false if not.
	 *
	 * @return string Mailheader.
	 *
	 * @since 1.0.0
	 */
	public function header( bool $addAttachments = false ) : string;

	/**
	 * Get mail body.
	 *
	 * @param bool $addAttachments True if attachments have to be added, false if not.
	 *
	 * @return string Body.
	 *
	 * @since 1.0.0
	 */
	public function body( bool $addAttachments = false ) : string;

	/**
	 * Get to email addresses.
	 *
	 * @return array Emails in an array.
	 *
	 * @since 1.0.0
	 */
	public function toEmails() : array;

	/**
	 * Get mail subject.
	 *
	 * @return string Email subject.
	 *
	 * @since 1.0.0
	 */
	public function subject() : string;

	/**
	 * Get mail content.
	 *
	 * @return string Email content.
	 *
	 * @since 1.0.0
	 */
	public function content() : string;

	/**
	 * Get mail attachments.
	 *
	 * @return array Email attachments.
	 *
	 * @since 1.0.0
	 */
	public function attachments() : array;
}
<?php

namespace AWSM\Lib_Mail\Model;

/**
 * Interface Mail_Interface
 *
 * @package AWSM\Lib_Mail
 *
 * @since 1.0.0
 */
interface Mail_Interface {
	/**
	 * Get mail header.
	 *
	 * @param bool $add_attachments True if attachments have to be added, false if not.
	 *
	 * @return string Mailheader.
	 *
	 * @since 1.0.0
	 */
	public function get_header( bool $add_attachment ) : string;

	/**
	 * Get mail body.
	 *
	 * @return string Body.
	 *
	 * @since 1.0.0
	 */
	public function get_body( bool $add_attachment ) : string;

	/**
	 * Get to email addresses.
	 *
	 * @return array Emails in an array.
	 *
	 * @since 1.0.0
	 */
	public function get_to_emails() : array;

	/**
	 * Get mail subject.
	 *
	 * @return string Email subject.
	 *
	 * @since 1.0.0
	 */
	public function get_subject() : string;

	/**
	 * Get mail content.
	 *
	 * @return string Email content.
	 *
	 * @since 1.0.0
	 */
	public function get_content() : string;

	/**
	 * Get mail attachments.
	 *
	 * @return array Email attachments.
	 *
	 * @since 1.0.0
	 */
	public function get_attachments() : array;
}
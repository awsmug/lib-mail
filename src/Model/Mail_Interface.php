<?php

namespace awsm\Mail_Wrapper\Model;

/**
 * Interface Mail_Interface
 *
 * @package awsm\Mail_Wrapper
 *
 * @since 1.0.0
 */
interface Mail_Interface {
	/**
	 * Get mail header.
	 *
	 * @return string Mailheader.
	 *
	 * @since 1.0.0
	 */
	public function get_header() : string;

	/**
	 * Get to email addresses.
	 *
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public function get_to_emails() : array;

	/**
	 * Get mail subject.
	 *
	 * @return string Subject.
	 *
	 * @since 1.0.0
	 */
	public function get_subject() : string;

	/**
	 * Get mail content.
	 *
	 * @return string Subject.
	 *
	 * @since 1.0.0
	 */
	public function get_content() : string;

	/**
	 * Get mail body.
	 *
	 * @return string Body.
	 *
	 * @since 1.0.0
	 */
	public function get_body() : string;

	/**
	 * Get mail attachments.
	 *
	 * @return array Attachments.
	 *
	 * @since 1.0.0
	 */
	public function get_attachments() : array;
}
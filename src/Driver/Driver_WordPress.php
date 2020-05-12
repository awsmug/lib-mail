<?php

namespace awsm\Mail_Wrapper\Driver;

use awsm\Mail_Wrapper\Exception;
use awsm\Mail_Wrapper\Mail;

class Driver_WordPress extends Driver {
	/**
	 * Set mail object.
	 *
	 * @param Mail $mail Mail object.
	 *
	 * @since 1.0.0
	 */
	public function set_mail( Mail $mail ) {
		$this->mail = $mail;
	}

	/**
	 * @return bool
	 *
	 * @throws Exception
	 */
	public function send() {
		if ( ! function_exists( 'wp_mail' ) ) {
			throw new Exception( 'wp_mail function does not exists. Make sure you working on a WordPress installation.' );
		}

		$from_name   = $this->mail->get_from_name();
		$from_email  = $this->mail->get_from_email();
		$to          = $this->mail->get_to_email_addresses();
		$cc          = $this->mail->get_cc_email_addresses();
		$bcc         = $this->mail->get_bcc_email_addresses();
		$subject     = $this->mail->get_subject();
		$content     = $this->mail->get_content();
		$attachments = $this->mail->get_attachments();

		if ( ! empty( $from_name ) && ! empty( $from_email ) ) {
			$headers[] = "From: {$from_name} <{$from_email}>";
		}

		if ( count( $cc ) > 0 ) {
			$cc        = implode( ', ', $cc );
			$headers[] = "Cc: {$cc}";
		}

		if ( count( $bcc ) > 0 ) {
			$bcc       = implode( ', ', $bcc );
			$headers[] = "Bcc: {$bcc}";
		}

		if ( ! wp_mail( $to, $subject, $content, $headers, $attachments ) ) {
			throw new Exception( 'wp_mail returned false. Mail was not sent.' );
		}
	}
}
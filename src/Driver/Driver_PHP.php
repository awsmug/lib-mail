<?php

namespace awsm\Mail_Wrapper\Driver;

use awsm\Mail_Wrapper\Exception;
use awsm\Mail_Wrapper\Mail;

class Driver_PHP extends Driver {
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
	public function send() : bool {
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

		if ( count( $to ) > 0 ) {
			$to        = implode( ', ', $to );
			$headers[] = "Cc: {$to}";
		}

		if ( count( $cc ) > 0 ) {
			$cc        = implode( ', ', $cc );
			$headers[] = "Cc: {$cc}";
		}

		if ( count( $bcc ) > 0 ) {
			$bcc       = implode( ', ', $bcc );
			$headers[] = "Bcc: {$bcc}";
		}

		if ( count( $attachments ) > 0 ) {
			$uid = md5( uniqid( time() ) );

			$mime_boundary = "==Multipart_Boundary_x{$uid}x";

			//  $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
			// Headers for attachment
			$headers[] = 'MIME-Version: 1.0';
			$headers[] = 'Content-Type: multipart/mixed;';
			$headers[] = " boundary=\"{$mime_boundary}\"";

			foreach ( $attachments as $attachment ) {
				$file_name = basename( $attachment );
				$file_size = filesize( $attachment );

				$content .= "--{$mime_boundary}\n";
				$fp      = fopen( $attachment, 'rb' );
				$data    = fread( $fp, $file_size );

				fclose( $fp );

				$data    = chunk_split( base64_encode( $data ) );

				$content .= "Content-Type: application/octet-stream; name=\"" . $file_name . "\"\n" .
				            "Content-Description: " . $file_name . "\n" .
				            "Content-Disposition: attachment;\n" . " filename=\"" . $file_name . "\"; size=" . $file_size . ";\n" .
				            "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
			}

			$content .= "--{$mime_boundary}--";
		}

		$headers = implode( ' \r\n', $headers );

		return mail( $to, $subject, $content, $headers );
	}
}
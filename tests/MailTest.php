<?php

use PHPUnit\Framework\TestCase;

use AWSM\Lib_Mail\Mail;
use AWSM\Lib_Mail\Transporter\PHP_Mail;
use AWSM\Lib_Mail\Mail_Exception;

final class MailTest extends TestCase {
	private $transporter;

	private $mail;

	protected function setUp(): void
	{
		$this->transporter = new PHP_Mail();
		$mail = new Mail();
	}

	public function testMailFromName(): void
	{
		$mail = new Mail();
		$mail->set_from_name( 'John Doe' );
		$this->assertEquals('John Doe', $mail->get_from_name() );
	}

	public function testMailFromAddress(): void
	{
		$mail = new Mail();
		$mail->set_from_email( 'john.doe@dummy.com' );

		$this->assertEquals('john.doe@dummy.com', $mail->get_from_email() );

		$this->expectException( Mail_Exception::class );
		$mail->set_from_email( 'abcdefg' );
	}

	public function testMailToAddress(): void {
		$mail = new Mail();

		$mail->add_to_email('john.doe1@dummy.com' );
		$mail->add_to_email('john.doe2@dummy.com' );
		$mail->add_to_email('john.doe3@dummy.com' );

		$emails = $mail->get_to_emails();

		$this->assertIsArray( $emails );
		$this->assertEquals('john.doe1@dummy.com', $emails[0] );
		$this->assertEquals('john.doe2@dummy.com', $emails[1] );
		$this->assertEquals('john.doe3@dummy.com', $emails[2] );

		$mail->add_to_email('john.doe4@dummy.com', 0 );

		$emails = $mail->get_to_emails();
		$this->assertEquals('john.doe4@dummy.com', $emails[0] );

		$this->expectException( Mail_Exception::class );
		$mail->add_to_email( 'abcdefg' );
	}

	public function testMailCCAddress(): void {
		$mail = new Mail();

		$mail->add_cc_email('john.doe5@dummy.com' );
		$mail->add_cc_email('john.doe6@dummy.com' );
		$mail->add_cc_email('john.doe7@dummy.com' );

		$emails = $mail->get_cc_emails();

		$this->assertIsArray( $emails );
		$this->assertEquals('john.doe5@dummy.com', $emails[0] );

		$mail->add_cc_email('john.doe8@dummy.com', 0 );

		$emails = $mail->get_cc_emails();
		$this->assertEquals('john.doe8@dummy.com', $emails[0] );

		$this->expectException( Mail_Exception::class );
		$mail->add_cc_email( 'abcdefg' );
	}

	public function testMailBCCAddress(): void {
		$mail = new Mail();

		$mail->add_bcc_email('john.doe9@dummy.com' );
		$mail->add_bcc_email('john.doe10@dummy.com' );
		$mail->add_bcc_email('john.doe11@dummy.com' );

		$emails = $mail->get_bcc_emails();

		$this->assertIsArray( $emails );
		$this->assertEquals('john.doe9@dummy.com', $emails[0] );

		$mail->add_bcc_email('john.doe12@dummy.com', 0 );

		$emails = $mail->get_bcc_emails();
		$this->assertEquals('john.doe12@dummy.com', $emails[0] );

		$this->expectException( Mail_Exception::class );
		$mail->add_bcc_email( 'abcdefg' );
	}

	public function testMailSubject(): void
	{
		$mail = new Mail();

		$mail->set_subject( 'Email subject' );
		$this->assertEquals('Email subject', $mail->get_subject() );
	}

	public function testMailContent(): void
	{
		$mail = new Mail();

		$mail->set_content( 'Email content' );
		$this->assertEquals('Email content', $mail->get_content() );
	}

	public function testMailAttachment(): void {
		$mail = new Mail();

		$file_1 = dirname(__FILE__ ) . '/test1.txt';
		$file_2 = dirname(__FILE__ ) . '/test2.txt';
		$file_3 = dirname(__FILE__ ) . '/test3.txt';

		touch( $file_1 );
		touch( $file_2 );
		touch( $file_3 );

		$mail->add_attachment( $file_1 );
		$mail->add_attachment( $file_2 );
		$mail->add_attachment( $file_3 );

		unlink( $file_1 );
		unlink( $file_2 );
		unlink( $file_3 );

		$attachments = $mail->get_attachments();

		$this->assertIsArray( $attachments );
		$this->assertEquals( $file_1, $attachments[0] );

		$this->expectException( Mail_Exception::class );
		$mail->add_attachment( dirname(__FILE__ ) . '/abcdefg.txt' );
	}

	public function testSendEmail(): void {
		$mail = new Mail();

		$mail->set_from_email( 'john.doe@dummy.com' );
		$mail->add_to_email('trash@awesome.ug' );
		$mail->set_subject('The email subject' );
		$mail->set_content( 'This is my message' );

		$this->expectException( Mail_Exception::class );

		$transporter = new PHP_Mail();
		$transporter->set_mail( $mail );
		$transporter->send();
	}
}
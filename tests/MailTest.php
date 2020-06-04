<?php

use PHPUnit\Framework\TestCase;

use awsm\Mail_Wrapper\Mail;
use awsm\Mail_Wrapper\Dispatcher\PHP_Mail;
use awsm\Mail_Wrapper\Mail_Exception;

final class MailTest extends TestCase {
	private $dispatcher;

	private $mail;

	protected function setUp(): void
	{
		$this->dispatcher = new PHP_Mail();
		$this->mail = new Mail();
	}

	public function testMailFromName(): void
	{
		$this->mail->set_from_name( 'John Doe' );
		$this->assertEquals('John Doe', $this->mail->get_from_name() );
	}

	public function testMailFromAddress(): void
	{
		$this->mail->set_from_email( 'john.doe@dummy.com' );
		$this->assertEquals('john.doe@dummy.com', $this->mail->get_from_email() );

		$this->expectException( Mail_Exception::class );
		$this->mail->set_from_email( 'abcdefg' );
	}

	public function testMailToAddress(): void {
		$this->mail->add_to_email('john.doe1@dummy.com' );
		$this->mail->add_to_email('john.doe2@dummy.com' );
		$this->mail->add_to_email('john.doe3@dummy.com' );

		$emails = $this->mail->get_to_emails();

		$this->assertIsArray( $emails );
		$this->assertEquals('john.doe1@dummy.com', $emails[0] );

		$this->mail->add_to_email('john.doe4@dummy.com', 0 );

		$emails = $this->mail->get_to_emails();
		$this->assertEquals('john.doe4@dummy.com', $emails[0] );

		$this->expectException( Mail_Exception::class );
		$this->mail->add_to_email( 'abcdefg' );
	}

	public function testMailCCAddress(): void {
		$this->mail->add_cc_email('john.doe5@dummy.com' );
		$this->mail->add_cc_email('john.doe6@dummy.com' );
		$this->mail->add_cc_email('john.doe7@dummy.com' );

		$emails = $this->mail->get_cc_emails();

		$this->assertIsArray( $emails );
		$this->assertEquals('john.doe5@dummy.com', $emails[0] );

		$this->mail->add_cc_email('john.doe8@dummy.com', 0 );

		$emails = $this->mail->get_cc_emails();
		$this->assertEquals('john.doe8@dummy.com', $emails[0] );

		$this->expectException( Mail_Exception::class );
		$this->mail->add_cc_email( 'abcdefg' );
	}

	public function testMailBCCAddress(): void {
		$this->mail->add_bcc_email('john.doe9@dummy.com' );
		$this->mail->add_bcc_email('john.doe10@dummy.com' );
		$this->mail->add_bcc_email('john.doe11@dummy.com' );

		$emails = $this->mail->get_bcc_emails();

		$this->assertIsArray( $emails );
		$this->assertEquals('john.doe9@dummy.com', $emails[0] );

		$this->mail->add_bcc_email('john.doe12@dummy.com', 0 );

		$emails = $this->mail->get_bcc_emails();
		$this->assertEquals('john.doe12@dummy.com', $emails[0] );

		$this->expectException( Mail_Exception::class );
		$this->mail->add_bcc_email( 'abcdefg' );
	}

	public function testMailSubject(): void
	{
		$this->mail->set_subject( 'Email subject' );
		$this->assertEquals('Email subject', $this->mail->get_subject() );
	}

	public function testMailContent(): void
	{
		$this->mail->set_content( 'Email content' );
		$this->assertEquals('Email content', $this->mail->get_content() );
	}

	public function testMailAttachment(): void {
		$file_1 = dirname(__FILE__ ) . '/test1.txt';
		$file_2 = dirname(__FILE__ ) . '/test2.txt';
		$file_3 = dirname(__FILE__ ) . '/test3.txt';

		touch( $file_1 );
		touch( $file_2 );
		touch( $file_3 );

		$this->mail->add_attachment( $file_1 );
		$this->mail->add_attachment( $file_2 );
		$this->mail->add_attachment( $file_3 );

		unlink( $file_1 );
		unlink( $file_2 );
		unlink( $file_3 );

		$attachments = $this->mail->get_attachments();

		$this->assertIsArray( $attachments );
		$this->assertEquals( $file_1, $attachments[0] );

		$this->expectException( Mail_Exception::class );
		$this->mail->add_attachment( dirname(__FILE__ ) . '/abcdefg.txt' );
	}

	public function testSendEmail(): void {
		$this->mail->set_from_name( 'John Doe' );
		$this->mail->set_from_email( 'john.doe@dummy.com' );
		$this->mail->add_to_email('sven@awesome.ug' );
		$this->mail->set_subject('The email subject' );
		$this->mail->set_content( 'This is my message' );

		$this->dispatcher->set_mail( $this->mail );

		$this->assertFalse( $this->dispatcher->send() );
	}
}
<?php

use PHPUnit\Framework\TestCase;

use AWSM\LibMail\Mail;
use AWSM\LibMail\Transporter\PhpMail;
use AWSM\LibMail\MailException;

final class MailTest extends TestCase {
	private $transporter;

	private $mail;

	protected function setUp(): void
	{
		$this->transporter = new PhpMail();
		$mail = new Mail();
	}

	public function testMailFromName(): void
	{
		$mail = new Mail();
		$mail->setFromName( 'John Doe' );
		$this->assertEquals('John Doe', $mail->getFromName() );
	}

	public function testMailFromAddress(): void
	{
		$mail = new Mail();
		$mail->setFromEmail( 'john.doe@dummy.com' );

		$this->assertEquals('john.doe@dummy.com', $mail->getFromEmail() );

		$this->expectException( MailException::class );
		$mail->setFromEmail( 'abcdefg' );
		$mail->setFromEmail( 'abcdefg' );
		$mail->setFromEmail( 'abcdefg' );
	}

	public function testMailToAddress(): void {
		$mail = new Mail();

		$mail->addToEmail('john.doe1@dummy.com' );
		$mail->addToEmail('john.doe2@dummy.com' );
		$mail->addToEmail('john.doe3@dummy.com' );

		$emails = $mail->toEmails();

		$this->assertIsArray( $emails );
		$this->assertEquals('john.doe1@dummy.com', $emails[0] );
		$this->assertEquals('john.doe2@dummy.com', $emails[1] );
		$this->assertEquals('john.doe3@dummy.com', $emails[2] );

		$mail->addToEmail('john.doe4@dummy.com', 0 );

		$emails = $mail->toEmails();
		$this->assertEquals('john.doe4@dummy.com', $emails[0] );

		$this->expectException( MailException::class );
		$mail->addToEmail( 'abcdefg' );
	}

	public function testMailCCAddress(): void {
		$mail = new Mail();

		$mail->addCcEmail('john.doe5@dummy.com' );
		$mail->addCcEmail('john.doe6@dummy.com' );
		$mail->addCcEmail('john.doe7@dummy.com' );

		$emails = $mail->getCcEmails();

		$this->assertIsArray( $emails );
		$this->assertEquals('john.doe5@dummy.com', $emails[0] );

		$mail->addCcEmail('john.doe8@dummy.com', 0 );

		$emails = $mail->getCcEmails();
		$this->assertEquals('john.doe8@dummy.com', $emails[0] );

		$this->expectException( MailException::class );
		$mail->addCcEmail( 'abcdefg' );
	}

	public function testMailBCCAddress(): void {
		$mail = new Mail();

		$mail->addBccEmail('john.doe9@dummy.com' );
		$mail->addBccEmail('john.doe10@dummy.com' );
		$mail->addBccEmail('john.doe11@dummy.com' );

		$emails = $mail->getBccEmails();

		$this->assertIsArray( $emails );
		$this->assertEquals('john.doe9@dummy.com', $emails[0] );

		$mail->addBccEmail('john.doe12@dummy.com', 0 );

		$emails = $mail->getBccEmails();
		$this->assertEquals('john.doe12@dummy.com', $emails[0] );

		$this->expectException( MailException::class );
		$mail->addBccEmail( 'abcdefg' );
	}

	public function testMailSubject(): void
	{
		$mail = new Mail();

		$mail->setSubject( 'Email subject' );
		$this->assertEquals('Email subject', $mail->subject() );
	}

	public function testMailContent(): void
	{
		$mail = new Mail();

		$mail->setContent( 'Email content' );
		$this->assertEquals('Email content', $mail->content() );
	}

	public function testMailAttachment(): void {
		$mail = new Mail();

		$file_1 = dirname(__FILE__ ) . '/test1.txt';
		$file_2 = dirname(__FILE__ ) . '/test2.txt';
		$file_3 = dirname(__FILE__ ) . '/test3.txt';

		touch( $file_1 );
		touch( $file_2 );
		touch( $file_3 );

		$mail->addAttachments( $file_1 );
		$mail->addAttachments( $file_2 );
		$mail->addAttachments( $file_3 );

		unlink( $file_1 );
		unlink( $file_2 );
		unlink( $file_3 );

		$attachments = $mail->attachments();

		$this->assertIsArray( $attachments );
		$this->assertEquals( $file_1, $attachments[0] );

		$this->expectException( MailException::class );
		$mail->addAttachments( dirname(__FILE__ ) . '/abcdefg.txt' );
	}

	public function testSendEmail(): void {
		// @todo: How to test?
		$mail = new Mail();

		$mail->setFromEmail( 'john.doe@dummy.com' );
		$mail->addToEmail('sven@awesome.ug' );
		$mail->setSubject('The email subject' );
		$mail->setContent( 'This is my message' );

		$this->expectException( MailException::class );

		$transporter = new PhpMail();
		$transporter->setMail( $mail );
		$transporter->send();
	}
}
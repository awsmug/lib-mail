<?php

use PHPUnit\Framework\TestCase;

use awsm\Mail_Wrapper\Wrappers\PHP;
use awsm\Mail_Wrapper\Mail;
use awsm\Mail_Wrapper\Exception;

final class MailTest extends TestCase {
	private $wrapper_php;

	private $mail;

	protected function setUp(): void
	{
		$this->wrapper_php = new PHP();
		$this->mail = new Mail( $this->wrapper_php );
	}

	public function testMailClass(): void
	{
		$this->assertInstanceOf( 'awsm\Mail_Wrapper\Wrappers\PHP', $this->wrapper_php );

		$this->assertInstanceOf( 'awsm\Mail_Wrapper\Mail', $this->mail );
		$this->assertInstanceOf( 'awsm\Mail_Wrapper\Wrappers\Mail_Wrapper', $this->mail->get_mail_wrapper() );
		$this->assertInstanceOf( 'awsm\Mail_Wrapper\Wrappers\PHP', $this->mail->get_mail_wrapper() );

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

		$this->expectException( Exception::class );
		$this->mail->set_from_email( 'abcdefg' );
	}
}
<?php

use PHPUnit\Framework\TestCase;

use awsm\Mail_Wrapper\Mail;
use awsm\Mail_Wrapper\Driver\Driver_PHP AS Mail_Driver_PHP;
use awsm\Mail_Wrapper\Exception;

final class MailTest extends TestCase {
	private $driver;

	private $mail;

	protected function setUp(): void
	{
		$this->driver = new Mail_Driver_PHP();
		$this->mail = new Mail( $this->driver );
	}

	public function testMailClass(): void
	{
		$this->assertInstanceOf( 'awsm\Mail_Wrapper\Driver\Driver_PHP', $this->driver );

		$this->assertInstanceOf( 'awsm\Mail_Wrapper\Mail', $this->mail );
		$this->assertInstanceOf( 'awsm\Mail_Wrapper\Driver\Driver_Interface', $this->mail->get_driver() );
		$this->assertInstanceOf( 'awsm\Mail_Wrapper\Driver\Driver', $this->mail->get_driver() );
		$this->assertInstanceOf( 'awsm\Mail_Wrapper\Driver\Driver_PHP', $this->mail->get_driver() );

	}

	public function testMailFromName(): void
	{
		$this->mail->set_from_name( 'John Doe' );
		$this->assertEquals('John Doe', $this->mail->get_from_name() );
	}

	public function testMailFromAddress(): void
	{
		$this->mail->set_from_email( 'john.doe@dummy.com' );
		$this->assertEquals('john.doe@dummsssy.com', $this->mail->get_from_email() );

		$this->expectException( Exception::class );
		$this->mail->set_from_email( 'abcdefg' );
	}
}
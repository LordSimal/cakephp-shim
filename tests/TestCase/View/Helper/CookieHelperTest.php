<?php

namespace Shim\Test\TestCase\View\Helper;

use Cake\Http\ServerRequest;
use Cake\View\View;
use Shim\TestSuite\TestCase;
use Shim\View\Helper\CookieHelper;

class CookieHelperTest extends TestCase {

	/**
	 * @var \Shim\View\Helper\CookieHelper
	 */
	protected $Cookie;

	/**
	 * @var \Cake\Http\ServerRequest|\PHPUnit\Framework\MockObject\MockObject
	 */
	protected $request;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		/** @var \Cake\Http\ServerRequest|\PHPUnit\Framework\MockObject\MockObject $request */
		$this->request = $this->getMockBuilder(ServerRequest::class)->setMethods(['getCookie', 'getCookieParams'])->getMock();
		$this->Cookie = new CookieHelper(new View($this->request));
	}

	/**
	 * @return void
	 */
	public function tearDown(): void {
		unset($this->Table);

		parent::tearDown();
	}

	/**
	 * @return void
	 */
	public function testGetChookies() {
		$this->request->expects($this->once())
			->method('getCookieParams')
			->will($this->returnValue(['one' => 1, 'two' => 2]));

		$this->assertSame(['one', 'two'], $this->Cookie->getCookies());
	}

	/**
	 * @return void
	 */
	public function testCheckFalse() {
		$this->request->expects($this->once())
			->method('getCookie')
			->will($this->returnValue(null));
		$this->assertFalse($this->Cookie->check('Foo.key'));
	}

	/**
	 * @return void
	 */
	public function testCheckTrue() {
		$this->request->expects($this->once())
			->method('getCookie')
			->will($this->returnValue('val'));
		$this->assertTrue($this->Cookie->check('Foo.key'));
	}

	/**
	 * CookieHelperTest::testRead()
	 *
	 * @return void
	 */
	public function testRead() {
		$this->request->expects($this->once())
			->method('getCookie')
			->will($this->returnValue('val'));

		$output = $this->Cookie->read('Foo.key');
		$this->assertTextEquals('val', $output);
	}

}

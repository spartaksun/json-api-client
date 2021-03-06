<?php

namespace Art4\JsonApiClient\Tests;

use Art4\JsonApiClient\Error;
use Art4\JsonApiClient\Tests\Fixtures\HelperTrait;

class ErrorTest extends \PHPUnit_Framework_TestCase
{
	use HelperTrait;

	/**
	 * @setup
	 */
	public function setUp()
	{
		$this->manager = $this->buildManagerMock();
	}

	/**
	 * @test create with object returns self
	 */
	public function testCreateWithObjectReturnsSelf()
	{
		$object = new \stdClass();
		$object->id = 'id';
		$object->links = new \stdClass();
		$object->links->about = 'http://example.org/about';
		$object->status = 'status';
		$object->code = 'code';
		$object->title = 'title';
		$object->detail = 'detail';
		$object->source = new \stdClass();
		$object->meta = new \stdClass();

		$error = new Error($object, $this->manager);

		$this->assertInstanceOf('Art4\JsonApiClient\Error', $error);
		$this->assertInstanceOf('Art4\JsonApiClient\AccessInterface', $error);
		$this->assertSame($error->getKeys(), array('id', 'links', 'status', 'code', 'title', 'detail', 'source', 'meta'));

		$this->assertTrue($error->has('id'));
		$this->assertSame($error->get('id'), 'id');
		$this->assertTrue($error->has('links'));
		$this->assertInstanceOf('Art4\JsonApiClient\ErrorLinkInterface', $error->get('links'));
		$this->assertTrue($error->has('status'));
		$this->assertSame($error->get('status'), 'status');
		$this->assertTrue($error->has('code'));
		$this->assertSame($error->get('code'), 'code');
		$this->assertTrue($error->has('title'));
		$this->assertSame($error->get('title'), 'title');
		$this->assertTrue($error->has('detail'));
		$this->assertSame($error->get('detail'), 'detail');
		$this->assertTrue($error->has('source'));
		$this->assertInstanceOf('Art4\JsonApiClient\ErrorSourceInterface', $error->get('source'));
		$this->assertTrue($error->has('meta'));
		$this->assertInstanceOf('Art4\JsonApiClient\MetaInterface', $error->get('meta'));

		$this->assertSame($error->asArray(), array(
			'id'     => 'id',
			'links'  => $error->get('links'),
			'status' => 'status',
			'code'   => 'code',
			'title'  => 'title',
			'detail' => 'detail',
			'source' => $error->get('source'),
			'meta'   => $error->get('meta'),
		));

		// Test full array
		$this->assertSame($error->asArray(true), array(
			'id'     => 'id',
			'links'  => $error->get('links')->asArray(true),
			'status' => 'status',
			'code'   => 'code',
			'title'  => 'title',
			'detail' => 'detail',
			'source' => $error->get('source')->asArray(true),
			'meta'   => $error->get('meta')->asArray(true),
		));

		// test get() with not existing key throws an exception
		$this->assertFalse($error->has('something'));

		$this->setExpectedException(
		'Art4\JsonApiClient\Exception\AccessException',
		'"something" doesn\'t exist in this error object.'
		);

		$error->get('something');
	}

	/**
	 * @dataProvider jsonValuesProvider
	 */
	public function testCreateWithoutObjectThrowsException($input)
	{
		// Input must be an object
		if ( gettype($input) === 'object' )
		{
			return;
		}

		$this->setExpectedException(
			'Art4\JsonApiClient\Exception\ValidationException',
			'Error has to be an object, "' . gettype($input) . '" given.'
		);

		$error = new Error($input, $this->manager);
	}

	/**
	 * @dataProvider jsonValuesProvider
	 */
	public function testCreateIdWithoutStringThrowsException($input)
	{
		// Input must be a string
		if ( gettype($input) === 'string' )
		{
			return;
		}

		$object = new \stdClass();
		$object->id = $input;

		$this->setExpectedException(
			'Art4\JsonApiClient\Exception\ValidationException',
			'property "id" has to be a string, "' . gettype($input) . '" given.'
		);

		$error = new Error($object, $this->manager);
	}

	/**
	 * @dataProvider jsonValuesProvider
	 */
	public function testCreateStatusWithoutStringThrowsException($input)
	{
		// Input must be a string
		if ( gettype($input) === 'string' )
		{
			return;
		}

		$object = new \stdClass();
		$object->status = $input;

		$this->setExpectedException(
			'Art4\JsonApiClient\Exception\ValidationException',
			'property "status" has to be a string, "' . gettype($input) . '" given.'
		);

		$error = new Error($object, $this->manager);
	}

	/**
	 * @dataProvider jsonValuesProvider
	 */
	public function testCreateCodeWithoutStringThrowsException($input)
	{
		// Input must be a string
		if ( gettype($input) === 'string' )
		{
			return;
		}

		$object = new \stdClass();
		$object->code = $input;

		$this->setExpectedException(
			'Art4\JsonApiClient\Exception\ValidationException',
			'property "code" has to be a string, "' . gettype($input) . '" given.'
		);

		$error = new Error($object, $this->manager);
	}

	/**
	 * @dataProvider jsonValuesProvider
	 */
	public function testCreateTitleWithoutStringThrowsException($input)
	{
		// Input must be a string
		if ( gettype($input) === 'string' )
		{
			return;
		}

		$object = new \stdClass();
		$object->title = $input;

		$this->setExpectedException(
			'Art4\JsonApiClient\Exception\ValidationException',
			'property "title" has to be a string, "' . gettype($input) . '" given.'
		);

		$error = new Error($object, $this->manager);
	}

	/**
	 * @dataProvider jsonValuesProvider
	 */
	public function testCreateDetailWithoutStringThrowsException($input)
	{
		// Input must be a string
		if ( gettype($input) === 'string' )
		{
			return;
		}

		$object = new \stdClass();
		$object->detail = $input;

		$this->setExpectedException(
			'Art4\JsonApiClient\Exception\ValidationException',
			'property "detail" has to be a string, "' . gettype($input) . '" given.'
		);

		$error = new Error($object, $this->manager);
	}
}

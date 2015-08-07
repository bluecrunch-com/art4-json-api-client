<?php

namespace Art4\JsonApiClient\Tests;

use Art4\JsonApiClient\ErrorLink;
use Art4\JsonApiClient\Tests\Fixtures\JsonValueTrait;
use InvalidArgumentException;

class ErrorLinkTest extends \PHPUnit_Framework_TestCase
{
	use JsonValueTrait;

	/**
	 * @test only 'about' property' can exist
	 *
	 * An error object MAY have the following members:
	 * - links: a links object containing the following members:
	 *   - about: a link that leads to further details about this particular occurrence of the problem.
	 */
	public function testOnlyAboutPropertyExists()
	{
		$object = new \stdClass();
		$object->meta = new \stdClass();
		$object->href = 'http://example.org/href';
		$object->about = 'http://example.org/about';

		$link = new ErrorLink($object);

		$this->assertInstanceOf('Art4\JsonApiClient\ErrorLink', $link);

		$this->assertFalse($link->__isset('href'));
		$this->assertFalse($link->hasMeta());
		$this->assertTrue($link->__isset('about'));
		$this->assertSame($link->get('about'), 'http://example.org/about');
	}

	/**
	 * @test 'about' property can be a link object
	 *
	 * An error object MAY have the following members:
	 * - links: a links object containing the following members:
	 *   - about: a link that leads to further details about this particular occurrence of the problem.
	 */
	public function testAboutCanBeAnObject()
	{
		$object = new \stdClass();
		$object->about = new \stdClass();

		$link = new ErrorLink($object);

		$this->assertInstanceOf('Art4\JsonApiClient\ErrorLink', $link);

		$this->assertTrue($link->__isset('about'));
		$this->assertInstanceOf('Art4\JsonApiClient\Link', $link->get('about'));
	}

	/**
	 * @dataProvider jsonValuesProvider
	 *
	 * The value of each links member MUST be an object (a "links object").
	 */
	public function testCreateWithDataprovider($input)
	{
		// Input must be an object
		if ( gettype($input) === 'object' )
		{
			return;
		}

		$this->setExpectedException('InvalidArgumentException');

		$link = new ErrorLink($input);
	}

	/**
	 * Json Values Provider
	 *
	 * @see http://json.org/
	 */
	public function jsonValuesProvider()
	{
		return array(
		array(new \stdClass()),
		array(array()),
		array('string'),
		array(456),
		array(true),
		array(false),
		array(null),
		);
	}
}

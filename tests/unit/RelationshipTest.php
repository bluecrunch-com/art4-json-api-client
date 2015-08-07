<?php

namespace Art4\JsonApiClient\Tests;

use Art4\JsonApiClient\Relationship;
use Art4\JsonApiClient\Tests\Fixtures\JsonValueTrait;
use InvalidArgumentException;

class RelationshipTest extends \PHPUnit_Framework_TestCase
{
	use JsonValueTrait;

	/**
	 * @test create with object returns self
	 */
	public function testCreateWithObjectReturnsSelf()
	{
		$object = new \stdClass();
		$object->meta = new \stdClass();

		$this->assertInstanceOf('Art4\JsonApiClient\Relationship', new Relationship($object));
	}

	/**
	 * @dataProvider jsonValuesProvider
	 *
	 * The value of the relationships key MUST be an object (a "relationships object").
	 */
	public function testCreateWithoutObjectThrowsException($input)
	{
		// Skip if $input is an object
		if ( gettype($input) === 'object' )
		{
			return;
		}

		$this->setExpectedException('InvalidArgumentException');
		$relationship = new Relationship($input);
	}

	/**
	 * @expectedException InvalidArgumentException
	 *
	 * A "relationship object" MUST contain at least one of the following: links, data, meta
	 */
	public function testCreateWithoutLinksDataMetaPropertiesThrowsException()
	{
		$object = new \stdClass();
		$object->foo = 'bar';

		$relationship = new Relationship($object);
	}

	/**
	 * @test create with link object
	 */
	public function testCreateWithLinksObject()
	{
		$object = new \stdClass();
		$object->links = new \stdClass();
		$object->links->self = 'http://example.org/self';

		$relationship = new Relationship($object);

		$this->assertInstanceOf('Art4\JsonApiClient\Relationship', $relationship);
		$this->assertTrue($relationship->hasLinks());

		$this->assertInstanceOf('Art4\JsonApiClient\RelationshipLink', $relationship->getLinks());
	}

	/**
	 * @test create with data object
	 *
	 * data: resource linkage, see http://jsonapi.org/format/#document-resource-object-linkage
	 */
	public function testCreateWithDataObject()
	{
		$data = new \stdClass();
		$data->type = 'posts';
		$data->id = 5;

		$object = new \stdClass();
		$object->data = $data;

		$relationship = new Relationship($object);

		$this->assertInstanceOf('Art4\JsonApiClient\Relationship', $relationship);
		$this->assertTrue($relationship->hasData());

		$this->assertInstanceOf('Art4\JsonApiClient\ResourceIdentifier', $relationship->getData());
	}

	/**
	 * @test create with data null
	 */
	public function testCreateWithDataNull()
	{
		$object = new \stdClass();
		$object->data = null;

		$relationship = new Relationship($object);

		$this->assertInstanceOf('Art4\JsonApiClient\Relationship', $relationship);
		$this->assertTrue($relationship->hasData());

		$this->assertTrue(is_null($relationship->getData()));
	}

	/**
	 * @test create with data object array
	 */
	public function testCreateWithDataObjectArray()
	{
		$data_obj = new \stdClass();
		$data_obj->type = 'types';
		$data_obj->id = 5;

		$object = new \stdClass();
		$object->data = array($data_obj);

		$relationship = new Relationship($object);

		$this->assertInstanceOf('Art4\JsonApiClient\Relationship', $relationship);
		$this->assertTrue($relationship->hasData());

		$resources = $relationship->getData();

		$this->assertTrue(is_array($resources));
		$this->assertTrue( count($resources) === 1);

		foreach ($resources as $resource)
		{
			$this->assertInstanceOf('Art4\JsonApiClient\ResourceIdentifier', $resource);
		}
	}

	/**
	 * @test create with data empty array
	 */
	public function testCreateWithDataEmptyArray()
	{
		$object = new \stdClass();
		$object->data = array();

		$relationship = new Relationship($object);

		$this->assertInstanceOf('Art4\JsonApiClient\Relationship', $relationship);
		$this->assertTrue($relationship->hasData());

		$resources = $relationship->getData();

		$this->assertTrue(is_array($resources));
		$this->assertTrue( count($resources) === 0);
	}

	/**
	 * @test create with meta object
	 */
	public function testCreateWithMetaObject()
	{
		$object = new \stdClass();
		$object->meta = new \stdClass();

		$relationship = new Relationship($object);

		$this->assertInstanceOf('Art4\JsonApiClient\Relationship', $relationship);
		$this->assertTrue($relationship->hasMeta());

		$this->assertInstanceOf('Art4\JsonApiClient\Meta', $relationship->getMeta());
	}
}

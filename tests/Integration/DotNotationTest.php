<?php
/*
 * A PHP Library to handle a JSON API body in an OOP way.
 * Copyright (C) 2015-2018  Artur Weigandt  https://wlabs.de/kontakt

 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Art4\JsonApiClient\Tests\Integration;

use Art4\JsonApiClient\Utils\Helper;
use Art4\JsonApiClient\Tests\Fixtures\HelperTrait;

class DotNotationTest extends \Art4\JsonApiClient\Tests\Fixtures\TestCase
{
    use HelperTrait;

    /**
     * @test
     */
    public function testCompleteResourceObjectWithMultipleRelationships()
    {
        $string = $this->getJsonString('04_complete_document_with_multiple_relationships.json');
        $document = Helper::parseResponseBody($string);

        $this->assertInstanceOf('Art4\JsonApiClient\Document', $document);

        $this->assertTrue($document->has('data'));
        $this->assertInstanceOf('Art4\JsonApiClient\ResourceCollection', $document->get('data'));

        $this->assertTrue($document->has('data.0'));
        $this->assertInstanceOf('Art4\JsonApiClient\ResourceItem', $document->get('data.0'));
        $this->assertFalse($document->has('data.1'));

        $this->assertTrue($document->has('data.0.type'));
        $this->assertSame($document->get('data.0.type'), 'articles');

        $this->assertTrue($document->has('data.0.id'));
        $this->assertSame($document->get('data.0.id'), '1');

        $this->assertTrue($document->has('data.0.attributes'));
        $this->assertInstanceOf('Art4\JsonApiClient\Attributes', $document->get('data.0.attributes'));

        $this->assertTrue($document->has('data.0.attributes.title'));
        $this->assertSame($document->get('data.0.attributes.title'), 'JSON API paints my bikeshed!');

        $this->assertTrue($document->has('data.0.links'));
        $this->assertInstanceOf('Art4\JsonApiClient\ResourceItemLink', $document->get('data.0.links'));

        $this->assertTrue($document->has('data.0.links.self'));
        $this->assertSame($document->get('data.0.links.self'), 'http://example.com/articles/1');

        $this->assertTrue($document->has('data.0.relationships'));
        $this->assertInstanceOf('Art4\JsonApiClient\RelationshipCollection', $document->get('data.0.relationships'));

        $this->assertTrue($document->has('data.0.relationships.author'));
        $this->assertInstanceOf('Art4\JsonApiClient\Relationship', $document->get('data.0.relationships.author'));

        $this->assertTrue($document->has('data.0.relationships.author.links'));
        $this->assertInstanceOf('Art4\JsonApiClient\RelationshipLink', $document->get('data.0.relationships.author.links'));

        $this->assertTrue($document->has('data.0.relationships.author.links.self'));
        $this->assertSame($document->get('data.0.relationships.author.links.self'), 'http://example.com/articles/1/relationships/author');

        $this->assertTrue($document->has('data.0.relationships.author.links.related'));
        $this->assertSame($document->get('data.0.relationships.author.links.related'), 'http://example.com/articles/1/author');

        $this->assertTrue($document->has('data.0.relationships.author.data'));
        $this->assertInstanceOf('Art4\JsonApiClient\ResourceIdentifier', $document->get('data.0.relationships.author.data'));

        $this->assertTrue($document->has('data.0.relationships.author.data.type'));
        $this->assertSame($document->get('data.0.relationships.author.data.type'), 'people');

        $this->assertTrue($document->has('data.0.relationships.author.data.id'));
        $this->assertSame($document->get('data.0.relationships.author.data.id'), '9');

        $this->assertTrue($document->has('data.0.relationships.comments'));
        $this->assertInstanceOf('Art4\JsonApiClient\Relationship', $document->get('data.0.relationships.comments'));

        $this->assertTrue($document->has('data.0.relationships.comments.links'));
        $this->assertInstanceOf('Art4\JsonApiClient\RelationshipLink', $document->get('data.0.relationships.comments.links'));

        $this->assertTrue($document->has('data.0.relationships.comments.links.self'));
        $this->assertSame($document->get('data.0.relationships.comments.links.self'), 'http://example.com/articles/1/relationships/comments');

        $this->assertTrue($document->has('data.0.relationships.comments.links.related'));
        $this->assertSame($document->get('data.0.relationships.comments.links.related'), 'http://example.com/articles/1/comments');

        $this->assertTrue($document->has('data.0.relationships.comments.data'));
        $this->assertInstanceOf('Art4\JsonApiClient\ResourceIdentifierCollection', $document->get('data.0.relationships.comments.data'));

        $this->assertTrue($document->has('data.0.relationships.comments.data.0'));
        $this->assertInstanceOf('Art4\JsonApiClient\ResourceIdentifier', $document->get('data.0.relationships.comments.data.0'));

        $this->assertTrue($document->has('data.0.relationships.comments.data.0.type'));
        $this->assertSame($document->get('data.0.relationships.comments.data.0.type'), 'comments');

        $this->assertTrue($document->has('data.0.relationships.comments.data.0.id'));
        $this->assertSame($document->get('data.0.relationships.comments.data.0.id'), '5');

        $this->assertTrue($document->has('data.0.relationships.comments.data.1'));
        $this->assertInstanceOf('Art4\JsonApiClient\ResourceIdentifier', $document->get('data.0.relationships.comments.data.1'));

        $this->assertTrue($document->has('data.0.relationships.comments.data.1.type'));
        $this->assertSame($document->get('data.0.relationships.comments.data.1.type'), 'comments');

        $this->assertTrue($document->has('data.0.relationships.comments.data.1.id'));
        $this->assertSame($document->get('data.0.relationships.comments.data.1.id'), '12');

        $this->assertTrue($document->has('included'));
        $this->assertInstanceOf('Art4\JsonApiClient\ResourceCollection', $document->get('included'));

        $this->assertTrue($document->has('included.0'));
        $this->assertInstanceOf('Art4\JsonApiClient\ResourceItem', $document->get('included.0'));

        $this->assertTrue($document->has('included.0.type'));
        $this->assertSame($document->get('included.0.type'), 'people');

        $this->assertTrue($document->has('included.0.id'));
        $this->assertSame($document->get('included.0.id'), '9');

        $this->assertTrue($document->has('included.0.attributes'));
        $this->assertInstanceOf('Art4\JsonApiClient\Attributes', $document->get('included.0.attributes'));

        $this->assertTrue($document->has('included.0.attributes.first-name'));
        $this->assertSame($document->get('included.0.attributes.first-name'), 'Dan');

        $this->assertTrue($document->has('included.0.attributes.last-name'));
        $this->assertSame($document->get('included.0.attributes.last-name'), 'Gebhardt');

        $this->assertTrue($document->has('included.0.attributes.twitter'));
        $this->assertSame($document->get('included.0.attributes.twitter'), 'dgeb');

        $this->assertTrue($document->has('included.0.links'));
        $this->assertInstanceOf('Art4\JsonApiClient\ResourceItemLink', $document->get('included.0.links'));

        $this->assertTrue($document->has('included.0.links.self'));
        $this->assertSame($document->get('included.0.links.self'), 'http://example.com/people/9');

        $this->assertTrue($document->has('included.1'));
        $this->assertInstanceOf('Art4\JsonApiClient\ResourceItem', $document->get('included.1'));

        $this->assertTrue($document->has('included.1.type'));
        $this->assertSame($document->get('included.1.type'), 'comments');

        $this->assertTrue($document->has('included.1.id'));
        $this->assertSame($document->get('included.1.id'), '5');

        $this->assertTrue($document->has('included.1.attributes'));
        $this->assertInstanceOf('Art4\JsonApiClient\Attributes', $document->get('included.1.attributes'));

        $this->assertTrue($document->has('included.1.attributes.body'));
        $this->assertSame($document->get('included.1.attributes.body'), 'First!');

        $this->assertTrue($document->has('included.1.links'));
        $this->assertInstanceOf('Art4\JsonApiClient\ResourceItemLink', $document->get('included.1.links'));

        $this->assertTrue($document->has('included.1.links.self'));
        $this->assertSame($document->get('included.1.links.self'), 'http://example.com/comments/5');

        $this->assertTrue($document->has('included.2'));
        $this->assertInstanceOf('Art4\JsonApiClient\ResourceItem', $document->get('included.2'));

        $this->assertTrue($document->has('included.2.type'));
        $this->assertSame($document->get('included.2.type'), 'comments');

        $this->assertTrue($document->has('included.2.id'));
        $this->assertSame($document->get('included.2.id'), '12');

        $this->assertTrue($document->has('included.2.attributes'));
        $this->assertInstanceOf('Art4\JsonApiClient\Attributes', $document->get('included.2.attributes'));

        $this->assertTrue($document->has('included.2.attributes.body'));
        $this->assertSame($document->get('included.2.attributes.body'), 'I like XML better');

        $this->assertTrue($document->has('included.2.links'));
        $this->assertInstanceOf('Art4\JsonApiClient\ResourceItemLink', $document->get('included.2.links'));

        $this->assertTrue($document->has('included.2.links.self'));
        $this->assertSame($document->get('included.2.links.self'), 'http://example.com/comments/12');
    }

    /**
     * @test
     */
    public function testGetNotExistentValueThrowsException()
    {
        $string = $this->getJsonString('05_simple_meta_object.json');
        $document = Helper::parseResponseBody($string);

        // Test 3 segments, segment 2 don't exists
        $this->assertFalse($document->has('meta.foobar.zap'));

        // Test 3 segments, segment 3 don't exists
        $this->assertFalse($document->has('meta.random_object.zap'));

        $this->setExpectedException(
            'Art4\JsonApiClient\Exception\AccessException',
            '"meta.random_object.zap" doesn\'t exist in Document.'
        );

        $document->get('meta.random_object.zap');
    }
}

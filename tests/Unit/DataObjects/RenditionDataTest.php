<?php
namespace Dkd\PhpCmis\Test\Unit\DataObjects;

/*
 * This file is part of php-cmis-lib.
 *
 * (c) Sascha Egerer <sascha.egerer@dkd.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use PHPUnit_Framework_TestCase;
use Dkd\PhpCmis\DataObjects\RenditionData;
use Dkd\PhpCmis\Test\Unit\DataProviderCollectionTrait;

/**
 * Class RenditionDataTest
 */
class RenditionDataTest extends PHPUnit_Framework_TestCase
{
    use DataProviderCollectionTrait;

    /**
     * @var RenditionData
     */
    protected $renditionData;

    public function setUp(): void
    {
        $this->renditionData = new RenditionData();
    }

    public function testSetStreamIdSetsProperty(): void
    {
        $this->renditionData->setStreamId('stream-id');
        $this->assertAttributeSame('stream-id', 'streamId', $this->renditionData);
    }

    /**
     * @depends testSetStreamIdSetsProperty
     */
    public function testGetStreamIdReturnsPropertyValue(): void
    {
        $this->renditionData->setStreamId('stream-id');
        $this->assertSame('stream-id', $this->renditionData->getStreamId());
    }

    /**
     * @dataProvider integerCastDataProvider
     * @param integer $expected
     */
    public function testSetHeightSetsPropertyAsInteger($expected, mixed $value): void
    {
        $this->renditionData->setHeight($value);
        $this->assertAttributeSame($expected, 'height', $this->renditionData);
    }

    /**
     * @depends testSetHeightSetsPropertyAsInteger
     */
    public function testGetHeightReturnsPropertyValue(): void
    {
        $this->renditionData->setHeight(10);
        $this->assertSame(10, $this->renditionData->getHeight());
    }

    /**
     * @dataProvider integerCastDataProvider
     * @param integer $expected
     */
    public function testSetWidthSetsPropertyAsInteger($expected, mixed $value): void
    {
        $this->renditionData->setWidth($value);
        $this->assertAttributeSame($expected, 'width', $this->renditionData);
    }

    /**
     * @depends testSetWidthSetsPropertyAsInteger
     */
    public function testGetWidthReturnsPropertyValue(): void
    {
        $this->renditionData->setWidth(10);
        $this->assertSame(10, $this->renditionData->getWidth());
    }

    /**
     * @dataProvider integerCastDataProvider
     * @param integer $expected
     */
    public function testSetLengthSetsPropertyAsInteger($expected, mixed $value): void
    {
        $this->renditionData->setLength($value);
        $this->assertAttributeSame($expected, 'length', $this->renditionData);
    }

    /**
     * @depends testSetLengthSetsPropertyAsInteger
     */
    public function testGetLengthReturnsPropertyValue(): void
    {
        $this->renditionData->setLength(10);
        $this->assertSame(10, $this->renditionData->getLength());
    }

    /**
     * @dataProvider stringCastDataProvider
     * @param string $expected
     */
    public function testSetMimeTypeSetsPropertyAsString($expected, mixed $value): void
    {
        $this->renditionData->setMimeType($value);
        $this->assertAttributeSame($expected, 'mimeType', $this->renditionData);
    }

    /**
     * @depends testSetMimeTypeSetsPropertyAsString
     */
    public function testGetMimeTypeReturnsPropertyValue(): void
    {
        $this->renditionData->setMimeType('foo');
        $this->assertSame('foo', $this->renditionData->getMimeType());
    }

    /**
     * @dataProvider stringCastDataProvider
     * @param string $expected
     */
    public function testSetKindSetsPropertyAsString($expected, mixed $value): void
    {
        $this->renditionData->setKind($value);
        $this->assertAttributeSame($expected, 'kind', $this->renditionData);
    }

    /**
     * @depends testSetKindSetsPropertyAsString
     */
    public function testGetKindReturnsPropertyValue(): void
    {
        $this->renditionData->setKind('foo');
        $this->assertSame('foo', $this->renditionData->getKind());
    }

    /**
     * @dataProvider stringCastDataProvider
     * @param string $expected
     */
    public function testSetTitleSetsPropertyAsString($expected, mixed $value): void
    {
        $this->renditionData->setTitle($value);
        $this->assertAttributeSame($expected, 'title', $this->renditionData);
    }

    /**
     * @depends testSetTitleSetsPropertyAsString
     */
    public function testGetTitleReturnsPropertyValue(): void
    {
        $this->renditionData->setTitle('foo');
        $this->assertSame('foo', $this->renditionData->getTitle());
    }

    /**
     * @dataProvider stringCastDataProvider
     * @param string $expected
     */
    public function testSetRenditionDocumentIdSetsPropertyAsString($expected, mixed $value): void
    {
        $this->renditionData->setRenditionDocumentId($value);
        $this->assertAttributeSame($expected, 'renditionDocumentId', $this->renditionData);
    }

    /**
     * @depends testSetRenditionDocumentIdSetsPropertyAsString
     */
    public function testGetRenditionDocumentIdReturnsPropertyValue(): void
    {
        $this->renditionData->setRenditionDocumentId('foo');
        $this->assertSame('foo', $this->renditionData->getRenditionDocumentId());
    }
}

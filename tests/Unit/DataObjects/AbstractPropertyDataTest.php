<?php
namespace Dkd\PhpCmis\Test\Unit\DataObjects;

/*
 * This file is part of php-cmis-client
 *
 * (c) Sascha Egerer <sascha.egerer@dkd.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use PHPUnit_Framework_TestCase;
use Dkd\PhpCmis\DataObjects\AbstractPropertyData;
use Dkd\PhpCmis\Test\Unit\DataProviderCollectionTrait;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Class AbstractPropertyDataTest
 */
class AbstractPropertyDataTest extends PHPUnit_Framework_TestCase
{
    use DataProviderCollectionTrait;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject|AbstractPropertyData
     */
    protected $propertyDataMock;

    public function setUp(): void
    {
        $this->propertyDataMock = $this->getMockBuilder(
            AbstractPropertyData::class
        )->setConstructorArgs(
            ['foo', 'value']
        )->getMockForAbstractClass();
    }

    public function testConstructorSetsIdAndValueProperty(): void
    {
        $this->assertAttributeSame('foo', 'id', $this->propertyDataMock);
        $this->assertAttributeSame(['value'], 'values', $this->propertyDataMock);


        $propertyData = $this->getMockBuilder(AbstractPropertyData::class)->setConstructorArgs(
            ['foo', ['bar', 'value']]
        )->getMockForAbstractClass();
        $this->assertAttributeSame(['bar', 'value'], 'values', $propertyData);
    }

    /**
     * @dataProvider stringCastDataProvider
     * @param $expected
     * @param $value
     */
    public function testSetDisplayNameSetsProperty($expected, $value): void
    {
        $this->propertyDataMock->setDisplayName($value);
        $this->assertAttributeSame($expected, 'displayName', $this->propertyDataMock);
    }

    /**
     * @depends testSetDisplayNameSetsProperty
     */
    public function testGetDisplayNameGetsProperty(): void
    {
        $this->propertyDataMock->setDisplayName('displayName');
        $this->assertSame('displayName', $this->propertyDataMock->getDisplayName());
    }

    /**
     * @dataProvider stringCastDataProvider
     * @param $expected
     * @param $value
     */
    public function testSetIdSetsProperty($expected, $value): void
    {
        $this->propertyDataMock->setId($value);
        $this->assertAttributeSame($expected, 'id', $this->propertyDataMock);
    }

    /**
     * @depends testSetIdSetsProperty
     */
    public function testGetIdGetsProperty(): void
    {
        $this->propertyDataMock->setId('id');
        $this->assertSame('id', $this->propertyDataMock->getId());
    }

    /**
     * @dataProvider stringCastDataProvider
     * @param $expected
     * @param $value
     */
    public function testSetLocalNameSetsProperty($expected, $value): void
    {
        $this->propertyDataMock->setLocalName($value);
        $this->assertAttributeSame($expected, 'localName', $this->propertyDataMock);
    }

    /**
     * @depends testSetLocalNameSetsProperty
     */
    public function testGetLocalNameGetsProperty(): void
    {
        $this->propertyDataMock->setLocalName('localName');
        $this->assertSame('localName', $this->propertyDataMock->getLocalName());
    }

    /**
     * @dataProvider stringCastDataProvider
     * @param $expected
     * @param $value
     */
    public function testSetQueryNameSetsProperty($expected, $value): void
    {
        $this->propertyDataMock->setQueryName($value);
        $this->assertAttributeSame($expected, 'queryName', $this->propertyDataMock);
    }

    /**
     * @depends testSetQueryNameSetsProperty
     */
    public function testGetQueryNameGetsProperty(): void
    {
        $this->propertyDataMock->setQueryName('queryName');
        $this->assertSame('queryName', $this->propertyDataMock->getQueryName());
    }

    public function testSetValuesSetsProperty(): void
    {
        $this->propertyDataMock->setValues(['value']);
        $this->assertAttributeSame(['value'], 'values', $this->propertyDataMock);
    }

    public function testSetValuesSetsPropertyAsIndexedArray(): void
    {
        $values = [0 => 'foo', 'a' => 'bar', 'baz'];
        $this->propertyDataMock->setValues($values);
        $this->assertAttributeSame([0 => 'foo', 1 => 'bar', 2 => 'baz'], 'values', $this->propertyDataMock);
    }

    /**
     * @depends testSetValuesSetsProperty
     */
    public function testGetValuesGetsProperty(): void
    {
        $this->propertyDataMock->setValues(['value']);
        $this->assertSame(['value'], $this->propertyDataMock->getValues());
    }

    public function testSetValueSetsSingleValueAsArrayInProperty(): void
    {
        $this->propertyDataMock->setValue('value');
        $this->assertAttributeSame(['value'], 'values', $this->propertyDataMock);
    }

    /**
     * @depends testSetValuesSetsProperty
     */
    public function testGetFirstValueReturnsFirstEntryOfValuesProperty(): void
    {
        $this->propertyDataMock->setValues(['value1', 'value2', 'value3']);
        $this->assertSame('value1', $this->propertyDataMock->getFirstValue());
    }

    /**
     * @depends testSetValuesSetsProperty
     */
    public function testGetFirstValueReturnsNullIfPropertyDoesNotContainValues(): void
    {
        $this->propertyDataMock->setValues([]);
        $this->assertNull($this->propertyDataMock->getFirstValue());
    }
}

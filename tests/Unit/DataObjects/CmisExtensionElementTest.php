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
use Dkd\PhpCmis\DataObjects\CmisExtensionElement;
use Dkd\PhpCmis\Test\Unit\DataProviderCollectionTrait;

/**
 * Class CmisExtensionElementTest
 */
class CmisExtensionElementTest extends PHPUnit_Framework_TestCase
{
    use DataProviderCollectionTrait;

    public function testConstructorThrowsExceptionIfNameIsEmpty(): void
    {
        $this->setExpectedException('\\InvalidArgumentException', 'Name must be given!');
        new CmisExtensionElement('namespace', '');
    }

    public function testConstructorThrowsExceptionIfValueAndChildrenIsGiven(): void
    {
        $this->setExpectedException(
            '\\InvalidArgumentException',
            'Value and children given! Only one of them is allowed.'
        );
        new CmisExtensionElement('namespace', 'name', [], 'value', ['children']);
    }

    /**
     * @dataProvider stringCastDataProvider
     * @param string $expected
     */
    public function testConstructorSetsNameAsProperty($expected, mixed $value): void
    {
        // filter empty values from the data provider because they will end in an exception here.
        if (!empty($value)) {
            $cmisExtensionElement = new CmisExtensionElement('namespace', $value, [], 'value');
            $this->assertAttributeSame($expected, 'name', $cmisExtensionElement);
        }
    }

    /**
     * @dataProvider stringCastDataProvider
     * @param string $expected
     */
    public function testConstructorSetsNamespaceAsProperty($expected, mixed $value): void
    {
        $cmisExtensionElement = new CmisExtensionElement($value, 'name', [], 'value');
        $this->assertAttributeSame($expected, 'namespace', $cmisExtensionElement);
    }

    public function testConstructorSetsAttributesAsProperty(): void
    {
        $cmisExtensionElement = new CmisExtensionElement('namespace', 'name', ['foo'], 'value');
        $this->assertAttributeSame(['foo'], 'attributes', $cmisExtensionElement);
    }

    /**
     * @dataProvider stringCastDataProvider
     * @param string $expected
     */
    public function testConstructorSetsValueAsProperty($expected, mixed $value): void
    {
        // filter empty values from the data provider because they will end in an exception here.
        if (!empty($value)) {
            $cmisExtensionElement = new CmisExtensionElement('namespace', 'name', [], $value);
            $this->assertAttributeSame($expected, 'value', $cmisExtensionElement);
            $this->assertAttributeSame([], 'children', $cmisExtensionElement);
        }
    }

    public function testConstructorSetsChildrenAsProperty(): void
    {
        $children = [new CmisExtensionElement('namespace', 'children', [], 'children')];
        $cmisExtensionElement = new CmisExtensionElement('namespace', 'name', [], null, $children);
        $this->assertAttributeSame(null, 'value', $cmisExtensionElement);
        $this->assertAttributeSame($children, 'children', $cmisExtensionElement);
    }

    /**
     * @dependsOn testConstructorSetsAttributesAsProperty
     */
    public function testGetAttributesReturnsProperty(): void
    {
        $cmisExtensionElement = new CmisExtensionElement('namespace', 'name', ['foo'], 'value');
        $this->assertEquals(['foo'], $cmisExtensionElement->getAttributes());
    }

    /**
     * @dependsOn testConstructorSetsChildrenAsProperty
     */
    public function testGetChildrenReturnsProperty(): void
    {
        $children = [new CmisExtensionElement('namespace', 'children', [], 'children')];
        $cmisExtensionElement = new CmisExtensionElement('namespace', 'name', [], null, $children);
        $this->assertEquals($children, $cmisExtensionElement->getChildren());
    }

    /**
     * @dependsOn testConstructorSetsNameAsProperty
     */
    public function testGetNameReturnsProperty(): void
    {
        $cmisExtensionElement = new CmisExtensionElement('namespace', 'name', [], 'value');
        $this->assertEquals('name', $cmisExtensionElement->getName());
    }

    /**
     * @dependsOn testConstructorSetsNamespaceAsProperty
     */
    public function testGetNamespaceReturnsProperty(): void
    {
        $cmisExtensionElement = new CmisExtensionElement('namespace', 'name', [], 'value');
        $this->assertEquals('namespace', $cmisExtensionElement->getNamespace());
    }

    /**
     * @dependsOn testConstructorSetsValueAsProperty
     */
    public function testGetValueReturnsProperty(): void
    {
        $cmisExtensionElement = new CmisExtensionElement('namespace', 'name', [], 'value');
        $this->assertEquals('value', $cmisExtensionElement->getValue());
    }
}

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
use Dkd\PhpCmis\Data\AceInterface;
use Dkd\PhpCmis\DataObjects\AccessControlList;
use Dkd\PhpCmis\DataObjects\AbstractPropertyData;
use Dkd\PhpCmis\DataObjects\Properties;
use Dkd\PhpCmis\Exception\CmisRuntimeException;
use Dkd\PhpCmis\DataObjects\PropertyBoolean;
use DateTime;
use Dkd\PhpCmis\DataObjects\PropertyDateTime;
use Dkd\PhpCmis\DataObjects\PropertyDecimal;
use Dkd\PhpCmis\DataObjects\PropertyHtml;
use Dkd\PhpCmis\DataObjects\PropertyId;
use Dkd\PhpCmis\DataObjects\PropertyInteger;
use Dkd\PhpCmis\DataObjects\PropertyString;
use Dkd\PhpCmis\DataObjects\PropertyUri;
use Dkd\PhpCmis\DataObjects\AccessControlEntry;
use Dkd\PhpCmis\DataObjects\BindingsObjectFactory;
use Dkd\PhpCmis\DataObjects\Principal;
use Dkd\PhpCmis\DataObjects\PropertyBooleanDefinition;
use Dkd\PhpCmis\DataObjects\PropertyDateTimeDefinition;
use Dkd\PhpCmis\DataObjects\PropertyDecimalDefinition;
use Dkd\PhpCmis\DataObjects\PropertyHtmlDefinition;
use Dkd\PhpCmis\DataObjects\PropertyIdDefinition;
use Dkd\PhpCmis\DataObjects\PropertyIntegerDefinition;
use Dkd\PhpCmis\DataObjects\PropertyStringDefinition;
use Dkd\PhpCmis\DataObjects\PropertyUriDefinition;
use Dkd\PhpCmis\Definitions\PropertyDefinitionInterface;

/**
 * Class BindingsObjectFactoryTest
 */
class BindingsObjectFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var BindingsObjectFactory
     */
    protected $bindingsObjectFactory;

    public function setUp(): void
    {
        $this->bindingsObjectFactory = new BindingsObjectFactory();
    }

    public function testCreateAccessControlEntryReturnsAccessControlEntryObjectWithGivenProperties(): void
    {
        $principal = 'DummyPrincipal';
        $permissions = ['perm1', 'perm2'];
        $ace = $this->bindingsObjectFactory->createAccessControlEntry($principal, $permissions);

        $this->assertInstanceOf(AccessControlEntry::class, $ace);
        $this->assertEquals(new Principal($principal), $ace->getPrincipal());
        $this->assertSame($permissions, $ace->getPermissions());
    }

    public function testCreateAccessControlListCreatesAnAccessControlListObjectWithGivenAces(): void
    {
        $aces = [
            $this->getMockBuilder(
                AceInterface::class
            )->disableOriginalConstructor()->getMockForAbstractClass(),
            $this->getMockBuilder(
                AceInterface::class
            )->disableOriginalConstructor()->getMockForAbstractClass()
        ];
        $acl = $this->bindingsObjectFactory->createAccessControlList($aces);

        $this->assertInstanceOf(AccessControlList::class, $acl);
        $this->assertAttributeSame($aces, 'aces', $acl);
    }

    public function testCreatePropertiesDataCreatesInstanceOfPropertiesObjectWithGivenProperties(): void
    {
        $property1 = $this->getMockBuilder(AbstractPropertyData::class)->setConstructorArgs(
            ['property1']
        )->getMockForAbstractClass();
        $property2 = $this->getMockBuilder(AbstractPropertyData::class)->setConstructorArgs(
            ['property2']
        )->getMockForAbstractClass();
        $properties = $this->bindingsObjectFactory->createPropertiesData([$property1, $property2]);
        $this->assertInstanceOf(Properties::class, $properties);
        $this->assertAttributeSame(
            ['property1' => $property1, 'property2' => $property2],
            'properties',
            $properties
        );
    }

    public function testCreatePropertyDataThrowsExceptionIfUnknownPropertyDefinitionIsGiven(): void
    {
        /** @var PropertyDefinitionInterface $invalidPropertyDefinition */
        $invalidPropertyDefinition = $this->getMockBuilder(
            PropertyDefinitionInterface::class
        )->setMockClassName('InvalidPropertyDefinition')->getMockForAbstractClass();
        $this->setExpectedException(
            CmisRuntimeException::class,
            'Unknown property definition: InvalidPropertyDefinition'
        );
        $this->bindingsObjectFactory->createPropertyData($invalidPropertyDefinition, []);
    }

    public function testCreatePropertyBooleanDataReturnsInstanceOfPropertyBoolean(): void
    {
        $property = $this->bindingsObjectFactory->createPropertyBooleanData('myId', [true]);
        $this->assertInstanceOf(PropertyBoolean::class, $property);
    }

    public function testCreatePropertyDateTimeDataReturnsInstanceOfPropertyDateTime(): void
    {
        $property = $this->bindingsObjectFactory->createPropertyDateTimeData('myId', [new DateTime()]);
        $this->assertInstanceOf(PropertyDateTime::class, $property);
    }

    public function testCreatePropertyDecimalDataReturnsInstanceOfPropertyDecimal(): void
    {
        $property = $this->bindingsObjectFactory->createPropertyDecimalData('myId', [1.2]);
        $this->assertInstanceOf(PropertyDecimal::class, $property);
    }

    public function testCreatePropertyHtmlDataReturnsInstanceOfPropertyHtml(): void
    {
        $property = $this->bindingsObjectFactory->createPropertyHtmlData('myId', ['value']);
        $this->assertInstanceOf(PropertyHtml::class, $property);
    }

    public function testCreatePropertyIdDataReturnsInstanceOfPropertyId(): void
    {
        $property = $this->bindingsObjectFactory->createPropertyIdData('myId', ['value']);
        $this->assertInstanceOf(PropertyId::class, $property);
    }

    public function testCreatePropertyIntegerDataReturnsInstanceOfPropertyInteger(): void
    {
        $property = $this->bindingsObjectFactory->createPropertyIntegerData('myId', [12]);
        $this->assertInstanceOf(PropertyInteger::class, $property);
    }

    public function testCreatePropertyStringDataReturnsInstanceOfPropertyString(): void
    {
        $property = $this->bindingsObjectFactory->createPropertyStringData('myId', ['value']);
        $this->assertInstanceOf(PropertyString::class, $property);
    }

    public function testCreatePropertyUriDataReturnsInstanceOfPropertyUri(): void
    {
        $property = $this->bindingsObjectFactory->createPropertyUriData('myId', ['value']);
        $this->assertInstanceOf(PropertyUri::class, $property);
    }

    /**
     * @param string $expectedPropertyClass
     * @dataProvider createPropertyDataDataProvider
     */
    public function testCreatePropertyDataCreatesPropertyBasedOnTheGivenPropertyDefinition(
        PropertyDefinitionInterface $propertyDefinition,
        array $values,
        $expectedPropertyClass
    ): void {
        $this->assertInstanceOf(
            $expectedPropertyClass,
            $this->bindingsObjectFactory->createPropertyData($propertyDefinition, $values)
        );
    }

    public function createPropertyDataDataProvider()
    {
        return [
            [
                new PropertyBooleanDefinition('testId'),
                [true],
                PropertyBoolean::class
            ],
            [
                new PropertyDateTimeDefinition('testId'),
                [new DateTime()],
                PropertyDateTime::class
            ],
            [
                new PropertyDecimalDefinition('testId'),
                [1.2],
                PropertyDecimal::class
            ],
            [
                new PropertyHtmlDefinition('testId'),
                ['testValue'],
                PropertyHtml::class
            ],
            [
                new PropertyIdDefinition('testId'),
                ['testValue'],
                PropertyId::class
            ],
            [
                new PropertyIntegerDefinition('testId'),
                [12],
                PropertyInteger::class
            ],
            [
                new PropertyStringDefinition('testId'),
                ['testValue'],
                PropertyString::class
            ],
            [
                new PropertyUriDefinition('testId'),
                ['testValue'],
                PropertyUri::class
            ],
        ];
    }
}

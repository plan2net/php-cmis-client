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
use Dkd\PhpCmis\DataObjects\AbstractPropertyDefinition;
use Dkd\PhpCmis\DataObjects\PropertyIntegerDefinition;
use Dkd\PhpCmis\Test\Unit\DataProviderCollectionTrait;

/**
 * Class PropertyIntegerDefinitionTest
 */
class PropertyIntegerDefinitionTest extends PHPUnit_Framework_TestCase
{
    use DataProviderCollectionTrait;

    /**
     * @var PropertyIntegerDefinition
     */
    protected $propertyIntegerDefinition;

    public function setUp(): void
    {
        $this->propertyIntegerDefinition = new PropertyIntegerDefinition('testId');
    }

    public function testAssertIsInstanceOfAbstractPropertyDefinition(): void
    {
        $this->assertInstanceOf(
            AbstractPropertyDefinition::class,
            $this->propertyIntegerDefinition
        );
    }

    /**
     * @dataProvider integerCastDataProvider
     * @param integer $expected
     */
    public function testSetMaxValueCastsValueToIntegerAndSetsProperty($expected, mixed $value): void
    {
        @$this->propertyIntegerDefinition->setMaxValue($value);
        $this->assertAttributeSame($expected, 'maxValue', $this->propertyIntegerDefinition);
    }

    /**
     * @depends testSetMaxValueCastsValueToIntegerAndSetsProperty
     */
    public function testGetMaxValueReturnsPropertyValue(): void
    {
        $this->propertyIntegerDefinition->setMaxValue(100);
        $this->assertSame(100, $this->propertyIntegerDefinition->getMaxValue());
    }

    /**
     * @dataProvider integerCastDataProvider
     * @param integer $expected
     */
    public function testSetMinValueCastsValueToIntegerAndSetsProperty($expected, mixed $value): void
    {
        @$this->propertyIntegerDefinition->setMinValue($value);
        $this->assertAttributeSame($expected, 'minValue', $this->propertyIntegerDefinition);
    }

    /**
     * @depends testSetMinValueCastsValueToIntegerAndSetsProperty
     */
    public function testGetMinValueReturnsPropertyValue(): void
    {
        $this->propertyIntegerDefinition->setMinValue(100);
        $this->assertSame(100, $this->propertyIntegerDefinition->getMinValue());
    }
}

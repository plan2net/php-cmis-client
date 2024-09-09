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
use Dkd\PhpCmis\DataObjects\PropertyDecimalDefinition;
use Dkd\PhpCmis\Enum\DecimalPrecision;
use Dkd\PhpCmis\Test\Unit\DataProviderCollectionTrait;

/**
 * Class PropertyDecimalDefinitionTest
 */
class PropertyDecimalDefinitionTest extends PHPUnit_Framework_TestCase
{
    use DataProviderCollectionTrait;

    /**
     * @var PropertyDecimalDefinition
     */
    protected $propertyDecimalDefinition;

    public function setUp(): void
    {
        $this->propertyDecimalDefinition = new PropertyDecimalDefinition('testId');
    }

    public function testAssertIsInstanceOfAbstractPropertyDefinition(): void
    {
        $this->assertInstanceOf(
            AbstractPropertyDefinition::class,
            $this->propertyDecimalDefinition
        );
    }

    /**
     * @dataProvider integerCastDataProvider
     * @param integer $expected
     */
    public function testSetMaxValueCastsValueToIntegerAndSetsProperty($expected, mixed $value): void
    {
        @$this->propertyDecimalDefinition->setMaxValue($value);
        $this->assertAttributeSame($expected, 'maxValue', $this->propertyDecimalDefinition);
    }

    /**
     * @depends testSetMaxValueCastsValueToIntegerAndSetsProperty
     */
    public function testGetMaxValueReturnsPropertyValue(): void
    {
        $this->propertyDecimalDefinition->setMaxValue(100);
        $this->assertSame(100, $this->propertyDecimalDefinition->getMaxValue());
    }

    /**
     * @dataProvider integerCastDataProvider
     * @param integer $expected
     */
    public function testSetMinValueCastsValueToIntegerAndSetsProperty($expected, mixed $value): void
    {
        @$this->propertyDecimalDefinition->setMinValue($value);
        $this->assertAttributeSame($expected, 'minValue', $this->propertyDecimalDefinition);
    }

    /**
     * @depends testSetMinValueCastsValueToIntegerAndSetsProperty
     */
    public function testGetMinValueReturnsPropertyValue(): void
    {
        $this->propertyDecimalDefinition->setMinValue(100);
        $this->assertSame(100, $this->propertyDecimalDefinition->getMinValue());
    }

    public function testSetPrecisionSetsProperty(): void
    {
        $precision = DecimalPrecision::cast(DecimalPrecision::BITS32);
        $this->propertyDecimalDefinition->setPrecision($precision);
        $this->assertAttributeSame($precision, 'precision', $this->propertyDecimalDefinition);
    }

    /**
     * @depends testSetPrecisionSetsProperty
     */
    public function testGetPrecisionReturnsPropertyValue(): void
    {
        $precision = DecimalPrecision::cast(DecimalPrecision::BITS32);
        $this->propertyDecimalDefinition->setPrecision($precision);
        $this->assertSame($precision, $this->propertyDecimalDefinition->getPrecision());
    }
}

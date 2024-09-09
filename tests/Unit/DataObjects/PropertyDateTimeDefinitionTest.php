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
use Dkd\PhpCmis\DataObjects\PropertyDateTimeDefinition;
use Dkd\PhpCmis\Enum\DateTimeResolution;

/**
 * Class PropertyDateTimeDefinitionTest
 */
class PropertyDateTimeDefinitionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PropertyDateTimeDefinition
     */
    protected $propertyDateTimeDefinition;

    public function setUp(): void
    {
        $this->propertyDateTimeDefinition = new PropertyDateTimeDefinition('testId');
    }

    public function testAssertIsInstanceOfAbstractPropertyDefinition(): void
    {
        $this->assertInstanceOf(
            AbstractPropertyDefinition::class,
            $this->propertyDateTimeDefinition
        );
    }

    public function testSetPrecisionSetsProperty(): void
    {
        $dateTimeResolution = DateTimeResolution::cast(DateTimeResolution::YEAR);
        $this->propertyDateTimeDefinition->setDateTimeResolution($dateTimeResolution);
        $this->assertAttributeSame($dateTimeResolution, 'dateTimeResolution', $this->propertyDateTimeDefinition);
    }

    /**
     * @depends testSetPrecisionSetsProperty
     */
    public function testGetPrecisionReturnsPropertyValue(): void
    {
        $dateTimeResolution = DateTimeResolution::cast(DateTimeResolution::YEAR);
        $this->propertyDateTimeDefinition->setDateTimeResolution($dateTimeResolution);
        $this->assertSame($dateTimeResolution, $this->propertyDateTimeDefinition->getDateTimeResolution());
    }
}

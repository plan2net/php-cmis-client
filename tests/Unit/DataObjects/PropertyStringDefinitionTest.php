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
use Dkd\PhpCmis\DataObjects\PropertyStringDefinition;
use Dkd\PhpCmis\Test\Unit\DataProviderCollectionTrait;

/**
 * Class PropertyStringDefinitionTest
 */
class PropertyStringDefinitionTest extends PHPUnit_Framework_TestCase
{
    use DataProviderCollectionTrait;

    /**
     * @var PropertyStringDefinition
     */
    protected $propertyStringDefinition;

    public function setUp(): void
    {
        $this->propertyStringDefinition = new PropertyStringDefinition('testId');
    }

    public function testAssertIsInstanceOfAbstractPropertyDefinition(): void
    {
        $this->assertInstanceOf(
            AbstractPropertyDefinition::class,
            $this->propertyStringDefinition
        );
    }

    /**
     * @dataProvider integerCastDataProvider
     * @param integer $expected
     */
    public function testSetMaxLengthCastsValueToIntegerAndSetsProperty($expected, mixed $value): void
    {
        @$this->propertyStringDefinition->setMaxLength($value);
        $this->assertAttributeSame($expected, 'maxLength', $this->propertyStringDefinition);
    }

    /**
     * @depends testSetMaxLengthCastsValueToIntegerAndSetsProperty
     */
    public function testGetMaxLengthReturnsPropertyValue(): void
    {
        $this->propertyStringDefinition->setMaxLength(100);
        $this->assertSame(100, $this->propertyStringDefinition->getMaxLength());
    }
}

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
use Dkd\PhpCmis\Definitions\ChoiceInterface;
use Dkd\PhpCmis\DataObjects\AbstractTypeDefinition;
use Dkd\PhpCmis\Enum\Cardinality;
use Dkd\PhpCmis\Enum\PropertyType;
use Dkd\PhpCmis\Enum\Updatability;
use Dkd\PhpCmis\Test\Unit\DataProviderCollectionTrait;

/**
 * Class AbstractPropertyDefinitionTest
 */
class AbstractPropertyDefinitionTest extends PHPUnit_Framework_TestCase
{
    use DataProviderCollectionTrait;

    /**
     * @var AbstractTypeDefinition
     */
    protected $abstractPropertyDefinition;

    protected $stringProperties = [
        'id',
        'localName',
        'localNamespace',
        'queryName',
        'displayName',
        'description'
    ];

    protected $booleanProperties = [
        'isInherited',
        'isQueryable',
        'isOrderable',
        'isRequired',
        'isOpenChoice',
    ];

    public function setUp(): void
    {
        $this->abstractPropertyDefinition = $this->getMockBuilder(
            AbstractPropertyDefinition::class
        )->setConstructorArgs(['testId'])->getMockForAbstractClass();
    }

    public function stringPropertyDataProvider()
    {
        $stringPropertyData = [];
        foreach ($this->stringProperties as $propertyName) {
            foreach ($this->stringCastDataProvider() as $stringPropertyTestValues) {
                $testDataSet = $stringPropertyTestValues;
                // Do not expect null values to be casted because they are allowed.
                // So the expected result for a given "null" is also "null" and not an empty string.
                if ($testDataSet[1] === null) {
                    $testDataSet[0] = null;
                }
                array_unshift($testDataSet, $propertyName);
                $stringPropertyData[] = $testDataSet;
            }
        }

        return $stringPropertyData;
    }

    public function booleanPropertyDataProvider()
    {
        $booleanPropertyData = [];
        foreach ($this->booleanProperties as $propertyName) {
            foreach ($this->booleanCastDataProvider() as $booleanPropertyTestValues) {
                $testDataSet = $booleanPropertyTestValues;
                array_unshift($testDataSet, $propertyName);
                $booleanPropertyData[] = $testDataSet;
            }
        }

        return $booleanPropertyData;
    }

    public function objectPropertyDataProvider()
    {
        $propertyType = PropertyType::cast(PropertyType::ID);
        $cardinality = Cardinality::cast(Cardinality::MULTI);
        $updatability = Updatability::cast(Updatability::ONCREATE);
        $choices = [
            $this->getMockBuilder(ChoiceInterface::class)->getMockForAbstractClass()
        ];

        return [
            ['propertyType', $propertyType, $propertyType],
            ['cardinality', $cardinality, $cardinality],
            ['updatability', $updatability, $updatability],
            ['choices', $choices, $choices],
        ];
    }

    public function arrayPropertyDataProvider()
    {
        return [
            ['defaultValue', [123], [123]]
        ];
    }

    public function propertyDataProvider()
    {
        return array_merge(
            $this->stringPropertyDataProvider(),
            $this->booleanPropertyDataProvider(),
            $this->objectPropertyDataProvider(),
            $this->arrayPropertyDataProvider()
        );
    }

    /**
     * Test setter for a property - should cast given value to expected type
     *
     * @dataProvider propertyDataProvider
     * @param string $propertyName
     */
    public function testPropertySetterSetsPropertyAndCastsToExpectedType(
        $propertyName,
        mixed $expectedAttributeValue,
        mixed $propertyValue
    ): void {
        $setterName = 'set' . ucfirst($propertyName);
        @$this->abstractPropertyDefinition->$setterName($propertyValue);
        $this->assertAttributeSame($expectedAttributeValue, $propertyName, $this->abstractPropertyDefinition);
    }

    /**
     * Test getter for a property
     *
     * @depends      testPropertySetterSetsPropertyAndCastsToExpectedType
     * @dataProvider propertyDataProvider
     * @param string $propertyName
     */
    public function testPropertyGetterReturnsPropertyValue($propertyName, mixed $expectedAttributeValue, mixed $propertyValue): void
    {
        $setterName = 'set' . ucfirst($propertyName);
        $getterName = preg_match('/^is[A-z].*/', $propertyName) ? $propertyName : 'get' . ucfirst($propertyName);
        @$this->abstractPropertyDefinition->$setterName($propertyValue);
        $this->assertSame(
            $expectedAttributeValue,
            $this->abstractPropertyDefinition->$getterName()
        );
    }
}

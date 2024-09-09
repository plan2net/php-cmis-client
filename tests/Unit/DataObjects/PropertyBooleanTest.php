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
use Dkd\PhpCmis\Exception\CmisInvalidArgumentException;
use Dkd\PhpCmis\DataObjects\PropertyBoolean;
use Dkd\PhpCmis\Test\Unit\DataProviderCollectionTrait;

/**
 * Class PropertyBooleanTest
 */
class PropertyBooleanTest extends PHPUnit_Framework_TestCase
{
    use DataProviderCollectionTrait;

    /**
     * @var PropertyBoolean
     */
    protected $propertyBoolean;

    public function setUp(): void
    {
        $this->propertyBoolean = new PropertyBoolean('testId');
    }

    /**
     * @dataProvider booleanCastDataProvider
     * @param boolean $expected
     */
    public function testSetValuesSetsProperty($expected, mixed $value): void
    {
        if ($value === null) {
            $expected = $value;
        }
        if (!is_bool($value) && $value !== null) {
            $this->setExpectedException(CmisInvalidArgumentException::class, '', 1413440336);
        }
        $values = [true, $value];
        $this->propertyBoolean->setValues($values);
        $this->assertAttributeSame([true, $expected], 'values', $this->propertyBoolean);
    }

    /**
     * @dataProvider booleanCastDataProvider
     * @param boolean $expected
     */
    public function testSetValueSetsValuesProperty($expected, mixed $value): void
    {
        if ($value === null) {
            $expected = $value;
        }
        if (!is_bool($value) && $value !== null) {
            $this->setExpectedException(CmisInvalidArgumentException::class, '', 1413440336);
        }
        $this->propertyBoolean->setValue($value);
        $this->assertAttributeSame([$expected], 'values', $this->propertyBoolean);
    }
}

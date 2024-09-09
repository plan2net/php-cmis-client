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
use Dkd\PhpCmis\DataObjects\PropertyInteger;
use Dkd\PhpCmis\Test\Unit\DataProviderCollectionTrait;

/**
 * Class PropertyIntegerTest
 */
class PropertyIntegerTest extends PHPUnit_Framework_TestCase
{
    use DataProviderCollectionTrait;

    /**
     * @var PropertyInteger
     */
    protected $propertyInteger;

    public function setUp(): void
    {
        $this->propertyInteger = new PropertyInteger('testId');
    }

    /**
     * @dataProvider integerCastDataProvider
     * @param integer $expected
     */
    public function testSetValuesSetsProperty($expected, mixed $value): void
    {
        if ($value === null) {
            $expected = $value;
        }

        if (!is_int($value) && $value !== null && !(PHP_INT_SIZE == 4 && is_float($value))) {
            $this->setExpectedException(CmisInvalidArgumentException::class, '', 1413440336);
        }

        $this->propertyInteger->setValues([$value]);
        $this->assertAttributeSame([$expected], 'values', $this->propertyInteger);
    }

    /**
     * @dataProvider integerCastDataProvider
     * @param integer $expected
     */
    public function testSetValueSetsValuesProperty($expected, mixed $value): void
    {
        if ($value === null) {
            $expected = $value;
        }

        if (!is_int($value) && $value !== null && !(PHP_INT_SIZE == 4 && is_float($value))) {
            $this->setExpectedException(CmisInvalidArgumentException::class, '', 1413440336);
        }

        $this->propertyInteger->setValue($value);
        $this->assertAttributeSame([$expected], 'values', $this->propertyInteger);
    }
}

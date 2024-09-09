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
use Dkd\PhpCmis\DataObjects\PropertyDecimal;

/**
 * Class PropertyDecimalTest
 */
class PropertyDecimalTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PropertyDecimal
     */
    protected $propertyDecimal;

    public function setUp(): void
    {
        $this->propertyDecimal = new PropertyDecimal('testId');
    }

    public function testSetValuesSetsProperty(): void
    {
        $values = [2.3, 5.0, null];
        $this->propertyDecimal->setValues($values);
        $this->assertAttributeSame($values, 'values', $this->propertyDecimal);
    }

    public function testSetValuesCastsIntegersSilentlyToDoublesAndSetsProperty(): void
    {
        $values = [2, 5];
        $this->propertyDecimal->setValues($values);
        $this->assertAttributeSame([2.0, 5.0], 'values', $this->propertyDecimal);
    }

    public function testSetValuesThrowsExceptionIfInvalidValuesGiven(): void
    {
        $this->setExpectedException(CmisInvalidArgumentException::class, '', 1413440336);
        $this->propertyDecimal->setValues(['']);
    }

    public function testSetValueSetsValuesProperty(): void
    {
        $this->propertyDecimal->setValue(2.2);
        $this->assertAttributeSame([2.2], 'values', $this->propertyDecimal);
    }

    public function testSetValueThrowsExceptionIfInvalidValueGiven(): void
    {
        $this->setExpectedException(CmisInvalidArgumentException::class, '', 1413440336);
        $this->propertyDecimal->setValue(['']);
    }
}

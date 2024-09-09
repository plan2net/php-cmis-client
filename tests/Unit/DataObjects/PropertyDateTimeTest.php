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
use DateTime;
use Dkd\PhpCmis\Exception\CmisInvalidArgumentException;
use Dkd\PhpCmis\DataObjects\PropertyDateTime;
use Dkd\PhpCmis\Test\Unit\DataProviderCollectionTrait;

/**
 * Class PropertyDateTimeTest
 */
class PropertyDateTimeTest extends PHPUnit_Framework_TestCase
{
    use DataProviderCollectionTrait;

    /**
     * @var PropertyDateTime
     */
    protected $propertyDateTime;

    public function setUp(): void
    {
        $this->propertyDateTime = new PropertyDateTime('testId');
    }

    public function testSetValuesSetsProperty(): void
    {
        $values = [new DateTime()];
        $this->propertyDateTime->setValues($values);
        $this->assertAttributeSame($values, 'values', $this->propertyDateTime);
    }

    public function testSetValuesThrowsExceptionIfInvalidValuesGiven(): void
    {
        $this->setExpectedException(CmisInvalidArgumentException::class, '', 1413440336);
        $this->propertyDateTime->setValues(['now']);
    }

    public function testSetValueSetsValuesProperty(): void
    {
        $date = new DateTime();
        $this->propertyDateTime->setValue($date);
        $this->assertAttributeSame([$date], 'values', $this->propertyDateTime);
    }

    public function testSetValueThrowsExceptionIfInvalidValueGiven(): void
    {
        $this->setExpectedException(CmisInvalidArgumentException::class, '', 1413440336);
        $this->propertyDateTime->setValue('now');
    }
}

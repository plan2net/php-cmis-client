<?php
namespace Dkd\PhpCmis\Test\Unit;

/*
 * This file is part of php-cmis-lib.
 *
 * (c) Sascha Egerer <sascha.egerer@dkd.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use PHPUnit_Framework_TestCase;
use stdClass;
use Dkd\PhpCmis\DataObjects\ObjectId;

/**
 * Class ObjectIdTest
 */
class ObjectIdTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider invalidIdValuesDataProvider
     */
    public function testConstructorThrowsExceptionIfNoStringAsIdGiven(mixed $idValue): void
    {
        $this->setExpectedException('\\InvalidArgumentException', 'Id must not be empty!');
        new ObjectId($idValue);
    }

    /**
     * Data provider with invalid id values
     *
     * @return array
     */
    public function invalidIdValuesDataProvider()
    {
        return [
            [''],
            [null],
            [0],
            [1],
            [['foo']],
            [new stdClass()]
        ];
    }

    public function testConstructorSetsIdProperty(): void
    {
        $objectId = new ObjectId('foo');
        $this->assertAttributeSame('foo', 'id', $objectId);
    }

    public function testGetIdReturnsId(): void
    {
        $objectId = new ObjectId('foo');
        $this->assertSame('foo', $objectId->getId());
    }

    public function testToStringReturnsIdAsString(): void
    {
        $objectId = new ObjectId('foo');
        $this->assertSame('foo', (string) $objectId);
    }
}

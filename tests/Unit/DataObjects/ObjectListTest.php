<?php
namespace Dkd\PhpCmis\Test\Unit\DataObjects;

/*
 * This file is part of php-cmis-lib.
 *
 * (c) Dimitri Ebert <dimitri.ebert@dkd.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use PHPUnit_Framework_TestCase;
use Dkd\PhpCmis\Exception\CmisInvalidArgumentException;
use stdClass;
use Dkd\PhpCmis\Data\ObjectDataInterface;
use Dkd\PhpCmis\DataObjects\ObjectList;

/**
 * Class ObjectListTest
 */
class ObjectListTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectList
     */
    protected $objectList;

    public function setUp(): void
    {
        $this->objectList = new ObjectList([$this->getObjectDataMock()]);
    }

    public function testSetObjectsSetsProperty(): void
    {
        $objects = [$this->getObjectDataMock()];
        $this->objectList->setObjects($objects);
        $this->assertAttributeSame($objects, 'objects', $this->objectList);
    }

    public function testSetObjectsThrowsExceptionIfAGivenObjectIsNotOfTypeObjectDataInterface(): void
    {
        $this->setExpectedException(CmisInvalidArgumentException::class);
        $this->objectList->setObjects([new stdClass()]);
    }

    /**
     * @depends testSetObjectsSetsProperty
     */
    public function testGetObjectsReturnsPropertyValue(): void
    {
        $objects = [
            $this->getObjectDataMock(),
            $this->getObjectDataMock()
        ];
        $this->objectList->setObjects($objects);
        $this->assertSame($objects, $this->objectList->getObjects());
    }

    public function testSetHasMoreItemsSetsHasMoreItems(): void
    {
        $this->objectList->setHasMoreItems(true);
        $this->assertAttributeSame(true, 'hasMoreItems', $this->objectList);
        $this->objectList->setHasMoreItems(false);
        $this->assertAttributeSame(false, 'hasMoreItems', $this->objectList);
    }

    public function testSetHasMoreItemsCastsValueToBoolean(): void
    {
        $this->setExpectedException('\\PHPUnit_Framework_Error_Notice');
        $this->objectList->setHasMoreItems(1);
        $this->assertAttributeSame(true, 'hasMoreItems', $this->objectList);
    }

    /**
     * @depends testSetHasMoreItemsSetsHasMoreItems
     */
    public function testHasMoreItemsReturnsHasMoreItems(): void
    {
        $this->objectList->setHasMoreItems(true);
        $this->assertTrue($this->objectList->hasMoreItems());
        $this->objectList->setHasMoreItems(false);
        $this->assertFalse($this->objectList->hasMoreItems());
    }

    public function testSetNumItemsSetsNumItems(): void
    {
        $this->objectList->setNumItems(2);
        $this->assertAttributeSame(2, 'numItems', $this->objectList);
        $this->objectList->setNumItems(3);
        $this->assertAttributeSame(3, 'numItems', $this->objectList);
    }

    /**
     * @depends testSetNumItemsSetsNumItems
     */
    public function testNumItemsReturnsNumItems(): void
    {
        $this->objectList->setNumItems(2);
        $this->assertEquals(2, $this->objectList->getNumItems());
        $this->objectList->setNumItems(3);
        $this->assertEquals(3, $this->objectList->getNumItems());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ObjectDataInterface
     */
    protected function getObjectDataMock()
    {
        return $this->getMockBuilder(
            ObjectDataInterface::class
        )->disableOriginalConstructor()->getMockForAbstractClass();
    }
}

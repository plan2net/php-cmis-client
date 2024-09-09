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
use Dkd\PhpCmis\Data\ObjectInFolderDataInterface;
use Dkd\PhpCmis\Exception\CmisInvalidArgumentException;
use stdClass;
use Dkd\PhpCmis\DataObjects\ObjectInFolderData;
use Dkd\PhpCmis\DataObjects\ObjectInFolderList;

/**
 * Class ObjectInFolderListTest
 */
class ObjectInFolderListTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectInFolderList
     */
    protected $objectInFolderList;

    /**
     * @var ObjectInFolderData
     */
    protected $objectInFolderData;

    public function setUp(): void
    {
        $this->objectInFolderData = $this->getMockBuilder(
            ObjectInFolderDataInterface::class
        )->disableOriginalConstructor()->getMockForAbstractClass();

        $this->objectInFolderList = new ObjectInFolderList([$this->objectInFolderData]);
    }

    public function testSetObjectsSetsProperty(): void
    {
        $objects = [$this->objectInFolderData];
        $this->objectInFolderList->setObjects($objects);
        $this->assertAttributeSame($objects, 'objects', $this->objectInFolderList);
    }

    public function testSetObjectsThrowsExceptionIfAGivenObjectIsNotOfTypeObjectInFolderDataInterface(): void
    {
        $this->setExpectedException(CmisInvalidArgumentException::class);
        $this->objectInFolderList->setObjects([new stdClass()]);
    }

    /**
     * @depends testSetObjectsSetsProperty
     */
    public function testGetObjectsReturnsPropertyValue(): void
    {
        $objects = [$this->objectInFolderData];
        $this->objectInFolderList->setObjects($objects);
        $this->assertSame($objects, $this->objectInFolderList->getObjects());
    }

    public function testSetHasMoreItemsSetsHasMoreItems(): void
    {
        $this->objectInFolderList->setHasMoreItems(true);
        $this->assertAttributeSame(true, 'hasMoreItems', $this->objectInFolderList);
        $this->objectInFolderList->setHasMoreItems(false);
        $this->assertAttributeSame(false, 'hasMoreItems', $this->objectInFolderList);
    }

    public function testSetHasMoreItemsCastsValueToBoolean(): void
    {
        $this->setExpectedException('\\PHPUnit_Framework_Error_Notice');
        $this->objectInFolderList->setHasMoreItems(1);
        $this->assertAttributeSame(true, 'hasMoreItems', $this->objectInFolderList);
    }

    /**
     * @depends testSetHasMoreItemsSetsHasMoreItems
     */
    public function testHasMoreItemsReturnsHasMoreItems(): void
    {
        $this->objectInFolderList->setHasMoreItems(true);
        $this->assertTrue($this->objectInFolderList->hasMoreItems());
        $this->objectInFolderList->setHasMoreItems(false);
        $this->assertFalse($this->objectInFolderList->hasMoreItems());
    }

    public function testSetNumItemsSetsNumItems(): void
    {
        $this->objectInFolderList->setNumItems(2);
        $this->assertAttributeSame(2, 'numItems', $this->objectInFolderList);
        $this->objectInFolderList->setNumItems(3);
        $this->assertAttributeSame(3, 'numItems', $this->objectInFolderList);
    }

    /**
     * @depends testSetNumItemsSetsNumItems
     */
    public function testNumItemsReturnsNumItems(): void
    {
        $this->objectInFolderList->setNumItems(2);
        $this->assertEquals(2, $this->objectInFolderList->getNumItems());
        $this->objectInFolderList->setNumItems(3);
        $this->assertEquals(3, $this->objectInFolderList->getNumItems());
    }
}

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
use Dkd\PhpCmis\Data\ObjectInFolderContainerInterface;
use Dkd\PhpCmis\DataObjects\ObjectInFolderData;
use Dkd\PhpCmis\DataObjects\ObjectInFolderContainer;

/**
 * Class ObjectInFolderContainerTest
 */
class ObjectInFolderContainerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectInFolderContainer
     */
    protected $objectInFolderContainer;

    public function setUp(): void
    {
        $this->objectInFolderContainer = new ObjectInFolderContainer(new ObjectInFolderData());
    }

    public function testSetObjectSetsProperty(): void
    {
        $objectData = $this->getMockForAbstractClass(ObjectInFolderDataInterface::class);
        $this->objectInFolderContainer->setObject($objectData);
        $this->assertAttributeSame($objectData, 'object', $this->objectInFolderContainer);
    }

    /**
     * @depends testSetObjectSetsProperty
     */
    public function testGetObjectReturnsPropertyValue(): void
    {
        $objectData = $this->getMockForAbstractClass(ObjectInFolderDataInterface::class);
        $this->objectInFolderContainer->setObject($objectData);
        $this->assertSame($objectData, $this->objectInFolderContainer->getObject());
    }

    public function testSetObjectsSetsProperty(): void
    {
        $children = [$this->getObjectInFolderContainerMock()];

        $this->objectInFolderContainer->setChildren($children);
        $this->assertAttributeSame($children, 'children', $this->objectInFolderContainer);
    }

    public function testSetChildrenThrowsExceptionIfAGivenObjectIsNotOfTypeObjectInFolderContainerInterface(): void
    {
        $this->setExpectedException(CmisInvalidArgumentException::class);
        $this->objectInFolderContainer->setChildren([new stdClass()]);
    }

    /**
     * @depends testSetObjectsSetsProperty
     */
    public function testGetObjectsReturnsPropertyValue(): void
    {
        $children = [$this->getObjectInFolderContainerMock()];

        $this->objectInFolderContainer->setChildren($children);
        $this->assertSame($children, $this->objectInFolderContainer->getChildren());
    }

    public function testConstructorSetsObject(): void
    {
        $expectedObject = new ObjectInFolderData;
        $objectInFolderContainer = new ObjectInFolderContainer($expectedObject);
        $this->assertAttributeSame($expectedObject, 'object', $objectInFolderContainer);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ObjectInFolderContainerInterface
     */
    protected function getObjectInFolderContainerMock()
    {
        return $this->getMockBuilder(
            ObjectInFolderContainerInterface::class
        )->disableOriginalConstructor()->getMockForAbstractClass();
    }
}

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
use Dkd\PhpCmis\Data\ObjectDataInterface;
use Dkd\PhpCmis\DataObjects\ObjectInFolderData;

/**
 * Class ObjectInFolderDataTest
 */
class ObjectInFolderDataTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectInFolderData
     */
    protected $objectInFolderData;

    public function setUp(): void
    {
        $this->objectInFolderData = new ObjectInFolderData();
    }

    public function testSetObjectSetsProperty(): void
    {
        $objectData = $this->getMockForAbstractClass(ObjectDataInterface::class);
        $this->objectInFolderData->setObject($objectData);
        $this->assertAttributeSame($objectData, 'object', $this->objectInFolderData);
    }

    /**
     * @depends testSetObjectSetsProperty
     */
    public function testGetObjectReturnsPropertyValue(): void
    {
        $objectData = $this->getMockForAbstractClass(ObjectDataInterface::class);
        $this->objectInFolderData->setObject($objectData);
        $this->assertSame($objectData, $this->objectInFolderData->getObject());
    }

    public function testSetPathSegmentSetsProperty(): void
    {
        $this->objectInFolderData->setPathSegment('foo');
        $this->assertAttributeSame('foo', 'pathSegment', $this->objectInFolderData);
        $this->objectInFolderData->setPathSegment('bar');
        $this->assertAttributeSame('bar', 'pathSegment', $this->objectInFolderData);
    }

    public function testSetPathSegmentSetsPropertyAsNull(): void
    {
        $this->objectInFolderData->setPathSegment(null);
        $this->assertAttributeSame(null, 'pathSegment', $this->objectInFolderData);
    }

    /**
     * @depends testSetPathSegmentSetsProperty
     */
    public function testGetPathSegmentReturnsPropertyValue(): void
    {
        $this->objectInFolderData->setPathSegment('foo');
        $this->assertEquals('foo', $this->objectInFolderData->getPathSegment());
        $this->objectInFolderData->setPathSegment('bar');
        $this->assertEquals('bar', $this->objectInFolderData->getPathSegment());
    }
}

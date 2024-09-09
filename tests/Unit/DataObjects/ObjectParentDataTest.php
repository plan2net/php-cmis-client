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
use Dkd\PhpCmis\DataObjects\ObjectParentData;

/**
 * Class ObjectParentDataTest
 */
class ObjectParentDataTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectParentData
     */
    protected $objectParentData;

    public function setUp(): void
    {
        $this->objectParentData = new ObjectParentData();
    }

    public function testSetObjectSetsProperty(): void
    {
        $objectData = $this->getMockForAbstractClass(ObjectDataInterface::class);
        $this->objectParentData->setObject($objectData);
        $this->assertAttributeSame($objectData, 'object', $this->objectParentData);
    }

    /**
     * @depends testSetObjectSetsProperty
     */
    public function testGetObjectReturnsPropertyValue(): void
    {
        $objectData = $this->getMockForAbstractClass(ObjectDataInterface::class);
        $this->objectParentData->setObject($objectData);
        $this->assertSame($objectData, $this->objectParentData->getObject());
    }

    public function testSetRelativePathSegmentSetsProperty(): void
    {
        $this->objectParentData->setRelativePathSegment('foo');
        $this->assertAttributeSame('foo', 'relativePathSegment', $this->objectParentData);
        $this->objectParentData->setRelativePathSegment('bar');
        $this->assertAttributeSame('bar', 'relativePathSegment', $this->objectParentData);
    }

    /**
     * @depends testSetRelativePathSegmentSetsProperty
     */
    public function testGetRelativePathSegmentReturnsPropertyValue(): void
    {
        $this->objectParentData->setRelativePathSegment('foo');
        $this->assertEquals('foo', $this->objectParentData->getRelativePathSegment());
        $this->objectParentData->setRelativePathSegment('bar');
        $this->assertEquals('bar', $this->objectParentData->getRelativePathSegment());
    }
}

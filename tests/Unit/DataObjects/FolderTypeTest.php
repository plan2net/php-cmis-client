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
use Dkd\PhpCmis\SessionInterface;
use Dkd\PhpCmis\DataObjects\FolderType;
use Dkd\PhpCmis\DataObjects\FolderTypeDefinition;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Class FolderTypeTest
 */
class FolderTypeTest extends PHPUnit_Framework_TestCase
{
    public function testConstructorSetsSession(): void
    {
        /**
         * @var SessionInterface|PHPUnit_Framework_MockObject_MockObject $sessionMock
         */
        $sessionMock = $this->getMockBuilder(SessionInterface::class)->getMockForAbstractClass();

        $folderTypeDefinition = new FolderTypeDefinition('typeId');
        $errorReportingLevel = error_reporting(E_ALL & ~E_USER_NOTICE);
        $folderType = new FolderType($sessionMock, $folderTypeDefinition);
        error_reporting($errorReportingLevel);

        $this->assertAttributeSame($sessionMock, 'session', $folderType);
    }

    public function testConstructorCallsPopulateMethod(): void
    {
        /**
         * @var SessionInterface|PHPUnit_Framework_MockObject_MockObject $sessionMock
         */
        $sessionMock = $this->getMockBuilder(SessionInterface::class)->getMockForAbstractClass();

        $folderTypeDefinition = new FolderTypeDefinition('typeId');

        /**
         * @var FolderType|PHPUnit_Framework_MockObject_MockObject $folderType
         */
        $folderType = $this->getMockBuilder(FolderType::class)->setMethods(
            ['populate']
        )->disableOriginalConstructor()->getMock();
        $folderType->expects($this->once())->method('populate')->with(
            $folderTypeDefinition
        );
        $folderType->__construct($sessionMock, $folderTypeDefinition);
    }
}

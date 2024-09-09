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
use Dkd\PhpCmis\DataObjects\SecondaryType;
use Dkd\PhpCmis\DataObjects\SecondaryTypeDefinition;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Class SecondaryTypeTest
 */
class SecondaryTypeTest extends PHPUnit_Framework_TestCase
{
    public function testConstructorSetsSession(): void
    {
        /**
         * @var SessionInterface|PHPUnit_Framework_MockObject_MockObject $sessionMock
         */
        $sessionMock = $this->getMockBuilder(SessionInterface::class)->getMockForAbstractClass();

        $secondaryTypeDefinition = new SecondaryTypeDefinition('typeId');
        $errorReportingLevel = error_reporting(E_ALL & ~E_USER_NOTICE);
        $secondaryType = new SecondaryType($sessionMock, $secondaryTypeDefinition);
        error_reporting($errorReportingLevel);

        $this->assertAttributeSame($sessionMock, 'session', $secondaryType);
    }

    public function testConstructorCallsPopulateMethod(): void
    {
        /**
         * @var SessionInterface|PHPUnit_Framework_MockObject_MockObject $sessionMock
         */
        $sessionMock = $this->getMockBuilder(SessionInterface::class)->getMockForAbstractClass();

        $secondaryTypeDefinition = new SecondaryTypeDefinition('typeId');

        /**
         * @var SecondaryType|PHPUnit_Framework_MockObject_MockObject $secondaryType
         */
        $secondaryType = $this->getMockBuilder(SecondaryType::class)->setMethods(
            ['populate']
        )->disableOriginalConstructor()->getMock();
        $secondaryType->expects($this->once())->method('populate')->with(
            $secondaryTypeDefinition
        );
        $secondaryType->__construct($sessionMock, $secondaryTypeDefinition);
    }
}

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
use Dkd\PhpCmis\DataObjects\DocumentType;
use Dkd\PhpCmis\DataObjects\DocumentTypeDefinition;
use Dkd\PhpCmis\Definitions\DocumentTypeDefinitionInterface;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Class DocumentTypeTest
 */
class DocumentTypeTest extends PHPUnit_Framework_TestCase
{
    public function testConstructorSetsSession(): void
    {
        /**
         * @var SessionInterface|PHPUnit_Framework_MockObject_MockObject $sessionMock
         */
        $sessionMock = $this->getMockBuilder(SessionInterface::class)->getMockForAbstractClass();

        /**
         * @var DocumentTypeDefinitionInterface|PHPUnit_Framework_MockObject_MockObject $documentTypeDefinition
         */
        $documentTypeDefinition = new DocumentTypeDefinition('typeId');
        $errorReportingLevel = error_reporting(E_ALL & ~E_USER_NOTICE);
        $documentType = new DocumentType($sessionMock, $documentTypeDefinition);
        error_reporting($errorReportingLevel);

        $this->assertAttributeSame($sessionMock, 'session', $documentType);
    }

    public function testConstructorCallsPopulateMethod(): void
    {
        /**
         * @var SessionInterface|PHPUnit_Framework_MockObject_MockObject $sessionMock
         */
        $sessionMock = $this->getMockBuilder(SessionInterface::class)->getMockForAbstractClass();

        $documentTypeDefinition = new DocumentTypeDefinition('typeId');

        /**
         * @var DocumentType|PHPUnit_Framework_MockObject_MockObject $documentType
         */
        $documentType = $this->getMockBuilder(DocumentType::class)->setMethods(
            ['populate']
        )->disableOriginalConstructor()->getMock();
        $documentType->expects($this->once())->method('populate')->with(
            $documentTypeDefinition
        );
        $documentType->__construct($sessionMock, $documentTypeDefinition);
    }
}

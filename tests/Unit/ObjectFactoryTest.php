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
use Dkd\PhpCmis\Bindings\CmisBindingInterface;
use Dkd\PhpCmis\Data\BindingsObjectFactoryInterface;
use Dkd\PhpCmis\Data\AclInterface;
use Dkd\PhpCmis\Data\AceInterface;
use Dkd\PhpCmis\Exception\CmisRuntimeException;
use Dkd\PhpCmis\Definitions\TypeDefinitionInterface;
use Dkd\PhpCmis\DataObjects\DocumentType;
use Dkd\PhpCmis\DataObjects\DocumentTypeDefinition;
use Dkd\PhpCmis\DataObjects\FolderType;
use Dkd\PhpCmis\DataObjects\FolderTypeDefinition;
use Dkd\PhpCmis\DataObjects\RelationshipType;
use Dkd\PhpCmis\DataObjects\RelationshipTypeDefinition;
use Dkd\PhpCmis\DataObjects\PolicyType;
use Dkd\PhpCmis\DataObjects\PolicyTypeDefinition;
use Dkd\PhpCmis\DataObjects\ItemType;
use Dkd\PhpCmis\DataObjects\ItemTypeDefinition;
use Dkd\PhpCmis\DataObjects\SecondaryType;
use Dkd\PhpCmis\DataObjects\SecondaryTypeDefinition;
use Dkd\PhpCmis\Exception\CmisInvalidArgumentException;
use Dkd\PhpCmis\QueryResult;
use Dkd\PhpCmis\DataObjects\ObjectData;
use Dkd\PhpCmis\ObjectFactory;
use Dkd\PhpCmis\PropertyIds;
use Dkd\PhpCmis\SessionInterface;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Class ObjectFactoryTest
 */
class ObjectFactoryTest extends PHPUnit_Framework_TestCase
{
    use ReflectionHelperTrait;

    const CLASS_TO_TEST = '\\Dkd\\PhpCmis\\ObjectFactory';

    /**
     * @param SessionInterface|PHPUnit_Framework_MockObject_MockObject $session
     * @return ObjectFactory
     */
    public function getObjectFactory($session = null)
    {
        if ($session === null) {
            $session = $this->getMockBuilder(SessionInterface::class)->getMockForAbstractClass();
        }
        $objectFactory = new ObjectFactory();
        $objectFactory->initialize($session);

        return $objectFactory;
    }

    public function testInitializeSetsGivenSessionAsProperty(): void
    {
        $sessionMock = $this->getMockBuilder(SessionInterface::class)->getMockForAbstractClass();
        $this->assertAttributeSame($sessionMock, 'session', $this->getObjectFactory($sessionMock));
    }

    public function testGetBindingsObjectFactoryReturnsBindingsObjectFactoryFromSession(): void
    {
        $bindingMock = $this->getMockBuilder(CmisBindingInterface::class)->setMethods(
            ['getObjectFactory']
        )->getMockForAbstractClass();
        $bindingObjectFactoryMock = $this->getMockBuilder(
            BindingsObjectFactoryInterface::class
        )->getMockForAbstractClass();

        $bindingMock->expects($this->once())->method('getObjectFactory')->willReturn($bindingObjectFactoryMock);
        /** @var SessionInterface|PHPUnit_Framework_MockObject_MockObject $sessionMock */
        $sessionMock = $this->getMockBuilder(SessionInterface::class)->setMethods(
            ['getBinding']
        )->getMockForAbstractClass();
        $sessionMock->expects($this->once())->method('getBinding')->willReturn($bindingMock);
        $objectFactory = $this->getObjectFactory($sessionMock);

        $method = $this->getMethod(self::CLASS_TO_TEST, 'getBindingsObjectFactory');
        $this->assertSame($bindingObjectFactoryMock, $method->invoke($objectFactory));
    }

    /**
     * @covers Dkd\PhpCmis\ObjectFactory::convertAces
     */
    public function testConvertAcesConvertsAcesToAcl(): void
    {
        $expectedAcl = $this->getMockForAbstractClass(AclInterface::class);
        $aces = [
            $this->getMockForAbstractClass(AceInterface::class),
            $this->getMockForAbstractClass(AceInterface::class)
        ];

        $bindingMock = $this->getMockBuilder(CmisBindingInterface::class)->setMethods(
            ['getObjectFactory']
        )->getMockForAbstractClass();
        $bindingObjectFactoryMock = $this->getMockBuilder(
            BindingsObjectFactoryInterface::class
        )->setMethods(['createAccessControlList'])->getMockForAbstractClass();
        $bindingObjectFactoryMock->expects($this->once())->method('createAccessControlList')->with($aces)->willReturn(
            $expectedAcl
        );
        $bindingMock->expects($this->any())->method('getObjectFactory')->willReturn($bindingObjectFactoryMock);
        /** @var SessionInterface|PHPUnit_Framework_MockObject_MockObject $sessionMock */
        $sessionMock = $this->getMockBuilder(SessionInterface::class)->setMethods(
            ['getBinding']
        )->getMockForAbstractClass();
        $sessionMock->expects($this->any())->method('getBinding')->willReturn($bindingMock);
        $objectFactory = $this->getObjectFactory($sessionMock);

        $this->assertSame($expectedAcl, $objectFactory->convertAces($aces));
    }

    public function testConvertTypeDefinitionThrowsExceptionIfUnknownTypeDefinitionIsGiven(): void
    {
        $this->setExpectedException(CmisRuntimeException::class, '', 1422028427);
        $this->getObjectFactory()->convertTypeDefinition(
            $this->getMockForAbstractClass(TypeDefinitionInterface::class)
        );
    }

    /**
     * @dataProvider convertTypeDefinitionDataProvider
     * @param $expectedInstance
     * @param $typeDefinition
     */
    public function testConvertTypeDefinitionConvertsTypeDefinitionToAType($expectedInstance, $typeDefinition): void
    {
        $errorReportingLevel = error_reporting(E_ALL & ~E_USER_NOTICE);
        $instance = $this->getObjectFactory()->convertTypeDefinition($typeDefinition);
        error_reporting($errorReportingLevel);
        $this->assertInstanceOf($expectedInstance, $instance);
    }

    /**
     * @return array
     */
    public function convertTypeDefinitionDataProvider()
    {
        return [
            [
                DocumentType::class,
                new DocumentTypeDefinition('typeId')
            ],
            [
                FolderType::class,
                new FolderTypeDefinition('typeId')
            ],
            [
                RelationshipType::class,
                new RelationshipTypeDefinition('typeId')
            ],
            [
                PolicyType::class,
                new PolicyTypeDefinition('typeId')
            ],
            [
                ItemType::class,
                new ItemTypeDefinition('typeId')
            ],
            [
                SecondaryType::class,
                new SecondaryTypeDefinition('typeId')
            ]
        ];
    }

    public function testConvertPropertiesReturnsNullIfNoPropertiesGiven(): void
    {
        $this->assertNull($this->getObjectFactory()->convertProperties([]));
    }

    public function testConvertPropertiesThrowsExceptionIfSecondaryTypesPropertyIsSetButNotAnArray(): void
    {
        $this->setExpectedException(CmisInvalidArgumentException::class, '', 1425473414);
        $this->getObjectFactory()->convertProperties(
            [
                PropertyIds::OBJECT_TYPE_ID => 'type-id',
                PropertyIds::SECONDARY_OBJECT_TYPE_IDS => 'invalidValue'
            ]
        );
    }

    public function testConvertQueryResult(): void
    {
        $objectData = new ObjectData();
        $this->assertInstanceOf(
            QueryResult::class,
            $this->getObjectFactory()->convertQueryResult($objectData)
        );
    }

    // TODO Write unit tests for convertProperties
}

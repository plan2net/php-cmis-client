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
use Dkd\PhpCmis\Data\ObjectTypeInterface;
use Dkd\PhpCmis\DataObjects\RelationshipType;
use Dkd\PhpCmis\DataObjects\RelationshipTypeDefinition;
use Dkd\PhpCmis\SessionInterface;
use Dkd\PhpCmis\Test\Unit\ReflectionHelperTrait;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Class RelationshipTypeTest
 */
class RelationshipTypeTest extends PHPUnit_Framework_TestCase
{
    use ReflectionHelperTrait;

    /**
     * @var SessionInterface|PHPUnit_Framework_MockObject_MockObject
     */
    protected $sessionMock;

    /**
     * @var RelationshipType
     */
    protected $relationshipType;

    /**
     * @var ObjectTypeInterface
     */
    protected $objectTypeDefinitionMock;

    /**
     * @covers \Dkd\PhpCmis\DataObjects\RelationshipType::__construct
     */
    public function setUp(): void
    {
        $this->sessionMock = $this->getMockBuilder(SessionInterface::class)->setMethods(
            ['getTypeDefinition']
        )->getMockForAbstractClass();
        $this->objectTypeDefinitionMock = $this->getMockBuilder(
            ObjectTypeInterface::class
        )->getMockForAbstractClass();
        $this->sessionMock->expects($this->any())->method('getTypeDefinition')->willReturn(
            $this->objectTypeDefinitionMock
        );

        $errorReportingLevel = error_reporting(E_ALL & ~E_USER_NOTICE);
        $this->relationshipType = new RelationshipType($this->sessionMock, new RelationshipTypeDefinition('typeId'));
        error_reporting($errorReportingLevel);
    }

    public function testConstructorSetsSession(): void
    {
        $this->assertAttributeSame($this->sessionMock, 'session', $this->relationshipType);
    }

    /**
     * @covers \Dkd\PhpCmis\DataObjects\RelationshipType::__construct
     */
    public function testConstructorCallsPopulateMethod(): void
    {
        $relationshipTypeDefinition = new RelationshipTypeDefinition('typeId');

        /**
         * @var RelationshipType|PHPUnit_Framework_MockObject_MockObject $relationshipType
         */
        $relationshipType = $this->getMockBuilder(RelationshipType::class)->setMethods(
            ['populate']
        )->disableOriginalConstructor()->getMock();

        $relationshipType->expects($this->once())->method('populate')->with(
            $relationshipTypeDefinition
        );
        $relationshipType->__construct($this->sessionMock, $relationshipTypeDefinition);
    }

    public function testSetAllowedSourceTypeIdsResetsAllowedSourceTypesParameter(): void
    {
        // set the property to a dummy value
        $this->setProtectedProperty($this->relationshipType, 'allowedSourceTypes', ['foo', 'bar']);

        $this->relationshipType->setAllowedSourceTypeIds(['baz']);
        $this->assertAttributeEquals(null, 'allowedSourceTypes', $this->relationshipType);
    }

    public function testSetAllowedTargetTypeIdsResetsAllowedTargetTypesParameter(): void
    {
        // set the property to a dummy value
        $this->setProtectedProperty($this->relationshipType, 'allowedTargetTypes', ['foo', 'bar']);

        $this->relationshipType->setAllowedTargetTypeIds(['baz']);
        $this->assertAttributeEquals(null, 'allowedTargetTypes', $this->relationshipType);
    }

    public function testGetAllowedSourceTypesReturnsPropertyValue(): void
    {
        $allowedSourceTypes =  ['foo', 'bar'];
        // set the property to a dummy value
        $this->setProtectedProperty($this->relationshipType, 'allowedSourceTypes', $allowedSourceTypes);
        $this->assertSame($allowedSourceTypes, $this->relationshipType->getAllowedSourceTypes());
    }

    public function testGetAllowedSourceTypesSetsAllowedSourceTypesPropertyGeneratedOnIdsAndReturnsResult(): void
    {
        $this->setProtectedProperty($this->relationshipType, 'allowedSourceTypeIds', ['foo']);
        $this->assertSame([$this->objectTypeDefinitionMock], $this->relationshipType->getAllowedSourceTypes());
    }

    public function testGetAllowedTargetTypesReturnsPropertyValue(): void
    {
        $allowedTargetTypes =  ['foo', 'bar'];
        // set the property to a dummy value
        $this->setProtectedProperty($this->relationshipType, 'allowedTargetTypes', $allowedTargetTypes);
        $this->assertSame($allowedTargetTypes, $this->relationshipType->getAllowedTargetTypes());
    }

    public function testGetAllowedTargetTypesSetsAllowedTargetTypesPropertyGeneratedOnIdsAndReturnsResult(): void
    {
        $this->setProtectedProperty($this->relationshipType, 'allowedTargetTypeIds', ['foo']);
        $this->assertSame([$this->objectTypeDefinitionMock], $this->relationshipType->getAllowedTargetTypes());
    }
}

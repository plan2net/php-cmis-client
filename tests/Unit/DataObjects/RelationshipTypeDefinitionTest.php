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
use Dkd\PhpCmis\DataObjects\RelationshipTypeDefinition;

/**
 * Class RelationshipTypeDefinitionTest
 */
class RelationshipTypeDefinitionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var RelationshipTypeDefinition
     */
    protected $relationshipTypeDefinition;

    public function setUp(): void
    {
        $this->relationshipTypeDefinition = new RelationshipTypeDefinition('typeId');
    }

    public function testPopulateWithClonesMethodCopiesPropertyValuesFromGivenTypeDefinition(): void
    {
        $dummyTypeDefinition = new RelationshipTypeDefinition('typeId');
        $dummyTypeDefinition->setAllowedTargetTypeIds(['foo']);
        $dummyTypeDefinition->setAllowedSourceTypeIds(['bar']);

        $errorReportingLevel = error_reporting(E_ALL & ~E_USER_NOTICE);
        $this->relationshipTypeDefinition->populateWithClones($dummyTypeDefinition);
        error_reporting($errorReportingLevel);
        $this->assertEquals($dummyTypeDefinition, $this->relationshipTypeDefinition);
    }

    public function testDefaultValuesAreEmpty(): void
    {
        $this->assertAttributeSame([], 'allowedTargetTypeIds', $this->relationshipTypeDefinition);
        $this->assertAttributeSame([], 'allowedTargetTypeIds', $this->relationshipTypeDefinition);
    }

    public function testSetAllowedTargetTypeIdsSetsProperty(): void
    {
        $this->relationshipTypeDefinition->setAllowedTargetTypeIds(['foo']);
        $this->assertAttributeSame(['foo'], 'allowedTargetTypeIds', $this->relationshipTypeDefinition);
    }

    /**
     * @depends testSetAllowedTargetTypeIdsSetsProperty
     */
    public function testGetAllowedTargetTypeIdsGetsProperty(): void
    {
        $this->relationshipTypeDefinition->setAllowedTargetTypeIds(['foo']);
        $this->assertSame(['foo'], $this->relationshipTypeDefinition->getAllowedTargetTypeIds());
    }

    public function testSetAllowedSourceTypeIdsSetsProperty(): void
    {
        $this->relationshipTypeDefinition->setAllowedSourceTypeIds(['foo']);
        $this->assertAttributeSame(['foo'], 'allowedSourceTypeIds', $this->relationshipTypeDefinition);
    }

    /**
     * @depends testSetAllowedSourceTypeIdsSetsProperty
     */
    public function testGetAllowedSourceTypeIdsGetsProperty(): void
    {
        $this->relationshipTypeDefinition->setAllowedSourceTypeIds(['foo']);
        $this->assertSame(['foo'], $this->relationshipTypeDefinition->getAllowedSourceTypeIds());
    }
}

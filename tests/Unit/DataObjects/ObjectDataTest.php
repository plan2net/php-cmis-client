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
use Dkd\PhpCmis\Data\AclInterface;
use Dkd\PhpCmis\Data\AllowableActionsInterface;
use Dkd\PhpCmis\Data\ChangeEventInfoInterface;
use Dkd\PhpCmis\Data\PolicyIdListInterface;
use Dkd\PhpCmis\Data\PropertiesInterface;
use Dkd\PhpCmis\Data\ObjectDataInterface;
use Dkd\PhpCmis\DataObjects\ObjectData;
use Dkd\PhpCmis\DataObjects\Properties;
use Dkd\PhpCmis\DataObjects\PropertyId;
use Dkd\PhpCmis\Enum\BaseTypeId;
use Dkd\PhpCmis\PropertyIds;

/**
 * Class ObjectDataTest
 */
class ObjectDataTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectData
     */
    protected $objectData;

    public function setUp(): void
    {
        $this->objectData = new ObjectData();
    }

    public function testSetAclSetsProperty(): void
    {
        $acl = $this->getMockForAbstractClass(AclInterface::class);
        $this->objectData->setAcl($acl);
        $this->assertAttributeSame($acl, 'acl', $this->objectData);
    }

    /**
     * @depends testSetAclSetsProperty
     */
    public function testGetAclReturnsPropertyValue(): void
    {
        $acl = $this->getMockForAbstractClass(AclInterface::class);
        $this->objectData->setAcl($acl);
        $this->assertSame($acl, $this->objectData->getAcl());
    }

    public function testSetAllowableActionsSetsProperty(): void
    {
        $allowableActions = $this->getMockForAbstractClass(AllowableActionsInterface::class);
        $this->objectData->setAllowableActions($allowableActions);
        $this->assertAttributeSame($allowableActions, 'allowableActions', $this->objectData);
    }

    /**
     * @depends testSetAllowableActionsSetsProperty
     */
    public function testGetAllowableActionsReturnsPropertyValue(): void
    {
        $allowableActions = $this->getMockForAbstractClass(AllowableActionsInterface::class);
        $this->objectData->setAllowableActions($allowableActions);
        $this->assertSame($allowableActions, $this->objectData->getAllowableActions());
    }

    public function testSetChangeEventInfoSetsProperty(): void
    {
        $changeEventInfo = $this->getMockForAbstractClass(ChangeEventInfoInterface::class);
        $this->objectData->setChangeEventInfo($changeEventInfo);
        $this->assertAttributeSame($changeEventInfo, 'changeEventInfo', $this->objectData);
    }

    /**
     * @depends testSetChangeEventInfoSetsProperty
     */
    public function testGetChangeEventInfoReturnsPropertyValue(): void
    {
        $changeEventInfo = $this->getMockForAbstractClass(ChangeEventInfoInterface::class);
        $this->objectData->setChangeEventInfo($changeEventInfo);
        $this->assertSame($changeEventInfo, $this->objectData->getChangeEventInfo());
    }

    public function testSetIsExactAclSetsProperty(): void
    {
        $this->objectData->setIsExactAcl(true);
        $this->assertAttributeSame(true, 'isExactAcl', $this->objectData);
        $this->objectData->setIsExactAcl(false);
        $this->assertAttributeSame(false, 'isExactAcl', $this->objectData);
    }

    /**
     * @depends testSetIsExactAclSetsProperty
     */
    public function testGetIsExactAclReturnsPropertyValue(): void
    {
        $this->objectData->setIsExactAcl(true);
        $this->assertTrue($this->objectData->isExactAcl());
    }


    public function testSetPolicyIdsSetsProperty(): void
    {
        $policyIds = $this->getMockForAbstractClass(PolicyIdListInterface::class);
        $this->objectData->setPolicyIds($policyIds);
        $this->assertAttributeSame($policyIds, 'policyIds', $this->objectData);
    }

    /**
     * @depends testSetPolicyIdsSetsProperty
     */
    public function testGetPolicyIdsReturnsPropertyValue(): void
    {
        $policyIds = $this->getMockForAbstractClass(PolicyIdListInterface::class);
        $this->objectData->setPolicyIds($policyIds);
        $this->assertSame($policyIds, $this->objectData->getPolicyIds());
    }

    public function testSetPropertiesSetsProperty(): void
    {
        $properties = $this->getMockForAbstractClass(PropertiesInterface::class);
        $this->objectData->setProperties($properties);
        $this->assertAttributeSame($properties, 'properties', $this->objectData);
    }

    /**
     * @depends testSetPropertiesSetsProperty
     */
    public function testGetPropertiesReturnsPropertyValue(): void
    {
        $properties = $this->getMockForAbstractClass(PropertiesInterface::class);
        $this->objectData->setProperties($properties);
        $this->assertSame($properties, $this->objectData->getProperties());
    }

    public function testSetRelationshipsSetsProperty(): void
    {
        $relationships = [$this->getMockForAbstractClass(ObjectDataInterface::class)];
        $this->objectData->setRelationships($relationships);
        $this->assertAttributeSame($relationships, 'relationships', $this->objectData);
    }

    /**
     * @depends testSetRelationshipsSetsProperty
     */
    public function testGetRelationshipsReturnsPropertyValue(): void
    {
        $relationships = [$this->getMockForAbstractClass(ObjectDataInterface::class)];
        $this->objectData->setRelationships($relationships);
        $this->assertSame($relationships, $this->objectData->getRelationships());
    }

    public function testSetRenditionsSetsProperty(): void
    {
        $renditions = [$this->getMockForAbstractClass(ObjectDataInterface::class)];
        $this->objectData->setRenditions($renditions);
        $this->assertAttributeSame($renditions, 'renditions', $this->objectData);
    }

    /**
     * @depends testSetRenditionsSetsProperty
     */
    public function testGetRenditionsReturnsPropertyValue(): void
    {
        $renditions = [$this->getMockForAbstractClass(ObjectDataInterface::class)];
        $this->objectData->setRenditions($renditions);
        $this->assertSame($renditions, $this->objectData->getRenditions());
    }

    public function testGetIdReturnsNullIfPropertyDoesNotExist(): void
    {
        $this->assertNull($this->objectData->getId());
    }

    public function testGetIdReturnsIdPropertyValue(): void
    {
        $idProperty = new PropertyId(PropertyIds::OBJECT_ID, 'fooPropertyId');
        $properties = new Properties();
        $properties->addProperty($idProperty);
        $this->objectData->setProperties($properties);

        $this->assertSame('fooPropertyId', $this->objectData->getId());
    }

    public function testGetIdReturnsFirstValueOfIdMultiValuePropertyValue(): void
    {
        $idProperty = new PropertyId(PropertyIds::OBJECT_ID, ['fooPropertyId', 'secondValue']);
        $properties = new Properties();
        $properties->addProperty($idProperty);
        $this->objectData->setProperties($properties);

        $this->assertSame('fooPropertyId', $this->objectData->getId());
    }

    public function testGetBaseTypeIdReturnsNullIfPropertyDoesNotExist(): void
    {
        $this->assertNull($this->objectData->getBaseTypeId());
    }

    public function testGetBaseTypeIdReturnsNullIfRequestedPropertyDoesNotExist(): void
    {
        $idProperty = new PropertyId(PropertyIds::OBJECT_ID, ['fooPropertyId', 'secondValue']);
        $properties = new Properties();
        $properties->addProperty($idProperty);
        $this->objectData->setProperties($properties);

        $this->assertNull($this->objectData->getBaseTypeId());
    }

    public function testGetBaseTypeIdReturnsNullIfBaseTypeIdValueIsInvalid(): void
    {
        $idProperty = new PropertyId(PropertyIds::BASE_TYPE_ID, 'invalidBaseTypeId');
        $properties = new Properties();
        $properties->addProperty($idProperty);
        $this->objectData->setProperties($properties);

        $this->assertNull($this->objectData->getBaseTypeId());
    }

    public function testGetBaseTypeIdReturnsIdPropertyValue(): void
    {
        $idProperty = new PropertyId(PropertyIds::BASE_TYPE_ID, 'cmis:item');
        $properties = new Properties();
        $properties->addProperty($idProperty);
        $this->objectData->setProperties($properties);

        $this->assertEquals(BaseTypeId::cast(BaseTypeId::CMIS_ITEM), $this->objectData->getBaseTypeId());
    }

    public function testGetBaseTypeIdReturnsFirstValueOfIdMultiValuePropertyValue(): void
    {
        $idProperty = new PropertyId(PropertyIds::BASE_TYPE_ID, ['cmis:item', 'cmis:document']);
        $properties = new Properties();
        $properties->addProperty($idProperty);
        $this->objectData->setProperties($properties);

        $this->assertEquals(BaseTypeId::cast(BaseTypeId::CMIS_ITEM), $this->objectData->getBaseTypeId());
    }
}

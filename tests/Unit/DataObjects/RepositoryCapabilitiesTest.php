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
use Dkd\PhpCmis\DataObjects\CreatablePropertyTypes;
use Dkd\PhpCmis\DataObjects\NewTypeSettableAttributes;
use Dkd\PhpCmis\DataObjects\RepositoryCapabilities;
use Dkd\PhpCmis\Enum\CapabilityAcl;
use Dkd\PhpCmis\Enum\CapabilityChanges;
use Dkd\PhpCmis\Enum\CapabilityContentStreamUpdates;
use Dkd\PhpCmis\Enum\CapabilityJoin;
use Dkd\PhpCmis\Enum\CapabilityOrderBy;
use Dkd\PhpCmis\Enum\CapabilityQuery;
use Dkd\PhpCmis\Enum\CapabilityRenditions;
use Dkd\PhpCmis\Test\Unit\DataProviderCollectionTrait;

/**
 * Class RepositoryCapabilitiesTest
 */
class RepositoryCapabilitiesTest extends PHPUnit_Framework_TestCase
{
    use DataProviderCollectionTrait;

    /**
     * @var RepositoryCapabilities
     */
    protected $repositoryCapabilities;

    public function setUp(): void
    {
        $this->repositoryCapabilities = new RepositoryCapabilities();
    }

    public function testSetAclCapabilitySetsProperty(): void
    {
        $aclCapability = CapabilityAcl::cast(CapabilityAcl::DISCOVER);
        $this->repositoryCapabilities->setAclCapability($aclCapability);
        $this->assertAttributeSame($aclCapability, 'aclCapability', $this->repositoryCapabilities);
    }

    /**
     * @depends testSetAclCapabilitySetsProperty
     */
    public function testGetAclCapabilityReturnsPropertyValue(): void
    {
        $aclCapability = CapabilityAcl::cast(CapabilityAcl::DISCOVER);
        $this->repositoryCapabilities->setAclCapability($aclCapability);
        $this->assertSame($aclCapability, $this->repositoryCapabilities->getAclCapability());
    }

    public function testSetChangesCapabilitySetsProperty(): void
    {
        $changesCapability = CapabilityChanges::cast(CapabilityChanges::PROPERTIES);
        $this->repositoryCapabilities->setChangesCapability($changesCapability);
        $this->assertAttributeSame($changesCapability, 'changesCapability', $this->repositoryCapabilities);
    }

    /**
     * @depends testSetChangesCapabilitySetsProperty
     */
    public function testGetChangesCapabilityReturnsPropertyValue(): void
    {
        $changesCapability = CapabilityChanges::cast(CapabilityChanges::PROPERTIES);
        $this->repositoryCapabilities->setChangesCapability($changesCapability);
        $this->assertSame($changesCapability, $this->repositoryCapabilities->getChangesCapability());
    }

    /**
     * @dataProvider booleanCastDataProvider
     * @param boolean $expected
     */
    public function testSetSupportsAllVersionsSearchableSetsProperty($expected, mixed $value): void
    {
        $this->repositoryCapabilities->setSupportsAllVersionsSearchable($value);
        $this->assertAttributeSame($expected, 'supportsAllVersionsSearchable', $this->repositoryCapabilities);
    }

    /**
     * @depends testSetSupportsAllVersionsSearchableSetsProperty
     */
    public function testIsAllVersionsSearchableReturnsPropertyValue(): void
    {
        $this->repositoryCapabilities->setSupportsAllVersionsSearchable(true);
        $this->assertSame(true, $this->repositoryCapabilities->isAllVersionsSearchableSupported());
    }

    /**
     * @dataProvider booleanCastDataProvider
     * @param boolean $expected
     */
    public function testSetIsPwcSearchableSetsProperty($expected, mixed $value): void
    {
        $this->repositoryCapabilities->setSupportsPwcSearchable($value);
        $this->assertAttributeSame($expected, 'isPwcSearchable', $this->repositoryCapabilities);
    }

    /**
     * @depends testSetIsPwcSearchableSetsProperty
     */
    public function testIsIsPwcSearchableReturnsPropertyValue(): void
    {
        $this->repositoryCapabilities->setSupportsPwcSearchable(true);
        $this->assertSame(true, $this->repositoryCapabilities->isPwcSearchableSupported());
    }

    /**
     * @dataProvider booleanCastDataProvider
     * @param boolean $expected
     */
    public function testSetIsPwcUpdatableSetsProperty($expected, mixed $value): void
    {
        $this->repositoryCapabilities->setSupportsPwcUpdatable($value);
        $this->assertAttributeSame($expected, 'isPwcUpdatable', $this->repositoryCapabilities);
    }

    /**
     * @depends testSetIsPwcUpdatableSetsProperty
     */
    public function testIsIsPwcUpdatableReturnsPropertyValue(): void
    {
        $this->repositoryCapabilities->setSupportsPwcUpdatable(true);
        $this->assertSame(true, $this->repositoryCapabilities->isPwcUpdatableSupported());
    }

    public function testSetContentStreamUpdatesCapabilitySetsProperty(): void
    {
        $ContentStreamUpdatesCapability = CapabilityContentStreamUpdates::cast(CapabilityContentStreamUpdates::PWCONLY);
        $this->repositoryCapabilities->setContentStreamUpdatesCapability($ContentStreamUpdatesCapability);
        $this->assertAttributeSame(
            $ContentStreamUpdatesCapability,
            'contentStreamUpdatesCapability',
            $this->repositoryCapabilities
        );
    }

    /**
     * @depends testSetContentStreamUpdatesCapabilitySetsProperty
     */
    public function testGetContentStreamUpdatesCapabilityReturnsPropertyValue(): void
    {
        $ContentStreamUpdatesCapability = CapabilityContentStreamUpdates::cast(CapabilityContentStreamUpdates::PWCONLY);
        $this->repositoryCapabilities->setContentStreamUpdatesCapability($ContentStreamUpdatesCapability);
        $this->assertSame(
            $ContentStreamUpdatesCapability,
            $this->repositoryCapabilities->getContentStreamUpdatesCapability()
        );
    }

    public function testSetCreatablePropertyTypesSetsProperty(): void
    {
        $creatablePropertyTypes = new CreatablePropertyTypes();
        $this->repositoryCapabilities->setCreatablePropertyTypes($creatablePropertyTypes);
        $this->assertAttributeSame($creatablePropertyTypes, 'creatablePropertyTypes', $this->repositoryCapabilities);
    }

    /**
     * @depends testSetCreatablePropertyTypesSetsProperty
     */
    public function testGetCreatablePropertyTypesReturnsPropertyValue(): void
    {
        $creatablePropertyTypes = new CreatablePropertyTypes();
        $this->repositoryCapabilities->setCreatablePropertyTypes($creatablePropertyTypes);
        $this->assertSame($creatablePropertyTypes, $this->repositoryCapabilities->getCreatablePropertyTypes());
    }

    public function testSetJoinCapabilitySetsProperty(): void
    {
        $joinCapability = CapabilityJoin::cast(CapabilityJoin::INNERANDOUTER);
        $this->repositoryCapabilities->setJoinCapability($joinCapability);
        $this->assertAttributeSame($joinCapability, 'joinCapability', $this->repositoryCapabilities);
    }

    /**
     * @depends testSetJoinCapabilitySetsProperty
     */
    public function testGetJoinCapabilityReturnsPropertyValue(): void
    {
        $joinCapability = CapabilityJoin::cast(CapabilityJoin::INNERANDOUTER);
        $this->repositoryCapabilities->setJoinCapability($joinCapability);
        $this->assertSame($joinCapability, $this->repositoryCapabilities->getJoinCapability());
    }

    public function testSetNewTypeSettableAttributesSetsProperty(): void
    {
        $newTypeSettableAttributes = new NewTypeSettableAttributes();
        $this->repositoryCapabilities->setNewTypeSettableAttributes($newTypeSettableAttributes);
        $this->assertAttributeSame(
            $newTypeSettableAttributes,
            'newTypeSettableAttributes',
            $this->repositoryCapabilities
        );
    }

    /**
     * @depends testSetNewTypeSettableAttributesSetsProperty
     */
    public function testGetNewTypeSettableAttributesReturnsPropertyValue(): void
    {
        $newTypeSettableAttributes = new NewTypeSettableAttributes();
        $this->repositoryCapabilities->setNewTypeSettableAttributes($newTypeSettableAttributes);
        $this->assertSame($newTypeSettableAttributes, $this->repositoryCapabilities->getNewTypeSettableAttributes());
    }

    public function testSetOrderByCapabilitySetsProperty(): void
    {
        $orderByCapability = CapabilityOrderBy::cast(CapabilityOrderBy::CUSTOM);
        $this->repositoryCapabilities->setOrderByCapability($orderByCapability);
        $this->assertAttributeSame($orderByCapability, 'orderByCapability', $this->repositoryCapabilities);
    }

    /**
     * @depends testSetOrderByCapabilitySetsProperty
     */
    public function testGetOrderByCapabilityReturnsPropertyValue(): void
    {
        $orderByCapability = CapabilityOrderBy::cast(CapabilityOrderBy::CUSTOM);
        $this->repositoryCapabilities->setOrderByCapability($orderByCapability);
        $this->assertSame($orderByCapability, $this->repositoryCapabilities->getOrderByCapability());
    }

    public function testSetQueryCapabilitySetsProperty(): void
    {
        $queryCapability = CapabilityQuery::cast(CapabilityQuery::BOTHCOMBINED);
        $this->repositoryCapabilities->setQueryCapability($queryCapability);
        $this->assertAttributeSame($queryCapability, 'queryCapability', $this->repositoryCapabilities);
    }

    /**
     * @depends testSetQueryCapabilitySetsProperty
     */
    public function testGetQueryCapabilityReturnsPropertyValue(): void
    {
        $queryCapability = CapabilityQuery::cast(CapabilityQuery::BOTHCOMBINED);
        $this->repositoryCapabilities->setQueryCapability($queryCapability);
        $this->assertSame($queryCapability, $this->repositoryCapabilities->getQueryCapability());
    }

    public function testSetRenditionsCapabilitySetsProperty(): void
    {
        $renditionsCapability = CapabilityRenditions::cast(CapabilityRenditions::NONE);
        $this->repositoryCapabilities->setRenditionsCapability($renditionsCapability);
        $this->assertAttributeSame($renditionsCapability, 'renditionsCapability', $this->repositoryCapabilities);
    }

    /**
     * @depends testSetRenditionsCapabilitySetsProperty
     */
    public function testGetRenditionsCapabilityReturnsPropertyValue(): void
    {
        $renditionsCapability = CapabilityRenditions::cast(CapabilityRenditions::NONE);
        $this->repositoryCapabilities->setRenditionsCapability($renditionsCapability);
        $this->assertSame($renditionsCapability, $this->repositoryCapabilities->getRenditionsCapability());
    }

    /**
     * @dataProvider booleanCastDataProvider
     * @param boolean $expected
     */
    public function testSetSupportsGetDescendantsSetsProperty($expected, mixed $value): void
    {
        $this->repositoryCapabilities->setSupportsGetDescendants($value);
        $this->assertAttributeSame($expected, 'supportsGetDescendants', $this->repositoryCapabilities);
    }

    /**
     * @depends testSetIsPwcUpdatableSetsProperty
     */
    public function testSetIsGetDescendantsSupportedReturnsPropertyValue(): void
    {
        $this->repositoryCapabilities->setSupportsGetDescendants(true);
        $this->assertSame(true, $this->repositoryCapabilities->isGetDescendantsSupported());
    }

    /**
     * @dataProvider booleanCastDataProvider
     * @param boolean $expected
     */
    public function testSetSupportsGetFolderTreeSetsProperty($expected, mixed $value): void
    {
        $this->repositoryCapabilities->setSupportsGetFolderTree($value);
        $this->assertAttributeSame($expected, 'supportsGetFolderTree', $this->repositoryCapabilities);
    }

    /**
     * @depends testSetIsPwcUpdatableSetsProperty
     */
    public function testSetIsGetFolderTreeSupportedReturnsPropertyValue(): void
    {
        $this->repositoryCapabilities->setSupportsGetFolderTree(true);
        $this->assertSame(true, $this->repositoryCapabilities->isGetFolderTreeSupported());
    }

    /**
     * @dataProvider booleanCastDataProvider
     * @param boolean $expected
     */
    public function testSetSupportsMultifilingSetsProperty($expected, mixed $value): void
    {
        $this->repositoryCapabilities->setSupportsMultifiling($value);
        $this->assertAttributeSame($expected, 'supportsMultifiling', $this->repositoryCapabilities);
    }

    /**
     * @depends testSetIsPwcUpdatableSetsProperty
     */
    public function testSetIsMultifilingSupportedReturnsPropertyValue(): void
    {
        $this->repositoryCapabilities->setSupportsMultifiling(true);
        $this->assertSame(true, $this->repositoryCapabilities->isMultifilingSupported());
    }

    /**
     * @dataProvider booleanCastDataProvider
     * @param boolean $expected
     */
    public function testSetSupportsUnfilingSetsProperty($expected, mixed $value): void
    {
        $this->repositoryCapabilities->setSupportsUnfiling($value);
        $this->assertAttributeSame($expected, 'supportsUnfiling', $this->repositoryCapabilities);
    }

    /**
     * @depends testSetIsPwcUpdatableSetsProperty
     */
    public function testSetIsUnfilingSupportedReturnsPropertyValue(): void
    {
        $this->repositoryCapabilities->setSupportsUnfiling(true);
        $this->assertSame(true, $this->repositoryCapabilities->isUnfilingSupported());
    }

    /**
     * @dataProvider booleanCastDataProvider
     * @param boolean $expected
     */
    public function testSetSupportsVersionSpecificFilingSetsProperty($expected, mixed $value): void
    {
        $this->repositoryCapabilities->setSupportsVersionSpecificFiling($value);
        $this->assertAttributeSame($expected, 'supportsVersionSpecificFiling', $this->repositoryCapabilities);
    }

    /**
     * @depends testSetIsPwcUpdatableSetsProperty
     */
    public function testSetIsVersionSpecificFilingSupportedReturnsPropertyValue(): void
    {
        $this->repositoryCapabilities->setSupportsVersionSpecificFiling(true);
        $this->assertSame(true, $this->repositoryCapabilities->isVersionSpecificFilingSupported());
    }
}

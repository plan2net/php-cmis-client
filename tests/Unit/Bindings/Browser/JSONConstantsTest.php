<?php
namespace Dkd\PhpCmis\Test\Unit\Bindings\Browser;

/*
 * This file is part of php-cmis-client
 *
 * (c) Sascha Egerer <sascha.egerer@dkd.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use PHPUnit_Framework_TestCase;
use Dkd\PhpCmis\Bindings\Browser\JSONConstants;

/**
 * Class JSONConstantsTest
 */
class JSONConstantsTest extends PHPUnit_Framework_TestCase
{

    public function testGetRepositoryInfoKeysReturnsContentOfStaticArray(): void
    {
        $this->assertSame(
            $this->getStaticAttribute(JSONConstants::class, 'REPOSITORY_INFO_KEYS'),
            JSONConstants::getRepositoryInfoKeys()
        );
    }

    public function testGetCapabilityKeysReturnsContentOfStaticArray(): void
    {
        $this->assertSame(
            $this->getStaticAttribute(JSONConstants::class, 'CAPABILITY_KEYS'),
            JSONConstants::getCapabilityKeys()
        );
    }

    public function testGetCapabilityCreatablePropertyKeysReturnsContentOfStaticArray(): void
    {
        $this->assertSame(
            $this->getStaticAttribute(
                JSONConstants::class,
                'CAPABILITY_CREATABLE_PROPERTY_KEYS'
            ),
            JSONConstants::getCapabilityCreatablePropertyKeys()
        );
    }

    public function testGetCapabilityNewTypeSettableAttributeKeysReturnsContentOfStaticArray(): void
    {
        $this->assertSame(
            $this->getStaticAttribute(
                JSONConstants::class,
                'CAP_NEW_TYPE_SETTABLE_ATTRIBUTES_KEYS'
            ),
            JSONConstants::getCapabilityNewTypeSettableAttributeKeys()
        );
    }

    public function testGetAclCapabilityKeysReturnsContentOfStaticArray(): void
    {
        $this->assertSame(
            $this->getStaticAttribute(JSONConstants::class, 'ACL_CAPABILITY_KEYS'),
            JSONConstants::getAclCapabilityKeys()
        );
    }

    public function testGetAclCapabilityPermissionKeysReturnsContentOfStaticArray(): void
    {
        $this->assertSame(
            $this->getStaticAttribute(
                JSONConstants::class,
                'ACL_CAPABILITY_PERMISSION_KEYS'
            ),
            JSONConstants::getAclCapabilityPermissionKeys()
        );
    }

    public function testGetAclCapabilityMappingKeysReturnsContentOfStaticArray(): void
    {
        $this->assertSame(
            $this->getStaticAttribute(
                JSONConstants::class,
                'ACL_CAPABILITY_MAPPING_KEYS'
            ),
            JSONConstants::getAclCapabilityMappingKeys()
        );
    }

    public function testGetObjectKeysReturnsContentOfStaticArray(): void
    {
        $this->assertSame(
            $this->getStaticAttribute(JSONConstants::class, 'OBJECT_KEYS'),
            JSONConstants::getObjectKeys()
        );
    }

    public function testGetPropertyKeysReturnsContentOfStaticArray(): void
    {
        $this->assertSame(
            $this->getStaticAttribute(JSONConstants::class, 'PROPERTY_KEYS'),
            JSONConstants::getPropertyKeys()
        );
    }

    public function testGetChangeEventKeysReturnsContentOfStaticArray(): void
    {
        $this->assertSame(
            $this->getStaticAttribute(JSONConstants::class, 'CHANGE_EVENT_KEYS'),
            JSONConstants::getChangeEventKeys()
        );
    }

    public function testGetRenditionKeysReturnsContentOfStaticArray(): void
    {
        $this->assertSame(
            $this->getStaticAttribute(JSONConstants::class, 'RENDITION_KEYS'),
            JSONConstants::getRenditionKeys()
        );
    }

    public function testGetFeatureKeysReturnsContentOfStaticArray(): void
    {
        $this->assertSame(
            $this->getStaticAttribute(JSONConstants::class, 'FEATURE_KEYS'),
            JSONConstants::getFeatureKeys()
        );
    }

    public function testGetPolicyIdsKeysReturnsContentOfStaticArray(): void
    {
        $this->assertSame(
            $this->getStaticAttribute(JSONConstants::class, 'POLICY_IDS_KEYS'),
            JSONConstants::getPolicyIdsKeys()
        );
    }

    public function testGetAclKeysReturnsContentOfStaticArray(): void
    {
        $this->assertSame(
            $this->getStaticAttribute(JSONConstants::class, 'ACL_KEYS'),
            JSONConstants::getAclKeys()
        );
    }

    public function testGetPrincipalKeysReturnsContentOfStaticArray(): void
    {
        $this->assertSame(
            $this->getStaticAttribute(JSONConstants::class, 'ACE_PRINCIPAL_KEYS'),
            JSONConstants::getAcePrincipalKeys()
        );
    }

    public function testGetAceKeysReturnsContentOfStaticArray(): void
    {
        $this->assertSame(
            $this->getStaticAttribute(JSONConstants::class, 'ACE_KEYS'),
            JSONConstants::getAceKeys()
        );
    }

    public function testGetTypeKeysReturnsContentOfStaticArray(): void
    {
        $this->assertSame(
            $this->getStaticAttribute(JSONConstants::class, 'TYPE_KEYS'),
            JSONConstants::getTypeKeys()
        );
    }

    public function testGetPropertyTypeKeysReturnsContentOfStaticArray(): void
    {
        $this->assertSame(
            $this->getStaticAttribute(JSONConstants::class, 'PROPERTY_TYPE_KEYS'),
            JSONConstants::getPropertyTypeKeys()
        );
    }

    public function testGetTypeTypeMutabilityKeysReturnsContentOfStaticArray(): void
    {
        $this->assertSame(
            $this->getStaticAttribute(
                JSONConstants::class,
                'TYPE_TYPE_MUTABILITY_KEYS'
            ),
            JSONConstants::getTypeTypeMutabilityKeys()
        );
    }

    public function testGetObjectInFolderKeysReturnsContentOfStaticArray(): void
    {
        $this->assertSame(
            $this->getStaticAttribute(
                JSONConstants::class,
                'OBJECTINFOLDER_KEYS'
            ),
            JSONConstants::getObjectInFolderKeys()
        );
    }

    public function testGetObjectInFolderListKeysReturnsContentOfStaticArray(): void
    {
        $this->assertSame(
            $this->getStaticAttribute(
                JSONConstants::class,
                'OBJECTINFOLDERLIST_KEYS'
            ),
            JSONConstants::getObjectInFolderListKeys()
        );
    }

    public function testGetObjectInFolderContainerKeysReturnsContentOfStaticArray(): void
    {
        $this->assertSame(
            $this->getStaticAttribute(
                JSONConstants::class,
                'OBJECTINFOLDERCONTAINER_KEYS'
            ),
            JSONConstants::getObjectInFolderContainerKeys()
        );
    }

    public function testGetObjectParentsKeysReturnsContentOfStaticArray(): void
    {
        $this->assertSame(
            $this->getStaticAttribute(
                JSONConstants::class,
                'OBJECTPARENTS_KEYS'
            ),
            JSONConstants::getObjectParentsKeys()
        );
    }

    public function testGetQueryResultListKeysReturnsContentOfStaticArray(): void
    {
        $this->assertSame(
            $this->getStaticAttribute(
                JSONConstants::class,
                'QUERYRESULTLIST_KEYS'
            ),
            JSONConstants::getQueryResultListKeys()
        );
    }

    public function testGetFailedToDeleteKeysReturnsContentOfStaticArray(): void
    {
        $this->assertSame(
            $this->getStaticAttribute(
                JSONConstants::class,
                'FAILEDTODELETE_KEYS'
            ),
            JSONConstants::getFailedToDeleteKeys()
        );
    }

    public function testGetTypesContainerKeysReturnsContentOfStaticArray(): void
    {
        $this->assertSame(
            $this->getStaticAttribute(
                JSONConstants::class,
                'TYPESCONTAINER_KEYS'
            ),
            JSONConstants::getTypesContainerKeys()
        );
    }

    public function testGetTypesListKeysReturnsContentOfStaticArray(): void
    {
        $this->assertSame(
            $this->getStaticAttribute(
                JSONConstants::class,
                'TYPESLIST_KEYS'
            ),
            JSONConstants::getTypesListKeys()
        );
    }
}

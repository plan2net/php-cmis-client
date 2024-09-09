<?php
namespace Dkd\PhpCmis\DataObjects;

/*
 * This file is part of php-cmis-client.
 *
 * (c) Sascha Egerer <sascha.egerer@dkd.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Dkd\PhpCmis\Data\AclCapabilitiesInterface;
use Dkd\PhpCmis\Data\ExtensionFeatureInterface;
use Dkd\PhpCmis\Data\RepositoryCapabilitiesInterface;
use Dkd\PhpCmis\Data\RepositoryInfoInterface;
use Dkd\PhpCmis\Enum\BaseTypeId;
use Dkd\PhpCmis\Enum\CmisVersion;

/**
 * Repository info data implementation.
 */
class RepositoryInfo extends AbstractExtensionData implements RepositoryInfoInterface
{
    /**
     * @var string
     */
    protected $id = '';

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var CmisVersion
     */
    protected $cmisVersion;

    /**
     * @var RepositoryCapabilitiesInterface
     */
    protected $capabilities;

    /**
     * @var string
     */
    protected $rootFolderId = '';

    /**
     * @var AclCapabilitiesInterface
     */
    protected $aclCapabilities;

    /**
     * @var string
     */
    protected $principalIdAnonymous = '';

    /**
     * @var string
     */
    protected $principalIdAnyone = '';

    /**
     * @var string
     */
    protected $thinClientUri = '';

    /**
     * @var boolean
     */
    protected $changesIncomplete = false;

    /**
     * @var BaseTypeId[]
     */
    protected $changesOnType = [];

    /**
     * @var string
     */
    protected $latestChangeLogToken = '';

    /**
     * @var string
     */
    protected $vendorName = '';

    /**
     * @var string
     */
    protected $productName = '';

    /**
     * @var string
     */
    protected $productVersion = '';

    /**
     * @var ExtensionFeatureInterface[]
     */
    protected $extensionFeatures = [];

    public function setAclCapabilities(AclCapabilitiesInterface $aclCapabilities): void
    {
        $this->aclCapabilities = $aclCapabilities;
    }

    public function setCapabilities(RepositoryCapabilitiesInterface $capabilities): void
    {
        $this->capabilities = $capabilities;
    }

    /**
     * @param boolean $changesIncomplete
     */
    public function setChangesIncomplete($changesIncomplete): void
    {
        $this->changesIncomplete = $this->castValueToSimpleType('boolean', $changesIncomplete);
    }

    /**
     * @param BaseTypeId[] $changesOnType
     */
    public function setChangesOnType(array $changesOnType): void
    {
        foreach ($changesOnType as $baseTypeId) {
            $this->checkType(BaseTypeId::class, $baseTypeId);
        }
        $this->changesOnType = $changesOnType;
    }

    /**
     * @param string $description
     */
    public function setDescription($description): void
    {
        $this->description = $this->castValueToSimpleType('string', $description);
    }

    /**
     * @param ExtensionFeatureInterface[] $extensionFeatures
     */
    public function setExtensionFeatures(array $extensionFeatures): void
    {
        foreach ($extensionFeatures as $extensionFeature) {
            $this->checkType(ExtensionFeatureInterface::class, $extensionFeature);
        }
        $this->extensionFeatures = $extensionFeatures;
    }

    /**
     * @param string $id
     */
    public function setId($id): void
    {
        $this->id = $this->castValueToSimpleType('string', $id, true);
    }

    /**
     * @param string $latestChangeLogToken
     */
    public function setLatestChangeLogToken($latestChangeLogToken): void
    {
        $this->latestChangeLogToken = $this->castValueToSimpleType('string', $latestChangeLogToken, true);
    }

    /**
     * @param string $name
     */
    public function setName($name): void
    {
        $this->name = $this->castValueToSimpleType('string', $name, true);
    }

    /**
     * @param string $principalIdAnonymous
     */
    public function setPrincipalIdAnonymous($principalIdAnonymous): void
    {
        $this->principalIdAnonymous = $this->castValueToSimpleType('string', $principalIdAnonymous, true);
    }

    /**
     * @param string $principalIdAnyone
     */
    public function setPrincipalIdAnyone($principalIdAnyone): void
    {
        $this->principalIdAnyone = $this->castValueToSimpleType('string', $principalIdAnyone, true);
    }

    /**
     * @param string $productName
     */
    public function setProductName($productName): void
    {
        $this->productName = $this->castValueToSimpleType('string', $productName, true);
    }

    /**
     * @param string $productVersion
     */
    public function setProductVersion($productVersion): void
    {
        $this->productVersion = $this->castValueToSimpleType('string', $productVersion, true);
    }

    /**
     * @param string $rootFolderId
     */
    public function setRootFolderId($rootFolderId): void
    {
        $this->rootFolderId = $this->castValueToSimpleType('string', $rootFolderId, true);
    }

    /**
     * @param string $thinClientUri
     */
    public function setThinClientUri($thinClientUri): void
    {
        $this->thinClientUri = $this->castValueToSimpleType('string', $thinClientUri, true);
    }

    /**
     * @param string $vendorName
     */
    public function setVendorName($vendorName): void
    {
        $this->vendorName = $this->castValueToSimpleType('string', $vendorName, true);
    }

    /**
     * {@inheritdoc}
     */
    public function getAclCapabilities()
    {
        return $this->aclCapabilities;
    }

    /**
     * {@inheritdoc}
     */
    public function getCapabilities()
    {
        return $this->capabilities;
    }

    /**
     * {@inheritdoc}
     */
    public function getChangesOnType()
    {
        return $this->changesOnType;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function getExtensionFeatures()
    {
        return $this->extensionFeatures;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getLatestChangeLogToken()
    {
        return $this->latestChangeLogToken;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * {@inheritdoc}
     */
    public function getProductVersion()
    {
        return $this->productVersion;
    }

    /**
     * {@inheritdoc}
     */
    public function getRootFolderId()
    {
        return $this->rootFolderId;
    }

    /**
     * {@inheritdoc}
     */
    public function getThinClientUri()
    {
        return $this->thinClientUri;
    }

    /**
     * {@inheritdoc}
     */
    public function getVendorName()
    {
        return $this->vendorName;
    }

    /**
     * {@inheritdoc}
     */
    public function getChangesIncomplete()
    {
        return $this->changesIncomplete;
    }

    /**
     * {@inheritdoc}
     */
    public function getCmisVersion()
    {
        return CmisVersion::cast($this->cmisVersion);
    }

    /**
     * Set the supported CMIS version
     *
     * @param CmisVersion|null $cmisVersion
     */
    public function setCmisVersion(CmisVersion $cmisVersion = null): void
    {
        $this->cmisVersion = CmisVersion::cast($cmisVersion);
    }

    /**
     * {@inheritdoc}
     */
    public function getPrincipalIdAnonymous()
    {
        return $this->principalIdAnonymous;
    }

    /**
     * {@inheritdoc}
     */
    public function getPrincipalIdAnyone()
    {
        return $this->principalIdAnyone;
    }
}

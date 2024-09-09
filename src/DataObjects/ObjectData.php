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

use Dkd\Enumeration\Exception\InvalidEnumerationValueException;
use Dkd\PhpCmis\Data\AclInterface;
use Dkd\PhpCmis\Data\AllowableActionsInterface;
use Dkd\PhpCmis\Data\ChangeEventInfoInterface;
use Dkd\PhpCmis\Data\ObjectDataInterface;
use Dkd\PhpCmis\Data\PolicyIdListInterface;
use Dkd\PhpCmis\Data\PropertiesInterface;
use Dkd\PhpCmis\Data\RenditionDataInterface;
use Dkd\PhpCmis\Enum\BaseTypeId;
use Dkd\PhpCmis\PropertyIds;

/**
 * ObjectData implementation.
 */
class ObjectData extends AbstractExtensionData implements ObjectDataInterface
{
    /**
     * @var PropertiesInterface
     */
    protected $properties;

    /**
     * @var ChangeEventInfoInterface
     */
    protected $changeEventInfo;

    /**
     * @var ObjectDataInterface[]
     */
    protected $relationships = [];

    /**
     * @var RenditionDataInterface[]
     */
    protected $renditions = [];

    /**
     * @var PolicyIdListInterface
     */
    protected $policyIds;

    /**
     * @var AllowableActionsInterface
     */
    protected $allowableActions;

    /**
     * @var AclInterface
     */
    protected $acl;

    /**
     * @var boolean|null
     */
    protected $isExactAcl;

    /**
     * @return AclInterface
     */
    public function getAcl()
    {
        return $this->acl;
    }

    public function setAcl(AclInterface $acl): void
    {
        $this->acl = $acl;
    }

    /**
     * @return AllowableActionsInterface
     */
    public function getAllowableActions()
    {
        return $this->allowableActions;
    }

    public function setAllowableActions(AllowableActionsInterface $allowableActions): void
    {
        $this->allowableActions = $allowableActions;
    }

    /**
     * @return ChangeEventInfoInterface
     */
    public function getChangeEventInfo()
    {
        return $this->changeEventInfo;
    }

    public function setChangeEventInfo(ChangeEventInfoInterface $changeEventInfo): void
    {
        $this->changeEventInfo = $changeEventInfo;
    }

    /**
     * @param boolean $isExactAcl
     */
    public function setIsExactAcl($isExactAcl): void
    {
        $this->isExactAcl = $this->castValueToSimpleType('boolean', $isExactAcl, true);
    }

    /**
     * Returns if the access control list reflects the exact permission set in the repository.
     *
     * @return boolean|null <code>true</code> - exact; <code>false</code> - not exact, other permission constraints
     *      exist; <code>null</code> - unknown
     */
    public function isExactAcl()
    {
        return $this->isExactAcl;
    }

    /**
     * @return PolicyIdListInterface
     */
    public function getPolicyIds()
    {
        return $this->policyIds;
    }

    public function setPolicyIds(PolicyIdListInterface $policyIds): void
    {
        $this->policyIds = $policyIds;
    }

    /**
     * @return PropertiesInterface|null
     */
    public function getProperties()
    {
        return $this->properties;
    }

    public function setProperties(PropertiesInterface $properties): void
    {
        $this->properties = $properties;
    }

    /**
     * @return ObjectDataInterface[]
     */
    public function getRelationships()
    {
        return $this->relationships;
    }

    /**
     * @param ObjectDataInterface[] $relationships
     */
    public function setRelationships(array $relationships): void
    {
        foreach ($relationships as $relationship) {
            $this->checkType(ObjectDataInterface::class, $relationship);
        }
        $this->relationships = $relationships;
    }

    /**
     * @return RenditionDataInterface[]
     */
    public function getRenditions()
    {
        return $this->renditions;
    }

    /**
     * @param RenditionDataInterface[] $renditions
     */
    public function setRenditions(array $renditions): void
    {
        $this->renditions = $renditions;
    }

    /**
     * Returns the base object type.
     *
     * @return BaseTypeId|null the base object type or <code>null</code> if the base object type is unknown
     */
    public function getBaseTypeId()
    {
        $value = $this->getFirstValue(PropertyIds::BASE_TYPE_ID);
        if (is_string($value)) {
            try {
                return BaseTypeId::cast($value);
            } catch (InvalidEnumerationValueException) {
                // invalid base type -> return null
            }
        }

        return null;
    }

    /**
     * Returns the object ID.
     *
     * @return string|null the object ID or <code>null</code> if the object ID is unknown
     */
    public function getId(): ?string
    {
        $value = $this->getFirstValue(PropertyIds::OBJECT_ID);
        if (is_string($value)) {
            return $value;
        }
        return null;
    }

    /**
     * Returns the first value of a property or <code>null</code> if the
     * property is not set.
     *
     * @return mixed
     */
    private function getFirstValue(string $id)
    {
        if ($this->properties === null) {
            return null;
        }
        $properties = $this->properties->getProperties();

        if (isset($properties[$id])) {
            return $properties[$id]->getFirstValue();
        }

        return null;
    }
}

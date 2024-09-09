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
use DateTime;
use Dkd\PhpCmis\Data\AceInterface;
use Dkd\PhpCmis\Data\BindingsObjectFactoryInterface;
use Dkd\PhpCmis\Data\PropertyDataInterface;
use Dkd\PhpCmis\Definitions\PropertyBooleanDefinitionInterface;
use Dkd\PhpCmis\Definitions\PropertyDateTimeDefinitionInterface;
use Dkd\PhpCmis\Definitions\PropertyDecimalDefinitionInterface;
use Dkd\PhpCmis\Definitions\PropertyDefinitionInterface;
use Dkd\PhpCmis\Definitions\PropertyHtmlDefinitionInterface;
use Dkd\PhpCmis\Definitions\PropertyIdDefinitionInterface;
use Dkd\PhpCmis\Definitions\PropertyIntegerDefinitionInterface;
use Dkd\PhpCmis\Definitions\PropertyStringDefinitionInterface;
use Dkd\PhpCmis\Definitions\PropertyUriDefinitionInterface;
use Dkd\PhpCmis\Enum\BaseTypeId;
use Dkd\PhpCmis\Exception\CmisInvalidArgumentException;
use Dkd\PhpCmis\Exception\CmisRuntimeException;

/**
 * CMIS binding object factory implementation.
 */
class BindingsObjectFactory implements BindingsObjectFactoryInterface
{
    /**
     * Create a AccessControlEntry for the given principal and permissions
     *
     * @param string $principal
     * @param string[] $permissions
     */
    public function createAccessControlEntry($principal, array $permissions): AccessControlEntry
    {
        return new AccessControlEntry(new Principal($principal), $permissions);
    }

    /**
     * @param AceInterface[] $aces
     */
    public function createAccessControlList(array $aces): AccessControlList
    {
        return new AccessControlList($aces);
    }

    /**
     * TODO check if this method is required at all in the php implementation
     *
     * @param string $filename
     * @param integer $length
     * @param string $mimeType
     * @param mixed $stream @TODO define datatype
     */
    public function createContentStream($filename, $length, $mimeType, $stream): void
    {
        // TODO: Implement createContentStream() method.
    }

    /**
     * @param PropertyDataInterface[] $propertiesData
     */
    public function createPropertiesData(array $propertiesData): Properties
    {
        $properties = new Properties();
        $properties->addProperties($propertiesData);
        return $properties;
    }

    /**
     * @return PropertyDataInterface
     */
    public function createPropertyData(PropertyDefinitionInterface $propertyDefinition, array $values)
    {
        if ($propertyDefinition instanceof PropertyStringDefinitionInterface) {
            return $this->createPropertyStringData($propertyDefinition->getId(), $values);
        }
        if ($propertyDefinition instanceof PropertyBooleanDefinitionInterface) {
            return $this->createPropertyBooleanData($propertyDefinition->getId(), $values);
        }
        if ($propertyDefinition instanceof PropertyIdDefinitionInterface) {
            return $this->createPropertyIdData($propertyDefinition->getId(), $values);
        }
        if ($propertyDefinition instanceof PropertyDateTimeDefinitionInterface) {
            return $this->createPropertyDateTimeData($propertyDefinition->getId(), $values);
        }
        if ($propertyDefinition instanceof PropertyDecimalDefinitionInterface) {
            return $this->createPropertyDecimalData($propertyDefinition->getId(), $values);
        }
        if ($propertyDefinition instanceof PropertyHtmlDefinitionInterface) {
            return $this->createPropertyHtmlData($propertyDefinition->getId(), $values);
        }
        if ($propertyDefinition instanceof PropertyIntegerDefinitionInterface) {
            return $this->createPropertyIntegerData($propertyDefinition->getId(), $values);
        }
        if ($propertyDefinition instanceof PropertyUriDefinitionInterface) {
            return $this->createPropertyUriData($propertyDefinition->getId(), $values);
        }
        throw new CmisRuntimeException(sprintf('Unknown property definition: %s', $propertyDefinition::class));
    }

    /**
     * @param string $id
     * @param boolean[] $values
     */
    public function createPropertyBooleanData($id, array $values): PropertyBoolean
    {
        return new PropertyBoolean($id, $values);
    }

    /**
     * @param string $id
     * @param DateTime[] $values
     */
    public function createPropertyDateTimeData($id, array $values): PropertyDateTime
    {
        return new PropertyDateTime($id, $values);
    }

    /**
     * @param string $id
     * @param float[] $values
     */
    public function createPropertyDecimalData($id, array $values): PropertyDecimal
    {
        return new PropertyDecimal($id, $values);
    }

    /**
     * @param string $id
     * @param string[] $values
     */
    public function createPropertyHtmlData($id, array $values): PropertyHtml
    {
        return new PropertyHtml($id, $values);
    }

    /**
     * @param string $id
     * @param string[] $values
     */
    public function createPropertyIdData($id, array $values): PropertyId
    {
        return new PropertyId($id, $values);
    }

    /**
     * @param string $id
     * @param integer[] $values
     */
    public function createPropertyIntegerData($id, array $values): PropertyInteger
    {
        return new PropertyInteger($id, $values);
    }

    /**
     * @param string $id
     * @param string[] $values
     */
    public function createPropertyStringData($id, array $values): PropertyString
    {
        return new PropertyString($id, $values);
    }

    /**
     * @param string $id
     * @param string[] $values
     */
    public function createPropertyUriData($id, array $values): PropertyUri
    {
        return new PropertyUri($id, $values);
    }

    /**
     * Get a type definition object by its base type id
     *
     * @param string $baseTypeIdString
     * @param string $typeId
     * @throws CmisInvalidArgumentException Exception is thrown if the base type exists in the BaseTypeId enumeration
     *      but is not implemented here. This could only happen if the base type enumeration is extended which requires
     *      a CMIS specification change.
     */
    public function getTypeDefinitionByBaseTypeId($baseTypeIdString, $typeId): SecondaryTypeDefinition|ItemTypeDefinition|PolicyTypeDefinition|RelationshipTypeDefinition|DocumentTypeDefinition|FolderTypeDefinition
    {
        $baseTypeId = BaseTypeId::cast($baseTypeIdString);

        if ($baseTypeId->equals(BaseTypeId::cast(BaseTypeId::CMIS_FOLDER))) {
            $baseType = new FolderTypeDefinition($typeId);
        } elseif ($baseTypeId->equals(BaseTypeId::cast(BaseTypeId::CMIS_DOCUMENT))) {
            $baseType = new DocumentTypeDefinition($typeId);
        } elseif ($baseTypeId->equals(BaseTypeId::cast(BaseTypeId::CMIS_RELATIONSHIP))) {
            $baseType = new RelationshipTypeDefinition($typeId);
        } elseif ($baseTypeId->equals(BaseTypeId::cast(BaseTypeId::CMIS_POLICY))) {
            $baseType = new PolicyTypeDefinition($typeId);
        } elseif ($baseTypeId->equals(BaseTypeId::cast(BaseTypeId::CMIS_ITEM))) {
            $baseType = new ItemTypeDefinition($typeId);
        } elseif ($baseTypeId->equals(BaseTypeId::cast(BaseTypeId::CMIS_SECONDARY))) {
            $baseType = new SecondaryTypeDefinition($typeId);
        } else {
            // @codeCoverageIgnoreStart
            // this could only happen if a new baseType is added to the enumeration and not implemented here.
            throw new CmisInvalidArgumentException(
                sprintf('The given type definition "%s" could not be converted.', $baseTypeId)
            );
            // @codeCoverageIgnoreEnd
        }

        $baseType->setBaseTypeId($baseTypeId);

        return $baseType;
    }
}

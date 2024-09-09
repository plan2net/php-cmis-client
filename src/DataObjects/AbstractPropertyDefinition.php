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

use Dkd\PhpCmis\Definitions\ChoiceInterface;
use Dkd\PhpCmis\Definitions\MutablePropertyDefinitionInterface;
use Dkd\PhpCmis\Enum\Cardinality;
use Dkd\PhpCmis\Enum\PropertyType;
use Dkd\PhpCmis\Enum\Updatability;

/**
 * Abstract property definition data implementation.
 */
abstract class AbstractPropertyDefinition extends AbstractExtensionData implements MutablePropertyDefinitionInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $localName;

    /**
     * @var string
     */
    protected $localNamespace;

    /**
     * @var string
     */
    protected $queryName;

    /**
     * @var string
     */
    protected $displayName;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var PropertyType
     */
    protected $propertyType;

    /**
     * @var Cardinality
     */
    protected $cardinality;

    /**
     * @var ChoiceInterface[]
     */
    protected $choices = [];

    /**
     * @var array
     */
    protected $defaultValue = [];

    /**
     * @var Updatability
     */
    protected $updatability;

    /**
     * @var boolean
     */
    protected $isInherited = false;

    /**
     * @var boolean
     */
    protected $isQueryable = false;

    /**
     * @var boolean
     */
    protected $isOrderable = false;

    /**
     * @var boolean
     */
    protected $isRequired = false;

    /**
     * @var boolean
     */
    protected $isOpenChoice = false;

    /**
     * @param string $id
     */
    public function __construct($id)
    {
        $this->setId($id);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id): void
    {
        $this->id = $this->castValueToSimpleType('string', $id, true);
    }

    /**
     * @return string
     */
    public function getLocalName()
    {
        return $this->localName;
    }

    /**
     * @param string $localName
     */
    public function setLocalName($localName): void
    {
        $this->localName = $this->castValueToSimpleType('string', $localName, true);
    }

    /**
     * @return string
     */
    public function getLocalNamespace()
    {
        return $this->localNamespace;
    }

    /**
     * @param string $localNamespace
     */
    public function setLocalNamespace($localNamespace): void
    {
        $this->localNamespace = $this->castValueToSimpleType('string', $localNamespace, true);
    }

    /**
     * @return string
     */
    public function getQueryName()
    {
        return $this->queryName;
    }

    /**
     * @param string $queryName
     */
    public function setQueryName($queryName): void
    {
        $this->queryName = $this->castValueToSimpleType('string', $queryName, true);
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @param string $displayName
     */
    public function setDisplayName($displayName): void
    {
        $this->displayName = $this->castValueToSimpleType('string', $displayName, true);
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description): void
    {
        $this->description = $this->castValueToSimpleType('string', $description, true);
    }

    /**
     * @return PropertyType
     */
    public function getPropertyType()
    {
        return $this->propertyType;
    }

    public function setPropertyType(PropertyType $propertyType): void
    {
        $this->propertyType = $propertyType;
    }

    /**
     * @return Cardinality
     */
    public function getCardinality()
    {
        return $this->cardinality;
    }

    public function setCardinality(Cardinality $cardinality): void
    {
        $this->cardinality = $cardinality;
    }

    /**
     * COMPATIBILITY: required by CMIS auto-property mapping; the "choices" property
     * is sent in responses as "choice" (singular). PHP API allows properl plural name.
     *
     * @return ChoiceInterface[]
     */
    public function getChoice()
    {
        return $this->choices;
    }

    /**
     * COMPATIBILITY: required by CMIS auto-property mapping; the "choices" property
     * is sent in responses as "choice" (singular). PHP API allows properl plural name.
     *
     * @param ChoiceInterface[] $choices
     */
    public function setChoice(array $choices): void
    {
        $this->choices = $choices;
    }

    /**
     * @return ChoiceInterface[]
     */
    public function getChoices()
    {
        return $this->choices;
    }

    /**
     * @param ChoiceInterface[] $choices
     */
    public function setChoices(array $choices): void
    {
        $this->choices = $choices;
    }

    /**
     * @return array
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    public function setDefaultValue(array $defaultValue): void
    {
        $this->defaultValue = $defaultValue;
    }

    /**
     * @return Updatability
     */
    public function getUpdatability()
    {
        return $this->updatability;
    }

    public function setUpdatability(Updatability $updatability): void
    {
        $this->updatability = $updatability;
    }

    /**
     * @return boolean
     */
    public function isInherited()
    {
        return $this->isInherited;
    }

    /**
     * @param boolean $isInherited
     */
    public function setIsInherited($isInherited): void
    {
        $this->isInherited = $this->castValueToSimpleType('boolean', $isInherited);
    }

    /**
     * @return boolean
     */
    public function isQueryable()
    {
        return $this->isQueryable;
    }

    /**
     * @param boolean $isQueryable
     */
    public function setIsQueryable($isQueryable): void
    {
        $this->isQueryable = $this->castValueToSimpleType('boolean', $isQueryable);
    }

    /**
     * @return boolean
     */
    public function isOrderable()
    {
        return $this->isOrderable;
    }

    /**
     * @param boolean $isOrderable
     */
    public function setIsOrderable($isOrderable): void
    {
        $this->isOrderable = $this->castValueToSimpleType('boolean', $isOrderable);
    }

    /**
     * @return boolean
     */
    public function isRequired()
    {
        return $this->isRequired;
    }

    /**
     * @param boolean $isRequired
     */
    public function setIsRequired($isRequired): void
    {
        $this->isRequired = $this->castValueToSimpleType('boolean', $isRequired);
    }

    /**
     * @return boolean
     */
    public function isOpenChoice()
    {
        return $this->isOpenChoice;
    }

    /**
     * @param boolean $isOpenChoice
     */
    public function setIsOpenChoice($isOpenChoice): void
    {
        $this->isOpenChoice = $this->castValueToSimpleType('boolean', $isOpenChoice);
    }
}

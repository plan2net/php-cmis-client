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

use Dkd\PhpCmis\Data\PropertyInterface;
use Dkd\PhpCmis\Definitions\PropertyDefinitionInterface;
use Dkd\PhpCmis\Enum\Cardinality;
use Dkd\PhpCmis\Enum\PropertyType;

/**
 * Property Implementation.
 */
class Property extends AbstractPropertyData implements PropertyInterface
{
    /**
     * Initialize the property with its definition and values
     *
     * @param mixed[] $values
     */
    public function __construct(protected PropertyDefinitionInterface $propertyDefinition, array $values)
    {
        $this->setId($this->propertyDefinition->getId());
        $this->setDisplayName($this->propertyDefinition->getDisplayName());
        $this->setLocalName($this->propertyDefinition->getLocalName());
        $this->setQueryName($this->propertyDefinition->getQueryName());
        $this->setValues($values);
    }

    /**
     * Returns if the property is a multi-value property.
     *
     * @return boolean <code>true</code> if the property is multi-value property, <code>false</code> if the property is
     *     single-value property,
     */
    public function isMultiValued()
    {
        return Cardinality::cast($this->getDefinition()->getCardinality())->equals(Cardinality::MULTI);
    }

    /**
     * Returns the property data type.
     *
     * @return PropertyType the data type of the property
     */
    public function getType()
    {
        return $this->getDefinition()->getPropertyType();
    }

    /**
     * Returns the property definition.
     *
     * @return PropertyDefinitionInterface the property definition
     */
    public function getDefinition()
    {
        return $this->propertyDefinition;
    }
}

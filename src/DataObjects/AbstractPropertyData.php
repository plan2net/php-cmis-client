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

use Dkd\PhpCmis\Data\MutablePropertyDataInterface;

/**
 * Abstract property data implementation.
 */
abstract class AbstractPropertyData extends AbstractExtensionData implements MutablePropertyDataInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $displayName;

    /**
     * @var string
     */
    protected $localName;

    /**
     * @var string
     */
    protected $queryName;

    /**
     * @var array
     */
    protected $values = [];

    /**
     * @param string $id
     */
    public function __construct($id, mixed $value = null)
    {
        $this->setId($id);

        if (is_array($value)) {
            $this->setValues($value);
        } elseif ($value !== null) {
            $this->setValue($value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * {@inheritdoc}
     */
    public function setDisplayName($displayName): void
    {
        $this->displayName = (string) $displayName;
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
    public function setId($id): void
    {
        $this->id = (string) $id;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocalName()
    {
        return $this->localName;
    }

    /**
     * {@inheritdoc}
     */
    public function setLocalName($localName): void
    {
        $this->localName = (string) $localName;
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryName()
    {
        return $this->queryName;
    }

    /**
     * {@inheritdoc}
     */
    public function setQueryName($queryName): void
    {
        $this->queryName = (string) $queryName;
    }

    /**
     * {@inheritdoc}
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * {@inheritdoc}
     */
    public function setValues(array $values): void
    {
        $this->values = array_values($values);
    }

    /**
     * {@inheritdoc}
     */
    final public function setValue($value): void
    {
        $this->setValues([$value]);
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstValue()
    {
        if (count($this->values) > 0) {
            return $this->values[0];
        }

        return null;
    }
}

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

use Dkd\PhpCmis\Definitions\TypeMutabilityInterface;

/**
 * Type mutability flags.
 */
class TypeMutability extends AbstractExtensionData implements TypeMutabilityInterface
{
    /**
     * @var boolean
     */
    protected $canCreate = false;

    /**
     * @var boolean
     */
    protected $canUpdate = false;

    /**
     * @var boolean
     */
    protected $canDelete = false;

    /**
     * @return boolean
     */
    public function canCreate()
    {
        return $this->canCreate;
    }

    /**
     * @param boolean $canCreate
     */
    public function setCanCreate($canCreate): void
    {
        $this->canCreate = $this->castValueToSimpleType('boolean', $canCreate);
    }

    /**
     * @return boolean
     */
    public function canUpdate()
    {
        return $this->canUpdate;
    }

    /**
     * @param boolean $canUpdate
     */
    public function setCanUpdate($canUpdate): void
    {
        $this->canUpdate = $this->castValueToSimpleType('boolean', $canUpdate);
    }

    /**
     * @return boolean
     */
    public function canDelete()
    {
        return $this->canDelete;
    }

    /**
     * @param boolean $canDelete
     */
    public function setCanDelete($canDelete): void
    {
        $this->canDelete = $this->castValueToSimpleType('boolean', $canDelete);
    }
}

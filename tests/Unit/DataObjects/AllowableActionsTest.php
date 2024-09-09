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
use Dkd\PhpCmis\Exception\CmisInvalidArgumentException;
use Dkd\PhpCmis\DataObjects\AllowableActions;
use Dkd\PhpCmis\Enum\Action;

/**
 * Class AllowableActionsTest
 */
class AllowableActionsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var AllowableActions
     */
    protected $allowableActions;

    public function setUp(): void
    {
        $this->allowableActions = new AllowableActions();
    }

    public function testSetAllowableActionsThrowsExceptionIfGivenListContainsInvalidValue(): void
    {
        $this->setExpectedException(CmisInvalidArgumentException::class);
        $this->allowableActions->setAllowableActions(['foo']);
    }

    public function testSetAllowableActionsAssignsActionsToAttribute(): void
    {
        $actions = [Action::cast(Action::CAN_ADD_OBJECT_TO_FOLDER), Action::cast(Action::CAN_APPLY_ACL)];
        $this->allowableActions->setAllowableActions($actions);

        $this->assertAttributeSame($actions, 'allowableActions', $this->allowableActions);
    }

    /**
     * @depends testSetAllowableActionsAssignsActionsToAttribute
     */
    public function testGetAllowableActionsReturnsArrayWithActions(): void
    {
        $actions = [Action::cast(Action::CAN_ADD_OBJECT_TO_FOLDER), Action::cast(Action::CAN_APPLY_ACL)];
        $this->allowableActions->setAllowableActions($actions);

        $this->assertSame($actions, $this->allowableActions->getAllowableActions());
    }
}

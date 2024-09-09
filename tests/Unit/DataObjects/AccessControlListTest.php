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
use Dkd\PhpCmis\Data\AceInterface;
use Dkd\PhpCmis\Exception\CmisInvalidArgumentException;
use stdClass;
use Dkd\PhpCmis\DataObjects\AccessControlEntry;
use Dkd\PhpCmis\DataObjects\AccessControlList;

/**
 * Class AccessControlListTest
 */
class AccessControlListTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var AccessControlList
     */
    protected $acl;

    /**
     * @var AccessControlEntry
     */
    protected $aceMock;

    public function setUp(): void
    {
        $this->aceMock = $this->getMockBuilder(
            AceInterface::class
        )->disableOriginalConstructor()->getMockForAbstractClass();

        $this->acl = new AccessControlList([$this->aceMock]);
    }

    public function testSetAcesSetsProperty(): void
    {
        $aces = [$this->aceMock];
        $this->acl->setAces($aces);
        $this->assertAttributeSame($aces, 'aces', $this->acl);
    }

    public function testSetAcesThrowsExceptionIfAGivenAceItemIsNotOfTypeAceInterface(): void
    {
        $this->setExpectedException(CmisInvalidArgumentException::class);
        $this->acl->setAces([new stdClass()]);
    }

    /**
     * @depends testSetAcesSetsProperty
     */
    public function testGetAcesReturnsPropertyValue(): void
    {
        $aces = [$this->aceMock];
        $this->acl->setAces($aces);
        $this->assertSame($aces, $this->acl->getAces());
    }

    public function testConstructorSetsAces(): void
    {
        $aces = [$this->aceMock];
        $acl = new AccessControlList($aces);
        $this->assertAttributeSame($aces, 'aces', $acl);
    }

    public function testSetIsExactSetsIsExact(): void
    {
        $this->acl->setIsExact(true);
        $this->assertAttributeSame(true, 'isExact', $this->acl);
        $this->acl->setIsExact(false);
        $this->assertAttributeSame(false, 'isExact', $this->acl);
    }

    public function testSetIsExactCastsValueToBoolean(): void
    {
        $this->setExpectedException('\\PHPUnit_Framework_Error_Notice');
        $this->acl->setIsExact(1);
        $this->assertAttributeSame(true, 'isExact', $this->acl);
    }

    /**
     * @depends testSetIsExactSetsIsExact
     */
    public function testIsExactReturnsIsExact(): void
    {
        $this->acl->setIsExact(true);
        $this->assertTrue($this->acl->isExact());
        $this->acl->setIsExact(false);
        $this->assertFalse($this->acl->isExact());
    }
}

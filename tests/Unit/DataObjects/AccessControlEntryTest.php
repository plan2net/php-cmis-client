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
use stdClass;
use Dkd\PhpCmis\DataObjects\AccessControlEntry;
use Dkd\PhpCmis\PrincipalInterface;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Class AccessControlEntryTest
 */
class AccessControlEntryTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var AccessControlEntry
     */
    protected $ace;

    /**
     * @var string[]
     */
    protected $dummyPermissions = ['foo', 'bar'];

    /**
     * @var PrincipalInterface|PHPUnit_Framework_MockObject_MockObject
     */
    protected $dummyPrincipal;

    public function setUp(): void
    {
        $this->dummyPrincipal = $this->getMockBuilder(PrincipalInterface::class)->getMockForAbstractClass();
        $this->ace = new AccessControlEntry(
            $this->dummyPrincipal,
            $this->dummyPermissions
        );
    }

    public function testSetPermissionsSetsPermissions(): void
    {
        $permissions = ['baz', 'bazz'];
        $this->ace->setPermissions($permissions);
        $this->assertAttributeSame($permissions, 'permissions', $this->ace);
    }

    public function testSetPermissionsThrowsExceptionIfPermissionItemIsNotOfTypeString(): void
    {
        $this->setExpectedException(CmisInvalidArgumentException::class);
        $this->ace->setPermissions([new stdClass()]);
    }

    public function testSetPrincipalSetsPrincipal(): void
    {
        $principal = $this->getMockBuilder(PrincipalInterface::class)->getMockForAbstractClass();
        $this->ace->setPrincipal($principal);
        $this->assertAttributeSame($principal, 'principal', $this->ace);
    }

    /**
     * @depends testSetPermissionsSetsPermissions
     * @depends testSetPrincipalSetsPrincipal
     */
    public function testConstructorSetsPermissionAndPrincipalIfGiven(): void
    {
        $this->assertAttributeSame($this->dummyPrincipal, 'principal', $this->ace);
        $this->assertAttributeSame($this->dummyPermissions, 'permissions', $this->ace);
    }

    /**
     * @depends testSetPermissionsSetsPermissions
     */
    public function testGetPermissionsReturnsPermissions(): void
    {
        $this->assertSame($this->dummyPermissions, $this->ace->getPermissions());
    }

    /**
     * @depends testSetPrincipalSetsPrincipal
     */
    public function testGetPrincipalReturnsPrincipal(): void
    {
        $this->assertSame($this->dummyPrincipal, $this->ace->getPrincipal());
    }

    public function testSetIsDirectSetsIsDirect(): void
    {
        $this->ace->setIsDirect(true);
        $this->assertAttributeSame(true, 'isDirect', $this->ace);
        $this->ace->setIsDirect(false);
        $this->assertAttributeSame(false, 'isDirect', $this->ace);
    }

    public function testSetIsDirectCastsValueToBoolean(): void
    {
        $this->setExpectedException('\\PHPUnit_Framework_Error_Notice');
        $this->ace->setIsDirect(1);
        $this->assertAttributeSame(true, 'isDirect', $this->ace);
    }

    /**
     * @depends testSetIsDirectSetsIsDirect
     */
    public function testIsDirectReturnsIsDirect(): void
    {
        $this->ace->setIsDirect(true);
        $this->assertTrue($this->ace->isDirect());
        $this->ace->setIsDirect(false);
        $this->assertFalse($this->ace->isDirect());
    }
}

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
use Dkd\PhpCmis\DataObjects\PermissionMapping;
use Dkd\PhpCmis\Test\Unit\DataProviderCollectionTrait;

/**
 * Class PermissionMappingTest
 */
class PermissionMappingTest extends PHPUnit_Framework_TestCase
{
    use DataProviderCollectionTrait;

    /**
     * @var PermissionMapping
     */
    protected $permissionMapping;

    public function setUp(): void
    {
        $this->permissionMapping = new PermissionMapping();
    }

    /**
     * @dataProvider stringCastDataProvider
     * @param string $expected
     */
    public function testSetPermissionsSetsProperty($expected, mixed $value): void
    {
        $this->permissionMapping->setPermissions([$value]);
        $this->assertAttributeSame([$expected], 'permissions', $this->permissionMapping);
    }

    /**
     * @depends testSetPermissionsSetsProperty
     */
    public function testGetPermissionsReturnsPropertyValue(): void
    {
        $this->permissionMapping->setPermissions(['foo']);
        $this->assertSame(['foo'], $this->permissionMapping->getPermissions());
    }

    /**
     * @dataProvider stringCastDataProvider
     * @param string $expected
     */
    public function testSetKeySetsProperty($expected, mixed $value): void
    {
        $this->permissionMapping->setKey($value);
        $this->assertAttributeSame($expected, 'key', $this->permissionMapping);
    }

    /**
     * @depends testSetKeySetsProperty
     */
    public function testGetKeyReturnsPropertyValue(): void
    {
        $this->permissionMapping->setKey('foo');
        $this->assertSame('foo', $this->permissionMapping->getKey());
    }
}

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

use Dkd\PhpCmis\DataObjects\PermissionDefinition;
use Dkd\PhpCmis\Test\Unit\DataProviderCollectionTrait;
use PHPUnit_Framework_TestCase;

/**
 * Class PermissionDefinitionTest
 */
class PermissionDefinitionTest extends PHPUnit_Framework_TestCase
{
    use DataProviderCollectionTrait;

    /**
     * @var PermissionDefinition
     */
    protected $permissionDefinition;

    public function setUp(): void
    {
        $this->permissionDefinition = new PermissionDefinition();
    }

    /**
     * @dataProvider stringCastDataProvider
     * @param string $expected
     */
    public function testSetDescriptionSetsProperty($expected, mixed $value): void
    {
        $this->permissionDefinition->setDescription($value);
        $this->assertAttributeSame($expected, 'description', $this->permissionDefinition);
    }

    /**
     * @depends testSetDescriptionSetsProperty
     */
    public function testGetDescriptionReturnsPropertyValue(): void
    {
        $this->permissionDefinition->setDescription('foo');
        $this->assertSame('foo', $this->permissionDefinition->getDescription());
    }

    /**
     * @dataProvider stringCastDataProvider
     * @param string $expected
     */
    public function testSetIdSetsProperty($expected, mixed $value): void
    {
        $this->permissionDefinition->setId($value);
        $this->assertAttributeSame($expected, 'id', $this->permissionDefinition);
    }

    /**
     * @depends testSetIdSetsProperty
     */
    public function testGetIdReturnsPropertyValue(): void
    {
        $this->permissionDefinition->setId('foo');
        $this->assertSame('foo', $this->permissionDefinition->getId());
    }
}

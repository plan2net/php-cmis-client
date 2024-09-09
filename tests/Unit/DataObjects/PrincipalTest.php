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
use Dkd\PhpCmis\DataObjects\Principal;

/**
 * Class PrincipalTest
 */
class PrincipalTest extends PHPUnit_Framework_TestCase
{
    public function testConstructorSetsId(): void
    {
        $principal = new Principal('foo');
        $this->assertAttributeSame('foo', 'id', $principal);
    }

    public function testSetPrincipalIdSetsProperty(): void
    {
        $principal = new Principal('foo');
        $principal->setId('value');
        $this->assertAttributeSame('value', 'id', $principal);
    }

    /**
     * @depends testSetPrincipalIdSetsProperty
     */
    public function testGetPrincipalIdReturnsProperty(): void
    {
        $principal = new Principal('value');
        $this->assertSame('value', $principal->getId());
    }
}

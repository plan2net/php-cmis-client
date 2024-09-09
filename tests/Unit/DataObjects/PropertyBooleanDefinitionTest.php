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
use Dkd\PhpCmis\DataObjects\AbstractPropertyDefinition;
use Dkd\PhpCmis\DataObjects\PropertyBooleanDefinition;

/**
 * Class PropertyBooleanDefinitionTest
 */
class PropertyBooleanDefinitionTest extends PHPUnit_Framework_TestCase
{
    public function testAssertIsInstanceOfAbstractPropertyDefinition(): void
    {
        $this->assertInstanceOf(
            AbstractPropertyDefinition::class,
            new PropertyBooleanDefinition('testId')
        );
    }
}

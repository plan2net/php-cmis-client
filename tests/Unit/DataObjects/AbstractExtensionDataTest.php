<?php
namespace Dkd\PhpCmis\Test\Unit\DataObjects;

/*
 * This file is part of php-cmis-client
 *
 * (c) Sascha Egerer <sascha.egerer@dkd.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use Dkd\PhpCmis\Data\CmisExtensionElementInterface;
use Dkd\PhpCmis\Exception\CmisInvalidArgumentException;
use stdClass;
use Dkd\PhpCmis\DataObjects\AbstractExtensionData;
use Dkd\PhpCmis\Test\Unit\ReflectionHelperTrait;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

/**
 * Unit Tests for AbstractExtensionData
 */
class AbstractExtensionDataTest extends PHPUnit_Framework_TestCase
{
    use ReflectionHelperTrait;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject|AbstractExtensionData
     */
    protected $abstractExtensionData;

    const CLASS_TO_TEST = '\\Dkd\\PhpCmis\\DataObjects\\AbstractExtensionData';

    public function setUp(): void
    {
        $this->abstractExtensionData = $this->getMockBuilder(self::CLASS_TO_TEST)->enableProxyingToOriginalMethods(
        )->getMockForAbstractClass();
    }

    public function testSetExtensionsSetsAttributeAndGetExtensionReturnsAttribute(): void
    {
        $extensions = [
            $this->getMockBuilder(
                CmisExtensionElementInterface::class
            )->getMockForAbstractClass()
        ];

        $this->abstractExtensionData->setExtensions($extensions);
        $this->assertAttributeSame($extensions, 'extensions', $this->abstractExtensionData);
        $this->assertSame($extensions, $this->abstractExtensionData->getExtensions());
    }

    public function testSetExtensionsWithInvalidDataThrowsException(): void
    {
        $this->setExpectedException(
            CmisInvalidArgumentException::class,
            'Argument of type "stdClass" given but argument of type '
            . '"Dkd\\PhpCmis\\Data\\CmisExtensionElementInterface" was expected.'
        );
        $this->abstractExtensionData->setExtensions([new stdClass()]);
    }
}

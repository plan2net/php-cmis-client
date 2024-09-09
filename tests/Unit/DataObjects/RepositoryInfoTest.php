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
use Dkd\PhpCmis\Data\RepositoryCapabilitiesInterface;
use Dkd\PhpCmis\Data\AclCapabilitiesInterface;
use Dkd\PhpCmis\Data\ExtensionFeatureInterface;
use stdClass;
use Dkd\PhpCmis\Exception\CmisInvalidArgumentException;
use Dkd\PhpCmis\DataObjects\RepositoryInfo;
use Dkd\PhpCmis\Enum\BaseTypeId;
use Dkd\PhpCmis\Enum\CmisVersion;

/**
 * Class RepositoryInfoTest
 */
class RepositoryInfoTest extends PHPUnit_Framework_TestCase
{
    const DO_NOT_TEST_INVALID_TYPE_VALUE = 'doNotTestInvalidType';

    /**
     * @var RepositoryInfo
     */
    protected $repositoryInfo;

    public function setUp(): void
    {
        $this->repositoryInfo = new RepositoryInfo();
    }

    /**
     * DataProvider for all properties with a valid value and an invalid value
     *
     * @return array
     */
    public function propertiesOfSutDataProvider()
    {
        return [
            // string properties
            [
                'propertyName' => 'id',
                'validValue' => 'exampleString',
                'invalidValue' => 123
            ],
            [
                'propertyName' => 'name',
                'validValue' => 'exampleString',
                'invalidValue' => 123
            ],
            [
                'propertyName' => 'description',
                'validValue' => 'exampleString',
                'invalidValue' => 123
            ],
            [
                'propertyName' => 'rootFolderId',
                'validValue' => 'exampleString',
                'invalidValue' => 123
            ],
            [
                'propertyName' => 'principalIdAnonymous',
                'validValue' => 'exampleString',
                'invalidValue' => 123
            ],
            [
                'propertyName' => 'principalIdAnyone',
                'validValue' => 'exampleString',
                'invalidValue' => 123
            ],
            [
                'propertyName' => 'thinClientUri',
                'validValue' => 'exampleString',
                'invalidValue' => 123
            ],
            [
                'propertyName' => 'latestChangeLogToken',
                'validValue' => 'exampleString',
                'invalidValue' => 123
            ],
            [
                'propertyName' => 'vendorName',
                'validValue' => 'exampleString',
                'invalidValue' => 123
            ],
            [
                'propertyName' => 'productName',
                'validValue' => 'exampleString',
                'invalidValue' => 123
            ],
            [
                'propertyName' => 'productVersion',
                'validValue' => 'exampleString',
                'invalidValue' => 123
            ],
            // boolean properties
            [
                'propertyName' => 'changesIncomplete',
                'validValue' => true,
                'invalidValue' => 1
            ],
            // RepositoryCapabilitiesInterface properties
            [
                'propertyName' => 'capabilities',
                'validValue' => $this->getMockForAbstractClass(RepositoryCapabilitiesInterface::class),
                'invalidValue' => self::DO_NOT_TEST_INVALID_TYPE_VALUE
            ],
            // AclCapabilitiesInterface properties
            [
                'propertyName' => 'aclCapabilities',
                'validValue' => $this->getMockForAbstractClass(AclCapabilitiesInterface::class),
                'invalidValue' => self::DO_NOT_TEST_INVALID_TYPE_VALUE
            ],
            // CmisVersion properties
            [
                'propertyName' => 'cmisVersion',
                'validValue' => CmisVersion::cast(CmisVersion::CMIS_1_1),
                'invalidValue' => self::DO_NOT_TEST_INVALID_TYPE_VALUE
            ],
            // BaseTypeId[] properties
            [
                'propertyName' => 'changesOnType',
                'validValue' => [BaseTypeId::cast(BaseTypeId::CMIS_DOCUMENT)],
                'invalidValue' => ['foo']
            ],
            // ExtensionFeatureInterface[] properties
            [
                'propertyName' => 'extensionFeatures',
                'validValue' => [
                    $this->getMockForAbstractClass(
                        ExtensionFeatureInterface::class
                    )
                ],
                'invalidValue' => [new stdClass()]
            ]
        ];
    }

    /**
     * Test setter for a property
     *
     * @dataProvider propertiesOfSutDataProvider
     * @param string $propertyName
     */
    public function testPropertySetterSetsProperty($propertyName, mixed $validValue): void
    {
        $setterName = 'set' . ucfirst($propertyName);
        $this->repositoryInfo->$setterName($validValue);
        $this->assertAttributeSame($validValue, $propertyName, $this->repositoryInfo);
    }

    /**
     * Test setter for a property - should cast value to expected type
     *
     * @dataProvider propertiesOfSutDataProvider
     * @param string $propertyName
     */
    public function testPropertySetterCastsValueToExpectedType($propertyName, mixed $validValue, mixed $invalidValue): void
    {
        if ($invalidValue !== self::DO_NOT_TEST_INVALID_TYPE_VALUE) {
            $setterName = 'set' . ucfirst($propertyName);
            $validType = gettype($validValue);
            if ($validType === 'object' || $validType === 'array') {
                $this->setExpectedException(
                    CmisInvalidArgumentException::class,
                    '',
                    1413440336
                );
                $this->repositoryInfo->$setterName($invalidValue);
            } else {
                @$this->repositoryInfo->$setterName($invalidValue);
                $this->assertAttributeInternalType($validType, $propertyName, $this->repositoryInfo);
            }
        }
    }

    /**
     * Test getter for a property
     *
     * @dataProvider propertiesOfSutDataProvider
     * @param string $propertyName
     */
    public function testPropertyGetterReturnsPropertyValue($propertyName, mixed $validValue): void
    {
        $setterName = 'set' . ucfirst($propertyName);
        $getterName = 'get' . ucfirst($propertyName);
        $this->setDependencies(['testSetPropertySetsProperty']);
        $this->repositoryInfo->$setterName($validValue);
        $this->assertSame($validValue, $this->repositoryInfo->$getterName());
    }
}

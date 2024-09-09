<?php
namespace Dkd\PhpCmis\Test\Unit\Bindings\Browser;

/*
 * This file is part of php-cmis-lib.
 *
 * (c) Sascha Egerer <sascha.egerer@dkd.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use PHPUnit_Framework_TestCase;
use Dkd\PhpCmis\Bindings\BindingSessionInterface;
use Dkd\PhpCmis\AclServiceInterface;
use Dkd\PhpCmis\DiscoveryServiceInterface;
use Dkd\PhpCmis\MultiFilingServiceInterface;
use Dkd\PhpCmis\NavigationServiceInterface;
use Dkd\PhpCmis\ObjectServiceInterface;
use Dkd\PhpCmis\PolicyServiceInterface;
use Dkd\PhpCmis\RelationshipServiceInterface;
use Dkd\PhpCmis\RepositoryServiceInterface;
use Dkd\PhpCmis\VersioningServiceInterface;
use Dkd\PhpCmis\Bindings\Browser\CmisBrowserBinding;

/**
 * Class CmisBrowserBindingTest
 */
class CmisBrowserBindingTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CmisBrowserBinding
     */
    protected $cmisBrowserBinding;

    public function setUp(): void
    {
        $sessionMock = $this->getMockBuilder(
            BindingSessionInterface::class
        )->getMockForAbstractClass();
        $this->cmisBrowserBinding = new CmisBrowserBinding($sessionMock);
    }

    public function testConstructorSetsSessionAsSessionProperty(): void
    {
        $sessionMock = $this->getMockBuilder(
            BindingSessionInterface::class
        )->getMockForAbstractClass();
        $cmisBrowserBinding = new CmisBrowserBinding($sessionMock);
        $this->assertAttributeSame($sessionMock, 'session', $cmisBrowserBinding);
    }

    /**
     * @dataProvider servicesDataProvider
     * @param $expectedInstance
     * @param $propertyName
     */
    public function testConstructorInitializesServiceProperties($expectedInstance, $propertyName): void
    {
        $this->assertAttributeInstanceOf($expectedInstance, $propertyName, $this->cmisBrowserBinding);
    }

    /**
     * @dataProvider servicesDataProvider
     * @param $expectedInstance
     * @param $propertyName
     */
    public function testServiceGetterReturnsServiceInstance($expectedInstance, $propertyName): void
    {
        $getterName = 'get' . ucfirst((string) $propertyName);
        $this->assertInstanceOf($expectedInstance, $this->cmisBrowserBinding->$getterName());
    }

    public function servicesDataProvider()
    {
        return [
            [
                AclServiceInterface::class,
                'aclService'
            ],
            [
                DiscoveryServiceInterface::class,
                'discoveryService'
            ],
            [
                MultiFilingServiceInterface::class,
                'multiFilingService'
            ],
            [
                NavigationServiceInterface::class,
                'navigationService'
            ],
            [
                ObjectServiceInterface::class,
                'objectService'
            ],
            [
                PolicyServiceInterface::class,
                'policyService'
            ],
            [
                RelationshipServiceInterface::class,
                'relationshipService'
            ],
            [
                RepositoryServiceInterface::class,
                'repositoryService'
            ],
            [
                VersioningServiceInterface::class,
                'versioningService'
            ]
        ];
    }
}

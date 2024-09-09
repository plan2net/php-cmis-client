<?php
namespace Dkd\PhpCmis\Test\Unit\Bindings;

/*
 * This file is part of php-cmis-client
 *
 * (c) Sascha Egerer <sascha.egerer@dkd.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use PHPUnit_Framework_TestCase;
use Dkd\PhpCmis\Exception\CmisRuntimeException;
use Dkd\PhpCmis\Exception\CmisInvalidArgumentException;
use Dkd\PhpCmis\Bindings\Browser\RepositoryService;
use Dkd\PhpCmis\Bindings\CmisBindingsHelper;
use Dkd\PhpCmis\ObjectServiceInterface;
use Dkd\PhpCmis\RepositoryServiceInterface;
use Dkd\PhpCmis\NavigationServiceInterface;
use Dkd\PhpCmis\DiscoveryServiceInterface;
use Dkd\PhpCmis\Bindings\BindingSessionInterface;
use Dkd\PhpCmis\Bindings\CmisBinding;
use Dkd\PhpCmis\Bindings\Session;
use Dkd\PhpCmis\DataObjects\BindingsObjectFactory;
use Dkd\PhpCmis\SessionParameter;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Class CmisBindingTest
 */
class CmisBindingTest extends PHPUnit_Framework_TestCase
{

    public function testConstructorThrowsExceptionIfNoSessionParametersGiven(): void
    {
        $this->setExpectedException(
            CmisRuntimeException::class,
            'Session parameters must be set!'
        );
        new CmisBinding(new Session(), []);
    }

    public function testConstructorThrowsExceptionIfNoSessionParameterBindingClassIsGiven(): void
    {
        $this->setExpectedException(
            CmisInvalidArgumentException::class,
            'Session parameters do not contain a binding class name!'
        );
        new CmisBinding(new Session(), ['foo' => 'bar']);
    }


    public function testConstructorPutsSessionParametersToSession(): void
    {
        /** @var BindingSessionInterface|\PHPUnit_Framework_MockObject_MockObject $session */
        $session = $this->getMockBuilder(BindingSessionInterface::class)->setMethods(
            ['put']
        )->getMockForAbstractClass();
        $session->expects($this->once())->method('put');
        new CmisBinding($session, [SessionParameter::BINDING_CLASS => 'foo']);

        $session = $this->getMockBuilder(BindingSessionInterface::class)->setMethods(
            ['put']
        )->getMockForAbstractClass();
        $session->expects($this->exactly(3))->method('put');
        new CmisBinding($session, [SessionParameter::BINDING_CLASS => 'foo', 1, 2]);
    }

    public function testConstructorCreatesRepositoryServiceInstance(): void
    {
        $binding = new CmisBinding(new Session(), [SessionParameter::BINDING_CLASS => 'foo']);
        $this->assertAttributeInstanceOf(
            RepositoryService::class,
            'repositoryService',
            $binding
        );
    }

    public function testConstructorCreatesObjectFactoryInstanceIfNoneGiven(): void
    {
        $binding = new CmisBinding(new Session(), [SessionParameter::BINDING_CLASS => 'foo']);
        $this->assertAttributeInstanceOf(
            BindingsObjectFactory::class,
            'objectFactory',
            $binding
        );
    }

    public function testConstructorSetsObjectFactoryPropertyToGivenObjectFactory(): void
    {
        /** @var PHPUnit_Framework_MockObject_MockObject|BindingsObjectFactory $objectFactory */
        $objectFactory = $this->getMockBuilder(BindingsObjectFactory::class)->setMockClassName(
            'CustomObjectFactory'
        )->getMock();
        $binding = new CmisBinding(
            new Session(),
            [SessionParameter::BINDING_CLASS => 'foo'],
            null,
            $objectFactory
        );
        $this->assertAttributeSame(
            $objectFactory,
            'objectFactory',
            $binding
        );
    }

    public function testGetCmisBindingsHelperReturnsCmisBindingsHelper(): void
    {
        $binding = new CmisBinding(new Session(), [SessionParameter::BINDING_CLASS => 'foo']);
        $this->assertInstanceOf(CmisBindingsHelper::class, $binding->getCmisBindingsHelper());
    }

    public function testGetObjectServiceReturnsObjectService(): void
    {
        // the subject will be mocked because we have to mock getCmisBindingsHelper
        /** @var CmisBinding|\PHPUnit_Framework_MockObject_MockObject $binding */
        $binding = $this->getMockBuilder(CmisBinding::class)->setConstructorArgs(
            [
                new Session(),
                [SessionParameter::BINDING_CLASS => 'foo']
            ]
        )->setMethods(['getCmisBindingsHelper'])->getMock();

        $cmisBindingsHelperMock = $this->getMockBuilder(
            CmisBindingsHelper::class
        )->getMock();

        $cmisBindingSessionInterfaceMock = $this->getMockBuilder(
            BindingSessionInterface::class
        )->setMethods(['getObjectService'])->getMockForAbstractClass();
        $cmisBindingSessionInterfaceMock->expects($this->any())->method('getObjectService')->willReturn(
            $this->getMockForAbstractClass(ObjectServiceInterface::class)
        );

        $cmisBindingsHelperMock->expects($this->any())->method('getSpi')->willReturn($cmisBindingSessionInterfaceMock);

        $binding->expects($this->any())->method('getCmisBindingsHelper')->willReturn(
            $cmisBindingsHelperMock
        );

        $this->assertInstanceOf(ObjectServiceInterface::class, $binding->getObjectService());
    }

    public function testGetRepositoryServiceReturnsInstanceOfRepositoryService(): void
    {
        $binding = new CmisBinding(new Session(), [SessionParameter::BINDING_CLASS => 'foo']);
        $this->assertInstanceOf(RepositoryServiceInterface::class, $binding->getRepositoryService());
    }

    public function testGetNavigationServiceReturnsInstanceOfNavigationService(): void
    {
        // the subject will be mocked because we have to mock getCmisBindingsHelper
        /** @var CmisBinding|\PHPUnit_Framework_MockObject_MockObject $binding */
        $binding = $this->getMockBuilder(CmisBinding::class)->setConstructorArgs(
            [
                new Session(),
                [SessionParameter::BINDING_CLASS => 'foo']
            ]
        )->setMethods(['getCmisBindingsHelper'])->getMock();

        $cmisBindingsHelperMock = $this->getMockBuilder(
            CmisBindingsHelper::class
        )->getMock();

        $cmisBindingSessionInterfaceMock = $this->getMockBuilder(
            BindingSessionInterface::class
        )->setMethods(['getNavigationService'])->getMockForAbstractClass();
        $cmisBindingSessionInterfaceMock->expects($this->any())->method('getNavigationService')->willReturn(
            $this->getMockForAbstractClass(NavigationServiceInterface::class)
        );

        $cmisBindingsHelperMock->expects($this->any())->method('getSpi')->willReturn($cmisBindingSessionInterfaceMock);

        $binding->expects($this->any())->method('getCmisBindingsHelper')->willReturn(
            $cmisBindingsHelperMock
        );

        $this->assertInstanceOf(NavigationServiceInterface::class, $binding->getNavigationService());
    }

    /**
     * @depends testConstructorSetsObjectFactoryPropertyToGivenObjectFactory
     */
    public function testGetObjectFactoryReturnsDefinedObjectFactory(): void
    {
        /** @var PHPUnit_Framework_MockObject_MockObject|BindingsObjectFactory $objectFactory */
        $objectFactory = $this->getMockBuilder(BindingsObjectFactory::class)->setMockClassName(
            'CustomObjectFactory'
        )->getMock();
        $binding = new CmisBinding(
            new Session(),
            [SessionParameter::BINDING_CLASS => 'foo'],
            null,
            $objectFactory
        );
        $this->assertSame(
            $objectFactory,
            $binding->getObjectFactory()
        );
    }

    public function testGetDiscoveryServiceReturnsInstanceOfDiscoveryService(): void
    {
        // the subject will be mocked because we have to mock getCmisBindingsHelper
        /** @var CmisBinding|\PHPUnit_Framework_MockObject_MockObject $binding */
        $binding = $this->getMockBuilder(CmisBinding::class)->setConstructorArgs(
            [
                new Session(),
                [SessionParameter::BINDING_CLASS => 'foo']
            ]
        )->setMethods(['getCmisBindingsHelper'])->getMock();

        $cmisBindingsHelperMock = $this->getMockBuilder(
            CmisBindingsHelper::class
        )->getMock();

        $cmisBindingSessionInterfaceMock = $this->getMockBuilder(
            BindingSessionInterface::class
        )->setMethods(['getDiscoveryService'])->getMockForAbstractClass();
        $cmisBindingSessionInterfaceMock->expects($this->any())->method('getDiscoveryService')->willReturn(
            $this->getMockForAbstractClass(DiscoveryServiceInterface::class)
        );

        $cmisBindingsHelperMock->expects($this->any())->method('getSpi')->willReturn($cmisBindingSessionInterfaceMock);

        $binding->expects($this->any())->method('getCmisBindingsHelper')->willReturn(
            $cmisBindingsHelperMock
        );

        $this->assertInstanceOf(DiscoveryServiceInterface::class, $binding->getDiscoveryService());
    }
}

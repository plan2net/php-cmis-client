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
use Dkd\PhpCmis\Bindings\CmisBindingFactory;
use Dkd\PhpCmis\Bindings\CmisBinding;
use Dkd\PhpCmis\Bindings\BindingSessionInterface;
use Dkd\PhpCmis\Bindings\CmisInterface;
use Dkd\PhpCmis\Test\Fixtures\Php\Bindings\CmisBindingConstructorThrowsException;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Dkd\PhpCmis\Exception\CmisInvalidArgumentException;
use Dkd\PhpCmis\Test\Fixtures\Php\HttpInvokerConstructorThrowsException;
use Dkd\PhpCmis\Test\Fixtures\Php\ConstructorThrowsException;
use Dkd\PhpCmis\Bindings\CmisBindingsHelper;
use Dkd\PhpCmis\Enum\BindingType;
use Dkd\PhpCmis\SessionParameter;

/**
 * Class CmisBindingsHelperTest
 */
class CmisBindingsHelperTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var CmisBindingsHelper
     */
    protected $cmisBindingsHelper;

    public function setUp(): void
    {
        $this->cmisBindingsHelper = new CmisBindingsHelper();
    }

    public function testCreateBindingThrowsExceptionIfNoSessionParametersAreGiven(): void
    {
        $this->setExpectedException(
            CmisRuntimeException::class,
            'Session parameters must be set!'
        );
        $this->cmisBindingsHelper->createBinding([]);
    }

    public function testCreateBindingThrowsExceptionIfNoBindingTypeSessionParameterIsGiven(): void
    {
        $this->setExpectedException(
            CmisRuntimeException::class,
            'Required binding type is not configured!'
        );
        $this->cmisBindingsHelper->createBinding(['foo' => 'bar']);
    }

    public function testCreateBindingThrowsExceptionIfInvalidBindingTypeSessionParameterIsGiven(): void
    {
        $this->setExpectedException(
            CmisRuntimeException::class,
            'Invalid binding type given: bar'
        );
        $this->cmisBindingsHelper->createBinding([SessionParameter::BINDING_TYPE => 'bar']);
    }

    public function testCreateBindingThrowsExceptionIfGivenBindingTypeIsNotYetImplemented(): void
    {
        $this->setExpectedException(
            CmisRuntimeException::class,
            sprintf(
                'The given binding "%s" is not yet implemented.',
                BindingType::CUSTOM
            )
        );
        $this->cmisBindingsHelper->createBinding([SessionParameter::BINDING_TYPE => BindingType::CUSTOM]);
    }

    public function testCreateBindingRequestsBindingFactoryForRequestedBinding(): void
    {
        $parameters = [SessionParameter::BINDING_TYPE => BindingType::BROWSER];

        $cmisBindingsHelper = $this->getMockBuilder(CmisBindingsHelper::class)->setMethods(
            ['getCmisBindingFactory']
        )->getMock();

        $cmisBindingFactoryMock = $this->getMockBuilder(CmisBindingFactory::class)->setMethods(
            ['createCmisBrowserBinding']
        )->getMock();

        $cmisBindingFactoryMock->expects($this->once())->method('createCmisBrowserBinding')->with(
            $parameters
        )->willReturn(
            $this->getMockBuilder(CmisBinding::class)
                ->disableOriginalConstructor()
                ->getMockForAbstractClass()
        );

        $cmisBindingsHelper->expects($this->once())->method('getCmisBindingFactory')->willReturn(
            $cmisBindingFactoryMock
        );

        $cmisBindingsHelper->createBinding(
            $parameters
        );
    }

    public function testGetSpiReturnsInstanceOfBindingClassAndStoresItToTheSession(): void
    {
        $sessionMock = $this->getMockBuilder(BindingSessionInterface::class)->setMethods(
            ['get', 'put']
        )->getMockForAbstractClass();

        $bindingClassFixture = $this->getMockForAbstractClass(CmisInterface::class);
        $bindingClassFixtureClassName = $bindingClassFixture::class;

        // ensure that $session->get() is called 2 times. Once to check if spi exists already in the session
        // and second to get the name of the binding class that should be used for the spi.
        $sessionMock->expects($this->exactly(2))->method('get')->will(
            $this->returnValueMap(
                [
                    [CmisBindingsHelper::SPI_OBJECT, null, null],
                    [SessionParameter::BINDING_CLASS, null, $bindingClassFixtureClassName]
                ]
            )
        );

        // check if the binding is put into the session
        $sessionMock->expects($this->once())->method('put')->with(
            CmisBindingsHelper::SPI_OBJECT,
            $this->isInstanceOf($bindingClassFixtureClassName)
        );

        $spi = $this->cmisBindingsHelper->getSpi($sessionMock);

        $this->assertInstanceOf($bindingClassFixtureClassName, $spi);
    }

    public function testGetSpiReturnsSpiFromSessionIfAlreadyExists(): void
    {
        $sessionMock = $this->getMockBuilder(BindingSessionInterface::class)->setMethods(
            ['get']
        )->getMockForAbstractClass();

        $bindingClassFixture = $this->getMockForAbstractClass(CmisInterface::class);

        $sessionMock->expects($this->once())->method('get')->with(CmisBindingsHelper::SPI_OBJECT)->willReturn(
            $bindingClassFixture
        );

        $this->assertSame($bindingClassFixture, $this->cmisBindingsHelper->getSpi($sessionMock));
    }

    public function testGetSpiThrowsExceptionIfBindingClassIsNotConfiguredInSession(): void
    {
        $sessionMock = $this->getMockBuilder(BindingSessionInterface::class)->setMethods(
            ['get']
        )->getMockForAbstractClass();
        $sessionMock->expects($this->exactly(2))->method('get')->will(
            $this->returnValueMap(
                [
                    [CmisBindingsHelper::SPI_OBJECT, null, null],
                    [SessionParameter::BINDING_CLASS, null, null]
                ]
            )
        );

        $this->setExpectedException(
            CmisRuntimeException::class,
            'The given binding class "" is not valid!'
        );
        $this->cmisBindingsHelper->getSpi($sessionMock);
    }

    public function testGetSpiThrowsExceptionIfGivenBindingClassDoesNotExist(): void
    {
        $sessionMock = $this->getMockBuilder(BindingSessionInterface::class)->setMethods(
            ['get']
        )->getMockForAbstractClass();
        $sessionMock->expects($this->exactly(2))->method('get')->will(
            $this->returnValueMap(
                [
                    [CmisBindingsHelper::SPI_OBJECT, null, null],
                    [SessionParameter::BINDING_CLASS, null, 'ThisClassDoesNotExist']
                ]
            )
        );

        $this->setExpectedException(
            CmisRuntimeException::class,
            'The given binding class "ThisClassDoesNotExist" is not valid!'
        );
        $this->cmisBindingsHelper->getSpi($sessionMock);
    }

    public function testGetSpiThrowsExceptionIfGivenBindingClassCouldNotBeInstantiated(): void
    {
        $sessionMock = $this->getMockBuilder(BindingSessionInterface::class)->setMethods(
            ['get']
        )->getMockForAbstractClass();

        $spiClassName = CmisBindingConstructorThrowsException::class;
        $sessionMock->expects($this->exactly(2))->method('get')->will(
            $this->returnValueMap(
                [
                    [CmisBindingsHelper::SPI_OBJECT, null, null],
                    [SessionParameter::BINDING_CLASS, null, $spiClassName]
                ]
            )
        );

        $this->setExpectedException(
            CmisRuntimeException::class,
            sprintf('Could not create object of type "%s"!', $spiClassName)
        );
        $this->cmisBindingsHelper->getSpi($sessionMock);
    }

    public function testGetSpiThrowsExceptionIfGivenBindingClassDoesNotImplementCmisInterface(): void
    {
        $sessionMock = $this->getMockBuilder(BindingSessionInterface::class)->setMethods(
            ['get']
        )->getMockForAbstractClass();

        $sessionMock->expects($this->exactly(2))->method('get')->will(
            $this->returnValueMap(
                [
                    [CmisBindingsHelper::SPI_OBJECT, null, null],
                    [SessionParameter::BINDING_CLASS, null, 'stdClass']
                ]
            )
        );

        $this->setExpectedException(
            CmisRuntimeException::class,
            'The given binding class "stdClass" does not implement required CmisInterface!'
        );
        $this->cmisBindingsHelper->getSpi($sessionMock);
    }

    public function testGetHttpInvokerReturnsInstanceOfInvokerClassAndStoresItToTheSession(): void
    {
        $sessionMock = $this->getMockBuilder(BindingSessionInterface::class)->setMethods(
            ['get', 'put']
        )->getMockForAbstractClass();

        // ensure that $session->get() is called 2 times. Once to check if http invoker exists already in the session
        // and second to get the name of the http invoker class that should be used.
        $sessionMock->expects($this->exactly(2))->method('get')->will(
            $this->returnValueMap(
                [
                    [SessionParameter::HTTP_INVOKER_OBJECT, null, null],
                    [SessionParameter::HTTP_INVOKER_CLASS, null, Client::class]
                ]
            )
        );

        // check if the binding is put into the session
        $sessionMock->expects($this->once())->method('put')->with(
            SessionParameter::HTTP_INVOKER_OBJECT,
            $this->isInstanceOf(Client::class)
        );

        $httpInvoker = $this->cmisBindingsHelper->getHttpInvoker($sessionMock);

        $this->assertInstanceOf(Client::class, $httpInvoker);
    }

    public function testGetHttpInvokerReturnsHttpInvokerFromSessionIfAlreadyExists(): void
    {
        $sessionMock = $this->getMockBuilder(BindingSessionInterface::class)->setMethods(
            ['get']
        )->getMockForAbstractClass();

        $httpInvokerFixture = $this->getMock(ClientInterface::class);

        $sessionMock->expects($this->once())->method('get')->with(SessionParameter::HTTP_INVOKER_OBJECT)->willReturn(
            $httpInvokerFixture
        );

        $this->assertSame($httpInvokerFixture, $this->cmisBindingsHelper->getHttpInvoker($sessionMock));
    }

    public function testGetHttpInvokerThrowsExceptionIfInvokerDoesNotImplementExpectedInterface(): void
    {
        $sessionMock = $this->getMockBuilder(BindingSessionInterface::class)->setMethods(
            ['get']
        )->getMockForAbstractClass();

        $httpInvokerFixture = $this->getMock('\\stdClass');

        $sessionMock->expects($this->once())->method('get')->with(SessionParameter::HTTP_INVOKER_OBJECT)->willReturn(
            $httpInvokerFixture
        );

        $this->setExpectedException(
            CmisInvalidArgumentException::class,
            '',
            1415281262
        );
        $this->assertSame($httpInvokerFixture, $this->cmisBindingsHelper->getHttpInvoker($sessionMock));
    }

    public function testGetHttpInvokerThrowsExceptionIfHttpInvokerClassIsNotConfiguredInSession(): void
    {
        /** @var BindingSessionInterface|\PHPUnit_Framework_MockObject_MockObject $sessionMock */
        $sessionMock = $this->getMockBuilder(BindingSessionInterface::class)->setMethods(
            ['get']
        )->getMockForAbstractClass();
        $sessionMock->expects($this->exactly(2))->method('get')->will(
            $this->returnValueMap(
                [
                    [SessionParameter::HTTP_INVOKER_OBJECT, null, null],
                    [SessionParameter::HTTP_INVOKER_CLASS, null, null]
                ]
            )
        );

        $this->setExpectedException(
            CmisRuntimeException::class,
            'The given HTTP Invoker class "" is not valid!'
        );
        $this->cmisBindingsHelper->getHttpInvoker($sessionMock);
    }

    public function testGetHttpInvokerThrowsExceptionIfGivenHttpInvokerClassDoesNotExist(): void
    {
        /** @var BindingSessionInterface|\PHPUnit_Framework_MockObject_MockObject $sessionMock */
        $sessionMock = $this->getMockBuilder(BindingSessionInterface::class)->setMethods(
            ['get']
        )->getMockForAbstractClass();
        $sessionMock->expects($this->exactly(2))->method('get')->will(
            $this->returnValueMap(
                [
                    [SessionParameter::HTTP_INVOKER_OBJECT, null, null],
                    [SessionParameter::HTTP_INVOKER_CLASS, null, 'ThisClassDoesNotExist']
                ]
            )
        );

        $this->setExpectedException(
            CmisRuntimeException::class,
            'The given HTTP Invoker class "ThisClassDoesNotExist" is not valid!'
        );
        $this->cmisBindingsHelper->getHttpInvoker($sessionMock);
    }

    public function testGetHttpInvokerThrowsExceptionIfGivenHttpInvokerClassCouldNotBeInstantiated(): void
    {
        /** @var BindingSessionInterface|\PHPUnit_Framework_MockObject_MockObject $sessionMock */
        $sessionMock = $this->getMockBuilder(BindingSessionInterface::class)->setMethods(
            ['get']
        )->getMockForAbstractClass();

        $httpInvokerClassName = HttpInvokerConstructorThrowsException::class;
        $sessionMock->expects($this->exactly(2))->method('get')->will(
            $this->returnValueMap(
                [
                    [SessionParameter::HTTP_INVOKER_OBJECT, null, null],
                    [SessionParameter::HTTP_INVOKER_CLASS, null, $httpInvokerClassName]
                ]
            )
        );

        $this->setExpectedException(
            CmisRuntimeException::class,
            sprintf('Could not create object of type "%s"!', $httpInvokerClassName)
        );
        $this->cmisBindingsHelper->getHttpInvoker($sessionMock);
    }

    public function testGetJsonConverterReturnsInstanceOfConverterClassAndStoresItToTheSession(): void
    {
        $sessionMock = $this->getMockBuilder(BindingSessionInterface::class)->setMethods(
            ['get', 'put']
        )->getMockForAbstractClass();

        // ensure that $session->get() is called 2 times. Once to check if JSON Converter exists already in the session
        // and second to get the name of the JSON Converter class that should be used.
        $sessionMock->expects($this->exactly(2))->method('get')->will(
            $this->returnValueMap(
                [
                    [SessionParameter::JSON_CONVERTER, null, null],
                    [SessionParameter::JSON_CONVERTER_CLASS, null, Client::class]
                ]
            )
        );

        // check if the binding is put into the session
        $sessionMock->expects($this->once())->method('put')->with(
            SessionParameter::JSON_CONVERTER,
            $this->isInstanceOf(Client::class)
        );

        $jsonConverter = $this->cmisBindingsHelper->getJsonConverter($sessionMock);

        $this->assertInstanceOf(Client::class, $jsonConverter);
    }

    public function testGetJsonConverterReturnsJsonConverterFromSessionIfAlreadyExists(): void
    {
        $sessionMock = $this->getMockBuilder(BindingSessionInterface::class)->setMethods(
            ['get']
        )->getMockForAbstractClass();

        $jsonConverterFixture = $this->getMock('\\stdClass');

        $sessionMock->expects($this->once())->method('get')->with(SessionParameter::JSON_CONVERTER)->willReturn(
            $jsonConverterFixture
        );

        $this->assertSame($jsonConverterFixture, $this->cmisBindingsHelper->getJsonConverter($sessionMock));
    }

    public function testGetJsonConverterThrowsExceptionIfJsonConverterClassIsNotConfiguredInSession(): void
    {
        /** @var BindingSessionInterface|\PHPUnit_Framework_MockObject_MockObject $sessionMock */
        $sessionMock = $this->getMockBuilder(BindingSessionInterface::class)->setMethods(
            ['get']
        )->getMockForAbstractClass();
        $sessionMock->expects($this->exactly(2))->method('get')->will(
            $this->returnValueMap(
                [
                    [SessionParameter::JSON_CONVERTER, null, null],
                    [SessionParameter::JSON_CONVERTER_CLASS, null, null]
                ]
            )
        );

        $this->setExpectedException(
            CmisRuntimeException::class,
            'The given JSON Converter class "" is not valid!'
        );
        $this->cmisBindingsHelper->getJsonConverter($sessionMock);
    }

    public function testGetJsonConverterThrowsExceptionIfGivenJsonConverterClassDoesNotExist(): void
    {
        /** @var BindingSessionInterface|\PHPUnit_Framework_MockObject_MockObject $sessionMock */
        $sessionMock = $this->getMockBuilder(BindingSessionInterface::class)->setMethods(
            ['get']
        )->getMockForAbstractClass();
        $sessionMock->expects($this->exactly(2))->method('get')->will(
            $this->returnValueMap(
                [
                    [SessionParameter::JSON_CONVERTER, null, null],
                    [SessionParameter::JSON_CONVERTER_CLASS, null, 'ThisClassDoesNotExist']
                ]
            )
        );

        $this->setExpectedException(
            CmisRuntimeException::class,
            'The given JSON Converter class "ThisClassDoesNotExist" is not valid!'
        );
        $this->cmisBindingsHelper->getJsonConverter($sessionMock);
    }

    public function testGetJsonConverterThrowsExceptionIfGivenJsonConverterClassCouldNotBeInstantiated(): void
    {
        /** @var BindingSessionInterface|\PHPUnit_Framework_MockObject_MockObject $sessionMock */
        $sessionMock = $this->getMockBuilder(BindingSessionInterface::class)->setMethods(
            ['get']
        )->getMockForAbstractClass();

        $jsonConverterClassName = ConstructorThrowsException::class;
        $sessionMock->expects($this->exactly(2))->method('get')->will(
            $this->returnValueMap(
                [
                    [SessionParameter::JSON_CONVERTER, null, null],
                    [SessionParameter::JSON_CONVERTER_CLASS, null, $jsonConverterClassName]
                ]
            )
        );

        $this->setExpectedException(
            CmisRuntimeException::class,
            sprintf('Could not create object of type "%s"!', $jsonConverterClassName)
        );
        $this->cmisBindingsHelper->getJsonConverter($sessionMock);
    }
}

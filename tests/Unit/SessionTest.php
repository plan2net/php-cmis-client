<?php
namespace Dkd\PhpCmis\Test\Unit;

/*
 * This file is part of php-cmis-client
 *
 * (c) Sascha Egerer <sascha.egerer@dkd.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use PHPUnit_Framework_TestCase;
use Dkd\PhpCmis\Exception\CmisInvalidArgumentException;
use Dkd\PhpCmis\RepositoryServiceInterface;
use Dkd\PhpCmis\RelationshipServiceInterface;
use Dkd\PhpCmis\Bindings\CmisBindingInterface;
use Dkd\PhpCmis\ObjectFactory;
use ReflectionClass;
use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\CacheProvider;
use Dkd\PhpCmis\DataObjects\RepositoryInfo;
use Dkd\PhpCmis\Data\ObjectTypeInterface;
use ReflectionProperty;
use Dkd\PhpCmis\DataObjects\ObjectId;
use Dkd\PhpCmis\Enum\RelationshipDirection;
use Dkd\PhpCmis\Bindings\CmisBindingsHelper;
use Dkd\PhpCmis\ObjectFactoryInterface;
use Dkd\PhpCmis\Session;
use Dkd\PhpCmis\SessionParameter;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Class SessionTest
 */
class SessionTest extends PHPUnit_Framework_TestCase
{
    public function testConstructorThrowsExceptionIfNoParametersGiven(): void
    {
        $this->setExpectedException(
            CmisInvalidArgumentException::class,
            'No parameters provided!',
            1408115280
        );
        new Session([]);
    }

    /**
     * @return CmisBindingsHelper|PHPUnit_Framework_MockObject_MockObject
     */
    protected function getBindingsHelperMock()
    {
        $repositoryServiceMock = $this->getMockBuilder(
            RepositoryServiceInterface::class
        )->getMockForAbstractClass();
        $relationshipServiceMock = $this->getMockBuilder(
            RelationshipServiceInterface::class
        )->getMockForAbstractClass();
        $bindingMock = $this->getMockBuilder(CmisBindingInterface::class)->setMethods(
            ['getRepositoryService', 'getRelationshipService']
        )->getMockForAbstractClass();
        $bindingMock->expects($this->any())->method('getRepositoryService')->willReturn($repositoryServiceMock);
        $bindingMock->expects($this->any())->method('getRelationshipService')->willReturn($relationshipServiceMock);
        /** @var CmisBindingsHelper|PHPUnit_Framework_MockObject_MockObject $bindingsHelperMock */
        $bindingsHelperMock = $this->getMockBuilder(CmisBindingsHelper::class)->setMethods(
            ['createBinding']
        )->getMockForAbstractClass();
        $bindingsHelperMock->expects($this->any())->method('createBinding')->willReturn($bindingMock);

        return $bindingsHelperMock;
    }

    public function testObjectFactoryIsSetToDefaultObjectFactoryWhenNoObjectFactoryIsGivenOrDefined(): void
    {
        $session = new Session(
            [SessionParameter::REPOSITORY_ID => 'foo'],
            null,
            null,
            null,
            null,
            $this->getBindingsHelperMock()
        );
        $this->assertInstanceOf(ObjectFactory::class, $session->getObjectFactory());
    }

    public function testObjectFactoryIsSetToObjectFactoryInstanceGivenAsMethodParameter(): void
    {
        /** @var ObjectFactoryInterface $dummyObjectFactory */
        $dummyObjectFactory = $this->getMock(ObjectFactoryInterface::class);
        $session = new Session(
            [SessionParameter::REPOSITORY_ID => 'foo'],
            $dummyObjectFactory,
            null,
            null,
            null,
            $this->getBindingsHelperMock()
        );

        $this->assertSame($dummyObjectFactory, $session->getObjectFactory());
    }

    public function testObjectFactoryIsSetToObjectFactoryDefinedInParametersArray(): void
    {
        $objectFactory = $this->getMock(ObjectFactory::class);
        $session = new Session(
            [
                SessionParameter::REPOSITORY_ID => 'foo',
                SessionParameter::OBJECT_FACTORY_CLASS => $objectFactory::class
            ],
            null,
            null,
            null,
            null,
            $this->getBindingsHelperMock()
        );

        $this->assertEquals($objectFactory, $session->getObjectFactory());
    }

    public function testExceptionIsThrownIfConfiguredObjectFactoryDoesNotImplementObjectFactoryInterface(): void
    {
        $this->setExpectedException(
            '\\RuntimeException',
            '',
            1408354120
        );

        $object = $this->getMock('\\stdClass');
        new Session(
            [SessionParameter::OBJECT_FACTORY_CLASS => $object::class]
        );
    }

    public function testCreatedObjectFactoryInstanceWillBeInitialized(): void
    {
        // dummy object factory with a spy on initialize
        $objectFactory = $this->getMock(ObjectFactory::class);
        $objectFactory->expects($this->once())->method('initialize');

        $sessionClassName = Session::class;

        // Get mock, without the constructor being called
        $mock = $this->getMockBuilder($sessionClassName)
                     ->disableOriginalConstructor()
                     ->setMethods(['createDefaultObjectFactoryInstance'])
                     ->getMock();

        // set createDefaultObjectFactoryInstance to return our object factory spy
        $mock->expects($this->once())
             ->method('createDefaultObjectFactoryInstance')
             ->willReturn($objectFactory);

        // now call the constructor
        $reflectedClass = new ReflectionClass($mock::class);
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke(
            $mock,
            [SessionParameter::REPOSITORY_ID => 'foo'],
            null,
            null,
            null,
            null,
            $this->getBindingsHelperMock()
        );
    }

    public function testCreateQueryStatementThrowsErrorOnEmptyProperties(): void
    {
        $this->setExpectedException(CmisInvalidArgumentException::class);
        $mock = $this->getMockBuilder(Session::class)
            ->setMethods(['dummy'])
            ->disableOriginalConstructor()
            ->getMock();
        $mock->createQueryStatement([], ['foobar']);
    }

    public function testCreateQueryStatementThrowsErrorOnEmptyTypes(): void
    {
        $this->setExpectedException(CmisInvalidArgumentException::class);
        $mock = $this->getMockBuilder(Session::class)
            ->setMethods(['dummy'])
            ->disableOriginalConstructor()
            ->getMock();
        $mock->createQueryStatement(['foobar'], []);
    }

    public function testCacheIsSetToDefaultCacheWhenNoCacheIsGivenOrDefined(): void
    {
        $session = new Session(
            [SessionParameter::REPOSITORY_ID => 'foo'],
            null,
            null,
            null,
            null,
            $this->getBindingsHelperMock()
        );
        $this->assertInstanceOf(Cache::class, $session->getCache());
    }

    public function testCacheIsSetToCacheInstanceGivenAsMethodParameter(): void
    {
        /** @var Cache $dummyCache */
        $dummyCache = $this->getMockForAbstractClass(Cache::class);
        $session = new Session(
            [SessionParameter::REPOSITORY_ID => 'foo'],
            null,
            $dummyCache,
            null,
            null,
            $this->getBindingsHelperMock()
        );
        $this->assertSame($dummyCache, $session->getCache());
    }

    public function testCacheIsSetToCacheDefinedInParametersArray(): void
    {
        $cache = $this->getMockForAbstractClass(CacheProvider::class);
        $session = new Session(
            [SessionParameter::REPOSITORY_ID => 'foo', SessionParameter::CACHE_CLASS => $cache::class],
            null,
            null,
            null,
            null,
            $this->getBindingsHelperMock()
        );
        $this->assertEquals($cache, $session->getCache());
    }

    public function testExceptionIsThrownIfConfiguredCacheDoesNotImplementCacheInterface(): void
    {
        $this->setExpectedException(
            CmisInvalidArgumentException::class,
            '',
            1408354123
        );

        $object = $this->getMock('\\stdClass');
        new Session(
            [SessionParameter::CACHE_CLASS => $object::class]
        );
    }

    public function testGetRelationships(): void
    {
        $bindingsMock = $this->getBindingsHelperMock();
        $bindingsMock->createBinding([])->getRelationshipService()
            ->expects($this->once())
            ->method('getObjectRelationships')
            ->with();
        $session = new Session(
            [SessionParameter::REPOSITORY_ID => 'foo'],
            null,
            null,
            null,
            null,
            $bindingsMock
        );
        $repositoryInfo = $this->getMockBuilder(RepositoryInfo::class)
            ->setMethods(['getId'])
            ->getMock();
        $repositoryInfo->expects($this->once())->method('getId');
        $objectType = $this->getMockBuilder(ObjectTypeInterface::class)
            ->setMethods(['getId', '__toString'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $property = new ReflectionProperty($session, 'repositoryInfo');
        $property->setAccessible(true);
        $property->setValue($session, $repositoryInfo);
        $session->getRelationships(
            new ObjectId('foobar-object-id'),
            true,
            RelationshipDirection::cast(RelationshipDirection::TARGET),
            $objectType
        );
    }
}

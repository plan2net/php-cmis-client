<?php
namespace Dkd\PhpCmis\Test\Unit;

/*
 * This file is part of php-cmis-lib.
 *
 * (c) Dimitri Ebert <dimitri.ebert@dkd.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use PHPUnit_Framework_TestCase;
use Dkd\PhpCmis\Data\DocumentInterface;
use GuzzleHttp\Stream\StreamInterface;
use Dkd\PhpCmis\Bindings\Browser\ObjectService;
use Dkd\PhpCmis\Bindings\CmisBindingInterface;
use Dkd\PhpCmis\Data\RepositoryInfoInterface;
use Dkd\PhpCmis\DataObjects\ObjectId;
use Dkd\PhpCmis\DataObjects\Rendition;
use Dkd\PhpCmis\SessionInterface;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Class RenditionTest
 */
class RenditionTest extends PHPUnit_Framework_TestCase
{
    use ReflectionHelperTrait;

    /**
     * @var SessionInterface|PHPUnit_Framework_MockObject_MockObject
     */
    protected $sessionMock;

    public function setUp(): void
    {
        $this->sessionMock = $this->getMockBuilder(SessionInterface::class)->getMockForAbstractClass();
    }

    public function testConstructorSetsSessionFromGivenSessionParameter(): void
    {
        $rendition = new Rendition($this->sessionMock, 'objectId');
        $this->assertAttributeSame($this->sessionMock, 'session', $rendition);
    }

    public function testConstructorSetsObjectIdFromGivenObjectId(): void
    {
        $objectId = 'fooObjectId';
        $rendition = new Rendition($this->sessionMock, $objectId);
        $this->assertAttributeSame($objectId, 'objectId', $rendition);
    }

    public function testGetHeightReturnsHeight(): void
    {
        $height = 123;
        $rendition = new Rendition($this->sessionMock, 'objectId');
        $rendition->setHeight($height);
        $this->assertSame($height, $rendition->getHeight());
    }

    public function testGetHeightReturnsMinus1IfNoAvailable(): void
    {
        $rendition = new Rendition($this->sessionMock, 'objectId');
        $this->assertSame(-1, $rendition->getHeight());
    }

    public function testGetLengthReturnsLength(): void
    {
        $length = 124;
        $rendition = new Rendition($this->sessionMock, 'objectId');
        $rendition->setLength($length);
        $this->assertSame($length, $rendition->getLength());
    }

    public function testGetLengthReturnsMinus1IfNoAvailable(): void
    {
        $rendition = new Rendition($this->sessionMock, 'objectId');
        $this->assertSame(-1, $rendition->getLength());
    }

    public function testGetWidthReturnsWidth(): void
    {
        $width = 125;
        $rendition = new Rendition($this->sessionMock, 'objectId');
        $rendition->setWidth($width);
        $this->assertSame($width, $rendition->getWidth());
    }

    public function testGetWidthReturnsMinus1IfNoAvailable(): void
    {
        $rendition = new Rendition($this->sessionMock, 'objectId');
        $this->assertSame(-1, $rendition->getWidth());
    }

    public function testGetRenditionDocumentReturnsDocument(): void
    {
        $renditionDocumentId = 'foo';
        $documentMock = $this->getMockBuilder(DocumentInterface::class)->getMockForAbstractClass();

        $this->sessionMock->expects($this->once())->method('createObjectId')->with(
            $renditionDocumentId
        )->willReturn(new ObjectId('foo'));

        $this->sessionMock->expects($this->once())->method('getObject')->with(
            $renditionDocumentId
        )->willReturn($documentMock);

        $rendition = new Rendition($this->sessionMock, 'objectId');
        $rendition->setRenditionDocumentId($renditionDocumentId);

        $this->assertSame($documentMock, $rendition->getRenditionDocument());
    }

    public function testGetContentStreamReturnsStream(): void
    {
        $streamId = 'bar';
        $objectId = 'foo';

        /** @var  RepositoryInfoInterface|PHPUnit_Framework_MockObject_MockObject $repositoryInfoMock */
        $repositoryInfoMock = $this->getMockBuilder(
            RepositoryInfoInterface::class
        )->setMethods(['getId'])->getMockForAbstractClass();
        $repositoryInfoMock->expects($this->any())->method('getId')->willReturn('repositoryId');

        $streamMock = $this->getMockBuilder(StreamInterface::class)->getMockForAbstractClass();

        $objectServiceMock = $this->getMockBuilder(
            ObjectService::class
        )->setMethods(['getContentStream'])->disableOriginalConstructor()->getMockForAbstractClass();

        $objectServiceMock->expects($this->once())->method('getContentStream')->with(
            $repositoryInfoMock->getId(),
            $objectId,
            $streamId
        )->willReturn($streamMock);

        $bindingMock = $this->getMockBuilder(
            CmisBindingInterface::class
        )->setMethods(['getObjectService'])->disableOriginalConstructor()->getMockForAbstractClass();

        $bindingMock->expects($this->once())->method('getObjectService')->willReturn($objectServiceMock);


        $this->sessionMock->expects($this->once())->method('getBinding')->willReturn($bindingMock);
        $this->sessionMock->expects($this->once())->method('getRepositoryInfo')->willReturn($repositoryInfoMock);

        $rendition = new Rendition($this->sessionMock, $objectId);
        $rendition->setStreamId($streamId);
        $this->assertSame($streamMock, $rendition->getContentStream());
    }
}

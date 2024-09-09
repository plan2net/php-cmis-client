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
use Dkd\PhpCmis\Exception\CmisInvalidArgumentException;
use Dkd\PhpCmis\Bindings\CmisBinding;
use Dkd\PhpCmis\Bindings\CmisBindingFactory;
use Dkd\PhpCmis\SessionParameter;
use Dkd\PhpCmis\Test\Unit\ReflectionHelperTrait;

/**
 * Class CmisBindingFactoryTest
 */
class CmisBindingFactoryTest extends PHPUnit_Framework_TestCase
{
    use ReflectionHelperTrait;

    /**
     * @var CmisBindingFactory
     */
    protected $cmisBindingFactory;

    /**
     * @var string
     */
    const CLASS_TO_TEST = '\\Dkd\\PhpCmis\\Bindings\\CmisBindingFactory';

    public function setUp(): void
    {
        $className = self::CLASS_TO_TEST;
        $this->cmisBindingFactory = new $className();
    }

    public function testCreateCmisBrowserBindingThrowsExceptionIfBrowserUrlIsNotConfigured(): void
    {
        $this->setExpectedException(CmisInvalidArgumentException::class);
        $this->cmisBindingFactory->createCmisBrowserBinding(['foo' => 'bar']);
    }

    public function testValidateCmisBrowserBindingParametersThrowsExceptionIfBrowserUrlIsNotConfigured(): void
    {
        $sessionParameters = [];

        $this->setExpectedException(CmisInvalidArgumentException::class);
        $validateMethod = $this->getMethod(self::CLASS_TO_TEST, 'validateCmisBrowserBindingParameters');
        $validateMethod->invokeArgs($this->cmisBindingFactory, [&$sessionParameters]);
    }

    public function testValidateCmisBrowserBindingParametersAddsDefaultValueForBindingClass(): void
    {
        $sessionParameters = [SessionParameter::BROWSER_URL => 'foo'];

        $validateMethod = $this->getMethod(self::CLASS_TO_TEST, 'validateCmisBrowserBindingParameters');
        $validateMethod->invokeArgs($this->cmisBindingFactory, [&$sessionParameters]);

        $this->assertArrayHasKey(SessionParameter::BINDING_CLASS, $sessionParameters);
    }

    public function testValidateCmisBrowserBindingParametersSetsBrowserSuccinctTrueIfNotSet(): void
    {
        $sessionParameters = [SessionParameter::BROWSER_URL => 'foo'];

        $validateMethod = $this->getMethod(self::CLASS_TO_TEST, 'validateCmisBrowserBindingParameters');
        $validateMethod->invokeArgs($this->cmisBindingFactory, [&$sessionParameters]);

        $this->assertArrayHasKey(SessionParameter::BROWSER_SUCCINCT, $sessionParameters);
        $this->assertTrue($sessionParameters[SessionParameter::BROWSER_SUCCINCT]);

        // ensure that BROWSER_SUCCINCT is not modified after it has been assigned to the session
        $sessionParameters[SessionParameter::BROWSER_SUCCINCT] = 'FOOBAR';
        $validateMethod->invokeArgs($this->cmisBindingFactory, [&$sessionParameters]);
        $this->assertEquals('FOOBAR', $sessionParameters[SessionParameter::BROWSER_SUCCINCT]);
    }

    public function testCreateCmisBrowserBindingReturnsCmisBinding(): void
    {
        $sessionParameters = [SessionParameter::BROWSER_URL => 'foo'];
        $browserBinding = $this->cmisBindingFactory->createCmisBrowserBinding($sessionParameters);
        $this->assertInstanceOf(CmisBinding::class, $browserBinding);
    }
}

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
use Dkd\PhpCmis\DataObjects\ExtensionFeature;
use Dkd\PhpCmis\Test\Unit\DataProviderCollectionTrait;

/**
 * Class ExtensionFeatureTest
 */
class ExtensionFeatureTest extends PHPUnit_Framework_TestCase
{
    use DataProviderCollectionTrait;

    /**
     * @var ExtensionFeature
     */
    protected $extensionFeature;

    public function setUp(): void
    {
        $this->extensionFeature = new ExtensionFeature();
    }

    /**
     * @dataProvider stringCastDataProvider
     * @param $value
     * @param $expected
     */
    public function testSetCommonNameSetsProperty($expected, $value): void
    {
        $this->extensionFeature->setCommonName($value);
        $this->assertAttributeSame($expected, 'commonName', $this->extensionFeature);
    }

    /**
     * @depends testSetCommonNameSetsProperty
     */
    public function testGetCommonNameReturnsPropertyValue(): void
    {
        $this->extensionFeature->setCommonName('string');
        $this->assertSame('string', $this->extensionFeature->getCommonName());
    }

    /**
     * @dataProvider stringCastDataProvider
     * @param $value
     * @param $expected
     */
    public function testSetDescriptionSetsProperty($expected, $value): void
    {
        $this->extensionFeature->setDescription($value);
        $this->assertAttributeSame($expected, 'description', $this->extensionFeature);
    }

    /**
     * @depends testSetDescriptionSetsProperty
     */
    public function testGetDescriptionReturnsPropertyValue(): void
    {
        $this->extensionFeature->setDescription('string');
        $this->assertSame('string', $this->extensionFeature->getDescription());
    }

    /**
     * @dataProvider stringCastDataProvider
     * @param $value
     * @param $expected
     */
    public function testSetIdSetsProperty($expected, $value): void
    {
        $this->extensionFeature->setId($value);
        $this->assertAttributeSame($expected, 'id', $this->extensionFeature);
    }

    /**
     * @depends testSetIdSetsProperty
     */
    public function testGetIdReturnsPropertyValue(): void
    {
        $this->extensionFeature->setId('string');
        $this->assertSame('string', $this->extensionFeature->getId());
    }

    /**
     * @dataProvider stringCastDataProvider
     * @param $value
     * @param $expected
     */
    public function testSetUrlSetsProperty($expected, $value): void
    {
        $this->extensionFeature->setUrl($value);
        $this->assertAttributeSame($expected, 'url', $this->extensionFeature);
    }

    /**
     * @depends testSetUrlSetsProperty
     */
    public function testGetUrlReturnsPropertyValue(): void
    {
        $this->extensionFeature->setUrl('string');
        $this->assertSame('string', $this->extensionFeature->getUrl());
    }

    /**
     * @dataProvider stringCastDataProvider
     * @param $value
     * @param $expected
     */
    public function testSetVersionLabelSetsProperty($expected, $value): void
    {
        $this->extensionFeature->setVersionLabel($value);
        $this->assertAttributeSame($expected, 'versionLabel', $this->extensionFeature);
    }

    /**
     * @depends testSetVersionLabelSetsProperty
     */
    public function testGetVersionLabelReturnsPropertyValue(): void
    {
        $this->extensionFeature->setVersionLabel('string');
        $this->assertSame('string', $this->extensionFeature->getVersionLabel());
    }

    public function testSetFeatureDataSetsProperty(): void
    {
        $this->extensionFeature->setFeatureData([1, true, 'string']);
        $this->assertAttributeSame(['1', '1', 'string'], 'featureData', $this->extensionFeature);
    }

    /**
     * @depends testSetVersionLabelSetsProperty
     */
    public function testGetFeatureDataReturnsPropertyValue(): void
    {
        $this->extensionFeature->setFeatureData(['string']);
        $this->assertSame(['string'], $this->extensionFeature->getFeatureData());
    }
}

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
use Dkd\PhpCmis\Exception\CmisInvalidArgumentException;
use stdClass;
use Dkd\PhpCmis\DataObjects\Choice;
use Dkd\PhpCmis\Definitions\ChoiceInterface;

/**
 * Class ChoiceTest
 */
class ChoiceTest extends PHPUnit_Framework_TestCase
{
    const CLASS_TO_TEST = '\\Dkd\\PhpCmis\\DataObjects\\Choice';

    /**
     * @var Choice
     */
    protected $choice;

    public function setUp(): void
    {
        $this->choice = new Choice();
    }

    public function testSetChoiceSetsPropertyValue(): void
    {
        /** @var ChoiceInterface $choice */
        $choice = $this->getMockForAbstractClass(self::CLASS_TO_TEST);
        $this->choice->setChoices([$choice]);
        $this->assertAttributeEquals([$choice], 'choices', $this->choice);
    }

    public function testSetChoiceThrowsExceptionIfChoiceListContainsInvalidValue(): void
    {
        /** @var ChoiceInterface $choice */
        $choice = $this->getMockForAbstractClass(self::CLASS_TO_TEST);
        $this->setExpectedException(CmisInvalidArgumentException::class, '', 1413440336);
        $this->choice->setChoices([$choice, new stdClass()]);
    }

    /**
     * @depends testSetChoiceSetsPropertyValue
     */
    public function testGetChoicesGetsPropertyValue(): void
    {
        $choice = $this->getMockForAbstractClass(self::CLASS_TO_TEST);
        $this->choice->setChoices([$choice]);

        $this->assertEquals([$choice], $this->choice->getChoices());
    }

    public function testSetDisplayNameSetsPropertyValue(): void
    {
        $displayName = 'displayNameValue';
        $this->choice->setDisplayName($displayName);
        $this->assertAttributeSame($displayName, 'displayName', $this->choice);
    }

    /**
     * @depends testSetDisplayNameSetsPropertyValue
     */
    public function testGetDisplayNameGetsPropertyValue(): void
    {
        $displayName = 'displayNameValue';
        $this->choice->setDisplayName($displayName);
        $this->assertSame($displayName, $this->choice->getDisplayName());
    }

    public function testSetValueSetsPropertyValue(): void
    {
        $value = ['value', 1, true, new Choice()];
        $this->choice->setValue($value);
        $this->assertAttributeSame($value, 'value', $this->choice);
    }

    /**
     * @depends testSetValueSetsPropertyValue
     */
    public function testGetValueGetsPropertyValue(): void
    {
        $value = ['value', 1, true, new Choice()];
        $this->choice->setValue($value);
        $this->assertSame($value, $this->choice->getValue());
    }
}

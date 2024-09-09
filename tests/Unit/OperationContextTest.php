<?php
namespace Dkd\PhpCmis\Test\Unit;

/*
 * This file is part of php-cmis-lib.
 *
 * (c) Sascha Egerer <sascha.egerer@dkd.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use PHPUnit_Framework_TestCase;
use ReflectionClass;
use Dkd\PhpCmis\Constants;
use Dkd\PhpCmis\Enum\IncludeRelationships;
use Dkd\PhpCmis\OperationContext;

/**
 * Class OperationContextTest
 */
class OperationContextTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var OperationContext
     */
    protected $operationContext;

    public function setUp(): void
    {
        $this->operationContext = new OperationContext();
    }

    public function testConstructorCallsSetRenditionFilterToInitalizeIt(): void
    {
        $operationContextMock = $this->getMockBuilder(OperationContext::class)->disableOriginalConstructor(
        )->getMock();
        $operationContextMock->expects($this->once())->method('setRenditionFilter')->with([]);

        // now call the constructor
        $reflectedClass = new ReflectionClass($operationContextMock::class);
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke($operationContextMock);
    }

    public function testConstructorInitializesIncludeRelationshipsAttribute(): void
    {
        $this->assertAttributeEquals(
            IncludeRelationships::cast(IncludeRelationships::NONE),
            'includeRelationships',
            $this->operationContext
        );
    }

    public function testSetIncludeAclsSetsProperty(): void
    {
        $this->operationContext->setIncludeAcls(true);
        $this->assertAttributeSame(true, 'includeAcls', $this->operationContext);
        $this->operationContext->setIncludeAcls(false);
        $this->assertAttributeSame(false, 'includeAcls', $this->operationContext);
    }

    public function testSetIncludeAllowableActionsSetsProperty(): void
    {
        $this->operationContext->setIncludeAllowableActions(true);
        $this->assertAttributeSame(true, 'includeAllowableActions', $this->operationContext);
        $this->operationContext->setIncludeAllowableActions(false);
        $this->assertAttributeSame(false, 'includeAllowableActions', $this->operationContext);
    }

    public function testSetIncludePathSegmentsSetsProperty(): void
    {
        $this->operationContext->setIncludePathSegments(true);
        $this->assertAttributeSame(true, 'includePathSegments', $this->operationContext);
        $this->operationContext->setIncludePathSegments(false);
        $this->assertAttributeSame(false, 'includePathSegments', $this->operationContext);
    }

    public function testSetIncludePoliciesSetsProperty(): void
    {
        $this->operationContext->setIncludePolicies(true);
        $this->assertAttributeSame(true, 'includePolicies', $this->operationContext);
        $this->operationContext->setIncludePolicies(false);
        $this->assertAttributeSame(false, 'includePolicies', $this->operationContext);
    }

    public function testSetFilterSetsProperty(): void
    {
        $this->operationContext->setFilter(['foo']);
        $this->assertAttributeSame(['foo'], 'filter', $this->operationContext);
        $this->operationContext->setFilter(['baz', 'bar']);
        $this->assertAttributeSame(['baz', 'bar'], 'filter', $this->operationContext);
    }

    public function testSetFilterSetsPropertyAndIgnoresEmptyFilterValues(): void
    {
        $this->operationContext->setFilter(['foo', '', 0, 'bar']);
        $this->assertAttributeSame(['foo', '0', 'bar'], 'filter', $this->operationContext);
    }

    public function testSetFilterThrowsExceptionIfFilterContainsComma(): void
    {
        $this->setExpectedException('\\InvalidArgumentException', 'Filter must not contain a comma!');
        $this->operationContext->setFilter(['foo', 'bar,baz']);
    }

    public function testSetRenditionFilterSetsProperty(): void
    {
        $this->operationContext->setRenditionFilter(['foo']);
        $this->assertAttributeSame(['foo'], 'renditionFilter', $this->operationContext);
        $this->operationContext->setRenditionFilter(['baz', 'bar']);
        $this->assertAttributeSame(['baz', 'bar'], 'renditionFilter', $this->operationContext);
    }

    public function testSetRenditionFilterThrowsExceptionIfFilterContainsComma(): void
    {
        $this->setExpectedException('\\InvalidArgumentException', 'Rendition must not contain a comma!');
        $this->operationContext->setRenditionFilter(['foo', 'bar,baz']);
    }

    public function testSetRenditionFilterIgnoresEmptyFilters(): void
    {
        $this->operationContext->setRenditionFilter(['', 0, 'foo']);
        $this->assertAttributeSame(['0' ,'foo'], 'renditionFilter', $this->operationContext);
    }

    public function testSetRenditionFilterSetsRenditionNoneIfEmptyListOfRenditionsGiven(): void
    {
        $this->operationContext->setRenditionFilter([]);
        $this->assertAttributeSame([Constants::RENDITION_NONE], 'renditionFilter', $this->operationContext);
    }

    public function testSetLoadSecondaryTypePropertiesSetsProperty(): void
    {
        $this->operationContext->setLoadSecondaryTypeProperties(false);
        $this->assertAttributeSame(false, 'loadSecondaryTypeProperties', $this->operationContext);
        $this->operationContext->setLoadSecondaryTypeProperties(true);
        $this->assertAttributeSame(true, 'loadSecondaryTypeProperties', $this->operationContext);
    }

    public function testSetMaxItemsPerPageSetsProperty(): void
    {
        $this->operationContext->setMaxItemsPerPage(10);
        $this->assertAttributeSame(10, 'maxItemsPerPage', $this->operationContext);
        $this->operationContext->setMaxItemsPerPage(20);
        $this->assertAttributeSame(20, 'maxItemsPerPage', $this->operationContext);
    }

    public function testSetMaxItemsPerPageThrowsExceptionIfInvalidValueIsGiven(): void
    {
        $this->setExpectedException('\\InvalidArgumentException');
        $this->operationContext->setMaxItemsPerPage(0);
    }

    public function testSetOrderBySetsProperty(): void
    {
        $this->operationContext->setOrderBy('foo ASC, Bar desc');
        $this->assertAttributeSame('foo ASC, Bar desc', 'orderBy', $this->operationContext);
    }

    public function testSetIncludeRelationshipsSetsProperty(): void
    {
        $this->operationContext->setIncludeRelationships(IncludeRelationships::cast(IncludeRelationships::BOTH));
        $this->assertAttributeEquals(
            IncludeRelationships::cast(IncludeRelationships::BOTH),
            'includeRelationships',
            $this->operationContext
        );
        $this->operationContext->setIncludeRelationships(IncludeRelationships::cast(IncludeRelationships::NONE));
        $this->assertAttributeEquals(
            IncludeRelationships::cast(IncludeRelationships::NONE),
            'includeRelationships',
            $this->operationContext
        );
    }

    public function testSetFilterStringExplodesStringByCommaAndSetsResultAsFilterProperty(): void
    {
        $this->operationContext->setFilterString('');
        $this->assertAttributeSame([], 'filter', $this->operationContext);
        $this->operationContext->setFilterString('foo,bar');
        $this->assertAttributeSame(['foo', 'bar'], 'filter', $this->operationContext);
        $this->operationContext->setFilterString('foo,bar,baz');
        $this->assertAttributeSame(['foo', 'bar', 'baz'], 'filter', $this->operationContext);
    }

    public function testSetRenditionFilterStringExplodesStringByCommaAndSetsResultAsFilterProperty(): void
    {
        $this->operationContext->setRenditionFilterString('');
        $this->assertAttributeSame(['cmis:none'], 'renditionFilter', $this->operationContext);
        $this->operationContext->setRenditionFilterString('foo,bar');
        $this->assertAttributeSame(['foo', 'bar'], 'renditionFilter', $this->operationContext);
        $this->operationContext->setRenditionFilterString('foo,bar,baz');
        $this->assertAttributeSame(['foo', 'bar', 'baz'], 'renditionFilter', $this->operationContext);
    }

    public function testGetCacheKeyReturnsStringBasedOnPropertyValues(): void
    {
        $this->assertSame('0101||none|cmis:none', $this->operationContext->getCacheKey());

        $this->operationContext->setIncludeAcls(true)
                               ->setIncludeAllowableActions(false)
                               ->setIncludePolicies(true)
                               ->setIncludePathSegments(false)
                               ->setFilter(['foo', 'bar'])
                               ->setIncludeRelationships(IncludeRelationships::cast(IncludeRelationships::BOTH))
                               ->setRenditionFilter(['baz', 'foo']);

        $this->assertSame(
            '1010|foo,bar,cmis:objectId,cmis:baseTypeId,cmis:objectTypeId|both|baz,foo',
            $this->operationContext->getCacheKey()
        );
    }

    public function testSetCacheEnabledSetsProperty(): void
    {
        $this->assertAttributeSame(false, 'cacheEnabled', $this->operationContext);
        $returnValue = $this->operationContext->setCacheEnabled(true);
        $this->assertAttributeSame(true, 'cacheEnabled', $this->operationContext);
        $this->assertSame($this->operationContext, $returnValue);
    }

    public function testIsCacheEnabledReturnsValueOfProperty(): void
    {
        $this->assertAttributeSame($this->operationContext->isCacheEnabled(), 'cacheEnabled', $this->operationContext);
    }

    /**
     * @depends testSetFilterSetsProperty
     */
    public function testGetFilterReturnsValueOfProperty(): void
    {
        $this->operationContext->setFilter(['foo', 'bar']);
        $this->assertAttributeSame($this->operationContext->getFilter(), 'filter', $this->operationContext);
    }

    public function testIsIncludeAclsReturnsValueOfProperty(): void
    {
        $this->assertAttributeSame($this->operationContext->isIncludeAcls(), 'includeAcls', $this->operationContext);
    }

    public function testIsIncludeAllowableActionsReturnsValueOfProperty(): void
    {
        $this->assertAttributeSame(
            $this->operationContext->isIncludeAllowableActions(),
            'includeAllowableActions',
            $this->operationContext
        );
    }

    public function testIsIncludePathSegmentsReturnsValueOfProperty(): void
    {
        $this->assertAttributeSame(
            $this->operationContext->isIncludePathSegments(),
            'includePathSegments',
            $this->operationContext
        );
    }

    public function testIsIncludePoliciesReturnsValueOfProperty(): void
    {
        $this->assertAttributeSame(
            $this->operationContext->isIncludePolicies(),
            'includePolicies',
            $this->operationContext
        );
    }

    public function testGetIncludeRelationshipsReturnsValueOfProperty(): void
    {
        $this->assertAttributeSame(
            $this->operationContext->getIncludeRelationships(),
            'includeRelationships',
            $this->operationContext
        );
    }

    public function testGetMaxItemsPerPageReturnsValueOfProperty(): void
    {
        $this->assertAttributeSame(
            $this->operationContext->getMaxItemsPerPage(),
            'maxItemsPerPage',
            $this->operationContext
        );
    }

    public function testGetOrderByReturnsValueOfProperty(): void
    {
        $this->assertAttributeSame(
            $this->operationContext->getOrderBy(),
            'orderBy',
            $this->operationContext
        );
    }

    public function testGetRenditionFilterReturnsValueOfProperty(): void
    {
        $this->assertAttributeSame(
            $this->operationContext->getRenditionFilter(),
            'renditionFilter',
            $this->operationContext
        );
    }

    public function testGetFilterStringReturnsNullIfNoFilterIsSet(): void
    {
        $this->assertAttributeSame([], 'filter', $this->operationContext);
        $this->assertNull($this->operationContext->getQueryFilterString());
    }

    /**
     * @depends testSetFilterSetsProperty
     */
    public function testGetFilterStringReturnsStarIfFilterContainsAStar(): void
    {
        $this->operationContext->setFilter(['foo', OperationContext::PROPERTIES_WILDCARD]);
        $this->assertSame(OperationContext::PROPERTIES_WILDCARD, $this->operationContext->getQueryFilterString());
    }

    /**
     * @depends testSetFilterSetsProperty
     * @depends testSetLoadSecondaryTypePropertiesSetsProperty
     */
    public function testGetFilterStringAddsRequiredPropertiesAndReturnsValueOfPropertyAsString(): void
    {
        $this->operationContext->setFilter(['foo', 'bar']);
        $this->assertSame(
            'foo,bar,cmis:objectId,cmis:baseTypeId,cmis:objectTypeId',
            $this->operationContext->getQueryFilterString()
        );

        $this->operationContext->setLoadSecondaryTypeProperties(true);
        $this->assertSame(
            'foo,bar,cmis:objectId,cmis:baseTypeId,cmis:objectTypeId,cmis:secondaryObjectTypeIds',
            $this->operationContext->getQueryFilterString()
        );
    }

    public function testGetRenditionFilterStringReturnsNullIfNoFilterIsDefined(): void
    {
        $operationContext = new ReflectionClass(OperationContext::class);
        $renditionFilterProperty = $operationContext->getProperty('renditionFilter');
        $renditionFilterProperty->setAccessible(true);
        $renditionFilterProperty->setValue($this->operationContext, []);

        $this->assertNull($this->operationContext->getRenditionFilterString());
    }

    /**
     * @depends testSetRenditionFilterSetsProperty
     */
    public function testGetRenditionFilterStringReturnsCommaSeparatedStringOfRenditionFilters(): void
    {
        $this->operationContext->setRenditionFilter(['foo', 'bar']);
        $this->assertSame('foo,bar', $this->operationContext->getRenditionFilterString());
    }

    public function testLoadSecondaryTypePropertiesReturnsValueOfProperty(): void
    {
        $this->assertAttributeSame(
            $this->operationContext->loadSecondaryTypeProperties(),
            'loadSecondaryTypeProperties',
            $this->operationContext
        );
    }
}

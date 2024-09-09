<?php
namespace Dkd\PhpCmis;

/*
 * This file is part of php-cmis-client.
 *
 * (c) Sascha Egerer <sascha.egerer@dkd.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use InvalidArgumentException;
use Dkd\PhpCmis\Enum\IncludeRelationships;

/**
 * OperationContext implementation
 */
class OperationContext implements OperationContextInterface
{
    const PROPERTIES_WILDCARD = '*';

    /**
     * @var string[]
     */
    private array $filter = [];

    private bool $loadSecondaryTypeProperties = false;

    private bool $includeAcls = false;

    private bool $includeAllowableActions = true;

    private bool $includePolicies = false;

    /**
     * @var IncludeRelationships
     */
    private $includeRelationships;

    /**
     * @var string[]
     */
    private $renditionFilter = [];

    private bool $includePathSegments = true;

    /**
     * @var string
     */
    private $orderBy;

    private bool $cacheEnabled = false;

    private int $maxItemsPerPage = 100;

    /**
     * Creates new Operation Context
     */
    public function __construct()
    {
        $this->setRenditionFilter([]);
        $this->includeRelationships = IncludeRelationships::cast(IncludeRelationships::NONE);
    }

    /**
     * {@inheritdoc}
     */
    public function isCacheEnabled()
    {
        return $this->cacheEnabled;
    }

    /**
     * {@inheritdoc}
     */
    public function setCacheEnabled($cacheEnabled): static
    {
        $this->cacheEnabled = (boolean) $cacheEnabled;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheKey(): string
    {
        $cacheKey = $this->isIncludeAcls() ? '1' : '0';
        $cacheKey .= $this->isIncludeAllowableActions() ? '1' : '0';
        $cacheKey .= $this->isIncludePolicies() ? '1' : '0';
        $cacheKey .= $this->isIncludePathSegments() ? '1' : '0';
        $cacheKey .= '|';
        $cacheKey .= $this->getQueryFilterString();
        $cacheKey .= '|';
        $cacheKey .= (string) $this->getIncludeRelationships();
        $cacheKey .= '|';

        return $cacheKey . $this->getRenditionFilterString();
    }

    /**
     * {@inheritdoc}
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * {@inheritdoc}
     */
    public function setFilter(array $propertyFilters): static
    {
        $filters = [];
        foreach ($propertyFilters as $filter) {
            $filter = trim((string) $filter);
            if ($filter === '') {
                continue;
            }

            if (self::PROPERTIES_WILDCARD === $filter) {
                $filters[] = self::PROPERTIES_WILDCARD;
                break;
            }

            if (stripos($filter, ',') !== false) {
                throw new InvalidArgumentException('Filter must not contain a comma!');
            }

            $filters[] = $filter;
        }

        $this->filter = $filters;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isIncludeAcls()
    {
        return $this->includeAcls;
    }

    /**
     * {@inheritdoc}
     */
    public function setIncludeAcls($includeAcls): static
    {
        $this->includeAcls = $includeAcls;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isIncludeAllowableActions()
    {
        return $this->includeAllowableActions;
    }

    /**
     * {@inheritdoc}
     */
    public function setIncludeAllowableActions($includeAllowableActions): static
    {
        $this->includeAllowableActions = $includeAllowableActions;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isIncludePathSegments()
    {
        return $this->includePathSegments;
    }

    /**
     * {@inheritdoc}
     */
    public function setIncludePathSegments($includePathSegments): static
    {
        $this->includePathSegments = $includePathSegments;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isIncludePolicies()
    {
        return $this->includePolicies;
    }

    /**
     * {@inheritdoc}
     */
    public function setIncludePolicies($includePolicies): static
    {
        $this->includePolicies = $includePolicies;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIncludeRelationships()
    {
        return $this->includeRelationships;
    }

    /**
     * {@inheritdoc}
     */
    public function setIncludeRelationships(IncludeRelationships $includeRelationships): static
    {
        $this->includeRelationships = $includeRelationships;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function loadSecondaryTypeProperties()
    {
        return $this->loadSecondaryTypeProperties;
    }

    /**
     * {@inheritdoc}
     */
    public function setLoadSecondaryTypeProperties($loadSecondaryTypeProperties): static
    {
        $this->loadSecondaryTypeProperties = (boolean) $loadSecondaryTypeProperties;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMaxItemsPerPage()
    {
        return $this->maxItemsPerPage;
    }

    /**
     * {@inheritdoc}
     */
    public function setMaxItemsPerPage($maxItemsPerPage): static
    {
        if ((int) $maxItemsPerPage < 1) {
            throw new InvalidArgumentException('itemsPerPage must be > 0!');
        }
        $this->maxItemsPerPage = (int) $maxItemsPerPage;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * {@inheritdoc}
     */
    public function setOrderBy($orderBy): static
    {
        $this->orderBy = $orderBy;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRenditionFilter()
    {
        return $this->renditionFilter;
    }

    /**
     * {@inheritdoc}
     */
    public function setRenditionFilter(array $renditionFilter): static
    {
        $filters = [];
        foreach ($renditionFilter as $filter) {
            $filter = trim((string) $filter);
            if ($filter === '') {
                continue;
            }

            if (stripos($filter, ',') !== false) {
                throw new InvalidArgumentException('Rendition must not contain a comma!');
            }

            $filters[] = $filter;
        }

        if ($filters === []) {
            $filters[] = Constants::RENDITION_NONE;
        }

        $this->renditionFilter = $filters;

        return $this;
    }


    /**
     * {@inheritdoc}
     */
    public function getQueryFilterString(): ?string
    {
        if (count($this->filter) === 0) {
            return null;
        }

        if (array_search(self::PROPERTIES_WILDCARD, $this->filter)) {
            return self::PROPERTIES_WILDCARD;
        }

        $filters = $this->filter;
        $filters[] = PropertyIds::OBJECT_ID;
        $filters[] = PropertyIds::BASE_TYPE_ID;
        $filters[] = PropertyIds::OBJECT_TYPE_ID;

        if ($this->loadSecondaryTypeProperties()) {
            $filters[] = PropertyIds::SECONDARY_OBJECT_TYPE_IDS;
        }

        return implode(',', array_unique($filters));
    }

    /**
     * {@inheritdoc}
     */
    public function getRenditionFilterString(): ?string
    {
        if (count($this->renditionFilter) === 0) {
            return null;
        }

        return implode(',', $this->renditionFilter);
    }

    /**
     * {@inheritdoc}
     */
    public function setFilterString($propertyFilter): static
    {
        if (empty($propertyFilter)) {
            $this->setFilter([]);
        } else {
            $this->setFilter(explode(',', $propertyFilter));
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setRenditionFilterString($renditionFilter): static
    {
        if (empty($renditionFilter)) {
            $this->setRenditionFilter([]);
        } else {
            $this->setRenditionFilter(explode(',', $renditionFilter));
        }

        return $this;
    }
}

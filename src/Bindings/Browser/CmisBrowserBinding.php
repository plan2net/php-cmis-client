<?php
namespace Dkd\PhpCmis\Bindings\Browser;

/*
 * This file is part of php-cmis-client.
 *
 * (c) Sascha Egerer <sascha.egerer@dkd.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Dkd\PhpCmis\AclServiceInterface;
use Dkd\PhpCmis\Bindings\BindingSessionInterface;
use Dkd\PhpCmis\Bindings\CmisInterface;
use Dkd\PhpCmis\DiscoveryServiceInterface;
use Dkd\PhpCmis\MultiFilingServiceInterface;
use Dkd\PhpCmis\NavigationServiceInterface;
use Dkd\PhpCmis\ObjectServiceInterface;
use Dkd\PhpCmis\PolicyServiceInterface;
use Dkd\PhpCmis\RelationshipServiceInterface;
use Dkd\PhpCmis\RepositoryServiceInterface;
use Dkd\PhpCmis\VersioningServiceInterface;

/**
 * Base class for all Browser Binding client services.
 */
class CmisBrowserBinding implements CmisInterface
{
    protected RepositoryService $repositoryService;

    protected NavigationService $navigationService;

    protected ObjectService $objectService;

    protected VersioningService $versioningService;

    protected DiscoveryService $discoveryService;

    protected MultiFilingService $multiFilingService;

    protected RelationshipService $relationshipService;

    protected PolicyService $policyService;

    protected AclService $aclService;

    public function __construct(protected BindingSessionInterface $session)
    {
        $this->repositoryService = new RepositoryService($this->session);
        $this->navigationService = new NavigationService($this->session);
        $this->objectService = new ObjectService($this->session);
        $this->versioningService = new VersioningService($this->session);
        $this->discoveryService = new DiscoveryService($this->session);
        $this->multiFilingService = new MultiFilingService($this->session);
        $this->relationshipService = new RelationshipService($this->session);
        $this->policyService = new PolicyService($this->session);
        $this->aclService = new AclService($this->session);
    }

    /**
     * Gets a Repository Service interface object.
     *
     * @return RepositoryServiceInterface
     */
    public function getRepositoryService()
    {
        return $this->repositoryService;
    }

    /**
     * Gets a Navigation Service interface object.
     *
     * @return NavigationServiceInterface
     */
    public function getNavigationService()
    {
        return $this->navigationService;
    }

    /**
     * Gets an Object Service interface object.
     *
     * @return ObjectServiceInterface
     */
    public function getObjectService()
    {
        return $this->objectService;
    }

    /**
     * Gets a Versioning Service interface object.
     *
     * @return VersioningServiceInterface
     */
    public function getVersioningService()
    {
        return $this->versioningService;
    }

    /**
     * Gets a Relationship Service interface object.
     *
     * @return RelationshipServiceInterface
     */
    public function getRelationshipService()
    {
        return $this->relationshipService;
    }

    /**
     * Gets a Discovery Service interface object.
     *
     * @return DiscoveryServiceInterface
     */
    public function getDiscoveryService()
    {
        return $this->discoveryService;
    }

    /**
     * Gets a Multifiling Service interface object.
     *
     * @return MultiFilingServiceInterface
     */
    public function getMultiFilingService()
    {
        return $this->multiFilingService;
    }

    /**
     * Gets an ACL Service interface object.
     *
     * @return AclServiceInterface
     */
    public function getAclService()
    {
        return $this->aclService;
    }

    /**
     * Gets a Policy Service interface object.
     *
     * @return PolicyServiceInterface
     */
    public function getPolicyService()
    {
        return $this->policyService;
    }

    /**
     * Clears all caches of the current session.
     */
    public function clearAllCaches(): void
    {
        // TODO: Implement clearAllCaches() method.
    }

    /**
     * Clears all caches of the current session that are related to the given
     * repository.
     *
     * @param string $repositoryId the repository id
     */
    public function clearRepositoryCache($repositoryId): void
    {
        // TODO: Implement clearRepositoryCache() method.
    }

    /**
     * Releases all resources assigned to this instance.
     */
    public function close(): void
    {
        // TODO: Implement close() method.
    }
}

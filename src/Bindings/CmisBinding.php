<?php
namespace Dkd\PhpCmis\Bindings;

/*
 * This file is part of php-cmis-client.
 *
 * (c) Sascha Egerer <sascha.egerer@dkd.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use Exception;
use Dkd\Enumeration\Exception\InvalidEnumerationValueException;
use Dkd\PhpCmis\AclServiceInterface;
use Dkd\PhpCmis\Bindings\Browser\RepositoryService;
use Dkd\PhpCmis\Data\BindingsObjectFactoryInterface;
use Dkd\PhpCmis\DataObjects\BindingsObjectFactory;
use Dkd\PhpCmis\DiscoveryServiceInterface;
use Dkd\PhpCmis\Enum\BindingType;
use Dkd\PhpCmis\Exception\CmisInvalidArgumentException;
use Dkd\PhpCmis\Exception\CmisRuntimeException;
use Dkd\PhpCmis\MultiFilingServiceInterface;
use Dkd\PhpCmis\NavigationServiceInterface;
use Dkd\PhpCmis\ObjectServiceInterface;
use Dkd\PhpCmis\PolicyServiceInterface;
use Dkd\PhpCmis\RelationshipServiceInterface;
use Dkd\PhpCmis\RepositoryServiceInterface;
use Dkd\PhpCmis\SessionParameter;
use Dkd\PhpCmis\VersioningServiceInterface;
use Doctrine\Common\Cache\Cache;

/**
 * Class CmisBinding
 */
class CmisBinding implements CmisBindingInterface
{
    protected RepositoryService $repositoryService;

    protected BindingsObjectFactoryInterface $objectFactory;

    /**
     * @param Cache|null $typeDefinitionCache
     * @param BindingsObjectFactoryInterface|null $objectFactory
     */
    public function __construct(
        protected BindingSessionInterface $session,
        array $sessionParameters,
        Cache $typeDefinitionCache = null,
        BindingsObjectFactoryInterface $objectFactory = null
    ) {
        if ($sessionParameters === []) {
            throw new CmisRuntimeException('Session parameters must be set!');
        }

        if (!isset($sessionParameters[SessionParameter::BINDING_CLASS])) {
            throw new CmisInvalidArgumentException('Session parameters do not contain a binding class name!');
        }

        foreach ($sessionParameters as $key => $value) {
            $this->session->put($key, $value);
        }

        // if ($typeDefinitionCache !== null) {
        //     @TODO add cache
        // }

        $this->objectFactory = $objectFactory ?? new BindingsObjectFactory();
        $this->repositoryService = new RepositoryService($this->session);
    }

    /**
     * Clears all caches of the current CMIS binding session.
     */
    public function clearAllCaches(): never
    {
        throw new Exception('Not yet implemented!');
        // TODO: Implement clearAllCaches() method.
    }

    /**
     * Clears all caches of the current CMIS binding session that are related to the given repository.
     *
     * @param string $repositoryId
     */
    public function clearRepositoryCache($repositoryId): never
    {
        throw new Exception('Not yet implemented!');
        // TODO: Implement clearRepositoryCache() method.
    }

    /**
     * Releases all resources assigned to this binding instance.
     */
    public function close(): void
    {
        $this->getCmisBindingsHelper()->getSpi($this->session)->close();
    }

    /**
     * Gets an ACL Service interface object.
     *
     * @return AclServiceInterface
     */
    public function getAclService()
    {
        return $this->getCmisBindingsHelper()->getSpi($this->session)->getAclService();
    }

    /**
     * Returns the binding type.
     *
     * @return BindingType
     */
    public function getBindingType()
    {
        $bindingType = $this->session->get(SessionParameter::BINDING_TYPE);

        if (!is_string($bindingType)) {
            return BindingType::cast(BindingType::CUSTOM);
        }

        try {
            return BindingType::cast($bindingType);
        } catch (InvalidEnumerationValueException) {
            return BindingType::cast(BindingType::CUSTOM);
        }
    }

    /**
     * Gets a Discovery Service interface object.
     *
     * @return DiscoveryServiceInterface
     */
    public function getDiscoveryService()
    {
        return $this->getCmisBindingsHelper()->getSpi($this->session)->getDiscoveryService();
    }

    /**
     * Gets a Multifiling Service interface object.
     *
     * @return MultiFilingServiceInterface
     */
    public function getMultiFilingService()
    {
        return $this->getCmisBindingsHelper()->getSpi($this->session)->getMultiFilingService();
    }

    /**
     * Gets a Navigation Service interface object.
     *
     * @return NavigationServiceInterface
     */
    public function getNavigationService()
    {
        return $this->getCmisBindingsHelper()->getSpi($this->session)->getNavigationService();
    }

    /**
     * Gets a factory for CMIS binding specific objects.
     *
     * @return BindingsObjectFactoryInterface
     */
    public function getObjectFactory()
    {
        return $this->objectFactory;
    }

    /**
     * Gets an Object Service interface object.
     *
     * @return ObjectServiceInterface
     */
    public function getObjectService()
    {
        return $this->getCmisBindingsHelper()->getSpi($this->session)->getObjectService();
    }

    /**
     * Gets a Policy Service interface object.
     *
     * @return PolicyServiceInterface
     */
    public function getPolicyService()
    {
        return $this->getCmisBindingsHelper()->getSpi($this->session)->getPolicyService();
    }

    /**
     * Gets a Relationship Service interface object.
     *
     * @return RelationshipServiceInterface
     */
    public function getRelationshipService()
    {
        return $this->getCmisBindingsHelper()->getSpi($this->session)->getRelationshipService();
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
     * Returns the client session id.
     *
     * @return string
     */
    public function getSessionId()
    {
        return $this->session->getSessionId();
    }

    /**
     * Gets a Versioning Service interface object.
     *
     * @return VersioningServiceInterface
     */
    public function getVersioningService()
    {
        return $this->getCmisBindingsHelper()->getSpi($this->session)->getVersioningService();
    }

    public function getCmisBindingsHelper(): CmisBindingsHelper
    {
        return new CmisBindingsHelper();
    }
}

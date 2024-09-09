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

use Dkd\PhpCmis\Bindings\Browser\CmisBrowserBinding;
use Dkd\PhpCmis\Common\Cache\ArrayCache;
use Dkd\PhpCmis\Converter\JsonConverter;
use Dkd\PhpCmis\Exception\CmisInvalidArgumentException;
use Dkd\PhpCmis\SessionParameter;
use Doctrine\Common\Cache\Cache;
use GuzzleHttp\Client;

/**
 * Default factory for a CMIS binding instance.
 */
class CmisBindingFactory
{
    /**
     * Create a browser binding
     *
     * @param Cache|null $typeDefinitionCache
     */
    public function createCmisBrowserBinding(array $sessionParameters, Cache $typeDefinitionCache = null): CmisBinding
    {
        $this->validateCmisBrowserBindingParameters($sessionParameters);

        return new CmisBinding(new Session(), $sessionParameters, $typeDefinitionCache);
    }

    protected function validateCmisBrowserBindingParameters(array &$sessionParameters)
    {
        $sessionParameters[SessionParameter::BINDING_CLASS] ??= CmisBrowserBinding::class;
        $sessionParameters[SessionParameter::BROWSER_SUCCINCT] ??= true;
        $this->addDefaultSessionParameters($sessionParameters);
        $this->check($sessionParameters, SessionParameter::BROWSER_URL);
    }

    /**
     * Sets some parameters to a default value if they are not already set
     */
    protected function addDefaultSessionParameters(array &$sessionParameters)
    {
        $sessionParameters[SessionParameter::CACHE_SIZE_REPOSITORIES] ??= 10;
        $sessionParameters[SessionParameter::CACHE_SIZE_TYPES] ??= 100;
        $sessionParameters[SessionParameter::CACHE_SIZE_LINKS] ??= 400;
        $sessionParameters[SessionParameter::HTTP_INVOKER_CLASS] ??= Client::class;
        $sessionParameters[SessionParameter::JSON_CONVERTER_CLASS] ??= JsonConverter::class;
        $sessionParameters[SessionParameter::TYPE_DEFINITION_CACHE_CLASS] ??= ArrayCache::class;
    }

    /**
     * Checks if the given parameter is present. If not, throw an
     * <code>IllegalArgumentException</code>.
     *
     * @param string $parameter
     * @throws CmisInvalidArgumentException
     */
    protected function check(array $sessionParameters, $parameter): bool
    {
        if (empty($sessionParameters[$parameter])) {
            throw new CmisInvalidArgumentException(sprintf('Parameter "%s" is missing!', $parameter));
        }

        return true;
    }
}

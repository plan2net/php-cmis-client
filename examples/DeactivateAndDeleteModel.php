<?php
use GuzzleHttp\Client;
use Dkd\PhpCmis\SessionParameter;
use Dkd\PhpCmis\Enum\BindingType;
use Dkd\PhpCmis\SessionFactory;
use Dkd\PhpCmis\Exception\CmisContentAlreadyExistsException;

require_once(__DIR__ . '/../vendor/autoload.php');
if (!is_file(__DIR__ . '/conf/Configuration.php')) {
    die("Please add your connection credentials to the file \"" . __DIR__ . "/conf/Configuration.php\".\n");
}
require_once(__DIR__ . '/conf/Configuration.php');

$httpInvoker = new Client(
    [
        'defaults' => [
            'auth' => [
                CMIS_BROWSER_USER,
                CMIS_BROWSER_PASSWORD
            ]
        ]
    ]
);

$parameters = [
    SessionParameter::BINDING_TYPE => BindingType::BROWSER,
    SessionParameter::BROWSER_URL => CMIS_BROWSER_URL,
    SessionParameter::BROWSER_SUCCINCT => false,
    SessionParameter::HTTP_INVOKER_OBJECT => $httpInvoker,
];

$sessionFactory = new SessionFactory();

// If no repository id is defined use the first repository
if (CMIS_REPOSITORY_ID === null) {
    $repositories = $sessionFactory->getRepositories($parameters);
    $parameters[SessionParameter::REPOSITORY_ID] = $repositories[0]->getId();
} else {
    $parameters[SessionParameter::REPOSITORY_ID] = CMIS_REPOSITORY_ID;
}

$session = $sessionFactory->createSession($parameters);

echo "Deactivating and removing model 'examples/resources/custommodel.xml' from repository\n\n";

try {
    $document = $session->getObjectByPath('/Data Dictionary/Models/custommodel.xml');
    $updated = $session->getObject($document)->updateProperties([
        'cm:modelActive' => false
    ]);
    if (!$updated->getPropertyValue('cm:modelActive')) {
        echo "Model '" . $document->getId() . "' was deactivated.\n";
    } else {
        echo "Model '" . $document->getId() . "' failed to deactivate!\n";
    }
    $document->delete(true);
    echo "Model '" . $document->getId() . "' was deleted.\n";
} catch (CmisContentAlreadyExistsException $e) {
    echo "********* ERROR **********\n";
    echo $e->getMessage() . "\n";
    echo "**************************\n";
    exit();
}

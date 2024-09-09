<?php
use GuzzleHttp\Client;
use Dkd\PhpCmis\SessionParameter;
use Dkd\PhpCmis\Enum\BindingType;
use Dkd\PhpCmis\SessionFactory;
use Dkd\PhpCmis\PropertyIds;
use Dkd\PhpCmis\Exception\CmisContentAlreadyExistsException;

require_once(__DIR__ . '/../vendor/autoload.php');
if (!is_file(__DIR__ . '/conf/Configuration.php')) {
    die("Please add your connection credentials to the file \"" . __DIR__ . "/conf/Configuration.php\".\n");
}
require_once(__DIR__ . '/conf/Configuration.php');

$httpInvoker = new Client(
    [
        'auth' =>
            [
                CMIS_BROWSER_USER,
                CMIS_BROWSER_PASSWORD
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

echo "Create CMIS Folder\n\n";

$properties = [
    PropertyIds::OBJECT_TYPE_ID => 'cmis:folder',
    PropertyIds::NAME => 'Demo Folder'
];

try {
    $folder = $session->createFolder(
        $properties,
        $session->createObjectId($session->getRepositoryInfo()->getRootFolderId())
    );

    echo "Folder has been created. Folder Id: " . $folder->getId() . "\n";
    echo "Please delete that folder now by hand!\n";
} catch (CmisContentAlreadyExistsException $e) {
    echo "********* ERROR **********\n";
    echo $e->getMessage() . "\n";
    echo "**************************\n";
    echo "Try to get folder by path!\n";
    $folder = $session->getObjectByPath($properties[PropertyIds::NAME]);
}

<?php
use GuzzleHttp\Client;
use Dkd\PhpCmis\SessionParameter;
use Dkd\PhpCmis\Enum\BindingType;
use Dkd\PhpCmis\SessionFactory;
use Dkd\PhpCmis\OperationContext;
use Dkd\PhpCmis\DataObjects\ObjectId;
use Dkd\PhpCmis\Enum\PropertyType;

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

$operationContext = new OperationContext();
$rootFolderID = $session->getRepositoryInfo()->getRootFolderId();

echo "Root folder ID: $rootFolderID\n\n";
echo "Repository Information (Object Properties):\n-------------";
$repositoryData = $session->getObject(
    new ObjectId($session->getRepositoryInfo()->getRootFolderId()),
    $operationContext
);

foreach ($repositoryData->getProperties() as $property) {
    $value = $property->getDefinition()->getPropertyType()->equals(PropertyType::DATETIME) ?
        $property->getFirstValue()->format("Y-m-d H:i:s") : (string) $property->getFirstValue();
    echo "\n" . $property->getDisplayName() . ': ' . $value;
}
echo "\n-----------\n";

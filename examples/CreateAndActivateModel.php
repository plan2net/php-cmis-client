<?php
use GuzzleHttp\Client;
use Dkd\PhpCmis\SessionParameter;
use Dkd\PhpCmis\Enum\BindingType;
use Dkd\PhpCmis\SessionFactory;
use Dkd\PhpCmis\PropertyIds;
use GuzzleHttp\Stream\Stream;
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

echo "Add and activate model 'examples/resources/custommodel.xml' as CMIS model\n\n";

$properties = [
    PropertyIds::OBJECT_TYPE_ID => 'D:cm:dictionaryModel',
    PropertyIds::SECONDARY_OBJECT_TYPE_IDS => [
        'P:cm:titled'
    ],
    PropertyIds::NAME => 'custommodel.xml',
    'cm:description' => 'Testing model',
    'cm:title' => 'Testing model 2'
];

try {
    $document = $session->createDocument(
        $properties,
        $session->getObjectByPath('/Data Dictionary/Models'),
        Stream::factory(fopen(__DIR__ . '/resource/custommodel.xml', 'r'))
    );

    echo "Model has been created in '/Data Dictionary/Models/'. Model Id: " . $document->getId() . "\n";
    $updated = $session->getObject($document)->updateProperties([
        'cm:modelActive' => true
    ]);
    if ($session->getObject($document)->getPropertyValue('cm:modelActive')) {
        echo "Model '" . $document->getId() . "' was activated.\n";
    } else {
        echo "Model '" . $document->getId() . "' failed to activate!\n";
    }
    echo "To remove the model, delete it manually or run the DeactivateAndDeleteModel.php example.\n";
} catch (CmisContentAlreadyExistsException $e) {
    echo "********* ERROR **********\n";
    echo $e->getMessage() . "\n";
    echo "**************************\n";
    exit();
}

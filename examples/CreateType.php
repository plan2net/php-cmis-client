<?php
use GuzzleHttp\Client;
use Dkd\PhpCmis\SessionParameter;
use Dkd\PhpCmis\Enum\BindingType;
use Dkd\PhpCmis\SessionFactory;
use Dkd\PhpCmis\DataObjects\TypeMutability;
use Dkd\PhpCmis\Enum\BaseTypeId;
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

echo "Create CMIS type\n\n";


try {
    $typeMutability = new TypeMutability();
    $typeMutability->setCanCreate(true);
    $typeMutability->setCanUpdate(true);
    $typeMutability->setCanDelete(true);
    $typeDefinition = $session->getObjectFactory()->createTypeDefinition(
        'typo3:page',
        'page',
        (string) BaseTypeId::cast(BaseTypeId::CMIS_DOCUMENT),
        (string) BaseTypeId::cast(BaseTypeId::CMIS_DOCUMENT),
        true,
        true,
        true,
        true,
        true,
        true,
        true,
        '',
        '',
        'TYPO3 Page',
        'TYPO3 Page object',
        $typeMutability
    );

    $session->createType($typeDefinition);

    echo "Type definition has been created. Id: " . $typeDefinition->getId() . "\n";
    echo "Please delete that definition now by hand!\n";
} catch (CmisContentAlreadyExistsException $e) {
    echo "********* ERROR **********\n";
    echo $e->getMessage() . "\n";
    echo "**************************\n";
    exit();
}

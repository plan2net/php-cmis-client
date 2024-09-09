<?php
use GuzzleHttp\Client;
use Dkd\PhpCmis\SessionParameter;
use Dkd\PhpCmis\Enum\BindingType;
use Dkd\PhpCmis\SessionFactory;

require_once(__DIR__ . '/../vendor/autoload.php');
if (!is_file(__DIR__ . '/conf/Configuration.php')) {
    die("Please add your connection credentials to the file \"" . __DIR__ . "/conf/Configuration.php\".\n");
}
require_once(__DIR__ . '/conf/Configuration.php');

$httpInvoker = new Client(
    [
        'auth' => [
            CMIS_BROWSER_USER,
            CMIS_BROWSER_PASSWORD
        ]
    ]
);

$parameters = [
    SessionParameter::BINDING_TYPE => BindingType::BROWSER,
    SessionParameter::BROWSER_URL => CMIS_BROWSER_URL,
    SessionParameter::BROWSER_SUCCINCT => false,
    SessionParameter::HTTP_INVOKER_OBJECT => $httpInvoker
];

$sessionFactory = new SessionFactory();

echo "REPOSITORIES: \n";
foreach ($sessionFactory->getRepositories($parameters) as $repository) {
    echo sprintf("---\nName: %s\nID:   %s \n---\n", $repository->getName(), $repository->getId());
}
echo "\n";

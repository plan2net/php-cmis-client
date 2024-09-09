<?php
use GuzzleHttp\Client;
use Dkd\PhpCmis\SessionParameter;
use Dkd\PhpCmis\Enum\BindingType;
use Dkd\PhpCmis\SessionFactory;
use Dkd\PhpCmis\Data\FolderInterface;
use Dkd\PhpCmis\Data\DocumentInterface;

/**
 * This example will list the children of the CMIS root folder.
 * The list is created recursively but is limited to 5 items per level.
 */

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

// Get the root folder of the repository
$rootFolder = $session->getRootFolder();

echo '+ [ROOT FOLDER]: ' . $rootFolder->getName() . "\n";

printFolderContent($rootFolder);

function printFolderContent(FolderInterface $folder, string $levelIndention = '  '): void
{
    $i = 0;
    foreach ($folder->getChildren() as $children) {
        echo $levelIndention;
        $i++;
        if ($i > 10) {
            echo "| ...\n";
            break;
        }

        if ($children instanceof FolderInterface) {
            echo '+ [FOLDER]: ' . $children->getName() . "\n";
            printFolderContent($children, $levelIndention . '  ');
        } elseif ($children instanceof DocumentInterface) {
            echo '- [DOCUMENT]: ' . $children->getName() . "\n";
        } else {
            echo '- [ITEM]: ' . $children->getName() . "\n";
        }
    }
}

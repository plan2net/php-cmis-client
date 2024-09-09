<?php

use Dkd\PhpCmis\PropertyIds;
use Dkd\PhpCmis\DataObjects\Document;

require_once(__DIR__ . '/CreateDocument.php');

if ($document !== null) {
    echo "Create a second document...\n";

    /** @var Document $documentObject */
    $documentObject = $session->getObject($document);

    $secondDocument = $session->createDocumentFromSource(
        $documentObject,
        [PropertyIds::NAME => 'Demo Object 2'],
        $documentObject->getParents()[0]
    );

    echo "Second document created! Id: " . $secondDocument->getId() . "\n";

    echo "Create relationship for " . $document->getId() . " -> " . $secondDocument->getId() . "\n";

    $properties = [
        PropertyIds::SOURCE_ID => $document->getId(),
        PropertyIds::TARGET_ID => $secondDocument->getId(),
        PropertyIds::OBJECT_TYPE_ID => 'R:cm:basis'
    ];

    $relationshipId = $session->createRelationship($properties);

    echo "Relationship has been created with id " . $relationshipId->getId() . " \n";

    echo "Please delete now everything hand!\n";
} else {
    exit("Document has not been created and therefore could not create the relation!\n");
}

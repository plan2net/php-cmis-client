<?php

use Dkd\PhpCmis\DataObjects\PropertyIdDefinition;
use Dkd\PhpCmis\Enum\PropertyType;
use Dkd\PhpCmis\Enum\Updatability;
use Dkd\PhpCmis\Enum\Cardinality;
use Dkd\PhpCmis\DataObjects\PropertyStringDefinition;
use Dkd\PhpCmis\DataObjects\PropertyBooleanDefinition;
use Dkd\PhpCmis\DataObjects\PropertyUriDefinition;
use Dkd\PhpCmis\DataObjects\PropertyDecimalDefinition;
use Dkd\PhpCmis\Enum\DecimalPrecision;
use Dkd\PhpCmis\DataObjects\PropertyHtmlDefinition;
use Dkd\PhpCmis\DataObjects\PropertyIntegerDefinition;
use Dkd\PhpCmis\DataObjects\PropertyDateTimeDefinition;
use Dkd\PhpCmis\Enum\DateTimeResolution;

$id = new PropertyIdDefinition('cmis:id');
$id->setPropertyType(PropertyType::cast(PropertyType::ID));
$id->setLocalName('cmis:idValue');
$id->setQueryName('cmis:idValue');
$id->setIsInherited(false);
$id->setIsOpenChoice(false);
$id->setIsOrderable(true);
$id->setDescription('This is a id property.');
$id->setUpdatability(Updatability::cast(Updatability::READONLY));
$id->setLocalNamespace('local');
$id->setDisplayName('Id property');
$id->setIsRequired(true);
$id->setCardinality(Cardinality::cast(Cardinality::SINGLE));
$id->setIsQueryable(true);

$string = new PropertyStringDefinition('cmis:string');
$string->setPropertyType(PropertyType::cast(PropertyType::STRING));
$string->setLocalName('cmis:stringValue');
$string->setQueryName('cmis:stringValue');
$string->setIsInherited(true);
$string->setIsOpenChoice(true);
$string->setIsOrderable(false);
$string->setDescription('This is a string property.');
$string->setUpdatability(Updatability::cast(Updatability::READWRITE));
$string->setLocalNamespace('namespace');
$string->setDisplayName('String property');
$string->setIsRequired(false);
$string->setCardinality(Cardinality::cast(Cardinality::MULTI));
$string->setIsQueryable(false);
$string->setMaxLength(100);

$boolean = new PropertyBooleanDefinition('cmis:boolean');
$boolean->setPropertyType(PropertyType::cast(PropertyType::BOOLEAN));
$boolean->setLocalName('cmis:booleanValue');
$boolean->setQueryName('cmis:booleanValue');
$boolean->setIsInherited(true);
$boolean->setIsOpenChoice(true);
$boolean->setIsOrderable(false);
$boolean->setDescription('This is a boolean property.');
$boolean->setUpdatability(Updatability::cast(Updatability::READWRITE));
$boolean->setLocalNamespace('namespace');
$boolean->setDisplayName('Boolean property');
$boolean->setIsRequired(false);
$boolean->setCardinality(Cardinality::cast(Cardinality::MULTI));
$boolean->setIsQueryable(true);

$uri = new PropertyUriDefinition('cmis:uri');
$uri->setPropertyType(PropertyType::cast(PropertyType::URI));
$uri->setLocalName('cmis:uriValue');
$uri->setQueryName('cmis:uriValue');
$uri->setIsInherited(true);
$uri->setIsOpenChoice(true);
$uri->setIsOrderable(false);
$uri->setDescription('This is a uri property.');
$uri->setUpdatability(Updatability::cast(Updatability::READWRITE));
$uri->setLocalNamespace('namespace');
$uri->setDisplayName('Uri property');
$uri->setIsRequired(false);
$uri->setCardinality(Cardinality::cast(Cardinality::MULTI));
$uri->setIsQueryable(true);

$decimal = new PropertyDecimalDefinition('cmis:decimal');
$decimal->setPropertyType(PropertyType::cast(PropertyType::DECIMAL));
$decimal->setLocalName('cmis:decimalValue');
$decimal->setQueryName('cmis:decimalValue');
$decimal->setIsInherited(true);
$decimal->setIsOpenChoice(true);
$decimal->setIsOrderable(false);
$decimal->setDescription('This is a decimal property.');
$decimal->setUpdatability(Updatability::cast(Updatability::READWRITE));
$decimal->setLocalNamespace('namespace');
$decimal->setDisplayName('Decimal property');
$decimal->setIsRequired(false);
$decimal->setCardinality(Cardinality::cast(Cardinality::MULTI));
$decimal->setIsQueryable(true);
$decimal->setMinValue(5);
$decimal->setMaxValue(15);
$decimal->setPrecision(DecimalPrecision::cast(DecimalPrecision::BITS64));

$html = new PropertyHtmlDefinition('cmis:html');
$html->setPropertyType(PropertyType::cast(PropertyType::HTML));
$html->setLocalName('cmis:htmlValue');
$html->setQueryName('cmis:htmlValue');
$html->setIsInherited(true);
$html->setIsOpenChoice(true);
$html->setIsOrderable(false);
$html->setDescription('This is a html property.');
$html->setUpdatability(Updatability::cast(Updatability::READWRITE));
$html->setLocalNamespace('namespace');
$html->setDisplayName('Html property');
$html->setIsRequired(false);
$html->setCardinality(Cardinality::cast(Cardinality::MULTI));
$html->setIsQueryable(true);

$integer = new PropertyIntegerDefinition('cmis:integer');
$integer->setPropertyType(PropertyType::cast(PropertyType::INTEGER));
$integer->setLocalName('cmis:integerValue');
$integer->setQueryName('cmis:integerValue');
$integer->setIsInherited(true);
$integer->setIsOpenChoice(true);
$integer->setIsOrderable(false);
$integer->setDescription('This is a integer property.');
$integer->setUpdatability(Updatability::cast(Updatability::READWRITE));
$integer->setLocalNamespace('namespace');
$integer->setDisplayName('Integer property');
$integer->setIsRequired(false);
$integer->setCardinality(Cardinality::cast(Cardinality::MULTI));
$integer->setIsQueryable(true);
$integer->setMinValue(5);
$integer->setMaxValue(100);

$datetime = new PropertyDateTimeDefinition('cmis:datetime');
$datetime->setPropertyType(PropertyType::cast(PropertyType::DATETIME));
$datetime->setLocalName('cmis:datetimeValue');
$datetime->setQueryName('cmis:datetimeValue');
$datetime->setIsInherited(true);
$datetime->setIsOpenChoice(true);
$datetime->setIsOrderable(false);
$datetime->setDescription('This is a datetime property.');
$datetime->setUpdatability(Updatability::cast(Updatability::READWRITE));
$datetime->setLocalNamespace('namespace');
$datetime->setDisplayName('Datetime property');
$datetime->setIsRequired(false);
$datetime->setCardinality(Cardinality::cast(Cardinality::MULTI));
$datetime->setIsQueryable(true);
$datetime->setDateTimeResolution(
    DateTimeResolution::cast(DateTimeResolution::TIME)
);

return [
    'cmis:id' => $id,
    'cmis:string' => $string,
    'cmis:boolean' => $boolean,
    'cmis:uri' => $uri,
    'cmis:decimal' => $decimal,
    'cmis:html' => $html,
    'cmis:integer' => $integer,
    'cmis:datetime' => $datetime
];

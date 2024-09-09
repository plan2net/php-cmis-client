<?php
namespace Dkd\PhpCmis\Converter;

/*
 * This file is part of php-cmis-client.
 *
 * (c) Sascha Egerer <sascha.egerer@dkd.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use DateTime;
use Exception;
use Dkd\PhpCmis\Exception\CmisRuntimeException;
use function array_filter;
use function array_map;

/**
 * An Abstract data converter that contains some basic converter methods
 */
abstract class AbstractDataConverter implements DataConverterInterface
{
    /**
     * Cast all array values to string
     *
     * @return array
     */
    protected function convertStringValues(array $source)
    {
        return array_map('strval', $source);
    }

    /**
     * Cast all array values to boolean
     *
     * @return array
     */
    protected function convertBooleanValues(array $source)
    {
        return array_map('boolval', $source);
    }

    /**
     * Cast all array values to integer
     *
     * @return array
     */
    protected function convertIntegerValues(array $source)
    {
        return array_map('intval', $source);
    }

    /**
     * Cast all array values to float
     *
     * @return array
     */
    protected function convertDecimalValues(array $source)
    {
        return array_map('floatval', $source);
    }

    /**
     * @param array $source
     * @return array
     */
    protected function convertDateTimeValues($source)
    {
        return array_map(
            [$this, 'convertDateTimeValue'],
            array_filter(
                (array) $source,
                fn($item): bool => !empty($item)
            )
        );
    }

    /**
     * @return DateTime
     */
    protected function convertDateTimeValue(mixed $source)
    {
        if (is_int($source)) {
            $date = new DateTime();
            // DateTimes are given in a Timestamp with milliseconds.
            // see http://docs.oasis-open.org/cmis/CMIS/v1.1/os/CMIS-v1.1-os.html#x1-5420004
            $date->setTimestamp($source / 1000);
        } elseif (PHP_INT_SIZE == 4 && is_float($source)) {
            //TODO: 32-bit - handle this specially?
            $date = new DateTime();
            $date->setTimestamp($source / 1000);
        } elseif (is_string($source)) {
            try {
                $date = new DateTime($source);
            } catch (Exception $exception) {
                throw new CmisRuntimeException('Invalid property value: ' . $source, 1416296900, $exception);
            }
        } else {
            throw new CmisRuntimeException(
                'Invalid property value: ' . (is_scalar($source) ? $source : gettype($source)),
                1416296901
            );
        }

        return $date;
    }
}

<?php
namespace Dkd\PhpCmis\Test\Unit;

use Closure;
use stdClass;

/*
 * This file is part of php-cmis-lib.
 *
 * (c) Sascha Egerer <sascha.egerer@dkd.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
/**
 * Class DataProviderCollectionTrait
 */
trait DataProviderCollectionTrait
{
    /**
     * Data Provider that provides an expected boolean representation and a value
     */
    public function booleanCastDataProvider(): array
    {
        return [
            [true, true],
            [true, 1],
            [true, '1'],
            [true, 'string'],
            [false, false],
            [false, 0],
            [false, '0'],
            [false, null]
        ];
    }

    /**
     * Data Provider that provides an expected integer representation and a value
     */
    public function integerCastDataProvider(): array
    {
        return [
            [0, ''],
            [2, '2'],
            [0, null],
            [3, 3],
            [3, 3.2]
        ];
    }

    /**
     * Data Provider that provides an expected string representation and a value
     */
    public function stringCastDataProvider(): array
    {
        return [
            ['', ''],
            ['foo', 'foo'],
            ['', null],
            ['3', 3],
            ['3.2', 3.2],
            ['1', true],
            ['', false]
        ];
    }

    /**
     * Data provider that provides a value for all PHP types expect resource
     */
    public function allTypesDataProvider(Closure $filter = null): array
    {
        $values = [
            'string' => ['String'],
            'integer' => [1],
            'float' => [1.1],
            'boolean' => [true],
            'object' => [new stdClass()],
            'array' => [[]],
            'null' => [null],
            'callable' => [
                fn(): true => true
            ]
        ];

        if ($filter instanceof Closure) {
            return array_filter($values, $filter);
        }

        return $values;
    }

    /**
     * Data provider that provides a value for all PHP types expect resource and integer
     *
     * @return array
     */
    public function nonIntegerDataProvider()
    {
        return $this->allTypesDataProvider(
            fn($value): bool => !is_int(reset($value))
        );
    }

    /**
     * Data provider that provides a value for all PHP types expect resource and string
     *
     * @return array
     */
    public function nonStringDataProvider()
    {
        return $this->allTypesDataProvider(
            fn($value): bool => !is_string(reset($value))
        );
    }

    /**
     * Data provider that provides a value for all PHP types expect resource and boolean
     *
     * @return array
     */
    public function nonBooleanDataProvider()
    {
        return $this->allTypesDataProvider(
            fn($value): bool => !is_bool(reset($value))
        );
    }

    /**
     * Data provider that provides a value for all PHP types expect resource and array
     *
     * @return array
     */
    public function nonArrayDataProvider()
    {
        return $this->allTypesDataProvider(
            fn($value): bool => !is_array(reset($value))
        );
    }

    /**
     * Data provider that provides a value for all PHP types expect resource and float
     *
     * @return array
     */
    public function nonFloatDataProvider()
    {
        return $this->allTypesDataProvider(
            fn($value): bool => !is_float(reset($value))
        );
    }

    /**
     * Data provider that provides a value for all PHP types expect resource and object
     *
     * @return array
     */
    public function nonObjectDataProvider()
    {
        return $this->allTypesDataProvider(
            fn($value): bool => !is_object(reset($value))
        );
    }

    /**
     * Data provider that provides a value for all PHP types expect resource and callable
     *
     * @return array
     */
    public function nonCallableDataProvider()
    {
        return $this->allTypesDataProvider(
            fn($value): bool => !is_callable(reset($value))
        );
    }
}

<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use InvalidArgumentException;

class Misc
{
    /**
     * Recursively converts all keys of a given array to "headline" format.
     *
     * This function accepts an array or any data type, and applies Laravel's
     * Str::headline() helper to transform the keys of an array into a "headline"
     * format, which capitalizes each word in a key and adds spaces where
     * underscores or camel case are found. The transformation is applied
     * recursively to nested arrays.
     *
     * Example:
     * Input:
     *   [
     *     'first_name' => 'John',
     *     'user_data' => [
     *         'last_name' => 'Doe',
     *         'contact_info' => [
     *             'phone_number' => '1234567890'
     *         ]
     *     ]
     *   ]
     *
     * Output:
     *   [
     *     'First Name' => 'John',
     *     'User Data' => [
     *         'Last Name' => 'Doe',
     *         'Contact Info' => [
     *             'Phone Number' => '1234567890'
     *         ]
     *     ]
     *   ]
     *
     * @param  array  $data  The data to be processed. If the data is an array, its keys
     *                       will be transformed. Non-array data types will be returned
     *                       as-is without modification.
     * @return array The processed data, with all array keys in "headline" format.
     *               If the input was not an array, it will return the original value.
     */
    public static function convertKeysToHeadline(array $data)
    {
        $formatted = [];

        // Loop through each key and value
        foreach ($data as $key => $value) {
            // Apply Str::headline to the key and recursively process the value if it's an array
            $formatted[Str::headline($key)] = is_array($value) ? self::convertKeysToHeadline($value) : $value;
        }

        return $formatted;
    }

    public static function apiPagination(array $data)
    {
        return [
            'current_page' => $data['current_page'],
            'from' => $data['from'],
            'last_page' => $data['last_page'],
//            'links' => $data['links'],
//            'path' => $data['path'],
            'per_page' => $data['per_page'],
            'to' => $data['to'],
            'total' => $data['total'],
        ];
    }
}

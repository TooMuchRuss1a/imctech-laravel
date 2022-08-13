<?php

namespace App\Services;


class SanitizerService
{

    public function sanitizer($object, $column) {
        foreach ($object as $row) {
            if (empty($row->$column)) continue;
            $item = json_decode($row->$column);
            if (is_array($item)) {
                $row->$column = $this->arraySanitizer($item);
            }
            else if (is_object($item)) {
                $row->$column = $this->objectSanitizer($item);
            }
            else $row->$column = htmlspecialchars($item);
        }
        return $object;
    }

    protected function arraySanitizer($array) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = $this->arraySanitizer($value);
            }
            else if (is_object($value)) {
                $array[$key] = $this->objectSanitizer($value);
            }
            else $array[$key] = htmlspecialchars($value);
        }
        return $array;
    }

    protected function objectSanitizer($object) {
        foreach ($object as $key => $value) {
            if (is_array($value)) {
                $object->$key = $this->arraySanitizer($value);
            }
            else if (is_object($value)) {
                $object->$key = $this->objectSanitizer($value);
            }
            else $object->$key = htmlspecialchars($value);
        }
        return $object;
    }
}

<?php

namespace App\Services;


use Illuminate\Support\Facades\Validator;

class TimetableService
{

    public static function getTimelinesFromPostData($post): array {
        $array = [];
        foreach ($post as $key => $value) {
            if (str_contains($key, '-')) {
                $temp = explode('-', $key);
                $array[$temp[1]][$temp[0]] = $value;
            }
        }

        return $array;
    }

    public static function validateTimelines(array $events): array {
        $errors = [];
        $normalEvents = [];
        foreach ($events as $event) {
            $validator = Validator::make($event, [
                'from' => 'date_format:H:i',
                'to' => 'date_format:H:i',
                'description' => 'required'
            ])->messages();

            if (empty($validator->messages())) $normalEvents[] = $event;
            else {
                foreach ($validator->messages() as $message) {
                    $errors[] = $message;
                }
            }
        }

        return array($normalEvents, array_unique($errors, SORT_REGULAR));
    }
}

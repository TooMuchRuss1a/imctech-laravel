<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class ProjectService
{
    public static function getProjectsFromPostData($post): array {
        $array = [];
        foreach ($post as $key => $value) {
            if (str_contains($key, '-')) {
                $temp = explode('-', $key);
                $array[$temp[1]][$temp[0]] = $value;
            }
        }

        return $array;
    }

    public static function validateProjects(array $events): array {
        $errors = [];
        $normalProjects = [];
        foreach ($events as $event) {
            $validator = Validator::make($event, [
                'name' => 'required|unique:projects',
            ])->messages();

            if (empty($validator->messages())) $normalProjects[] = $event;
            else {
                foreach ($validator->messages() as $message) {
                    $errors[] = $message;
                }
            }
        }

        return array($normalProjects, array_unique($errors, SORT_REGULAR));
    }
}

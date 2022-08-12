<?php

namespace App\Services;


class VkApiService
{
    public static function getVkData($link) {
        if (isset(explode("/", $link)[3])) {
            $nickname = explode("/", $link)[3];
            $request_params = [
                'user_ids' => $nickname,
                'fields' => 'activities,
                        about,
                        blacklisted,
                        blacklisted_by_me,
                        books,
                        bdate,
                        can_be_invited_group,
                        can_post,
                        can_see_all_posts,
                        can_see_audio,
                        can_send_friend_request,
                        can_write_private_message,
                        career,
                        common_count,
                        connections,
                        contacts,
                        city,
                        country,
                        crop_photo,
                        domain,
                        education,
                        exports,
                        followers_count,
                        friend_status,
                        has_photo,
                        has_mobile,
                        home_town,
                        photo_100,
                        photo_200,
                        photo_200_orig,
                        photo_400_orig,
                        photo_50,
                        sex,
                        site,
                        schools,
                        screen_name,
                        status,
                        verified,
                        games,
                        interests,
                        is_favorite,
                        is_friend,
                        is_hidden_from_feed,
                        last_seen,
                        maiden_name,
                        military,
                        movies,
                        music,
                        nickname,
                        occupation,
                        online,
                        personal,
                        photo_id,
                        photo_max,
                        photo_max_orig,
                        quotes,
                        relation,
                        relatives,
                        timezone,
                        tv,
                        universities',
                'access_token' => env('ACCESS_TOKEN'),
                'v' => '5.85',
                'lang' => 'ru'
            ];

            $response = json_decode(file_get_contents('https://api.vk.com/method/getProfiles?' . http_build_query($request_params)));
            if (isset($response->error)) {
                return null;
            }
            return $response->response[0];
        }
        return null;
    }
}

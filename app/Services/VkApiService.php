<?php

namespace App\Services;


use App\Models\ApiRequest;
use App\Models\Role;

class VkApiService
{
    public function execVkApiRequest($method, $params = array()) {
        $params['v'] = '5.85';
        $params['lang'] = 'ru';
        $url = 'https://api.vk.com/method/'.$method.'?'.http_build_query($params);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($json, true);
        $this->logRequest($method, $params, $response);

        return (isset($response['error'])) ? null : $response['response'];
    }

    protected function logRequest($method, $params, $response) {
        unset($params['access_token']);
        $data = [
            'username' => (auth()->check()) ? auth()->user()->login : request()->ip(),
            'api' => 'vk',
            'method' => $method,
            'params' => json_encode($params, JSON_UNESCAPED_UNICODE),
            'response' => json_encode($response, JSON_UNESCAPED_UNICODE),
            'ip' => request()->ip(),
        ];

        info(ApiRequest::create($data));
    }

    public function getVkData(array $nicknames) {
        if (!empty($nicknames)) {
            $request_params = [
                'user_ids' => $nicknames,
                'fields' => 'activities,
                    about,
                    bdate,
                    career,
                    counters,
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
            ];

            return $this->execVkApiRequest('getProfiles', $request_params);
        }
        return null;
    }

    public function getVkDataViaLink ($links) {
        $nicknames = [];
        if (is_array($links) || is_object($links)) {
            foreach ($links as $link) {
                $array = explode("/", $link);
                $nicknames[] = $array[array_key_last($array)];
            }
            return $this->getVkData($nicknames);
        }
        else {
            $array = explode("/", $links);
            $nicknames[] = $array[array_key_last($array)];

            if (cache($nicknames[0])) {
                return cache($nicknames[0]);
            }
        }
        $response = $this->getVkData($nicknames);

        if (!empty($response)) {
            cache()->put($nicknames[0], $response, now()->addDay());
        }

        return $response;
    }

    public function getConversationMembers($peer_id) {
        return $this->execVkApiRequest('messages.getConversationMembers', [
            'peer_id' => 2000000000 + $peer_id,
            'access_token' => env('VK_API_COMMUNITY_TOKEN')
        ]);
    }

    public function sendMsg($peer_id, $message) {
        return $this->execVkApiRequest('messages.send', [
            'peer_id'    => $peer_id,
            'message'    => $message,
            'access_token' => env('VK_API_COMMUNITY_TOKEN')
        ]);
    }

    public function createChat($title) {
        return $this->execVkApiRequest('messages.createChat', [
            'title'    => $title,
            'access_token' => env('VK_API_COMMUNITY_TOKEN')
        ]);
    }

    public function getInviteLink($chat_id) {
        return $this->execVkApiRequest('messages.getInviteLink', [
            'peer_id'    => 2000000000 + $chat_id,
            'access_token' => env('VK_API_COMMUNITY_TOKEN')
        ]);
    }

    public function notifyRoot($data): void {
        $message = now() . " \n" . $data['status'] . " \n" . $data['username'] . " \n" . $data['method'] . ' ' . $data['uri'] . " \n" . $data['message'] . " \n" . $data['data'] . " \n" . route('admin.errors');
        $root_vk = Role::where(['name' => 'root'])->first()->user()->first()->socials()->where(['type' => 'vk'])->first()->link;

        $vk_id = $this->getVkDataViaLink($root_vk);
        if (!empty($vk_id)) {
            $this->sendMsg($vk_id[0]['id'], $message);
        }
    }

    public function removeChatUser($chat_id, $user_id) {
        return $this->execVkApiRequest('messages.removeChatUser', [
            'chat_id' => $chat_id,
            'user_id' => $user_id,
            'access_token' => env('VK_API_COMMUNITY_TOKEN')
        ]);
    }
}

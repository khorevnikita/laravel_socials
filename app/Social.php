<?php

namespace App;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot(['temp_code', 'access_token']);
    }

    public function getAuthUrlAttribute($v)
    {
        $redirect_url = "http://localhost:8080/socials/response";
        switch ($this->type) {
            case "vk":
                return "$v?client_id=$this->secret_id&display=page&redirect_uri=$redirect_url&code=7a6fa4dff77a228eeda56603b8f53806c883f011c40b72630bb50df056f6479e52a&response_type=code&state=$this->type";
                break;
            default:
                return $v;
        }
    }

    public function getTokenUrlAttribute()
    {
        $redirect_url = "http://localhost:8080/socials/response";
        switch ($this->type) {
            case "vk":
                return "https://oauth.vk.com/access_token?client_id=$this->secret_id&client_secret=$this->secret_key&redirect_uri=$redirect_url&code=";
                break;
            default:
                return null;
        }
    }

    public function getVkToken($code)
    {
        // https://oauth.vk.com/access_token?client_id=1&client_secret=H2Pk8htyFD8024mZaPHm&redirect_uri=http://mysite.ru&code=7a6fa4dff77a228eeda56603b8f53806c883f011c40b72630bb50df056f6479e52a
        $params = [
            'client_id' => $this->secret_id,
            'client_secret' => $this->secret_key,
            'redirect_uri' => 'http://socials.local/api/socials/get_token',
            'code' => $code,

        ];
        $client = new Client();
        $res = $client->get('https://oauth.vk.com/access_token?' . http_build_query($params));
        echo $res->getStatusCode(); // 200
        echo $res->getBody(); // { "type": "User", ....
    }
}

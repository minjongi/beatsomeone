<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
———————————————————————mint———————————————————————————————————
http://192.168.0.114:4002/user/mint
{
    "password" : "123",
    "token_id" : "5000", // 생성할 token id
    "token_string" : {   "general_infomation": {     "title": "Vvit (Prod.Maxmi)",     "tags": "lofi,groove,virture,Maxmi",     "track_type": "beats",     "release_date": "2020-11-07 15:10:00",     "url_of_your_track": "https://beatsomeone.com/detail/5fa39818db22f"   },   "selling_preferences": {     "is_the_music_copyright_officially_registered_beat": "N",     "basic_lease_license_price": "$5",     "basic_lease_license_inventory_quantity": 5,     "mastering_license_price": "$280",     "include_copyright_transfer": "N",     "mastering_license_inventory_quantity": 1   },   "track_details": {     "primary_genre": "electronic",     "subgenre": "indie",     "primary_mood": "calm",     "description": "Beatsomeone Original Contents",     "bpm": "1111111111111111111111111111111111111"   } }
}
—————————————————————-call————————————————————————————————————
http://192.168.0.114:4002/user/call
{
    "callname" : "read_string",
    "token_id" : "5000", // token id만 바꾸면 됨
    "address" : "5C5W6PAsJJr8891RrekVbYAVjpZd7HSVcrZ4b7xvKkqJuGxB"
}
————————————————————--query——————————————————————————————————
http://192.168.0.114:4002/user/query
{
    "extrincs" : "0x57b019a2deb0faf032f5440ae129c8f717a7f86deaa1beaf941ff03d8483258b" // mint에서 생성된 extrincs (txhash 입력)
}

https://telemetry.polkadot.io/#list/Beatsomeone
*/

class Blockchain {
    private $url = 'http://121.133.140.199:4003';
    private $address = '5C5W6PAsJJr8891RrekVbYAVjpZd7HSVcrZ4b7xvKkqJuGxB';
    private $password = '123';

	/**
	 * This is a static class, do not instantiate it
	 *
	 * @codeCoverageIgnore
	 */
	public function __construct() {}

    public function mint($tokenId, $tokenString) {
        $method = '/user/mint';
        $data = [
            'password' => $this->password,
            'token_id' => $tokenId,
            'token_string' => json_encode($tokenString)
        ];

        return $this->json_rpc($method, $data);
    }

    public function call($tokenId) {
        $method = '/user/call';
        $data = [
            'callname' => 'read_string',
            'token_id' => $tokenId,
            'address' => $this->address
        ];

        return $this->json_rpc($method, $data);
    }

	public function query($extrincs) {
        $method = '/user/query';
        $data = [
            'extrincs' => $extrincs
        ];

        return $this->json_rpc($method, $data);
    }

    function json_rpc($method, $data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url . $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($ch);
    }
}

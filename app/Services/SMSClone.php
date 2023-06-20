<?php

namespace App\Services;

class SMSClone {
    private $endpoint;
    private $username;
    private $password;

    public function __construct() {
        $this->endpoint = env('SMSCLONE_ENDPOINT');
        $this->username = env('SMSCLONE_USERNAME');
        $this->password = env('SMSCLONE_PASSWORD');
    }

    public function send(string $message, string $sender_id, array $numbers) {
        try {
            $numbers = implode(',', $numbers);
            $message = urlencode($message);

            $query_url = "{$this->endpoint}?username={$this->username}&password={$this->password}&sender={$sender_id}&recipient={$numbers}&message={$message}";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $query_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            
            curl_close($ch);

            return $response;
        } catch(\Exception $e) {
            return $e->getMessage();
        }
    }
}
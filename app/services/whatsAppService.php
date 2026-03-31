<?php 

namespace App\services;

use GreenApi\RestApi\GreenApiClient;

class whatsAppService{

    private GreenApiClient $client;
    
    public function __construct()
    {
        $this->client = new GreenApiClient(
                            $_ENV['GREEN_API_INSTANCE'],
                            $_ENV['GREEN_API_TOKEN']
                        );
    }

    public function sendMessage(string $number, string $text){
        $result = $this->client->sending->sendMessage('573003520420@c.us', 'lupe');
        debuguear($result);
    }
}
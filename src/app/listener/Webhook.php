<?php
namespace API\Webhook;

use Phalcon\Di\Injectable;
use GuzzleHttp\Client;
use Phalcon\Events\Event;
use WebhookUsers;

class Webhook extends Injectable
{
    public function sendUpdateResponse(Event $event)
    {
        $hooks = new WebhookUsers;
        $results = $hooks->findForUpdateEvent();

        foreach ($results->toArray() as $result) {

            $client = new Client();
            $response = $client->request('POST', $result['url'], ['form_params' => [json_decode(json_encode($event->getData()->toArray()), 1)[0]]]);
            
        }

    } 
    public function sendAddResponse(Event $event)
    {
        $hooks = new WebhookUsers;
        $results = $hooks->findForAddEvent();
        foreach ($results->toArray() as $result) {
            $client = new Client();
            $response = $client->request('POST', $result['url'], ['form_params' => [json_decode(json_encode($event->getData()->toArray()), 1)[0]]]);
            
        }
            
    }
}

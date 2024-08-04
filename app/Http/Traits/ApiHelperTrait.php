<?php

namespace App\Http\Traits;

use GuzzleHttp\Client;

trait ApiHelperTrait
{
    protected $client;

    public function initializeApiHelper()
    {
        $this->client = new Client([
            'base_uri' => env('API_URL')
        ]);
    }

    public function isAuthorized()
    {
        $token = session('token');
        $user = session('user');

        if (!$token || !$user) {
            return null;
        }

        return true;
    }
    public function fetchData($uri)
    {
        try {
            $response = $this->client->get($uri, [
                'headers' => [
                    'Authorization' => 'Bearer ' . session('token')
                ]
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function postData($uri, $data, $type, $requiresToken)
    {
        try {
            $options = [];
            if ($requiresToken) {
                $options['headers'] = [
                    'Authorization' => 'Bearer ' . session('token'),
                ];
            }

            if ($type === 'json') {
                $options['json'] = $data;
            } elseif ($type === 'form') {
                $options['form_params'] = $data;
            }

            $response = $this->client->post($uri, $options);

            return json_decode($response->getBody()->getContents());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }


    public function putData($uri, $data, $type)
    {
        try {
            $options = [
                'headers' => [
                    'Authorization' => 'Bearer ' . session('token')
                ],
            ];

            if ($type === 'json') {
                $options['json'] = $data;
            } elseif ($type === 'form') {
                $options['form_params'] = $data;
            }

            $response = $this->client->put($uri, $options);

            return json_decode($response->getBody()->getContents());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function deleteData($uri)
    {
        try {
            $response = $this->client->delete($uri, [
                'headers' => [
                    'Authorization' => 'Bearer ' . session('token')
                ]
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}

<?php

namespace App\Repositories;

use App\Message;
use App\Repositories\Interfaces\MessageRepositoryInterface;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class MessageRepository implements MessageRepositoryInterface
{
    /**
     * Клиент для запросов
     *
     * @var Client
     */
    protected $client;

    /**
     * Url в сервис получения данных
     *
     * @var string
     */
    protected $urlDatabase = 'http://127.0.0.1:8080';

    /**
     * Конструктор MessageRepository
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * {@inheritdoc}
     *
     * @param  int    $senderId
     * @param  int    $receiverId
     * @param  string $text
     * @return void
     * @throws \Exception
     */
    public function create(int $senderId, int $receiverId, string $text)
    {
        try {
            $response = $this->client->post(sprintf('%s/message', $this->urlDatabase), [
                'form_params' => [
                    'receiverId' => $receiverId,
                    'senderId'   => $senderId,
                    'text'       => $text,
                ]
            ]);

            $data = json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            throw new \Exception('Error while adding message');
        }

        if (!(isset($data['code']) && $data['code'] == 200)) {
            throw new \Exception('Error while adding message');
        }
    }

    /**
     * {@inheritdoc}
     *
     * @param  int            $senderId
     * @param  int            $receiverId
     * @return \App\Message[]
     */
    public function getMessages(int $senderId, int $receiverId)
    {
        try {
            $url      = sprintf('%s/messages?receiverId=%d&senderId=%d', $this->urlDatabase, $receiverId, $senderId);
            $response = $this->client->get($url, []);
            $data     = json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            return [];
        }

        $messages = $data['messages'] ?? [];
        $result   = [];

        foreach ($messages as $message) {
            $result[] = new Message((array) $message);
        }

        return $result;
    }
}
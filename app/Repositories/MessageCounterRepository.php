<?php

namespace App\Repositories;

use App\Message;
use App\Repositories\Interfaces\MessageCounterRepositoryInterface;
use GuzzleHttp\Client;

class MessageCounterRepository implements MessageCounterRepositoryInterface
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
    protected $urlDatabase = 'http://127.0.0.1:8090';

    /**
     * Конструктор MessageCounterRepository
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * {@inheritdoc}
     *
     * @param  int $userId
     * @return int
     */
    public function getNbUnreadMessages(int $userId)
    {
        if (empty($userId) || $userId === 0) {
            return 0;
        }

        try {
            $url      = sprintf('%s/get-nb-unread?userId=%d', $this->urlDatabase, $userId);
            $response = $this->client->get($url, []);
            $data     = json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            return 0;
        }

        $cnt = $data['cnt'] ?? 0;

        return $cnt;
    }
}
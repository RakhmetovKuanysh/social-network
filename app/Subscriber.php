<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Подписчики пользователя
 */
class Subscriber extends Model
{
    /**
     * Id
     *
     * @var int
     */
    private $id;

    /**
     * Id пользователя
     *
     * @var int
     */
    private $followerId;

    /**
     * Id подписчика
     *
     * @var int
     */
    private $subscriberId;

    /**
     * Конструктор
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);

        $this->id           = $data['id'] ?? null;
        $this->followerId   = $data['follower_id'] ?? null;
        $this->subscriberId = $data['subscriber_id'] ?? null;
    }

    /**
     * Id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Id подписчика
     *
     * @return int
     */
    public function getSubscriberId()
    {
        return $this->subscriberId;
    }

    /**
     * Id пользователя
     *
     * @return int
     */
    public function getFollowerId()
    {
        return $this->followerId;
    }

    /**
     * Приводит сущность в массив
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id'           => $this->getId(),
            'subscriberId' => $this->getSubscriberId(),
            'followerId'   => $this->getFollowerId(),
        ];
    }
}
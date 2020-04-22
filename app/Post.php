<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Пост
 */
class Post extends Model
{
    /**
     * Заполняемые поля
     *
     * @var array
     */
    protected $fillable = ['id'];

    /**
     * Id
     *
     * @var int
     */
    private $id;

    /**
     * Текст
     *
     * @var string
     */
    private $text;

    /**
     * Id пользователя
     *
     * @var int
     */
    private $userId;

    /**
     * Дата создания
     *
     * @var \DateTime
     */
    private $createdAt;

    /**
     * Конструктор
     *
     * @param  array $data
     * @return \App\Post
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);

        $this->id        = $data['id'] ?? null;
        $this->text      = $data['text'] ?? '';
        $this->userId    = $data['userId'] ?? null;
        $this->createdAt = $data['created_at'] ?? null;

        return $this;
    }

    /**
     * Id
     *
     * @param  int       $id
     * @return \App\Post
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
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
     * Текст
     *
     * @param  string   $text
     * @return \App\Post
     */
    public function setText(string $text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Текст
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Id пользователя
     *
     * @param  int       $userId
     * @return \App\Post
     */
    public function setUserId(int $userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Id пользователя
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Дата создания
     *
     * @param  \DateTime $createdAt
     * @return \App\Post
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Дата создания
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Приводит сущность в массив
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id'         => $this->getId(),
            'text'       => $this->getText(),
            'user_id'    => $this->getUserId(),
            'created_at' => $this->getCreatedAt(),
        ];
    }
}
<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Сообщение
 */
class Message extends Model
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
     * Id пользователя
     *
     * @var int
     */
    private $senderId;

    /**
     * Id подписчика
     *
     * @var int
     */
    private $receiverId;

    /**
     * Дата создания
     *
     * @var \DateTime
     */
    private $createdAt;

    /**
     * Текст сообщения
     *
     * @var string
     */
    private $text;

    /**
     * Конструктор
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);

        $this->id         = $data['id'] ?? null;
        $this->senderId   = $data['sender_id'] ?? null;
        $this->receiverId = $data['receiver_id'] ?? null;
        $this->text       = $data['text'] ?? null;
        $this->createdAt  = $data['created_at'] ?? null;
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
     * Id принимающего
     *
     * @return int
     */
    public function getReceiverId()
    {
        return $this->receiverId;
    }

    /**
     * Id отсылающего
     *
     * @return int
     */
    public function getSenderId()
    {
        return $this->senderId;
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
     * Текст сообщения
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
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
            'receiverId' => $this->getReceiverId(),
            'senderId'   => $this->getSenderId(),
            'text'       => $this->getText(),
            'createdAt'  => $this->getCreatedAt(),
        ];
    }
}
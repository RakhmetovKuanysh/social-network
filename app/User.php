<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Модель пользователя
 */
class User extends Model
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
     * Email
     *
     * @var string
     */
    private $email;

    /**
     * Имя
     *
     * @var string
     */
    private $name;

    /**
     * Фамилия
     *
     * @var string
     */
    private $surname;

    /**
     * Пол
     *
     * @var int
     */
    private $gender;

    /**
     * Интересы
     *
     * @var string
     */
    private $interests;

    /**
     * Город
     *
     * @var string
     */
    private $city;

    /**
     * Год рождения
     *
     * @var int
     */
    private $year;

    /**
     * Конструктор
     *
     * @param  array $data
     * @return \App\User
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);

        $this->id        = $data['id'] ?? null;
        $this->email     = $data['email'] ?? '';
        $this->name      = $data['name'] ?? '';
        $this->surname   = $data['surname'] ?? '';
        $this->city      = $data['city'] ?? '';
        $this->year      = $data['year'] ?? null;
        $this->interests = $data['interests'] ?? '';
        $this->gender    = $data['gender'] ?? null;

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
     * Email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Имя
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Фамилия
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Год рождения
     *
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Интересы
     *
     * @return string
     */
    public function getInterests()
    {
        return $this->interests;
    }

    /**
     * Пол
     *
     * @return int
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Город
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Подписчики
     *
     * @return HasMany
     */
    public function subscribers()
    {
        return $this->hasMany('App\Subscriber', 'follower_id', 'id');
    }

    /**
     * Приводит сущность в массив
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id'        => $this->getId(),
            'name'      => $this->getName(),
            'surname'   => $this->getSurname(),
            'gender'    => $this->getGender(),
            'interests' => $this->getInterests(),
            'year'      => $this->getYear(),
            'email'     => $this->getEmail(),
        ];
    }
}

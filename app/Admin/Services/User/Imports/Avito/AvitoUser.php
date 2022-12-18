<?php

namespace App\Admin\Services\User\Imports\Avito;

class AvitoUser
{
    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $phone;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $personal_site;

    /**
     * @var string
     */
    protected $birthday;

    public function __construct(
        string $firstName,
        string $lastName,
        string $email,
        string $phone
//        string $password,
//        string $personal_site,
//        string $birthday
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phone = $this->formatPhone($phone);
//        $this->password = $password;
//        $this->personal_site = $personal_site;
//        $this->birthday = $birthday;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

     /**
     * @return string
     */
    public function getPersonalSite(): string
    {
        return $this->personal_site;
    }

     /**
     * @return string
     */
    public function getBirthday(): string
    {
        return $this->birthday;
    }

    /**
     * Форматировать телефон.
     *
     * @param string $phone
     *
     * @return string
     */
    protected function formatPhone(string $phone): string
    {
        return mb_strlen($phone) === 11 ? $phone : 7 . $phone;
    }
}

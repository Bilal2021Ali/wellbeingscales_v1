<?php

namespace DTOs;

use Carbon\Carbon;
use PHPExperts\DataTypeValidator\DataTypeValidator;
use PHPExperts\SimpleDTO\SimpleDTO;

/**
 * @property string $Phone
 * @property string $Email
 */
class StudentDTO extends SimpleDTO
{
    /**
     * @var string $F_name_EN
     */
    protected string $F_name_EN;
    /**
     * @var string $F_name_AR
     */
    protected string $F_name_AR;
    /**
     * @var string $M_name_EN
     */
    protected string $M_name_EN;
    /**
     * @var string $M_name_AR
     */
    protected string $M_name_AR;
    /**
     * @var string $L_name_EN
     */
    protected string $L_name_EN;
    /**
     * @var string $L_name_AR
     */
    protected string $L_name_AR;

    /**
     * @var string $Email
     */
    protected string $Email;
    /**
     * @var string $Phone
     */
    protected string $Phone;
    /**
     * @var string $address
     */
    protected string $address;
    /**
     * @var string $city
     */
    protected string $city;
    /**
     * @var string $country
     */
    protected string $country;
    /**
     * @var string $nationality
     */
    protected string $nationality;
    /**
     * @var string $gender
     */
    protected string $gender;
    /**
     * @var Carbon $DOB
     */
    protected Carbon $DOP;

    public function __construct(array $input)
    {
        parent::__construct($input, [SimpleDTO::PERMISSIVE]);
    }

    public function __serialize(): array
    {
        return [];
    }

    public function __unserialize(array $data): void
    {
    }

    public function fullName(string $language): string
    {
        $language = strtoupper($language);
        return $this->{'F_name_' . $language} . ' ' . $this->{'L_name_' . $language};
    }
}
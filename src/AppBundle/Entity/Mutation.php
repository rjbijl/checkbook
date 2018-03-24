<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Mutation
 *
 * @ORM\Entity
 * @ORM\Table(name="mutation")
 *
 * @package AppBundle\Entity
 */
class Mutation
{
    const TYPE_DEBIT = 'debit';
    const TYPE_CREDIT = 'credit';

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var \DateTimeInterface
     * @ORM\Column(name="datetime", type="datetime")
     */
    private $datetime;

    /**
     * @var string
     * @ORM\Column(name="contra_account_name", type="string")
     */
    private $contraAccountName;

    /**
     * @var string
     * @ORM\Column(name="contra_account_number", type="string")
     */
    private $contraAccountNumber;

    /**
     * @var int
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

    /**
     * @var string
     * @ORM\Column(name="type", type="string")
     */
    private $type;

    /**
     * @var string
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    public function __construct()
    {

    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDatetime(): \DateTimeInterface
    {
        return $this->datetime;
    }

    /**
     * @param \DateTimeInterface $datetime
     * @return Mutation
     */
    public function setDatetime(\DateTimeInterface $datetime): Mutation
    {
        $this->datetime = $datetime;
        return $this;
    }


    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return Mutation
     */
    public function setAmount(int $amount): Mutation
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Mutation
     */
    public function setType(string $type): Mutation
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Mutation
     */
    public function setDescription(string $description): Mutation
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getContraAccountName(): string
    {
        return $this->contraAccountName;
    }

    /**
     * @param string $contraAccountName
     * @return Mutation
     */
    public function setContraAccountName(string $contraAccountName): Mutation
    {
        $this->contraAccountName = $contraAccountName;
        return $this;
    }

    /**
     * @return string
     */
    public function getContraAccountNumber(): string
    {
        return $this->contraAccountNumber;
    }

    /**
     * @param string $contraAccountNumber
     * @return Mutation
     */
    public function setContraAccountNumber(string $contraAccountNumber): Mutation
    {
        $this->contraAccountNumber = $contraAccountNumber;
        return $this;
    }
}
<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Mutation
 *
 * @ORM\Entity
 * @ORM\Table(name="category")
 *
 * @package AppBundle\Entity
 */
class Category
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Mutation", mappedBy="category")
     */
    private $mutations;

    /**
     * Category constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->mutations = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Category
     */
    public function setName(string $name): Category
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getMutations(): ArrayCollection
    {
        return $this->mutations;
    }

    /**
     * @param ArrayCollection $mutations
     * @return Category
     */
    public function setMutations(ArrayCollection $mutations): Category
    {
        $this->mutations = $mutations;
        return $this;
    }

    /**
     * @param Mutation $mutation
     * @return Category
     */
    public function addMutation(Mutation $mutation): Category
    {
        if (!$this->mutations->contains($mutation)) {
            $this->mutations->add($mutation);
            $mutation->setCategory($this);
        }

        return $this;
    }
}
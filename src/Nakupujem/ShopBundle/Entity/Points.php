<?php

namespace Nakupujem\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Points
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Points
{
    /**
     *
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToOne(targetEntity="Nakupujem\ShopBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userId", referencedColumnName="id")
     *  }
     * )
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

    public function __construct()
    {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set amount
     *
     * @param string $amount
     * @return Points
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set user
     *
     * @param \Nakupujem\ShopBundle\Entity\User $user
     * @return Points
     */
    public function setUser(\Nakupujem\ShopBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Nakupujem\ShopBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}

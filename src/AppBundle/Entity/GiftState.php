<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GiftState
 *
 * @ORM\Table(name="gift_state")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GiftStateRepository")
 */
class GiftState
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=100, unique=true)
     */
    private $state;

    /**
     * @ORM\OneToMany(targetEntity="Donation", mappedBy="state")
     */
    private $donation;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return GiftState
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->donation = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add donation
     *
     * @param \AppBundle\Entity\GiftState $donation
     *
     * @return GiftState
     */
    public function addDonation(\AppBundle\Entity\GiftState $donation)
    {
        $this->donation[] = $donation;

        return $this;
    }

    /**
     * Remove donation
     *
     * @param \AppBundle\Entity\GiftState $donation
     */
    public function removeDonation(\AppBundle\Entity\GiftState $donation)
    {
        $this->donation->removeElement($donation);
    }

    /**
     * Get donation
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDonation()
    {
        return $this->donation;
    }
}

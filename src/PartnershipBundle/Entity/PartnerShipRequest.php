<?php

namespace PartnershipBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Date;

/**
 * CategoriePartenaire
 * @ORM\Entity
 * @ORM\Table(name="partnership_request")
 */
class PartnerShipRequest
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
     * @var Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     *
     */
    private $client;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="datetime")
    */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="CategoriePartenaire")
     * @ORM\JoinColumn(name="categorie",referencedColumnName="id",onDelete="CASCADE")
     */
    private $categorie;


    /**
     * @var string
     * @ORM\Column(name="note", type="string", nullable=true , length=255)
     */
    private $note;

    /**
     * @var string
     * @ORM\Column(name="status", type="string", length=150, nullable=false)
     * @Assert\NotBlank
     */
    private $status;


    /**
     * PartnerShipRequest constructor.
     * @param string $status
     */
    public function __construct()
    {
        $this->status = 'EN_COURS';
        $this->date = new \DateTime('now');
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }



    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param string $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param mixed $categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }




}
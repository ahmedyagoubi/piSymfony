<?php

namespace EventBundle\Entity;

//use AncaRebeca\FullCalendarBundle\Event\CalendarEvent;
use AncaRebeca\FullCalendarBundle\Model\FullCalendarEvent;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement")
 * @ORM\Entity(repositoryClass="EventBundle\Repository\EvenementRepository")
 * @UniqueEntity("nomEvenement" , message="LE NOM de evenement existe déjà .") // c'est ici que je declare le champs unique
 */
class Evenement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_event", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true , unique=true)
     *  * @Assert\NotBlank()
     */
    private $nomEvenement;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=true)
     */
    private $adr;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var float
     *
     * @ORM\Column(name="code_post", type="float")
     */
    private $code;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_part", type="integer")
     */
    private $nbreplace;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string")
     */
    private $ville;
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_start", type="date")
     */
    private $dateDebut;

    /**
     * @ORM\Column(name="media", type="string")
     *
     * @Assert\NotBlank(message="Please, upload image file.")
     * @Assert\File()
     */

    private $image;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="date")
     */
    private $dateFin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_create", type="date")
     */
    private $dateCreation;

    /**
     *
     * @ORM\ManyToOne(targetEntity="PartnershipBundle\Entity\Client")
     * @ORM\JoinColumn(name="id_admin",referencedColumnName="id",nullable=true, onDelete="CASCADE")
     */
    private $responsable;


    /**
     * Evenement constructor.
     * @param string $adr
     * @param string $description
     * @param \DateTime $dateDebut
     * @param \DateTime $dateFin
     */
//    public function __construct($adr, $description, \DateTime $dateDebut, \DateTime $dateFin)
//    {
//        $this->adr = $adr;
//        $this->description = $description;
//        $this->dateDebut = $dateDebut;
//        $this->dateFin = $dateFin;
//    }

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
     * Set nomEvenement
     *
     * @param string $nomEvenement
     *
     * @return Evenement
     */
    public function setNomEvenement($nomEvenement)
    {
        $this->nomEvenement = $nomEvenement;

        return $this;
    }

    /**
     * Get nomEvenement
     *
     * @return string
     */
    public function getNomEvenement()
    {
        return $this->nomEvenement;
    }

    /**
     * Set adr
     *
     * @param string $adr
     *
     * @return Evenement
     */
    public function setAdr($adr)
    {
        $this->adr = $adr;

        return $this;
    }

    /**
     * Get adr
     *
     * @return string
     */
    public function getAdr()
    {
        return $this->adr;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Evenement
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return Evenement
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Evenement
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @return mixed
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * @param mixed $responsable
     */
    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return float
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param float $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return int
     */
    public function getNbreplace()
    {
        return $this->nbreplace;
    }

    /**
     * @param int $nbreplace
     */
    public function setNbreplace($nbreplace)
    {
        $this->nbreplace = $nbreplace;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return int
     */
    public function getNbrSignal()
    {
        return $this->nbrSignal;
    }

    /**
     * @param int $nbrSignal
     */
    public function setNbrSignal($nbrSignal)
    {
        $this->nbrSignal = $nbrSignal;
    }


    /**
     * @return int
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param int $ville
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param \DateTime $dateCreation
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
    }

}

<?php

namespace PartnershipBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use PartnershipBundle\Entity\Partenaire;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="client")
 * @Vich\Uploadable
 * @ORM\Entity(repositoryClass="PartnershipBundle\Repository\UserRepository")
 */
class Client extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255 , nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255 , nullable=true)
     */
    private $prenom;


    /**
     * @var string
     *
     * @ORM\Column(name="addresse", type="string", length=255 , nullable=true)
     */
    private $addresse;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255 , nullable=true)
     */
    private $type;

    /**
     * @var string
     * @Assert\Length(
     *      min = 8,
     *      max = 8,
     *      minMessage = "Le numéro de téléphone doit se composer de deux chiffre",
     *      maxMessage = "Le numéro de téléphone doit se composer de deux chiffre",
     * )
     * @ORM\Column(name="telephone", type="string", length=255 , nullable=true)
     */
    private $telephone;


    /**
     * @ORM\Column(type="string", length=255, nullable = true)
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="user_image", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var int
     *
     * @ORM\Column(name="ptFidelite", type="integer")
     */
    private $ptFidelite;

    /**
     *
     * @ORM\ManyToOne(targetEntity="CategoriePartenaire")
     * @ORM\JoinColumn(name="categorie_id", referencedColumnName="id"   )
     */
    private $categorie;



    /**
     * @var array
     */
    protected $roles;

    /**
     * Client constructor.
     * @param int $ptFidelite
     */
    public function __construct()
    {
        parent::__construct();
        $this->ptFidelite = 1;
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

    /**
     * @return int
     */
    public function getPtFidelite()
    {
        return $this->ptFidelite;
    }

    /**
     * @param int $ptFidelite
     */
    public function setPtFidelite($ptFidelite)
    {
        $this->ptFidelite = $ptFidelite;
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
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return string
     */
    public function getAddresse()
    {
        return $this->addresse;
    }

    /**
     * @param string $addresse
     */
    public function setAddresse($addresse)
    {
        $this->addresse = $addresse;
    }

    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
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
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param File $imageFile
     */
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
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



}


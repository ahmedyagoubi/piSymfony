<?php

namespace PartnershipBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * CategoriePartenaire
 * @Vich\Uploadable
 * @ORM\Table(name="categorie_partenaire")
 * @ORM\Entity(repositoryClass="PartnershipBundle\Repository\CategoriePartenaireRepository")
 */
class CategoriePartenaire
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
     * @ORM\Column(name="libelle", type="string", length=255)
     *
     * @Assert\NotBlank
     *
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     *
     * @Assert\NotBlank
     *
     */
    private $description;

    /**
     * One product has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="Client", mappedBy="categorie")
     */
    private $partenaires;

    /**
     * @ORM\Column(type="string", length=255, nullable = true)
     * @var string
     */
    private $cover;

    /**
     * @Vich\UploadableField(mapping="categorie_image", fileNameProperty="cover")
     * @var File
     */
    private $categorieFile;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     * @var \DateTime
     */
    private $updatedAt;

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
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param string $libelle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPartenaires()
    {
        return $this->partenaires;
    }

    /**
     * @param mixed $partenaires
     */
    public function setPartenaires($partenaires)
    {
        $this->partenaires = $partenaires;
    }

    public function __toString()
    {
        return $this->libelle;
    }

    /**
     * @return string
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * @param string $cover
     */
    public function setCover($cover)
    {
        $this->cover = $cover;
    }

    /**
     * @return File
     */
    public function getCategorieFile()
    {
        return $this->categorieFile;
    }

    /**
     * @param File $categorieFile
     */
    public function setCategorieFile($categorieFile)
    {
        $this->categorieFile = $categorieFile;
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

}


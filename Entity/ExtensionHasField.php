<?php

namespace Purethink\CMSBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\SoftDeleteable;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="extension_has_field")
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class ExtensionHasField implements SoftDeleteable
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    const TYPE_TEXT = 1;
    const TYPE_TEXTAREA = 2;
    const TYPE_NUMBER = 3;
    const TYPE_BOOLEAN = 6;
    const TYPE_DATE = 7;
    const TYPE_DATETIME = 8;
    const TYPE_ARTICLE = 9;
    const TYPE_FILE = 10;
    const TYPE_WYSIWYG = 11;

    public static $availableTypeOfField = [
        self::TYPE_TEXT     => "text",
        self::TYPE_TEXTAREA => "textarea",
        self::TYPE_NUMBER   => "number",
        self::TYPE_BOOLEAN  => "boolean",
        self::TYPE_DATE     => "date",
        self::TYPE_DATETIME => "datetime",
        self::TYPE_ARTICLE  => "article",
        self::TYPE_FILE     => "file",
        self::TYPE_WYSIWYG  => "WYSIWYG"
    ];

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\Length(max="255")
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"}, unique=false, separator="_")
     * @ORM\Column(length=255, unique=false)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Assert\Length(max="255")
     */
    private $labelOfField;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $required = false;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isMainField = false;

    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="Extension", inversedBy="fields")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $extension;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotNull()
     */
    private $typeOfField;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ComponentHasValue", mappedBy="extensionHasField", orphanRemoval=true)
     */
    protected $fields;


    public static function getTypeOfFieldStringById($id)
    {
        return self::$availableTypeOfField[$id];
    }

    public function getTypeOfFieldString()
    {
        return self::$availableTypeOfField[$this->getTypeOfField()];
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
     * Set name
     *
     * @param string $name
     * @return ExtensionHasField
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return ExtensionHasField
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set isMainField
     *
     * @param boolean $isMainField
     * @return ExtensionHasField
     */
    public function setIsMainField($isMainField)
    {
        $this->isMainField = $isMainField;

        return $this;
    }

    /**
     * Get isMainField
     *
     * @return boolean
     */
    public function getIsMainField()
    {
        return $this->isMainField;
    }

    /**
     * Set extension
     *
     * @param Extension $extension
     * @return ExtensionHasField
     */
    public function setExtension(Extension $extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return Extension
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set labelOfField
     *
     * @param string $labelOfField
     * @return ExtensionHasField
     */
    public function setLabelOfField($labelOfField)
    {
        $this->labelOfField = $labelOfField;

        return $this;
    }

    /**
     * Get labelOfField
     *
     * @return string
     */
    public function getLabelOfField()
    {
        return $this->labelOfField;
    }

    /**
     * Set typeOfField
     *
     * @param integer $typeOfField
     * @return ExtensionHasField
     */
    public function setTypeOfField($typeOfField)
    {
        $this->typeOfField = $typeOfField;

        return $this;
    }

    /**
     * Get typeOfField
     *
     * @return integer
     */
    public function getTypeOfField()
    {
        return $this->typeOfField;
    }

    /**
     * Set required
     *
     * @param boolean $required
     * @return ExtensionHasField
     */
    public function setRequired($required)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * Get required
     *
     * @return boolean
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return ExtensionHasField
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fields = new ArrayCollection();
    }

    /**
     * Add field
     *
     * @param ComponentHasValue $field
     *
     * @return ExtensionHasField
     */
    public function addField(ComponentHasValue $field)
    {
        $this->fields[] = $field;

        return $this;
    }

    /**
     * Remove field
     *
     * @param ComponentHasValue $field
     */
    public function removeField(ComponentHasValue $field)
    {
        $this->fields->removeElement($field);
    }

    /**
     * Get fields
     *
     * @return Collection
     */
    public function getFields()
    {
        return $this->fields;
    }
}

<?php

namespace Purethink\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\SoftDeleteable;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translatable;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Table(name="site")
 * @ORM\Entity(repositoryClass="Purethink\CMSBundle\Repository\SiteRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Site implements SoftDeleteable, MetadataInterface
{
    use Translatable;
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="tracking_code", nullable=true)
     */
    protected $trackingCode;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="contact_email", length=255, nullable=true)
     * @Assert\Email()
     * @Assert\Length(min="3", max="255")
     */
    protected $contactEmail;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", name="add_title_to_sub_pages", options={"default"=1})
     */
    protected $addTitleToSubPages = true;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", name="send_contact_request_on_email", options={"default"=0})
     */
    protected $sendContactRequestOnEmail = false;

    protected $translations;


    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        if ($this->isSendContactRequestOnEmail() && empty($this->getContactEmail())) {
            $context->buildViolation('This value should not be blank.')
                ->atPath('contactEmail')
                ->addViolation();
        }
    }

    public function __toString()
    {
        if ($this->translations && $this->translations->count()) {
            return (string)$this->getTitle();
        }
        return '';
    }

    public function getTitle()
    {
        if ($this->getCurrentTranslation()) {
            return $this->getCurrentTranslation()->getTitle();
        }

        return '';
    }

    public function getDescription()
    {
        if ($this->getCurrentTranslation()) {
            return $this->getCurrentTranslation()->getDescription();
        }

        return '';
    }

    public function getKeyword()
    {
        if ($this->getCurrentTranslation()) {
            return $this->getCurrentTranslation()->getKeyword();
        }

        return '';
    }

    public function __construct()
    {
        $this->translations = new ArrayCollection();
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
     * @return string
     */
    public function getTrackingCode()
    {
        return $this->trackingCode;
    }

    /**
     * @param string $trackingCode
     */
    public function setTrackingCode($trackingCode)
    {
        $this->trackingCode = $trackingCode;
    }

    /**
     * @return string
     */
    public function getContactEmail()
    {
        return $this->contactEmail;
    }

    /**
     * @param string $contactEmail
     */
    public function setContactEmail($contactEmail)
    {
        $this->contactEmail = $contactEmail;
    }

    /**
     * @return boolean
     */
    public function isAddTitleToSubPages()
    {
        return $this->addTitleToSubPages;
    }

    /**
     * @param boolean $addTitleToSubPages
     * @return Site
     */
    public function setAddTitleToSubPages($addTitleToSubPages)
    {
        $this->addTitleToSubPages = $addTitleToSubPages;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isSendContactRequestOnEmail()
    {
        return $this->sendContactRequestOnEmail;
    }

    /**
     * @param boolean $sendContactRequestOnEmail
     * @return Site
     */
    public function setSendContactRequestOnEmail($sendContactRequestOnEmail)
    {
        $this->sendContactRequestOnEmail = $sendContactRequestOnEmail;
        return $this;
    }
}

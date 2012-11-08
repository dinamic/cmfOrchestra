<?php
/**
 * This file is part of the <Translation> project.
 *
 * @category   BootStrap_Model
 * @package    Model
 * @author (c) <etienne de Longeaux> <etienne.delongeaux@gmail.com>
 * @since 2012-03-22
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace BootStrap\TranslationBundle\Model;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use BootStrap\TranslationBundle\Model\AbstractTranslation;

/**
 * abstract class for default attribut.
 *
 * @category   BootStrap_Model
 * @package    Model
 * @abstract
 *
 * @author (c) <etienne de Longeaux> <etienne.delongeaux@gmail.com>
 */
abstract class AbstractDefault extends AbstractTranslation 
{
    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $created_at;
    
    /**
     * @var datetime $updated_at
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updated_at;
    
    /**
     * @var date $published_at
     *
     * @ORM\Column(name="published_at", type="date", nullable=true)
     */
    protected $published_at;
    
    /**
     * @var datetime $archive_at
     *
     * @ORM\Column(name="archive_at", type="datetime", nullable=true)
     */
    protected $archive_at;
    
    /**
     * @var boolean $enabled
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    protected $enabled;
    
    /**
     * @ORM\Column(name="position", type="integer",  nullable=true)
     */
    protected $position;   
    
    /**
     * Constructor
     */    
    public function __construct()
    {
    	parent::__construct();
    	
    	$this->setEnabled(true);
    }    

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
    	$this->created_at = $createdAt;
    	return $this;
    }
    
    /**
     * Get created_at
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
    	return $this->created_at;
    }
    
    /**
     * Set updated_at
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
    	$this->updated_at = $updatedAt;
    	return $this;
    }
    
    /**
     * Get updated_at
     *
     * @return datetime
     */
    public function getUpdatedAt()
    {
    	return $this->updated_at;
    }
    
    /**
     * Set published_at
     *
     * @param date $publishedAt
     */
    public function setPublishedAt($publishedAt)
    {
    	$this->published_at = $publishedAt;
    	return $this;
    }
    
    /**
     * Get published_at
     *
     * @return date
     */
    public function getPublishedAt()
    {
    	return $this->published_at;
    }
    
    /**
     * Set archive_at
     *
     * @param datetime $archiveAt
     */
    public function setArchiveAt($archiveAt)
    {
    	$this->archive_at = $archiveAt;
    	return $this;
    }
    
    /**
     * Get archive_at
     *
     * @return datetime
     */
    public function getArchiveAt()
    {
    	return $this->archive_at;
    }
    
    /**
     * Set enabled
     *
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
    	$this->enabled = $enabled;
    	return $this;
    }
    
    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
    	return $this->enabled;
    }   

    /**
     * Set $position
     *
     * @param integer $position
     */
    public function setPosition($position)
    {
    	$this->position = $position;
    	//return $this;
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
    
}
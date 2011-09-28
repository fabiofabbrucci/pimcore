<?php 
/**
 * Pimcore
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.pimcore.org/license
 *
 * @category   Pimcore
 * @package    Document
 * @copyright  Copyright (c) 2009-2010 elements.at New Media Solutions GmbH (http://www.elements.at)
 * @license    http://www.pimcore.org/license     New BSD License
 */

class Document_Hardlink extends Document
{

    /**
     * static type of this object
     *
     * @var string
     */
    public $type = "hardlink";

    /**
     * @var int
     */
    public $sourceId;

    /**
     * @var bool
     */
    public $propertiesFromSource;

    /**
     * @var bool
     */
    public $inheritedPropertiesFromSource;

    /**
     * @var bool
     */
    public $childsFromSource;


    /**
     * @return Document_PageSnippet
     */
    public function getSourceDocument () {
        if($this->getSourceId()) {
            return Document::getById($this->getSourceId());
        }

        return null;
    }

    /**
     * @see Document::resolveDependencies
     * @return array
     */
    public function resolveDependencies()
    {
        $dependencies = parent::resolveDependencies();

        if ($this->getSourceDocument() instanceof Document) {
            $key = "document_" . $this->getSourceDocument()->getId();

            $dependencies[$key] = array(
                "id" => $this->getSourceDocument()->getId(),
                "type" => "document"
            );
        }

        return $dependencies;
    }

    /**
     * Resolves dependencies and create tags for caching out of them
     *
     * @return array
     */
    public function getCacheTags($tags = array())
    {
        $tags = is_array($tags) ? $tags : array();

        $tags = parent::getCacheTags($tags);

        if ($this->getSourceDocument()) {
            if ($this->getSourceDocument()->getId() != $this->getId() and !array_key_exists($this->getSourceDocument()->getCacheTag(), $tags)) {
                $tags = $this->getSourceDocument()->getCacheTags($tags);
            }
        }

        return $tags;
    }

    /**
     * @param boolean $childsFromSource
     */
    public function setChildsFromSource($childsFromSource)
    {
        $this->childsFromSource = $childsFromSource;
    }

    /**
     * @return boolean
     */
    public function getChildsFromSource()
    {
        return $this->childsFromSource;
    }

    /**
     * @param int $sourceId
     */
    public function setSourceId($sourceId)
    {
        $this->sourceId = $sourceId;
    }

    /**
     * @return int
     */
    public function getSourceId()
    {
        return $this->sourceId;
    }

    /**
     * @param boolean $propertiesFromSource
     */
    public function setPropertiesFromSource($propertiesFromSource)
    {
        $this->propertiesFromSource = $propertiesFromSource;
    }

    /**
     * @return boolean
     */
    public function getPropertiesFromSource()
    {
        return $this->propertiesFromSource;
    }

    /**
     * @param boolean $inheritedPropertiesFromSource
     */
    public function setInheritedPropertiesFromSource($inheritedPropertiesFromSource)
    {
        $this->inheritedPropertiesFromSource = $inheritedPropertiesFromSource;
    }

    /**
     * @return boolean
     */
    public function getInheritedPropertiesFromSource()
    {
        return $this->inheritedPropertiesFromSource;
    }


}

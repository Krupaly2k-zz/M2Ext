<?php

namespace Bestresponsemedia\Customers\Model\Attribute\Backend;

/**
 * Class GitUrl
 */
class GitUrl extends \Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend
{

    /**
     * @var int $maxValueLength
     */
    protected $maxValueLength = 200;

    /**
     * @param \Magento\Framework\DataObject $object
     *
     * @return $this
     */
    public function afterLoad($object)
    {
        // your after load logic

        return parent::afterLoad($object);
    }

    /**
     * @param \Magento\Framework\DataObject $object
     *
     * @return $this
     */
    public function beforeSave($object)
    {
        $this->validateLength($object);
		$this->validateUrl($object);
        return parent::beforeSave($object);
    }

    /**
     * Validate length
     *
     * @param \Magento\Framework\DataObject $object
     *
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function validateLength($object)
    {
	
        /** @var string $attributeCode */
        $gitUrl = $this->getAttribute()->getAttributeCode();
        /** @var int $value */
    
		
		$value = (int)$object->getData($gitUrl);
		
	      /** @var int $maxValueLength */
	
	if(!isset($_POST['git_url']))
	{	
		$value = strlen($_POST['customer']['git_url']);
	}
	else
	{
		$value = strlen($_POST['git_url']);
	}	
        $maxValueLength = $this->getmaxValueLength();

        if ($this->getAttribute()->getIsRequired() && $value >= $maxValueLength) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('The value of Git URL "%1" should not greater than %2', $gitUrl,$maxValueLength)
            );
        }

        return true;
    }
	
	/* Validate URL */
	public function validateUrl($object)
	{
	
	if(!isset($_POST['git_url']))
	{	
		$url = $_POST['customer']['git_url'];
	}
	else
	{
		$url = $_POST['git_url'];
	}	
		//$url = $_POST['customer']['git_url'];
		$url = filter_var($url, FILTER_SANITIZE_URL);

		// Validate url
		if (filter_var($url, FILTER_VALIDATE_URL) !== false) {
			
		} else {
			    throw new \Magento\Framework\Exception\LocalizedException(
                __('The value of Git URL is not valid URL. Please enter valid URL')
            );
		}

	
	}

    /**
     * Get max attribute value length
     * 
     * @return int
     */
    public function getmaxValueLength()
    {
        return $this->maxValueLength;
    }
}
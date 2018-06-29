<?php
namespace Bestresponsemedia\Customers\Helper;

use Magento\Customer\Model\Context;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Framework\App\Http\Context
     */
    protected $_httpContext;
	protected $_customerSession;
    /**
     * @param \Magento\Framework\App\Http\Context $httpContext
     * 
     */
    public function __construct(
        \Magento\Framework\App\Http\Context $httpContext,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,

		\Magento\Customer\Model\Session $customerSession
    ) {
		$this->customerRepositoryInterface = $customerRepositoryInterface;
		$this->resultPageFactory = $resultPageFactory;

        $this->_httpContext = $httpContext;
		$this->_customerSession = $customerSession;
    }

   /* Get customersession */
	public function getCustomerSession() 
    {
		
		$cid = $this->_customerSession->getCustomerId();
	 	$customer =$this->customerRepositoryInterface->getById($cid);
		
		
        return $customer->getCustomAttribute('git_url')->getValue(); 
		        
    }
}
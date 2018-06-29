<?php
 

namespace Bestresponsemedia\Customers\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;

class InstallData implements InstallDataInterface
{

    private $customerSetupFactory;

    /**
     * Constructor
     *
     * @param \Magento\Customer\Setup\CustomerSetupFactory $customerSetupFactory
     */
    public function __construct(
        CustomerSetupFactory $customerSetupFactory
    ) {
        $this->customerSetupFactory = $customerSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'git_url', [
            'type' => 'varchar',
            'label' => 'Git URL',
            'input' => 'text',
			'validate_class' => 'validate-url',
            'source' => '',
            'required' => true,
			'unique' => true,
            'visible' => true,
            'position' => 10,
            'system' => false,
			'backend' => '\Bestresponsemedia\Customers\Model\Attribute\Backend\GitUrl'
        ]);
        
		$git_url   = $customerSetup->getAttribute(\Magento\Customer\Model\Customer::ENTITY, 'git_url');

		
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'git_url')
        ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]
        ]);
        $attribute->save();

    }
}

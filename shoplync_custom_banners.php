<?php
/**
* 2007-2023 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2023 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class Shoplync_custom_banners extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'shoplync_custom_banners';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Shoplync';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Custom Shop Banners');
        $this->description = $this->l('Allows users to manage/enable/disable banners via SMS Pro. This banner will be displayed a the top of the shop');

        $this->confirmUninstall = $this->l('');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('SHOPLYNC_CUSTOM_BANNERS_LIVE_MODE', false);

        include(dirname(__FILE__).'/sql/install.php');

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('displayHeader') &&
            $this->registerHook('displayBackOfficeHeader') &&
            
            $this->registerHook('displayBanner') &&
            $this->registerHook('displayNavFullWidth') &&
            $this->registerHook('displayTop') &&
            $this->registerHook('displayFooterProduct') &&
            $this->registerHook('angarBannersBottom') &&
            $this->registerHook('displayFooter');
    }

    public function uninstall()
    {
        Configuration::deleteByName('SHOPLYNC_CUSTOM_BANNERS_LIVE_MODE');
        include(dirname(__FILE__).'/sql/uninstall.php');
        
        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitShoplync_custom_bannersModule')) == true) {
            $this->postProcess();
        }

        $this->context->smarty->assign('module_dir', $this->_path);
        $this->context->smarty->assign('module_settings', $this->renderForm());

        $bannerPositions = $this->GetBannerPosition();
        if (!empty($bannerPositions))
            $this->context->smarty->assign('banner_positions',$bannerPositions);
        
        //allow users to toggle positions on/off
        //get all banners for each position
        //allow users to create/edit/disable/enable specific banners
        //allow users to mode banners to another section?  

        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');


        return $output;
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitShoplync_custom_bannersModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('Settings'),
                'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Live mode'),
                        'name' => 'SHOPLYNC_CUSTOM_BANNERS_LIVE_MODE',
                        'is_bool' => true,
                        'desc' => $this->l('Use this module in live mode'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return array(
            'SHOPLYNC_CUSTOM_BANNERS_LIVE_MODE' => Configuration::get('SHOPLYNC_CUSTOM_BANNERS_LIVE_MODE', true),
        );
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookBackOfficeHeader()
    {
        if (Tools::getValue('configure') == $this->name) {
            $this->context->controller->addJS($this->_path.'views/js/back.js');
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
        }
    }
    
    
    protected function GetBannerPosition()
    {
        $query = 'SELECT position_id, position_name, description, enabled FROM `' . _DB_PREFIX_ . 'shoplync_banner_position` ORDER BY position_order';
        $banner_positions = Db::getInstance()->executeS($query);
        
        return $banner_positions;
    }
    

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/front.js');
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }
    public function hookDisplayHeader(){}
    

    public function hookDisplayBanner()
    {
        /* Place your code here. */
        $output = $this->context->smarty->fetch($this->local_path.'views/templates/front/default.tpl');

        return $output.'banner';
    }
    
    public function hookDisplayTop()
    {
        /* Place your code here. */
        $output = $this->context->smarty->fetch($this->local_path.'views/templates/front/default.tpl');

        return $output;
    }
    
    public function hookDisplayNavFullWidth()
    {
        $output = $this->context->smarty->fetch($this->local_path.'views/templates/front/default.tpl');

        return $output.'<h1>full width nav banner</h1>';
    }
    
    public function hookAngarBannersBottom()
    {
        $output = $this->context->smarty->fetch($this->local_path.'views/templates/front/default.tpl');

        return $output.'<h1>custom angar!!!</h1>';
    }
    
    public function hookDisplayFooterProduct()
    {
        $output = $this->context->smarty->fetch($this->local_path.'views/templates/front/default.tpl');

        return $output;
    }
    
    public function hookDisplayFooter()
    {
        /* Place your code here. */
        $output = $this->context->smarty->fetch($this->local_path.'views/templates/front/default.tpl');

        return $output;
    }

}

{*
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
*}

<div class="panel">
	<div class="row moduleconfig-header">
		<div class="col-xs-12 mx-auto text-center">
			<img class="mx-auto img-block w-50" src="{$module_dir|escape:'html':'UTF-8'}views/img/admin-banner.jpg" />
		</div>
	</div>

	<hr />

	<div class="moduleconfig-content">
		<div class="row text-center">
			<div class="col-xs-3"></div>
			<div class="col-xs-6">
				<p>
					<h1>{l s='Jumpstart Your Business With SMS Pro' mod='shoplync_sms_pro'}</h1>
					<ul class="ul-spaced mx-auto w-50 text-left">
						<li>{l s='Full invetory management, including automatic re-order' mod='shoplync_sms_pro'}</li>
						<li>{l s='Ability to set scaling pricing models' mod='shoplync_sms_pro'}</li>
						<li>{l s='Full Website Integration' mod='shoplync_sms_pro'}</li>
						<li>{l s='Fully Integrated Paypal Customer Verification' mod='shoplync_sms_pro'}</li>
						<li>{l s='Import/Export Parts List' mod='shoplync_sms_pro'}</li>
						<li>{l s='Built-in invoicing and order management' mod='shoplync_sms_pro'}</li>
					</ul>
				</p>

				<br />

				<p class="text-center">
					<strong>
						<a href="https://www.shoplync.com/" target="_blank" title="Copyright 2023 Shoplync. All Rights Reserved">
							{l s='© Copyright 2023 Shoplync Inc. All Rights Reserved' }
						</a>
					</strong>
				</p>
			</div>
			<div class="col-xs-3"></div>
		</div>
	</div>
</div>

<div class="panel">
	<div class="row moduleconfig-header">
        <div class="col-xs-4"></div>
        <div class="col-xs-2 mx-auto text-right">
			<img class="w-50" src="{$module_dir|escape:'html':'UTF-8'}views/img/logo.png" />
		</div>
		<div class="col-xs-2 text-left">
			<h2>{l s='SMS Banners' mod='shoplync_sku_display'}</h2>
			<h4>{l s='An SMS Pro Add-On' mod='shoplync_sku_display'}</h4>
		</div>
        <div class="col-xs-4"></div>
	</div>

	<hr />

	<div class="moduleconfig-content">
		<div class="row">
            <div class="col-xs-12">
            {$module_settings}
            </div>
        </div>
                    {*if isset($brands) && isset($update_action) && isset($action_link) && isset($token) *}
        {if isset($banner_positions)}
        {foreach from=$banner_positions item=position}
		<div class="row">
            <br>
            <div class="col-xs-2"></div>
            <div class="col-xs-8">
                <div class="accordion-style">
                    <div class="card">
                        <div class="card-header" id="heading-id-{$position.position_id}">
                            <h5 class="mb-0">
                                <button class="btn btn-link btn-block text-decoration-none outline-none display-5 collapsed" style="font-size:31px" data-toggle="collapse" data-target="#collapse-banner-pos-{$position.position_id}" aria-expanded="true" aria-controls="collapse-banner-pos-{$position.position_id}">
                                {$position.position_name}
                                </button>
                            </h5>
                        </div>

                        <div id="collapse-banner-pos-{$position.position_id}" class="collapse" aria-labelledby="heading-id-{$position.position_id}" data-parent="#accordion">
                            <div class="card-body">
                                <p class="text-center">
                                    {$position.description}
                                </p>
                                <hr />   
                                <button class="btn d-block mx-auto text-decoration-none">
                                Create Banner
                                </button>
                                
                                <div class="banner-container">
                                    <div class="banner-object">
                                        <p>asdfasdfasdfasdfasdfasdfasdfasdf</p>
                                        <div class="input-group mb-3">
                                          <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">Position:</label>
                                          </div>
                                          <select class="custom-select" id="inputGroupSelect01">
                                            <option selected>Choose...</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                          </select>
                                        </div>
                                        <div class="input-group mb-3">
                                          <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">Banner Type:</label>
                                          </div>
                                          <select class="custom-select" id="inputGroupSelect01">
                                            <option selected>Choose...</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                          </select>
                                        </div>
                                        <div class="input-group">
                                          <div class="input-group-prepend">
                                            <span class="input-group-text">HTML Code</span>
                                          </div>
                                          <textarea class="form-control" aria-label="With textarea"></textarea>
                                        </div>
                                        <button class="btn text-decoration-none">Save</button>
                                        <button class="btn text-decoration-none">Duplicate Banner</button>
                                        <button class="btn text-decoration-none">Delete Banner</button>
                                    </div>
                                    <div class="banner-object">
                                        <p>asdfasdfasdfasdfasdfasdfasdfasdf</p>
                                        <button class="btn text-decoration-none">Save</button>
                                        <button class="btn text-decoration-none">Duplicate Banner</button>
                                        <button class="btn text-decoration-none">Delete Banner</button>
                                    </div>
                                </div>
                                
                                <button class="btn d-block mx-auto text-decoration-none">
                                Create Banner
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-2"></div>
		</div>            
        {/foreach}
        {/if}
	</div>
</div>



# Mage2 Module Funarbe Colaborador

    ``funarbe/module-colaborador``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [Specifications](#markdown-header-specifications)
 - [Attributes](#markdown-header-attributes)


## Main Functionalities
Seta o grupo Funarbe no cadastro do colaborador

## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the zip file in `app/code/Funarbe`
 - Enable the module by running `php bin/magento module:enable Funarbe_Colaborador`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

 - Make the module available in a composer repository for example:
    - private repository `repo.magento.com`
    - public repository `packagist.org`
    - public github repository as vcs
 - Add the composer repository to the configuration by running `composer config repositories.repo.magento.com composer https://repo.magento.com/`
 - Install the module composer by running `composer require funarbe/module-colaborador`
 - enable the module by running `php bin/magento module:enable Funarbe_Colaborador`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`


## Configuration




## Specifications

 - Observer
	- customer_register_success > Funarbe\Colaborador\Observer\Frontend\Customer\RegisterSuccess


## Attributes




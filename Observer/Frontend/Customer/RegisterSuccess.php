<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Funarbe\Colaborador\Observer\Frontend\Customer;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\App\ResourceConnection;

class RegisterSuccess implements ObserverInterface
{
    protected \Magento\Framework\HTTP\Client\Curl $curlClient;

    public function __construct(
        \Magento\Framework\HTTP\Client\Curl $curl
    ) {
        $this->curlClient = $curl;
    }

    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @throws \Safe\Exceptions\JsonException
     */
    public function execute(Observer $observer): void
    {
        $customer = $observer->getEvent()->getCustomer();
        $cpf = $customer->getTaxvat();
        $response = $this->getIntegratorRmClienteFornecedor($cpf);

        if ($response) {
            $idCustomer = $customer->getId();

            $objectManager = ObjectManager::getInstance();

            $resource = $objectManager->get(ResourceConnection::class);

            $connection = $resource->getConnection();
            $customer_entity = $resource->getTableName('customer_entity');
            $customer_grid_flat = $resource->getTableName('customer_grid_flat');

            $sql = "UPDATE $customer_entity ce JOIN $customer_grid_flat cgf ON ce.entity_id = cgf.entity_id";
            $sql .= " SET ce.group_id = 4, cgf.group_id = 4 WHERE ce.entity_id={$idCustomer} ";

            $connection->query($sql);
        }

    }

    /**
     * @throws \Safe\Exceptions\JsonException
     */
    public function getIntegratorRmClienteFornecedor($cpf)
    {

        $URL = "https://integrator2.funarbe.org.br/rm/cliente-fornecedor/";
        $URL .= "?expand=FUNCIONARIOATIVO&fields=FUNCIONARIOATIVO&filter[CGCCFO]=$cpf";

        $username = 'mestre';
        $password = 'cacg93d7';

        //set curl options
        $this->curlClient->setOption(CURLOPT_USERPWD, $username . ":" . $password);
        $this->curlClient->setOption(CURLOPT_HEADER, 0);
        $this->curlClient->setOption(CURLOPT_TIMEOUT, 60);
        $this->curlClient->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->curlClient->setOption(CURLOPT_CUSTOMREQUEST, 'GET');

        //get request with url
        $this->curlClient->get($URL);

        //read response
        $response = $this->curlClient->getBody();
        $resp = \Safe\json_decode($response, true);
        return $resp['items'][0]['FUNCIONARIOATIVO'];
    }
}

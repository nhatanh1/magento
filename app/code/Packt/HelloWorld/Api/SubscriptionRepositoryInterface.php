<?php

namespace Packt\HelloWorld\Api;

interface SubscriptionRepositoryInterface
{
   /**
    * get subscription by id
    *
    * @param string $sku
    * @param boolean $editMode
    * @param int|null $storeId
    * @param boolean $forceReload
    * @return \PacHelHelloWorld\Api\SubscriptionRepositoryInterface
    * @throws Exception
    */
    public function getById($sub_id);
    
    // /**
    //  * Undocumented function
    //  *
    //  * @param [type] $subscription
    //  * @param boolean $saveOpion
    //  * @return void
    //  */
    // public function save($subscription, $saveOpion = false);

    // /**
    //  * Undocumented function
    //  *
    //  * @param [type] $subscription
    //  * @return void
    //  */
    // public function delete($subscription);
    
    // /**
    //  * Undocumented function
    //  *
    //  * @param [type] $sub_id
    //  * @return void
    //  */
    // public function deleteById($sub_id);


    public function getList();
}
<?php

namespace Packt\HelloWorld\Model;

interface SubscriptionRepositoryInterface
{
    public function getById($id);

    public function getList();
}

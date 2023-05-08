<?php

namespace Opentechiz\Blog\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Opentechiz\Blog\Controller\Comment\Submit;

class CustomSection implements SectionSourceInterface
{
    protected $submit;

    public function __construct(
        Submit $submit
    ) {
        $this->submit = $submit;
    }

    public function getSectionData()
    {
        $i = 1;
        $data = $i++;
        return [
            'customdata' => $data,
        ];
    }
}

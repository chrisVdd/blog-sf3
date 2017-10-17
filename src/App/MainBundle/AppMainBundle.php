<?php

namespace App\MainBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class AppMainBundle
 * @package App\MainBundle
 */
class AppMainBundle extends Bundle
{
    /**
     * @return string
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}

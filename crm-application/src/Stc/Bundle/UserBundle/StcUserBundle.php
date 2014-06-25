<?php

namespace Stc\Bundle\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class StcUserBundle extends Bundle
{
    public function getParent()
    {
        return 'OroUserBundle';
    }
}

<?php

namespace Stc\Bundle\DashboardBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class StcDashboardBundle extends Bundle
{
    public function getParent()
    {
        return 'OroDashboardBundle';
    }
}
<?php

namespace Sunshine\AdminBundle\DataFixtures\ORM;

use Hautelook\AliceBundle\Doctrine\DataFixtures\AbstractLoader;

class AdminFixtures extends AbstractLoader
{
    public function getFixtures()
    {
        return [
            __DIR__ . '/zh_CN/admin.yml',
        ];
    }
}
<?php

namespace Sunshine\OrganizationBundle\DataFixtures\ORM;

use Hautelook\AliceBundle\Doctrine\DataFixtures\AbstractLoader;

class OrganizationFixtures extends AbstractLoader
{
    public function getFixtures()
    {
        return [
            __DIR__ . '/zh_CN/organization.yml',
        ];
    }
}
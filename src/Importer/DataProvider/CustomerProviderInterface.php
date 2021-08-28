<?php

declare(strict_types=1);

namespace App\Importer\DataProvider;

use App\Importer\CustomerModel;

interface CustomerProviderInterface
{
    /**
     * @return CustomerModel[]
     */
    public function fetch(int $limit, string $nationality): array;
}

<?php

declare(strict_types=1);

namespace App\Importer\DataProvider;

use App\Importer\CustomerModel;
use App\Importer\Nationality;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class RandomuserProvider implements CustomerProviderInterface
{
    private const URL = 'https://randomuser.me/api/';

    public function __construct(
        private HttpClientInterface $httpClient
    ) {
    }

    public function fetch(int $limit, string $nationality): array
    {
        $data = $this->httpClient->request('GET', self::URL, [
            'query' => [
                'nat' => $this->convertNationality($nationality),
                'results' => $limit,
            ],
        ])->toArray();

        $customers = [];
        foreach ($data['results'] as $item) {
            $customers[] = $this->createModel($item);
        }

        return $customers;
    }

    /**
     * @param mixed[] $data
     */
    private function createModel(array $data): CustomerModel
    {
        $model = new CustomerModel();
        $model->phone = $data['phone'];
        $model->email = $data['email'];
        $model->country = $data['location']['country'];
        $model->gender = $data['gender'];
        $model->lastname = $data['name']['last'];
        $model->firstname = $data['name']['first'];
        $model->city = $data['location']['city'];
        $model->username = $data['login']['username'];

        return $model;
    }

    private function convertNationality(string $nationality): string
    {
        // TODO
        return match ($nationality) {
            Nationality::AU => 'au',
            default => ''
        };
    }
}

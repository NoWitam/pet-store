<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;

class PetService
{
    public string $url = "https://petstore.swagger.io/v2/pet";

    public function list($statuses)
    {
        return Http::get($this->url . "/findByStatus?status=" . implode("&status=", $statuses));
    }

    public function delete(int $id)
    {
        return Http::delete($this->url . "/". $id);
    }

    public function create(array $data)
    {
        $digits = 19;

        return Http::post($this->url, [
            "id" => random_int((int) 10 ** $digits, (int) 10 ** ($digits+1) - 1),
            "name" => $data['name'],
            "photoUrls" => $data["photos"],
            "status" => $data['status'],
            "category" => [
                "name" => $data["category"],
            ],
            "tags" => isset($data['tags']) ? array_map(
                fn($tag) => ["name" => $tag],
                $data['tags']
            ) : null
        ]);
    }

    public function update(int $id, array $data)
    {
        return Http::put($this->url, [
            "id" => $id,
            "name" => $data['name'],
            "photoUrls" => $data["photos"],
            "status" => $data['status'],
            "category" => [
                "name" => $data["category"],
            ],
            "tags" => isset($data['tags']) ? array_map(
                fn($tag) => ["name" => $tag],
                $data['tags']
            ) : null
        ]);
    }

    public function find(int $id)
    {
        return Http::get($this->url . "/" . $id);
    }

}
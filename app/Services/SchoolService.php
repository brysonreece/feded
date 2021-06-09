<?php

namespace App\Services;

use App\Models\School;

class SchoolService
{
    public function query()
    {
        return School::query();
    }

    public function all()
    {
        return $this->query()->all();
    }

    public function locale(int $locale)
    {
        return $this->query()->whereLocale($locale)->get();
    }

    public function search(string $input)
    {
        return School::search($input)->get();
    }
}

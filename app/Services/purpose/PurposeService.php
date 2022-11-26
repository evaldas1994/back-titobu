<?php

namespace App\Services\purpose;

use App\Services\Service;
use App\Models\Purpose;

class PurposeService extends Service
{
    public function store(array $validated): Purpose
    {
        return Purpose::create($validated);
    }

    public function update(Purpose $purpose, array $validated): Purpose
    {
        $purpose->update($validated);

        return $purpose;
    }

    public function delete(Purpose $purpose): void
    {
        $purpose->delete();
    }
}

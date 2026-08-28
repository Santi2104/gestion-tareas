<?php

namespace App\Services;

use App\Models\Priority;
use Illuminate\Database\Eloquent\Collection;

class PriorityService
{
    /**
     * @return Collection<int, Priority>
     */
    public function getAll(): Collection
    {
        return Priority::all();
    }
}

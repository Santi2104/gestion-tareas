<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PriorityResource;
use App\Services\PriorityService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PriorityController extends Controller
{
    public function __construct(
        protected PriorityService $priorityService
    ) {}

    public function index(): AnonymousResourceCollection
    {
        return PriorityResource::collection($this->priorityService->getAll());
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Services\TagService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TagController extends Controller
{
    public function __construct(
        protected TagService $tagService
    ) {}

    public function index(): AnonymousResourceCollection
    {
        return TagResource::collection($this->tagService->getAll());
    }
}

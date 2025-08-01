<?php

namespace Modules\KnowledgeBase\Http\Services;

use Modules\Auto\Models\Brand;
use Modules\Auto\Models\ModelAuto;
use Modules\Auto\Models\Modification;
use Modules\KnowledgeBase\Models\Instruction;
use Modules\KnowledgeBase\Models\Problem;
use Modules\Posts\Models\Post;

class KnowledgeService
{
    public function getKnowledgeData(array $filters): array
    {
        $brands        = $this->getBrands();
        $models        = $this->getModels($filters['brand_id'] ?? null);
        $modifications = $this->getModifications($filters['model_id'] ?? null);

        $header = $this->buildHeader($filters);

        [$problems, $instructions] = $this->loadKnowledge($filters, $modifications);
        $posts                     = $this->getPosts($filters);

        return compact(
            'brands',
            'models',
            'modifications',
            'problems',
            'instructions',
            'posts',
            'header'
        );
    }

    private function getBrands()
    {
        return Brand::select('id', 'name')->get();
    }

    private function getModels($brandId)
    {
        if (!$brandId) return [];
        return ModelAuto::where('brand_id', $brandId)->select('id', 'name')->get();
    }

    private function getModifications($modelId)
    {
        if (!$modelId) return [];
        return Modification::where('model_id', $modelId)->select('id', 'name')->get();
    }

    private function buildHeader(array $filters): string
    {
        $brandId        = $filters['brand_id'] ?? null;
        $modelId        = $filters['model_id'] ?? null;
        $modificationId = $filters['modification_id'] ?? null;

        $brandName        = $brandId ? Brand::find($brandId)?->name : '';
        $modelName        = $modelId ? ModelAuto::find($modelId)?->name : '';
        $modificationName = $modificationId ? Modification::find($modificationId)?->name : '';

        return collect([$brandName, $modelName, $modificationName])
            ->filter()
            ->implode(' / ');
    }

    private function loadKnowledge(array $filters, $modifications): array
    {
        if (empty($filters['model_id'])) {
            return [[], []];
        }

        $modificationIds = $filters['modification_id'] ?? $modifications->pluck('id')->toArray();

        $problems     = Problem::with(['solutions', 'sources'])
            ->whereHas('modifications', fn ($q) => $q->whereIn('modification_id', $modificationIds));

        $instructions = Instruction::with('source')
            ->whereHas('modifications', fn ($q) => $q->whereIn('modification_id', $modificationIds));

        /*
        if ($filters['part'] ?? false) {
            $problems->whereHas('tags', fn($q) =>
                $q->where('name', 'like', '%' . $filters['part'] . '%'));
            $instructions->whereHas('tags', fn($q) =>
                $q->where('name', 'like', '%' . $filters['part'] . '%'));
        }
        */

        return [$problems->get(), $instructions->get()];
    }

    private function getPosts(array $filters)
    {
        if (array_filter($filters)) {
            return [];
        }

        return Post::with('tags')->latest()->take(5)->get();
    }
}

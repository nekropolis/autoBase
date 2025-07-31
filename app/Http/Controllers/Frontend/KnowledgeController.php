<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Auto\Models\Brand;
use Modules\Auto\Models\ModelAuto;
use Modules\Auto\Models\Modification;
use Modules\KnowledgeBase\Models\Instruction;
use Modules\KnowledgeBase\Models\Problem;

class KnowledgeController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only('brand_id', 'model_id', 'modification_id', 'search_type', 'part');

        $brands = Brand::select('id', 'name')->get();

        $models = [];
        if ($filters['brand_id'] ?? false) {
            $models = ModelAuto::where('brand_id', $filters['brand_id'])->select('id', 'name')->get();
        }

        $modifications = [];
        if ($filters['model_id'] ?? false) {
            $modifications = Modification::where('model_id', $filters['model_id'])->select('id', 'name')->get();
        }

        $problems = null;
        $instructions = null;

        if (($filters['model_id'] ?? false)) {
            $problems = Problem::query()->with(['solutions', 'sources']);
            $instructions = Instruction::query()->with(['source']);
            $modificationIds = (array) $filters['modification_id'];

            if ($modificationIds == null) {
                $modificationIds = $modifications->pluck('id')->toArray();
            }

            $problems->whereHas('modifications', fn($q) =>
            $q->whereIn('modification_id', $modificationIds)
            );
            $instructions->whereHas('modifications', fn($q) =>
            $q->whereIn('modification_id', $modificationIds)
            );
        }

       /* if ($filters['part'] ?? false) {
            $problems->whereHas('tags', fn($q) =>
            $q->where('name', 'like', '%' . $filters['part'] . '%')
            );
            $instructions->whereHas('tags', fn($q) =>
            $q->where('name', 'like', '%' . $filters['part'] . '%')
            );
        }*/

        return Inertia::render('dashboard', [
            'filters' => $filters,
            'brands' => $brands,
            'models' => $models,
            'modifications' => $modifications,
            'problems' => $problems != null ? $problems->get() : [],
            'instructions' => $instructions != null ? $instructions->get() : [],
        ]);
    }
}

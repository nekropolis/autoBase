<?php

namespace Modules\KnowledgeBase\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\KnowledgeBase\Http\Services\KnowledgeService;

class KnowledgeController extends Controller
{
    public function index(Request $request, KnowledgeService $service)
    {
        $filters = $request->only('brand_id', 'model_id', 'modification_id', 'search_type', 'part');
        $data    = $service->getKnowledgeData($filters);

        return Inertia::render('dashboard', [
            'filters'       => array_merge($filters, ['header' => $data['header']]),
            'brands'        => $data['brands'],
            'models'        => $data['models'],
            'modifications' => $data['modifications'],
            'problems'      => $data['problems'],
            'instructions'  => $data['instructions'],
            'posts'         => $data['posts'],
        ]);
    }
}

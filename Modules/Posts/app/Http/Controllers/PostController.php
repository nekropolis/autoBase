<?php

namespace Modules\Posts\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Modules\Posts\Models\Post;

class PostController extends Controller
{
    public function show(string $slug)
    {
        $post = Post::with('tags')->where('slug', $slug)->firstOrFail();

        return Inertia::render('Posts/PostShow', [
            'post' => $post,
        ]);
    }
}

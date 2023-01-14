<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __invoke(
        Request $request,
    ) {
        $posts = Post::query()
            ->withCount('likes', 'comments') // likes_count comments_count
            ->filters(
                sortBy: $request->sortBy,
                direction: $request->direction,
            )
            ->latest()
            ->paginate(25);

        return view(
            view: 'welcome',
            data: ['posts' => $posts],
        );
    }
}

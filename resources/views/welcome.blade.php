<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        @vite('resources/css/app.css')
    </head>
    <body>
    @include('navbar')
    <section class="antialiased text-gray-600 px-4">
        <div class="flex flex-col justify-center h-full mt-10">
            <!-- Table -->
            <div class="w-full max-w-7xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
                <header class="px-5 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-gray-800">Articles</h2>
                </header>
                <div class="p-3">
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full">
                            <thead class="text-xs font-semibold uppercase text-gray-400">
                            <tr>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">
                                        <a href="?page={{ $posts->currentPage() }}&sortBy=title&direction={{ request('direction') === 'desc' ? 'asc' : 'desc' }}">
                                            Titre
                                        </a>
                                    </div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">
                                        <a href="?page={{ $posts->currentPage() }}&sortBy=status&direction={{ request('direction') === 'desc' ? 'asc' : 'desc' }}">
                                            Statut
                                        </a>
                                    </div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">
                                        <a href="?page={{ $posts->currentPage() }}&sortBy=analysis&direction={{ request('direction') === 'desc' ? 'asc' : 'desc' }}">
                                            Analyse
                                        </a>
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-100">
                                @foreach($posts as $post)
                                    <tr>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="font-medium text-gray-800">
                                                    {{ $post->title }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-left">
                                                <span class="bg-{{ $post->status->color() }}-100 text-{{ $post->status->color() }}-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-{{ $post->status->color() }}-900 dark:text-{{ $post->status->color() }}-300">{{ $post->status }}</span>
                                            </div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-left font-medium text-blue-500">{{ $post->likes_count }} "J'aime"</div>
                                            <div class="text-left font-medium text-yellow-500">{{ $post->comments_count }} commentaires</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
    </body>
</html>

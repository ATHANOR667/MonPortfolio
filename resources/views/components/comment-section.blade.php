<!-- Formulaire de commentaire -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8 transition-all duration-300">
    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Laisser un commentaire</h3>
    
    @if (session('comment_status'))
        <div class="bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 p-4 rounded-md mb-6">
            {{ session('comment_status') }}
        </div>
    @endif
    
    <form action="{{ route('comments.store', $project) }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email *</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('email') border-red-500 @enderror">
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Votre email ne sera pas publié</p>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mb-6">
            <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Site web (optionnel)</label>
            <input type="url" id="website" name="website" value="{{ old('website') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('website') border-red-500 @enderror">
            @error('website')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Commentaire *</label>
            <textarea id="content" name="content" rows="4" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('content') border-red-500 @enderror">{{ old('content') }}</textarea>
            @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-300">
                Envoyer le commentaire
            </button>
        </div>
        
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-4">
            * Les commentaires sont modérés avant publication. Veuillez rester courtois et respectueux.
        </p>
    </form>
</div>

<!-- Liste des commentaires approuvés -->
@if($approvedComments->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 transition-all duration-300">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">{{ $approvedComments->count() }} Commentaire(s)</h3>
        
        <div class="space-y-6">
            @foreach($approvedComments as $comment)
                <div class="flex space-x-4">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center">
                            <span class="text-primary-700 dark:text-primary-300 font-medium">{{ substr($comment->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <div class="flex-grow">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ $comment->name }}</h4>
                                @if($comment->website)
                                    <a href="{{ $comment->website }}" target="_blank" rel="noopener noreferrer" class="text-xs text-primary-600 dark:text-primary-400 hover:underline">{{ parse_url($comment->website, PHP_URL_HOST) }}</a>
                                @endif
                            </div>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                            {{ $comment->content }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@else
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 text-center transition-all duration-300">
        <p class="text-gray-500 dark:text-gray-400">Aucun commentaire pour le moment. Soyez le premier à commenter !</p>
    </div>
@endif

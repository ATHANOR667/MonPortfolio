@extends('layouts.admin')

@section('title', 'Détail du message')

@section('admin-content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('admin.contacts.index') }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à la liste des messages
            </a>
        </div>

        @if (session('status'))
            <div class="bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 p-4 rounded-md mb-6">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 p-4 rounded-md mb-6">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 sm:p-6 transition-all duration-300">
            <div class="flex flex-col sm:flex-row justify-between items-start mb-6 gap-4">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white truncate max-w-full">{{ $contact->subject }}</h2>
                <div class="flex flex-wrap gap-2">
                    @if($contact->is_read)
                        <form action="{{ route('admin.contacts.mark-as-unread', $contact) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="py-1 px-2 sm:px-3 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors duration-300">
                                Marquer comme non lu
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.contacts.mark-as-read', $contact) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="py-1 px-2 sm:px-3 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 hover:bg-green-200 dark:hover:bg-green-800 transition-colors duration-300">
                                Marquer comme lu
                            </button>
                        </form>
                    @endif
                    <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="py-1 px-2 sm:px-3 text-xs rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 hover:bg-red-200 dark:hover:bg-red-800 transition-colors duration-300">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Expéditeur</h3>
                    <p class="text-base text-gray-900 dark:text-white truncate max-w-full">{{ $contact->name }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Email</h3>
                    <p class="text-base text-gray-900 dark:text-white truncate max-w-full">
                        <a href="mailto:{{ $contact->email }}" class="text-primary-600 dark:text-primary-400 hover:underline">{{ $contact->email }}</a>
                    </p>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Date</h3>
                <p class="text-base text-gray-900 dark:text-white">{{ $contact->created_at->format('d/m/Y H:i') }}</p>
            </div>

            @if($contact->attachment)
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Pièce jointe</h3>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                        </svg>
                        <a href="{{ Storage::url($contact->attachment) }}" target="_blank" class="text-primary-600 dark:text-primary-400 hover:underline truncate max-w-[90%]">
                            {{ Str::limit($contact->attachment_name ?? 'Pièce jointe', 30) }}
                        </a>
                    </div>
                </div>
            @endif

            <div class="mb-6">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Message</h3>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-md p-4 mt-2 max-w-full overflow-x-auto">
                    <p class="text-base text-gray-900 dark:text-white whitespace-pre-wrap break-words">{{ $contact->message }}</p>
                </div>
            </div>

            <!-- Historique des réponses -->
            @if(isset($replies) && $replies->count() > 0)
                <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Historique des réponses</h3>

                    @foreach($replies as $reply)
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-md p-4 mb-4">
                            <div class="flex justify-between items-start mb-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400 truncate max-w-[90%]">
                                    Répondu par {{ $reply->user->name }} le {{ $reply->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                            <div class="text-base text-gray-900 dark:text-white whitespace-pre-wrap break-words max-w-full overflow-x-auto">
                                {{ $reply->message }}
                            </div>

                            @if($reply->attachment)
                                <div class="mt-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                    </svg>
                                    <a href="{{ Storage::url($reply->attachment) }}" target="_blank" class="text-primary-600 dark:text-primary-400 hover:underline truncate max-w-[90%]">
                                        {{ Str::limit($reply->attachment_name ?? 'Pièce jointe', 30) }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Formulaire de réponse -->
            <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Répondre</h3>

                <form action="{{ route('admin.contacts.reply', $contact) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Votre réponse</label>
                        <textarea id="message" name="message" rows="4" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                        @error('message')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="attachment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pièce jointe (optionnelle)</label>
                        <input type="file" id="attachment" name="attachment" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('attachment') border-red-500 @enderror">
                        @error('attachment')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <button type="submit" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-300">
                            Envoyer la réponse
                        </button>

                        <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="inline-flex items-center py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Répondre par email
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
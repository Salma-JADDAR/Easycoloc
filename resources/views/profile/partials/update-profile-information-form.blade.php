<div class="space-y-6">
    <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
        @csrf
        @method('patch')
        
        <div>
            <label class="block text-sm font-medium text-gray-700">Nom</label>
            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
            @error('name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
            @error('email')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700">Rôle</label>
            <div class="px-4 py-2 bg-gray-100 rounded-lg">
                {{ auth()->user()->role === 'admin' ? 'Administrateur' : 'Membre' }}
            </div>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700">Réputation</label>
            <div class="px-4 py-2 bg-gray-100 rounded-lg">
                {{ auth()->user()->reputation }} XP
            </div>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700">Statut</label>
            <div class="px-4 py-2 bg-gray-100 rounded-lg">
                @if(auth()->user()->estBanni())
                    <span class="text-red-600">Banni</span>
                @else
                    <span class="text-green-600">Actif</span>
                @endif
            </div>
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg">
                Enregistrer
            </button>
        </div>
    </form>
</div>
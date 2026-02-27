<div class="space-y-6">
    <form method="post" action="{{ route('password.update') }}" class="space-y-4">
        @csrf
        @method('put')
        
        <div>
            <label class="block text-sm font-medium text-gray-700">Mot de passe actuel</label>
            <input type="password" name="current_password" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
            @error('current_password', 'updatePassword')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
            <input type="password" name="password" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
            @error('password', 'updatePassword')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700">Confirmer</label>
            <input type="password" name="password_confirmation" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg">
                Mettre à jour le mot de passe
            </button>
        </div>
    </form>
</div>
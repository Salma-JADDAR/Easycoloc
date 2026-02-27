<div class="space-y-4">
    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
        <p class="text-sm text-red-800">
            <strong>Attention :</strong> Cette action est irréversible.
        </p>
    </div>
    
    <form method="post" action="{{ route('profile.destroy') }}">
        @csrf
        @method('delete')
        
        <div>
            <label class="block text-sm font-medium text-gray-700">Mot de passe</label>
            <input type="password" name="password" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
            @error('password', 'userDeletion')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="flex justify-end mt-4">
            <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ?')">
                Supprimer mon compte
            </button>
        </div>
    </form>
</div>
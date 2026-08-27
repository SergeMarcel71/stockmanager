@if ($errors->any())
    <div class="mb-4 text-sm text-red-600">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<div>
    <label class="block text-sm font-medium mb-1">Nom du dépôt</label>
    <input type="text" name="nom" value="{{ old('nom', $depot->nom ?? '') }}" required
           placeholder="Ex : Dépôt Ouagadougou"
           class="w-full border rounded px-3 py-2">
</div>

<div>
    <label class="block text-sm font-medium mb-1">Adresse (optionnel)</label>
    <input type="text" name="adresse" value="{{ old('adresse', $depot->adresse ?? '') }}"
           class="w-full border rounded px-3 py-2">
</div>

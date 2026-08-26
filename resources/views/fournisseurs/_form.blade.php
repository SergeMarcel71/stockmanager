@if ($errors->any())
    <div class="mb-4 text-sm text-red-600">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<div>
    <label class="block text-sm font-medium mb-1">Nom</label>
    <input type="text" name="nom" value="{{ old('nom', $fournisseur->nom ?? '') }}" required
           class="w-full border rounded px-3 py-2">
</div>

<div>
    <label class="block text-sm font-medium mb-1">Contact</label>
    <input type="text" name="contact" value="{{ old('contact', $fournisseur->contact ?? '') }}"
           class="w-full border rounded px-3 py-2">
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email', $fournisseur->email ?? '') }}"
               class="w-full border rounded px-3 py-2">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Téléphone</label>
        <input type="text" name="telephone" value="{{ old('telephone', $fournisseur->telephone ?? '') }}"
               class="w-full border rounded px-3 py-2">
    </div>
</div>

<div>
    <label class="block text-sm font-medium mb-1">Délai de livraison moyen (jours)</label>
    <input type="number" min="0" name="delai_livraison_jours"
           value="{{ old('delai_livraison_jours', $fournisseur->delai_livraison_jours ?? 7) }}" required
           class="w-full border rounded px-3 py-2">
</div>

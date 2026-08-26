@if ($errors->any())
    <div class="mb-4 text-sm text-red-600">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<div>
    <label class="block text-sm font-medium mb-1">Nom</label>
    <input type="text" name="nom" value="{{ old('nom', $produit->nom ?? '') }}" required
           class="w-full border rounded px-3 py-2">
</div>

<div>
    <label class="block text-sm font-medium mb-1">SKU (référence unique)</label>
    <input type="text" name="sku" value="{{ old('sku', $produit->sku ?? '') }}" required
           class="w-full border rounded px-3 py-2">
</div>

<div>
    <label class="block text-sm font-medium mb-1">Description</label>
    <textarea name="description" rows="3"
              class="w-full border rounded px-3 py-2">{{ old('description', $produit->description ?? '') }}</textarea>
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium mb-1">Catégorie</label>
        <select name="categorie_id" class="w-full border rounded px-3 py-2">
            <option value="">— Aucune —</option>
            @foreach ($categories as $categorie)
                <option value="{{ $categorie->id }}"
                    @selected(old('categorie_id', $produit->categorie_id ?? '') == $categorie->id)>
                    {{ $categorie->nom }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Fournisseur</label>
        <select name="fournisseur_id" class="w-full border rounded px-3 py-2">
            <option value="">— Aucun —</option>
            @foreach ($fournisseurs as $fournisseur)
                <option value="{{ $fournisseur->id }}"
                    @selected(old('fournisseur_id', $produit->fournisseur_id ?? '') == $fournisseur->id)>
                    {{ $fournisseur->nom }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="grid grid-cols-3 gap-4">
    <div>
        <label class="block text-sm font-medium mb-1">Prix unitaire (€)</label>
        <input type="number" step="0.01" min="0" name="prix_unitaire"
               value="{{ old('prix_unitaire', $produit->prix_unitaire ?? '') }}" required
               class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Quantité en stock</label>
        <input type="number" min="0" name="quantite_stock"
               value="{{ old('quantite_stock', $produit->quantite_stock ?? 0) }}" required
               class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Seuil d'alerte</label>
        <input type="number" min="0" name="seuil_alerte"
               value="{{ old('seuil_alerte', $produit->seuil_alerte ?? 5) }}" required
               class="w-full border rounded px-3 py-2">
    </div>
</div>

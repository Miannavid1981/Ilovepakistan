@foreach ($children as $child)
    <div class="category-item">
        <label>
            <input type="checkbox" name="categories[]" value="{{ $child->id }}" 
                   {{ in_array($child->id, $selectedCategories) ? 'checked' : '' }}
                   class="category-checkbox">
            {{ $child->name }}
        </label>
        @if ($child->childrenCategories->count() > 0)
            <div class="children">
                @include('seller.profile.partials.category-children', ['children' => $child->childrenCategories, 'selectedCategories' => $selectedCategories])
            </div>
        @endif
    </div>
@endforeach

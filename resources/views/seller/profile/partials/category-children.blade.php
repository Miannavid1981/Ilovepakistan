@foreach ($children as $child)
    <div class="category-item">
        <label>
            <input type="checkbox" name="categories[]" value="{{ $child->id }}" 
                   {{ in_array($child->id, $selectedCategories) ? 'checked' : '' }}
                   class="category-checkbox">
            {{ $child->name }}
        </label>
        @if ($child->children->count())
            <div class="children">
                @include('partials.category-children', ['children' => $child->children, 'selectedCategories' => $selectedCategories])
            </div>
        @endif
    </div>
@endforeach

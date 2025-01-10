@php
    $indentation = str_repeat('-', $child_category->level ?? 0);
@endphp

<li>
    <label>
        <input type="radio" name="category_id" value="{{ $child_category->id }}"> {{ $indentation }}{{ $child_category->name }}
    </label>
    @if ($child_category->childrenCategories)
        <ul>
            @foreach ($child_category->childrenCategories as $childCategory)
                @include('backend.product.products.child_category', ['child_category' => $childCategory])
            @endforeach
        </ul>
    @endif
</li>

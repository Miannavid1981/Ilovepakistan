@if ($products->hasPages())
    <nav>
        <ul class="pagination justify-content-center">
            {{ $products->links() }}
        </ul>
    </nav>
@endif

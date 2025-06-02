<div class="card p-3 border">
    <h5>{{ $method->title }}</h5>
    <p><strong>Account Title:</strong> {{ $method->account_title }}</p>
    <p><strong>Account No:</strong> {{ $method->account_no }}</p>
    <p><strong>IBAN:</strong> {{ $method->iban }}</p>
    @if($method->image)
        <img src="{{ asset('storage/' . $method->image) }}" alt="{{ $method->title }}" style="max-width: 100px;">
    @endif
</div>

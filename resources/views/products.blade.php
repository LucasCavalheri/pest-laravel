
<ul>
    <li>Produto A</li>
    <li>Produto B</li>
    @foreach($products as $product)
        <li>{{ $product->title }}</li>
    @endforeach
</ul>

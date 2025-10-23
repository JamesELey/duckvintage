@extends('layouts.app')

@section('title', $product->name . ' - Duck Vintage')

@section('content')
<div class="container">
    <div class="grid grid-2" style="gap: 3rem;">
        <!-- Product Images -->
        <div>
            @if($product->images && count($product->images) > 0)
                <div style="margin-bottom: 1rem;">
                    <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" style="width: 100%; height: 400px; object-fit: cover; border-radius: 8px;">
                </div>
                @if(count($product->images) > 1)
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        @foreach($product->images as $image)
                            <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; cursor: pointer;" onclick="changeMainImage(this.src)">
                        @endforeach
                    </div>
                @endif
            @else
                <div style="width: 100%; height: 400px; background-color: #333; display: flex; align-items: center; justify-content: center; color: #FFD700; border-radius: 8px;">
                    No Image Available
                </div>
            @endif
        </div>

        <!-- Product Details -->
        <div>
            <h1 style="font-size: 2rem; margin-bottom: 1rem;">{{ $product->name }}</h1>
            <p style="color: #CCC; margin-bottom: 1rem;">{{ $product->category->name }}</p>
            
            <div style="margin-bottom: 1rem;">
                @if($product->sale_price)
                    <span style="font-size: 1.5rem; color: #FF6B6B; text-decoration: line-through; margin-right: 0.5rem;">${{ number_format($product->price, 2) }}</span>
                    <span style="font-size: 2rem; font-weight: bold; color: #FFD700;">${{ number_format($product->sale_price, 2) }}</span>
                    <span style="color: #FF6B6B; margin-left: 0.5rem;">{{ $product->discount_percentage }}% OFF</span>
                @else
                    <span style="font-size: 2rem; font-weight: bold; color: #FFD700;">${{ number_format($product->price, 2) }}</span>
                @endif
            </div>

            <div style="margin-bottom: 2rem;">
                <p>{{ $product->description }}</p>
            </div>

            @if($product->stock_quantity > 0)
                <form method="POST" action="{{ route('cart.add') }}" style="margin-bottom: 2rem;">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <div class="form-group">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" class="form-control" style="width: 100px;">
                    </div>

                    @if($product->sizes && count($product->sizes) > 0)
                        <div class="form-group">
                            <label class="form-label">Size</label>
                            <select name="size" class="form-control" style="width: 150px;">
                                <option value="">Select Size</option>
                                @foreach($product->sizes as $size)
                                    <option value="{{ $size }}">{{ $size }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    @if($product->colors && count($product->colors) > 0)
                        <div class="form-group">
                            <label class="form-label">Color</label>
                            <select name="color" class="form-control" style="width: 150px;">
                                <option value="">Select Color</option>
                                @foreach($product->colors as $color)
                                    <option value="{{ $color }}">{{ $color }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <button type="submit" class="btn" style="font-size: 1.1rem; padding: 1rem 2rem;">Add to Cart</button>
                </form>
            @else
                <div style="padding: 1rem; background-color: #4d1a1a; border: 1px solid #7a2d2d; border-radius: 4px; margin-bottom: 2rem;">
                    <p style="color: #FFB6C1; margin: 0;">This product is currently out of stock.</p>
                </div>
            @endif

            <div style="border-top: 1px solid #333; padding-top: 1rem;">
                <p style="color: #CCC; margin-bottom: 0.5rem;"><strong>SKU:</strong> {{ $product->sku }}</p>
                <p style="color: #CCC;"><strong>Stock:</strong> {{ $product->stock_quantity }} available</p>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div style="margin-top: 4rem;">
            <h2 style="margin-bottom: 2rem;">Related Products</h2>
            <div class="grid grid-4">
                @foreach($relatedProducts as $relatedProduct)
                <div class="product-card">
                    <a href="{{ route('products.show', $relatedProduct) }}" style="text-decoration: none; color: inherit;">
                        @if($relatedProduct->images && count($relatedProduct->images) > 0)
                            <img src="{{ asset('storage/' . $relatedProduct->images[0]) }}" alt="{{ $relatedProduct->name }}" class="product-image">
                        @else
                            <div class="product-image" style="background-color: #333; display: flex; align-items: center; justify-content: center; color: #FFD700;">
                                No Image
                            </div>
                        @endif
                        <div class="product-info">
                            <h3 class="product-title">{{ $relatedProduct->name }}</h3>
                            <div class="product-price">
                                @if($relatedProduct->sale_price)
                                    <span class="product-sale-price">${{ number_format($relatedProduct->price, 2) }}</span>
                                    ${{ number_format($relatedProduct->sale_price, 2) }}
                                @else
                                    ${{ number_format($relatedProduct->price, 2) }}
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
function changeMainImage(src) {
    document.querySelector('.product-image').src = src;
}
</script>
@endsection



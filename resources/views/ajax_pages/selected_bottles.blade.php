@if($images)
    @foreach( $images as $key => $image )
        <div class="product">
            <div class="product_image">
                <img alt="" data-id="{{ $image->id }}" src="{{ route('bottle',  $image->image) }}">
            </div>
        </div>
    @endforeach
@else
    <p class="text-muted"><b>Not found any bottles</b></p>
@endif
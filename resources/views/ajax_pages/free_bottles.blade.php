@if($bottles)
<div class="row gx-3 mb-3 mt-5">
    @foreach( $bottles as $name => $ids )
        <h5 class="mb-3">Please choose one product from this section:</h5>
        <!-- <h5 class="mb-3">For `{{$name}}`, you are eligible for</h5> -->
        @foreach( $ids as $bottle )
            <div class="col mb-3">
                <div class="product product_free_bottle" data-id="{{ $bottle->id }}" data-variant="{{ $bottle->variant_id }}">
                    <div class="product_image">
                        {{-- <img alt="" src="{{asset('images/glucosamine-chondroitin_300x')}}.png"> --}}
                        <img alt="" src="{{ route('bottle', $bottle->image) }}">
                    </div>
                    <p class="product-title">{{$bottle->name}}</p>
                </div>
            </div>
        @endforeach
    @endforeach
</div>
@else
<p class="text-muted"><b>Not found any results</b></p>
@endif

<script>
    highlighted_class = 'selected-product';
    bottle_ids = [];
    variant_ids = [];
    
    $('.product_free_bottle').click(function(e) {
        e.preventDefault();
        count_highlighted = $('.' + highlighted_class).length;

        if (bottle_ids.includes($(this).data('id'))) {
            removeBottle($(this))
        } else if (count_highlighted == bottles_to_qualify) {
            let id = bottle_ids[bottle_ids.length - 1];
            let var_id = bottle_ids[variant_ids.length - 1];
            let prev_sel_ele = $('.free-bottles').find(`[data-id=${id}]`);
            prev_sel_ele.removeClass(highlighted_class)
            bottle_ids.splice(bottle_ids.indexOf(id), 1);
            variant_ids.splice(variant_ids.indexOf(var_id), 1);
            addBottle($(this))
        } else if (count_highlighted < bottles_to_qualify) {
            // remove_all.removeClass(highlighted_class);
            addBottle($(this))
        }
    })

    /** remove bottle class and its values */
    function removeBottle(element) {
        element.removeClass(highlighted_class);
        bottle_ids.splice(bottle_ids.indexOf(element.data('id')), 1);
        variant_ids.splice(variant_ids.indexOf(element.data('variant')), 1);
    }

    /** add bottle class and its values */
    function addBottle(element) {
        element.addClass(highlighted_class);
        bottle_ids.push(element.data('id'));
        variant_ids.push(element.data('variant'));
    }
</script>
<div class="modal-body p-3 c-scrollbar-light">
    <section class="mb-4 pt-3">
        <div class="container">
            <div class="bg-white py-3">
                <div class="row">
                    <!-- Product Image Gallery -->
                    <div class="col-xl-4 col-lg-6 mb-4">
                        @include('frontend.product_details.image_gallery')
                    </div>

                    <!-- Product Details -->
                    <div class="col-xl-8 col-lg-6">
                        @include('frontend.product_details.details')
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    $('#option-choice-form input').on('change', function () {
        getVariantPrice();
    });
</script>

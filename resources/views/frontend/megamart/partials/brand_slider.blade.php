    
<style>
    h2 {
        text-align: center;
        padding: 20px;
        text-transform: uppercase;
    }
    b {
        color: red;
    }
    .brand-logos-slider .slick-slide {
        margin: 0px 20px;
        height: 80px;
    }
    .brand-logos-slider  .slick-slide img {
        width: 100%;
    }
    .brand-logos-slider {
        max-height: 150px; /* Adjust the height as needed */
        overflow: hidden; /* Ensures no extra spacing */
    }   

    .brand-logos-slider .slide img {
        object-fit: contain;
        width: auto;
        height: 100%;
        max-width: 100px;
    }
</style>

<div class="container d-flex justify-content-between ">
    <h4>Brands</h4>
    <a href="" class="text-dark fs-18 text-decoration-underline">
        View All
    </a>
</div>
<section class="container brand-logos-slider slider mt-3">

    @php
        $brands_slides = \App\Models\Brand::all();
    @endphp



    @foreach ( $brands_slides as $slide )
        <div class="slide d-flex align-items-center justify-content-center"><img src="{{ uploaded_asset($slide->logo) }}" alt="{{translate('Brand')}}"></div>
    @endforeach
    
 
</section>


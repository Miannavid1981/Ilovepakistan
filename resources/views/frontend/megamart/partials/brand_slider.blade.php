    
    <style>
        h2 {
            text-align: center;
            padding: 20px;
            text-transform: uppercase;
        }
        b {
            color: red;
        }
        .slick-slide {
            margin: 0px 20px;
        }
        .slick-slide img {
            width: 100%;
        }
        .brand-logos-slider {
    max-height: 150px; /* Adjust the height as needed */
    overflow: hidden; /* Ensures no extra spacing */
}

.brand-logos-slider .slide img {
    height: 100px; /* Adjust height as needed */
    width: auto; /* Keeps aspect ratio */
    object-fit: contain; /* Ensures images fit nicely */
}

    </style>
    <div class="container">
       <hr>
        <section class="brand-logos-slider slider">

            @php
                $brands_slides = \App\Models\Brand::all();

               // dd($brands_slides);

            @endphp



            @foreach ( $brands_slides as $slide )

                @php
                    dd($slide );
                @endphp
                <div class="slide"><img src="https://logopond.com/logos/dc5cc8314658dcbce4536affc4772f78.png" alt="Logo"></div>
            @endforeach
            
         
        </section>
        <hr>
    </div>
    


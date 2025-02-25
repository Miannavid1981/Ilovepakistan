@php
$photos = [];
@endphp
@if ($detailedProduct->photos != null)
    @php
        $photos = explode(',', $detailedProduct->photos);
    @endphp
@endif

<style>
 .slider-container {
    position: relative;
    background: white;
    border-radius: 10px;
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
    display: flex;
    flex-direction: row; /* Keep thumbnails and image side by side */
    align-items: flex-start; /* Align items to the top */
    justify-content: center;
    overflow: hidden; /* Hide scrollbars */
}

.main-image {
    width: 100%;
    height: auto;
    max-width: 500px;
    border-radius: 10px;
    cursor: grab;
    object-fit: cover;
    object-position: center;
}

.main-image:active {
    cursor: grabbing;
}

/* Thumbnail container placed outside the main image */
.thumbnail-container {
    position: absolute;
    top: 50%;
    left: -70px; /* Adjust to position thumbnails on the left side */
    transform: translateY(-50%);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 10px;
    border-radius: 10px;
    overflow: hidden; /* Hide scrollbar */
    white-space: nowrap; /* Prevent thumbnails from wrapping */
    max-height: 100%;
    height: 100%; /* Ensure the container takes full height */
}

.thumbnail-wrapper {
    display: flex;
    flex-direction: column; /* Stack thumbnails vertically */
    gap: 10px;
    transition: transform 0.3s ease-in-out;
    overflow: hidden; /* Ensure no horizontal scrollbar */
}

.thumbnail {
    width: 70px;  /* You can adjust this to your preferred size */
    height: 70px; /* Ensure height matches width for a square aspect ratio */
    cursor: pointer;
    border-radius: 10px;
    border: 1px solid rgb(53, 53, 53);
    transition: opacity 0.3s;
    opacity: 0.5;
    object-fit: cover;
    aspect-ratio: 1 / 1; /* Ensures square aspect ratio */
}


.thumbnail.selected {
    opacity: 1;
}

.thumbnail:hover {
    opacity: 0.7;
}

/* Arrows for sliding thumbnails */
.thumbnail-arrow {
    font-size: 24px;
    border: none;
    cursor: pointer;
    transition: 0.3s;
    background: rgba(255, 255, 255, 0.8);
}

.thumbnail-arrow:hover {
    background: rgba(255, 255, 255, 0.8);
}

/* Change direction of arrows to top and bottom */
.thumbnail-left {
    margin-top: 10px; /* Add margin for spacing */
    transform: rotate(180deg); /* Rotate arrow to point downwards */
}

.thumbnail-right {
    margin-bottom: 10px; /* Add margin for spacing */
    transform: rotate(0deg); /* Rotate arrow to point upwards */
}

/* Fullscreen styles */
.fullscreen {
    position: fixed;
    object-fit: cover;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.8);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.fullscreen img {
    width: 90%;
    max-height: 90%;
    object-fit: contain;
    border-radius: 10px;
}

/* Arrows for fullscreen mode */
.arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    font-size: 30px;
    color: white;
    cursor: pointer;
    user-select: none;
    visibility: hidden;
}

.left-arrow {
    left: 10px;
}

.right-arrow {
    right: 40px;
}

.fullscreen .arrow {
    visibility: visible;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .thumbnail {
        width: 60px;
        height: 90px;
    }

    .main-image {
        min-height: 400px;
    }
}

@media (max-width: 480px) {
    .thumbnail {
        width: 50px;
        height: 80px;
    }

    .main-image {
        min-height: 300px;
    }

    .arrow {
        font-size: 20px;
    }
}

.slick-track {
    width: 100% !important
}

</style>

<div class="row g-1">
    @if(count($photos) != 0 )
        @if(count($photos) == 1 )

            <div class="col-12 ">
                <img src="{{ uploaded_asset($photos[0]) }}" class=" h-100 w-100">
            </div>
            
        @else

            <div class="col-2 ">
                <div class="slider product-detail-slider-nav">
                    @foreach ($photos as $key => $photo)
                        <img src="{{ uploaded_asset($photo) }}" class="w-100 h-100" {{ $loop->first ? 'selected' : '' }}" >
                    @endforeach
                </div>
            </div>
            <div class="col-10 ">
                <div class="slider product-detail-slider-for">
                    @foreach ($photos as $key => $photo)
                        <img src="{{ uploaded_asset($photo) }}" class="w-100 h-100" {{ $loop->first ? 'selected' : '' }}" >
                    @endforeach
                </div>
            </div>

        @endif
    @endif
   
</div>


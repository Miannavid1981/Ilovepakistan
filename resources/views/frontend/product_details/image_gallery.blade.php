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

.fullscreen .close-btn{
    color: #ffffff ;
    padding-right: 30px;
    font-size: 30px;
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







</style>

<div class="row g-1">
    @if(count($photos) != 0 )
        @if(count($photos) == 1 )

            <div class="col-12 ">
                <img src="{{ uploaded_asset($photos[0]) }}" class="h-100 w-100 fullscreen-trigger">
            </div>
            
        @else
       
           
            <div class="col-2 ">
                <button class="arrow-prev border-0 custom-arrow w-100 d-flex justify-content-center py-2 bg-white ">
                    <i class="fa fa-chevron-up fs-20"></i>
                </button>
               
                <div class="slider slick-slider-c product-detail-slider-nav">
                    @foreach ($photos as $key => $photo)
                        <img src="{{ uploaded_asset($photo) }}" class="w-100 h-100 thumbnail" data-index="{{ $key }}">
                    @endforeach
                </div>

                <button class="arrow-next border-0 custom-arrow w-100 d-flex justify-content-center py-2 bg-white">
                    <i class="fas fa-chevron-down fs-20"></i>
                </button>
            </div>
            <div class="col-10 ">
                <div class="slider product-detail-slider-for">
                    @foreach ($photos as $key => $photo)
                        <img src="{{ uploaded_asset($photo) }}" class="w-100 h-100 fullscreen-trigger" data-index="{{ $key }}">
                    @endforeach
                </div>
            </div>

        @endif
    @endif
</div>


<div id="fullscreen-modal" class="fullscreen" style="display: none;">
    <span class="close-btn" onclick="closeFullscreen()">×</span>
    <img id="fullscreen-image" src="" alt="Fullscreen Image">
    <div class="arrow left-arrow" onclick="prevImage()">&#10094;</div>
    <div class="arrow right-arrow" onclick="nextImage()">&#10095;</div>
</div>


<script>
    let images = [];
    let currentIndex = 0;

    document.addEventListener("DOMContentLoaded", function () {
        images = Array.from(document.querySelectorAll('.fullscreen-trigger'));

        images.forEach((img, index) => {
            img.addEventListener("click", function () {
                openFullscreen(index);
            });
        });

        // Add event listener to thumbnails
        let thumbnails = document.querySelectorAll('.thumbnail');
        let mainImage = document.querySelector('.fullscreen-trigger'); 

        thumbnails.forEach((thumb, index) => {
            thumb.addEventListener("click", function () {
                updateMainImage(index);
            });
        });
    });

    function openFullscreen(index) {
        currentIndex = index;
        const modal = document.getElementById("fullscreen-modal");
        const fullscreenImage = document.getElementById("fullscreen-image");

        fullscreenImage.src = images[currentIndex].src;
        modal.style.display = "flex";
    }

    function closeFullscreen() {
        document.getElementById("fullscreen-modal").style.display = "none";
    }

    function prevImage() {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        document.getElementById("fullscreen-image").src = images[currentIndex].src;
    }

    function nextImage() {
        currentIndex = (currentIndex + 1) % images.length;
        document.getElementById("fullscreen-image").src = images[currentIndex].src;
    }

    function updateMainImage(index) {
        currentIndex = index;
        
        // Update main image on the right
        let mainImage = document.querySelector('.fullscreen-trigger'); 
        mainImage.src = images[currentIndex].src;

        // Remove selected class from previous and add to the new one
        document.querySelectorAll('.thumbnail').forEach(thumb => thumb.classList.remove('selected'));
        document.querySelectorAll('.thumbnail')[currentIndex].classList.add('selected');
    }
</script>

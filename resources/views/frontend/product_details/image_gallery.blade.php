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
        flex-direction: column;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding-bottom: 80px;
    }

    /* Thumbnail container */
    .thumbnail-container {
        position: absolute;
        bottom: -60px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        align-items: center;
        border-radius: 10px;
        width: 100%;
        background: rgba(255, 255, 255, 0.8);
        overflow: hidden;
    }

    /* Wrapper for scrolling thumbnails */
    .thumbnail-wrapper {
        display: flex;
        gap: 10px;
        transition: transform 0.3s ease-in-out;
        overflow-x: hidden;
        white-space: nowrap;
    }

    /* Thumbnails */
    .thumbnail {
        width: 70px;
        height: 100px;
        cursor: pointer;
        border-radius: 10px;
        border: 1px solid rgb(53, 53, 53);
        transition: opacity 0.3s;
        opacity: 0.5;
        object-fit: cover;
    }

    .thumbnail.selected {
        opacity: 1;
    }

    .thumbnail:hover {
        opacity: 0.7;
    }

    /* Main image */
    .main-image {
        width: 100%;
        height: auto;
        max-width: 500px;
        aspect-ratio: 1 / 1;
        border-radius: 10px;
        cursor: grab;
        object-fit: contain;
        object-position: center;
    }

    .main-image:active {
        cursor: grabbing;
    }

    /* Arrows for thumbnail navigation */
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

    .thumbnail-left {
        margin-right: 10px;
    }

    .thumbnail-right {
        margin-left: 10px;
    }

    /* Fullscreen styles */
    .fullscreen {
        position: fixed;
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
        max-width: 90%;
        max-height: 90%;
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
</style>

<body>
    <!-- Main image -->
    <div class="slider-container">
        <img src="{{ uploaded_asset($photos[0]) }}" class="main-image" id="mainImage" onclick="openFullscreen()">
    </div>

    <!-- Thumbnail section -->
    <div class="thumbnail-container" id="thumbnailContainer">
        <button class="thumbnail-arrow thumbnail-left" onclick="slideThumbnails('left')">&#10094;</button>

        <div class="thumbnail-wrapper" id="thumbnailWrapper">
            @foreach ($photos as $key => $photo)
                <img src="{{ uploaded_asset($photo) }}" class="thumbnail {{ $loop->first ? 'selected' : '' }}" onclick="changeImage('{{ uploaded_asset($photo) }}', this)">
            @endforeach
        </div>

        <button class="thumbnail-arrow thumbnail-right" onclick="slideThumbnails('right')">&#10095;</button>
    </div>
    @php

// Map the photo IDs to URLs
$photoUrls = array_map(function($photoId) {
    return uploaded_asset($photoId); // Map each ID to its URL
}, $photos);

@endphp

<script>
    // Pass the mapped photo URLs from PHP to JavaScript
    let images = @json($photoUrls);

        let currentIndex = 0;

        function changeImage(imageSrc, element) {
            let mainImg = document.getElementById("mainImage");
            mainImg.src = imageSrc;
            document.querySelectorAll(".thumbnail").forEach(img => img.classList.remove("selected"));
            element.classList.add("selected");
            currentIndex = images.indexOf(imageSrc);
        }

        function openFullscreen() {
            let imageSrc = document.getElementById("mainImage").src;
            currentIndex = images.indexOf(imageSrc);
            let fullscreenDiv = document.createElement("div");
            fullscreenDiv.classList.add("fullscreen");
            fullscreenDiv.innerHTML = `
                <span class="arrow left-arrow" onclick="prevImage(event)">&#10094;</span>
                <img src="${imageSrc}" id="fullscreenImage" onclick="event.stopPropagation()">
                <span class="arrow right-arrow" onclick="nextImage(event)">&#10095;</span>
            `;
            fullscreenDiv.addEventListener("click", closeFullscreen);
            document.body.appendChild(fullscreenDiv);
            document.addEventListener("keydown", closeOnEscape);
        }

        function closeFullscreen() {
            document.querySelector(".fullscreen").remove();
            document.removeEventListener("keydown", closeOnEscape);
        }

        function closeOnEscape(event) {
            if (event.key === "Escape") closeFullscreen();
        }

        function prevImage(event) {
            event.stopPropagation();
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            updateImages();
        }

        function nextImage(event) {
            event.stopPropagation();
            currentIndex = (currentIndex + 1) % images.length;
            updateImages();
        }

        function updateImages() {
            // Update main image
            let mainImg = document.getElementById("mainImage");
            if (mainImg) mainImg.src = images[currentIndex];

            // Update fullscreen image
            let fullscreenImg = document.getElementById("fullscreenImage");
            if (fullscreenImg) fullscreenImg.src = images[currentIndex];

            // Update selected thumbnail
            updateThumbnails();
        }

        function updateThumbnails() {
            document.querySelectorAll(".thumbnail").forEach(img => img.classList.remove("selected"));
            document.querySelectorAll(".thumbnail")[currentIndex].classList.add("selected");
        }

        function slideThumbnails(direction) {
            let wrapper = document.getElementById("thumbnailWrapper");
            let scrollAmount = 200; // Adjust for smooth scrolling
            if (direction === 'left') {
                wrapper.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            } else {
                wrapper.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        }
    </script>
</body>

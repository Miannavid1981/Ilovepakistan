@extends('seller.layouts.app')
<style>

.prevent_click {
    
    pointer-events: none;
    /*opacity: 0.3;*/
    
}




/* Skeleton Animation */
@keyframes skeleton-loading {
    0% {
        background-position: -200% 0;
    }
    100% {
        background-position: 200% 0;
    }
}

/* Apply skeleton animation to skeleton elements */
.skeleton {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: skeleton-loading 1.2s infinite ease-in-out;
    position: relative;
}

/* Skeleton image style */
.skeleton-img {
    width: 100%;
    height: 200px;
    background-color: #e0e0e0;
    border-radius: 4px;
}

/* Skeleton text style */
.skeleton-text {
    height: 16px;
    width: 100%;
    margin: 8px 0;
    background-color: #e0e0e0;
    border-radius: 4px;
}


.card {
  --background: #fff;
  --background-checkbox: #0082ff;
  --background-image: #fff, rgba(0, 107, 175, 0.2);
  --text-color: #666;
  --text-headline: #000;
  --card-shadow: #0082ff;
  /*--card-height: 190px;*/
  /*--card-width: 190px;*/
  --card-radius: 12px;
  --header-height: 47px;
  --blend-mode: overlay;
  --transition: 0.15s;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
}
.card:nth-child(odd) .card__body-cover-image {
  --x-y1: 100% 90%;
  --x-y2: 67% 83%;
  --x-y3: 33% 90%;
  --x-y4: 0% 85%;
}
.card:nth-child(even) .card__body-cover-image {
  --x-y1: 100% 85%;
  --x-y2: 73% 93%;
  --x-y3: 25% 85%;
  --x-y4: 0% 90%;
}
.card__input {
  position: absolute;
  display: block;
  outline: none;
  border: none;
  background: none;
  padding: 0;
  margin: 0;
  -webkit-appearance: none;
}
.card__input:checked ~ .card__body {
  --shadow: 0 0 0 3px var(--card-shadow);
}
.card__input:checked ~ .card__body .card__body-cover-checkbox {
  --check-bg: var(--background-checkbox);
  --check-border: #fff;
  --check-scale: 1;
  --check-opacity: 1;
}
.card__input:checked ~ .card__body .card__body-cover-checkbox--svg {
  --stroke-color: #fff;
  --stroke-dashoffset: 0;
}
.card__input:checked ~ .card__body .card__body-cover:after {
  --opacity-bg: 0;
}
.card__input:checked ~ .card__body .card__body-cover-image {
  --filter-bg: grayscale(0);
}
.card__input:disabled ~ .card__body {
  cursor: not-allowed;
  opacity: 0.5;
}
.card__input:disabled ~ .card__body:active {
  --scale: 1;
}
.card__body {
  display: grid;
  /*grid-auto-rows: calc(var(--card-height) - var(--header-height)) auto;*/
  background: var(--background);
  height: var(--card-height);
  width: var(--card-width);
  border-radius: var(--card-radius);
  overflow: hidden;
  position: relative;
  cursor: pointer;
  box-shadow: var(--shadow, 0 4px 4px 0 rgba(0, 0, 0, 0.02));
  transition: transform var(--transition), box-shadow var(--transition);
  transform: scale(var(--scale, 1)) translateZ(0);
  height: 100%;
}
.card__body:active {
  --scale: 0.96;
}
.card__body-cover {
  --c-border: var(--card-radius) var(--card-radius) 0 0;
  --c-width: 100%;
  --c-height: 100%;
  position: relative;
  overflow: hidden;
}
.card__body-cover:after {
  content: "";
  position: absolute;
  left: 0;
  top: 0;
  width: var(--c-width);
  height: var(--c-height);
  border-radius: var(--c-border);
  background: linear-gradient(to bottom right, var(--background-image));
  mix-blend-mode: var(--blend-mode);
  opacity: var(--opacity-bg, 1);
  transition: opacity var(--transition) linear;
}
.card__body-cover-image {
  width: var(--c-width);
  height: var(--c-height);
  -o-object-fit: cover;
     object-fit: cover;
  border-radius: var(--c-border);
 filter: var(--filter-bg, grayscale(0.5));
  /*-webkit-clip-path: polygon(0% 0%, 100% 0%, var(--x-y1, 100% 90%), var(--x-y2, 67% 83%), var(--x-y3, 33% 90%), var(--x-y4, 0% 85%));*/
  /*        clip-path: polygon(0% 0%, 100% 0%, var(--x-y1, 100% 90%), var(--x-y2, 67% 83%), var(--x-y3, 33% 90%), var(--x-y4, 0% 85%));*/
              aspect-ratio: 1 / 1;
    object-fit: contain;
    object-position: center;

}
.card__body-cover-checkbox {
  background: var(--check-bg, var(--background-checkbox));
  border: 2px solid var(--check-border, #fff);
  position: absolute;
  right: 10px;
  top: 10px;
  z-index: 1;
  width: 28px;
  height: 28px;
  border-radius: 50%;
  opacity: var(--check-opacity, 0);
  transition: transform var(--transition), opacity calc(var(--transition) * 1.2) linear;
  transform: scale(var(--check-scale, 0));
}
.card__body-cover-checkbox--svg {
  width: 13px;
  height: 11px;
  display: inline-block;
  vertical-align: top;
  fill: none;
  margin: 7px 0 0 5px;
  stroke: var(--stroke-color, #fff);
  stroke-width: 2;
  stroke-linecap: round;
  stroke-linejoin: round;
  stroke-dasharray: 16px;
  stroke-dashoffset: var(--stroke-dashoffset, 16px);
  transition: stroke-dashoffset 0.4s ease var(--transition);
}
.card__body-header {
  /*height: var(--header-height);*/
  background: var(--background);
  padding: 0 10px 10px 10px;
}
.card__body-header-title {
  color: var(--text-headline);
  font-weight: 700;
  margin-bottom: 8px;
}
.card__body-header-subtitle {
  color: var(--text-color);
  font-weight: 500;
  font-size: 13px;
}


body .grid {
  display: grid;
   grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr;
  grid-gap: 1rem;
}
@media (max-width: 768px){
     body .grid {
          grid-template-columns: 1fr 1fr 1fr 1fr;
     }
}
@media (max-width:  540px){
     body .grid {
          grid-template-columns: 1fr 1fr;
     }
}
/*floating controls */
@charset "UTF-8";
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap");
.modal .modal-content .modal-body {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
.modal .modal-content .modal-body::-webkit-scrollbar {
  display: none;
}
body {
  margin: 0;
  background-color: #eceff1;
  font-family: "Poppins", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
.warning {
  display: block !important;
  padding: 12px 15px !important;
  background-color: rgba(244, 67, 54, 0.25) !important;
  border-radius: 8px !important;
  font-weight: 500 !important;
  color: #e53935 !important;
  text-align: left !important;
}
.warning > i {
  position: relative;
  top: 1px;
  margin-right: 8px;
  transform: scale(1.25);
}
#mega-button {
  display: flex;
  align-items: center;
  justify-content: center;
  position: fixed;
  bottom: 15px;
  right: 15px;
  width: 50px;
  height: 50px;
  cursor: default;
  transition: all 0.15s ease-out;
  z-index: 1;
  will-change: width;
}
#mega-button > .tooltip {
  padding: 5px 10px;
  position: absolute;
  left: 10px;
  top: -9px;
  transform: translateY(-100%);
  white-space: nowrap;
  background-color: #fff;
  border-radius: 8px;
  filter: drop-shadow(0 2px 2px rgba(120, 144, 156, 0.5));
  box-shadow: inset 0 0 0 1px rgba(120, 144, 156, 0.1);
  font-weight: 500;
  color: #1e4989;
  -webkit-animation: tooltip-hover;
          animation: tooltip-hover;
  /* @keyframes duration | easing-function | delay |
  iteration-count | direction | fill-mode | play-state | name */
  -webkit-animation: 1s ease-in-out 0s infinite alternate both tooltip-hover;
          animation: 1s ease-in-out 0s infinite alternate both tooltip-hover;
  transition: all 0.15s ease-out;
  pointer-events: none;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
  will-change: opacity;
}
#mega-button > .tooltip::before {
  content: "";
  display: block;
  position: absolute;
  bottom: 1px;
  left: 8px;
  width: 12px;
  height: 6px;
  background-color: inherit;
  -webkit-clip-path: polygon(0 0, 100% 0, 50% 100%);
          clip-path: polygon(0 0, 100% 0, 50% 100%);
  transform: translateY(100%);
}
#mega-button::before {
  display: flex;
  align-items: center;
  justify-content: center;
  position: absolute;
  left: 0;
  top: 0;
  width: 50px;
  height: 50px;
  padding-top: 4px;
  background: 100% 100%/250% 100% #fff linear-gradient(135deg, transparent 33%, #2c92c8 66%, #892cc8) no-repeat;
  border-radius: 50%;
  content: "";
  font-family: "Font Awesome 5 Pro";
  font-size: 32px;
  font-weight: 400;
  color: #fff;
  transition: inherit;
  box-sizing: border-box;
  cursor: inherit;
  box-shadow: 0 10px 20px -10px #1a237e;
  backdrop-filter: blur(4px);
  -webkit-backdrop-filter: blur(4px);
  will-change: transform, background-color, box-shadow;
}
#mega-button > .sub-button {
  display: flex;
  align-items: center;
  justify-content: center;
  position: absolute;
  top: 50%;
  left: 25px;
  width: 36px;
  height: 36px;
  background: #2c92c8;
  border-radius: 50%;
  text-decoration: none !important;
  box-shadow: 0 10px 20px -10px #1a237e;
  transform: translate(-50%, -50%) scale(0.75);
  transition: inherit;
  z-index: -1;
  will-change: transform, transition-duration;
}
#mega-button > .sub-button::before {
  font-family: "Font Awesome 5 Pro";
  color: #fff;
  font-size: 20px;
  font-weight: 400;
  transform: rotate(-90deg);
  transition: inherit;
  will-change: transform;
}
#mega-button > .sub-button#buttons--write::before {
  content: "";
}
#mega-button > .sub-button#buttons--archive::before {
  content: "";
}
#mega-button > .sub-button#buttons--delete::before {
  content: "";
}
#mega-button:hover {
  width: calc(50px + 2px + 123px);
}
#mega-button:hover::before {
  transform: rotate(45deg) scale(0.675);
  padding-right: 2px;
  box-shadow: 7.5px 7.5px 20px -10px rgba(55, 71, 79, 0);
  background: -100% 100%/250% 100% rgba(144, 164, 174, 0.625) linear-gradient(135deg, transparent 33%, #2c92c8 66%, #892cc8) no-repeat;
}
#mega-button:hover::after {
  width: 200px;
}
#mega-button:hover > .sub-button::before {
  transform: rotate(0deg);
}
#mega-button:hover > .sub-button:nth-of-type(1) {
  transform: translate(calc(-50% + 50px + 0% + 0px + 2px), -50%) scale(1);
  transition-delay: 0.1s;
}
#mega-button:hover > .sub-button:nth-of-type(1):hover {
  transform: translate(calc(-50% + 50px + 0% + 0px + 2px), -50%) scale(1.18);
  transition-duration: 0.15s;
}
#mega-button:hover > .sub-button:nth-of-type(2) {
  transform: translate(calc(-50% + 50px + 100% + 5px + 2px), -50%) scale(1);
  transition-delay: 0.05s;
}
#mega-button:hover > .sub-button:nth-of-type(2):hover {
  transform: translate(calc(-50% + 50px + 100% + 5px + 2px), -50%) scale(1.18);
  transition-duration: 0.15s;
}
#mega-button:hover > .sub-button:nth-of-type(3) {
  transform: translate(calc(-50% + 50px + 200% + 10px + 2px), -50%) scale(1);
  transition-delay: 0s;
}
#mega-button:hover > .sub-button:nth-of-type(3):hover {
  transform: translate(calc(-50% + 50px + 200% + 10px + 2px), -50%) scale(1.18);
  transition-duration: 0.15s;
}
#mega-button:hover > .sub-button:hover {
  background-color: #3949ab;
}
#mega-button:hover > .sub-button:hover::before {
  transform: scale(0.85);
}
#mega-button:hover .tooltip, .modal:target ~ #mega-button .tooltip {
  opacity: 0;
}

@-webkit-keyframes tooltip-hover {
  from {
    transform: translateY(-100%);
  }
  to {
    transform: translateY(calc(-100% - 5px));
  }
}
@keyframes tooltip-hover {
  from {
    transform: translateY(-100%);
  }
  to {
    transform: translateY(calc(-100% - 5px));
  }
}
</style>

@section('panel_content')
<div class="aiz-titlebar mt-2 mb-4">
    <div class="row align-items-center">
        <div class="col-md-3">
            <h1 class="h3">{{ translate('Market') }}</h1>
        </div>
        <div class="col-md-5">
            
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control bg-soft-secondary border-0 form-control-sm" placeholder="Search products...">
        </div>
    </div>
</div>


<div class="grid" id="product-list">
  
</div>

<nav>
    <ul class="pagination" id="pagination"></ul>
</nav>
<div id="seller_floating_controls" style="display: none">
    
   
    
   
  
    <div id="mega-button">
      <div class="tooltip">Seller Tools</div>
      <a class="sub-button" id="buttons--write" href="#modal-write"></a>
      <a class="sub-button" id="buttons--archive" href="#modal-archive"></a>
      <a class="sub-button" id="buttons--delete" href="#modal-delete"></a>
    </div>
</div>



@endsection

@section('script') 
<script src="https://kit.fontawesome.com/07afc061fe.js" crossorigin="anonymous"></script>
<script>


$(document).ready(function(){
        
    function get_selected_count() {
        var count = 0;
        $(".multiselect_checkbox_id").each(function(){
            if( $(this).is(':checked') ){
                count++
            }
        })
        return count;
    }    
    function show_card_skeleton(){
        const total = 60;
    
        for ( var i = 0; i<=total; i++){
    
            $('#product-list').append(`
                <label class="card">
                    
                    <div class="card__body">
                        <div class="card__body-cover">
                            <img class="card__body-cover-image skeleton skeleton-img" src="" />
                            <span class="card__body-cover-checkbox">
                                <svg class="card__body-cover-checkbox--svg" viewBox="0 0 12 10">
                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                </svg>
                            </span>
                        </div>
                        <header class="card__body-header">
                            <h6 class="card__body-header-title skeleton skeleton-text"></h6>
                            <p class="card__body-header-subtitle skeleton skeleton-text"></p>
                        </header>
                    </div>
                </label>
            `);
        };
    }
    show_card_skeleton();
        
    // Helper function to extract the page number from URL
    function getPageFromUrl(url) {
        if (!url) return null;
        const params = new URL(url).searchParams;
        return params.get('page');
    }
    
    // Function to render pagination links
    function renderPagination(response) {
        $('#pagination').empty();
    
        response.links.forEach(link => {
            const isActive = link.active ? 'active' : '';
            const isDisabled = link.url === null ? 'disabled' : '';
            $('#pagination').append(`
                <li class="page-item ${isActive} ${isDisabled}">
                    <a class="page-link" href="#" data-page="${getPageFromUrl(link.url)}">${link.label}</a>
                </li>
            `);
        });
    }
    
    // Function to fetch products
    function fetchProducts(page = 1, search = '') {
        $('#product-list').addClass("prevent_click");
        console.log(page);
        $.ajax({
            url: `/seller/market-products`,
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            data: JSON.stringify({
                page: page,
                search: search,
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }),
            success: function(response) {
                // Clear the product list
                $('#product-list').empty();
    
                // Loop through products and append cards
                response.data.forEach(product => {
                    const thumbnailUrl = product.thumbnail_url ?? 'assets/img/placeholder.jpg';
                    const productUrl = `${product.product_url}`;
                    const brandName = product.brand_name ?? 'Unknown Brand';
    
                    $('#product-list').append(`
                        <label class="card">
                            <input class="card__input multiselect_checkbox_id" type="checkbox" 
                                   name="product_id" data-value="${product.id}" />
                            <div class="card__body">
                                <div class="card__body-cover">
                                    <img class="card__body-cover-image" src="${thumbnailUrl}" />
                                    <span class="card__body-cover-checkbox">
                                        <svg class="card__body-cover-checkbox--svg" viewBox="0 0 12 10">
                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                </div>
                                <header class="card__body-header">
                                    <h6 class="card__body-header-title">${brandName}</h6>
                                    <p class="card__body-header-subtitle">${product.name}</p>
                                </header>
                            </div>
                        </label>
                    `);
                });
    
                // Handle pagination
                renderPagination(response);
                 $('#product-list').removeClass("prevent_click");
            },
            error: function(error) {
                console.error('Error fetching products:', error);
            }
        });
    }
    
    // Event listener for pagination link clicks
    $(document).on('click', '.page-link', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        if (page) {
            fetchProducts(page);
        }
    });

// Call the function to fetch products when the page loads
    fetchProducts();

    $(document).on('click', '.card__input', function(){
      if(get_selected_count() > 0){
        
            $("#seller_floating_controls").fadeIn();
          
      } else {
            $("#seller_floating_controls").fadeOut();
      }
    })
    
    

})

    
</script>
@endsection
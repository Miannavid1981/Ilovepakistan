
<style>
    .custom-tabs-wrapper {
        position: relative;
        display: inline-flex;
        background: #f5f5f5;
        padding: 8px;
        border-radius: 50px;
        width: fit-content;
        position: relative;
    }

    .custom-tab {
        padding: 10px 20px;
        border-radius: 25px;
        cursor: pointer;
        font-size: 18px;
        font-weight: 500;
        color: #666;
        transition: color 0.3s ease;
        position: relative;
        z-index: 2;
    }

    .custom-tab.active {
        color: black;
        font-weight: 700;
    }

    /* Moving Bubble Indicator */
    .bubble {
        position: absolute;
        top: 5px;
        bottom: 5px;
        left: 5px;
        width: calc(100% / 3 - 10px); /* Adjust width to fit */
        background: white;
        border-radius: 25px;
        transition: transform 0.3s ease-in-out;
        z-index: 1;
    }
</style>
<div class="container mt-5 text-center">
<!-- Tabs -->
<div class="custom-tabs-wrapper mx-auto">
    <div class="bubble"></div>
    <div class="custom-tab active" onclick="showTab('bestSellers', 0)">Best Sellers</div>
    <div class="custom-tab" onclick="showTab('onSale', 1)">On Sale</div>
    <div class="custom-tab" onclick="showTab('newArrivals', 2)">New Arrivals</div>
</div>

<!-- Cards -->
<div class="mt-4">
    <div id="bestSellers" class="tab-content">
        <div class="card p-3 shadow-sm">Best Sellers Content</div>
    </div>
    <div id="onSale" class="tab-content d-none">
        <div class="card p-3 shadow-sm">On Sale Content</div>
    </div>
    <div id="newArrivals" class="tab-content d-none">
        <div class="card p-3 shadow-sm">New Arrivals Content</div>
    </div>
</div>
</div>

<div class="row">
    @foreach ($products as $product)
        <div class="col-md-4 col-sm-6 mb-4">
            <div class="card h-100">
                <img src="{{ $product->thumbnail != null ? my_asset($product->thumbnail->file_name) : static_asset('assets/img/placeholder.jpg') }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                   
                    <div class="d-flex ">

                        @if ($product->auction_product == 0)
        
                            <!-- Previous price -->
        
                            @if (home_base_price($product) != home_discounted_base_price($product))
        
                                <div class="">
        
                                    <del class="fw-400 fs-14  text-secondary mr-1">{{ home_base_price($product) }}</del>
        
                                </div>
        
                            @endif
        
                            <!-- price -->
        
                        @endif
        
                        
        
                    </div>
                    
                    <div class="">
                        <span class="fs-15">{{ get_system_default_currency()->code }}</span>
                        <span class="fw-700 text-dark text-start fs-20" style=" font-family: "Kanit", serif !important">{{ number_format(home_discounted_base_price($product, false)) }}</span>
        
                            <!-- Discount percentage tag -->
        
                            @if (discount_in_percentage($product) > 0)
        
                                <span class="bg-primary ml-1 fs-15 fw-700 text-white w-35px text-center rounded-3 px-2"
        
                                    style="padding-top:2px;padding-bottom:2px;">-{{ discount_in_percentage($product) }}%</span>
        
                            @endif 
        
                    <!-- Wholesale tag -->
        
                    </div>

                    @php

                  
                    $admin_user = User::where('email', 'admin@bighouz.com')->first();
                    $admin_id = $admin_user->id;

                    $target_cat = Category::where("id",$product->category_id)->first();
                        

                    $admin_commission_type = null;
                    $seller_commission_type = null;
                    
                    $admin_commission_rate = null;
                    $seller_commission_rate = null;
                    $brand_profit_amount = null;
                    $seller_profit = null;
                    $admin_profit_per_amount = null;
                    $admin_profit_final_amount = null;
                    $commission = 0;


                    if($target_cat->commission == 1){
                        $commission = 1;
                        $admin_commission_type = $target_cat->commission_rate_type;
                        $seller_commission_type = $target_cat->seller_commission_rate_type;

                        $admin_commission_rate = (float) $target_cat->commision_rate;
                        $seller_commission_rate = (float)  $target_cat->seller_commission_rate;

                    } else {

                        if($product->commission == 1){
                            $commission = 1;
                            $admin_commission_type = $product->admin_commission_type;
                            $seller_commission_type = $product->seller_commission_type;
                            
                            $admin_commission_rate = (float)  $product->admin_commission_rate;
                            $seller_commission_rate = (float)  $product->seller_commission_rate;
                        }
                        

                    }
                    
                    
            

                    if($commission ) {
                        
                        if( !empty($admin_commission_type) && !empty($admin_commission_rate)  ){

                            // Calculate admin profit per amount depending on the commission type (percentage or fixed amount)
                            if ($admin_commission_type === 'percentage') {
                                $admin_profit_per_amount = get_percentage_amount($admin_commission_rate, $item_price);
                            } else {
                                // If it's an amount, use it directly
                                $admin_profit_per_amount = $admin_commission_rate;
                            }
                            
                            $brand_profit_amount = $item_price - $admin_profit_per_amount;
                      
                            $seller_profit = 0;
                            if ($source_seller_id != $seller_id) {

                                if( !empty($seller_commission_type) && !empty($seller_commission_rate)  ){
                                    // Handle seller commission
                                    if ($seller_commission_type === 'percentage') {
                                        $seller_profit_per_amount = get_percentage_amount($seller_commission_rate, $admin_profit_per_amount);
                                        $seller_profit = (int) ($seller_commission_rate / 100) * $admin_profit_per_amount;
                                    } else {
                                        // If it's a fixed amount, use the fixed value
                                        $seller_profit_per_amount = $seller_commission_rate;
                                        $seller_profit =  (int)  $seller_commission_rate; // Fixed amount, so no percentage calculation needed
                                    }
                                }
                            } 
                            
                            // Final admin profit after subtracting seller's profit
                            $admin_profit_final_amount = $admin_profit_per_amount - $seller_profit;
                            
                            // Assign final admin profit to order detail
                           
                            
                            
                            

                        } 
                    }

                   

                    @endphp
                    <span class="text-success"> +{{ $seller_profit }}</span>
                    <input type="checkbox" 
                           name="product_ids[]" 
                           value="{{ $product->id }}" 
                           class="product-checkbox"
                           {{ in_array($product->id, $importedProductIds) ? 'checked' : '' }}>
                </div>
            </div>
        </div>
    @endforeach
</div>

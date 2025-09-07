@extends('frontend.layouts.app')


@section('content')


 <style>
    /* Bighouz Branding Colors */
    :root {
      --primary-gradient-start: #7f00ff;
      --primary-gradient-end: #e100ff;
      --accent-pink: #d63384;
      --text-main: #000000;
      --text-sub: #333333;
      --bg-white: #ffffff;
      --bg-light: #f4f7fa;
    }

    .policy-header {
      background: linear-gradient(to right, var(--primary-gradient-start), var(--primary-gradient-end));
      color: white;
      padding: 30px;
      text-align: center;
      font-size: 2rem;
      font-weight: bold;
      letter-spacing: 1px;
    }

    .policy-section {
      background: var(--bg-white);
      border-left: 6px solid var(--accent-pink);
      border-radius: 10px;
      padding: 25px;
      margin-bottom: 25px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    }

    h2 {
      color: var(--primary-gradient-start);
      font-size: 1.5rem;
      margin-bottom: 15px;
    }

    h3 {
      color: var(--primary-gradient-end);
      font-size: 1.2rem;
      margin-top: 20px;
    }

    ul {
      padding-left: 1.2rem;
    }

    li {
      margin-bottom: 8px;
      color: var(--text-sub);
    }

    p {
      color: var(--text-sub);
      line-height: 1.6;
    }

    @media (max-width: 768px) {
      .policy-header {
        font-size: 1.5rem;
        padding: 20px 10px;
      }

     

      h2 {
        font-size: 1.3rem;
      }

      h3 {
        font-size: 1rem;
      }
    }

      .Img{
        margin-bottom: 20px;
    }
  </style>

  <div class="policy-header">Bighouz Ecosystem</div>

  

    <section class="policy-section">
      <p>The <strong>Bighouz Ecosystem</strong> is a complete digital commerce and service environment that connects multiple stakeholders—buyers, sellers, brands, service providers, and logistics—into one unified marketplace. It’s not just a store, but a business infrastructure that combines technology, trade, and support systems.</p>
    </section>

    <section class="policy-section">
      <h2>1. Core Components</h2>
      <ul>
        <li><strong>Multi-Vendor Marketplace:</strong> Vendors (individual sellers, wholesalers, and companies) can open stores on Bighouz to list and sell products.</li>
        <li><strong>Features:</strong> Vendor dashboard, SKIN (Stock Keeping Identification Number), commissions, vendor branding.</li>
        <li><strong>Brands & Resellers:</strong> Manufacturers and official brands can list products. Resellers can cross-list using the SKIN system.</li>
        <li><strong>Courier & Logistics:</strong> Integrated shipping partners for delivery, tracking, and returns.</li>
        <li><strong>Admin Layer:</strong> Manages policies, commissions, security, and category management.</li>
      </ul>
    </section>
      <Img class="Img" src="{{ static_asset('Screenshot_5-9-2025_125934_.jpeg') }}"></Img>

    <section class="policy-section">
      <h2>2. Supporting Technologies</h2>
      <ul>
        <li><strong>AI Bots:</strong> Automate product listings, pricing, and inventory sync.</li>
        <li><strong>SKIN System:</strong> Unique identifier for tracking/import/export.</li>
        <li><strong>Payment Gateways:</strong> COD, Easypaisa, JazzCash, Bank, Stripe, PayPal.</li>
        <li><strong>Analytics & Insights:</strong> Reports on sales, buyer behavior, and stock movement.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>3. Stakeholders</h2>
      <ul>
        <li><strong>Vendors (Seller Partners):</strong> Sell directly to customers.</li>
        <li><strong>Brands (Brand Partners):</strong> Showcase official products.</li>
        <li><strong>Resellers (Store Partners):</strong> Earn via cross-listing without holding inventory.</li>
        <li><strong>Buyers (Customers):</strong> Enjoy competitive prices and variety.</li>
        <li><strong>Logistics Partners:</strong> Handle shipping and delivery.</li>
        <li><strong>Service Providers:</strong> E.g., installation and after-sales services.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>4. Value-Added Services</h2>
      <ul>
        <li>E-commerce store management tools (product entry, automation).</li>
        <li>Vendor financing (Buy now, pay later).</li>
        <li>Digital marketing (SEO, ads, promotions).</li>
        <li>After-sales services (returns, warranty claims).</li>
        <li>Affiliate & referral programs (influencer/blogger support).</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>5. Extended Ecosystem Possibilities</h2>
      <ul>
        <li><strong>Bighouz Solar Division:</strong> Focus on renewable products like solar panels, inverters, batteries, and accessories.</li>
        <li><strong>Bighouz B2B:</strong> Marketplace for wholesale and industrial supplies.</li>
        <li><strong>Bighouz Logistics:</strong> Independent courier network with tracking and delivery.</li>
        <li><strong>Bighouz Financial Services:</strong> Escrow, vendor financing, and future e-wallet options.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>6. Why It’s an Ecosystem (Not Just a Marketplace)</h2>
      <ul>
        <li>Connects retail, wholesale, logistics, and services in one system.</li>
        <li>Empowers buyers and vendors using tech, data, and finance.</li>
        <li>Creates a self-sustaining loop:
          <em>Vendors list → Buyers purchase → Logistics deliver → Payments settle → Data improves system → Vendors grow</em>.
        </li>
      </ul>
      <p><strong>In short:</strong> The Bighouz Ecosystem is a one-stop commercial universe where trade, technology, logistics, finance, and services are interconnected to create sustainable growth for all participants.</p>
    </section>

  




@endsection

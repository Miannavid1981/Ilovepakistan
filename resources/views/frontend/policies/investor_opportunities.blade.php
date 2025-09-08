@extends('frontend.layouts.app')


@section('content')


 <style>
    /* Bighouz Branding Colors */
       :root {
      --primary-gradient-start: #761ae0 ;
      --primary-gradient-end: #dd5a6e;
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
      font-family: "Aeonik" !important;
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

  <div class="policy-header">Investor Opportunities in the Bighouz Ecosystem</div>

   <div class="container py-5">
    <section class="policy-section">
      <h2>1. 🛍 Marketplace Expansion (Core Investment)</h2>
      <ul>
        <li><strong>Opportunity:</strong> Invest in scaling the multi-vendor marketplace (web, app, user acquisition).</li>
        <li><strong>Returns:</strong> Commissions, vendor subscriptions, ad slots.</li>
        <li><strong>Why Attractive:</strong> Untapped Tier 2 & 3 city markets + rising e-commerce in Pakistan/region.</li>
      </ul>
    </section>

     <image class="Img" src="./Screenshot 2025-09-05 130251.png" mode=""></image>

    <section class="policy-section">
      <h2>2. 🏷 Vendor & Brand Onboarding</h2>
      <ul>
        <li><strong>Opportunity:</strong> Fund vendor acquisition campaigns, training, brand deals.</li>
        <li><strong>Returns:</strong> Subscription revenue, commissions, vendor services.</li>
        <li><strong>Why Attractive:</strong> More vendors = more SKUs = more buyers = higher GMV.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>3. Reseller & Affiliate Network</h2>
      <ul>
        <li><strong>Opportunity:</strong> Develop SKIN-based reseller program + influencer/affiliate network.</li>
        <li><strong>Returns:</strong> Performance-based commissions.</li>
        <li><strong>Why Attractive:</strong> Scalable, low cost, powered by social sellers.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>4. Logistics & Courier Services</h2>
      <ul>
        <li><strong>Opportunity:</strong> Co-own or franchise Bighouz delivery hubs.</li>
        <li><strong>Returns:</strong> Delivery fees, COD handling, reverse logistics.</li>
        <li><strong>Why Attractive:</strong> Reliable logistics = recurring revenue backbone.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>5. Financial Services & Fintech</h2>
      <ul>
        <li><strong>Opportunity:</strong>
          <ul>
            <li>Vendor Financing (Buy Now, Pay Later)</li>
            <li>Bighouz Wallet (escrow + payments)</li>
            <li>Micro-loans for inventory</li>
          </ul>
        </li>
        <li><strong>Returns:</strong> Interest income, transaction & wallet fees.</li>
        <li><strong>Why Attractive:</strong> High-margin, sticky services that lock in vendors.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>6. Solar Division (Niche Vertical)</h2>
      <ul>
        <li><strong>Opportunity:</strong> Invest in solar e-commerce: panels, batteries, inverters, cables, accessories.</li>
        <li><strong>Returns:</strong> High-margin product sales + recurring installation revenue.</li>
        <li><strong>Why Attractive:</strong> Booming industry due to Pakistan's energy crisis.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>7. B2B Marketplace</h2>
      <ul>
        <li><strong>Opportunity:</strong> Enter wholesale space — raw materials, bulk supplies, machinery.</li>
        <li><strong>Returns:</strong> Large commissions, vendor memberships, B2B subscriptions.</li>
        <li><strong>Why Attractive:</strong> Less competitive, higher average order value.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>8. Data & Analytics Services</h2>
      <ul>
        <li><strong>Opportunity:</strong> Sell anonymized sales and trend data to brands/vendors.</li>
        <li><strong>Returns:</strong> Subscription-based analytics tools and insights.</li>
        <li><strong>Why Attractive:</strong> No inventory needed. High-value insights-as-a-service model.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>9. Value-Added Services</h2>
      <ul>
        <li><strong>Opportunity:</strong>
          <ul>
            <li>Product photography & content</li>
            <li>SEO and marketing packages</li>
            <li>After-sales & warranty handling</li>
          </ul>
        </li>
        <li><strong>Returns:</strong> Vendor service fees, recurring monthly charges.</li>
        <li><strong>Why Attractive:</strong> Scales with vendor count and improves ecosystem loyalty.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>10. Regional Expansion</h2>
      <ul>
        <li><strong>Opportunity:</strong> Franchise or replicate Bighouz in Africa, ME, South Asia.</li>
        <li><strong>Returns:</strong> Joint ventures, regional partnerships, licensing.</li>
        <li><strong>Why Attractive:</strong> First-mover advantage in underserved digital markets.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>📈 Investor ROI Models</h2>
      <ul>
        <li><strong>Short-Term:</strong> Vendor onboarding, ads, affiliate scaling.</li>
        <li><strong>Mid-Term:</strong> Logistics, fintech, solar.</li>
        <li><strong>Long-Term:</strong> B2B marketplace, data monetization, regional replication.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>💡 Conclusion</h2>
      <p>
        Investors in the <strong>Bighouz Ecosystem</strong> aren't just backing an e-commerce store — they're investing in a full-fledged digital commercial universe across retail, logistics, fintech, energy, and wholesale. With each vertical offering its own revenue stream, Bighouz presents a scalable, multi-industry growth model.
      </p>
    </section>

    <div class="contact-cta">
      <a href="mailto:invest@bighouz.com" class="cta-btn">📩 Contact NOW</a>
    </div>
</div>



@endsection

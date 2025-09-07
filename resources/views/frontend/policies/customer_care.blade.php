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

  <div class="policy-header">Investor Opportunities in the Bighouz Ecosystem</div>

  
    <section class="policy-section">
      <h2>1. Buyer Support</h2>
      <ul>
        <li>Multi-Channel Helpdesk: Live chat, WhatsApp, phone, and email support.</li>
        <li>Order Tracking: Real-time updates from purchase to delivery.</li>
        <li>Easy Returns & Refunds: Clear policies, one-click request system, and fast settlements.</li>
        <li>Knowledge Base & FAQs: Self-service guides for common queries.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>2. 🏷 Brand & Vendor Support</h2>
      <ul>
        <li>Dedicated Store Managers for onboarding and store management.</li>
        <li>Training & Tutorials: Webinars on listing, pricing, and marketing.</li>
        <li>Vendor Care Hotline for critical issues.</li>
        <li>Automated Tools: SKIN-based sync, sales reports, and AI insights.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>3. Bighouz’s Customer Data Privacy</h2>

      <h3>3.1 Data Protection Principles</h3>
      <ul>
        <li>Minimal Data Collection for necessary operations only.</li>
        <li>Encryption (AES/SSL) for secure storage and transmission.</li>
        <li>Access Control: Restricted to authorized personnel.</li>
      </ul>

      <h3>3.2 🛡 Privacy in Customer Care</h3>
      <ul>
        <li>Encrypted chats, email, and WhatsApp communication.</li>
        <li>Masked Data Sharing with vendors (order-only visibility).</li>
        <li>Anonymized Analytics for decision-making.</li>
      </ul>

      <h3>3.3 – 3.5</h3>
      <p>Additional data safeguards and proactive privacy measures under implementation.</p>
    </section>

    <section class="policy-section">
      <h2>4. Compliance & Policies</h2>
      <ul>
        <li>GDPR & Local Law Compliance.</li>
        <li>Clear Privacy Policy & Communication.</li>
        <li>Opt-in/Opt-out for marketing preferences.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>5. Tech & AI Layer</h2>
      <ul>
        <li>AI Chatbots with Privacy Mode.</li>
        <li>Secure Ticketing System with anonymized IDs.</li>
        <li>Automated Alerts on data access anomalies.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>6. Trust & Transparency</h2>
      <ul>
        <li>Customer data control (view/download/delete).</li>
        <li>Data Breach Protocols with immediate alert system.</li>
        <li>Support team trained in privacy & data handling.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>7. Logistics Support</h2>
      <ul>
        <li>Courier Tracking System for real-time updates.</li>
        <li>Last-Mile Support with courier coordination.</li>
        <li>Reverse Logistics for returns and replacements.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>8. Financial Services Support</h2>
      <ul>
        <li>Escrow-based Payment Dispute Resolution.</li>
        <li>24/7 Wallet Assistance for all users.</li>
        <li>Vendor Financing Helpdesk for credit-related queries.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>9. Solar & B2B Division Care</h2>
      <ul>
        <li>Engineer Technical Support for setup and after-sales.</li>
        <li>Fast-track Warranty Handling.</li>
        <li>Corporate Buyers Desk for large-scale orders.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>10. Technology-Driven Care</h2>
      <ul>
        <li>AI Chatbots for 24/7 basic support.</li>
        <li>Ticketing System with SLA tracking.</li>
        <li>Real-time Customer Care Dashboard for admins.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>11. Customer Experience Enhancements</h2>
      <ul>
        <li>Feedback Loops via post-purchase surveys.</li>
        <li>Loyalty Programs for buyers and vendors.</li>
        <li>Transparent seller ratings and delivery info.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2>Why It’s the “Best”</h2>
      <p>In the Bighouz Ecosystem, customer care is not only reactive (solving problems) but also proactive (preventing problems). It 
connects buyers, vendors, logistics, and financial services into one seamless support experience, ensuring trust, loyalty, and 
repeat business.</p>
    </section>




@endsection

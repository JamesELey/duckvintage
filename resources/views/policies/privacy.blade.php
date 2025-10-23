@extends('layouts.app')

@section('title', 'Privacy Policy - Duck Vintage')

@section('content')
<div class="container">
    <h1 style="margin-bottom: 2rem;">Privacy Policy</h1>
    
    <div class="card">
        <div class="card-body">
            <p><strong>Last Updated:</strong> {{ date('F d, Y') }}</p>
            
            <h2>1. Introduction</h2>
            <p>Duck Vintage ("we", "our", or "us") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website and use our services.</p>
            
            <h2>2. GDPR Compliance</h2>
            <p>We are committed to compliance with the General Data Protection Regulation (GDPR) and other applicable data protection laws. This policy outlines your rights and how we protect your data.</p>
            
            <h3>Your Rights Under GDPR:</h3>
            <ul>
                <li><strong>Right to Access:</strong> You can request access to your personal data</li>
                <li><strong>Right to Rectification:</strong> You can correct inaccurate or incomplete data</li>
                <li><strong>Right to Erasure:</strong> You can request deletion of your data ("right to be forgotten")</li>
                <li><strong>Right to Data Portability:</strong> You can export your data in a machine-readable format</li>
                <li><strong>Right to Object:</strong> You can object to processing of your data</li>
                <li><strong>Right to Withdraw Consent:</strong> You can withdraw consent at any time</li>
            </ul>
            
            <h2>3. Information We Collect</h2>
            <h3>Personal Information:</h3>
            <ul>
                <li>Name and email address</li>
                <li>Shipping and billing addresses</li>
                <li>Phone number</li>
                <li>Payment information (processed securely through Stripe)</li>
            </ul>
            
            <h3>Automatically Collected Information:</h3>
            <ul>
                <li>IP address</li>
                <li>Browser type and version</li>
                <li>Pages visited and time spent</li>
                <li>Referring website</li>
                <li>Cookies and similar technologies</li>
            </ul>
            
            <h2>4. How We Use Your Information</h2>
            <p>We use your information to:</p>
            <ul>
                <li>Process and fulfill your orders</li>
                <li>Communicate with you about your orders</li>
                <li>Provide customer support</li>
                <li>Send marketing communications (with your consent)</li>
                <li>Improve our website and services</li>
                <li>Prevent fraud and enhance security</li>
            </ul>
            
            <h2>5. Data Retention</h2>
            <p>We retain your personal data only for as long as necessary to fulfill the purposes outlined in this policy, unless a longer retention period is required by law.</p>
            
            <h2>6. Data Security</h2>
            <p>We implement appropriate technical and organizational measures to protect your data against unauthorized access, alteration, disclosure, or destruction.</p>
            
            <h2>7. Cookies</h2>
            <p>We use cookies and similar tracking technologies. For more information, please see our <a href="{{ route('cookie-policy') }}">Cookie Policy</a>.</p>
            
            <h2>8. Third-Party Services</h2>
            <p>We may share your information with trusted third-party service providers who assist us in operating our website and conducting our business, including:</p>
            <ul>
                <li>Payment processors (Stripe)</li>
                <li>Shipping providers</li>
                <li>Email service providers</li>
                <li>Analytics providers</li>
            </ul>
            
            <h2>9. Your Data Rights</h2>
            <p>You can exercise your rights by:</p>
            <ul>
                <li><strong>Exporting Your Data:</strong> Visit your <a href="{{ route('profile.show') }}">profile page</a> and click "Export My Data"</li>
                <li><strong>Deleting Your Account:</strong> Visit your <a href="{{ route('profile.show') }}">profile page</a> and request account deletion</li>
                <li><strong>Updating Information:</strong> Edit your profile information at any time</li>
                <li><strong>Contact Us:</strong> Email us at privacy@duckvintage.com</li>
            </ul>
            
            <h2>10. Children's Privacy</h2>
            <p>Our services are not intended for children under 16 years of age. We do not knowingly collect personal information from children.</p>
            
            <h2>11. International Data Transfers</h2>
            <p>Your information may be transferred to and processed in countries other than your country of residence. We ensure appropriate safeguards are in place for such transfers.</p>
            
            <h2>12. Changes to This Policy</h2>
            <p>We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new policy on this page and updating the "Last Updated" date.</p>
            
            <h2>13. Contact Us</h2>
            <p>If you have questions about this Privacy Policy or wish to exercise your rights, please contact us:</p>
            <ul>
                <li>Email: privacy@duckvintage.com</li>
                <li>Address: [Your Business Address]</li>
            </ul>
            
            <div class="mt-4">
                <a href="{{ route('terms-of-service') }}" class="btn btn-secondary">Terms of Service</a>
                <a href="{{ route('cookie-policy') }}" class="btn btn-secondary">Cookie Policy</a>
            </div>
        </div>
    </div>
</div>

<style>
    h2 {
        color: #FFD700;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
    
    h3 {
        color: #FFD700;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
        font-size: 1.25rem;
    }
    
    ul {
        margin-left: 2rem;
        margin-bottom: 1rem;
    }
    
    li {
        margin-bottom: 0.5rem;
    }
    
    p {
        margin-bottom: 1rem;
        line-height: 1.6;
    }
    
    a {
        color: #FFD700;
        text-decoration: underline;
    }
    
    a:hover {
        color: #FFF;
    }
</style>
@endsection


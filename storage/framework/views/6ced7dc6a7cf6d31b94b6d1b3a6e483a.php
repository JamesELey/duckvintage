

<?php $__env->startSection('title', 'Terms of Service - Duck Vintage'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1 style="margin-bottom: 2rem;">Terms of Service</h1>
    
    <div class="card">
        <div class="card-body">
            <p><strong>Last Updated:</strong> <?php echo e(date('F d, Y')); ?></p>
            
            <h2>1. Agreement to Terms</h2>
            <p>By accessing and using Duck Vintage's website and services, you agree to be bound by these Terms of Service and all applicable laws and regulations.</p>
            
            <h2>2. Use of Our Service</h2>
            <p>You must be at least 18 years old to use our services. You agree to use our website only for lawful purposes.</p>
            
            <h3>You Agree Not To:</h3>
            <ul>
                <li>Use our service for any illegal or unauthorized purpose</li>
                <li>Violate any laws in your jurisdiction</li>
                <li>Infringe on the rights of others</li>
                <li>Transmit any malicious code or viruses</li>
                <li>Attempt to gain unauthorized access to our systems</li>
                <li>Interfere with the proper working of our website</li>
            </ul>
            
            <h2>3. Account Registration</h2>
            <p>To make purchases, you must create an account. You are responsible for:</p>
            <ul>
                <li>Maintaining the confidentiality of your account credentials</li>
                <li>All activities that occur under your account</li>
                <li>Providing accurate and complete information</li>
                <li>Updating your information as needed</li>
            </ul>
            
            <h2>4. Products and Pricing</h2>
            <ul>
                <li>All products are subject to availability</li>
                <li>Prices are subject to change without notice</li>
                <li>We reserve the right to limit quantities</li>
                <li>Product descriptions are as accurate as possible but may contain errors</li>
                <li>We reserve the right to refuse or cancel any order</li>
            </ul>
            
            <h2>5. Orders and Payment</h2>
            <p>By placing an order, you agree to:</p>
            <ul>
                <li>Pay the total amount including taxes and shipping</li>
                <li>Provide accurate billing and shipping information</li>
                <li>Use a valid payment method</li>
            </ul>
            
            <h3>Payment Processing:</h3>
            <p>Payments are processed securely through Stripe. We do not store your full credit card information on our servers.</p>
            
            <h2>6. Shipping and Delivery</h2>
            <ul>
                <li>Shipping times are estimates and not guarantees</li>
                <li>Risk of loss passes to you upon delivery to the carrier</li>
                <li>International orders may be subject to customs fees</li>
            </ul>
            
            <h2>7. Returns and Refunds</h2>
            <p>Please review our Return Policy for detailed information about returns, exchanges, and refunds.</p>
            
            <h2>8. Intellectual Property</h2>
            <p>All content on our website, including text, graphics, logos, images, and software, is the property of Duck Vintage or its licensors and is protected by copyright and trademark laws.</p>
            
            <h2>9. User Content</h2>
            <p>By submitting reviews or other content, you grant us a non-exclusive, worldwide, royalty-free license to use, reproduce, and distribute such content.</p>
            
            <h2>10. Privacy</h2>
            <p>Your privacy is important to us. Please review our <a href="<?php echo e(route('privacy-policy')); ?>">Privacy Policy</a> to understand how we collect, use, and protect your information.</p>
            
            <h2>11. Limitation of Liability</h2>
            <p>To the fullest extent permitted by law, Duck Vintage shall not be liable for any indirect, incidental, special, consequential, or punitive damages arising from your use of our services.</p>
            
            <h2>12. Indemnification</h2>
            <p>You agree to indemnify and hold Duck Vintage harmless from any claims, damages, losses, liabilities, and expenses arising from your use of our services or violation of these terms.</p>
            
            <h2>13. Governing Law</h2>
            <p>These terms shall be governed by and construed in accordance with the laws of [Your Jurisdiction], without regard to its conflict of law provisions.</p>
            
            <h2>14. Changes to Terms</h2>
            <p>We reserve the right to modify these terms at any time. Continued use of our services after changes constitutes acceptance of the modified terms.</p>
            
            <h2>15. Termination</h2>
            <p>We may terminate or suspend your account and access to our services at any time, without prior notice, for conduct that we believe violates these terms or is harmful to other users, us, or third parties, or for any other reason.</p>
            
            <h2>16. Contact Information</h2>
            <p>If you have questions about these Terms of Service, please contact us:</p>
            <ul>
                <li>Email: support@duckvintage.com</li>
                <li>Address: [Your Business Address]</li>
            </ul>
            
            <div class="mt-4">
                <a href="<?php echo e(route('privacy-policy')); ?>" class="btn btn-secondary">Privacy Policy</a>
                <a href="<?php echo e(route('cookie-policy')); ?>" class="btn btn-secondary">Cookie Policy</a>
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
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8_2\htdocs\DuckVintage\resources\views/policies/terms.blade.php ENDPATH**/ ?>
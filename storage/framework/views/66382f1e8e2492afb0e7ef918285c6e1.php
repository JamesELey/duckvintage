

<?php $__env->startSection('title', 'Cookie Policy - Duck Vintage'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1 style="margin-bottom: 2rem;">Cookie Policy</h1>
    
    <div class="card">
        <div class="card-body">
            <p><strong>Last Updated:</strong> <?php echo e(date('F d, Y')); ?></p>
            
            <h2>1. What Are Cookies?</h2>
            <p>Cookies are small text files that are placed on your device when you visit our website. They help us provide you with a better experience by remembering your preferences and analyzing how you use our site.</p>
            
            <h2>2. How We Use Cookies</h2>
            <p>We use cookies for the following purposes:</p>
            
            <h3>Essential Cookies (Required)</h3>
            <p>These cookies are necessary for the website to function properly. They enable core functionality such as:</p>
            <ul>
                <li>Authentication and security</li>
                <li>Shopping cart functionality</li>
                <li>Session management</li>
                <li>Security measures</li>
            </ul>
            <p><strong>These cookies cannot be disabled as they are essential for the site to work.</strong></p>
            
            <h3>Functional Cookies</h3>
            <p>These cookies enhance functionality and personalization:</p>
            <ul>
                <li>Remembering your preferences</li>
                <li>Language settings</li>
                <li>Region selection</li>
            </ul>
            
            <h3>Analytics Cookies</h3>
            <p>These cookies help us understand how visitors interact with our website:</p>
            <ul>
                <li>Pages visited</li>
                <li>Time spent on site</li>
                <li>Traffic sources</li>
                <li>Error reporting</li>
            </ul>
            
            <h3>Marketing Cookies</h3>
            <p>These cookies track your visit across websites to display relevant advertisements:</p>
            <ul>
                <li>Track marketing campaign effectiveness</li>
                <li>Deliver personalized content</li>
                <li>Social media integration</li>
            </ul>
            
            <h2>3. Types of Cookies We Use</h2>
            
            <h3>Session Cookies</h3>
            <p>Temporary cookies that expire when you close your browser. These are essential for shopping cart functionality and user authentication.</p>
            
            <h3>Persistent Cookies</h3>
            <p>These cookies remain on your device for a set period or until you delete them. They remember your preferences for future visits.</p>
            
            <h2>4. Third-Party Cookies</h2>
            <p>We may use third-party service providers who also set cookies on your device:</p>
            <ul>
                <li><strong>Stripe:</strong> For secure payment processing</li>
                <li><strong>Google Analytics:</strong> For website analytics (if enabled)</li>
                <li><strong>Social Media Platforms:</strong> For social sharing features</li>
            </ul>
            
            <h2>5. Managing Cookies</h2>
            <p>You have several options to manage cookies:</p>
            
            <h3>Browser Settings</h3>
            <p>Most web browsers allow you to control cookies through their settings. You can:</p>
            <ul>
                <li>View what cookies are stored</li>
                <li>Delete specific or all cookies</li>
                <li>Block cookies from specific websites</li>
                <li>Block third-party cookies</li>
                <li>Block all cookies (not recommended as it may affect functionality)</li>
            </ul>
            
            <h3>How to Manage Cookies in Your Browser:</h3>
            <ul>
                <li><strong>Chrome:</strong> Settings > Privacy and Security > Cookies</li>
                <li><strong>Firefox:</strong> Options > Privacy & Security > Cookies and Site Data</li>
                <li><strong>Safari:</strong> Preferences > Privacy > Cookies and website data</li>
                <li><strong>Edge:</strong> Settings > Cookies and site permissions</li>
            </ul>
            
            <h3>Cookie Consent</h3>
            <p>When you first visit our website, we ask for your consent to use non-essential cookies. You can change your preferences at any time by clicking the "Cookie Preferences" link in the footer.</p>
            
            <h2>6. Impact of Disabling Cookies</h2>
            <p>If you disable cookies, please note that:</p>
            <ul>
                <li>You may not be able to use all features of our website</li>
                <li>Your shopping cart may not work properly</li>
                <li>You'll need to log in each time you visit</li>
                <li>Your preferences won't be saved</li>
            </ul>
            
            <h2>7. Do Not Track Signals</h2>
            <p>Some browsers include a "Do Not Track" (DNT) feature. Our website currently does not respond to DNT signals, but we respect your privacy choices and provide clear cookie management options.</p>
            
            <h2>8. Updates to This Policy</h2>
            <p>We may update this Cookie Policy from time to time to reflect changes in technology or legislation. Please check this page regularly for updates.</p>
            
            <h2>9. Contact Us</h2>
            <p>If you have questions about our use of cookies, please contact us:</p>
            <ul>
                <li>Email: privacy@duckvintage.com</li>
                <li>Address: [Your Business Address]</li>
            </ul>
            
            <div class="mt-4">
                <a href="<?php echo e(route('privacy-policy')); ?>" class="btn btn-secondary">Privacy Policy</a>
                <a href="<?php echo e(route('terms-of-service')); ?>" class="btn btn-secondary">Terms of Service</a>
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


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8_2\htdocs\DuckVintage\resources\views/policies/cookies.blade.php ENDPATH**/ ?>
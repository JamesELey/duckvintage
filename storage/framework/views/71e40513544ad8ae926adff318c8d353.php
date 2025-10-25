

<?php $__env->startSection('title', $blog->meta_title ?? $blog->title); ?>
<?php $__env->startSection('meta_description', $blog->meta_description ?? $blog->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($blog->content), 160)); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <article itemscope itemtype="http://schema.org/BlogPosting">
        <!-- Breadcrumb Navigation -->
        <nav style="margin-bottom: 2rem; font-size: 0.9rem; color: #999;">
            <a href="<?php echo e(route('home')); ?>" style="color: #FFD700;">Home</a> / 
            <a href="<?php echo e(route('blog.index')); ?>" style="color: #FFD700;">Blog</a> / 
            <span><?php echo e($blog->title); ?></span>
        </nav>

        <!-- Featured Image -->
        <?php if($blog->featured_image): ?>
            <div style="margin-bottom: 2rem;">
                <img src="<?php echo e($blog->featured_image); ?>" alt="<?php echo e($blog->title); ?>" itemprop="image" style="width: 100%; max-height: 500px; object-fit: cover; border-radius: 8px;">
            </div>
        <?php endif; ?>

        <!-- Post Header -->
        <header style="margin-bottom: 2rem;">
            <h1 itemprop="headline" style="margin-bottom: 1rem; font-size: 2.5rem;"><?php echo e($blog->title); ?></h1>
            
            <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; margin-bottom: 1rem; font-size: 0.95rem; color: #ccc;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span>📅</span>
                    <time itemprop="datePublished" datetime="<?php echo e($blog->published_at->toIso8601String()); ?>">
                        <?php echo e($blog->formatted_date); ?>

                    </time>
                </div>
                
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span>✍️</span>
                    <span itemprop="author" itemscope itemtype="http://schema.org/Person">
                        <span itemprop="name"><?php echo e($blog->author->name); ?></span>
                    </span>
                </div>
                
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span>📖</span>
                    <span><?php echo e($blog->reading_time); ?> min read</span>
                </div>
                
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span>👁️</span>
                    <span><?php echo e(number_format($blog->views)); ?> views</span>
                </div>
            </div>

            <?php if($blog->excerpt): ?>
                <p itemprop="description" style="font-size: 1.2rem; line-height: 1.6; color: #ccc; font-style: italic; padding: 1rem; background-color: #1a1a1a; border-left: 4px solid #FFD700; border-radius: 4px;">
                    <?php echo e($blog->excerpt); ?>

                </p>
            <?php endif; ?>
        </header>

        <!-- Post Content -->
        <div itemprop="articleBody" style="line-height: 1.8; font-size: 1.1rem; margin-bottom: 3rem;">
            <?php echo nl2br(e($blog->content)); ?>

        </div>

        <!-- Meta Information -->
        <meta itemprop="dateModified" content="<?php echo e($blog->updated_at->toIso8601String()); ?>">
        <meta itemprop="wordCount" content="<?php echo e(str_word_count(strip_tags($blog->content))); ?>">
        <div itemprop="publisher" itemscope itemtype="http://schema.org/Organization" style="display: none;">
            <meta itemprop="name" content="Duck Vintage">
            <meta itemprop="url" content="<?php echo e(url('/')); ?>">
        </div>

        <!-- Social Sharing -->
        <div style="margin: 3rem 0; padding: 2rem; background-color: #1a1a1a; border-radius: 8px;">
            <h3 style="margin-bottom: 1rem; color: #FFD700;">Share this article</h3>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="https://twitter.com/intent/tweet?url=<?php echo e(urlencode(route('blog.show', $blog->slug))); ?>&text=<?php echo e(urlencode($blog->title)); ?>" target="_blank" class="btn btn-secondary">
                    🐦 Twitter
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e(urlencode(route('blog.show', $blog->slug))); ?>" target="_blank" class="btn btn-secondary">
                    👍 Facebook
                </a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo e(urlencode(route('blog.show', $blog->slug))); ?>" target="_blank" class="btn btn-secondary">
                    💼 LinkedIn
                </a>
            </div>
        </div>
    </article>

    <!-- Related Posts -->
    <?php if($relatedPosts->count() > 0): ?>
        <section style="margin-top: 4rem;">
            <h2 style="margin-bottom: 2rem; text-align: center;">Related Articles</h2>
            <div class="grid" style="gap: 2rem;">
                <?php $__currentLoopData = $relatedPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article class="card">
                        <div class="card-body">
                            <h3 style="margin-bottom: 0.5rem;">
                                <a href="<?php echo e(route('blog.show', $related->slug)); ?>" style="color: #FFD700; text-decoration: none;">
                                    <?php echo e($related->title); ?>

                                </a>
                            </h3>
                            <p style="font-size: 0.9rem; color: #999; margin-bottom: 1rem;">
                                <?php echo e($related->formatted_date); ?> • <?php echo e($related->reading_time); ?> min read
                            </p>
                            <?php if($related->excerpt): ?>
                                <p style="margin-bottom: 1rem; line-height: 1.6;"><?php echo e(\Illuminate\Support\Str::limit($related->excerpt, 100)); ?></p>
                            <?php endif; ?>
                            <a href="<?php echo e(route('blog.show', $related->slug)); ?>" class="btn btn-secondary">Read More</a>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </section>
    <?php endif; ?>
</div>

<!-- Structured Data (JSON-LD) for SEO -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BlogPosting",
  "headline": "<?php echo e(addslashes($blog->title)); ?>",
  "description": "<?php echo e(addslashes($blog->meta_description ?? $blog->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($blog->content), 160))); ?>",
  "image": "<?php echo e($blog->featured_image ?? asset('fm_duck_02.png')); ?>",
  "author": {
    "@type": "Person",
    "name": "<?php echo e($blog->author->name); ?>"
  },
  "publisher": {
    "@type": "Organization",
    "name": "Duck Vintage",
    "logo": {
      "@type": "ImageObject",
      "url": "<?php echo e(asset('duck_logo_nav.png')); ?>"
    }
  },
  "datePublished": "<?php echo e($blog->published_at->toIso8601String()); ?>",
  "dateModified": "<?php echo e($blog->updated_at->toIso8601String()); ?>",
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "<?php echo e(route('blog.show', $blog->slug)); ?>"
  },
  "wordCount": <?php echo e(str_word_count(strip_tags($blog->content))); ?>,
  "articleBody": "<?php echo e(addslashes(strip_tags($blog->content))); ?>"
}
</script>

<!-- Additional SEO Tags -->
<link rel="canonical" href="<?php echo e(route('blog.show', $blog->slug)); ?>">
<meta property="og:type" content="article">
<meta property="article:published_time" content="<?php echo e($blog->published_at->toIso8601String()); ?>">
<meta property="article:modified_time" content="<?php echo e($blog->updated_at->toIso8601String()); ?>">
<meta property="article:author" content="<?php echo e($blog->author->name); ?>">
<?php if($blog->meta_keywords): ?>
    <meta name="keywords" content="<?php echo e($blog->meta_keywords); ?>">
<?php endif; ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8_2\htdocs\DuckVintage\resources\views/blog/show.blade.php ENDPATH**/ ?>


<?php $__env->startSection('title', 'Blog - Duck Vintage'); ?>
<?php $__env->startSection('meta_description', 'Read the latest articles about vintage fashion, styling tips, and sustainable clothing from Duck Vintage.'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1 style="margin-bottom: 2rem; text-align: center;">Duck Vintage Blog</h1>
    <p style="text-align: center; font-size: 1.1rem; margin-bottom: 3rem; color: #ccc;">
        Discover vintage fashion trends, styling tips, and stories behind our curated collection.
    </p>

    <?php if($posts->count() > 0): ?>
        <div class="grid" style="gap: 2rem;">
            <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="card" style="height: 100%;">
                    <?php if($post->featured_image): ?>
                        <img src="<?php echo e($post->featured_image); ?>" alt="<?php echo e($post->title); ?>" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px 8px 0 0;">
                    <?php endif; ?>
                    <div class="card-body">
                        <h2 style="margin-bottom: 1rem;">
                            <a href="<?php echo e(route('blog.show', $post->slug)); ?>" style="color: #FFD700; text-decoration: none;">
                                <?php echo e($post->title); ?>

                            </a>
                        </h2>
                        
                        <div style="display: flex; gap: 1rem; margin-bottom: 1rem; font-size: 0.9rem; color: #999;">
                            <span><?php echo e($post->formatted_date); ?></span>
                            <span>•</span>
                            <span>By <?php echo e($post->author->name); ?></span>
                            <span>•</span>
                            <span><?php echo e($post->reading_time); ?> min read</span>
                        </div>

                        <?php if($post->excerpt): ?>
                            <p style="margin-bottom: 1rem; line-height: 1.6;"><?php echo e($post->excerpt); ?></p>
                        <?php endif; ?>

                        <a href="<?php echo e(route('blog.show', $post->slug)); ?>" class="btn btn-secondary">Read More</a>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div style="margin-top: 3rem;">
            <?php echo e($posts->links()); ?>

        </div>
    <?php else: ?>
        <div class="card">
            <div class="card-body" style="text-align: center; padding: 3rem;">
                <h2>No Posts Yet</h2>
                <p>Check back soon for exciting content about vintage fashion!</p>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8_2\htdocs\DuckVintage\resources\views/blog/index.blade.php ENDPATH**/ ?>
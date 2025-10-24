

<?php $__env->startSection('title', 'Blog Posts Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Blog Posts</h2>
            <a href="<?php echo e(route('admin.blog.create')); ?>" class="btn">Create New Post</a>
        </div>
        <div class="card-body">
            <?php if($posts->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Published</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <strong><?php echo e($post->title); ?></strong>
                                        <br>
                                        <small style="color: #999;">/blog/<?php echo e($post->slug); ?></small>
                                    </td>
                                    <td><?php echo e($post->author->name); ?></td>
                                    <td>
                                        <span class="badge" style="background-color: <?php echo e($post->status === 'published' ? '#28a745' : '#ffc107'); ?>; color: #000; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem;">
                                            <?php echo e(ucfirst($post->status)); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e(number_format($post->views)); ?></td>
                                    <td><?php echo e($post->formatted_date); ?></td>
                                    <td>
                                        <div style="display: flex; gap: 0.5rem;">
                                            <?php if($post->status === 'published'): ?>
                                                <a href="<?php echo e(route('blog.show', $post->slug)); ?>" target="_blank" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.9rem;">View</a>
                                            <?php endif; ?>
                                            <a href="<?php echo e(route('admin.blog.edit', $post->id)); ?>" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Edit</a>
                                            <form action="<?php echo e(route('admin.blog.destroy', $post->id)); ?>" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn" style="background-color: #dc3545; padding: 0.5rem 1rem; font-size: 0.9rem;">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 2rem;">
                    <?php echo e($posts->links()); ?>

                </div>
            <?php else: ?>
                <p style="text-align: center; padding: 2rem;">No blog posts yet. <a href="<?php echo e(route('admin.blog.create')); ?>">Create your first post!</a></p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8_2\htdocs\DuckVintage\resources\views/admin/blog/index.blade.php ENDPATH**/ ?>
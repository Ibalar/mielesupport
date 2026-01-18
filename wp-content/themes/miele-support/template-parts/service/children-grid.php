<?php
$children = get_children([
    'post_type' => 'service',
    'post_parent' => get_the_ID(),
]);
?>

<?php if ($children): ?>
    <section class="service-children">
        <?php foreach ($children as $child): ?>
            <a href="<?php echo get_permalink($child->ID); ?>">
                <?php echo esc_html($child->post_title); ?>
            </a>
        <?php endforeach; ?>
    </section>
<?php endif; ?>

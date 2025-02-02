<?php
$backend_screenshot_section_id = isset($options['backend_screenshot_section_id']) ? $options['backend_screenshot_section_id'] : 'screenshots';
$backend_screenshot_section_title = isset($options['backend_screenshot_section_title']) ? $options['backend_screenshot_section_title'] : '';
$backend_screenshot_section_subtitle = isset($options['backend_screenshot_section_subtitle']) ? $options['backend_screenshot_section_subtitle'] : '';
$backend_screenshot_items = isset($options['backend_screenshot_items']) ? $options['backend_screenshot_items'] : '';
?>

<section id="<?php echo esc_attr($backend_screenshot_section_id); ?>"
    class="py-12 ta-featured md:py-20">
    <div class="container px-4 mx-auto">
        <div class="max-w-3xl mx-auto mb-12 text-center">
            <?php if ($backend_screenshot_section_title) : ?>
                <h2 class="text-ta-section-title -mt-1.5 mb-0">
                    <?php echo wp_kses_post($backend_screenshot_section_title); ?>
                </h2>
            <?php endif;
            if ($backend_screenshot_section_subtitle) :
            ?>
                <span class="inline-block mt-5 text-lg font-normal"><?php echo wp_kses_post($backend_screenshot_section_subtitle); ?></span>
            <?php endif; ?>
        </div>
        <div class="gallery">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:gap-6 xl:gap-8 md:grid-cols-3 lg:grid-cols-4">
                <?php
                if (!empty($backend_screenshot_items)) {
                    foreach ($backend_screenshot_items as $item) :
                        $backend_screenshot_image = isset($item['backend_screenshot_image']['url']) ? $item['backend_screenshot_image']['url'] : '';
                ?>
                        <a class="gallery_item" href="<?php echo esc_url($backend_screenshot_image) ?>" data-fancybox="gallery">
                            <div class="gallery_item_icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                                </svg>
                            </div>
                            <img src="<?php echo esc_url($backend_screenshot_image) ?>" alt="Thumbnail 1" />
                        </a>
                <?php
                    endforeach;
                }
                ?>
            </div>
        </div>
    </div>
</section>
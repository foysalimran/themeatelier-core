<?php
$layout_section_title = isset($options['layout_section_title']) ? $options['layout_section_title'] : '';
$layout_section_subtitle = isset($options['layout_section_subtitle']) ? $options['layout_section_subtitle'] : '';
$layout_items = isset($options['layout_items']) ? $options['layout_items'] : '';
?>

<section
    class="py-12 layouts tabs md:py-20 demo_section_bg">
    <div class="container px-4 mx-auto">
        <div class="max-w-3xl mx-auto mb-12 text-center">
            <?php if ($layout_section_title) : ?>
                <h2 class="text-ta-section-title -mt-1.5 mb-0">
                    <?php echo wp_kses_post($layout_section_title); ?>
                </h2>
            <?php endif;
            if ($layout_section_subtitle) : ?>
                <span class="inline-block mt-5 text-lg font-normal"><?php echo wp_kses_post($layout_section_subtitle) ?></span>
            <?php endif; ?>
        </div>
        <!-- Tabs -->
        <div class="flex flex-wrap justify-center gap-3 mb-2">
            <?php if (!empty($layout_items)) :
                $index = 0;
                foreach ($layout_items as $item) :
                    if ($item['layout_title']) :
            ?>
                        <button class="demo_btn_secondary !py-2 tab <?php echo ($index === 0) ? 'tab-active' : ''; ?>">
                            <?php echo esc_html($item['layout_title']); ?>
                        </button>
            <?php
                    endif;
                    $index++;
                endforeach;
            endif;
            ?>
        </div>

        <div class="border border-solid rounded-lg shadow-md mt-9 tab-content border-border-color">
            <?php if (!empty($layout_items)) :
                $index = 0;
                foreach ($layout_items as $item) :
                    if ($item['layout_image']['url']) :
            ?>
                        <div class="tab-pane <?php echo ($index === 0) ? 'tab-pane-active' : ''; ?>">
                            <img class="rounded-lg" src="<?php echo esc_url($item['layout_image']['url']) ?>" alt="">
                        </div>
            <?php
                    endif;
                    $index++;
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>
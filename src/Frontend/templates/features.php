<?php
$features_section_id = isset($options['features_section_id']) ? $options['features_section_id'] : 'features';
$features_section_title = isset($options['features_section_title']) ? $options['features_section_title'] : '';
$features_section_subtitle = isset($options['features_section_subtitle']) ? $options['features_section_subtitle'] : '';
$features_items     = isset($options['features_items']) ? $options['features_items'] : '';
$cta_v2_title       = isset($options['cta_v2_title']) ? $options['cta_v2_title'] : '';
$cta_v2_subtitle    = isset($options['cta_v2_subtitle']) ? $options['cta_v2_subtitle'] : '';
$cta_v2_link        = isset($options['cta_v2_link']) ? $options['cta_v2_link'] : '';
$cta_v2_link_url    = isset($cta_v2_link['url']) ? $cta_v2_link['url'] : '';
$cta_v2_link_text   = isset($cta_v2_link['text']) ? $cta_v2_link['text'] : '';
$cta_v2_money_back_guarantee   = isset($options['cta_v2_money_back_guarantee']) ? $options['cta_v2_money_back_guarantee'] : '';
?>

<section id="<?php echo esc_attr($features_section_id); ?>"
    class="py-12 ta-featured md:py-20" id="features">
    <div class="container px-4 mx-auto">
        <div class="max-w-3xl mx-auto mb-12 text-center">
            <?php if ($features_section_title) : ?>
                <h2 class="text-ta-section-title -mt-1.5 mb-0">
                    <?php echo wp_kses_post($features_section_title); ?>
                </h2>
            <?php endif;
            if ($features_section_subtitle) :
            ?>
                <span class="inline-block mt-5 text-lg font-normal"><?php echo wp_kses_post($features_section_subtitle) ?></span>
            <?php endif; ?>
        </div>

        <div class="space-y-20">
            <?php
            if ($features_items) :
                foreach ($features_items as $index => $item) :
                    $features_title = isset($item['features_title']) ? $item['features_title'] : '';
                    $features_description = isset($item['features_description']) ? $item['features_description'] : '';
                    $features_link_text = isset($item['features_link']['text']) ? $item['features_link']['text'] : '';
                    $features_link_url = isset($item['features_link']['url']) ? $item['features_link']['url'] : '';
                    $features_image_position = isset($item['features_image_position']) ? $item['features_image_position'] : '';
                    $features_image = isset($item['features_image']['url']) ? $item['features_image']['url'] : '';
            ?>
                    <div class="grid items-center gap-10 mb-20 lg:grid-cols-2">
                        <?php if ($features_image_position == 'left') : ?>
                            <div class="">
                                <img src="<?php echo esc_url($features_image); ?>" alt="">
                            </div>
                        <?php endif; ?>
                        <div class="">
                            <?php if ($features_title) : ?>
                                <h1 class="mb-0 text-4xl xl:text-ta-section-title">
                                    <?php echo esc_html__($features_title); ?>
                                </h1>
                            <?php endif;
                            if ($features_description) :
                                echo wp_kses_post($features_description);
                            endif;
                            if ($features_link_text) :
                            ?>
                                <a target="_blank" href="<?php echo esc_url($features_link_url); ?>" class="mt-9 demo_btn_secondary !py-2 group"><?php echo esc_html($features_link_text) ?></a>
                            <?php endif; ?>
                        </div>
                        <?php if ($features_image_position == 'right') : ?>
                            <div class="">
                                <img src="<?php echo esc_url($features_image); ?>" alt="">
                            </div>
                        <?php endif; ?>
                    </div>
            <?php endforeach;
            endif;
            ?>
            <div class="p-0 overflow-hidden rounded-lg demo_primary_bg">
                <div class="grid items-center grid-cols-12 gap-8 features_cta">
                    <div class="col-span-12 text-center lg:col-span-8 lg:text-start">
                        <?php if ($cta_v2_title) : ?>
                            <h3 class="mb-2 text-4xl text-white xl:text-ta-section-title">
                                <?php echo esc_html($cta_v2_title); ?>
                            </h3>
                        <?php endif; ?>
                        <?php if ($cta_v2_subtitle) : ?>
                            <p class="text-xl text-white"><?php echo wp_kses_post($cta_v2_subtitle) ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="flex justify-center col-span-12 text-center lg:justify-end lg:col-span-4">
                        <div class="">
                            <a href="<?php echo esc_url($cta_v2_link_url) ?>" class="!rounded-md demo_btn_primary call_to_btn mb-1"><?php echo esc_html($cta_v2_link_text) ?></a>
                            <p class="text-sm text-white"><?php echo wp_kses_post($cta_v2_money_back_guarantee) ?></a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
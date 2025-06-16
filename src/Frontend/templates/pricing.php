<?php 
$pricing_section_id = isset($options['pricing_section_id']) ? $options['pricing_section_id'] : 'pricing';
$pricing_section_title = isset($options['pricing_section_title']) ? $options['pricing_section_title'] : '';
$pricing_section_subtitle = isset($options['pricing_section_subtitle']) ? $options['pricing_section_subtitle'] : '';
$pricing_table = !empty($options['pricing_table']) ? $options['pricing_table'] : [];
$pricing_table_yearly = !empty($pricing_table['pricing_table_yearly']) ? $pricing_table['pricing_table_yearly'] : [];
$yearly_description = !empty($pricing_table['yearly_description']) ? $pricing_table['yearly_description'] : [];
$pricing_table_lifetime = !empty($pricing_table['pricing_table_lifetime']) ? $pricing_table['pricing_table_lifetime'] : [];
$lifetime_description = !empty($pricing_table['lifetime_description']) ? $pricing_table['lifetime_description'] : [];
?>

<section id="<?php echo esc_attr($pricing_section_id); ?>" class="py-12 pricing tabs md:py-20 demo_section_bg">
    <div class="container px-4 mx-auto">
        <div class="max-w-3xl mx-auto mb-12 text-center">
            <?php if($pricing_section_title) : ?>
            <h2 class="text-ta-section-title -mt-1.5 mb-0">
                <?php echo $pricing_section_title; ?>
            </h2>
            <?php endif; ?>
            <?php if($pricing_section_subtitle) : ?>
            <span class="inline-block mt-5 text-lg font-normal"><?php echo $pricing_section_subtitle; ?></span>
            <?php endif; ?>
        </div>
        <!-- Tabs -->
        <div class="flex justify-center gap-3 mb-2 shadow-md w-[fit-content] rounded-md mx-auto bg-white p-3">
            <button class="demo_btn_secondary !py-2 tab tab-active">Yearly</button>
            <button class="demo_btn_secondary !py-2 tab">Lifetime</button>
        </div>
        <div class="mt-9 tab-content">
            <div class="tab-pane tab-pane-active">
                <div class="grid grid-cols-1 lg:grid-cols-3 lg:border-[1.5px] lg:border-solid rounded-lg demo_border_primary">
                    <?php if($pricing_table_yearly) :
                        ?>
                        <?php foreach($pricing_table_yearly as $yearly) : 
                            
                            $yearly_title = $yearly['yearly_title'];
                            $yearly_subtitle = $yearly['yearly_subtitle'];
                            $yearly_price = $yearly['yearly_price'];
                            $yearly_parches_button = $yearly['yearly_parches_button'];
                            $yearly_parches_button_url = $yearly['yearly_parches_button']['url'];
                            $is_yearly_popular = $yearly['is_yearly_popular'];
                            $yearly_features = $yearly['yearly_features'];
                            ?>
                    <div class="p-6 lg:p-10 pricing_item border-[1.5px] border-solid lg:border-0 lg:border-none rounded-md mb-4 lg:rounded-none lg:mb-0 demo_border_primary <?php if($is_yearly_popular): ?>popular<?php endif;?>">
                        <?php if($yearly_title) : ?>
                            <h3 class="text-2xl text-center"><?php echo esc_html($yearly_title); ?></h3>
                        <?php endif; ?>
                        <?php if($yearly_subtitle) :  ?>
                            <p class="text-center"><?php echo esc_html($yearly_subtitle); ?></p>
                        <?php endif; ?>
                       <?php if($yearly_price) : ?>
                        <div class="flex items-end justify-center">
                            <p class="mb-0 text-lg font-bold">$</p>
                            <h4 class="text-4xl font-bold"><?php echo esc_html($yearly_price); ?></h4>
                            <p class="mb-0">/ Yearly</p>
                        </div>
                        <?php endif; ?>
                        <hr class="mt-10 mb-10 bg-secondary text-secondary">
                        <a href="<?php echo esc_url($yearly_parches_button_url); ?>" class="demo_btn_secondary !py-2 w-full">Buy Now</a>
                        <div class="h-8"></div>
                        <?php echo wp_kses_post($yearly_features); ?>
                        
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <?php if($yearly_description) : ?>
                <p class="mt-10 mb-0 text-center"><?php echo wp_kses_post($yearly_description); ?></p>
                <?php endif; ?>
            </div>
            <div class="tab-pane">
                <div class="grid grid-cols-1 lg:grid-cols-3 lg:border-[1.5px] lg:border-solid rounded-lg demo_border_primary">
                    <?php if($pricing_table_lifetime) : ?>
                        <?php foreach($pricing_table_lifetime as $lifetime) : 
            
                            $lifetime_title = $lifetime['lifetime_title'];
                            $lifetime_subtitle = $lifetime['lifetime_subtitle'];
                            $lifetime_price = $lifetime['lifetime_price'];
                            $lifetime_parches_button = $lifetime['lifetime_parches_button'];
                            $lifetime_parches_button_url = $lifetime['lifetime_parches_button']['url'];
                            $is_lifetime_popular = $lifetime['is_lifetime_popular'];
                            $lifetime_features = $lifetime['lifetime_features'];
                            ?>
                    <div class="p-6 lg:p-10 pricing_item border-[1.5px] border-solid lg:border-0 lg:border-none rounded-md mb-4 lg:rounded-none lg:mb-0 demo_border_primary <?php if($is_lifetime_popular): ?>popular<?php endif; ?>">
                        <?php if($lifetime_title) : ?>
                            <h3 class="text-2xl text-center"><?php echo esc_html($lifetime_title); ?></h3>
                        <?php endif; ?>
                        <?php if($lifetime_subtitle) : ?>
                            <p class="text-center"><?php echo esc_html($lifetime_subtitle); ?></p>
                        <?php endif; ?>
                        <?php if($lifetime_price): ?>
                        <div class="flex items-end justify-center">
                            <p class="mb-0 text-lg font-bold">$</p>
                            <h4 class="text-4xl font-bold"><?php echo esc_html($lifetime_price); ?></h4>
                            <p class="mb-0">/ Lifetime</p>
                        </div>
                        <?php endif; ?>
                        <hr class="mt-10 mb-10 bg-secondary text-secondary">
                        <a href="<?php echo esc_url($lifetime_parches_button_url); ?>" class="demo_btn_secondary !py-2 w-full">Buy Now</a>
                        <div class="h-8"></div>
                        <?php echo wp_kses_post($lifetime_features); ?>
                       
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>

                </div>
                <?php if($lifetime_description) : ?>
                    <p class="mt-10 mb-0 text-center"><?php echo wp_kses_post($lifetime_description); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
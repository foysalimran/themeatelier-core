<?php 
$money_back_section_id = isset($options['money_back_section_id']) ? $options['money_back_section_id'] : 'mony_back';
$money_back_title = isset($options['money_back_title']) ? $options['money_back_title'] : '';
$money_back_description = isset($options['money_back_description']) ? $options['money_back_description'] : '';
$money_back_payment_terms = isset($options['money_back_payment_terms']) ? $options['money_back_payment_terms'] : '';
$money_back_payment_type = isset($options['money_back_payment_type']) ? $options['money_back_payment_type'] : '';
$money_back_payment_type_icon = isset($options['money_back_payment_type_icon']) ? $options['money_back_payment_type_icon'] : '';

$docs = !empty($options['docs_link']) ? $options['docs_link'] : [];
$download_id = get_the_ID();
$last_updated = get_post_modified_time( 'F j, Y', false, $download_id, true );
$version_number = get_post_meta( $download_id, '_edd_sl_version', true );
$changelog = get_post_meta( $download_id, '_edd_sl_changelog', true );

?>

<section id="<?php echo esc_attr($money_back_section_id); ?>" class="py-12 money-back md:py-20">
    <div class="container px-4 mx-auto">
        <div class="grid grid-cols-12">
            <div class="lg:col-span-1"></div>
            <div class="col-span-12 lg:col-span-10">
                <div class="p-10 mb-12 border border-solid rounded-lg shadow-md border-secondary">
                    <div class="justify-center gap-2 money-back_content">
                        <div class="mony-back_image">
                            <img width="148px" height="136px" src="<?php echo get_template_directory_uri(); ?>/assets/images/money-back-guaranteed.svg" alt="">
                        </div>
                        <div class="">
                            <?php if($money_back_title): ?>
                                <h2 class="mb-5 text-3xl"><?php echo esc_html($money_back_title); ?></h2>
                            <?php endif; ?>
                            <?php if($money_back_description) : ?>
                            <p class="mb-0">
                            <?php echo wp_kses_post($money_back_description); ?>
                            </p>
                        <?php endif; ?>
                        </div>
                    </div>
                    <hr class="mt-10 mb-6 bg-secondary text-secondary">
                    <div class="grid items-center grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">
                        <?php if($money_back_payment_terms) : ?>
                        <p class="mb-0"><?php echo esc_html($money_back_payment_terms); ?></p>
                        <?php endif;?>
                        <?php if($money_back_payment_type) : ?>
                        <div class="flex justify-center text-center">
                        <span class="inline-block px-3 py-1 rounded text-lime-50 demo_primary_bg"><?php echo esc_html($money_back_payment_type); ?></span>
                        </div>
                         <?php endif; ?>
                         <?php if($money_back_payment_type_icon['url']) : ?>
                        <div class="flex justify-center text-end">
                            <img src="<?php echo esc_url($money_back_payment_type_icon['url']); ?>" alt="">
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="p-10 bg-white border rounded-lg shadow-md border-md border-secondary">
                    <div class="grid items-center grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4">
                        <div class="changelog_item">
                            <div class="w-10 h-10">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Update.svg" alt="">
                            </div>
                            <div class="changelog_item_content">
                                <h4>Last Update</h4>
                                <p><?php echo esc_html($last_updated); ?></p>
                            </div>
                        </div>
                        <div class="changelog_item">
                            <div class="w-10 h-10">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/current-version.svg" alt="">
                            </div>
                            <div class="changelog_item_content">
                                <h4>Current Version</h4>
                                <p><?php echo esc_html($version_number); ?></p>
                            </div>
                        </div>
                        <div class="changelog_item">
                            <div class="w-10 h-10">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Changelog.svg" alt="">
                            </div>
                            <div class="changelog_item_content">
                                <h4>Changelog</h4>
                                <p class="cursor-pointer demo_text_primary changelog_btn">View Changelog</p>

                                <!-- Popup Container -->
                                <div id="popup" class="fixed inset-0 z-[9999999] flex items-center justify-center hidden bg-black bg-opacity-50">
                                    <div class="relative w-1/3 bg-white shadow-lg">
                                        <button id="closePopup" class="absolute w-6 h-6 text-gray-500 bg-white rounded-full top-2 right-2 hover:text-gray-800">
                                            &times;
                                        </button>
                                        <h2 class="p-4 text-xl font-semibold text-white demo_primary_bg"><?php echo get_the_title(); ?> Changelog</h2>
                                        <div class="p-4 h-[400px] overflow-y-scroll">
                                        <?php echo wp_kses_post($changelog); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="changelog_item">
                            <div class="w-10 h-10">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Documentation.svg" alt="">
                            </div>
                            <div class="changelog_item_content">
                                <h4>Documentation</h4>
                                <p><a class="text-[#0F8C7E]" href="<?php echo esc_url($docs['url']); ?>" target="_blank">View Docs</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-1"></div>
        </div>
    </div>
</section>
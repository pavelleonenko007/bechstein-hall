<footer class="footer">
    <div class="foo-mom">
        <div class="footer-container top-container">
            <?php $footer_columns = get_field('footer', 'option');
            foreach ($footer_columns as $index => $footer_column) : ?>
                <?php $classes = [
                    'footer-col'
                ];
                if ($index === 0) {
                    $classes[] = '_1';
                    $classes[] = 'top-col';
                } elseif ($index === 1) {
                    $classes[] = 'top-col';
                    $classes[] = 'center-col';
                } elseif ($index === 2) {
                    $classes[] = '_3';
                    $classes[] = 'top-col';
                }
                ?>
                <div id="w-node-e1be876e-05a4-9245-628d-78602bcc79a4-2bcc79a3" class="<?php echo implode(' ', $classes); ?>">
                    <?php $column_elements = $footer_column['footer_elements'];
                    foreach ($column_elements as $column_element) : ?>
                        <?php if ($column_element['acf_fc_layout'] === 'big_link') :
                            if (!bech_is_current_url($column_element['url'])) : ?>
                                <a href="<?php echo $column_element['url']; ?>" class="link-foo-big"><?php echo $column_element['link_title']; ?></a>
                            <?php else : ?>
                                <div class="link-foo-big w--current"><?php echo $column_element['link_title']; ?></div>
                            <?php endif; ?>
                            <?php elseif ($column_element['acf_fc_layout'] === 'small_link') :
                            if (!bech_is_current_url($column_element['url'])) : ?>
                                <a href="<?php echo $column_element['url']; ?>" class="link-foo-small <?php echo !$column_element['show_on_mobile'] ? 'no-mob' : ''; ?>"><?php echo $column_element['link_title']; ?></a>
                            <?php else : ?>
                                <div class="link-foo-small <?php echo !$column_element['show_on_mobile'] ? 'no-mob' : ''; ?> w--current"><?php echo $column_element['link_title']; ?></div>
                            <?php endif; ?>
                        <?php elseif ($column_element['acf_fc_layout'] === 'separator') : ?>
                            <div class="foo-marger"></div>
                            <?php elseif ($column_element['acf_fc_layout'] === 'card') :
                            if (!bech_is_current_url($column_element['url'])) : ?>
                                <a href="<?php echo $column_element['url']; ?>" class="link-foo-whats_last w-inline-block">
                                    <?php echo wp_get_attachment_image($column_element['background_image']['ID'], 'large', false, [
                                        'class' => 'img-cover foters'
                                    ]); ?>
                                    <div class="text-block"><?php echo $column_element['title']; ?></div>
                                </a>
                            <?php else : ?>
                                <div class="link-foo-whats_last w-inline-block w--current">
                                    <?php echo wp_get_attachment_image($column_element['background_image']['ID'], 'large', false, [
                                        'class' => 'img-cover foters'
                                    ]); ?>
                                    <div class="text-block"><?php echo $column_element['title']; ?></div>
                                </div>
                            <?php endif; ?>
                        <?php elseif ($column_element['acf_fc_layout'] === 'desktop_hidden_links') : ?>
                            <div class="foo-bottom no-pc">
                                <?php foreach ($column_element['hidden_desktop_links'] as $hidden_desktop_link) :
                                    if (!bech_is_current_url($hidden_desktop_link['url'])) : ?>
                                        <a href="<?php echo $hidden_desktop_link['url']; ?>" class="link-foo-small _2"><?php echo $hidden_desktop_link['title']; ?></a>
                                    <?php else : ?>
                                        <div class="link-foo-small _2 w--current"><?php echo $hidden_desktop_link['title']; ?></div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="footer-container bottom">
            <div class="footer-col _1">
                <div class="div-block-2">
                    <div class="p-20-27">
                        <?php $phone_number = get_field('phone_number', 'option');
                        if (!empty($phone_number)) : ?>
                            <a href="<?php echo 'tel:' . str_replace([
                                            '(',
                                            ')',
                                            '-',
                                            '–',
                                            ' '
                                        ], '', $phone_number); ?>"><?php echo $phone_number; ?></a>
                        <?php endif; ?>
                        <?php $email = get_field('email', 'option');
                        if (!empty($email)) : ?>
                            <a href="<?php echo 'mailto:' . $email; ?>"><?php echo $email; ?></a>
                        <?php endif; ?>
                        London, W1U 2RJ, 22–28 Wigmore St.
                    </div>
                </div>
                <?php $social_links = get_field('social_links', 'option');
                if (!empty($social_links)) : ?>
                    <div class="foo-soc-line">
                        <?php if ($social_links['youtube']) : ?>
                            <a href="<?php echo $social_links['youtube']; ?>" class="link-soc w-inline-block" target="_blank">
                                <div class="soc-icon w-embed">
                                    <svg class="ico-yt" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                        <circle cx="20" cy="20" r="20" fill="#030E14"></circle>
                                        <g clip-path="url(#clip0_1631_27420)">
                                            <path d="M17.5455 24.0231V16.8862L23.8182 20.4548L17.5455 24.0231ZM31.4985 14.6405C31.2225 13.6011 30.4092 12.7827 29.3766 12.5049C27.505 12.0001 20 12.0001 20 12.0001C20 12.0001 12.495 12.0001 10.6233 12.5049C9.59076 12.7827 8.77749 13.6011 8.50151 14.6405C8 16.5243 8 20.4546 8 20.4546C8 20.4546 8 24.3849 8.50151 26.2688C8.77749 27.3081 9.59076 28.1266 10.6233 28.4045C12.495 28.9092 20 28.9092 20 28.9092C20 28.9092 27.505 28.9092 29.3766 28.4045C30.4092 28.1266 31.2225 27.3081 31.4985 26.2688C32 24.3849 32 20.4546 32 20.4546C32 20.4546 32 16.5243 31.4985 14.6405Z" fill="#F5F5F0"></path>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1631_27420">
                                                <rect width="24" height="16.9091" fill="white" transform="translate(8 12)"></rect>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                            </a>
                        <?php endif; ?>
                        <?php if ($social_links['instagram']) : ?>
                            <a href="<?php echo $social_links['instagram']; ?>" class="link-soc w-inline-block" target="_blank">
                                <div class="soc-icon w-embed">
                                    <svg class="ico-in" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                        <circle cx="20" cy="20" r="20" fill="#030E14"></circle>
                                        <g clip-path="url(#clip0_1631_25901)">
                                            <path d="M15.0301 8.08417C13.7533 8.14441 12.8814 8.34817 12.1191 8.64769C11.3303 8.95513 10.6616 9.36769 9.99634 10.0354C9.33106 10.703 8.92138 11.3722 8.6161 12.1622C8.32066 12.9262 8.1205 13.7988 8.0641 15.0763C8.0077 16.3539 7.99522 16.7645 8.00146 20.0232C8.0077 23.2819 8.0221 23.6904 8.08402 24.9706C8.14498 26.2471 8.34802 27.1188 8.64754 27.8813C8.95546 28.6702 9.36754 29.3386 10.0355 30.0041C10.7034 30.6696 11.372 31.0783 12.164 31.3841C12.9272 31.6791 13.8001 31.8802 15.0774 31.9361C16.3547 31.992 16.7658 32.005 20.0235 31.9987C23.2813 31.9925 23.6915 31.9781 24.9714 31.9174C26.2513 31.8567 27.1184 31.6522 27.8811 31.3541C28.67 31.0455 29.3389 30.6341 30.0039 29.9659C30.669 29.2978 31.0784 28.6282 31.3835 27.8376C31.6791 27.0744 31.88 26.2015 31.9355 24.9252C31.9914 23.6443 32.0046 23.2354 31.9983 19.9771C31.9921 16.7189 31.9775 16.3104 31.9167 15.0307C31.856 13.751 31.6527 12.882 31.3535 12.119C31.0451 11.3302 30.6335 10.6622 29.9658 9.99625C29.2981 9.33025 28.628 8.92105 27.8377 8.61673C27.074 8.32129 26.2016 8.11993 24.9243 8.06473C23.6471 8.00953 23.2359 7.99537 19.977 8.00161C16.718 8.00785 16.31 8.02177 15.0301 8.08417ZM15.1703 29.7773C14.0003 29.7264 13.365 29.532 12.9416 29.3693C12.381 29.1533 11.9816 28.8922 11.5597 28.4743C11.1378 28.0565 10.8786 27.6557 10.6597 27.0963C10.4953 26.6729 10.2973 26.0383 10.2426 24.8683C10.1831 23.6038 10.1706 23.2241 10.1636 20.0203C10.1567 16.8166 10.1689 16.4374 10.2243 15.1723C10.2743 14.0033 10.4699 13.3673 10.6323 12.9442C10.8483 12.3828 11.1085 11.9842 11.5273 11.5625C11.9461 11.1408 12.3457 10.8811 12.9056 10.6622C13.3285 10.4971 13.9631 10.3008 15.1326 10.2451C16.3981 10.1851 16.7773 10.1731 19.9806 10.1662C23.1839 10.1592 23.564 10.1712 24.83 10.2269C25.9991 10.2778 26.6353 10.4714 27.0579 10.6349C27.6188 10.8509 28.0179 11.1103 28.4396 11.5299C28.8613 11.9494 29.1212 12.3475 29.3401 12.9086C29.5055 13.3303 29.7018 13.9647 29.757 15.1349C29.8172 16.4004 29.8309 16.7799 29.8367 19.9829C29.8424 23.1859 29.8311 23.5663 29.7757 24.8309C29.7246 26.0009 29.5307 26.6364 29.3677 27.0603C29.1517 27.6207 28.8913 28.0203 28.4723 28.4417C28.0532 28.8631 27.6541 29.1228 27.0939 29.3417C26.6715 29.5066 26.0363 29.7034 24.8677 29.7591C23.6022 29.8186 23.223 29.8311 20.0185 29.838C16.814 29.845 16.436 29.832 15.1705 29.7773H15.1703ZM24.9529 13.5866C24.9534 13.8715 25.0383 14.1498 25.197 14.3863C25.3556 14.6229 25.5808 14.8071 25.8442 14.9156C26.1075 15.0241 26.3971 15.0521 26.6764 14.9961C26.9556 14.94 27.212 14.8024 27.413 14.6006C27.614 14.3988 27.7507 14.142 27.8058 13.8625C27.8608 13.5831 27.8317 13.2936 27.7222 13.0306C27.6127 12.7677 27.4277 12.5431 27.1906 12.3854C26.9534 12.2276 26.6748 12.1437 26.39 12.1442C26.0082 12.145 25.6423 12.2974 25.3728 12.5679C25.1033 12.8384 24.9523 13.2048 24.9529 13.5866ZM13.8385 20.0122C13.8452 23.4154 16.6091 26.1679 20.0115 26.1614C23.414 26.155 26.1685 23.3914 26.162 19.9882C26.1555 16.585 23.391 13.8317 19.988 13.8384C16.5851 13.8451 13.832 16.6095 13.8385 20.0122ZM15.9999 20.0079C15.9984 19.2167 16.2314 18.4429 16.6697 17.7842C17.1079 17.1255 17.7316 16.6116 18.4619 16.3074C19.1923 16.0032 19.9964 15.9224 20.7726 16.0752C21.5489 16.228 22.2624 16.6075 22.8229 17.1659C23.3834 17.7242 23.7658 18.4362 23.9217 19.2118C24.0776 19.9874 23.9999 20.7919 23.6986 21.5234C23.3973 22.2549 22.8859 22.8806 22.2289 23.3215C21.572 23.7623 20.7991 23.9984 20.0079 24C19.4826 24.0011 18.9622 23.8987 18.4765 23.6987C17.9908 23.4986 17.5492 23.2049 17.177 22.8342C16.8048 22.4634 16.5093 22.023 16.3073 21.5381C16.1054 21.0531 16.0009 20.5332 15.9999 20.0079Z" fill="#F5F5F0"></path>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1631_25901">
                                                <rect width="24" height="24" fill="white" transform="translate(8 8)"></rect>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                            </a>
                        <?php endif; ?>
                        <?php if ($social_links['twitter']) : ?>
                            <a href="<?php echo $social_links['twitter']; ?>" class="link-soc w-inline-block" target="_blank">
                                <div class="soc-icon w-embed">
                                    <svg class="ico-tw" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                        <g clip-path="url(#clip0_1630_13060)">
                                            <path d="M20 40C31.0457 40 40 31.0457 40 20C40 8.95431 31.0457 0 20 0C8.95431 0 0 8.95431 0 20C0 31.0457 8.95431 40 20 40Z" fill="#030E14"></path>
                                            <path d="M16.3402 30.55C25.2102 30.55 30.0602 23.2 30.0602 16.83C30.0602 16.62 30.0602 16.41 30.0502 16.21C30.9902 15.53 31.8102 14.68 32.4602 13.71C31.6002 14.09 30.6702 14.35 29.6902 14.47C30.6902 13.87 31.4502 12.93 31.8102 11.8C30.8802 12.35 29.8502 12.75 28.7502 12.97C27.8702 12.03 26.6202 11.45 25.2302 11.45C22.5702 11.45 20.4102 13.61 20.4102 16.27C20.4102 16.65 20.4502 17.02 20.5402 17.37C16.5302 17.17 12.9802 15.25 10.6002 12.33C10.1902 13.04 9.95022 13.87 9.95022 14.75C9.95022 16.42 10.8002 17.9 12.1002 18.76C11.3102 18.74 10.5702 18.52 9.92021 18.16C9.92021 18.18 9.92021 18.2 9.92021 18.22C9.92021 20.56 11.5802 22.5 13.7902 22.95C13.3902 23.06 12.9602 23.12 12.5202 23.12C12.2102 23.12 11.9102 23.09 11.6102 23.03C12.2202 24.95 14.0002 26.34 16.1102 26.38C14.4602 27.67 12.3802 28.44 10.1202 28.44C9.73021 28.44 9.35021 28.42 8.97021 28.37C11.0802 29.75 13.6202 30.55 16.3402 30.55Z" fill="#F5F5F0"></path>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1630_13060">
                                                <rect width="40" height="40" fill="white"></rect>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                            </a>
                        <?php endif; ?>
                        <?php if ($social_links['facebook']) : ?>
                            <a href="<?php echo $social_links['facebook']; ?>" class="link-soc w-inline-block" target="_blank">
                                <div class="soc-icon w-embed">
                                    <svg class="ico-fb" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                        <g clip-path="url(#clip0_1630_14423)">
                                            <path d="M40 20C40 8.95434 31.0457 4.57764e-05 20 4.57764e-05C8.9543 4.57764e-05 0 8.95434 0 20C0 29.9826 7.31371 38.2567 16.875 39.7571V25.7813H11.7969V20H16.875V15.5938C16.875 10.5813 19.8609 7.81255 24.4293 7.81255C26.6175 7.81255 28.9062 8.20317 28.9062 8.20317V13.125H26.3843C23.8998 13.125 23.125 14.6667 23.125 16.2484V20H28.6719L27.7852 25.7813H23.125V39.7571C32.6863 38.2567 40 29.9826 40 20Z" fill="#030E14"></path>
                                            <path d="M27.7852 25.7812L28.6719 20H23.125V16.2483C23.125 14.6667 23.8998 13.125 26.3843 13.125H28.9063V8.20312C28.9063 8.20312 26.6175 7.8125 24.4293 7.8125C19.8609 7.8125 16.875 10.5812 16.875 15.5938V20H11.7969V25.7812H16.875V39.757C17.8932 39.9168 18.9369 40 20 40C21.0631 40 22.1068 39.9168 23.125 39.757V25.7812H27.7852Z" fill="#F5F5F0"></path>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1630_14423">
                                                <rect width="40" height="40" fill="white"></rect>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="footer-col no-mob">
                <div class="foo-bottom nz">
                    <a href="#" data-href="#moove_gdpr_cookie_modal" class="link-foo-small _2">Manage Consents</a>
                    <?php $terms_page = bech_get_page_by_slug('terms-and-conditions');
                    if ($terms_page) : ?>
                        <a href="<?php echo get_the_permalink($terms_page); ?>" class="link-foo-small _2"><?php echo get_the_title($terms_page); ?></a>
                    <?php endif; ?>
                    <?php $policy_page = bech_get_page_by_slug('privacy-policy');
                    if ($policy_page) : ?>
                        <a href="<?php echo get_the_permalink($policy_page); ?>" class="link-foo-small last"><?php echo get_the_title($policy_page); ?></a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="footer-col _3">
                <div class="foo-bottomer">
                    <div>© <?php echo date('Y'); ?>, <?php echo get_field('copyright', 'option'); ?></div>
                    <a href="https://func.agency" target="_blank" rel="nofollow" class="funk-link">Website made by Func. ↗</a>
                </div>
            </div>
        </div>
    </div>
    <?php $team_page = bech_get_page_by_slug('team');
    if (!$team_page) : ?>
        <div class="white-z"></div>
    <?php endif; ?>
</footer>
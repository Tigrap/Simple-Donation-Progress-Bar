<?php

// Admin menüye ayar sayfası ekleme
function donation_progress_bar_menu() {
    add_options_page(
        'Bağış İlerleme Çubuğu Ayarları', // Sayfa başlığı
        'Bağış İlerleme Çubuğu', // Menü adı
        'manage_options', // Gereken yetki
        'donation-progress-bar-settings', // Slug
        'donation_progress_bar_settings_page' // Callback işlevi
    );
}
add_action('admin_menu', 'donation_progress_bar_menu');

// Admin ayar sayfasının içeriği
function donation_progress_bar_settings_page() {
    ?>
    <div class="wrap">
        <h1>Bağış İlerleme Çubuğu Ayarları</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('donation_progress_bar_settings_group');
            do_settings_sections('donation-progress-bar-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Kayıt fonksiyonu
function donation_progress_bar_settings_init() {
    // Hedef, toplanan bağış, açıklama metni ve aktif/pasif alanları
    register_setting('donation_progress_bar_settings_group', 'donation_goal');
    register_setting('donation_progress_bar_settings_group', 'current_donation');
    register_setting('donation_progress_bar_settings_group', 'donation_message', 'wp_kses_post');
    register_setting('donation_progress_bar_settings_group', 'donation_bar_active');


    add_settings_section(
        'donation_progress_bar_section',
        'Bağış İlerleme Çubuğu Bilgileri',
        null,
        'donation-progress-bar-settings'
    );

    add_settings_field(
        'donation_goal',
        'Bağış Hedefi (₺)',
        'donation_goal_callback',
        'donation-progress-bar-settings',
        'donation_progress_bar_section'
    );

    add_settings_field(
        'current_donation',
        'Toplanan Bağış (₺)',
        'current_donation_callback',
        'donation-progress-bar-settings',
        'donation_progress_bar_section'
    );

    add_settings_field(
        'donation_message',
        'Bağış Açıklama Mesajı',
        'donation_message_callback',
        'donation-progress-bar-settings',
        'donation_progress_bar_section'
    );

    add_settings_field(
        'donation_bar_active',
        'İlerleme Çubuğunu Aktif Et',
        'donation_bar_active_callback',
        'donation-progress-bar-settings',
        'donation_progress_bar_section'
    );
}
add_action('admin_init', 'donation_progress_bar_settings_init');

// Varsayılan bağış hedefi alanı (Admin panelden düzenlenebilir)
function donation_goal_callback() {
    $goal = get_option('donation_goal', 1000);
    echo '<input type="number" name="donation_goal" value="' . esc_attr($goal) . '" />';
}

// Varsayılan toplanan bağış alanı (Admin panelden düzenlenebilir)
function current_donation_callback() {
    $donation = get_option('current_donation', 0);
    echo '<input type="number" name="current_donation" value="' . esc_attr($donation) . '" />';
}

// Bağış açıklama mesajı alanı  (Admin panelden düzenlenebilir)
function donation_message_callback() {
    $message = get_option('donation_message', 'Bağışlarınızla bizi destekleyin!');
    echo '<textarea name="donation_message" rows="3" cols="50">' . esc_textarea($message) . '</textarea>';
}


// İlerleme çubuğu aktif/pasif seçeneği alanı
function donation_bar_active_callback() {
    $active = get_option('donation_bar_active', 'yes');
    $checked = ($active === 'yes') ? 'checked' : '';
    echo '<input type="checkbox" name="donation_bar_active" value="yes" ' . $checked . ' /> Çubuğu Aktif Et';
}

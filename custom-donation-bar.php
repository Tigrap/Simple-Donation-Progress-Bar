<?php
/*
Plugin Name: Simple Donation Progress Bar
Description: Displays a donation progress bar at the top of the site with a custom goal and current amount. Update values from the admin settings.
Version: 1.1
Author: Marka Ltd
*/

if (!defined('ABSPATH')) {
    exit; 
}

function display_donation_progress_bar() {
    // Bağış çubuğunun aktif olup olmadığını kontrol et
    $is_active = get_option('donation_bar_active', 'yes');

    // Eğer çubuk pasifse gösterme
    if ($is_active !== 'yes') {
        return;
    }

    // Bağış hedefi, toplanan bağış ve açıklama metni
    $donation_goal = get_option('donation_goal', 1000); // Varsayılan hedef 1000  (Admin panelden düzenlenebilir)
    $current_donation = get_option('current_donation', 0); // Varsayılan 0  (Admin panelden düzenlenebilir)
    $donation_message = get_option('donation_message', 'Bizi destekleyin!'); // Varsayılan mesaj  (Admin panelden düzenlenebilir)

    // Yüzde hesaplama
    $percentage = ($current_donation / $donation_goal) * 100;

	// İlerleme çubuğu HTML çıktısı
	echo '<div style="background-color: #f3f3f3; padding: 10px; text-align: center;">
			<strong>' . wp_kses_post($donation_message) . '</strong><br>
			<strong>Toplanan Bağış: <font size="3">' . esc_html($current_donation) . '₺ </font>/ Hedef: <font size="4">' . esc_html($donation_goal) . '₺</font></strong>
			<div style="background-color: #ccc; width: 100%; margin: 10px 0;">
				<div style="width: ' . esc_attr($percentage) . '%; background-color: #4CAF50; height: 40px; color: white; display: flex; align-items: center; justify-content: center;">
					' . esc_html(round($percentage, 2)) . '%
				</div>
			</div>
		  </div>';
}

// İlerleme çubuğunu göster
add_action('wp_head', 'display_donation_progress_bar');

// Admin ayarları
require_once plugin_dir_path(__FILE__) . 'custom-donation-bar-admin.php';

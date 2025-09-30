<?php
/**
 * External Data Synchronization Script
 * Demonstrates secure API integration and data storage within WordPress.
 *
 * This uses an Object-Oriented approach (OOP) to organize code into a dedicated class, 
 * which is a best practice for modern WordPress plugin or module development.
 */

class HarisAPISyncer {

    // Define constants for configuration
    const API_URL = 'https://jsonplaceholder.typicode.com/todos/1'; // Dummy external API for demo
    const OPTION_KEY = 'haris_last_api_data_sync';

    /**
     * The main function to execute the API call and data processing.
     */
    public static function run_sync() {
        // Use wp_remote_get for safe and secure external HTTP requests
        $response = wp_remote_get(self::API_URL, [
            'timeout' => 10,
            'headers' => ['Accept' => 'application/json']
        ]);

        // 1. Critical Error Handling
        if (is_wp_error($response)) {
            error_log('Haris Sync Error: ' . $response->get_error_message());
            return false;
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        if (empty($data) || !is_array($data)) {
            error_log('Haris Sync Error: Received empty or invalid data structure.');
            return false;
        }

        // 2. Data Sanitization and Processing (Important for security)
        $processed_data = [
            // absint ensures data is a non-negative integer
            'id'        => absint($data['id']),
            // sanitize_text_field cleans text input/output for security
            'title'     => sanitize_text_field($data['title']),
            'completed' => (bool) $data['completed'],
            'synced_at' => current_time('mysql')
        ];

        // 3. Store data safely in the database using the WordPress Options API
        update_option(self::OPTION_KEY, $processed_data);

        return true;
    }

    /**
     * Registers a manual trigger page in the WordPress Admin area (Tools menu) for testing.
     */
    public static function register_admin_page() {
        add_submenu_page(
            'tools.php', 
            'API Sync Tool',
            'API Sync Tool',
            'manage_options',
            'haris-api-sync-tool',
            [self::class, 'render_sync_page']
        );
    }

    /**
     * Renders the content of the admin page.
     */
    public static function render_sync_page() {
        ?>
        <div class="wrap">
            <h1>API Synchronization Tool</h1>
            <p>This tool manually triggers the external API synchronization script.</p>
            <p>Once triggered, the script fetches data and stores the processed result in the database.</p>
            <a href="<?php echo esc_url(add_query_arg('action', 'run_sync', admin_url('tools.php?page=haris-api-sync-tool'))); ?>" class="button button-primary">Run Manual Sync Now</a>
            <?php 
                $last_data = get_option(self::OPTION_KEY, ['synced_at' => 'Never']);
                echo '<p>Last Successful Sync: <strong>' . esc_html($last_data['synced_at']) . '</strong></p>'; 
            ?>
        </div>
        <?php
    }

    /**
     * Handles the sync action when the button is clicked.
     */
    public static function handle_sync_action() {
        if (isset($_GET['action']) && $_GET['action'] === 'run_sync' && current_user_can('manage_options')) {
            self::run_sync();
            // Redirect to remove the GET parameter and prevent accidental re-runs
            wp_safe_redirect(admin_url('tools.php?page=haris-api-sync-tool&sync_status=complete'));
            exit;
        }
    }

    /**
     * Initialize all hooks for the class.
     */
    public static function init() {
        add_action('admin_menu', [self::class, 'register_admin_page']);
        add_action('admin_init', [self::class, 'handle_sync_action']);
        // For real world use, run_sync would be hooked to a cron: add_action('wp_scheduled_sync', [self::class, 'run_sync']);
    }
}

// Instantiate the class to start the hooks
HarisAPISyncer::init();

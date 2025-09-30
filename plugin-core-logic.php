<?php
/**
 * Core PHP Logic for Custom WordPress Development
 * Demonstrates best practices for registering components and using hooks.
 * * NOTE: This file is designed to be included in functions.php or run as a standalone plugin.
 */

// Define constants for versioning and pathing (Good practice for maintainability)
if (!defined('HARIS_CUSTOM_DEV_VERSION')) {
    define('HARIS_CUSTOM_DEV_VERSION', '1.0.0');
}

// 1. Register a Custom Post Type (CPT) using standard WordPress practices
// This allows a site to manage custom content types (e.g., 'Projects') beyond the standard Posts/Pages.
function haris_register_client_projects() {
    $labels = [
        'name'          => 'Client Projects',
        'singular_name' => 'Client Project',
        'menu_name'     => 'Projects',
    ];
    $args = [
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'projects'],
        'capability_type'    => 'post',
        'supports'           => ['title', 'editor', 'thumbnail'],
    ];
    register_post_type('client_project', $args);
}
// Hook the function into WordPress's initialization action
add_action('init', 'haris_register_client_projects');

// 2. Security Enhancement: Filter hook to modify the login error message
// This is a common security practice to prevent users from guessing usernames.
function haris_custom_login_errors() {
    // Hide specific login failure details for better security
    return 'ERROR: Invalid login credentials provided.';
}
// Use the 'login_errors' filter hook
add_filter('login_errors', 'haris_custom_login_errors');

// 3. Conditional Asset Loading (Performance focus)
// Only load CSS/JS when necessary, preventing unnecessary site bloat.
function haris_load_project_assets() {
    // Check if we are on the specific 'projects' archive page or a single project page
    if (is_post_type_archive('client_project') || is_singular('client_project')) {
        // Enqueue style using HARIS_CUSTOM_DEV_VERSION constant for cache-busting
        wp_enqueue_style('haris-project-style', get_template_directory_uri() . '/css/projects.css', [], HARIS_CUSTOM_DEV_VERSION);
    }
}
// Use the 'wp_enqueue_scripts' action hook
add_action('wp_enqueue_scripts', 'haris_load_project_assets');

// End of file

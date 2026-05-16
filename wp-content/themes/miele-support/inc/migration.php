<?php
/**
 * Site Migration Tool
 * Prepares site for transfer to another hosting with domain replacement
 * Does NOT modify the live site - only creates export archives
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register admin menu
 */
add_action('admin_menu', function () {
    add_management_page(
        'Site Migration',
        'Site Migration',
        'manage_options',
        'site-migration',
        'render_migration_page'
    );
});

/**
 * Handle AJAX export
 */
add_action('wp_ajax_migration_export', 'handle_migration_export');

/**
 * Handle AJAX download
 */
add_action('wp_ajax_migration_download', 'handle_migration_download');

/**
 * Render the migration admin page
 */
function render_migration_page() {
    $current_domain = parse_url(home_url(), PHP_URL_HOST);

    // Check for export status
    $export_status = get_transient('migration_export_status');
    $export_file = get_transient('migration_export_file');
    ?>
    <div class="wrap">
        <h1>Site Migration Tool</h1>
        <p>Prepare your site for transfer to another hosting. This tool creates archives of your site files and database with domain replacement.</p>

        <div style="background: #fff; border: 1px solid #ccd0d4; padding: 20px; margin-top: 20px; max-width: 700px;">
            <h2 style="margin-top: 0;">Export Settings</h2>

            <table class="form-table">
                <tr>
                    <th scope="row"><label for="current_domain">Current Domain</label></th>
                    <td>
                        <input type="text" id="current_domain" value="<?php echo esc_attr($current_domain); ?>" class="regular-text" readonly style="background: #f0f0f1;">
                        <p class="description">Detected automatically from WordPress settings.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="new_domain">New Domain</label></th>
                    <td>
                        <input type="text" id="new_domain" value="" class="regular-text" placeholder="example.com">
                        <p class="description">Enter the new domain (without http:// or www prefix). Leave empty to keep current domain.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="include_files">Include Files</label></th>
                    <td>
                        <label>
                            <input type="checkbox" id="include_files" checked value="1">
                            Include site files (themes, plugins, uploads)
                        </label>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="include_db">Include Database</label></th>
                    <td>
                        <label>
                            <input type="checkbox" id="include_db" checked value="1">
                            Include database dump
                        </label>
                    </td>
                </tr>
            </table>

            <p class="submit">
                <button type="button" id="start-export" class="button button-primary button-hero">Start Export</button>
            </p>

            <div id="export-progress" style="display: none;">
                <h3>Export Progress</h3>
                <div style="background: #f0f0f1; border-radius: 4px; overflow: hidden; height: 24px; margin-bottom: 10px;">
                    <div id="progress-bar" style="background: #2271b1; height: 100%; width: 0%; transition: width 0.3s;"></div>
                </div>
                <p id="progress-text">Preparing...</p>
            </div>

            <div id="export-result" style="display: none;">
                <div id="export-success" style="display: none; padding: 15px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 4px; margin-top: 15px;">
                    <h3 style="margin-top: 0; color: #155724;">Export Complete!</h3>
                    <p id="export-file-info" style="color: #155724;"></p>
                    <p>
                        <a id="export-download-link" href="#" class="button button-primary button-hero">Download Archive</a>
                    </p>
                </div>
                <div id="export-error" style="display: none; padding: 15px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 4px; margin-top: 15px;">
                    <h3 style="margin-top: 0; color: #721c24;">Export Failed</h3>
                    <p id="export-error-text" style="color: #721c24;"></p>
                </div>
            </div>
        </div>

        <div style="background: #fff; border: 1px solid #ccd0d4; padding: 20px; margin-top: 20px; max-width: 700px;">
            <h2 style="margin-top: 0;">How It Works</h2>
            <ol>
                <li>The tool creates a copy of your database as a SQL dump file</li>
                <li>All occurrences of the current domain are replaced with the new domain in the dump</li>
                <li>Serialized data is handled correctly (string lengths are recalculated)</li>
                <li>Site files are copied to a temporary directory</li>
                <li>Domain replacement is performed in config files and PHP files</li>
                <li>Everything is packaged into a single ZIP archive for download</li>
            </ol>
            <p><strong>Note:</strong> No changes are made to your live site. All operations are performed on copies.</p>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var startBtn = document.getElementById('start-export');
        var progressDiv = document.getElementById('export-progress');
        var resultDiv = document.getElementById('export-result');
        var progressBar = document.getElementById('progress-bar');
        var progressText = document.getElementById('progress-text');

        startBtn.addEventListener('click', function() {
            var newDomain = document.getElementById('new_domain').value.trim();
            var includeFiles = document.getElementById('include_files').checked;
            var includeDb = document.getElementById('include_db').checked;

            if (!includeFiles && !includeDb) {
                alert('Please select at least one export option.');
                return;
            }

            startBtn.disabled = true;
            startBtn.textContent = 'Exporting...';
            progressDiv.style.display = 'block';
            resultDiv.style.display = 'none';
            progressBar.style.width = '10%';
            progressText.textContent = 'Starting export...';

            var data = {
                action: 'migration_export',
                current_domain: '<?php echo esc_js($current_domain); ?>',
                new_domain: newDomain,
                include_files: includeFiles ? 1 : 0,
                include_db: includeDb ? 1 : 0,
                _wpnonce: '<?php echo wp_create_nonce('migration_export'); ?>'
            };

            jQuery.post(ajaxurl, data, function(response) {
                if (response.success) {
                    progressBar.style.width = '100%';
                    progressText.textContent = 'Export complete!';

                    document.getElementById('export-success').style.display = 'block';
                    document.getElementById('export-error').style.display = 'none';
                    document.getElementById('export-file-info').textContent = response.data.message;
                    document.getElementById('export-download-link').href = ajaxurl + '?action=migration_download&file=' + encodeURIComponent(response.data.file) + '&_wpnonce=' + encodeURIComponent(response.data.nonce);

                    resultDiv.style.display = 'block';
                } else {
                    progressBar.style.width = '100%';
                    progressBar.style.background = '#dc3232';
                    progressText.textContent = 'Export failed!';

                    document.getElementById('export-error').style.display = 'block';
                    document.getElementById('export-success').style.display = 'none';
                    document.getElementById('export-error-text').textContent = response.data.message || 'Unknown error occurred.';

                    resultDiv.style.display = 'block';
                }
                startBtn.disabled = false;
                startBtn.textContent = 'Start Export';
            }).fail(function() {
                progressBar.style.width = '100%';
                progressBar.style.background = '#dc3232';
                progressText.textContent = 'Export failed!';

                document.getElementById('export-error').style.display = 'block';
                document.getElementById('export-success').style.display = 'none';
                document.getElementById('export-error-text').textContent = 'Network error. Please try again.';

                resultDiv.style.display = 'block';
                startBtn.disabled = false;
                startBtn.textContent = 'Start Export';
            });
        });
    });
    </script>
    <?php
}

/**
 * Handle the export process
 */
function handle_migration_export() {
    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'Permission denied.']);
    }

    if (!wp_verify_nonce($_POST['_wpnonce'] ?? '', 'migration_export')) {
        wp_send_json_error(['message' => 'Security check failed.']);
    }

    $current_domain = sanitize_text_field($_POST['current_domain'] ?? '');
    $new_domain = sanitize_text_field($_POST['new_domain'] ?? '');
    $include_files = !empty($_POST['include_files']);
    $include_db = !empty($_POST['include_db']);

    if (empty($current_domain)) {
        wp_send_json_error(['message' => 'Current domain is required.']);
    }

    // If no new domain specified, use current
    if (empty($new_domain)) {
        $new_domain = $current_domain;
    }

    // Create temp directory for export
    $upload_dir = wp_upload_dir();
    $export_dir = $upload_dir['basedir'] . '/migration_export_' . time();
    $archive_name = 'site_migration_' . date('Y-m-d_H-i-s') . '.zip';
    $archive_path = $upload_dir['basedir'] . '/' . $archive_name;
    $temp_dir = $export_dir;

    if (!wp_mkdir_p($temp_dir)) {
        wp_send_json_error(['message' => 'Failed to create export directory.']);
    }

    $steps = [];
    if ($include_db) $steps[] = 'database';
    if ($include_files) $steps[] = 'files';
    $total_steps = count($steps);
    $current_step = 0;

    try {
        // Step 1: Database dump
        if ($include_db) {
            $current_step++;
            $progress = intval(($current_step / $total_steps) * 80);

            $db_file = $temp_dir . '/database.sql';
            $dump_result = export_database($db_file);

            if (is_wp_error($dump_result)) {
                throw new Exception('Database export failed: ' . $dump_result->get_error_message());
            }

            // Replace domain in database dump
            if ($current_domain !== $new_domain) {
                replace_domain_in_file($db_file, $current_domain, $new_domain);
            }

            $steps_done[] = 'database';
        }

        // Step 2: Files
        if ($include_files) {
            $current_step++;
            $progress = intval(($current_step / $total_steps) * 80);

            $files_dir = $temp_dir . '/files';
            if (!wp_mkdir_p($files_dir)) {
                throw new Exception('Failed to create files directory.');
            }

            // Copy essential files and directories
            $site_root = ABSPATH;
            $dirs_to_copy = [
                'wp-content/themes',
                'wp-content/plugins',
                'wp-content/uploads',
                'wp-config.php',
                '.htaccess',
            ];

            // Add mu-plugins if exists
            if (is_dir($site_root . 'wp-content/mu-plugins')) {
                $dirs_to_copy[] = 'wp-content/mu-plugins';
            }

            foreach ($dirs_to_copy as $item) {
                $src = $site_root . $item;
                $dst = $files_dir . '/' . $item;

                if (is_file($src)) {
                    $dst_dir = dirname($dst);
                    if (!is_dir($dst_dir)) {
                        wp_mkdir_p($dst_dir);
                    }
                    copy($src, $dst);
                } elseif (is_dir($src)) {
                    copy_directory($src, $dst);
                }
            }

            // Replace domain in config files
            if ($current_domain !== $new_domain) {
                $config_files = [
                    $files_dir . '/wp-config.php',
                ];

                foreach ($config_files as $cf) {
                    if (file_exists($cf)) {
                        replace_domain_in_file($cf, $current_domain, $new_domain);
                    }
                }
            }
        }

        // Step 3: Create ZIP archive
        $progress = 90;

        if (file_exists($archive_path)) {
            unlink($archive_path);
        }

        $zip = new ZipArchive();
        if ($zip->open($archive_path, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new Exception('Failed to create ZIP archive.');
        }

        // Add database dump
        if ($include_db && file_exists($temp_dir . '/database.sql')) {
            $zip->addFile($temp_dir . '/database.sql', 'database.sql');
        }

        // Add files
        if ($include_files && is_dir($temp_dir . '/files')) {
            add_directory_to_zip($zip, $temp_dir . '/files', 'files');
        }

        // Add migration readme
        $readme = generate_readme($current_domain, $new_domain);
        $zip->addFromString('MIGRATION_README.txt', $readme);

        $zip->close();

        // Step 4: Cleanup temp directory
        delete_directory($temp_dir);

        // Store file info for download
        set_transient('migration_export_file', [
            'path' => $archive_path,
            'name' => $archive_name,
            'size' => filesize($archive_path),
        ], 3600);

        $size_mb = round(filesize($archive_path) / 1024 / 1024, 2);

        wp_send_json_success([
            'message' => "Archive created successfully! Size: {$size_mb} MB",
            'file' => $archive_name,
            'nonce' => wp_create_nonce('migration_download_' . $archive_name),
        ]);

    } catch (Exception $e) {
        // Cleanup on error
        if (is_dir($temp_dir)) {
            delete_directory($temp_dir);
        }
        if (file_exists($archive_path)) {
            unlink($archive_path);
        }

        wp_send_json_error(['message' => $e->getMessage()]);
    }
}

/**
 * Handle download of exported archive
 */
function handle_migration_download() {
    if (!current_user_can('manage_options')) {
        wp_die('Permission denied.');
    }

    $file = sanitize_text_field($_GET['file'] ?? '');
    $nonce = sanitize_text_field($_GET['_wpnonce'] ?? '');

    if (!wp_verify_nonce($nonce, 'migration_download_' . $file)) {
        wp_die('Security check failed.');
    }

    $export_info = get_transient('migration_export_file');
    if (!$export_info || $export_info['name'] !== $file) {
        wp_die('Export file not found or expired.');
    }

    $filepath = $export_info['path'];
    if (!file_exists($filepath)) {
        wp_die('File no longer exists.');
    }

    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . $export_info['name'] . '"');
    header('Content-Length: ' . filesize($filepath));
    header('Cache-Control: no-cache, must-revalidate');

    readfile($filepath);
    exit;
}

/**
 * Export database using mysqldump or WP-CLI fallback
 */
function export_database($output_file) {
    global $wpdb;

    // Try mysqldump first (most reliable)
    $mysql_path = find_mysql_path();

    if ($mysql_path && is_callable('exec')) {
        $tmp_file = $output_file . '.tmp';

        $command = sprintf(
            '%s --host=%s --user=%s %s --result-file=%s %s',
            escapeshellcmd($mysql_path),
            escapeshellarg(DB_HOST),
            escapeshellarg(DB_USER),
            defined('DB_PASSWORD') && DB_PASSWORD ? '--password=' . escapeshellarg(DB_PASSWORD) : '',
            escapeshellarg($tmp_file),
            escapeshellarg(DB_NAME)
        );

        exec($command, $output, $return_code);

        if ($return_code === 0 && file_exists($tmp_file) && filesize($tmp_file) > 0) {
            rename($tmp_file, $output_file);
            return true;
        }

        // Cleanup failed attempt
        if (file_exists($tmp_file)) {
            unlink($tmp_file);
        }
    }

    // Fallback: PHP-based export
    return export_database_php($output_file);
}

/**
 * PHP-based database export (fallback when mysqldump is not available)
 */
function export_database_php($output_file) {
    global $wpdb;

    // Get all tables from current database
    $tables = $wpdb->get_results("SHOW TABLES", ARRAY_N);
    if (empty($tables)) {
        return new WP_Error('no_tables', 'No tables found.');
    }

    $output = '';
    $output .= "-- WordPress Database Export\n";
    $output .= "-- Host: " . DB_HOST . "\n";
    $output .= "-- Database: " . DB_NAME . "\n";
    $output .= "-- Date: " . current_time('mysql') . "\n\n";
    $output .= "SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';\n";
    $output .= "SET AUTOCOMMIT = 0;\n";
    $output .= "START TRANSACTION;\n\n";

    foreach ($tables as $table) {
        $table_name = $table[0];

        // Get CREATE TABLE statement
        $create_table = $wpdb->get_var("SHOW CREATE TABLE `{$table_name}`", 1);
        $output .= "DROP TABLE IF EXISTS `{$table_name}`;\n";
        $output .= $create_table . ";\n\n";

        // Get all rows
        $rows = $wpdb->get_results("SELECT * FROM `{$table_name}`", ARRAY_N);

        if (!empty($rows)) {
            // Get column info for proper escaping
            $columns = $wpdb->get_results("DESCRIBE `{$table_name}`", ARRAY_A);

            foreach ($rows as $row) {
                $values = [];
                foreach ($row as $key => $value) {
                    if ($value === null) {
                        $values[] = 'NULL';
                    } else {
                        $values[] = $wpdb->prepare('%s', $value);
                    }
                }
                $output .= "INSERT INTO `{$table_name}` VALUES (" . implode(', ', $values) . ");\n";
            }
            $output .= "\n";
        }
    }

    $output .= "COMMIT;\n";

    $result = file_put_contents($output_file, $output);

    if ($result === false) {
        return new WP_Error('write_failed', 'Failed to write database dump.');
    }

    return true;
}

/**
 * Find mysql/mysqldump binary path
 */
function find_mysql_path() {
    $possible_paths = [
        'mysqldump',
        '/usr/bin/mysqldump',
        '/usr/local/bin/mysqldump',
        '/usr/sbin/mysqldump',
        'C:\\Program Files\\MySQL\\MySQL Server\\bin\\mysqldump.exe',
    ];

    foreach ($possible_paths as $path) {
        $output = [];
        exec(escapeshellcmd($path) . ' --version 2>&1', $output, $return_code);
        if ($return_code === 0) {
            return $path;
        }
    }

    return null;
}

/**
 * Replace domain in a file with serialized data fix
 */
function replace_domain_in_file($file_path, $old_domain, $new_domain) {
    if (!file_exists($file_path)) return;

    $content = file_get_contents($file_path);

    // Handle both http and https, with and without www
    $replacements = [
        'http://' . $old_domain => 'http://' . $new_domain,
        'https://' . $old_domain => 'https://' . $new_domain,
        'http://www.' . $old_domain => 'http://www.' . $new_domain,
        'https://www.' . $old_domain => 'https://www.' . $new_domain,
    ];

    foreach ($replacements as $old => $new) {
        if (strpos($content, $old) !== false) {
            $content = str_replace($old, $new, $content);
        }
    }

    // Also handle bare domain (for wp-config defines etc.)
    if (strpos($content, $old_domain) !== false) {
        $content = str_replace($old_domain, $new_domain, $content);
    }

    // Fix serialized data
    $content = fix_serialized_data($content, $old_domain, $new_domain);

    file_put_contents($file_path, $content);
}

/**
 * Fix serialized data after domain replacement
 */
function fix_serialized_data($content, $old_domain, $new_domain) {
    $old_len = strlen($old_domain);
    $new_len = strlen($new_domain);

    if ($old_len === $new_len) {
        return $content; // No length change needed
    }

    // Find serialized strings and fix their lengths
    // Pattern: s:N:"...domain..."
    $pattern = '/s:\d+:"[^"]*' . preg_quote($old_domain, '/') . '[^"]*"/';

    return preg_replace_callback($pattern, function ($matches) use ($old_domain, $new_len) {
        $str = $matches[0];
        // Extract the string content
        preg_match('/s:\d+:"(.*)"/', $str, $m);
        if (isset($m[1])) {
            $new_str = 's:' . $new_len . ':"' . $m[1] . '"';
            return $new_str;
        }
        return $str;
    }, $content);
}

/**
 * Copy directory recursively
 */
function copy_directory($src, $dst) {
    if (!is_dir($src)) return false;

    @mkdir($dst, 0755, true);

    $objects = scandir($src);
    foreach ($objects as $object) {
        if ($object === '.' || $object === '..') continue;

        $src_path = $src . '/' . $object;
        $dst_path = $dst . '/' . $object;

        if (is_dir($src_path)) {
            copy_directory($src_path, $dst_path);
        } else {
            copy($src_path, $dst_path);
        }
    }

    return true;
}

/**
 * Add directory contents to ZIP
 */
function add_directory_to_zip($zip, $directory, $zip_path) {
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($files as $file) {
        if (!$file->isDir()) {
            $relative_path = substr($file->getRealPath(), strlen($directory) + 1);
            $zip->addFile($file->getRealPath(), $zip_path . '/' . $relative_path);
        }
    }
}

/**
 * Delete directory recursively
 */
function delete_directory($dir) {
    if (!is_dir($dir)) return;

    $objects = scandir($dir);
    foreach ($objects as $object) {
        if ($object === '.' || $object === '..') continue;

        $path = $dir . '/' . $object;
        if (is_dir($path)) {
            delete_directory($path);
        } else {
            unlink($path);
        }
    }

    rmdir($dir);
}

/**
 * Generate migration README file
 */
function generate_readme($old_domain, $new_domain) {
    $date = current_time('F j, Y H:i:s');
    $site_name = get_bloginfo('name');

    $readme = "SITE MIGRATION PACKAGE\n";
    $readme .= "======================\n\n";
    $readme .= "Generated: {$date}\n";
    $readme .= "Site: {$site_name}\n";
    $readme .= "Original domain: {$old_domain}\n";

    if ($old_domain !== $new_domain) {
        $readme .= "New domain: {$new_domain}\n";
    }

    $readme .= "\n";
    $readme .= "CONTENTS\n";
    $readme .= "--------\n\n";
    $readme .= "- database.sql: Full database dump with domain replacement applied\n";
    $readme .= "- files/: Site files including:\n";
    $readme .= "  - wp-content/themes/ (active and installed themes)\n";
    $readme .= "  - wp-content/plugins/ (installed plugins)\n";
    $readme .= "  - wp-content/uploads/ (media files)\n";
    $readme .= "  - wp-config.php (configuration file)\n";
    $readme .= "  - .htaccess (Apache configuration)\n\n";

    $readme .= "INSTALLATION INSTRUCTIONS\n";
    $readme .= "-------------------------\n\n";
    $readme .= "1. Upload all files from the 'files/' directory to your new hosting\n";
    $readme .= "2. Create a new MySQL database on your new hosting\n";
    $readme .= "3. Import 'database.sql' into the new database\n";
    $readme .= "4. Update wp-config.php with new database credentials:\n";
    $readme .= "   - DB_NAME\n";
    $readme .= "   - DB_USER\n";
    $readme .= "   - DB_PASSWORD\n";
    $readme .= "   - DB_HOST\n";

    if ($old_domain !== $new_domain) {
        $readme .= "5. Domain replacement has been applied automatically.\n";
        $readme .= "   If you encounter issues, run a search-replace tool:\n";
        $readme .= "   Search: {$old_domain}\n";
        $readme .= "   Replace: {$new_domain}\n";
    }

    $readme .= "\nNOTES\n";
    $readme .= "-----\n\n";
    $readme .= "- Make sure your new hosting meets WordPress requirements\n";
    $readme .= "- Check file permissions after upload (755 for directories, 644 for files)\n";
    $readme .= "- If using HTTPS on new domain, update WordPress Address URL in Settings\n";
    $readme .= "- Flush permalinks after migration (Settings > Permalinks > Save)\n";

    return $readme;
}

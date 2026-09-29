<?php
/**
 * Làm mới rewrite rules.
 *
 * Chạy: php scripts/flush-rewrite.php
 */

require_once __DIR__ . '/../wp-load.php';

flush_rewrite_rules( true );
echo "Đã flush rewrite rules.\n";

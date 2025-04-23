<?php
// includes/functions.php

/**
 * Formats bytes into human-readable file sizes
 * @param int $bytes Number of bytes
 * @param int $precision Decimal precision
 * @return string Formatted size
 */
function formatSize(int $bytes, int $precision = 2): string {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    
    $bytes /= (1 << (10 * $pow));
    
    return round($bytes, $precision) . ' ' . $units[$pow];
}

/**
 * Gets Font Awesome icon for file type
 * @param string $mimeType The file's MIME type
 * @return string HTML icon element
 */
function getFileTypeIcon(string $mimeType): string {
    $icons = [
        'image/' => 'fa-file-image',
        'application/pdf' => 'fa-file-pdf',
        'application/msword' => 'fa-file-word',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'fa-file-word',
        'application/zip' => 'fa-file-archive',
        'application/x-zip-compressed' => 'fa-file-archive',
        'text/plain' => 'fa-file-alt',
        'text/x-php' => 'fa-file-code'
    ];
    
    foreach ($icons as $pattern => $icon) {
        if (strpos($mimeType, $pattern) === 0) {
            return sprintf('<i class="fas %s me-2"></i>', $icon);
        }
    }
    
    return '<i class="fas fa-file me-2"></i>';
}


<footer class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p class="mb-0 text-muted">&copy; <?php echo date('Y'); ?> HASS & MUBZ PROJ</p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-0 text-muted">
                    <i class="fas fa-code"></i> with <i class="fas fa-heart text-danger"></i> by Your Team
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
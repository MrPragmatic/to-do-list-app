<?php
// Security headers removed

// Add security headers
// Defines the Content Security Policy to allow resources only from the same origin ('self')
// header("Content-Security-Policy: default-src 'self';");
// Prevents browsers from MIME-sniffing a response away from the declared content type.
//header("X-Content-Type-Options: nosniff");
// Enforces the use of HTTPS, includes subdomains, and allows preloading in browsers
// header("Strict-Transport-Security: max-age=63072000; includeSubdomains; preload");
// Enables the browser's Cross-Site Scripting (XSS) filter in block mode.
// header("X-XSS-Protection: 1; mode=block");
// Prevents the page from being displayed in a frame or iframe, enhancing protection against clickjacking.
// header("X-Frame-Options: DENY");
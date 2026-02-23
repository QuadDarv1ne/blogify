<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Blog Settings
    |--------------------------------------------------------------------------
    */
    
    'name' => env('BLOG_NAME', 'Blogify'),
    'tagline' => env('BLOG_TAGLINE', 'A modern Laravel blog'),
    
    // Posts per page
    'posts_per_page' => env('BLOG_POSTS_PER_PAGE', 12),
    
    // Comments
    'comments' => [
        'enabled' => true,
        'moderation' => true, // require approval
        'guest_can_comment' => false,
    ],
    
    // Cache
    'cache' => [
        'enabled' => true,
        'ttl' => 3600, // seconds
    ],
    
    // SEO
    'seo' => [
        'meta_description_length' => 160,
        'og_image' => '/images/og-default.png',
    ],
    
    // Social
    'social' => [
        'twitter' => env('BLOG_TWITTER', ''),
        'github' => env('BLOG_GITHUB', ''),
    ],
    
    // API
    'api' => [
        'version' => 'v1',
        'rate_limit' => 60,
    ],
];

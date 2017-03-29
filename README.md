# MOE-PIX

#.htaccess
<Files wp-comments-post.php>
Require all denied
</Files>

#functions.php
$user_agent = $_SERVER['HTTP_USER_AGENT'];
preg_match('/\Q'.preg_quote($user_agent, '/').'\E/i', $spam_list))
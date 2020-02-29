Запуск:
 - sitemap
 - robots

дев база - s7TJNfyK

Добавить правило в .htaccess, чтобы адреса с / и без обрабатывались одинаково в каталоге

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-l
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_URI} ^(.*/[^/\.]+)$
RewriteRule ^(.*)$ http://%{HTTP_HOST}/$1/ [R=301,L]
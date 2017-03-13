# VIP (WPCOM) mu-plugins

## Usage

Install this directory to `wp-content/mu-plugins` in your local development environment.

## Concatention

To enable nginx-http-concat, you'll need to define the `QUICKSTART_ENABLE_CONCAT` constant in `wp-config.php` and add the relevant configuration to your webserver. For example, in Nginx:

```
location /_static/ {
        fastcgi_pass unix:/var/run/fastcgi.sock;
        include /etc/nginx/fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root/wp-content/plugins/http-concat/ngx-http-concat.php;
}
```

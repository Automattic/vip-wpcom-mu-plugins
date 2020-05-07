# DEPRECATED

This repo is no longer actively being maintained.

## Usage

Install this directory to `wp-content/mu-plugins` in your local development environment. Current WordPress.com VIP Clients will find full setup instructions in the [VIP Lobby](https://wp.me/PPtWC-2T').

## Differences

This repo will help bridge the gap between WordPress.com VIP and your local development environment but will not provide a 1:1 setup. Some known missing pieces include:

* Protected Embeds
* Photon is [included with Jetpack](http://jetpack.me/support/photon/) and similar to the WordPress.com CDN, but requires your development server to be publicly accessible.
* The Database encoding on WordPress.com is latin1.
* On WordPress.com, it is not possible to upload files from the front-end of the site.
* When options are added or changed, the alloptions cache on WordPress.com is deleted.

## Batcache

WordPress.com uses Batcache for page caching. The code is included here, but requires some setup:

1. Install the Memcached backend
1. Copy or symlink `batcache/advanced-cache.php` to `/wp-content`
1. Turn on `WP_CACHE`, with `define('WP_CACHE', true);`

## Concatenation

To enable nginx-http-concat, you'll need to define the `QUICKSTART_ENABLE_CONCAT` constant in `wp-config.php` and add the relevant configuration to your webserver. For example, in Nginx:

```
location /_static/ {
        fastcgi_pass unix:/var/run/fastcgi.sock;
        include /etc/nginx/fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root/wp-content/mu-plugins/http-concat/ngx-http-concat.php;
}
```

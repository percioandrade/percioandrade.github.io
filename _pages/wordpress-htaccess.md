---
layout: page
permalink: /wp-htaccess/
title:  WordPress Htaccess
excerpt: A collection of WordPress htaccess
---

# htaccess codes for you WordPress

Place it on .htacces

*   Changelog

- 1.0: Started
- 1.1: Converted to github pages

---

**<a name="redirect_root">Webhost - Redirect to root</a>**

    # Use only in emergency case
    #
    #<IfModule mod_rewrite.c>
    #	RewriteEngine on
    #	RewriteCond %{REQUEST_FILENAME} !-f
    #	RewriteCond %{REQUEST_FILENAME} !-d
    #	RewriteRule .? / [R=302,L]
    #</IfModule>

---

**<a name="index_fallback">Webhost - Load main if index not found</a>**

    # If index.php isn't found then load the file MAINT-index.html from the same directory instead.
    # Try: https://codepen.io/j_holtslander/pen/KNgbMP
    #
    DirectoryIndex index.php index.html MAINT-index.html

**Use UTF-8 encoding for anything served text/plain or text/html**

    AddDefaultCharset UTF-8
    <IfModule mod_mime.c>
        AddCharset UTF-8 .atom .css .js .json .rss .vtt .xml
    </IfModule>
    
---

**<a name="correct_robots">Webhost - Correct robots.txt requests</a>**

    # Source: https://perishablepress.com/htaccess-cleanup/
    #
    <IfModule mod_alias.c>
        RedirectMatch 301 (?<!^)/robots.txt$ /robots.txt
    </IfModule>

---

**<a name="change_apachemail">Webhost - Change apache admin mail</a>**

    SetEnv SERVER_ADMIN email@domain.tdl

---

**<a name="prevent_overzealous">Webhost - Prevent overzealous 404 erros from apache</a>**

    # This setting prevents Apache from returning a 404 error as the result
    # of a rewrite when the directory with the same name does not exist.
    # See: 
    # * https://httpd.apache.org/docs/current/content-negotiation.html#multiviews
    # * https://www.infomaniak.com/en/support/faq/605/redirect-and-url-rewrite-issues-multiviews-option-in-htaccess
    #
    Options -MultiViews

---

**<a name="disable_etag">Webhost - FileETag None is not enough for every server</a>**

    <IfModule mod_headers.c>
    Header unset ETag
    </IfModule>

---

**<a name="disable_sniffing">Webhost - Remove X-Powered-By and others values to avoid sniffing</a>**

    <IfModule mod_headers.c>
        Header always unset X-Powered-By
        Header always unset Server
        Header always unset X-Pingback
        Header always set X-Content-Type-Options "nosniff"
        Header always set X-Frame-Options "SAMEORIGIN"
        Header always set X-XSS-Protection "1; mode=block"
        Header always set Content-Security-Policy "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://example.com; style-src 'self' 'unsafe-inline'; img-src 'self' data:; font-src 'self';"
        Header always set Referrer-Policy "strict-origin-when-cross-origin"
        Header always set Feature-Policy "geolocation 'none'; microphone 'none'; camera 'none'"
        Header always set Permissions-Policy "geolocation=(), microphone=(), camera=()"
    </IfModule>

---

**<a name="enable_deflate">Webhost - Enable deflate on files</a>**

    <IfModule mod_deflate.c>
    <IfModule mod_filter.c>
        Addtype font/truetype .ttf
        AddOutputFilterByType DEFLATE "application/atom+xml" \
                                        "application/javascript" \
                                        "application/json" \
                                        "application/ld+json" \
                                        "application/manifest+json" \
                                        "application/rdf+xml" \
                                        "application/rss+xml" \
                                        "application/schema+json" \
                                        "application/vnd.geo+json" \
                                        "application/vnd.ms-fontobject" \
                                        "application/x-font-ttf" \
                                        "application/x-javascript" \
                                        "application/x-web-app-manifest+json" \
                                        "application/xhtml+xml" \
                                        "application/xml" \
                                        "font/eot" \
                                        "font/opentype" \
                        "font/truetype" \
                                        "image/bmp" \
                                        "image/svg+xml" \
                                        "image/vnd.microsoft.icon" \
                                        "image/x-icon" \
                                        "text/cache-manifest" \
                                        "text/css" \
                                        "text/html" \
                                        "text/javascript" \
                        "text/text" \
                                        "text/plain" \
                                        "text/vcard" \
                                        "text/vnd.rim.location.xloc" \
                                        "text/vtt" \
                                        "text/x-component" \
                                        "text/x-cross-domain-policy" \
                                        "text/xml"
    </IfModule>
    <IfModule mod_mime.c>
        AddEncoding gzip              svgz
    </IfModule>
    </IfModule>

---

**<a name="enable_expires">Webhost - Enable Expires</a>**

    <ifModule mod_expires.c>
    ExpiresActive on
        ExpiresDefault                                      "access plus 1 month"
    # CSS
        ExpiresByType text/css                              "access plus 1 year"
    # Data interchange
        ExpiresByType application/atom+xml                  "access plus 1 hour"
        ExpiresByType application/rdf+xml                   "access plus 1 hour"
        ExpiresByType application/rss+xml                   "access plus 1 hour"
        ExpiresByType application/json                      "access plus 0 seconds"
        ExpiresByType application/ld+json                   "access plus 0 seconds"
        ExpiresByType application/schema+json               "access plus 0 seconds"
        ExpiresByType application/vnd.geo+json              "access plus 0 seconds"
        ExpiresByType application/xml                       "access plus 0 seconds"
        ExpiresByType text/xml                              "access plus 0 seconds"
    # Favicon (cannot be renamed!) and cursor images
        ExpiresByType image/vnd.microsoft.icon              "access plus 1 week"
        ExpiresByType image/x-icon                          "access plus 1 week"
    # HTML
        ExpiresByType text/html                             "access plus 1 week"
    # JavaScript
        ExpiresByType application/javascript                "access plus 1 year"
        ExpiresByType application/x-javascript              "access plus 1 year"
        ExpiresByType text/javascript                       "access plus 1 year"
    # Manifest files
        ExpiresByType application/manifest+json             "access plus 1 week"
        ExpiresByType application/x-web-app-manifest+json   "access plus 0 seconds"
        ExpiresByType text/cache-manifest                   "access plus 0 seconds"
    # Media files
        ExpiresByType audio/ogg                             "access plus 6 months"
        ExpiresByType image/bmp                             "access plus 6 months"
        ExpiresByType image/gif                             "access plus 6 months"
        ExpiresByType image/jpeg                            "access plus 6 months"
        ExpiresByType image/jpg                            "access plus 6 months"
        ExpiresByType image/png                             "access plus 6 months"
        ExpiresByType image/svg+xml                         "access plus 6 months"
        ExpiresByType image/webp                            "access plus 6 months"
        ExpiresByType video/mp4                             "access plus 6 months"
        ExpiresByType video/ogg                             "access plus 6 months"
        ExpiresByType video/webm                            "access plus 6 months"
    # Web fonts
        # Embedded OpenType (EOT)
        ExpiresByType application/vnd.ms-fontobject         "access plus 6 months"
        ExpiresByType font/eot                              "access plus 6 months"
        # OpenType
        ExpiresByType font/opentype                         "access plus 6 months"
        # TrueType
        ExpiresByType application/x-font-ttf                "access plus 6 months"
        # Web Open Font Format (WOFF) 1.0
        ExpiresByType application/font-woff                 "access plus 6 months"
        ExpiresByType application/x-font-woff               "access plus 6 months"
        ExpiresByType font/woff                             "access plus 6 months"
        # Web Open Font Format (WOFF) 2.0
        ExpiresByType application/font-woff2                "access plus 6 months"
    # Other
        ExpiresByType image/svg+xml                         "access plus 6 months"
        ExpiresByType text/x-cross-domain-policy            "access plus 1 week"
    </ifModule>

---


**<a name="enable_keepalive">Webhost - Enable KeepAlive</a>**

    <ifModule mod_headers.c>
    Header set Connection keep-alive
    </ifModule>

---

**<a name="remove_signature">Webhost - Remove Server Signature</a>**

    # See: 
    # * https://techjourney.net/improve-apache-web-server-security-use-servertokens-and-serversignature-to-disable-header/
    # * https://www.unixmen.com/how-to-disable-server-signature-using-htaccess-or-by-editing-apache/
    #
    ServerSignature Off

---

**<a name="filter_request">Webhost - Filter Request Methods</a>**

    <IfModule mod_rewrite.c>
        RewriteRule ^(TRACE|TRACK) - [F]
    </IfModule>

---


**<a name="filter_query">Webhost - Filter Suspicious Query Strings in the URL</a>**

    <IfModule mod_rewrite.c>
	RewriteCond %{QUERY_STRING} \.\.\/ [OR]
	RewriteCond %{QUERY_STRING} \.(bash|git|hg|log|svn|swp|cvs) [NC,OR]
	RewriteCond %{QUERY_STRING} etc/passwd [NC,OR]
	RewriteCond %{QUERY_STRING} boot\.ini [NC,OR]
	RewriteCond %{QUERY_STRING} ftp: [NC,OR]
    #RewriteCond %{QUERY_STRING} https?: [NC,OR]
	RewriteCond %{HTTP_HOST} !^www\.YOURDOMAIN\.com\.br$ [NC]
	RewriteCond %{QUERY_STRING} (<|%3C)script(>|%3E) [NC,OR]
	RewriteCond %{QUERY_STRING} mosConfig_[a-zA-Z_]{1,21}(=|%3D) [NC,OR]
	RewriteCond %{QUERY_STRING} base64_decode\( [NC,OR]
	RewriteCond %{QUERY_STRING} %24&x [NC,OR]
	RewriteCond %{QUERY_STRING} 127\.0 [NC,OR]
	RewriteCond %{QUERY_STRING} (^|\W)(globals|encode|localhost|loopback)($|\W) [NC,OR]
	RewriteCond %{QUERY_STRING} (^|\W)(concat|insert|union|declare)($|\W) [NC,OR]
	RewriteCond %{QUERY_STRING} %[01][0-9A-F] [NC]
	RewriteCond %{QUERY_STRING} !^loggedout=true
	RewriteCond %{QUERY_STRING} !^action=jetpack-sso
	RewriteCond %{QUERY_STRING} !^action=rp
	RewriteCond %{HTTP_COOKIE} !wordpress_logged_in_
	RewriteCond %{HTTP_REFERER} !^http://maps\.googleapis\.com
	RewriteRule ^.* - [F]
    </IfModule>

    <IfModule mod_rewrite.c>
    RewriteCond %{QUERY_STRING} http\:\/\/www\.google\.com\/humans\.txt\? [NC,OR]
    RewriteCond %{QUERY_STRING} (img|thumb|thumb_editor|thumbopen).php [NC,OR]
    RewriteCond %{QUERY_STRING} fckeditor [NC]
    RewriteCond %{QUERY_STRING} revslider [NC]
    RewriteRule .* - [F,L]
    </IfModule>

    <IfModule mod_rewrite.c>
    RewriteCond %{QUERY_STRING} http\:\/\/www\.google\.com\/humans\.txt\? [NC]
    RewriteRule .* - [F,L]
    </IfModule>

    <IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    AddDefaultCharset UTF-8

    RewriteCond %{REQUEST_URI} !^.*//.*$
    RewriteCond %{QUERY_STRING} !^.*(s\=|submit\=|wp\-admin|wp\-content|wp\-includes|\.php|/cart/|/my\-account/|/checkout/|/addons/|add\-to\-cart\=).*$
    RewriteCond %{REQUEST_URI} !^.*(s\=|submit\=|wp\-admin|wp\-content|wp\-includes|\.php|/cart/|/my\-account/|/checkout/|/addons/|add\-to\-cart\=).*$
    RewriteCond %{REQUEST_METHOD} GET
    RewriteCond %{QUERY_STRING} !.*=.*
    RewriteCond %{HTTP:Cookie} !^.*(comment_author|wp\-postpass|wptouch_switch_toggle|wordpress_logged_in|woocommerce_cart_).*$
    RewriteCond %{HTTPS} !on
    RewriteCond %{DOCUMENT_ROOT}/wp-content/pep-vn/cache/request-uri/data/%{SERVER_NAME}/$1/index-sw_.html -f
    RewriteRule ^(.*) "/wp-content/pep-vn/cache/request-uri/data/%{SERVER_NAME}/$1/index-sw_.html" [L]

    RewriteCond %{REQUEST_URI} !^.*//.*$
    RewriteCond %{QUERY_STRING} !^.*(s\=|submit\=|wp\-admin|wp\-content|wp\-includes|\.php|/cart/|/my\-account/|/checkout/|/addons/|add\-to\-cart\=).*$
    RewriteCond %{REQUEST_URI} !^.*(s\=|submit\=|wp\-admin|wp\-content|wp\-includes|\.php|/cart/|/my\-account/|/checkout/|/addons/|add\-to\-cart\=).*$
    RewriteCond %{REQUEST_METHOD} GET
    RewriteCond %{QUERY_STRING} !.*=.*
    RewriteCond %{HTTP:Cookie} !^.*(comment_author|wp\-postpass|wptouch_switch_toggle|wordpress_logged_in|woocommerce_cart_).*$
    RewriteCond %{HTTPS} on
    RewriteCond %{DOCUMENT_ROOT}/wp-content/pep-vn/cache/request-uri/data/%{SERVER_NAME}/$1/index-https-sw_.html -f
    RewriteRule ^(.*) "/wp-content/pep-vn/cache/request-uri/data/%{SERVER_NAME}/$1/index-https-sw_.html" [L]

    RewriteCond %{REQUEST_URI} !^.*//.*$
    RewriteCond %{QUERY_STRING} !^.*(s\=|submit\=|wp\-admin|wp\-content|wp\-includes|\.php|/cart/|/my\-account/|/checkout/|/addons/|add\-to\-cart\=).*$
    RewriteCond %{REQUEST_URI} !^.*(s\=|submit\=|wp\-admin|wp\-content|wp\-includes|\.php|/cart/|/my\-account/|/checkout/|/addons/|add\-to\-cart\=).*$
    RewriteCond %{REQUEST_URI} !^.*(wp-includes|wp-content|wp-admin|\.php).*$
    RewriteCond %{REQUEST_METHOD} GET
    RewriteCond %{QUERY_STRING} !.*=.*
    RewriteCond %{HTTP:Cookie} !^.*(comment_author|wp\-postpass|wptouch_switch_toggle|wordpress_logged_in|woocommerce_cart_).*$
    RewriteCond %{HTTPS} !on
    RewriteCond %{DOCUMENT_ROOT}/wp-content/pep-vn/cache/request-uri/data/%{SERVER_NAME}/$1/index.xml -f
    RewriteRule ^(.*) "/wp-content/pep-vn/cache/request-uri/data/%{SERVER_NAME}/$1/index.xml" [L]

    RewriteCond %{REQUEST_URI} !^.*//.*$
    RewriteCond %{QUERY_STRING} !^.*(s\=|submit\=|wp\-admin|wp\-content|wp\-includes|\.php|/cart/|/my\-account/|/checkout/|/addons/|add\-to\-cart\=).*$
    RewriteCond %{REQUEST_URI} !^.*(s\=|submit\=|wp\-admin|wp\-content|wp\-includes|\.php|/cart/|/my\-account/|/checkout/|/addons/|add\-to\-cart\=).*$
    RewriteCond %{REQUEST_URI} !^.*(wp-includes|wp-content|wp-admin|\.php).*$
    RewriteCond %{REQUEST_METHOD} GET
    RewriteCond %{QUERY_STRING} !.*=.*
    RewriteCond %{HTTP:Cookie} !^.*(comment_author|wp\-postpass|wptouch_switch_toggle|wordpress_logged_in|woocommerce_cart_).*$
    RewriteCond %{HTTP:Accept-Encoding} gzip
    RewriteCond %{HTTPS} on
    RewriteCond %{DOCUMENT_ROOT}/wp-content/pep-vn/cache/request-uri/data/%{SERVER_NAME}/$1/index-https.xml -f
    RewriteRule ^(.*) "/wp-content/pep-vn/cache/request-uri/data/%{SERVER_NAME}/$1/index-https.xml" [L]

    RewriteRule ^index\.php$ - [L]
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule . /index.php [L]
    </IfModule>

---

**<a name="block_bots"></a>Webhost - Block bad bots**
    
    # Start HackRepair.com Blacklist
    RewriteEngine on
    # Start Abuse Agent Blocking
    RewriteCond %{HTTP_USER_AGENT} "^Mozilla.*Indy" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Mozilla.*NEWT" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^$" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Maxthon$" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^SeaMonkey$" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Acunetix" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^binlar" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^BlackWidow" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Bolt 0" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^BOT for JCE" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Bot mailto\:craftbot@yahoo\.com" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^casper" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^checkprivacy" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^ChinaClaw" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^clshttp" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^cmsworldmap" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Custo" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Default Browser 0" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^diavol" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^DIIbot" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^DISCo" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^dotbot" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Download Demon" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^eCatch" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^EirGrabber" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^EmailCollector" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^EmailSiphon" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^EmailWolf" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Express WebPictures" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^extract" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^ExtractorPro" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^EyeNetIE" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^feedfinder" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^FHscan" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^FlashGet" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^flicky" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^g00g1e" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^GetRight" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^GetWeb\!" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Go\!Zilla" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Go\-Ahead\-Got\-It" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^grab" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^GrabNet" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Grafula" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^harvest" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^HMView" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Image Stripper" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Image Sucker" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^InterGET" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Internet Ninja" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^InternetSeer\.com" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^jakarta" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Java" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^JetCar" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^JOC Web Spider" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^kanagawa" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^kmccrew" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^larbin" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^LeechFTP" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^libwww" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Mass Downloader" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^microsoft\.url" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^MIDown tool" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^miner" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Mister PiX" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^MSFrontPage" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Navroad" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^NearSite" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Net Vampire" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^NetAnts" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^NetSpider" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^NetZIP" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^nutch" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Octopus" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Offline Explorer" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Offline Navigator" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^PageGrabber" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Papa Foto" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^pavuk" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^pcBrowser" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^PeoplePal" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^planetwork" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^psbot" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^purebot" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^pycurl" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^RealDownload" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^ReGet" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Rippers 0" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^sitecheck\.internetseer\.com" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^SiteSnagger" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^skygrid" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^SmartDownload" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^sucker" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^SuperBot" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^SuperHTTP" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Surfbot" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^tAkeOut" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Teleport Pro" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Toata dragostea mea pentru diavola" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^turnit" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^vikspider" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^VoidEYE" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Web Image Collector" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^WebAuto" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^WebBandit" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^WebCopier" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^WebFetch" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^WebGo IS" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^WebLeacher" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^WebReaper" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^WebSauger" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Website eXtractor" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Website Quester" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^WebStripper" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^WebWhacker" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^WebZIP" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Widow" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^WPScan" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^WWW\-Mechanize" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^WWWOFFLE" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Xaldon WebSpider" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^Zeus" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "^zmeu" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "360Spider" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "CazoodleBot" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "discobot" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "EasouSpider" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "ecxi" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "GT\:\:WWW" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "heritrix" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "HTTP\:\:Lite" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "HTTrack" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "ia_archiver" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "id\-search" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "IDBot" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "Indy Library" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "IRLbot" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "ISC Systems iRc Search 2\.1" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "LinksCrawler" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "LinksManager\.com_bot" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "linkwalker" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "lwp\-trivial" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "MFC_Tear_Sample" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "Microsoft URL Control" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "Missigua Locator" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "MJ12bot" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "panscient\.com" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "PECL\:\:HTTP" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "PHPCrawl" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "PleaseCrawl" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "SBIder" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "SearchmetricsBot" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "Snoopy" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "Steeler" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "URI\:\:Fetch" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "urllib" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "Web Sucker" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "webalta" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "WebCollage" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "Wells Search II" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "WEP Search" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "XoviBot" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "YisouSpider" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "zermelo" [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} "ZyBorg" [NC,OR]
    # End Abuse Agent Blocking
    # Start Abuse HTTP Referrer Blocking
    RewriteCond %{HTTP_REFERER} "^https?://(?:[^/]+\.)?semalt\.com" [NC,OR]
    RewriteCond %{HTTP_REFERER} "^https?://(?:[^/]+\.)?kambasoft\.com" [NC,OR]
    RewriteCond %{HTTP_REFERER} "^https?://(?:[^/]+\.)?savetubevideo\.com" [NC]
    # End Abuse HTTP Referrer Blocking
    RewriteRule ^.* - [F,L]
    # End HackRepair.com Blacklist, http://pastebin.com/u/hackrepair

---

**<a name="prevent_index">Webhost - Block directory search</a>**

    Options -Indexes -FollowSymLinks

---

**<a name="protect_htaccess">Webhost - Protect htaccess</a>**

    <Files ~ "^.*\.([Hh][Tt][Aa])">
    order allow,deny
    deny from all
    satisfy all
    </Files>

---

**<a name="add_svg">Webhost - Add support for SVG and HTC</a>**

    AddType image/svg+xml svg svgz
    AddEncoding gzip svgz
    AddType text/x-component .htc

---

**<a name="add_reality">Webhost - Add support for reality files</a>**

    # See: https://webkit.org/blog/8421/viewing-augmented-reality-assets-in-safari-for-ios/
    #
    # All files ending in .usdz served as USD.
    AddType model/vnd.usdz+zip usdz

---

**<a name="block_hidden">Webhost - Block access to hidden files & directories</a>**

    <IfModule mod_rewrite.c>
        RewriteCond %{SCRIPT_FILENAME} -d [OR]
        RewriteCond %{SCRIPT_FILENAME} -f
        RewriteRule "(^|/)\." - [F]
    </IfModule>

**<a name="wordpress_disablexmlrcp">WordPress - Disable XMLRCP</a>**

    <Files xmlrpc.php>
        Require all denied
    </Files>

---

**<a name="wordpress_protectadmin">Webhost - Exclude the files ajax, upload and WP CRON scripts from authentication</a>**

    <FilesMatch "(admin-ajax\.php|media-upload\.php|async-upload\.php|wp-cron\.php|xmlrpc\.php)$">
    Order allow,deny
    Allow from all
    Satisfy any
    </FilesMatch>

---

**<a name="disable_filesincludes">Wordpress - Disable files in include</a>**

    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteBase /

        # Block direct access to sensitive directories
        RewriteRule ^wp-admin/includes/ - [F,NC]
        RewriteRule ^wp-includes/ - [F,NC]

        # Block direct access to PHP files in wp-includes
        RewriteRule ^wp-includes/.+\.php$ - [F,NC]

        # Block direct access to language files in wp-includes/js/tinymce/langs
        RewriteRule ^wp-includes/js/tinymce/langs/.+\.php - [F,NC]

        # Block direct access to theme-compat directory
        RewriteRule ^wp-includes/theme-compat/ - [F,NC]
    </IfModule>

---

**<a name="protect_files">WordPress - Protect System Files</a>**

    <IfModule mod_authz_core.c>
        <FilesMatch "(^\.htaccess|readme\.(html|txt)|wp-config\.php)$">
            Require all denied
        </FilesMatch>
        <FilesMatch "(bak|config|dist|fla|inc|ini|log|psd|sh|sql|sw[op]|sftp-config\.json)">
            Require all denied
        </FilesMatch>
    </IfModule>
    <IfModule !mod_authz_core.c>
        <FilesMatch "(^\.htaccess|readme\.(html|txt)|wp-config\.php)$">
            Order allow,deny
            Deny from all
        </FilesMatch>
        <FilesMatch "(bak|config|dist|fla|inc|ini|log|psd|sh|sql|sw[op]|sftp-config\.json)">
            Order allow,deny
            Deny from all
        </FilesMatch>
    </IfModule>

---
**<a name="force_ie">Webhost - Force IE 8/9/10 to render pages in the highest mode</a>**

    <IfModule mod_headers.c>
        Header set X-UA-Compatible "IE=edge"
        <FilesMatch "\.(appcache|atom|bbaw|bmp|crx|css|cur|eot|f4[abpv]|flv|geojson|gif|htc|ico|jpe?g|js|json(ld)?|m4[av]|manifest|map|mp4|oex|og[agv]|opus|otf|pdf|png|rdf|rss|safariextz|svgz?|swf|topojson|tt[cf]|txt|vcard|vcf|vtt|webapp|web[mp]|webmanifest|woff2?|xloc|xml|xpi)$">
            Header unset X-UA-Compatible
        </FilesMatch>
    </IfModule>

---

**<a name="correct_mime">Webhost - Server resources with the correct mime types</a>**

    <IfModule mod_mime.c>
    # Data interchange
        AddType application/atom+xml                        atom
        AddType application/json                            json map topojson
        AddType application/ld+json                         jsonld
        AddType application/rss+xml                         rss
        AddType application/vnd.geo+json                    geojson
        AddType application/xml                             rdf xml
    # JavaScript
        AddType application/javascript                      js
    # Manifest files
        AddType application/manifest+json                   webmanifest
        AddType application/x-web-app-manifest+json         webapp
        AddType text/cache-manifest                         appcache
    # Media files
        AddType audio/mp4                                   f4a f4b m4a
        AddType audio/ogg                                   oga ogg opus
        AddType image/bmp                                   bmp
        AddType image/svg+xml                               svg svgz
        AddType image/webp                                  webp
        AddType video/mp4                                   f4v f4p m4v mp4
        AddType video/ogg                                   ogv
        AddType video/webm                                  webm
        AddType video/x-flv                                 flv
        AddType image/x-icon                                cur ico
    # Web fonts
        AddType application/font-woff                       woff
        AddType application/font-woff2                      woff2
        AddType application/vnd.ms-fontobject               eot
        AddType application/x-font-ttf                      ttc ttf
        AddType font/opentype                               otf
    # Other
        AddType application/octet-stream                    safariextz
        AddType application/x-bb-appworld                   bbaw
        AddType application/x-chrome-extension              crx
        AddType application/x-opera-extension               oex
        AddType application/x-xpinstall                     xpi
        AddType text/vcard                                  vcard vcf
        AddType text/vnd.rim.location.xloc                  xloc
        AddType text/vtt                                    vtt
        AddType text/x-component                            htc
    </IfModule>

---

**<a name="correct_mime">Webhost - Character encodings as utf-8</a>**


    AddDefaultCharset utf-8
    <IfModule mod_mime.c>
        AddCharset utf-8 .atom \
                        .bbaw \
                        .css \
                        .geojson \
                        .js \
                        .json \
                        .jsonld \
                        .manifest \
                        .rdf \
                        .rss \
                        .topojson \
                        .vtt \
                        .webapp \
                        .webmanifest \
                        .xloc \
                        .xml
    </IfModule>

---

**<a name="vary_encoding">Webhost - Add enconding in files increase perfomance</a>**

    # VARY ENCODING - https://www.maxcdn.com/blog/accept-encoding-its-vary-important/

    <IfModule mod_headers.c>
    <FilesMatch ".(js|css|xml|gz|html|woff|woff2)$">
        Header append Vary: Accept-Encoding
    </FilesMatch>
    </IfModule>

---

**<a name="enable_gzip">Webhost - Enable gzip in files increase perfomance</a>**

    <ifModule mod_gzip.c>
    mod_gzip_on Yes
    mod_gzip_dechunk Yes
    mod_gzip_item_include file .(html?|txt|css|js|php|pl)$
    mod_gzip_item_include handler ^cgi-script$
    mod_gzip_item_include mime ^text/.*
    mod_gzip_item_include mime ^application/x-javascript.*
    mod_gzip_item_exclude mime ^image/.*
    mod_gzip_item_exclude rspheader ^Content-Encoding:.*gzip.*
    </ifModule>

**<a name="secure_includes">WordPress - Secure wp-includes</a>**

    <IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    RewriteRule ^wp-admin/includes/ - [F,L]
    RewriteRule !^wp-includes/ - [S=3]
    RewriteRule ^wp-includes/[^/]+\.php$ - [F,L]
    RewriteRule ^wp-includes/js/tinymce/langs/.+\.php - [F,L]
    RewriteRule ^wp-includes/theme-compat/ - [F,L]
    </IfModule>

---

**<a name="disable_phpuploads">WordPress - Disable PHP in Uploads</a>**

    <IfModule mod_rewrite.c>
        RewriteRule ^wp-content/uploads/.*\.(?:php[1-7]?|pht|phtml?|phps)\.?$ - [F]
    </IfModule>

---

**<a name="disable_phpplugins">WordPress - Disable PHP in Plugins</a>**

    <IfModule mod_rewrite.c>
        RewriteRule ^wp-content/plugins/.*\.(?:php[1-7]?|pht|phtml?|phps)\.?$ - [F]
    </IfModule>

---

**<a name="disable_phptheme">WordPress - Disable PHP in Themes**

    <IfModule mod_rewrite.c>
        RewriteRule ^wp-content/themes/.*\.(?:php[1-7]?|pht|phtml?|phps)\.?$ - [F]
    </IfModule>

---

**<a name="disable_enumeration">WordPress - Disable WordPress enumaration</a>**

    # See: https://www.wpbeginner.com/wp-tutorials/how-to-discourage-brute-force-by-blocking-author-scans-in-wordpress/

    <IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    RewriteCond %{QUERY_STRING} (author=\d+) [NC]
    RewriteRule .* - [F]
    </IfModule>


**<a name="change_loginurl">WordPress - Change default login URL</a>**

    # BEGIN WordPress
    <IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    RewriteRule ^wp-login\.php$ - [R=404,L]
    RewriteRule ^my-secret-login$ /wp-login.php [L]
    </IfModule>
    # END WordPress

---

**<a name="stop_refspam">WordPress - Stop Comment Posting without proper Referer</a>**

    # Ref : http://www.slideshare.net/erchetansoni/complete-wordpress-security-by-chetan-soni-sr-security-specialist-at-secugenius-security-solutions

    RewriteEngine On
    RewriteCond %{REQUEST_METHOD} POST
    RewriteCond %{REQUEST_URI} .wp-comments-post\.php*
    RewriteCond %{HTTP_REFERER} !.*yourblog.com.* [OR]
    RewriteCond %{HTTP_USER_AGENT} ^$
    RewriteRule (.*) ^http://%{REMOTE_ADDR}/$ [R=301,L]

---

**<a name="stop_phpeegg">Webhost - Disallow PHP Easter Eggs (can be used in fingerprinting attacks to determine your PHP version</a>**

## See http://www.0php.com/php_easter_egg.php and
## http://osvdb.org/12184 for more information
## Ref : http://journalxtra.com/websiteadvice/wordpress-security-hardening-htaccess-rules/
    RewriteCond %{QUERY_STRING} \=PHP[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12} [NC]
    RewriteRule .* - [F,L]

---

**<a name="redirect_feedburner"></a>WordPress - Redirect feeds to feedburner**
    
    <IfModule mod_alias.c>
      RedirectMatch 301 /feed/(atom|rdf|rss|rss2)/?$ http://feedburner.com/yourfeed/
      RedirectMatch 301 /comments/feed/(atom|rdf|rss|rss2)/?$ http://feedburner.com/yourfeed/
    </IfModule>


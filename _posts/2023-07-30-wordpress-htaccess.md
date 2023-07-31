---
layout: post
title:  WordPress Htaccess
categories: [WordPress,Code]
excerpt: A collection of WordPress htaccess
---

# htaccess codes for you WordPress

Place it on .htacces

*   Changelog

- 1.0: Started
- 1.1: Converted to github pages

---

**Use UTF-8 encoding for anything served text/plain or text/html**

    AddDefaultCharset UTF-8
    <IfModule mod_mime.c>
        AddCharset UTF-8 .atom .css .js .json .rss .vtt .xml
    </IfModule>
    
---

**FileETag None is not enough for every server**

    <IfModule mod_headers.c>
    Header unset ETag
    </IfModule>

---

**Remove X-Powered-By and others values to avoid sniffing**

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

**Disable XMLRCP**

    <Files xmlrpc.php>
        Require all denied
    </Files>

---

**Enable deflate on files**

    <IfModule mod_deflate.c>
        # Enable compression for the specified MIME types
        AddOutputFilterByType DEFLATE text/html text/css text/javascript text/xml text/plain image/x-icon image/svg+xml application/rss+xml application/javascript application/x-javascript application/xml application/xhtml+xml application/x-font application/x-font-truetype application/x-font-ttf application/x-font-otf application/x-font-opentype application/vnd.ms-fontobject font/ttf font/otf font/opentype
        
        # Set the compression level (choose from 1 to 9, where 9 is the highest compression)
        DeflateCompressionLevel 6
    </IfModule>

---

**Disable files in include**

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

**Protect System Files**

    <IfModule mod_authz_core.c>
        <FilesMatch "(^\.htaccess|readme\.(html|txt)|wp-config\.php)$">
            Require all denied
        </FilesMatch>
    </IfModule>
    <IfModule !mod_authz_core.c>
        <FilesMatch "(^\.htaccess|readme\.(html|txt)|wp-config\.php)$">
            Order allow,deny
            Deny from all
        </FilesMatch>
    </IfModule>

---

**Disable PHP in Uploads**

    <IfModule mod_rewrite.c>
        RewriteRule ^wp-content/uploads/.*\.(?:php[1-7]?|pht|phtml?|phps)\.?$ - [F]
    </IfModule>

---

**Disable PHP in Plugins**

    <IfModule mod_rewrite.c>
        RewriteRule ^wp-content/plugins/.*\.(?:php[1-7]?|pht|phtml?|phps)\.?$ - [F]
    </IfModule>

---

**Disable PHP in Themes**

    <IfModule mod_rewrite.c>
        RewriteRule ^wp-content/themes/.*\.(?:php[1-7]?|pht|phtml?|phps)\.?$ - [F]
    </IfModule>

---

**Filter Request Methods**

    <IfModule mod_rewrite.c>
        RewriteRule ^(TRACE|TRACK) - [F]
    </IfModule>

---

**Filter Suspicious Query Strings in the URL**

    <IfModule mod_rewrite.c>
	RewriteCond %{QUERY_STRING} \.\.\/ [OR]
	RewriteCond %{QUERY_STRING} \.(bash|git|hg|log|svn|swp|cvs) [NC,OR]
	RewriteCond %{QUERY_STRING} etc/passwd [NC,OR]
	RewriteCond %{QUERY_STRING} boot\.ini [NC,OR]
	RewriteCond %{QUERY_STRING} ftp: [NC,OR]
    #RewriteCond %{QUERY_STRING} https?: [NC,OR]
	RewriteCond %{HTTP_HOST} !^www\.bandodenerd\.com\.br$ [NC]
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
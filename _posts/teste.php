
    // Steam
    
    if ($social_networks["steam"]) {
        $steam_target = "steamid";
        $steam_url = "https://steamcommunity.com/id/$username";
        $steam_id = preg_match('/steamid":"[^"]*/', file_get_contents($steam_url), $matches);
        $steam_id = $matches[0] ?? "";

        check_result("Steam", $steam_url, $steam_target, true);
    }
    



    // Twitter
    if ($social_networks["twitter"]) {
        // Twitter commands go here
        echo 'none';
    }

    // Instagram
    if ($social_networks["instagram"]) {
        $instagram_target = '"username":"' . $username . '"';
        $instagram_url = "https://www.instagram.com/$username/";

        check_result("Instagram", $instagram_url, $instagram_target);
    }

    // Threads
    if ($social_networks["threads"]) {
        $threads_target = 'vanity';
        $threads_url = "https://www.threads.net/@$username";

        check_result("Threads", $threads_url, $threads_target);
    }

    // Snapchat
    if ($social_networks["snapchat"]) {
        $snapchat_target = "username";
        $snapchat_url = "https://www.snapchat.com/add/$username";

        check_result("Snapchat", $snapchat_url, $snapchat_target);
    }

    // TikTok
    if ($social_networks["tiktok"]) {
        $tiktok_target = "uniqueId";
        $tiktok_url = "https://www.tiktok.com/@$username";

        check_result("TikTok", $tiktok_url, $tiktok_target);
    }

    // Kwai
    if ($social_networks["kwai"]) {
        $kwai_target = 'alternateName:"' . $username . '"';
        $kwai_url = "https://www.kwai.com/@$username";
        $f = true;

        check_result("Kwai", $kwai_url, $kwai_target, $f);
    }

    // Pinterest
    if ($social_networks["pinterest"]) {
        $pinterest_target = '"username":"' . $username . '"';
        $pinterest_url = "https://pinterest.com/$username/";
        $f = true;

        check_result("Pinterest", $pinterest_url, $pinterest_target, $f);
    }
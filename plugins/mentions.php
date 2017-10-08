<?php

if( !defined( "IN_MYBB" ) ) {
    die( "Direct initialization disallowed for the mentions plugin." );
}

$plugins->add_hook("parse_message", "replace_uid_mentions");
$plugins->add_hook("datahandler_post_insert_post", "replace_username_mentions");
$plugins->add_hook("datahandler_post_insert_thread_post", "replace_username_mentions");
// TO-DO: PMs, maybe?

function mentions_info() {
    return array(
        "name" => "Mentions",
        "description" => "Mention users by name and uid",
        "website" => "https://eternal.is/",
        "author" => "Sweets",
        "authorsite" => "https://eternal.is/user/sweets",
        "version" => "2.0",
        "guid" => "",
        "compatibility" => "18*"
    );
}

function stylize($user) {
    $formatted_name = format_name($user['username'], $user['usergroup'], $user['displaygroup']);
    return "<a href=\"/" . get_profile_link($user['uid']) . "\">" . $formatted_name . "</a>";
}

function replace_uid_mentions($message) {

    global $db;

    $uid_regex =  "/\@([\d]+)([^\d]|$)/";
    preg_match_all($uid_regex, $message, $uid_matches, PREG_SET_ORDER);

    foreach($uid_matches as $match) {

        $query = $db->simple_select("users", "*", "uid = " . $match[1]);

        if ($db->num_rows($query) >= 1) {

            $user = $db->fetch_array($query);
            $message = str_replace($match[0], stylize($user) . $match[2], $message);

        }

    }

    return $message;

}

function replace_username_mentions(&$post) {

    global $db;

    if ($post->data['savedraft'])
        return;

    $username_regex = "/\@(\\\\['|\"]{1}|[`]{1})(.+)(\\1)/";
    preg_match_all($username_regex, $post->post_insert_data['message'], $matches, PREG_SET_ORDER);

    foreach($matches as $match) {

        $query = $db->simple_select("users", "*", "username = \"" . $db->escape_string($match[2]) . "\"");

	if ($db->num_rows($query) >= 1) {

            $uid = $db->fetch_field($query, "uid");

	    if ($uid >= 1)
                $post->post_insert_data['message'] = str_replace($match[0], "@" . $uid, $post->post_insert_data['message']);

	}

    }

}

?>

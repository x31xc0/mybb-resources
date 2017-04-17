<?php

/*

Modified version of Eternal's mentions plugin. Modified because it references parts of MyBB that were modified for Eternal.

   */

if( !defined( "IN_MYBB" ) ) {
    die( "Direct initialization disallowed for the mentions plugin." );
}

$plugins->add_hook("parse_message", "mentions_change_to_username");

function mentions_info() {
    return array(
        "name" => "Mentions",
        "description" => "Mention users by name and uid",
        "website" => "https://eternal.is/",
        "author" => "Sweets",
        "authorsite" => "https://eternal.is/user/sweets",
        "version" => "1.0",
        "guid" => "",
        "compatibility" => "18*"
    );
}

function stylize($user) {
	$style = format_name($user['username'], $user['usergroup'], $user['displaygroup']);
	return "<a href=\"/" . get_profile_link($user['uid']) . "\">" . $style . "</a>";

}

function mentions_change_to_username($message) {
	global $db;
	$uid_match = "/\@([\d]+)([^\d]|$)/";
	preg_match_all($uid_match, $message, $uidmatches, PREG_SET_ORDER);
	foreach($uidmatches as $uid) {
		$query = $db->simple_select("users", "*", "uid = " . $uid[1]);
		if ($db->num_rows($query) >= 1) {
			$user = $db->fetch_array($query);
			$message = str_replace($uid[0], stylize($user) . $uid[2], $message);
		}
	}
	return $message;
}

?>

<?php

/* Start session */
session_start();

/* Set login status to false if not exists */
if(!isset($_SESSION['status']))
    $_SESSION['status'] = false;

/* Set last action to current time */
$_SESSION['last_action'] = time();

$sessid = "NULL";
if($_SESSION['status'])
    $sessid = sprintf("%d", $_SESSION['id']);

$sql = sprintf("INSERT INTO loginstat (user_id, time, url, ip, user_agent)
                    VALUES (%s, '%d', '%s', '%s', '%s')", $sessid, time(), $mysqli->real_escape_string($_SERVER["REQUEST_URI"]), $mysqli->real_escape_string($_SERVER["REMOTE_ADDR"]), $mysqli->real_escape_string($_SERVER["HTTP_USER_AGENT"]));
$eredmeny = $mysqli->query($sql);
if(!$eredmeny)
    throw new Exception("SQL Insert error: " . $mysqli->error);

/**
 * This function logs in with the user
 *
 * @param	$id: This parameter specifies the user id
 * @param	$rem: This parameter specifies whether remember the user or not
 * @throws	Exception when SQL error happens
 * @return 	None
 */
function login($id)
{
    /* Use the global database variable */
    global $mysqli;

    /* If not active user send to activation page */
    $tomb = rekord("activation", "user_id", $id);
    if($tomb['active'] == 0)
        tovabb("/activate?uid=$id");

    /* Set session variables */
    $_SESSION['id'] = $id;
    $user = rekord("users", "user_id", $id);
    $_SESSION['name'] = $user['username'];
    $_SESSION['status'] = true;
    $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
}

/**
 * This function authenticate the user (Checks if logged in)
 *
 * @param	$b: Default false. If true, check the admin privilge
 * @throws	Exception when SQL error occures
 * @return	True when the user logged in
 */
function auth(&$b = false)
{
    /* Use the global database variable */
    global $mysqli;

    /* If logged in and time limit not passed */
    if(isset($_SESSION['id']) and $_SESSION['ip'] == $_SERVER['REMOTE_ADDR'] and $_SESSION['last_action'] > (time() - 1800))
    {
        if($b && !isadmin($_SESSION['id']))
            $b = false;
    }
    /* Not logged in */
    else
    {
        unset($_SESSION['id']);
        $_SESSION['ip'] = '';
        $_SESSION['last_action'] = 0;
        return false;
    }
    /* Return */
    return true;
}

/**
 * This function check the user admin privilges
 *
 * @param	None
 * @return 	true if admin
 */
function isadmin()
{
    $tomb = rekord("users", "user_id", $_SESSION['id']);
    return $tomb['admin'];
}
?>
<?php
/* Include the database related functions */
require_once ("database.php");

/* Include the session related functions */
require_once ("session.php");

/* If admin page load the admin functions */
if(substr($_SERVER['PHP_SELF'], 1, strpos($_SERVER['PHP_SELF'], '/', 1) - 1) == "swgadmin")
    require_once ("admin_func.php");

/**
 * This function redirect the page to the specified location
 *
 * @param	$cim: This string specifies the adress
 * @return 	None
 */
 
function tovabb($cim)
{
    header("Location: " . $cim);
    exit ;
}

/**
 * This function sets the given values in the database
 *
 * @param 	$pass: This string specifies the password of the user
 * @param	$id: This int specifies the user id
 * @param	$fname: This string specifies the full name of the user
 * @param	$koli: This string specifies the dorm field
 * @param	$szoba: This string specifies the dorm room field
 * @param	$sex: This parameter specifies the sex of the user
 * @throws	Exception when SQL error occures
 * @return	None
 */

function settings($pass, $id, $fname, $koli, $szoba, $sex)
{
    global $mysqli;

    if(!empty($pass))
    {
        $sql = sprintf("UPDATE users SET pass='%s' WHERE user_id=%d;", $mysqli->real_escape_string($pass), $id);
        if(!$eredmeny = $mysqli->query($sql))
            throw new Exception("SQL Update error: " . $mysqli->error);
    }

    $sql = sprintf("UPDATE userdata SET full_name = '%s', sex=%d, koli=%d, szoba='%s' WHERE user_id = %d;", $mysqli->real_escape_string($fname), $sex, $koli, $mysqli->real_escape_string($szoba), $id);
    if(!$eredmeny = $mysqli->query($sql))
        throw new Exception("SQL Update error: " . $mysqli->error);
}

/**
 * This function resets the user in the database (deletes the user related rows)
 *
 * @param	None
 * @throws	Exception when SQL error occures
 * @return 	None
 */
function rst()
{
    global $mysqli;

    $sql = sprintf("UPDATE users SET level=0 WHERE user_id = %d;", $_SESSION['id']);
    if(!$eredmeny = $mysqli->query($sql))
        throw new Exception("SQL Update error: " . $mysqli->error);

    $sql = sprintf("DELETE FROM levelstat WHERE user_id = %d", $_SESSION['id']);
    if(!$eredmeny = $mysqli->query($sql))
        throw new Exception("SQL Delete error: " . $mysqli->error);

    $_SESSION['level'] = 0;
}

/**
 * This function gets the username by the specified id
 *
 * @param 	$id: This parameter specifies the user id
 * @throws	Exception when SQL error occurs, or not existent user id
 * @return	Returns the username
 */
function get_uname_by_id($id)
{
    /* Use the global database variable */
    global $mysqli;

    /* Select the user row */
    $sql = sprintf("SELECT username FROM users WHERE user_id=%d", $id);
    if(!$eredmeny = $mysqli->query($sql))
        throw new Exception("SQL Select error: " . $mysqli->error);

    /* Error when not existent user id */
    if($eredmeny->num_rows != 1)
        throw new Exception("Rossz user_id");

    $uname = $eredmeny->fetch_array();
    return $uname[0];
}

/**
 * This function gets the avatar's filepath
 *
 * @param 	$id: This value specifies the user id
 * @throws	Exceotion when SQL error occures, or not-existent user id
 * @return	The path of the avatar image
 */
function get_filepath_by_id($id)
{
    /* Use the global database variable */
    global $mysqli;

    $sql = sprintf("SELECT file_path FROM images WHERE user_id=%d", $id);
    if(!$eredmeny = $mysqli->query($sql))
        throw new Exception("SQL Select error: " . $mysqli->error);
    if($eredmeny->num_rows != 1)
        throw new Exception("Rossz user_id");
    $uname = $eredmeny->fetch_array();
    return $uname[0];
}

/**
 * This function looks up for the specified user
 *
 * @param 	$id: This parameter specifies the user id
 * @return 	True when the specified user exists every other case returns false
 **/
function user_exists($id)
{
    global $mysqli;

    $sql = sprintf("SELECT user_id FROM users WHERE user_id = '%d'", $id);
    if(!$eredmeny = $mysqli->query($sql))
        throw new Exception("SQL Select error: ".$mysqli->error);
    
    if(!$eredmeny->num_rows)
        return false;
    else
        return true;
}

/**
 * This function gathers data about the user
 *
 * @param	$id: This parameter specifies the user id
 * @throws	Exceptions when SQL error happens
 * @return 	Array of user data
 * 			Keys:
 * 		username 	- 	This string is the username
 * 		level		-	This number is the reached levels
 * 		fullname	-	This string is the user's fullname
 * 		sex			-	This number is the sex of the user
 * 		koli		-	This number is 1 when de user lives in dorm 0 otherwise
 * 		szoba		-	This string is a dorm door number
 * 		ido			-	This is the full playtime in seconds
 * 		min			-	This is the time of the fastest level completion
 * 		levelmin	-	This is the fastest level
 * 		max			-	This is the time of the slowest level completion
 * 		levelmax	-	This is the slowest level
 * 		hint		-	This is the number of used hints
 * 		lactive		-	This is timestamp of the last login time
 * 		msg			-	This is the number of the written messages in the forum
 * 		avatar		-	This is the path of the avatar
 */
function user_data($id)
{
    /* Use the global database variable */
    global $mysqli;

    /* Starting array */
    $tomb = array();

    /* Gather username, level, fullname, sex, koli, szoba */
    $sql = sprintf("SELECT users.username, userdata.full_name, userdata.sex, userdata.koli, userdata.szoba FROM users, userdata WHERE userdata.user_id=users.user_id and users.user_id=%d", $id);
    $eredmeny = $mysqli->query($sql);
    if($eredmeny)
    {
        if(!$eredmeny->num_rows)
        {
            return false;
        }
        $sor = $eredmeny->fetch_row();
        $tomb["username"] = $sor[0];
        $tomb["full_name"] = $sor[1];
        $tomb["sex"] = $sor[2];
        $tomb["koli"] = $sor[3];
        $tomb["szoba"] = $sor[4];
    }
    else
    {
        echo "SQL Select error: " . $mysqli->error;
        return false;
    }
    
    $sql = sprintf("SELECT COUNT(*) FROM levelstat WHERE user_id = '%d' AND finish <> 0", $id);
    if(!$eredmeny = $mysqli->query($sql))
    {
        echo "SQL Error: ".$mysqli->error;
        return false;
    }
    else
    {
        $sor = $eredmeny->fetch_array();
        $tomb["level"] = $sor[0]; 
    }

    //gather full playtime
    $sql = sprintf("SELECT SUM(levelstat.finish-levelstat.start)
                    FROM levelstat
                    WHERE levelstat.finish <> 0 AND user_id=%d", $id);
    $eredmeny = $mysqli->query($sql);
    if($eredmeny)
    {
        if(!$eredmeny->num_rows)
        {
            $tomb['ido'] = 0;
        }
        else
        {
            $row = $eredmeny->fetch_row();
            $tomb['ido'] = $row[0];
        }
    }
    else
    {
        echo "SQL Select error: " . $mysqli->error;
        return false;
    }

    //gather minimum level, and time
    $sql = sprintf("SELECT sub.min, levelstat.level
					FROM levelstat,
					(
						SELECT MIN(finish-start) AS min
						FROM levelstat
						WHERE user_id=%d AND finish <> 0
					) sub
					WHERE levelstat.finish-levelstat.start = sub.min", $id);
    $eredmeny = $mysqli->query($sql);
    if($eredmeny)
    {
        if(!$eredmeny->num_rows)
        {
            $tomb['min'] = 0;
            $tomb['levelmin'] = 0;
        }
        else
        {
            $row = $eredmeny->fetch_row();
            $tomb['min'] = $row[0];
            $tomb['levelmin'] = $row[1];
        }
    }
    else
    {
        echo "SQL Select error: " . $mysqli->error;
        return false;
    }

    //gather maximum level, and time
    $sql = sprintf("SELECT sub.max, levelstat.level
					FROM levelstat,
					(
						SELECT MAX(finish-start) AS max
						FROM levelstat
						WHERE user_id=%d AND finish <> 0
					) sub
					WHERE levelstat.finish-levelstat.start = sub.max", $id);
    $eredmeny = $mysqli->query($sql);
    if($eredmeny)
    {
        if(!$eredmeny->num_rows)
        {
            $tomb['max'] = 0;
            $tomb['levelmax'] = 0;
        }
        else
        {
            $row = $eredmeny->fetch_row();
            $tomb['max'] = $row[0];
            $tomb['levelmax'] = $row[1];
        }
    }
    else
    {
        echo "SQL Select error: " . $mysqli->error;
        return false;
    }

    //time of last activity
    $sql = sprintf("SELECT time
					FROM loginstat
					WHERE user_id=%d
					ORDER BY time DESC
					LIMIT 0,1", $id);
    $eredmeny = $mysqli->query($sql);
    if($eredmeny)
    {
        if(!$eredmeny->num_rows)
        {
            $tomb['lactive'] = 0;
        }
        else
        {
            $row = $eredmeny->fetch_row();
            $tomb['lactive'] = $row[0];
        }
    }
    else
    {
        echo "SQL Select error: " . $mysqli->error;
        return false;
    }

    //count of messages in the forum
    // $sql = sprintf("SELECT COUNT(msg_id)
					// FROM msgs
					// WHERE user_id=%d
					// GROUP BY user_id;", $id);
    // $eredmeny = $mysqli->query($sql);
    // if($eredmeny)
    // {
        // if(!$eredmeny->num_rows)
        // {
            // $tomb['msg'] = 0;
        // }
        // else
        // {
            // $row = $eredmeny->fetch_row();
            // $tomb['msg'] = $row[0];
        // }
    // }
    // else
    // {
        // echo "SQL Select error: " . $mysqli->error;
        // return false;
    // }

    //filepath of avatar
    $sql = sprintf("SELECT file_path FROM images WHERE user_id = %d", $id);
    $eredmeny = $mysqli->query($sql);
    if($eredmeny)
    {
        if(!$eredmeny->num_rows)
        {
            $tomb['avatar'] = "";
        }
        else
        {
            $row = $eredmeny->fetch_row();
            $tomb['avatar'] = $row[0];
        }
    }
    else
    {
        echo "SQL Select error: " . $mysqli->error;
        return false;
    }

    return $tomb;
}

/**
 * This function returns the current level of the user
 *
 * @param	$id: This parameter specifies the user id
 * @return	Level of the user
 */
function get_user_level($id)
{
    $user = rekord("users", "user_id", $id);
    return $user['level'];
}

/**
 * This function gets a time interval in seconds and generates string format
 *
 * @param	$int: Time interval in seconds
 * @return	Time interval in string format
 */
function get_interval_string($int)
{
    if($int <= 90)
        return $int . "s";

    if($int <= (65 * 60))
        return (int)($int / 60) . "m " . ($int % 60) . "s";

    if($int <= (25 * 60 * 60))
        return (int)($int / (60 * 60)) . "h " . (int)(($int % (60 * 60)) / 60) . "m " . ($int % 60) . "s";

    return (int)($int / (60 * 60 * 24)) . "d " . (int)(($int % (60 * 60 * 24)) / (60 * 60)) . "h " . (int)(($int % (60 * 60)) / 60) . "m";
}

/**
 * This function replaces the BB like code
 *
 * @param	$szoveg: This is the input string where to fint the occurances
 * @return	Replaced string
 */
function bb_decode($szoveg)
{
    //[url=''][/url]
    $pattern = "#\[url='([^']*)'\]([^\[]*)\[/url\]#";
    while(preg_match($pattern, $szoveg, $match))
    {
        $replace = "<a href=\"{$match[1]}\" target=\"_blank\">{$match[2]}</a>";
        $szoveg = preg_replace($pattern, $replace, $szoveg, 1);
    }

    //[b],[i]
    $bb = array("[b]", "[/b]", "[i]", "[/i]");
    $decoded = array("<b>", "</b>", "<i>", "</i>");
    $szoveg = str_replace($bb, $decoded, $szoveg);

    //válasz kiemelése
    $pattern = "/(Válasz [^ ]+ üzenetére: \(#\d+\))/";
    $replace = "<font color=\"#999999\">$1</font>";
    $szoveg = preg_replace($pattern, $replace, $szoveg);

    //sortörés
    $order = array("\r\n", "\n", "\r");
    $replace = '<br />';
    $szoveg = str_replace($order, $replace, $szoveg);

    //[edit]
    $pattern = "#\[edit](.*)\[/edit\]#";
    if(preg_match($pattern, $szoveg, $match))
    {
        $replace = "<font color=\"#0088ff\">{$match[1]}</font>";
        $szoveg = preg_replace($pattern, $replace, $szoveg);
    }

    //smile
    $smile = array("angel" => "(a)", "cool" => "(h)", "yell" => "(y)", "smile" => ":-)", "laugh" => ":-D", "sad" => ":-(", "tongue" => ":-P", "wink" => ";-)", "surprised" => ":-o", "embarassed" => ":-\$", "cry" => ":'(", "undecided" => ":-/");
    $img = array();
    foreach($smile as $nev => $ertek)
    {
        $img[$nev] = "<img src=\"/images/smile/$nev.png\" />";
    }
    $szoveg = str_replace($smile, $img, $szoveg);
    $smile2 = array("smile" => ":)", "laugh" => ":D", "sad" => ":(", "tongue" => ":P", "wink" => ";)", "surprised" => ":o", "embarassed" => ":\$");
    $img2 = array();
    foreach($smile2 as $nev => $ertek)
    {
        $img2[$nev] = "<img src=\"/images/smile/$nev.png\" />";
    }
    $szoveg = str_replace($smile2, $img2, $szoveg);

    return $szoveg;
}

/**
 * This function generates HTML code for pageing
 *
 * @param	$sum_line: numbers of all element
 * @param	$line_page: element in one page
 * @param	$page: current page number
 * @param	$link: lint where to point
 * @return	None
 */
function lapozas($sum_line, $line_page, $page, $link)
{
    //felső egészrész
    if($sum_line % $line_page == 0)
        $sum_page = $sum_line / $line_page;
    else
        $sum_page = (int)($sum_line / $line_page) + 1;

    if($sum_line > $line_page)
    {
        require ("content/common/site_pager.php");
    }
}

/**
 * This function checks the file paramteres to be valid
 *
 * @param	$code: upload status from PHP upload function
 * @throws	Exception when error occures
 * @return	Retunr if everithing went ok
 */
function valid_upload($code)
{
    if($code == UPLOAD_ERR_OK)
    {
        return;
    }

    switch ($code)
    {
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            $msg = 'A fájl túl nagy!';
            break;

        case UPLOAD_ERR_PARTIAL:
            $msg = 'A fájl csak részlegesen lett feltöltve!';
            break;

        case UPLOAD_ERR_NO_FILE:
            $msg = 'Nincs fájl feltöltve!';
            break;

        case UPLOAD_ERR_NO_TMP_DIR:
            $msg = 'A feltöltési mappa nem található!';
            break;

        case UPLOAD_ERR_CANT_WRITE:
            $msg = 'A feltöltött fájl írásvédett!';
            break;

        case UPLOAD_ERR_EXTENSION:
            $msg = 'Feltöltés meghiusult a kiterjesztés miatt!';
            break;

        default:
            $msg = 'Ismeretlen hiba!';
    }

    throw new Exception($msg);
}
?>
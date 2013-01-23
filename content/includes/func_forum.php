<?php

/**
 * This function ganerates the HTML code for the forum page (topic list)
 *
 * @param   void
 * @throws  Exception when SQL error happens
 * @return  void
 */
function forum()
{
    /* Use global database variable */
    global $mysqli;

    /* Get the list of topics */
    $sql = "SELECT * FROM topics";
    if( !$eredmeny = $mysqli->query($sql))
        throw new Exception("SQL Select error: " . $mysqli->error);

    /* Gather the topic related info */
    while($sor = $eredmeny->fetch_array())
    {
        $topic_id = $sor['topic_id'];
        $name = $sor['name'];
        $time = $sor['time'];
        $owner_id = $sor['owner'];
        $owner = get_uname_by_id($owner_id);

        $sql2 = sprintf("SELECT time, user_id FROM msgs WHERE topic_id='%d' ORDER BY time DESC", $topic_id);
        if( !$eredmeny2 = $mysqli->query($sql2))
            throw new Exception("SQL Select error: " . $mysqli->error);

        $sor2 = $eredmeny2->fetch_array();
        $last_time = $sor2['time'];
        $last_uid = $sor2['user_id'];

        if($last_uid == "")
        {
            $last_uid = 0;
            $last_user = "Törölt Felhasználó";
        }
        else
            $last_user = get_uname_by_id($last_uid);

        $sum = $eredmeny2->num_rows;

        /* Insert the HTML table row */
        require ("content/common/pattern_forum.php");

        $eredmeny2->free();
    }
}

/**
 * This function creates the messages int the specified topic and page
 *
 * @param   int $tp This variable specifies the topic id
 * @param   int $oldal This variable specifies the page to show, default is 1
 * @throws  Exception when SQL error happens
 * @return  void
 */
function topic($tp, $oldal = 1)
{
    /* Use the global database variable */
    global $mysqli;

    /* Calculate the id of the first message */
    $kezdo = 5 * ($oldal - 1);

    /* Get all message id from the related topic */
    $sql = sprintf("SELECT msg_id FROM msgs WHERE topic_id=%d", $tp);
    if( !$eredmeny = $mysqli->query($sql))
        throw new Exception("SQL Select error: " . $mysqli->error);
    $max = $eredmeny->num_rows;
    //$i = $max-($oldal-1)*5;

    /* Get the messages and the related data */
    $sql = sprintf("SELECT msg, time, msg_id, user_id, msg_no
					FROM msgs
					WHERE topic_id=%d
					ORDER BY time DESC
					LIMIT %d,5", $tp, $kezdo);
    if( !$eredmeny = $mysqli->query($sql))
        throw new Exception("SQL Select error: " . $mysqli->error);

    $mysql_data = array();
    while($sor = $eredmeny->fetch_array())
        $mysql_data[] = $sor;
    $mysql_data = array_reverse($mysql_data);

    /* Create the messages, get the related data */
    foreach($mysql_data as $sor)
    {
        $msg = $sor['msg'];
        $id = $sor['msg_id'];
        $time = $sor['time'];
        $uid = $sor['user_id'];
        $i = $sor['msg_no'];

        if($uid == "")
        {
            $uid = 0;
            $avatar = "del_user.png";
            $username = "Törölt User";
        }
        else
        {
            $avatar = get_filepath_by_id($uid);
            $username = get_uname_by_id($uid);
        }

        include ("content/common/pattern_topic.php");
    }

    /* Create pageing section */
    lapozas($max, 5, $oldal, "/forum/" . $tp);
}

function addtopic($name, $msg, $uid)//itt
{
    global $mysqli;

    $sql = sprintf("INSERT INTO topics (name, time, owner) VALUES ('%s', %d, %d)", $mysqli->real_escape_string($name), time(), $uid);
    if( !$eredmeny = $mysqli->query($sql))
        throw new Exception("SQL Insert error: " . $mysqli->error);
    $topic = $mysqli->insert_id;
    addmsg($msg, $topic, $uid);
}

function addmsg($msg, $tp, $uid)
{
    global $mysqli;

    $sql = sprintf("SELECT msg_no FROM msgs WHERE topic_id = '%d' ORDER BY time DESC LIMIT 1", $tp);
    $eredmeny = $mysqli->query($sql);
    $row = $eredmeny->fetch_row();
    $msg_no = $row[0] + 1;

    $sql = sprintf("INSERT INTO msgs (topic_id, user_id, msg, time, msg_no) VALUES ('%d', '%d', '%s', '%d', '%d')", $tp, $uid, $mysqli->real_escape_string($msg), time(), $msg_no);
    if( !$eredmeny = $mysqli->query($sql))
        throw new Exception("SQL Insert error: " . $mysqli->error);
}

function admin_msg($id, $msg, $uid)
{
    global $mysqli;
    if($uid)
    {
        $admin = get_uname_by_id($uid);
        $msg .= "\n\n[edit]Az &uuml;zenet szerkesztve " . $admin . " &aacute;ltal.  " . date("Y.m.d. H:i") . "[/edit]";
    }

    $sql = sprintf("UPDATE msgs SET msg='$msg' WHERE msg_id=%d", $id);
    $eredmeny = $mysqli->query($sql);
    if( !$eredmeny)
        throw new Exception("SQL Update error: " . $mysqli->error);
}

function mstorol($msgid)
{
    global $mysqli;

    $sql = sprintf("DELETE FROM msgs WHERE msg_id=%d", $msgid);
    if( !$eredmeny = $mysqli->query($sql))
        throw new Exception("SQL Delete error: " . $mysqli->error);
}

function readtopic($id)
{
    global $mysqli;

    $sql = sprintf("SELECT topic_id, name, time, owner FROM topics WHERE topic_id = %d", $id);
    if( !$eredmeny = $mysqli->query($sql))
        throw new Exception("SQL Select error: " . $mysqli->_error);
    $sor = $eredmeny->fetch_array();
    return $sor;
}

function edittopic($id, $nev)
{
    global $mysqli;

    $sql = sprintf("UPDATE topics SET name = '%s' WHERE topic_id = %d", $mysqli->real_escape_string($nev), $id);
    if( !$eredmeny = $mysqli->query($sql))
        throw new Exception("SQL Update error: " . $mysqli->error);
}

function deltopic($id)
{
    global $kapcsolat;

    $sql = sprintf("DELETE FROM msgs WHERE topic_id=%d", $id);
    if( !$eredmeny = $mysqli->query($sql))
        throw new Exception("SQL Delete error: " . $mysqli->error);

    $sql = sprintf("DELETE FROM topics WHERE topic_id=%d", $id);
    if( !$eredmeny = $mysqli->query($sql))
        throw new Exception("SQL Delete error: " . $mysqli->error);
}
?>
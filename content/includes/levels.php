<?php
/**
 * Starts the specified level.
 *
 * @param	$lvl: this variable specfies the level to start
 * @throws	Exception when SQL error happens
 * @return	1: when this level is already solved
 * 			0: when evrithong went ok
 */
function start_level($lvl)
{
    /* Use global database variable */
    global $mysqli;

    /* Checks if already started this level */
    $sql = sprintf("SELECT * FROM levelstat WHERE user_id='%d' AND level='%s' ", $_SESSION['id'], $mysqli->real_escape_string($lvl));
    if( !$eredmeny = $mysqli->query($sql))
        throw new Exception("SQL Count error:" . $mysqli->error);

    if($eredmeny->num_rows != 0)
    {
        $arr = $eredmeny->fetch_array();
        if($arr["finish"] != 0)
            return 1;
    }
    else
    {

        /* If not started this level already, register */
        $sql = sprintf("INSERT INTO levelstat (user_id, level, start) VALUES ('%d', '%s', '%d');", $_SESSION['id'], $mysqli->real_escape_string($lvl), time());
        $eredmeny;
        if( !$eredmeny = $mysqli->query($sql))
            throw new Exception("SQL Insert error: " . $mysqli->error);
    }
    /* Return if everithing went ok */
    return 0;
}

/**
 * Set the finish time of the specified level if not finished jet
 *
 * @param	$lvl: this variable specifies the current level to finish
 * @throws	Exception when SQL error happens
 * @return	None
 */
function finish_level($lvl)
{
    /* Use the global satabase variable */
    global $mysqli;

    /* Get the user record from database */
    $sql = sprintf("SELECT * FROM levelstat WHERE user_id='%d' AND level='%s'", $_SESSION['id'], $mysqli->real_escape_string($lvl));
    if( !$eredmeny = $mysqli->query($sql))
        throw new Exception("SQL Select error: " . $mysqli->error);

    /* If already finished do nothing and return */
    $arr = $eredmeny->fetch_array();
    if($arr["finish"] != 0)
        return;

    /* Set the finish time */
    $sql = sprintf("UPDATE levelstat SET finish='%d' WHERE user_id='%d' AND level='%s'", time(), $_SESSION['id'], $mysqli->real_escape_string($lvl));
    if( !$eredmeny = $mysqli->query($sql))
        throw new Exception("SQL Update error: " . $mysqli->error);
}

/**
 * This function write the level description on the HTML page
 *
 * @param	$lvl: this variable specifies the level to be written
 * @throws	Exception from rekord function
 * @return	None
 */
function print_feladat($lvl)
{
    $feladat = rekord("levels", "level", $lvl);
    echo bb_decode($feladat['descrip']);
}

/**
 * This function checks the specified files
 *
 * @param 	$fn1: this string specifies the path of the first file
 * @param	$fn2: this string specifies the path of the second file
 * @return	true if the files are equal, false otherwise
 */
function file_is_same($fn1, $fn2)
{
    /* Check for file sizes */
    if(filesize($fn1) != filesize($fn2))
        return false;

    /* Check for crc match */
    $f1 = crc32(file_get_contents($fn1));
    $f2 = crc32(file_get_contents($fn2));

    if($f1 != $f2)
        return false;

    /* Check for md5 match (paranoia) */
    $f1 = md5_file($fn1);
    $f2 = md5_file($fn2);

    if($f1 != $f2)
        return false;

    return true;
}
?>
<?php
	
	require("content/includes/func_forum.php");
	//check if logged in
	if(!auth())
		tovabb("/login");
	
	$msg = array();
	try
	{
		//check the params
		if(isset($PARAM) && is_numeric($PARAM)) // show the messages of the selected topic
		{
			$topic_id = $PARAM;
			
			if(isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) && $_REQUEST['page'] > 0)
				$page = $_REQUEST['page'];
			else
				$page = 1;
				
			if(isset($_POST['eset']) && $_POST['eset']=="Elküld")
			{
				if(!empty($_POST['msg']))
				{
					$msg = str_replace("\\'","'",$_POST['msg']);
					addmsg(htmlspecialchars($msg,ENT_COMPAT,"UTF-8"), $topic_id, $_SESSION['id']);
				}
				tovabb("/forum/$topic_id");
			}
			elseif(isset($_REQUEST['torol']) && isadmin())
			{
				mstorol($_REQUEST['torol']);
				tovabb("/forum/$topic_id?page=$page");
			}
			else
			{
				$topic = rekord("topics", "topic_id", $topic_id);
				if(empty($topic))
					tovabb("/forum");
			}
			
			//set header params
			$CSS = array();
			$CSS[] = "style/topic.css";
			$CSS[] = "style/topic_header.css";
			
			$SCRIPT = array();
			$SCRIPT[] = "/script/tag_insert.js";
			$SCRIPT[] = "/script/topic.js";
			
			$TITLE = "Fórum - {$topic['name']}";
			
			$CONTENT = "content/common/content_topic.php";
		}
		else //show topics
		{
			$CSS = array();
			$CSS[] = "style/forum.css";
			
			$SCRIPT = array();
			
			$TITLE = "Fórum";
			
			$CONTENT = "content/common/content_forum.php";
		}
	}
	catch(Exception $ex)
	{
		$msg[] = $ex->getMessage();
	}

require("content/common/site_header.php");
require("content/common/site_menu.php");

require($CONTENT);

require("content/common/site_footer.php");
?>
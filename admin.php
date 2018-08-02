<?php include('template_declare.php'); ?>
<?php

if ( ((isset($_POST['login_submitted'])) && ($_POST['username'] == ZIPSME_USERNAME) && (getEncryptedPassword($_POST['password']) == ZIPSME_PASSWORD_CRYPT)) || ((isset($_COOKIE['zipsme_admin'])) && ($_COOKIE['zipsme_admin'] == ZIPSME_PASSWORD_CRYPT)) ) {
	$logged_in = 'y';
	if ((isset($_GET['logout'])) && ($_GET['logout'] == 'y')) {
		setcookie("zipsme_admin", "", time() - (60*60*24*365), '/');
		$logged_in = 'n';
		redirect('admin.php?logout_complete=y');
	} else {
		setcookie("zipsme_admin", ZIPSME_PASSWORD_CRYPT, time() + (60*60*24*365), '/');		
	}
	
	if (isset($_POST['url_submitted'])) {
		$url = prepQueryText($_POST['url']);
		$url_name = prepQueryText($_POST['url_name']);
		$url_name = stripLink($url_name);
		$type = $_POST['type'];
		if (linkAvailable($url_name)) {
			insertLink($url_name, $url, $type);
			$alert = 'Link created successfully! <a target="_blank" href="' . SITE_URL . $url_name . '">' . SITE_URL . $url_name . '</a> now redirects to ' . $url;		
		} else {
			$alert = 'The link name ' . $url_name . ' is already being used.  Try a different name or edit the existing link';
		}
						  
	}
	
	if (isset($_POST['edit_submitted'])) {
		$url = prepQueryText($_POST['url']);
		$url_name = prepQueryText($_POST['url_name']);
		$type = $_POST['type'];
		updateLink($url_name, $url, $type);
		$alert = 'Update successful!';
	}
	
	if (isset($_GET['summary'])) { 
		$url_name = prepQueryText($_GET['summary']);
		$summary = new Stats($url_name);
		$view = 'stats';
	}
	
	if (isset($_GET['edit'])) { 
		$url_name = prepQueryText($_GET['edit']);
		$edit = new Info($url_name);
		$view = 'edit';
	}
	
	if (isset($_GET['delete'])) { 
		$url_name = prepQueryText($_GET['delete']);
		deleteLink($url_name);
		redirect('admin.php?delete_complete=' . $url_name);		
	}
	
	if (isset($_GET['delete_complete'])) {
		$url_name = prepQueryText($_GET['delete_complete']);
		$alert = $url_name . ' has been permanently deleted.';
	}
		
} else { 
	$logged_in = 'n';
	if (isset($_POST['login_submitted'])) {
		$alert = 'Incorrect username/password combination';
	} else if (isset($_GET['logout_complete'])) {	
		$alert = 'You\'ve been logged out successfully';
	}
}

?>
<?php include('template_header.php'); ?>
        <?php if (isset($alert)) { ?><p class="alert"><?php echo $alert; ?></p><?php } ?>
            <?php if ($logged_in == 'y') { ?>
            <div id="logout-link"><a href="admin.php">Admin Home</a> | <a href="admin.php?logout=y">Log Out</a></div>
            <?php if (isset($_GET['pre_delete'])) { ?>
            <p class="alert">Are you sure you want to delete the link <strong><?php echo SITE_URL; ?>/<?php echo prepOutputText($_GET['pre_delete']) ?></strong> ?  <a href="admin.php?delete=<?php echo prepOutputText($_GET['pre_delete']) ?>">Yes</a> | <a href="admin.php">No</a></p>
            <?php } ?>	
				<?php if ($view == 'stats') { ?>                                
                <h2>Statistics for <strong><?php echo $summary->url_name; ?></strong></h2>
					<?php if ($summary->total_clicks > 0) { ?>
                       <h3><?php echo $summary->total_clicks; ?> Total Clicks</h3>
                        <div id="click-summary" align="left">
                            <h3>By Month</h3>                    
                            <table>                	
                                <tr>
                                    <td><strong>Month</strong></td>
                                    <td><strong>Clicks</strong></td>
                                    <td><strong>%</strong></td>
                                </tr>
                                <?php $summary->showClicks(); ?>                                
                            </table>
                             <h3>Browsers</h3>
                            <table>                	
                                <tr>
                                    <td><strong>Browser</strong></td>
                                    <td><strong>Clicks</strong></td>
                                    <td><strong>%</strong></td>
                                </tr>
                                 <?php $summary->showBrowsers(); ?> 
                            </table>  
                            <h3>Referring Domains</h3>
                            <table>                	
                                <tr>
                                    <td><strong>Domain</strong></td>
                                    <td><strong>Clicks</strong></td>
                                    <td><strong>%</strong></td>
                                </tr>
                                <?php $summary->showDomains(); ?>                                                    
                            </table>
                            <h3>Referring Links</h3>
                            <table>                	
                                <tr>
                                    <td><strong>Referrer</strong></td>
                                    <td><strong>Clicks</strong></td>
                                    <td><strong>%</strong></td>
                                </tr>
                                <?php $summary->showReferrers(); ?>                                                    
                            </table>                           					                                                                     
                        </div>                                                     
                    <?php } else { ?>
                        <p>No clicks yet!</p>
                    <?php } ?>
                <?php } else if ($view == 'edit') { ?>
                 <h2>Edit <strong><?php echo $edit->url_name; ?></strong></h2>
                    <form action="admin.php" method="post" id="url-form">
                        <label>Original Link</label><input type="text" name="url" size="50" value="<?php echo $edit->url; ?>" /><br />                        
                        <label>Type</label><select name="type"><option <?php if ($edit->type == '301') { echo 'selected="selected"'; } ?> value="301">301 Permanent Redirect</option><option <?php if ($edit->type == '302') { echo 'selected="selected"'; } ?> value="302">302 Temporary Redirect</option></select><br />
                        <input type="hidden" value="1" name="edit_submitted"/>
                        <input type="hidden" value="<?php echo $edit->url_name; ?>" name="url_name"/>
                        <input type="submit" value="Update" id="form-button"/>
                    </form>
                <?php } else { ?>               	
                <h2>Shorten a New Link</h2>
                <form action="admin.php" method="post" id="url-form">
                    <label>Original Link</label><input type="text" name="url" size="50" /><br />
                    <label>New Link Name</label><input maxlength="255" type="text" name="url_name" /><br />
                    <label>Type</label><select name="type"><option selected="selected" value="301">301 Permanent Redirect</option><option value="302">302 Temporary Redirect</option></select><br />
                    <input type="hidden" value="1" name="url_submitted"/>
                    <input type="submit" value="Shorten It!" id="form-button"/>
            	</form>
                <h2>Link History</h2>
                <table>
                    <tr>
					    <td><strong>Link Name</strong></td>
                        <td><strong>Clicks</strong></td>
                        <td><strong>Options</strong></td>                        
					</tr>
                    <?php showLinkHistory(); ?>
                </table>
				<?php } ?>
			<?php } else { ?>
            <h2>Login</h2>
            <form action="admin.php" method="post" id="login-form">
            	<label>Username</label><input type="text" maxlength="100" name="username" /><br />
            	<label>Password</label><input type="password" maxlength="100" name="password" /><br />
                <input type="hidden" value="1" name="login_submitted"/>
                <input type="submit" value="Log In" id="form-button"/>
            </form>
			<?php } ?>
<?php include('template_footer.php'); ?>
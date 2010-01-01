<?php
include ("include/dbconnect.php");
include ("include/format.inc.php");

if($submit || $update) {
    $headers .=	'<meta HTTP-EQUIV="REFRESH" content="3;url=./email_type'.$page_ext.'">';
}
echo "<title>Email Types | Address Book</title>";
include ("include/header.inc.php");


        echo "<h1>".ucfmsg('EMAIL_TYPE')."</h1>";

        if($submit) {
            if(! $read_only) {
                $result = mysql_query("INSERT INTO " . $table_email_type . " (email_type) VALUES ('" . $email_type . "')");

                echo "<br /><div class='msgbox'>A new email type has been entered into the address book.<br /><i>return to the <a href='email_type" . $page_ext . "'>email type page</a></i></div>";
            } else
                echo "<br /><div class='msgbox'>Editing is disabled.<br /><i>return to the <a href='email_type" . $page_ext . "'>email type page</a></i></div>";
        }
// -- Add people to a email type
        else if($new) {
            if(! $read_only) {
                ?>
        <form accept-charset="utf-8" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
            <label>Email Type name:</label>
            <input type="text" name="email_type" size="35" /><br />

            <input type="submit" name="submit" value="Enter information" />
        </form>
                <?php
            } else
                echo "<br /><div class='msgbox'>Editing is disabled.</div>\n";
        } else if($delete) {
            // Remove the groups
            foreach($selected as $id) {
                // Delete links between addresses and groups
                $sql = "delete from " . $table_email . " where email_type_id = " . $id;
                $result = mysql_query($sql);

                // Delete groups
                $sql = "delete from " . $table_email_type . " where email_type_id = " . $id;
                $result = mysql_query($sql);
            }
            echo "<div class='msgbox'>Email Type has been removed.<br /><i>return to the <a href='email_type" . $page_ext . "'>email type page</a></i></div>";
        }
        else if($add) {
            // Lookup for the email_type_id
            $sql = "select * from " . $table_email_type . "where email_type = '" . $to_email_type . "'";

            $result = mysql_query($sql);
            // $resultsnumber = mysql_numrows($result);

            $myrow = mysql_fetch_array($result);
            $email_type_id = $myrow["email_type_id"];
            $email_type = $myrow["email_type"];
        }
// -- Remove people from a group
        else if($remove) {
            // Lookup for the email_type_id
            $sql = "select * from " . $table_email_type . " where email_type = '" . $email_type . "'";

            $result = mysql_query($sql);
            // $resultsnumber = mysql_numrows($result);

            $myrow = mysql_fetch_array($result);
            $email_type_id   = $myrow["email_type_id"];
            $email_type = $myrow["email_type"];
        }
        else if($update) {
            if(! $read_only) {
                $sql="SELECT * FROM $table_email_type WHERE email_type_id=$id";
                $result = mysql_query($sql);
                $resultsnumber = mysql_numrows($result);

                if($resultsnumber > 0) {
                    $sql = "UPDATE " . $table_email_type . " SET email_type='" . $email_type . "'
                                             WHERE email_type_id=" . $id;
                    $result = mysql_query($sql);

                    // header("Location: view?id=$id");

                    echo "<br /><div class='msgbox'>Email Type record has been updated.<br /><i>return to the <a href='email_type" . $page_ext . "'>email type page</a></i></div>";
                } else {
                    echo "<br /><div class='msgbox'>Invalid ID.<br /><i>return to the <a href='email_type" . $page_ext . "'>email type page</a></i></div>";
                }
            } else
                echo "<br /><div class='msgbox'>Editing is disabled.</div>";
        }
// Open for Editing
        else if($edit || $id) {
            if($edit) $id = $selected[0];
            if(! $read_only) {

                $result = mysql_query("SELECT * FROM " . $table_email_type . " WHERE email_type_id = " . $id,$db);
                $myrow = mysql_fetch_array($result);

                ?>
        <form accept-charset="utf-8" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
            <input type="hidden" name="id" value="<?php echo $myrow['email_type_id']?>" />

            <label><?php echo ucfmsg('EMAIL_TYPE'); ?></label>
            <input type="text" name="email_type" size="35" value="<?php echo $myrow['email_type']?>" /><br />

            <br /><br class="clear" />

            <input type="submit" name="update" value="<?php echo ucfmsg('UPDATE'); ?>" />
        </form>
        <br />
        <?php

    } else
        echo "<br /><div class='msgbox'>Editing is disabled.</div>\n";
}
else {

    $result = mysql_query("SELECT * FROM " . $table_email_type . " ORDER BY email_type");
            $resultsnumber = mysql_numrows($result);

            ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
            <input type="submit" name="new" value="<?php echo ucfmsg('NEW_EMAIL_TYPE'); ?>" />
        </form>
        <hr />
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">

            <?php
            while ($myrow = mysql_fetch_array($result)) {
                echo "<input type='checkbox' name='selected[]' value='".$myrow['email_type_id']."' title='Select (".$myrow['email_type'].")'/>";
        echo "&nbsp;".$myrow['email_type']."<br />";
    }
    ?>
            <br />
            <input type="submit" name="delete" value="<?php echo ucfmsg('DELETE_EMAIL_TYPE'); ?>" />
            <input type="submit" name="edit" value="<?php echo ucfmsg('EDIT_EMAIL_TYPE'); ?>" />
        </form>
                <?php
            }
            include ("include/footer.inc.php");
            ?>
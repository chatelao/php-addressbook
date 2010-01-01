<?php

include ("include/dbconnect.php");
include ("include/format.inc.php");

if($submit || $update) { ?>
	<meta HTTP-EQUIV="REFRESH" content="3;url=.">
<?php }

$resultsnumber = 0;
if ($id) {

   $sql = "SELECT * FROM $base_from_where AND $table.id='$id'";
   $result = mysql_query($sql, $db);
   $r = mysql_fetch_array($result);

   $resultsnumber = mysql_numrows($result);
}

	?>
	<script type="text/javascript">
        $(document).ready(function (){
                $('.primary').click(function(){ markPrimary(this); });
                $('.input').blur(function(){ enableRadioButton(this);});
                $('a.remove').click(function(){$(this).parent().remove()});
        });
    </script>
	<?php
if( ($resultsnumber == 0 && !isset($all)) || (!$id && !isset($all))) {
   ?><title>Address book <?php echo ($group_name != "" ? "($group_name)":""); ?></title><?php
   include ("include/header.inc.php");
} else {
   ?><title><?php echo $r["firstname"]." ".$r["lastname"]." ".($group_name != "" ? "($group_name)":"")."\n"; ?></title><?php
   if( !isset($_GET["print"]))
   {
     include ("include/header.inc.php");
   } else {
     echo '</head><body>';
     // echo '</head><body onload="javascript:window.setTimeout(window.print(self), 1000)";>';
   }
}
?>
 <h1><?php echo ucfmsg('EDIT_ADD_ENTRY'); ?></h1> 
<?php
if($submit){

if(! $read_only){
	//
	// Primitiv filter against spam on "sourceforge.net".
	//
	if($_SERVER['SERVER_NAME'] == "php-addressbook.sourceforge.net") {
		
	   $spam_test = $firstname.$lastname.$address.$home.$mobile.$work.$email.$email2.$bday.$bmonth.$byear.$address2.$phone2;
     $blacklist = array( 'viagra', 'seroquel', 'zovirax', 'ultram', 'mortage', 'loan'
                       , 'accutane', 'ativan', 'gun', 'sex', 'porn', 'arachidonic'
                       , 'recipe', 'comment1'
                       , 'naked', 'gay', 'fetish', 'domina', 'fakes', 'drugs'
                       , 'methylphenidate', 'nevirapine', 'viramune' );
     foreach( $blacklist as $blackitem ) {
	      if(strpos(strtolower($spam_test), $blackitem) !== FALSE ) {
	        exit;
	      }
	   }
	   if(   preg_match('/\D{3,}/', $home) > 0
	      || preg_match('/\D{3,}/', $mobile) > 0) {
	      	exit;
	   }
	   if(   strlen($home)   > 15 
	      || strlen($mobile) > 15) {
	      	exit;
	   }
	 }
	 
	$homepage = str_replace('http://', '', $homepage);
	// addition by rehan@itlinkonline.com
    $sql = "INSERT INTO $table (firstname,    lastname,   company,    homepage,   bday,  bmonth,   byear,    notes,     created, modified)
                VALUES ('$firstname','$lastname', '$company','$homepage','$bday','$bmonth','$byear', '$notes', now(),   now())";
	// end addition by rehan@itlinkonline.com
    $result = mysql_query($sql);

    // addition by rehan@itlinkonline.com
    $addressbook_id = mysql_insert_id($db);

    // phone
    for($i=0; $i< count($phone_number); $i++) {
        if($phone_type_id[$i] != '' && $phone_number[$i] != '') {
            $insertSql = 'INSERT INTO ' . $table_phone . ' (phone_type_id, addressbook_id, phone_number, primary_number)
                            VALUES ('. $phone_type_id[$i] .','. $addressbook_id .',\''. $phone_number[$i] .'\',' . $primary_number[$i] . ')';
            $result = mysql_query($insertSql, $db);
        }
    }
    // email
    for($i=0; $i< count($email_address); $i++) {
        if($email_type_id[$i] != '' && $email_address[$i] != '') {
            $insertSql = 'INSERT INTO ' . $table_email . ' (email_type_id, addressbook_id, email_address, primary_email)
                            VALUES ('. $email_type_id[$i] .','. $addressbook_id .',\''. $email_address[$i] .'\',' . $primary_email[$i] . ')';
            $result = mysql_query($insertSql, $db);
        }
    }
    // postal_address
    for($i=0; $i< count($postal_address); $i++) {
        if($address_type_id[$i] != '' && $postal_address[$i] != '') {
            $insertSql = 'INSERT INTO ' . $table_address . ' (address_type_id, addressbook_id, postal_address, primary_address)
                            VALUES ('. $address_type_id[$i] .','. $addressbook_id .',\''. $postal_address[$i] .'\',' . $primary_address[$i] . ')';
            $result = mysql_query($insertSql, $db);
        }
    }
    // end addition by rehan@itlinkonline.com
	 	 
	if(isset($table_groups) and $table_groups != "" ) {
		if( !$is_fix_group ) {
			$g_name = $new_group;
	  } else {
	  	$g_name = $group_name;
	  }
		$sql = "INSERT INTO $table_grp_adr SELECT LAST_INSERT_ID() id, group_id, now(), now() FROM $table_groups WHERE group_name = '$g_name'";
		$result = mysql_query($sql);
	
		echo "<br /><div class='msgbox'>Information entered into address book.";
		echo "<br /><i><a href='edit$page_ext'>add next</a> or return to <a href='index$page_ext'>home page</a>.</i></div>";
	}

} else
  echo "<br /><div class='msgbox'>Editing is disabled.</div>\n";

}
else if($update) {
  if(! $read_only) {
	$sql="SELECT * FROM $base_from_where AND $table.id='$id'";
	$result = mysql_query($sql);
	$resultsnumber = mysql_numrows($result);

	$homepage = str_replace('http://', '', $homepage);

	if($resultsnumber > 0)	{
		// addition by rehan@itlinkonline.com
                $sql = "UPDATE $table SET firstname='" . $firstname . "'
		                        , lastname='" . $lastname . "'
		                        , company='" . $company . "'
		                        , homepage='" . $homepage . "'
		                        , bday='" . $bday . "'
		                        , bmonth='" . $bmonth . "'
		                        , byear='" . $byear . "'
		                        , notes = '" . $notes . "'
		                        , modified = now()
		                      WHERE id='$id'";
                $result = mysql_query($sql);

                $addressbook_id = $id;

                // phone
                for($i=0; $i<count($phone_number); $i++) {
                    if($phone_remove_id[$i]!=0) {
                        $sql = 'DELETE FROM ' . $table_phone . ' WHERE phone_id = ' . $$phone_remove_id[$i];
                    }else if(isset($phone_id[$i])) {
                        $sql = 'UPDATE ' . $table_phone . ' SET phone_number = \'' . $phone_number[$i] . '\', phone_type_id = ' .$phone_type_id[$i] . ', primary_number = ' . $primary_number[$i]
                                . ' WHERE phone_id = ' . $phone_id[$i];
                    }else if($phone_type_id[$i] != '' && $phone_number[$i] != '') {
                        $sql = 'INSERT INTO ' . $table_phone . ' (phone_type_id, addressbook_id, phone_number, primary_phone)
                                        VALUES ('. $phone_type_id[$i] .',' . $addressbook_id . ',\'' . $phone_number[$i] . '\',' . $primary_number[$i] . ')';
                    }
                    $result = mysql_query($sql);
                }

                // email
                for($i=0; $i<count($email_address); $i++) {
                    if($email_remove_id[$i]!=0) {
                        $sql = 'DELETE FROM ' . $table_email . ' WHERE email_id = ' . $email_remove_id[$i];
                    }else if(isset($email_id[$i])) {
                        $sql = 'UPDATE ' . $table_email . ' SET email_address = \'' . $email_address[$i] . '\', email_type_id = ' .$email_type_id[$i] . ', primary_email = ' .$primary_email[$i]
                                . ' WHERE email_id = ' . $email_id[$i];
                    }else if($email_type_id[$i] != '' && $email_address[$i] != '') {
                        $sql = 'INSERT INTO ' . $table_email . ' (email_type_id, addressbook_id, email_address, primary_email)
                                        VALUES ('. $email_type_id[$i] .',' . $addressbook_id . ',\'' . $email_address[$i] . '\',' . $primary_email[$i] . ')';
                    }
                    $result = mysql_query($sql);
                }

                // postal_address
                for($i=0; $i<count($postal_address); $i++) {
                    if($address_remove_id[$i]!=0) {
                        $sql = 'DELETE FROM ' . $table_address . ' WHERE address_id = ' . $address_remove_id[$i];
                    }else if(isset($address_id[$i])) {
                        $sql = 'UPDATE ' . $table_address . ' SET postal_address = \'' . $postal_address[$i] . '\', address_type_id = ' .$address_type_id[$i] . ', primary_address = ' . $primary_address[$i]
                                . ' WHERE address_id = ' . $address_id[$i];
                    }else if($address_type_id[$i] != '' && $postal_address[$i] != '') {
                        $sql = 'INSERT INTO ' . $table_address . ' (address_type_id, addressbook_id, postal_address, primary_address)
                                        VALUES ('. $address_type_id[$i] .',' . $addressbook_id . ',\'' . $postal_address[$i] . '\',' . $primary_address[$i] . ')';
                    }
                    $result = mysql_query($sql);
                }
                // end addition by rehan@itlinkonline.com

		// header("Location: view?id=$id");		


		echo "<br /><div class='msgbox'>".ucfmsg('ADDRESS_BOOK')." ".msg('UPDATED')."<br /><i>return to <a href='index$page_ext'>home page</a></i></div>";
	} else {
		echo "<br /><div class='msgbox'>".ucfmsg('INVALID')." ID.<br /><i>return to <a href='index$page_ext'>home page</a></i></div>";
		echo "";  
	}
  } else
    echo "<br /><div class='msgbox'>Editing is disabled.</div>\n";
}
else if($id) {
  if(! $read_only) {
		$result = mysql_query("SELECT * FROM $base_from_where AND $table.id=$id",$db);
		$myrow = mysql_fetch_array($result);
		// addition by rehan@itlinkonline.com
        $phoneSql = 'SELECT * FROM ' . $table_phone . ' WHERE addressbook_id = ' . $id;
        $phones = mysql_query($phoneSql);

        $emailSql = 'SELECT * FROM ' . $table_email . ' WHERE addressbook_id = ' . $id;
        $emails = mysql_query($emailSql);

        $addressSql = 'SELECT * FROM ' . $table_address . ' WHERE addressbook_id = ' . $id;
        $postal_addresses = mysql_query($addressSql);
        // end addition by rehan@itlinkonline.com
?>
	<form accept-charset="utf-8" method="post" action="edit<?php echo $page_ext; ?>">

		<input type="hidden" name="id" value="<?php echo $myrow['id']?>" />
		<label><?php echo ucfmsg("FIRSTNAME") ?>:</label>
		<input type="text" name="firstname" size="35" value="<?php echo $myrow['firstname']?>" /><br />

		<label><?php echo ucfmsg("LASTNAME") ?>:</label>
		<input type="text" name="lastname" size="35" value="<?php echo $myrow['lastname']?>" /><br />

		<label><?php echo ucfmsg("COMPANY") ?>:</label>
		<input type="text" name="company" size="35" value="<?php echo $myrow['company']?>" /><br />

                <?php // addition by rehan@itlinkonline.com ?>
                <?php // postal_address ?>
        <br class="clear" />
        <label><?php echo ucfmsg("ADDRESS") ?>:</label><br class="clear" />
                <?php
                while($postal_address = mysql_fetch_array($postal_addresses)) {
                    ?>
        <div class="left">
            <label><select name="address_type_id[]"><?php outputOptions($table_address_type, 'address_type_id', 'address_type',$postal_address['address_type_id'],''); ?></select>:</label>
            <textarea class="left input" name="postal_address[]" rows="5" cols="35"><?php echo $postal_address['postal_address']?></textarea>
            <input type="hidden" name="address_id[]" value="<?php echo $postal_address['address_id']?>" />
            <label>
                <input type="hidden" name="primary_address[]" value="<?php echo $postal_address['primary_address']?>" />
                <input class="primary" name="primary_address_check" type="checkbox" <?php echo ($postal_address['primary_address']==1 ? 'checked="checked"' : '');?> />&nbsp;Primary&nbsp;
            </label>
            <br />
            <br />
            <br />
            <br />
            <label><input type="checkbox" name="address_remove_id[]" onclick="Toggle(this,'<?php echo $postal_address['address_id'];?>')" />&nbsp;Remove</label>
        </div>
        <br class="clear" />
                    <?php
                }
                ?>
        <div class="left" id="postal_address">
            <label><select name="address_type_id[]"><?php outputOptions($table_address_type, 'address_type_id', 'address_type','',''); ?></select>:</label>
            <textarea class="left input" name="postal_address[]" rows="5" cols="35"></textarea>
            <label>
                <input type="hidden" name="primary_address[]" value="0" />
                <input class="primary" type="checkbox" name="primary_address_check" disabled="disabled" />&nbsp;Primary&nbsp;
            </label>
            <a class="remove">Remove....</a>
        </div>
        <br class="clear" />
        <a class="label right duplicater" onclick="DuplicateBox('postal_address')">....Add Address</a>

        <br class="clear" />
        <label>&nbsp;</label><br class="clear" />
                <?php //phones ?>
        <label><?php echo ucfmsg("TELEPHONE") ?></label><br /><br class="clear" />
                <?php
                while($phone = mysql_fetch_array($phones)) {
                    ?>
        <div class="left">
            <label><select name="phone_type_id[]"><?php outputOptions($table_phone_type, 'phone_type_id', 'phone_type',$phone['phone_type_id'],''); ?></select>:</label>
            <input class="left input" type="text" name="phone_number[]" value="<?php echo $phone['phone_number']?>" />
            <input type="hidden" name="phone_id[]" value="<?php echo $phone['phone_id']?>" />
            <label>
                <input type="hidden" name="primary_number[]" value="<?php echo $phone['primary_number']?>" />
                <input class="primary" type="checkbox" name="primary_phone_check" <?php echo ($phone['primary_number']==1 ? 'checked="checked"' : '');?> />&nbsp;Primary&nbsp;
            </label>
            <label>&nbsp;<input type="checkbox" name="phone_remove_id[]" onclick="Toggle(this,'<?php echo $phone['phone_id'];?>')" /> Remove</label>
        </div>
        <br />
                    <?php
                }
                ?>
        <div class="left" id="phone">
            <label><select name="phone_type_id[]"><?php outputOptions($table_phone_type, 'phone_type_id', 'phone_type','',''); ?></select>:</label>
            <input class="input left" type="text" name="phone_number[]" />
            <label>
                <input type="hidden" name="primary_number[]" value="0" />
                <input class="primary" type="checkbox" name="primary_phone_check" />&nbsp;Primary&nbsp;
            </label>
            <a class="label remove">Remove....</a>
        </div>
        <br />
        <a class="label right duplicater" onclick="DuplicateBox('phone')">....Add Phone</a>

        <label>&nbsp;</label><br /><br class="clear" />

                <?php //email ?>
        <label><?php echo ucfmsg("EMAIL") ?>:</label><br /><br class="clear" />
                <?php
                while($email = mysql_fetch_array($emails)) {
                    ?>
        <div class="left">
            <label><select name="email_type_id[]"><?php outputOptions($table_email_type, 'email_type_id', 'email_type',$email['email_type_id'],''); ?></select>:</label>
            <input class="input left" type="text" name="email_address[]" value="<?php echo $email['email_address']?>" />
            <input type="hidden" name="email_id[]" value="<?php echo $email['email_id']?>" />
            <label>
                <input type="hidden" name="primary_email[]" value="<?php echo $email['primary_email']?>" />
                <input class="primary" name="primary_email_check" type="checkbox" <?php echo ($email['primary_email']==1 ? 'checked="checked"' : '');?> />&nbsp;Primary&nbsp;
            </label>
            <label>&nbsp;<input type="checkbox" name="email_remove_id[]" onclick="Toggle(this,'<?php echo $email['email_id'];?>')" /> Remove</label>
        </div>
        <br />
                    <?php
                }
                ?>
        <div class="left" id="email">
            <label><select name="email_type_id[]"><?php outputOptions($table_email_type, 'email_type_id', 'email_type','',''); ?></select>:</label>
            <input class="input left" type="text" name="email_address[]" />
            <label>
                <input type="hidden" name="primary_email[]" value="0" />
                <input class="primary" type="checkbox" name="primary_email_check" />&nbsp;Primary&nbsp;
            </label>
            <a class="label remove">Remove....</a>
        </div>
        <br />
        <a class="label right duplicater" onclick="DuplicateBox('email')">....Add Email</a>

        <label>&nbsp;</label><br /><br class="clear" />
                <?php
                // End addition by rehan@itlinkonline.com ?>

		<label><?php echo ucfmsg("HOMEPAGE") ?>:</label>
		<input type="text" name="homepage" size="35" value="<?php echo $myrow['homepage']?>" /><br />

		<label><?php echo ucfmsg("BIRTHDAY") ?>:</label>
        <select name="bday">
			<option value="<?php echo $myrow['bday']?>" selected="selected"><?php echo ($myrow["bday"] == 0?"-":$myrow["bday"]) ?></option>
          <option value="0">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>
          <option value="21">21</option>
          <option value="22">22</option>
          <option value="23">23</option>
          <option value="24">24</option>
          <option value="25">25</option>
          <option value="26">26</option>
          <option value="27">27</option>
          <option value="28">28</option>
          <option value="29">29</option>
          <option value="30">30</option>
          <option value="31">31</option>
        </select>
        <select name="bmonth">
          <option value="<?php echo $myrow['bmonth'] ?>" selected="selected"><?php echo ucfmsg(strtoupper($myrow["bmonth"])); ?></option>
          <option value="-">-</option>
          <option value="January"><?php echo ucfmsg("JANUARY") ?></option>
          <option value="February"><?php echo ucfmsg("FEBRUARY") ?></option>
          <option value="March"><?php echo ucfmsg("MARCH") ?></option>
          <option value="April"><?php echo ucfmsg("APRIL") ?></option>
          <option value="May"><?php echo ucfmsg("MAY") ?></option>
          <option value="June"><?php echo ucfmsg("JUNE") ?></option>
          <option value="July"><?php echo ucfmsg("JULY") ?></option>
          <option value="August"><?php echo ucfmsg("AUGUST") ?></option>
          <option value="September"><?php echo ucfmsg("SEPTEMBER") ?></option>
          <option value="October"><?php echo ucfmsg("OCTOBER") ?></option>
          <option value="November"><?php echo ucfmsg("NOVEMBER") ?></option>
          <option value="December"><?php echo ucfmsg("DECEMBER") ?></option>
        </select>
        <input type="text" name="byear" size="4" maxlength="4" value="<?php echo $myrow['byear']?>" /><br />

<?php
/* Group handling on change
      <label><?php echo ucfmsg("GROUP") ?>:</label>
				<?php      	
				if(isset($table_groups) and $table_groups != "" and !$is_fix_group) { ?>
				<select name="new_group">
				<?php
					if($group_name != "") 
					{
						echo "<option>$group_name</option>\n";
					}
					$sql = "SELECT group_name FROM $table_groups ORDER BY lower(group_name) ASC";
					$result_groups = mysql_query($sql);
					$result_gropup_snumber = mysql_numrows($result_groups);
					
					while ($myrow_group = mysql_fetch_array($result_groups))
					{
						echo "<option>".$myrow_group["group_name"]."</option>\n";
					}
				?>
				</select>
				<?php } ?>
			<br />
 */ ?>
		<br />

		<label><?php echo ucfmsg("NOTES") ?>:</label>
		<textarea name="notes" rows="5" cols="35"><?php echo $myrow["notes"]?></textarea><br /><br />

    	<input type="submit" name="update" value="<?php echo ucfmsg('UPDATE') ?>" />
  </form>
  <form method="get" action="delete<?php echo $page_ext; ?>">
		<input type="hidden" name="id" value="<?php echo $myrow['id']?>" />
		<input type="submit" name="update" value="<?php echo ucfmsg('DELETE') ?>" />
  </form>
<?php
	} else
		echo "<br /><div class='msgbox'>Editing is disabled.</div>";
	}
	else {
		if(! $read_only) {
?>
<script type="text/javascript">
<!--

last_proposal = "";

function proposeMail() {
	
	if(document.getElementById('email_address').value == last_proposal) {
	
    new_proposal = "";

	  has_firstname = document.theform.firstname.value != "";
	  has_lastname  = document.theform.lastname.value != "";
	
	  if(has_firstname) {
	    new_proposal = document.theform.firstname.value.toLowerCase();
	  }
	  if(has_firstname && has_lastname) {
      new_proposal += ".";
    }
    if(has_lastname) {
      new_proposal += document.theform.lastname.value.toLowerCase();    	
    }
    new_proposal += "@" + document.theform.company.value.toLowerCase().replace(" ", "-");

	  document.getElementById('email_address').value = new_proposal;
	  last_proposal = new_proposal;

	}
}

function ucfirst(str) {
  return str.slice(0,1).toUpperCase() + str.slice(1);
}
function ucf_arr(str_arr) {
  str_res = Array();
  for (var i = 0; i < str_arr.length; i++) {
    str_res[i] = ucfirst(str_arr[i]);
  }
  return str_res;
}

function trim(str, chars) {
	no_left = str.replace(new RegExp("^[" + chars + "]+", "g"), "");
	return no_left.replace(new RegExp("[" + chars + "]+$", "g"), "");
}

function proposeNames() {
 
  document.theform.email.value = trim(document.theform.email.value, " \t");
  who_from =  document.theform.email.value.split("@", 2);

  if(who_from.length >= 2) {

	  who  = who_from[0].split(/[\._]+/,2);
	  if(who.length == 1)  {
	    who  = who_from[0].split("_",2);
	  }
	  if(document.theform.firstname.value == "") {
	    document.theform.firstname.value = ucf_arr(who[0].split("-")).join("-");
	  }
	  if(who.length > 1 && document.theform.lastname.value == "") {
	    document.theform.lastname.value = ucf_arr(who[1].split("-")).join("-");
	  }
  }
}

-->
</script>

  <form accept-charset="utf-8" method="post" action="edit<?php echo $page_ext; ?>" name="theform">

		<input type="hidden" name="id" value="<?php echo $myrow['id']?>" />
		<label><?php echo ucfmsg("FIRSTNAME") ?>:</label>
		<input type="text" name="firstname" size="35" onkeyup="proposeMail()"/><br class="clear" />

		<label><?php echo ucfmsg("LASTNAME") ?>:</label>
		<input type="text" name="lastname" size="35" onkeyup="proposeMail()"/><br class="clear" />

		<label><?php echo ucfmsg("COMPANY") ?>:</label>
		<input type="text" name="company" size="35" onkeyup="proposeMail()"/><br class="clear" />

                <?php // addition by rehan@itlinkonline.com ?>

                <?php // address ?>
        <br />
        <label><?php echo ucfmsg("ADDRESS") ?>:</label><br class="clear" />

        <div id="postal_address" class="left" style="display:block;">
            <label><select name="address_type_id[]"><?php outputOptions($table_address_type, 'address_type_id', 'address_type','',''); ?></select>:</label>
            <textarea class="input left" name="postal_address[]" rows="5" cols="35"></textarea>
            <label><input class="primary" type="checkbox" name="primary_address[]" disabled="disabled" value="0" />&nbsp;Primary&nbsp;</label>
            <a class="remove">Remove....</a>
        </div>
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <a class="label right duplicater" onclick="DuplicateBox('postal_address')">....Add Address</a>
        <br class="clear" />

                <?php // phone ?>
        <br />
        <label><?php echo ucfmsg("TELEPHONE") ?></label><br class="clear" />
        <div class="left" id="phone" style="display:block;">
            <label><select name="phone_type_id[]"><?php outputOptions($table_phone_type, 'phone_type_id', 'phone_type','',''); ?></select>:</label>
            <input class="input left" type="text" name="phone_number[]" />
            <label><input class="primary" type="checkbox" name="primary_number[]" disabled="disabled" value="0" />&nbsp;Primary&nbsp;</label>
            <a class="label remove">Remove....</a>
        </div>
        <br />
        <a class="label right duplicater" onclick="DuplicateBox('phone')">....Add Phone</a>
        <br class="clear" />

                <?php // email ?>
        <br />
        <label><?php echo ucfmsg("EMAIL") ?>:</label><br class="clear" />
        <div class="left" id="email" style="display:block;">
            <label><select name="email_type_id[]"><?php outputOptions($table_email_type, 'email_type_id', 'email_type','',''); ?></select>:</label>
            <input class="input left" type="text" id="email_address" name="email_address[]" />
            <label><input class="primary" type="checkbox" name="primary_email[]" disabled="disabled" value="0" />&nbsp;Primary&nbsp;</label>
            <a class="label remove">Remove....</a>
        </div>
        <br />
        <a class="label right duplicater" onclick="DuplicateBox('email')">....Add Email</a>
        <br class="clear" />
                <?php // End addition by rehan@itlinkonline.com ?>

        <br />
        <label><?php echo ucfmsg("HOMEPAGE") ?>:</label>
        <input type="text" name="homepage" size="35" /><br class="clear" />

		<label><?php echo ucfmsg("BIRTHDAY") ?>:</label>
        <select name="bday">
          <option value="0" selected="selected">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>
          <option value="21">21</option>
          <option value="22">22</option>
          <option value="23">23</option>
          <option value="24">24</option>
          <option value="25">25</option>
          <option value="26">26</option>
          <option value="27">27</option>
          <option value="28">28</option>
          <option value="29">29</option>
          <option value="30">30</option>
          <option value="31">31</option>
        </select>
        <select name="bmonth">
          <option value="-" selected="selected">-</option>
          <option value="January"><?php echo ucfmsg("JANUARY") ?></option>
          <option value="February"><?php echo ucfmsg("FEBRUARY") ?></option>
          <option value="March"><?php echo ucfmsg("MARCH") ?></option>
          <option value="April"><?php echo ucfmsg("APRIL") ?></option>
          <option value="May"><?php echo ucfmsg("MAY") ?></option>
          <option value="June"><?php echo ucfmsg("JUNE") ?></option>
          <option value="July"><?php echo ucfmsg("JULY") ?></option>
          <option value="August"><?php echo ucfmsg("AUGUST") ?></option>
          <option value="September"><?php echo ucfmsg("SEPTEMBER") ?></option>
          <option value="October"><?php echo ucfmsg("OCTOBER") ?></option>
          <option value="November"><?php echo ucfmsg("NOVEMBER") ?></option>
          <option value="December"><?php echo ucfmsg("DECEMBER") ?></option>
        </select>
        <input type="text" name="byear" size="4" maxlength="4" /><br class="clear" />

		<?php      	
    if(isset($table_groups) and $table_groups != "" and !$is_fix_group) { ?>

	<label><?php echo ucfmsg("GROUP") ?>:</label>
				<select name="new_group">
				<?php
					if($group_name != "") {
						echo "<option>$group_name</option>\n";
					} ?>
          <option value="[none]">[<?php echo msg("NONE"); ?>]</option>
          <?php outputOptions($table_groups, 'group_name', 'group_name', '', '');?>
        </select>
        <br />
		<?php } ?>
		
		<br />
		<label><?php echo ucfmsg("NOTES") ?>:</label>
		<textarea name="notes" rows="5" cols="35"></textarea><br /><br />

		<input type="submit" name="submit" value="<?php echo ucfmsg('ENTER') ?>" />
  </form>
<?php
  } else
    echo "<br /><div class='msgbox'>Editing is disabled.</div>";
}

include ("include/footer.inc.php"); ?>
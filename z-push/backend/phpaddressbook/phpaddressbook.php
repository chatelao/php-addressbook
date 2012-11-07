<?php
/***********************************************
* File      :   php-addressbook.php
* Project   :   Z-Push
* Descr     :   A backend is for the PHP-Addressbook:
*               http://php-addressbook.sourceforge.net
*
* Created   :   16.07.2010
* Updated   :   10.03.2012
* chatelao/ät/users.sourceforge.net
*
* Consult LICENSE file for details
************************************************/
include_once('lib/default/diffbackend/diffbackend.php');
ini_set("memory_limit", "128M");

//
// FROM: export.vcard.php
//

function label2adr($address) {
   	
   	  preg_match_all('/(^|[^\d])(\d{4,6})([^\d]|$)/', $address, $zips);
   	  preg_match_all('/(^|[^\d])(\d{1,3})([^\d]|$)/', $address, $street_nrs);
      
      $address = str_replace("\r", "", $address);
      $addr_lines = explode("\n", $address);
      $cnt_lines  = count($addr_lines);
      
      // 
      // Find the city:
      //  a) On the line of the zip.
      //  b) On the last line if more than 2 letters
      //  c) ...
      //
      $zip  = "";
      $city = "";
      if(count($zips[0]) > 0) {
      	$zip = $zips[2][0];
      	for($i = 0; $i < $cnt_lines; $i++) {
        	if(FALSE !== strpos($addr_lines[$i], $zip)) {
        		$city_line = $i;
        		$city = trim(str_replace($zip, "", $addr_lines[$i]), ", ");
        	}
      	}
      } else {
      	if($cnt_lines >= 2) {
          $city_line = $cnt_lines-1;
     			$city = $addr_lines[$city_line];
      		if(strlen($city) <= 2) {
            $city_line = $cnt_lines-2;
      			$city = $addr_lines[$city_line];
      		}
      	} elseif($cnt_lines == 1) {
          $city_line = 0;
      		$city = $addr_lines[$city_line];
      	}
      }
      
      //--------------------------------------------------------
      // Find the name of the street:
      //
      $addr      = "";
      $street    = "";
      $street_nr = "";
      if(count($street_nrs[2]) > 0) {
      	$street_nr = $street_nrs[2][0];
        for($i = 0; $i < $cnt_lines; $i++) {
        	preg_match_all('/(^|[^\d])'.$street_nr.'([^\d]|$)/', $addr_lines[$i], $matches);
        	if(count($matches[0]) > 0) {
        		$addr_line = $i;
      	    $addr = $addr_lines[$addr_line];
        		$street = trim(str_replace($street_nr, "", $addr_lines[$i]), ", ");
        	}
        }        
      } elseif(isset($city_line) && $city_line >= 1) {
       		$addr_line = $city_line-1;
      	  $addr = $addr_lines[$addr_line];
          $street = $addr;
      }

      //--------------------------------------------------------
      // Find the extension:
      //
      $exta = "";
      if(isset($addr_line) && $addr_line >= 1) {
      	  $exta = $addr_lines[$addr_line-1];
      }

      //--------------------------------------------------------
      // Find the name of the country:
      //
      $country = "";
      if(isset($city_line) && $city_line < $cnt_lines-1) {
      	  $country = $addr_lines[$city_line+1];
      }

      $addr_struc['pbox']      = "";         // post office box
      $addr_struc['exta']      = $exta;      // the extended address; the street   
      $addr_struc['street']    = $street;
      $addr_struc['street_nr'] = $street_nr;
      $addr_struc['addr']      = $addr;      // address
      $addr_struc['city']      = $city;      // the locality (e.g., city)
      $addr_struc['region']    = "";         // the region (e.g., state or province)
      $addr_struc['zip']       = $zip;       // the postal code
      $addr_struc['country']   = $country;   // the country name
   	     	     	  
   	  return $addr_struc;
   	
}

//
// END: export.vcard.php
//

//
// FROM: dbconnect.php
//
class PhpAddr {

  public function connect() {

  	 global $dbserver, $dbuser, $dbpass, $dbname, $db;

     ZLog::Write(LOGLEVEL_DEBUG, 'PhpAddr::connect()'.$dbserver.' - '.$dbuser.' - '.$dbname);
     
     // --- Connect to DB, retry 5 times ---
     for ($i = 0; $i < 5; $i++) {

         $db = mysql_connect("$dbserver", "$dbuser", "$dbpass");
         $errno = mysql_errno();
         if ($errno == 1040 || $errno == 1226 || $errno == 1203) {
             sleep(1);
         }  else {
             break;
         }
     }
     mysql_select_db("$dbname", $db);
     mysql_query('set character set utf8;');
     mysql_query("SET NAMES `utf8`");
     
     return $db;

  }

  public function disconnect() {

  	global $db;

    if(mysql_ping($db)) {
     mysql_close($db);
    }
    return true;
  }
}

include_once("login.inc.php");
include_once("address.class.php");

//
// END: address.class.php
//

class BackendPhpaddressbook extends BackendDiff {
    /**----------------------------------------------------------------------------------------------------------
     * default backend methods
     */

    var $_user;
    var $_login;
    var $_phpaddr;

    /**
     * Authenticates the user
     *
     * @param string        $username
     * @param string        $domain
     * @param string        $password
     *
     * @access public
     * @return boolean
     */
    public function Logon($username, $domain, $password) {

    	  global $db, $usertable, $userlist,$base_where, $base_from, $base_from_where,$table,$domain_id;

     ZLog::Write(LOGLEVEL_DEBUG, 'PhpAddr::Logon()'.$username);

    	  
        $_POST['user']  = $username;
        $_POST['pass']  = $password;
        $_COOKIE['uin'] = "";

        $this->_user = $username;

        $this->_phpaddr = new PhpAddr();
        $db = $this->_phpaddr->connect();

//1  $userlist['admin']['pass']   = "nimda";
//1  $userlist['admin']['role']   = "root";

    	  $this->_login = AuthLoginFactory::getBestLogin();

        if($this->_login->hasRoles()) {
          $domain_id = $this->_login->getUser()->getDomain();
          $base_where = "$table.domain_id = $domain_id ";
          $base_where .= "AND $table.deprecated is null ";
          $base_from_where  = "$base_from WHERE $base_where ";

          return true;
        } else {
        	return false;
        }
    }

    /**
     * Logs off
     *
     * @access public
     * @return boolean
     */
    public function Logoff() {
       return $this->_phpaddr->disconnect();
    }

    /**
     * Sends an e-mail
     * Not implemented here
     *
     * @param SyncSendMail  $sm     SyncSendMail object
     *
     * @access public
     * @return boolean
     * @throws StatusException
     */
    public function SendMail($sm) {
        return false;
    }

    /**
     * Returns the waste basket
     *
     * @access public
     * @return string
     */
    public function GetWasteBasket() {
        return false;
    }

    /**
     * Returns the content of the named attachment as stream
     * not implemented
     *
     * @param string        $attname
     *
     * @access public
     * @return SyncItemOperationsAttachment
     * @throws StatusException
     */
    public function GetAttachmentData($attname) {
        return false;
    }

    /**----------------------------------------------------------------------------------------------------------
     * implemented DiffBackend methods
     */

    /**
     * Returns a list (array) of folders.
     * In simple implementations like this one, probably just one folder is returned.
     *
     * @access public
     * @return array
     */
    public function GetFolderList() {
        ZLog::Write(LOGLEVEL_DEBUG, 'PhpAddr::GetFolderList()');
        $contacts = array();
        $folder = $this->StatFolder("root");
        $contacts[] = $folder;

        return $contacts;
    }

    /**
     * Returns an actual SyncFolder object
     *
     * @param string        $id           id of the folder
     *
     * @access public
     * @return object       SyncFolder with information
     */
    public function GetFolder($id) {
        ZLog::Write(LOGLEVEL_DEBUG, 'PhpAddr::GetFolder('.$id.')');
        if($id == "root") {
            $folder = new SyncFolder();
            $folder->serverid = $id;
            $folder->parentid = "0";
            $folder->displayname = "Contacts";
            $folder->type = SYNC_FOLDER_TYPE_CONTACT;

            return $folder;
        } else return false;
    }

    /**
     * Returns folder stats. An associative array with properties is expected.
     *
     * @param string        $id             id of the folder
     *
     * @access public
     * @return array
     */
    public function StatFolder($id) {
        ZLog::Write(LOGLEVEL_DEBUG, 'PhpAddr::StatFolder('.$id.')');
        $folder = $this->GetFolder($id);

        $stat = array();
        $stat["id"] = $id;
        $stat["parent"] = $folder->parentid;
        $stat["mod"] = $folder->displayname;

        return $stat;
    }

    /**
     * Creates or modifies a folder
     * not implemented
     *
     * @param string        $folderid       id of the parent folder
     * @param string        $oldid          if empty -> new folder created, else folder is to be renamed
     * @param string        $displayname    new folder name (to be created, or to be renamed to)
     * @param int           $type           folder type
     *
     * @access public
     * @return boolean                      status
     * @throws StatusException              could throw specific SYNC_FSSTATUS_* exceptions
     *
     */
    public function ChangeFolder($folderid, $oldid, $displayname, $type){
        return false;
    }

    /**
     * Deletes a folder
     *
     * @param string        $id
     * @param string        $parent         is normally false
     *
     * @access public
     * @return boolean                      status - false if e.g. does not exist
     * @throws StatusException              could throw specific SYNC_FSSTATUS_* exceptions
     *
     */
    public function DeleteFolder($id, $parentid){
        return false;
    }

    /**
     * Returns a list (array) of messages
     *
     * @param string        $folderid       id of the parent folder
     * @param long          $cutoffdate     timestamp in the past from which on messages should be returned
     *
     * @access public
     * @return array/false  array with messages or false if folder is not available
     */
    public function GetMessageList($folderid, $cutoffdate) {

    	global $db, $base_from_where;

        debugLog('PhpAddr::GetMessageList('.$folderid.')');
        $messages = array();

        $sql = "SELECT id, modified FROM $base_from_where";

        $result = mysql_query($sql);
        while($rec = mysql_fetch_array($result)) {
            $message = array();
            $message["id"]  = $rec['id'];
            $message["mod"] = $rec["modified"];
            $message["flags"] = 1; // always 'read'

            $messages[] = $message;
        }

        debugLog('PhpAddr::GetMessageList('.$folderid.', found: '.count($messages).' items)');

        return $messages;
    }

    /**
     * Returns the actual SyncXXX object type.
     *
     * @param string            $folderid           id of the parent folder
     * @param string            $id                 id of the message
     * @param ContentParameters $contentparameters  parameters of the requested message (truncation, mimesupport etc)
     *
     * @access public
     * @return object/false     false if the message could not be retrieved
     */
    public function GetMessage($folderid, $id, $contentparameters) {

        global $db, $base_from_where, $domain_id;

        ZLog::Write(LOGLEVEL_DEBUG, 'PhpAddr::GetMessage('.$folderid.', '.$id.', ..)');
        if($folderid != "root")
            return false;

        $types = array ('dom' => 'type', 'intl' => 'type', 'postal' => 'type', 'parcel' => 'type', 'home' => 'type', 'work' => 'type',
            'pref' => 'type', 'voice' => 'type', 'fax' => 'type', 'msg' => 'type', 'cell' => 'type', 'pager' => 'type',
            'bbs' => 'type', 'modem' => 'type', 'car' => 'type', 'isdn' => 'type', 'video' => 'type',
            'aol' => 'type', 'applelink' => 'type', 'attmail' => 'type', 'cis' => 'type', 'eworld' => 'type',
            'internet' => 'type', 'ibmmail' => 'type', 'mcimail' => 'type',
            'powershare' => 'type', 'prodigy' => 'type', 'tlx' => 'type', 'x400' => 'type',
            'gif' => 'type', 'cgm' => 'type', 'wmf' => 'type', 'bmp' => 'type', 'met' => 'type', 'pmb' => 'type', 'dib' => 'type',
            'pict' => 'type', 'tiff' => 'type', 'pdf' => 'type', 'ps' => 'type', 'jpeg' => 'type', 'qtime' => 'type',
            'mpeg' => 'type', 'mpeg2' => 'type', 'avi' => 'type',
            'wave' => 'type', 'aiff' => 'type', 'pcm' => 'type',
            'x509' => 'type', 'pgp' => 'type', 'text' => 'value', 'inline' => 'value', 'url' => 'value', 'cid' => 'value', 'content-id' => 'value',
            '7bit' => 'encoding', '8bit' => 'encoding', 'quoted-printable' => 'encoding', 'base64' => 'encoding',
        );


        $message = new SyncContact();

        $sql = "SELECT * FROM $base_from_where AND id = ".intval($id);
        $result = mysql_query($sql);
        $addr = mysql_fetch_array($result);

        if(isset($addr['email']))
            $message->email1address = $addr['email'];
        if(isset($addr['email2']))
            $message->email2address = $addr['email2'];
        if(isset($addr['email3']))
            $message->email3address = $addr['email3'];

        if(isset($addr['address']) && trim($addr['address']) != "") {
            $addr_parts = label2adr($addr['address']);
            $message->homestreet     = $addr_parts['street']." ".$addr_parts['street_nr'];
            $message->homecity       = $addr_parts['city'];
            $message->homepostalcode = $addr_parts['zip'];
            // $message->homestate  = ?;
            $message->homecountry = $addr_parts['country'];
            }

        if(isset($addr['address2']) && trim($addr['address2']) != "") {
            $addr_parts = label2adr($addr['address2']);
            $message->businessstreet     = $addr_parts['street']." ".$addr_parts['street_nr'];
            $message->businesscity       = $addr_parts['city'];
            $message->businesspostalcode = $addr_parts['zip'];
            // $message->businessstate  = ?;
            $message->businesscountry = $addr_parts['country'];
        }
/*
        if(isset($vcard['tel'])){
            foreach($vcard['tel'] as $tel) {
                if(!isset($tel['type'])){
                    $tel['type'] = array();
                }
                if(in_array('car', $tel['type'])){
                    $message->carphonenumber = $tel['val'][0];
                }elseif(in_array('pager', $tel['type'])){
                    $message->pagernumber = $tel['val'][0];
                }elseif(in_array('cell', $tel['type'])){
                    $message->mobilephonenumber = $tel['val'][0];
                }elseif(in_array('home', $tel['type'])){
                    if(in_array('fax', $tel['type'])){
                        $message->homefaxnumber = $tel['val'][0];
                    }elseif(empty($message->homephonenumber)){
                        $message->homephonenumber = $tel['val'][0];
                    }else{
                        $message->home2phonenumber = $tel['val'][0];
                    }
                }elseif(in_array('work', $tel['type'])){
                    if(in_array('fax', $tel['type'])){
                        $message->businessfaxnumber = $tel['val'][0];
                    }elseif(empty($message->businessphonenumber)){
                        $message->businessphonenumber = $tel['val'][0];
                    }else{
                        $message->business2phonenumber = $tel['val'][0];
                    }
                }elseif(empty($message->homephonenumber)){
                    $message->homephonenumber = $tel['val'][0];
                }elseif(empty($message->home2phonenumber)){
                    $message->home2phonenumber = $tel['val'][0];
                }else{
                    $message->radiophonenumber = $tel['val'][0];
                }
            }
        }
        //;;street;city;state;postalcode;country
        if(isset($vcard['adr'])){
            foreach($vcard['adr'] as $adr) {
                if(empty($adr['type'])){
                    $a = 'other';
                }elseif(in_array('home', $adr['type'])){
                    $a = 'home';
                }elseif(in_array('work', $adr['type'])){
                    $a = 'business';
                }else{
                    $a = 'other';
                }
                if(!empty($adr['val'][2])){
                    $b=$a.'street';
                    $message->$b = w2ui($adr['val'][2]);
                }
                if(!empty($adr['val'][3])){
                    $b=$a.'city';
                    $message->$b = w2ui($adr['val'][3]);
                }
                if(!empty($adr['val'][4])){
                    $b=$a.'state';
                    $message->$b = w2ui($adr['val'][4]);
                }
                if(!empty($adr['val'][5])){
                    $b=$a.'postalcode';
                    $message->$b = w2ui($adr['val'][5]);
                }
                if(!empty($adr['val'][6])){
                    $b=$a.'country';
                    $message->$b = w2ui($adr['val'][6]);
                }
            }
        }
        */
        $message->fileas    = ( $addr['firstname']." ".$addr['lastname'] != ""
                              ? $addr['firstname']." ".$addr['lastname'] != ""
                              : $addr['company']);
                              
        $message->lastname    = $addr['lastname'];
        $message->firstname   = $addr['firstname'];
        $message->nickname    = $addr['nickname'];
        $message->jobtitle    = $addr['title'];
        $message->companyname = $addr['company'];

        $message->homephonenumber     = $addr['home'];
        $message->mobilephonenumber   = $addr['mobile'];
        $message->businessphonenumber = $addr['work'];
        $message->businessfaxnumber   = $addr['fax'];
        
        $message->home2phonenumber    = $addr['phone2'];

        $message->body = $addr['notes'];

        $message->picture = $addr['photo'];
        
        if(   isset($addr['bday'])   && $addr['bday']   != ""
           && isset($addr['bmonth']) && $addr['bmonth'] != ""
           && isset($addr['byear'])  && $addr['byear']  != ""
          )
        {
            $message->birthday = strtotime($addr['bday']." ".$addr['bmonth']." ".$addr['byear']);
        }

        if(   isset($addr['aday'])   && $addr['aday']   != ""
           && isset($addr['amonth']) && $addr['amonth'] != ""
           && isset($addr['ayear'])  && $addr['ayear']  != ""
          )
        {
            $message->anniversary = strtotime($addr['aday']." ".$addr['amonth']." ".$addr['ayear']);
        }
        // $message->birthday = strtotime($vcard['bday'][0]['val'][0]);
/*
        if(!empty($vcard['n'][0]['val'][2]))
            $message->middlename = w2ui($vcard['n'][0]['val'][2]);
        if(!empty($vcard['n'][0]['val'][3]))
            $message->title = w2ui($vcard['n'][0]['val'][3]);
        if(!empty($vcard['n'][0]['val'][4]))
            $message->suffix = w2ui($vcard['n'][0]['val'][4]);
        if(!empty($vcard['bday'][0]['val'][0])){
            $tz = date_default_timezone_get();
            date_default_timezone_set('UTC');
            $message->birthday = strtotime($vcard['bday'][0]['val'][0]);
            date_default_timezone_set($tz);
        }
        if(!empty($vcard['org'][0]['val'][0]))
            $message->companyname = w2ui($vcard['org'][0]['val'][0]);
        if(!empty($vcard['note'][0]['val'][0])){
            $message->body = w2ui($vcard['note'][0]['val'][0]);
            $message->bodysize = strlen($vcard['note'][0]['val'][0]);
            $message->bodytruncated = 0;
        }
        if(!empty($vcard['role'][0]['val'][0]))
            $message->jobtitle = w2ui($vcard['role'][0]['val'][0]);//$vcard['title'][0]['val'][0]
        if(!empty($vcard['url'][0]['val'][0]))
            $message->webpage = w2ui($vcard['url'][0]['val'][0]);
        if(!empty($vcard['categories'][0]['val']))
            $message->categories = $vcard['categories'][0]['val'];

        if(!empty($vcard['photo'][0]['val'][0]))
            $message->picture = base64_encode($vcard['photo'][0]['val'][0]);
*/
        return $message;
    }

    /**
     * Returns message stats, analogous to the folder stats from StatFolder().
     *
     * @param string        $folderid       id of the folder
     * @param string        $id             id of the message
     *
     * @access public
     * @return array
     */
    public function StatMessage($folderid, $id) {

    	  global $db, $base_from_where;

        ZLog::Write(LOGLEVEL_DEBUG, 'PhpAddr::StatMessage('.$folderid.', '.$id.')');
        if($folderid != "root")
            return false;

        $sql = "SELECT id, modified FROM $base_from_where AND id = ".intval($id);

//2        $this->_phpaddr->connect();
        $result = mysql_query($sql);
        $rec = mysql_fetch_array($result);
//2        $this->_phpaddr->disconnect();

        $message = array();
        $message["id"]  = $rec['id'];
        $message["mod"] = $rec["modified"];
        $message["flags"] = 1; // always 'read'

        return $message;
    }

    function _getOneToOneMapping() {
    	
    	$mapping = array();
    	
    	//
    	// $mapping[ActiveSyncKey] = PhpAddrKey (if not the same);
    	//
      $mapping['lastname']            = "";
      $mapping['firstname']           = "";
      $mapping['companyname']         = "company";
      
      $mapping['homephonenumber']     = "home";
      $mapping['home2phonenumber']    = "phone2";
      $mapping['mobilephonenumber']   = "mobile";
      $mapping['businessphonenumber'] = "work";
      $mapping['businessfaxnumber']   = "fax";

      $mapping['email1address']       = "email";
      $mapping['email2address']       = "email2";
      $mapping['email3address']       = "email3";

      $mapping['webpage']             = "homepage";

      $mapping['body']                = "notes";

    	return $mapping;
    }

    /**
     * Called when a message has been changed on the mobile.
     * This functionality is not available for emails.
     *
     * @param string        $folderid       id of the folder
     * @param string        $id             id of the message
     * @param SyncXXX       $message        the SyncObject containing a message
     *
     * @access public
     * @return array                        same return value as StatMessage()
     * @throws StatusException              could throw specific SYNC_STATUS_* exceptions
     */
    public function ChangeMessage($folderid, $id, $message) {
        ZLog::Write(LOGLEVEL_DEBUG, 'PhpAddr::ChangeMessage('.$folderid.', '.$id.', ..)');

        debugLog('PhpAddr::ChangeMessage(FolderID: '.$folderid.', ID: '.$id.', ..)'.json_encode($message));

        global $keep_history, $domain_id;


        $addr['firstname']  = ( $message->title != ""
                              ? $message->title." "
                              : "");
        $addr['firstname'] .= $message->firstname.
                              ( $message->middlename != ""
                              ? " ".$message->middlename : "");

        $addr['firstname'] .= ( $message->suffix != ""
                              ? " ".$message->suffix : "");

        $addr['lastname']  = $message->lastname;
        $addr['nickname']  = $message->nickname;
        $addr['company']   = $message->companyname;
        $addr['title']     = $message->jobtitle;
        // 'jobtitle' => 'ROLE',

        //   ';;homestreet;homecity;homestate;homepostalcode;homecountry' => 'ADR;HOME',

        $addr['home']   = $message->homephonenumber;
        $addr['mobile'] = $message->mobilephonenumber;
        $addr['work']   = $message->businessphonenumber;
        $addr['fax']    = ( $message->businessfaxnumber != ""
                          ? $message->businessfaxnumber
                          : $message->homefaxnumber);

        $addr['phone2'] = $message->home2phonenumber;

        // 'business2phonenumber' => 'TEL;WORK',
        // 'businessfaxnumber' => 'TEL;WORK;FAX',
        // 'home2phonenumber' => 'TEL;HOME',
        // 'homefaxnumber' => 'TEL;HOME;FAX',
        // 'carphonenumber' => 'TEL;CAR',
        // 'pagernumber' => 'TEL;PAGER',

        if(!empty($message->picture)) {
            $addr['photo'] .= 'PHOTO;ENCODING=BASE64;TYPE=JPEG:'."\n\t".substr(chunk_split($message->picture, 50, "\n\t"), 0, -1);
        }

        $addr['email']    = $message->email1address;
        $addr['email2']   = $message->email2address;
        $addr['email3']   = $message->email3address;

        $addr['homepage'] = $message->webpage;

        // if($message->birthday !== FALSE) {
        if($message->birthday != 0) {
           $addr['bday']   = date('j', $message->birthday);
           $addr['bmonth'] = date('F', $message->birthday);
           $addr['byear']  = date('Y', $message->birthday);
           
        }

        // if($message->anniversary !== FALSE) {
        if($message->anniversary != 0) {
           $addr['aday']   = date('j', $message->anniversary);
           $addr['amonth'] = date('F', $message->anniversary);
           $addr['ayear']  = date('Y', $message->anniversary);
        }
        // ->anniversary
/*   				
        // if($message->birthday > 0) {
          debugLog('PhpAddr::Birthday(Birthday: '.$message->birthday.', Day: '.$addr['bday']);
        }
        debugLog('PhpAddr::Birthday(Birthday: '.$message->birthday);
*/        

        //   ';;businessstreet;businesscity;businessstate;businesspostalcode;businesscountry' => 'ADR;WORK',
        //   ';;otherstreet;othercity;otherstate;otherpostalcode;othercountry' => 'ADR',
        $addr['notes'] = $message->body;

        // assistantname, assistnamephonenumber, children, department, officelocation, radiophonenumber, spouse, rtf
        $addr['address'] = $message->homestreet."\n"
                          .$message->homepostalcode." ".$message->homecity."\n"
                          .$message->homecountry;
                          // $message->homestate  = $addr_parts['city'];

        $addr['address2'] = $message->businessstreet."\n"
                           .$message->businesspostalcode." ".$message->businesscity."\n"
                           .$message->businesscountry;
                           // $message->businessstate  = $addr_parts['city'];

//2        $this->_phpaddr->connect();
        if($id == "") {
        	$id = saveAddress($addr);
          debugLog('PhpAddr::ChangedMessage(FolderID: '.$folderid.', ID: '.$id.', ..)');
        } else {
          $addr['id'] = intval($id);
        	updateAddress($addr);
        }
//2        $this->_phpaddr->disconnect();

/*
        $mapping = array(
            );
        $data = "BEGIN:VCARD\nVERSION:2.1\nPRODID:Z-Push\n";
        foreach($mapping as $k => $v){
            $val = '';
            $ks = explode(';', $k);
            foreach($ks as $i){
                if(!empty($message->$i))
                    $val .= $this->escape($message->$i);
                $val.=';';
            }
            if(empty($val))
                continue;
            $val = substr($val,0,-1);
            if(strlen($val)>50){
                $data .= $v.":\n\t".substr(chunk_split($val, 50, "\n\t"), 0, -1);
            }else{
                $data .= $v.':'.$val."\n";
            }
        }
        if(!empty($message->categories))
            $data .= 'CATEGORIES:'.implode(',', $this->escape($message->categories))."\n";
        if(!empty($message->picture))
            $data .= 'PHOTO;ENCODING=BASE64;TYPE=JPEG:'."\n\t".substr(chunk_split($message->picture, 50, "\n\t"), 0, -1);
        if(isset($message->birthday))
            $data .= 'BDAY:'.date('Y-m-d', $message->birthday)."\n";
        $data .= "END:VCARD";

// not supported: anniversary, assistantname, assistnamephonenumber, children, department, officelocation, radiophonenumber, spouse, rtf

        if(!$id){
            if(!empty($message->fileas)){
                $name = u2wi($message->fileas);
            }elseif(!empty($message->lastname)){
                $name = $name = u2wi($message->lastname);
            }elseif(!empty($message->firstname)){
                $name = $name = u2wi($message->firstname);
            }elseif(!empty($message->companyname)){
                $name = $name = u2wi($message->companyname);
            }else{
                $name = 'unknown';
            }
            $name = preg_replace('/[^a-z0-9 _-]/i', '', $name);
            $id = $name.'.vcf';
            $i = 0;
            while(file_exists($this->getPath().'/'.$id)){
                $i++;
                $id = $name.$i.'.vcf';
            }
        }
        // file_put_contents($this->getPath().'/'.$id, $data);
        */
        return $this->StatMessage($folderid, $id);
    }

    /**
     * Changes the 'read' flag of a message on disk
     *
     * @param string        $folderid       id of the folder
     * @param string        $id             id of the message
     * @param int           $flags          read flag of the message
     *
     * @access public
     * @return boolean                      status of the operation
     * @throws StatusException              could throw specific SYNC_STATUS_* exceptions
     */
    public function SetReadFlag($folderid, $id, $flags) {
        return false;
    }

    /**
     * Called when the user has requested to delete (really delete) a message
     *
     * @param string        $folderid       id of the folder
     * @param string        $id             id of the message
     *
     * @access public
     * @return boolean                      status of the operation
     * @throws StatusException              could throw specific SYNC_STATUS_* exceptions
     */
    public function DeleteMessage($folderid, $id) {

        debugLog('PhpAddr::DeleteMessage(FolderID: '.$folderid.', ID: '.$id.')');
//2        $this->_phpaddr->connect();
        $deleted = deleteAddresses(" id = '".intval($id)."'");
//2        $this->_phpaddr->disconnect();

        return $deleted;
    }

    /**
     * Called when the user moves an item on the PDA from one folder to another
     * not implemented
     *
     * @param string        $folderid       id of the source folder
     * @param string        $id             id of the message
     * @param string        $newfolderid    id of the destination folder
     *
     * @access public
     * @return boolean                      status of the operation
     * @throws StatusException              could throw specific SYNC_MOVEITEMSSTATUS_* exceptions
     */
    public function MoveMessage($folderid, $id, $newfolderid) {
        return false;
    }


    /**----------------------------------------------------------------------------------------------------------
     * private vcard-specific internals
     */

    /**
     * The path we're working on
     *
     * @access private
     * @return string
     */
    private function getPath() {
        return str_replace('%u', $this->store, VCARDDIR_DIR);
    }

    /**
     * Escapes a string
     *
     * @param string        $data           string to be escaped
     *
     * @access private
     * @return string
     */
    function escape($data){
        if (is_array($data)) {
            foreach ($data as $key => $val) {
                $data[$key] = $this->escape($val);
            }
            return $data;
        }
        $data = str_replace("\r\n", "\n", $data);
        $data = str_replace("\r", "\n", $data);
        $data = str_replace(array('\\', ';', ',', "\n"), array('\\\\', '\\;', '\\,', '\\n'), $data);
        return u2wi($data);
    }

    /**
     * Un-escapes a string
     *
     * @param string        $data           string to be un-escaped
     *
     * @access private
     * @return string
     */
    function unescape($data){
        $data = str_replace(array('\\\\', '\\;', '\\,', '\\n','\\N'),array('\\', ';', ',', "\n", "\n"),$data);
        return $data;
    }
};
?>
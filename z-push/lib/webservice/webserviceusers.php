<?php
/***********************************************
* File      :   webserviceusers.php
* Project   :   Z-Push
* Descr     :   Device remote administration tasks
*               used over webservice related to Z-Push users
*
* Created   :   14.02.2014
*
* Copyright 2007 - 2014 Zarafa Deutschland GmbH
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU Affero General Public License, version 3,
* as published by the Free Software Foundation with the following additional
* term according to sec. 7:
*
* According to sec. 7 of the GNU Affero General Public License, version 3,
* the terms of the AGPL are supplemented with the following terms:
*
* "Zarafa" is a registered trademark of Zarafa B.V.
* "Z-Push" is a registered trademark of Zarafa Deutschland GmbH
* The licensing of the Program under the AGPL does not imply a trademark license.
* Therefore any rights, title and interest in our trademarks remain entirely with us.
*
* However, if you propagate an unmodified version of the Program you are
* allowed to use the term "Z-Push" to indicate that you distribute the Program.
* Furthermore you may use our trademarks where it is necessary to indicate
* the intended purpose of a product or service provided you use it in accordance
* with honest practices in industrial or commercial matters.
* If you want to propagate modified versions of the Program under the name "Z-Push",
* you may only do so if you have a written permission by Zarafa Deutschland GmbH
* (to acquire a permission please contact Zarafa at trademark@zarafa.com).
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* Consult LICENSE file for details
************************************************/
include ('lib/utils/zpushadmin.php');

class WebserviceUsers {

    /**
     * Returns a list of all known devices
     *
     * @access public
     * @return array
     */
    public function ListDevices() {
        return ZPushAdmin::ListDevices(false);
    }

    /**
     * Returns a list of all known devices of the users
     *
     * @access public
     * @return array
     */
    public function ListDevicesAndUsers() {
        $devices = ZPushAdmin::ListDevices(false);
        $output = array();

        ZLog::Write(LOGLEVEL_INFO, sprintf("WebserviceUsers::ListDevicesAndUsers(): found %d devices", count($devices)));
        ZPush::GetTopCollector()->AnnounceInformation(sprintf("Retrieved details of %d devices and getting users", count($devices)), true);

        foreach ($devices as $devid)
            $output[$devid] = ZPushAdmin::ListUsers($devid);

        return $output;
    }

    /**
     * Returns a list of all known devices with users and when they synchronized for the first time
     *
     * @access public
     * @return array
     */
    public function ListDevicesDetails() {
        $devices = ZPushAdmin::ListDevices(false);
        $output = array();

        ZLog::Write(LOGLEVEL_INFO, sprintf("WebserviceUsers::ListLastSync(): found %d devices", count($devices)));
        ZPush::GetTopCollector()->AnnounceInformation(sprintf("Retrieved details of %d devices and getting users", count($devices)), true);

        foreach ($devices as $deviceId) {
            $output[$deviceId] = array();
            $users = ZPushAdmin::ListUsers($deviceId);
            foreach ($users as $user) {
                $output[$deviceId][$user] = ZPushAdmin::GetDeviceDetails($deviceId, $user);
            }
        }


        return $output;
    }
}
?>
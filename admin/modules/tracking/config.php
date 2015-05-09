<?php
#############################################################################################
#                                                                                           #
# $trackip:            Activate IP Tracking?                                (1=Yes 0=No)    #
# $ipmax:              How Many IP Tracking Records Do You Want As A Maximum?               #
# $ipdel:              Delete How Many IP Tracking Records When Maximum Reached?            #
# $numip:              Display How Many IP Tracking Records Per Page?                       #
# $hide_ipseg[1]:      Hide First Segment of the IP Address?                (1=Yes 0=No)    #
# $hide_ipseg[2]:      Hide Second Segment of the IP Address?               (1=Yes 0=No)    #
# $hide_ipseg[3]:      Hide Third Segment of the IP Address?                (1=Yes 0=No)    #
# $hide_ipseg[4]:      Hide Fourth Segment of the IP Address?               (1=Yes 0=No)    #
# $hide_host:          Hide Hostname?                                       (1=Yes 0=No)    #
# $ipmaskchar:         IP Address Masking Character                                         #
# $exclude_ips:        Comma separated list of quoted IP Addresses to exclude               #
# $exclude_hosts:      Comma separated list of quoted Hostnames to exclude                  #
# $members_see_iphost: Ignore Hiding IP segments and Hostnames for Members? (1=Yes 0=No)    #
# $members_see_users:  Let Members see User Names?                          (1=Yes 0=No)    #
# $show_hits:          0=show everyone, 1=only show member hits, 2=only show anonymous hits #
# $offset_hours:       Number of hours offset from Server Time                              #
# $gridcolor:          Color of IP Tracking table grid (default to $bgcolor2)               #
# $members_see_online: Let Members see who is Online?                       (1=Yes 0=No)    #
# $admin_see_online:   Let Admin see who is Online?                         (1=Yes 0=No)    #
# $updown_arrows:      Show Up/Down arrows for ascending/descending sorting (1=Yes 0=No)    #
#                                                                                           #
# Wildcard Characters (*) allowed for $exclude_ips or $exclude_hosts                        #
#                                                                                           #
# NOTE: If you hide IP Address segments but don't hide host,                                #
#       anyone can easily get the IP Address from the host name.                            #
#############################################################################################


/**
*
* @package IP Tracking SYSTEM														
* @version $Id: 1:25 PM 3/2/2010 Aneeshtan $						
* @version  http://www.ierealtor.com - phpnuke id: scottr $						
* @copyright (c) Marlik Group  http://www.nukelearn.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alikes
*
*/


$ipmax = 25000;
$ipdel = 3000;
$numip = 100;
$hide_ipseg[1] = 0;
$hide_ipseg[2] = 0;
$hide_ipseg[3] = 0;
$hide_ipseg[4] = 0;
$ipmaskchar = "x";
$show_hits = 1;
$offset_hours = 1;
$gridcolor = "#ff0000";
$admin_see_online = 1;
$updown_arrows = 0;

$exclude_ips = array(); # quoted IP comma separated list, wildcards ok
# example: $exclude_ips = array('127.0.0.1', '68.69.+');

$exclude_hosts = array(); # quoted Hostname comma separated list, wildcards ok
# example: $exclude_hosts = array('swbcs007.sbc.com', '.+avantgo.com');
#############################################################################################

?>
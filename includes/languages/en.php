<?php

function lang($phrase){

    static $lang = array(
        //Navbar Page Phrases
        "HOME_ADMIN"      => "Admin Area",
        "CATEGORIES"      => "Sections",
        "ITEMS"           => "Items",
        "MEMBERS"         => "Members",
        "COMMENTS"        => "Comments",
        "STATISTICS"      => "Statistics",
        "LOGS"            => "Logs",
        "EDIT PROFILE"    => "Edit Profile",
        "SETTINGS"        => "Settings",
        "LOGOUT"          => "Log out",
        //Dashboard Page Phrases
        "DASHBOARD"       => "Dashboard",
        "TOTALMEMBERS"    => "Total Members",
        "PENDINGMEMBERS"  => "Pending Members",
        "TOTALITEMS"      => "Total Items",
        "TOTALCOMMENTS"   => "Total Comments",
        "LATESTUSERS"     => " Latest 5 Register Users",
        "LATESTITEMS"     => "Latest Items",
        //Manage Member Page Phrases
        "MANAGEMEMBERS"   => "Manage Members",
        "USERNAME"        => "User Name",
        "EMAIL"           => "Email Address",
        "FULLNAME"        => "Full Name",
        "REGISTERDATE"    => "Register Date",
        "CONTROL"         => "Cotrol",
        "ADDNEWMEMBER"    => "Add New Member",
        //Comment Member Page Phrases
        "COMMENTMANAGE"   => "Comments Manage"
    );
    return $lang[$phrase];
}


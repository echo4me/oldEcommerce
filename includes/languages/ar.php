<?php

function lang($phrase){

    static $lang = array(
        //Navbar Page Phrases
        "HOME_ADMIN"      => "لوحة التحكم",
        "CATEGORIES"      => "الاقسام",
        "ITEMS"           => "المكونات",
        "MEMBERS"         => "الاعضاء",
        "COMMENTS"        => "التعليقات",
        "STATISTICS"      => "الاحصائيات",
        "LOGS"            => "ملفات التسجيل",
        "EDIT PROFILE"    => "اعدادت الحساب",
        "SETTINGS"        => "الاعدادات",
        "LOGOUT"          => "تسجيل الخروج",
        //Dashboard Page Phrases
        "DASHBOARD"       => "لوحة التحكم",
        "TOTALMEMBERS"    => "عدد الاعضاء",
        "PENDINGMEMBERS"  => "الاعضاء المعلقين",
        "TOTALITEMS"      => "عدد المكونات",
        "TOTALCOMMENTS"   => "عدد التعليقات",
        "LATESTUSERS"     => "اخر الاعضاء المسجلين",
        "LATESTITEMS"     => "اخر المكونات",
        //Manage Member Page Phrases
        "MANAGEMEMBERS"   => "اعدادت الاعضـاء",
        "USERNAME"        => "اسم المستخدم",
        "EMAIL"           => "الايميل",
        "FULLNAME"        => "الاسم كامل",
        "REGISTERDATE"    => "تاريخ التسجيل",
        "CONTROL"         => "اعدادت",
        "ADDNEWMEMBER"    => "اضافة عضو جديد"
    );
    return $lang[$phrase];
}


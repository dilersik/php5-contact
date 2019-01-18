<?php

switch (SystemC::getPag()) {
    // ADMIN
    case 'access_deniedVA': case 'Access_DeniedVA': 
        include_once DIR_VIEW_ADMIN . '/access_deniedVA.php'; 
        exit();
    case 'adminAddVA': 
        include_once DIR_VIEW_ADMIN . '/adminAddVA.php'; 
        exit();
    case 'adminEditVA': 
        include_once DIR_VIEW_ADMIN . '/adminEditVA.php'; 
        exit();
    case 'adminListVA': 
        include_once DIR_VIEW_ADMIN . '/adminListVA.php'; 
        exit();
    case 'homeVA': case 'restrito': 
        include_once DIR_VIEW_ADMIN . '/homeVA.php'; 
        exit();
    
    // PUBLIC
    case 'admin_loginVP': case 'admin_loginVP': 
        include_once DIR_VIEW_PUBLIC . '/adminLoginVP.php'; 
        exit();
}
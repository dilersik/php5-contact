<?php

include_once 'includes/includes.inc.php';

switch (SystemC::getPag()) {
    
//    case GET_PAG_DEFAULT: 
//        include_once DIR_VIEW_PUBLIC . '/homeVP.php'; 
//        exit();
    
    default: 
//        include_once DIR_VIEW_PUBLIC . '/404VP.php'; 
        exit();
        
}
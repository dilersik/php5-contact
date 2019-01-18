<?php

switch (SystemC::getPag()) {
    // ADMIN
    case 'contactAddVA': 
        include_once DIR_VIEW_CONTACT . '/contactAddVA.php'; 
        exit();
    case 'contactListVA': 
        include_once DIR_VIEW_CONTACT . '/contactListVA.php'; 
        exit();
    case 'contactEditVA': 
        include_once DIR_VIEW_CONTACT . '/contactEditVA.php'; 
        exit();
        
    // PUBLIC
    case 'contato': case 'fale-conosco': 
        include_once DIR_VIEW_PUBLIC . '/contactVP.php'; 
        exit();
        
    case 'trabalhe-conosco': 
        include_once DIR_VIEW_PUBLIC . '/trabalhe_conoscoVP.php'; 
        exit();
    
}
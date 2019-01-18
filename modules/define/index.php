<?php

switch (SystemC::getPag()) {
    // ADMIN
    case 'defineAddVA': 
        include_once DIR_VIEW_DEFINE . '/defineAddVA.php'; 
        exit();
    case 'defineEditVA': 
        include_once DIR_VIEW_DEFINE . '/defineEditVA.php'; 
        exit();
    case 'defineListVA': 
        include_once DIR_VIEW_DEFINE . '/defineListVA.php'; 
        exit();
        
    // PUBLIC
    
}
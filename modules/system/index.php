<?php

switch (SystemC::getPag()) {
    
    case 'executeAllSQL':
        DataBaseC::executeModulesSQL();
        exit();

    case 'downloadFromServer': 
        ToolsC::downloadFromServer(); 
        exit();

    case 'downloadFromHttp': 
        ToolsC::downloadFromHttp(); 
        exit();
    
}
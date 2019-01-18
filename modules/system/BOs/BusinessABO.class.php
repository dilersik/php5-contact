<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BusinessBO
 *
 * @author dilerdesenvolv
 */
abstract class BusinessABO {
    
    protected static function validateAdmin(ModelVOAC $vo) {
        if ($vo->getPostAdminVO()) {
            $vo->getPostAdminVO()->setStatus(SystemVO::STATUS_ATIVO);
            if (!AdminDAO::selectCountByID($vo->getPostAdminVO())) {
                throw new Exception("Invalid POST AdminID");
            }
        } else {
            $vo->setPostAdminVO(new AdminVO());
            $vo->getPostAdminVO()->setId(null);
        }
        if ($vo->getUpdateAdminVO()) {
            $vo->getUpdateAdminVO()->setStatus(SystemVO::STATUS_ATIVO);
            if (!AdminDAO::selectCountByID($vo->getUpdateAdminVO())) {
                throw new Exception("Invalid UPDATE AdminID");
            }
        } else {
            $vo->setUpdateAdminVO(new AdminVO());
            $vo->getUpdateAdminVO()->setId(null);
        }
        return true;
    }
    
}

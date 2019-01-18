<?php

class DefineDAO {
    
    public static function insert(DefineVO $vo) {
        $pstmt = DAO::newPDO()->prepare("INSERT INTO defines SET
                                        status = :status,
                                        date_post = '" . SystemC::dateTimeISO() . "',
                                        date_update = NULL,
                                        post_admin_id = :post_admin_id,
                                        page_title = :page_title,
                                        page_meta_keywords = :page_meta_keywords,
                                        page_meta_description = :page_meta_description,
                                        page_nice_url = :page_nice_url,
                                        page_analytics_code = :page_analytics_code,
                                        company_cnpj = :company_cnpj,
                                        company_state_registration = :company_state_registration,
                                        company_corporate_name = :company_corporate_name,
                                        company_fancy_name = :company_fancy_name,
                                        company_email = :company_email,
                                        company_tel = :company_tel,
                                        company_tel2 = :company_tel2,
                                        company_cel = :company_cel,
                                        company_cel2 = :company_cel2,
                                        company_whatsapp = :company_whatsapp,
                                        company_address = :company_address,
                                        company_address2 = :company_address2,
                                        company_cep_origem = :company_cep_origem,
                                        company_facebook = :company_facebook,
                                        company_instagram = :company_instagram,
                                        company_linkedin = :company_linkedin,
                                        company_twitter = :company_twitter,
                                        company_youtube = :company_youtube,
                                        correio_empresa = :correio_empresa,
                                        correio_senha = :correio_senha");
        $pstmt->bindValue(':status', $vo->getStatus(), PDO::PARAM_INT);
        $pstmt->bindValue(':post_admin_id', $vo->getPostAdminVO()->getId(), PDO::PARAM_INT);
        $pstmt->bindValue(':page_title', $vo->getPage_title());
        $pstmt->bindValue(':page_meta_keywords', $vo->getPage_meta_keywords());
        $pstmt->bindValue(':page_meta_description', $vo->getPage_meta_description());
        $pstmt->bindValue(':page_nice_url', $vo->getPage_nice_url());
        $pstmt->bindValue(':page_analytics_code', $vo->getPage_analytics_code());
        $pstmt->bindValue(':company_cnpj', $vo->getCompany_cnpj());
        $pstmt->bindValue(':company_state_registration', $vo->getCompany_state_registration());
        $pstmt->bindValue(':company_corporate_name', $vo->getCompany_corporate_name());
        $pstmt->bindValue(':company_fancy_name', $vo->getCompany_fancy_name());
        $pstmt->bindValue(':company_email', $vo->getCompany_email());
        $pstmt->bindValue(':company_tel', $vo->getCompany_tel());
        $pstmt->bindValue(':company_tel2', $vo->getCompany_tel2());
        $pstmt->bindValue(':company_cel', $vo->getCompany_cel());
        $pstmt->bindValue(':company_cel2', $vo->getCompany_cel2());
        $pstmt->bindValue(':company_whatsapp', $vo->getCompany_whatsapp());
        $pstmt->bindValue(':company_address', $vo->getCompany_address());
        $pstmt->bindValue(':company_address2', $vo->getCompany_address2());
        $pstmt->bindValue(':company_cep_origem', $vo->getCompany_cep_origem());
        $pstmt->bindValue(':company_facebook', $vo->getCompany_facebook());
        $pstmt->bindValue(':company_instagram', $vo->getCompany_instagram());
        $pstmt->bindValue(':company_linkedin', $vo->getCompany_linkedin());
        $pstmt->bindValue(':company_twitter', $vo->getCompany_twitter());
        $pstmt->bindValue(':company_youtube', $vo->getCompany_youtube());
        $pstmt->bindValue(':correio_empresa', $vo->getCorreio_empresa());
        $pstmt->bindValue(':correio_senha', $vo->getCorreio_senha());
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));
        
        return DAO::newPDO()->lastInsertId();
    }

    public static function updateDisable(DefineVO $vo) {
        $pstmt = DAO::newPDO()->prepare("UPDATE defines SET status = status * -1, update_admin_id = :update_admin_id,
                                        WHERE id = :id AND status > 0");
        $pstmt->bindValue(':update_admin_id', $vo->getUpdateAdminVO()->getId(), PDO::PARAM_INT);
        $pstmt->bindValue(':id', $vo->getId(), PDO::PARAM_INT);
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));        
    }
    
    public static function updateStatusLast($newstatus) {
        $pstmt = DAO::newPDO()->prepare("SET @ID = (SELECT MAX(id) FROM defines);
                                        UPDATE defines SET 
                                        status = :status
                                        WHERE id = @ID AND status > 0");
        $pstmt->bindValue(':status', $newstatus, PDO::PARAM_INT);
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));        
    }

    public static function select(DefineVO $vo, array $params = array()) {
        $sql = "SELECT SQL_CALC_FOUND_ROWS id, status, date_post, date_update, page_title, page_nice_url, company_email, company_tel, company_cel ";
        $sql .= " FROM defines WHERE status > 0 ";
        $sql .= $vo->getStatus() ? " AND status = :status " : "";
        $sql .= $vo->getPage_title() ? " AND page_title LIKE :page_title " : "";
        $sql .= $vo->getPage_nice_url() ? " AND page_nice_url LIKE :page_nice_url " : "";
        $sql .= " ORDER BY ";
        switch (@$params['order_by']) {
            case 1: $sql .= ' page_title ASC '; break;
            case 2: $sql .= ' page_title DESC '; break;
            case 3: $sql .= ' id ASC '; break;
            case 5: $sql .= ' status ASC '; break;
            case 6: $sql .= ' status DESC '; break;
            default: $sql .= ' id DESC '; break;
        }
        $pstmt = DAO::newPDO()->prepare($sql . (@$params['qtd'] ? " LIMIT :ini, :qtd" : ""));
        if ($vo->getStatus()) {
            $pstmt->bindValue(":status", $vo->getStatus(), PDO::PARAM_INT);
        }
        if ($vo->getPage_title()) {
            $pstmt->bindValue(":page_title", "%" . $vo->getPage_title() . "%");
        }
        if ($vo->getPage_nice_url()) {
            $pstmt->bindValue(":page_nice_url", "%" . $vo->getPage_nice_url() . "%");
        }
        if ($params['qtd']) {
            $pstmt->bindValue(':ini', $params['ini'], PDO::PARAM_INT);
            $pstmt->bindValue(':qtd', $params['qtd'], PDO::PARAM_INT);
        }
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));

        if (@$params['pager']) {
            DefineC::setRows(DAO::newPDO()->query("SELECT FOUND_ROWS()")->fetchColumn());
        }
        
        return $pstmt->fetchAll(PDO::FETCH_CLASS, 'DefineVO');
        return new DefineVO();
    }
    
    public static function selectByIDorLast(DefineVO $vo) {
        $pstmt = DAO::newPDO()->prepare("SELECT " . ($vo->getId() ? " id " : " MAX(id) ") . ", "
                                        . " status, date_post, date_update, post_admin_id, update_admin_id, page_title, page_meta_keywords, page_meta_description, page_nice_url, page_analytics_code, "
                                        . " company_cnpj, company_state_registration, company_corporate_name, company_fancy_name, company_email, company_tel, company_tel2, "
                                        . " company_cel, company_cel, company_whatsapp, company_address, company_address2, company_cep_origem, company_facebook, company_instagram,"
                                        . " company_linkedin, company_twitter, company_youtube, correio_empresa, correio_senha "
                                        . " FROM defines "
                                        . " WHERE status > 0 "
                                        . ($vo->getId() ? " AND id = :id " : "")
                                        . ($vo->getStatus() ? " AND status = :status " : ""));
        if ($vo->getId()) {
            $pstmt->bindValue(':id', $vo->getId(), PDO::PARAM_INT);
        }
        if ($vo->getStatus()) {
            $pstmt->bindValue(':status', $vo->getStatus(), PDO::PARAM_INT);
        }
        $pstmt->execute(); // nao utilizar o die(), pois precisa passar
        
        $row = $pstmt->fetchObject('DefineVO');
        if (!$row) {
            return null;
        }
        $row->setPostAdminVO(new AdminVO());
        $row->getPostAdminVO()->setId($row->post_admin_id);
        $row->setUpdateAdminVO(new AdminVO());
        $row->getUpdateAdminVO()->setId($row->update_admin_id);
        
        return $row;
        return new DefineVO();
    }
    
    public static function selectCountByID(DefineVO $vo) {
        $pstmt = DAO::newPDO()->prepare("SELECT COUNT(id) FROM defines WHERE id = :id AND status > 0 " .
                                        ($vo->getStatus() ? " AND status = :status " : ''));
        $pstmt->bindValue(':id', $vo->getId(), PDO::PARAM_INT);
        if ($vo->getStatus()) {
            $pstmt->bindValue(':status', $vo->getStatus(), PDO::PARAM_INT);
        }
        $pstmt->execute() or die(print_r($pstmt->errorInfo()));
                
        return $pstmt->fetchColumn();
    }
    
}

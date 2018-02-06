<?php
class ModelToolIntentEditPrice extends Model {
    public function getCategories($data = array()) {
        $sql = "SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, c1.parent_id, c1.sort_order FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category c1 ON (cp.category_id = c1.category_id) LEFT JOIN " . DB_PREFIX . "category c2 ON (cp.path_id = c2.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";

        if (!empty($data['filter_name'])) {
            $sql .= " AND cd2.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
        }

        $sql .= " GROUP BY cp.category_id";

        $sort_data = array(
            'name',
            'sort_order'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY sort_order";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getProductsByCategoryId($category_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN ". DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN ". DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) WHERE pd.language_id = '"
            . (int)$this->config->get('config_language_id')
            . "' AND p2c.category_id = '" . (int)$category_id . "' ORDER BY pd.name ASC");

        return $query->rows;
    }

    public function editProductPricePlus($category_id, $price) {
        $this->db->query("
        UPDATE " . DB_PREFIX . "product p INNER JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) SET p.price = p.price  +'" .(float)$price.  "', date_modified = NOW()
        WHERE p2c.category_id = '" . (int)$category_id . "'");
    }

    public function editProductPriceMinus($category_id, $price) {
        $this->db->query("
        UPDATE " . DB_PREFIX . "product p INNER JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) SET p.price = p.price  -'" .(float)$price.  "', date_modified = NOW()
        WHERE p2c.category_id = '" . (int)$category_id . "'");
    }

//UPDATE oc_product INNER JOIN oc_product_to_category ON oc_product.product_id = oc_product_to_category.product_id SET `price` = `price` +20 WHERE oc_product_to_category.category_id = 49

//    public function editProductPrice($category_id, $data) {
//        $this->db->query("
//        UPDATE " . DB_PREFIX . "product p INNER JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) SET p.price = p.price = '" .(float)$data['price'] . "', date_modified = NOW()
//        WHERE p2c.category_id = '" . (int)$category_id . "'");
//
//        model = '" . $this->db->escape($data['model']) . "',
//    }
}
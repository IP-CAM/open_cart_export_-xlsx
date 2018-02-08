<?php
class ModelToolExportAttr extends Model {

    /**
     * получение груп атрибутов в select
     * @return mixed
     */
    public function selectGroupAtribute()
    {
        $query = $this->db->query("SELECT attribute_group_id, name FROM " . DB_PREFIX . "attribute_group_description AS ad WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "'");

        return $query->rows;
    }

    /**
     * Попытка сформировать тело таблицы(то чем нужно ее заполнить)
     * @param $attribute_group_id
     * @return mixed
     */
    public function getAttributesGroupTbody($attribute_group_id)
    {
        $query = $this->db->query("SELECT pa.attribute_id, pa.product_id , a.attribute_group_id, ad.name, pa.text
                FROM " . DB_PREFIX . "attribute a 
                INNER JOIN " . DB_PREFIX . "product_attribute pa ON (pa.attribute_id = a.attribute_id)
                LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id)
                WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "'
                AND a.attribute_group_id = '" . (int)$attribute_group_id . "'  
                ORDER BY `pa`.`product_id`");

        return $query->rows; 
    }

    /**
     * получение имен атрибутов которые содержаться в любой из груп атрибута (они формируют шапку таблицы)
     * @param $attribute_group_id
     * @return mixed
     */
    public function selectGroupAttrThead ($attribute_group_id)
    {
        $query = $this->db->query("SELECT a.attribute_group_id, a.attribute_id, ad.name FROM " . DB_PREFIX . "attribute AS a
         INNER JOIN " . DB_PREFIX . "attribute_description AS ad ON (ad.attribute_id = a.attribute_id)  
             WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "'
             AND attribute_group_id ='" . (int)$attribute_group_id . "' ");

        return $query->rows;

    }

//    public function getAttributesGroup ($attribute_group_id)
//    {
//        $product_attribute_group_query = $this->db->query("SELECT pa.attribute_id, pa.product_id , a.attribute_group_id, ad.name, pa.text
//            FROM " . DB_PREFIX . "attribute a
//            INNER JOIN " . DB_PREFIX . "product_attribute pa ON (pa.attribute_id = a.attribute_id)
//            LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id)
//            WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "'
//            AND a.attribute_group_id = '" . (int)$attribute_group_id . "'
//            ORDER BY `pa`.`product_id`");
//
//        foreach ($product_attribute_group_query->rows as $product_attribute_group) {
//            $product_attribute_data = array();
//
//            $product_attribute_query = $this->db->query("SELECT pa.product_id, a.attribute_id, ad.name, pa.text
//              FROM " . DB_PREFIX . "product_attribute pa
//               LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id)
//               LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id)
//               WHERE pa.product_id = '" . (int)$product_attribute_group['product_id'] . "'
//                AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "'
//                AND pa.language_id = '" . (int)$this->config->get('config_language_id') . "'
//                ORDER BY  pa.product_id");
//
//            foreach ($product_attribute_query->rows as $product_attribute) {
//                $product_attribute_data[] = array(
//                    'product_id' => $product_attribute['product_id'],
//                    'attribute_id' => $product_attribute['attribute_id'],
//                    'name'         => $product_attribute['name'],
//                    'text'         => $product_attribute['text']
//                );
//            }
//
//            $product_attribute_group_data[] = array(
//                'attribute_group_id' => $product_attribute_group['attribute_group_id'],
//                'name'               => $product_attribute_group['name'],
//                'attribute'          => $product_attribute_data
//            );
//        }
//
//        return $product_attribute_group_data;
//
//    }




//    public function getProductAttributes($product_id) {
//        $product_attribute_group_data = array();
//
//        $product_attribute_group_query = $this->db->query("
//            SELECT  pa.product_id, ag.attribute_group_id, agd.name
//            FROM " . DB_PREFIX . "product_attribute pa
//
//            LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id)
//            LEFT JOIN " . DB_PREFIX . "attribute_group ag ON (a.attribute_group_id = ag.attribute_group_id)
//            LEFT JOIN " . DB_PREFIX . "attribute_group_description agd ON (ag.attribute_group_id = agd.attribute_group_id)
//             WHERE pa.product_id = '" . (int)$product_id . "' AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY ag.attribute_group_id ORDER BY ag.sort_order, agd.name");
//
//        foreach ($product_attribute_group_query->rows as $product_attribute_group) {
//            $product_attribute_data = array();
//
//            $product_attribute_query = $this->db->query("SELECT a.attribute_id, ad.name, pa.text FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.product_id = '" . (int)$product_id . "' AND a.attribute_group_id = '" . (int)$product_attribute_group['attribute_group_id'] . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY a.sort_order, ad.name");
//
//            foreach ($product_attribute_query->rows as $product_attribute) {
//                $product_attribute_data[] = array(
//                    'product_id' =>  $product_attribute_group['product_id'],
//                    'attribute_id' => $product_attribute['attribute_id'],
//                    'name'         => $product_attribute['name'],
//                    'text'         => $product_attribute['text']
//                );
//            }
//
//            $product_attribute_group_data[] = array(
//                'attribute_group_id' => $product_attribute_group['attribute_group_id'],
//                'name'               => $product_attribute_group['name'],
//                'attribute'          => $product_attribute_data
//            );
//        }
//
//        return $product_attribute_group_data;
//    }
}
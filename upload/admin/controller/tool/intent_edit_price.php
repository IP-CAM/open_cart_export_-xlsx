<?php

class ControllerToolIntentEditPrice extends Controller {
    public function index() {
        $this->load->language('tool/intent_edit_price');

        $this->document->setTitle($this->language->get('heading_title'));

        if (isset($this->session->data['error'])) {
            $data['error_warning'] = $this->session->data['error'];

            unset($this->session->data['error']);
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('tool/intent_edit_price', 'user_token=' . $this->session->data['user_token'], true)
        );


        $data['user_token'] = $this->session->data['user_token'];

        $data['receipt_of_goods'] = $this->url->link('tool/intent_edit_price/receiptOfGoods', 'user_token=' . $this->session->data['user_token'], true);

        $this->load->model('tool/intent_edit_price');


        $data['categories'] = $this->model_tool_intent_edit_price->getCategories();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $data['submit'] = $this->url->link('tool/intent_edit_price_prod/receiptOfGoods', 'user_token=' . $this->session->data['user_token'], true);
        $this->response->setOutput($this->load->view('tool/intent_edit_price', $data));
    }


    public function receiptOfGoods() {
        $this->index();
        $this->load->model('tool/intent_edit_price');
        $this->load->language('tool/intent_edit_price');
        $data['user_token'] = $this->session->data['user_token'];
        $data['url_update'] = $this->url->link('tool/intent_edit_price/updateProduct', 'user_token=' . $this->session->data['user_token'], true);

        $productList = [];

            if (isset($this->request->post['category_id'])) {
                $this->session->data['category_id'] = $this->request->post['category_id'];
                $productList = $this->model_tool_intent_edit_price->getProductsByCategoryId($this->request->post['category_id']);
            }
        $data['products'] = $productList;//пережаем все категории на вывод
        $this->response->setOutput($this->load->view('tool/intent_edit_price_product', $data));

    }

    public function updateProduct()
    {
        $this->load->model('tool/intent_edit_price');
        if (isset($this->request->post['increase_price'])) {
            $this->model_tool_intent_edit_price->editProductPricePlus($this->request->post['category_id'], $this->request->post['increase_price']);
        }

        if (isset($this->request->post['reduce_price'])) {
            $this->model_tool_intent_edit_price->editProductPriceMinus($this->request->post['category_id'], $this->request->post['reduce_price']);
        }

    }



}

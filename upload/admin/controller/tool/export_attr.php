<?php
class ControllerToolExportAttr extends Controller
{
    private $error = [];

    public function index()
    {
        $this->load->language('tool/export_attr');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('tool/export_attr');


        $data['heading_title'] = $this->language->get('heading_title');
        $data['title'] = $this->language->get('title');
        $data['button_export'] = $this->language->get('button_export');
        $data['product_id'] = $this->language->get('product_id');
        $data['color'] = $this->language->get('color');
        $data['guarantee'] = $this->language->get('guarantee');
        $data['type_of_product'] = $this->language->get('type_of_product');
        $data['series'] = $this->language->get('series');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['entry_status'] = $this->language->get('entry_status');

        if (isset($this->session->data['error'])) {
            $data['error_warning'] = $this->session->data['error'];

            unset($this->session->data['error']);
        } elseif (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('tool/export_attr', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $data['save'] = $this->url->link('tool/export_attr/index', 'token=' . $this->session->data['token'], 'SSL');


        //$data['session_id_group'] =  $this->session->data['attribute_groups'];

        $data['get_group_atributes'] = $this->getGroupAtributeForSelect();

        $data['group_atributes_id'] =  $this->getAttributesGroup();


        $this->response->setOutput($this->load->view('tool/export_attr.tpl', $data));
    }

    public function getGroupAtributeForSelect()//получение груп атрибутов в select
    {
        $this->load->model('tool/export_attr');
        return $this->model_tool_export_attr->selectGroupAtribute();
    }

public function getAttributesGroup()
{
    if ($this->request->server['REQUEST_METHOD'] == 'POST') {

        $this->load->model('tool/export_attr');

        return[
            'session' =>  $this->session->data['attribute_groups'] = $this->request->post['attribute_group_id'],
            'atributes_group' =>  $this->model_tool_export_attr->getAttributesGroup((int) $this->request->post['attribute_group_id'])
        ];


        //  SELECT attribute_group_id FROM oc_attribute_group_description WHERE name LIKE "Харак%"
    }

}





}
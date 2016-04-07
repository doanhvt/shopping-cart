<?php

class Shopping extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('cart');
        $this->load->model('shopping_model');
    }

    function index() {
        $this->load->library('pagination');
        $this->db->select('*');
        $this->db->from('cart');
        $this->db->order_by('id desc');
        $offset = $this->uri->segment(2);
        $limit = 6;
        $this->db->limit($limit, $offset);
        $query_poster = $this->db->get();
// pagination        
        $config['base_url'] = site_url() . '/shopping/';
        $config['total_rows'] = $this->db->count_all('pagination');
        $config['uri_segment'] = 2;
        $config['per_page'] = $limit;
        $config['prev_link'] = '&lt;';
        $config['next_link'] = '&gt;';
        $config['last_link'] = 'Cuối';
        $config['first_link'] = 'Đầu';
        $this->pagination->initialize($config);
        $paginator = $this->pagination->create_links();
// End pagination                      
        $ndata = array(
            'paginator' => $paginator,
            'post' => $query_poster,
            'title' => "CodeIgniter Shopping Cart Demo live",
            'keywords' => "Hoangcode Programming Blog, Huong Dan, jQuery, Ajax, PHP, MySQL and Demo",
            'description' => "Hoangcode là Blog về lập trình được phát triển và duy trì bởi Hoàng Code CI. Hướng dẫn cơ bản, Jquery, Ajax, PHP, Demo, CSS3, Javascript, Codeigniter and MySQL."
        );
        $this->load->view('tem-shopping', $ndata);
    }

    function add() {
        $insert_data = array(
            'id' => $this->input->post('id'),
            'name' => $this->input->post('name'),
            'price' => $this->input->post('price'),
            'qty' => 1
        );
        $this->cart->insert($insert_data);
        redirect('shopping.html');
    }

    function remove($rowid) {
        if ($rowid === "all") {
            $this->cart->destroy();
        } else {
            $data = array(
                'rowid' => $rowid,
                'qty' => 0
            );
            $this->cart->update($data);
        }
        redirect('shopping.html');
    }

    function update_cart() {
        $cart_info = $_POST['cart'];
        foreach ($cart_info as $id => $cart) {
            $rowid = $cart['rowid'];
            $price = $cart['price'];
            $amount = $price * $cart['qty'];
            $qty = $cart['qty'];

            $data = array(
                'rowid' => $rowid,
                'price' => $price,
                'amount' => $amount,
                'qty' => $qty
            );
            $this->cart->update($data);
        }
        redirect('shopping.html');
    }

    function billing_view() {
        $ndata = array(
            'title' => "Thanh toán",
            'keywords' => "Hoangcode Programming Blog, Huong Dan, jQuery, Ajax, PHP, MySQL and Demo",
            'description' => "Hoangcode là Blog về lập trình được phát triển và duy trì bởi Hoàng Code CI. Hướng dẫn cơ bản, Jquery, Ajax, PHP, Demo, CSS3, Javascript, Codeigniter and MySQL."
        );
        $this->load->view('tem-thanhtoan', $ndata);
    }

    function save_order() {
        $customer = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'address' => $this->input->post('address'),
            'date' => date('Y-m-d')
        );
        $cust_id = $this->shopping_model->insert_thanhtoan($customer);

        $order = array(
            'date' => date('Y-m-d'),
            'customerid' => $cust_id
        );

        $ord_id = $this->shopping_model->insert_order($order);

        if ($cart = $this->cart->contents()):
            foreach ($cart as $item):
                $order_detail = array(
                    'orderid' => $ord_id,
                    'productid' => $item['id'],
                    'quantity' => $item['qty'],
                    'price' => $item['price']
                );
                $cust_id = $this->shopping_model->insert_order_detail($order_detail);
            endforeach;
        endif;
        $this->load->view('tem-success');
    }

}

?>  
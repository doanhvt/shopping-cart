<?php

class Shopping extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('cart');
        $this->load->model('m_shopping');
    }

    function index() {
                
        $this->load->library('pagination');
// pagination        
        $config['base_url'] = site_url("shopping/index");
        $config['total_rows'] = $this->db->count_all('products');
        $config['uri_segment'] = 3;
        $config['per_page'] = 3;
        $config['prev_link'] = '&lt;';
        $config['next_link'] = '&gt;';
        $config['last_link'] = 'Cuối';
        $config['first_link'] = 'Đầu';
        $this->pagination->initialize($config);
        $paginator = $this->pagination->create_links();
// End pagination
        $page = $this->uri->segment(3);
        $offset = isset($page) ? $page : 0;
        $query = $this->m_shopping->get_list_products($config['per_page'], $offset);
        $ndata = array(
            'paginator' => $paginator,
            'post' => $query,
            'offset' =>$offset        
        );
        $this->load->view('v_shopping', $ndata);
    }

    function add($offset) {
        $insert_data = array(
            'id' => $this->input->post('id'),
            'name' => $this->input->post('name'),
            'price' => $this->input->post('price'),
            'qty' => 1
        );
        $this->cart->insert($insert_data);
        redirect('shopping/index/'.$offset);
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
        redirect('shopping');
    }

    function update_cart() {
        $cart_info = $_POST['cart'];
        foreach ($cart_info as $id => $cart) {
            $rowid = $cart['rowid'];
            $price = $cart['price'];
//            $amount = $price * $cart['qty'];
            $qty = $cart['qty'];

            $data = array(
                'rowid' => $rowid,
                'price' => $price,
//                'amount' => $amount,
                'qty' => $qty
            );
            $this->cart->update($data);
        }
        redirect('shopping');
    }

    function billing_view() {
        $ndata = array(
            'title' => "Thanh toán",          
        );
        $this->load->view('v_thanhtoan', $ndata);
    }

    function save_order() {
        $customer = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'address' => $this->input->post('address'),
            'date' => date('Y-m-d H:i:s')
        );
        $cust_id = $this->m_shopping->insert_thanhtoan($customer);

        $order = array(
            'date' => date('Y-m-d H:i:s'),
            'customerid' => $cust_id
        );

        $ord_id = $this->m_shopping->insert_order($order);

        if ($cart = $this->cart->contents()):
            foreach ($cart as $item):
                $order_detail = array(
                    'orderid' => $ord_id,
                    'productid' => $item['id'],
                    'quantity' => $item['qty'],
                    'price' => $item['price']
                );
                $cust_id = $this->m_shopping->insert_order_detail($order_detail);
            endforeach;
        endif;
        $this->load->view('v_success');
    }

}

?>  
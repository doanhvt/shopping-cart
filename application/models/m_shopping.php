<?php
class M_shopping extends CI_Model {

    function __construct()
        {
            parent::__construct();
        }     
    function get_list_products($limit,$offset){
        $this->db->select('*');
        $this->db->from('products');
        $this->db->order_by('id desc');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function insert_thanhtoan($data)
        {
            $this->db->insert('customers', $data);
            $id = $this->db->insert_id();
            return (isset($id)) ? $id : FALSE;
        }
    
    function insert_order($data)
        {
            $this->db->insert('orders', $data);
            $id = $this->db->insert_id();
            return (isset($id)) ? $id : FALSE;
        }
    
    function insert_order_detail($data)
        {
            $this->db->insert('order_detail', $data);
        }                                                           
} 
?>  
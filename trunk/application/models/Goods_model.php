<?php


class Goods_model extends MY_model
{
    /** @var string 表名 */
    protected $table_name = 'goods';

    public function __construct()
    {
        parent::__construct();
    }

	/**
	 * 获取商品列表
	 */
    public function get_list($where=[],$field='*',$limit=0,$offset=0,$order_by='goods_id desc'){
		if($field !== '*'){
			$new_field = '';
			foreach (explode(',',$field) as $key => $item){
				$new_field .= $this->table_name.'.'.$item.',';
			}
			$field = trim($new_field,',');
		}else{
			$field = $this->table_name.'.'.$field;
		}
    	$this->db->select("{$field},category.category_name");
		$this->db->from($this->table_name);
		$this->db->join('category',"{$this->table_name}.category_id = category.category_id",'left');
//		$this->db->join('goods_image',"{$this->table_name}.goods_id = goods_image.goods_id",'right');
		if($where){
		    $this->db->where($where);
        }
        if($limit){
			$this->db->limit($limit);
		}
		if($offset){
			$this->db->offset($offset);
		}
		if($order_by){
			$this->db->order_by($order_by);
		}
		$goods_list = $this->db->get()->result_array();
		foreach ($goods_list as $key => &$item){
			$item['goods_status'] = $this->get_goods_status($item['goods_status']);
			$this->CI->load->model('goods_image_model');
			$this->CI->load->model('upload_file_model');
			$goods_image_where = ['goods_id'=>$item['goods_id']];
			$goods_image_field = 'goods_image.image_id,upload_file.storage,upload_file.file_url,upload_file.file_name';
			$goods_image_order_by = 'id asc';
			$join = ['upload_file','upload_file.file_id = goods_image.image_id','left_join'];
			$goods_image = $this->CI->goods_image_model->get_row_by_where($goods_image_where, $goods_image_field,$goods_image_order_by,$join);
			$goods_image['url'] = $this->CI->upload_file_model->get_url($goods_image);
			$item['image'][] = $goods_image;
		}
		return $goods_list;
	}

	/**
	 * 商品状态
	 * @param $value
	 * @return mixed
	 */
	public function get_goods_status($value)
	{
		$status = [10 => '上架', 20 => '下架'];
		return ['text' => $status[$value], 'value' => $value];
	}
}

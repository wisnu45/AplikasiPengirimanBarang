<?php
use GuzzleHttp\Client;

class Barang_Model extends CI_Model
{
	var $table  = 'barang';
	var $key  = 'id_barang';
	
	function __construct()
    {
    	parent::__construct();
    }


	function getAll($filter = null,$limit = 20,$offset = 0, $orderBy, $orderType)
	{
		$where = "";
		$cond = array();
	  	if (isset($filter))
	  	{
			if (!empty($filter->keyword))
			{
				  $cond[] = "(lower(".$this->key.") like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(b.nama) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(b.satuan) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(b.del_no) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(k.nama) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(k.id_kategori) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								)";
			}
			
			if (!empty($filter->barang))
			{
				  $cond[] = "lower(b.id_barang) not in ('' . implode($filter->barang,'', '') . '')";
			}
			
			
			if(!empty($cond))
				$where = " where ". implode(" and ", $cond);
	  	}
	    
		$limitOffset = "LIMIT $offset,$limit";
		if($limit == 0)
			$limitOffset = "";
		
		if(!$orderBy)
			$orderBy = $this->key;
		
		if(!$orderType)
			$orderType = "asc";
			
		$query = $this->db->query("SELECT SQL_CALC_FOUND_ROWS b.*,k.nama kategori,k.keterangan
								   FROM ".$this->table." b
								   LEFT JOIN kategori k on k.id_kategori = b.id_kategori
								   $where ORDER BY $orderBy $orderType $limitOffset
								   ");
								   
		$result = $query->result_array();
		$query->free_result();
		
		$total = $this->db->query('SELECT found_rows() total_row')->row()->total_row;
		
		return array($result,$total);

	//Rest Client GET
		
		{
		$client = new Client();
		$response = $client->request('GET', 'http://localhost/AplikasiPengirimanBarang/RestAPI/api/Barang',[
			'auth' => ['admin','admin'], 
			'query' => [
				'pengiriman-key' => 'barang01'
			]
		]);

		$result = json_decode($response->getBody()->getContents(),TRUE);

		return $result['data']; 
		}
	}
	


	public function get_by($field, $value = "",$obj = false)
	{
		
		
		if(!$field)
			$field = $this->key;
			
		$where = "WHERE $field = '".$this->db->escape_str(strtolower($value))."'";
		$query = $this->db->query("SELECT b.*,k.nama kategori,k.keterangan
								   FROM ".$this->table." b
								   LEFT JOIN kategori k on k.id_kategori = b.id_kategori
								   $where 
								   ");
		
		if(!$obj)
			$result = $query->result_array();
		else
			$result = $query->row();
			
		$query->free_result();
		
		return $result;
	}

	

	function remove($id)
    { 
		
		$client = new Client();	
   		if (!is_array($id))
	 	$id = array($id);
			
		$this->db->where_in($this->key, $id)->delete($this->table);
	
	 //Rest Client DELETE
	
		$response = $client->request('DELETE', 'http://localhost/AplikasiPengirimanBarang/RestAPI/api/Barang',
		[
			'auth' => ['admin','admin'],	
			'form_params' => [
				'id_barang' => $id,
				'pengiriman-key' => 'user02'
			]
		]);		
	
    }
	


	function save($id = "",$data = array(), $insert_id = false)
	{
		$client = new Client();
		if (!empty($id))
		{
			$this->db->where($this->key, $id);
			$this->db->update($this->table, $data);
		}
		else
		{
			$this->db->insert($this->table, $data);
		}
		
		return $this->db->affected_rows();

		//Rest Client
		{

		$response = $client->request('GET', 'http://localhost/AplikasiPengirimanBarang/RestAPI/api/Barang',
				[
				'auth' => ['admin','admin'],
				'query' => [
					'pengiriman-key' => 'barang01',
					'id' => $id
				]
							 
			]);
		$result = json_decode($response->getBody()->getContents(),TRUE);
	
		return $result['data'][0]; 	
		}
	}
	


	public function cekName($id,$name)
	{
		$where = "WHERE ".$this->key." <> '".$this->db->escape_str(strtolower($id))."' and nama = '".$this->db->escape_str(strtolower($name))."' ";
		$query = $this->db->query("SELECT  *
								   FROM ".$this->table." 
								   $where 
								   ");
								   
		$result = $query->result_array();
		
		$query->free_result();
		
		return $result;
	}
	


	public function cekAvalaible($id)
	{
		$query = $this->db->query(" ( SELECT  ".$this->key." FROM detail_pengiriman where ".$this->key." = '".$this->db->escape_str(strtolower($id))."' ) ");
		$result = $query->row();
		$query->free_result();
		
		return $result;
	}
	


	public function get_last()
	{
		$query = $this->db->query("SELECT  * FROM ".$this->table." order by ".$this->key." desc limit 0,1");
		$result = $query->row();
		$query->free_result();
		
		return $result;
	}
}
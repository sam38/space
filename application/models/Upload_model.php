<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model Class for "uploads".
 *
 * @package		space
 * @author		Sudarshan Shakya
 * @since		Version 1.0
 */

class Upload_model extends CI_Model{

	private $table 	= 'uploads';

	function __construct(){	
		parent::__construct();
	}

	/**
	 * fetch the list of uploads.
	 * #no limit or offset options to keep things simple.
	 */
	public function get()
	{
		$this->db->order_by('created_at', 'desc');
		$query = $this->db->get(
				$this->table
			);
		return $query;
	}

	/**
	 * find the specific upload by primary id.
	 * @return Upload record (object)
	 */
	public function find($id=0)
	{
		$query = $this->db->get_where(
			$this->table,
			['id'=>$id],
			0, 1
		);
		return $query->row();
	}

	/**
	 * this will get the data of upload record (all rows with/without filter & search)
	 */
	public function find_data($id=0, $filter='all', $keyword='', $offset=0, $limit=20)
	{
		if ($keyword != '') {
			// requires filtering + searching
			$this->db->like('name', $keyword, 'after');
			$this->db->or_like('street', $keyword, 'after');
			$this->db->or_like('city', $keyword, 'after');
			$this->db->or_like('suburb', $keyword, 'after');
			$this->db->or_like('postcode', $keyword, 'after');
			$this->db->or_like('country', $keyword, 'after');
		}
		else if ($filter != 'all') {
			$this->db->like('name', $filter, 'after');
		}
		$this->db->order_by('name', 'asc');
		$this->db->where('upload_id', $id);
		$query = $this->db->get('upload_data', $limit, $offset);
		return $query;
	}

	/**
	 * this will get the count of data length
	 */
	public function get_data_count($id=0, $filter='all', $keyword='')
	{
		if ($keyword != '') {
			// requires filtering + searching
			$this->db->like('name', $keyword, 'after');
			$this->db->or_like('street', $keyword, 'after');
			$this->db->or_like('city', $keyword, 'after');
			$this->db->or_like('suburb', $keyword, 'after');
			$this->db->or_like('postcode', $keyword, 'after');
			$this->db->or_like('country', $keyword, 'after');
		}
		else if($filter != 'all') {
			$this->db->like('name', $filter, 'after');
		}
		$this->db->where('upload_id', $id);
		return $this->db->count_all_results('upload_data');
	}

	/**
	 * this will get the meta of upload record
	 */
	public function find_meta($id=0)
	{
		$this->db->order_by('meta_key', 'asc');
		$this->db->where('upload_id', $id);
		$query = $this->db->get('upload_meta');
		return $query;
	}

	/**
	 * this will get the count of uploads in db
	 */
	public function get_count()
	{
		return $this->db->count_all($this->table);
	}

	/**
	 * this will create/update an upload record
	 * and it will return the generated PK.
	 */
	public function save($data=[], $id=0)
	{
		if ($id == 0) {
			$this->db->insert($this->table, $data);
			$id = $this->db->insert_id();
		}
		else {
			$this->db->where('id', $id);
			$this->db->update($this->table, $data);
		}
		return $id;
	}

	/**
	 * this method will save the upload-data to db
	 * BATCH INSERT ONLY
	 */
	public function save_data($data=[], $upload_id=0) {
		if ($this->db->insert_batch('upload_data', $data)) {
			// save upload-data meta if insert is successful.
			$sql = "SELECT LEFT(name, 1) AS first_letter, COUNT(*) AS total 
						FROM upload_data 
					WHERE upload_id={$upload_id} GROUP BY first_letter";
			$query = $this->db->query($sql);
			$data = [];
			foreach ($query->result() as $row) {
				$data[] = [
					'upload_id' => $upload_id,
					'meta_key' => @$row->first_letter,
					'meta_value' => intval(@$row->total)
				];
			}
			$this->db->insert_batch('upload_meta', $data);
		}
	}
}

/* End of file upload_model.php */
/* Location: application/models/upload_model.php */
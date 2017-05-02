<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('upload_model');
	}

	/**
	 * this will show the app's homepage.
	 * 
	 * 2 choices to make.. 
	 * 1. upload CSV or 2. View history uploads.
	 */
	public function index()
	{
		/**
		 * fetch number of uploads available
		 * if records doesnot exist, do NOT display the "view history" link
		 */
		$data['total_uploads'] = $this->upload_model->get_count(); 

		$this->load_view('index', $data);
	}

	/**
	 * this will display the list of uploads
	 * the list item will have a link - redirecting to upload's detail page.
	 */
	public function uploads_list()
	{
		$data['title'] = 'CSV Upload History'; // page title
		$data['records'] = $this->upload_model->get();

		$this->load_view('list', $data);
	}

	/**
	 * this will list the detail of requested upload.
	 * the page provides options to search and filter the client.
	 */
	public function view_upload($id=0, $slug='', $filter='all')
	{
		// to breakdown the large list to set of 20 per page.
		$this->load->library('pagination');

		$upload = $this->upload_model->find(intval(@$id));
		// necessary to keep track of user's current preference.
		$url = base_url("csv/view/{$id}/{$slug}"); 

		/**
		 * calculate offset for current page data.
		 */
		// current page, default 1
		$page = isset($_GET['per_page']) ? intval($_GET['per_page']) : 1;
		// list items per page.
		$per_page = 20;
		// starting offset for current page selection
		$offset = ($per_page * ($page-1));

		// search filter keyword
		$keyword = isset($_GET['search']) ? $_GET['search'] : '';

		// current upload selection. ref: ID
		$data['upload'] = $upload;
		// all the rows in the upload, customized to user's filter and search params.
		$data['upload_data'] = $this->upload_model->find_data($upload->id, $filter, $keyword, $offset, $per_page);
		// meta information about the upload
		$data['upload_meta'] = $this->upload_model->find_meta($upload->id);
		// total number of data (without any filter and search)
		$data['total_data'] = $this->upload_model->get_data_count($upload->id);
		// total number of resultant data
		$data['total_filter_data'] = $this->upload_model->get_data_count($upload->id, $filter, $keyword);
		$data['url'] = $url;

		/**
		 * Initialize pagination
		 * URL will have GET variables for current filter and search keyword.
		 */
		$base_url = $keyword == '' ? 
			$url . "/{$filter}" : 
			$url . "/{$filter}" . '?search=' . $keyword;

		$config['base_url'] = $base_url;
		$config['total_rows'] = $data['total_filter_data'];
		$config['per_page'] = $per_page;
		$config['full_tag_open'] = '<div class="pagination">';
		$config['full_tag_close'] = '</div>';
		$config['use_page_numbers'] = TRUE;
		$config['page_query_string'] = true; // pass page number as query string.

		$this->pagination->initialize($config); 

		$data['pagination'] = $this->pagination->create_links();
		// current filter 
		$data['filter'] = $filter; 
		// current page number
		$data['page'] = $page;
		// counter's starting number
		$data['sn'] = $offset;
		// search keyword passed.
		$data['keyword'] = $keyword;

		$this->load_view('detail', $data);
		// $this->output->enable_profiler(true);
	}

	/**
	 * this method will take an AJAX request to list data of an upload
	 *
	 * Thought about loading data with AJAX, but not in scope.
	 * 
	 * @return JSON object of upload data-rows.
	 */
	public function fetch_upload_data($upload_id=0)
	{
		$upload_data = $this->upload_model->find_data($upload->id);
		$data = [];
		foreach ($upload_data->result() as $row) {
			$data[] = [
				'id' => $row->given_id,
				'name' => $row->name,
				'url' => $row->url,
				'logo' => $row->logo,
				'street' => $row->street,
				'city' => $row->city,
				'suburb' => $row->suburb,
				'postcode' => $row->postcode,
				'country' => $row->country
			];
		}

		header('Content-Type: application/json');
    	echo json_encode($data);
	}

	/**
	 * this method will load the required views
	 */
	private function load_view($view='404', $data=[]) 
	{
		$this->load->view('include/header', $data);
		$this->load->view($view, $data);
		$this->load->view('include/footer');
	}
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {

	function __construct() {
		parent::__construct();
	}

	/**
	 * this will look for form submit (with file upload)
	 * and attempt to save the file.
	 * 
	 * Upon successful upload, this will attempt to save the 
	 * CSV data to the database.
	 */
	function upload_csv() {

		$filename = time() . '_' . rand(1000, 999999) . '.csv';
		$config['upload_path'] = './assets/uploads/';
		$config['allowed_types'] = 'csv';
		$config['max_size']	= 5*1024; // max 5MB
		$config['file_name'] = $filename;

		// load upload library
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file')) {
			// upload failed, show the upload form again with error alerts.
			$error = array('error' => $this->upload->display_errors());
			$data['errors'] = $error;

			$this->load->view('include/header', $data);
			$this->load->view('error', $data);
			$this->load->view('include/footer');
		}
		else {
			// file uploaded succeeded. proceed to creating meta records.
			$this->create_upload_record($filename);
		}
	}

	/**
	 * this method will save the upload data in db
	 * 
	 * @TODO : remove the uploaded file after being read and
	 * saved to the database tables.
	 */
	private function create_upload_record($filename='')
	{
		$this->load->library('csvreader');

		$this->load->model('upload_model');
		$result = $this->csvreader->parse_file("assets/uploads/{$filename}");

		// create and Upload record first.
		$title = 'Upload ' . date('dS F, Y H:iA');
		$insert_id = $this->upload_model->save([
				'title' => $title,
				'description' => $filename,
				'created_at' => date('Y-m-d H:i:s')
			]);

		// if upload record was created, continue saving the upload-data.
		// @TODO : Could put some validation here, before inserting to the database.
		if ($insert_id > 0) {
			$data = [];
			foreach ($result as $row):
				$data[] = [
					'upload_id' => $insert_id,
					'given_id' => @$row['id'],
					'name' => @$row['name'],
					'url' => @$row['url'],
					'logo' => @$row['logo'],
					'street' => @$row['street'],
					'city' => @$row['city'],
					'suburb' => @$row['suburb'],
					'postcode' => @$row['postcode'],
					'country' => @$row['country']
				];
			endforeach;

			// continue finding meta info if bulk insert was successful.
			$this->upload_model->save_data($data, $insert_id);
		}
		
		// redirect to the newly added record's detail page.
		redirect('csv/view/' . $insert_id . '/' . url_title(strtolower($title)) . '/all', 'refresh');
	}
}

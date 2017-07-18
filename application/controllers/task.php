<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		$ss = $this->session->userdata('soding_logged');
		if($ss['sess_uid']):
		
			$data = array('url' => base_url(),
						  'title' => 'TASK DATA MANAGEMENT',
						  'form_display' => $this->display_task()
					);

			$this->parser->parse('v_task', $data);

		else :

			redirect('login', 'refresh');

		endif;
	}

	public function manage($id = "")
	{
		$ss = $this->session->userdata('soding_logged');
		
		$rs = $this->general->q_get_task($id);
		
		if($rs['id'] != ""):
			$id = $rs['id'];
		else:
			$id = "";
		endif;
		
		if($rs['name'] != ""):
			$name = $rs['name'];
		else:
			$name = "";
		endif;

		if($rs['description'] != ""):
			$description = $rs['description'];
		else:
			$description = "";
		endif;
		
		if($rs['dateCreated'] != "" || $rs['dateCreated'] != NULL):
			$created = $rs['dateCreated'];
		else:
			$created = "";
		endif;

		if($rs['dateUpdated'] != "" || $rs['dateUpdated'] != NULL):
			$updated = $rs['dateUpdated'];
		else:
			$updated = "";
		endif;

		if($ss['sess_uid']):

			$arr = array('id' => $id,
						 'name' => $name,
						 'description' => $description,
						 'dateCreated' => $created,
						 'dateUpdated' => $updated
					);
			
			$data = array('url' => base_url(),
						  'title' => 'TASK DATA MANAGEMENT',
						  'form_display' => $this->manage_task($arr)
					 );
			
			$this->parser->parse('v_task', $data);

		else :

			redirect('login', 'refresh');

		endif;
	}

	public function save()
	{
		$post = $this->input->post();

		$id = $post['id'];

		if(empty($id)){
			$created = date('Y-m-d H:i:s');
		} else {
			$r = $this->general->q_get_task($id);
			$created = $r['dateCreated'];
		}

		$arr = array('name' => $post['taskName'],
					 'description' => $post['taskDescription'],
					 'dateCreated' => $created,
					 'dateUpdated' => date('Y-m-d H:i:s')
				);

		if(empty($id)):
			$this->general->q_save_task($arr);
		else:
			$this->general->q_update_task($id, $arr);
		endif;

		redirect('task');
	}

	public function delete($id)
	{
		$this->general->q_delete_task($id);

		redirect('task');
	}

	public function display_task()
	{
		$list = $this->general->q_display_task();

		$dsp = '<a href="'.site_url("task/manage").'" class="btn btn-primary">Add Task<a>
				<hr>
				<table id="datatable-responsive" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>NO</th>
							<th>TASK NAME</th>
							<th>DESCRIPTION</th>
							<th>CREATED DATE</th>
							<th>UPDATED DATE</th>
							<th>ACTION</th>
						</tr>
					</thead>
					<tbody>';
					foreach($list as $l){
						$no = 1;
						$dsp .= '<tr>
							<td>'.$no.'</td>
							<td>'.$l->name.'</td>
							<td>'.$l->description.'</td>
							<td>'.$l->dateCreated.'</td>
							<td>'.$l->dateUpdated.'</td>
							<td><a href="'.site_url("task/manage/".$l->id).'">Edit</a> | <a href="'.site_url("task/delete/".$l->id).'">Hapus</a></td>
						</tr>';
						$no++;
					}
				$dsp .= '</tbody>
				</table>';

		return $dsp;
	}

	public function manage_task($arr)
	{
		$dsp = '<a href="'.site_url("task").'" class="btn btn-primary">List Task<a>
				<hr>
				<form method="post" action="'.site_url("task/save").'">
				<table class="table table-striped">
					<tbody>
						<tr>
							<td width="12%">Task Name</td>
							<td width="1%">:</td>
							<td>
								<input type="text" name="taskName" id="name" class="form-control" value="'.$arr['name'].'" placeholder="Task Name" required>
								<input type="hidden" name="id" value="'.$arr['id'].'">
							</td>
						</tr>
						<tr>
							<td>Task Description</td>
							<td>:</td>
							<td><textarea name="taskDescription" id="description" class="form-control" placeholder="Description Name" rows="5">'.$arr['description'].'</textarea></td>
						</tr>
						<tr>
							<td colspan="2"></td>
							<td>
								<button type="submit" name="btnTask" id="btnTask" class="btn btn-success">Save Task</button>
								<input type="reset" name="btnCancel" id="btnCancel" class="btn btn-warning" value="Cancel">
							</td>
						</tr>
					</tbody>
				</table>
				</form>';

		return $dsp;
	}
}

?>

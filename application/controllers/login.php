<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function index()
	{
		header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		
		$data = array('title' => 'Login Task Management',
					  'url' => base_url(),
					  'form_display' => $this->form_login()
				 );
		
		$this->parser->parse('v_login', $data);
	}

	public function auth()
	{		
		$id = $this->input->post('uid');
		$password = $this->input->post('password');		
		
		$log = $this->general->q_check_login($id, $password);
			
		if($log)
		{
			$sess_array = array();
			foreach($log as $l){
				$sess_array = array('sess_uid' => $l->id,
									'sess_uname' => $l->username
						  	  );

				$this->session->set_userdata('soding_logged', $sess_array);
			}

			redirect('task');
		}
		
		else
		{
			$this->session->set_flashdata('admin_login_msg', 'username atau password salah');
			redirect('login');	
		}
	}

	public function out()
	{
		$this->session->unset_userdata('sess_uid');
		$this->session->unset_userdata('sess_uname');

		$this->session->sess_destroy();
		redirect('login');
	}

	public function form_login()
	{
		$dsp = '<form method="post" action="'.site_url("login/auth").'">
				<table class="table table-striped">
					<tbody>
						<tr>
							<td width="12%">Username</td>
							<td width="1%">:</td>
							<td><input type="text" name="uid" id="uid" class="form-control" placeholder="Username" required></td>
						</tr>
						<tr>
							<td>Password</td>
							<td>:</td>
							<td><input type="password" name="password" id="password" class="form-control" placeholder="Password" required></td>
						</tr>
						<tr>
							<td colspan="2"></td>
							<td>
								<button type="submit" name="btnLogin" id="btnLogin" class="btn btn-success">Login</button>
							</td>
						</tr>
					</tbody>
				</table>
				</form>';

		return $dsp;
	}
}

?>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class View_handler {
	private $data = array();
	
	public function __construct() {
		$this->config->load('site_config', TRUE);
	
		// Header
		$this->data['site_header_title'] = $this->config->item('site_header_title', 'site_config');
		$this->data['site_header_description'] = $this->config->item('site_header_description', 'site_config');
		// Navbar
		$this->data['site_navbar_name'] = $this->config->item('site_navbar_name', 'site_config');
		if($this->ion_auth->in_group(5))  $this->data['site_navbar_name'] = $this->config->item('site_navbar_name', 'site_config') .': '. $this->session->userdata('nombreEstablecimiento');
		// Footer
		$this->data['site_footer_company_name'] = $this->config->item('site_footer_company_name', 'site_config');
		$this->data['site_footer_company_url'] = $this->config->item('site_footer_company_url', 'site_config');
	}
	
	public function __get($var)
	{
		return get_instance()->$var;
	}
	
	public function view($controler_name, $view_name, $data = array()) {
		
		$this->data = array_merge($this->data, $data);
		$this->data['title'] = !empty($data['title']) ? $data['title'] : 'Sin título';
		$this->data['subtitle'] = !empty($data['subtitle']) ? $data['subtitle'] : 'Sin subtítulo';
		$this->data['breadcrumb'] = !empty($data['breadcrumb']) ? $data['breadcrumb'] : array();
		$this->data['menu_items'] = !empty($data['menu_items']) ? $data['menu_items'] : array();
		
		$components = new stdClass();

		$components->navbar = $this->load->view('navbar', $this->data, true);
		$components->breadcrumb = $this->load->view('breadcrumb', $this->data, true);
		$components->pageheader = $this->load->view('pageheader', $this->data, true);
		
		if ($this->session->userdata('login_google')) {
			$components->sidebar = $this->load->view('sidebarFuncionario', $this->data, true);
		} else if($this->ion_auth->in_group(1)){
			$components->sidebar = $this->load->view('sidebar', $this->data, true);
		} else $components->sidebar = $this->load->view('sidebarUser', $this->data, true);

		$components->footer = $this->load->view('footer', $this->data, true);
		
		$path_view_css = "components/$controler_name/$view_name/css";
		$path_view_js = "components/$controler_name/$view_name/js";
		$path_view_html = "components/$controler_name/$view_name/html";
		
		$components->css = $this->load->view($path_view_css, $this->data, true);
		$components->script = $this->load->view($path_view_js, $this->data, true);
		$components->content = $this->load->view($path_view_html, $this->data, true);
		
		$this->data['components'] = $components;
		
		$this->load->view('global', $this->data);
	}
}
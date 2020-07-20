<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Menu_model');
    }

    public function index()
    {
        $data['title'] = 'Menu Mangement';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('messages', '<div class="alert alert-success" role="alert">New menu added</div>');
            redirect('menu');
        }
    }

    public function submenu()
    {
        $data['title'] = 'Submenu Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Menu_model', 'menu');

        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];

            $this->db->insert('user_sub_menu', $data);
            $this->session->set_flashdata('messages', '<div class="alert alert-success" role="alert">New Submenu added</div>');
            redirect('menu/submenu');
        }
    }

    public function deletemenu($id)
    {

        $this->load->model('Menu_model', 'menu');
        $this->menu->deleteMenu($id);

        $this->session->set_flashdata('messages', '<div class="alert alert-danger" role="alert">Menu control has been deleted !</div>');
        redirect('menu');
    }

    public function deletesubmenu($id)
    {
        $this->load->model('Menu_model', 'menu');
        $this->menu->deleteSubMenu($id);

        $this->session->set_flashdata('messages', '<div class="alert alert-danger" role="alert">Submenu has been deleted !</div>');
        redirect('menu/submenu');
    }

    public function deleterole($id)
    {
        $this->load->model('Menu_model', 'menu');
        $this->menu->deleteRole($id);

        $this->session->set_flashdata('messages', '<div class="alert alert-danger" role="alert">Role has been deleted !</div>');
        redirect('admin/role');
    }

    public function editmenu($id)
    {
        // $where = array('id' => $id);
        $data['title'] = 'Edit Menu';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['menu'] = $this->Menu_model->edit_menu($id);
        // var_dump($data['menu']);

        $this->form_validation->set_rules('menu', 'Menu Name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/editmenu', $data);
            $this->load->view('templates/footer');
        } else {

            $menu = $this->input->post('menu');

            $this->db->set('menu', $menu);
            $this->db->where('id', $id);
            $this->db->update('user_menu');

            $this->session->set_flashdata('messages', '<div class="alert alert-success" role="alert">Your menu has been updated!</div>');
            redirect('menu/index');
        }
    }
}

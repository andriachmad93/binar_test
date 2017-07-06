<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PX_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // DEFAULT TIME ZONE
        date_default_timezone_set('Asia/Jakarta');
        // TABLE 
        $this->tbl_prefix = 'px_';
        $this->tbl_adm_config = $this->tbl_prefix . 'adm_config';
        $this->tbl_album = $this->tbl_prefix . 'album';
        $this->tbl_album_files = $this->tbl_prefix . 'album_files';
        $this->tbl_banner = $this->tbl_prefix.'banner';
        $this->tbl_kategori_bakat = $this->tbl_prefix.'kategori_bakat';
        $this->tbl_kategori_talent = $this->tbl_prefix.'kategori_talent';
        $this->tbl_key = $this->tbl_prefix.'key';
        $this->tbl_mou = $this->tbl_prefix.'mou';
        $this->tbl_mou_rating = $this->tbl_prefix.'mou_rating';
        $this->tbl_master_data = $this->tbl_prefix . 'master_data';
        $this->tbl_menu = $this->tbl_prefix . 'menu';
        $this->tbl_news = $this->tbl_prefix . 'news';
        $this->tbl_static_content = $this->tbl_prefix . 'static_content';
        $this->tbl_talent = $this->tbl_prefix.'talent';
        $this->tbl_user = $this->tbl_prefix . 'user';
        $this->tbl_useraccess = $this->tbl_prefix . 'useraccess';
        $this->tbl_usergroup = $this->tbl_prefix . 'usergroup';
        // MODELS
        $this->load->model('model_basic');
        $this->load->model('model_menu');
        $this->load->model('model_news');
        $this->load->model('model_user');
        $this->load->model('model_useraccess');
        $this->load->model('model_usergroup');
        $this->load->model('model_master');
        // sessions
        if ($this->session->userdata('admin') != FALSE)
            $this->session_admin = $this->session->userdata('admin');
        else {
            $this->session_admin = array(
                'admin_id' => 0,
                'username' => 'GUEST',
                'password' => ' ',
                'realname' => 'GUEST',
                'email' => 'GUEST@LOCAL.DEV',
                'id_usergroup' => 0,
                'name_usergroup' => 'GUEST',
                'photo' => 'THUMB.png'
            );
        }
    }

    function get_app_settings() {
        $d_row = $this->model_basic->select_all_limit($this->tbl_adm_config, 1)->row();
        $data['app_id'] = $d_row->id;
        $data['app_title'] = $d_row->title;
        $data['app_desc'] = $d_row->desc;
        $data['app_login_logo'] = $d_row->login_logo;
        $data['app_mini_logo'] = $d_row->mini_logo;
        $data['app_single_logo'] = $d_row->single_logo;
        $data['app_mini_logo'] = $d_row->mini_logo;
        $data['app_favicon_logo'] = $d_row->favicon_logo;
        $data['gallery_footer'] = $this->model_basic->get_paging($this->tbl_album_files, 10, 0, 'id', 'DESC');
        $data['footer_about_us'] = $this->model_basic->select_where($this->tbl_static_content, 'id', 2)->row();
        $data['footer_contact_us'] = $this->model_basic->select_where($this->tbl_static_content, 'id', 1)->row();

        return $data;
    }

    function get_content_url($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $contents = curl_exec($ch);
        if (curl_errno($ch)) {
            return FALSE;
        } else {
            curl_close($ch);
        }

        if (!is_string($contents) || !strlen($contents)) {
            return FALSE;
        }
        return $contents;
    }

    function makeThumbnails($updir, $img, $width, $height) {
        $thumbnail_width = $width;
        $thumbnail_height = $height;
        $thumb_beforeword = "thumb";
        $arr_image_details = getimagesize("$updir" . "$img"); // pass id to thumb name
        $original_width = $arr_image_details[0];
        $original_height = $arr_image_details[1];
        if ($original_width > $original_height) {
            $new_width = $thumbnail_width;
            $new_height = intval($original_height * $new_width / $original_width);
        } else {
            $new_height = $thumbnail_height;
            $new_width = intval($original_width * $new_height / $original_height);
        }
        $dest_x = intval(($thumbnail_width - $new_width) / 2);
        $dest_y = intval(($thumbnail_height - $new_height) / 2);
        if ($arr_image_details[2] == 1) {
            $imgt = "ImageGIF";
            $imgcreatefrom = "ImageCreateFromGIF";
        }
        if ($arr_image_details[2] == 2) {
            $imgt = "ImageJPEG";
            $imgcreatefrom = "ImageCreateFromJPEG";
        }
        if ($arr_image_details[2] == 3) {
            $imgt = "ImagePNG";
            $imgcreatefrom = "ImageCreateFromPNG";
        }
        if ($imgt) {
            $old_image = $imgcreatefrom("$updir" . "$img");
            $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
            imagecopyresized($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
            $imgt($new_image, "$updir" . "$thumb_beforeword" . "$img");
        }
    }

    function get_function($name, $function) {
        $data['function_name'] = $name;
        $data['function'] = $function;
        $data['function_form'] = $function . '_form';
        $data['function_add'] = $function . '_add';
        $data['function_edit'] = $function . '_edit';
        $data['function_delete'] = $function . '_delete';
        $data['function_get'] = $function . '_get';
        $menu_id = $this->model_basic->select_where($this->tbl_menu, 'target', $function)->row();
        if ($menu_id)
            $data['function_id'] = $menu_id->id;
        else
            $data['function_id'] = 0;
        return $data;
    }

    function get_menu() {
        $menu = $this->model_menu->get_menu_bar($this->session_admin['id_usergroup']);
        $submenu = $this->model_menu->get_sub_menu($this->session_admin['id_usergroup']);
        $data = array();
        foreach ($menu as $m) {
            $data[$m->id_menu] = $m;
            $m->submenu = array();
        }
        foreach ($submenu as $sm) {
            $data[$sm->id_parent]->submenu[] = $sm;
        }
        $data['menu'] = $data;
        return $data;
    }

    function get_all_menu() {
        $menu = $this->model_basic->select_where_order($this->tbl_menu, 'id_parent', '0', 'orders', 'ASC')->result();
        $submenu = $this->model_basic->select_where_order($this->tbl_menu, 'id_parent >', '0', 'orders', 'ASC')->result();
        $data = array();
        foreach ($menu as $m) {
            $data[$m->id] = $m;
            $m->submenu = array();
        }
        foreach ($submenu as $sm) {
            $data[$sm->id_parent]->submenu[] = $sm;
        }
        return $data;
    }

    function check_login() {
        if ($this->session->userdata('admin') == FALSE) {
            redirect('admin');
        }
        else
            return true;
    }

    function check_userakses($menu_id, $function, $user = 'admin') {
        if ($user == 'admin')
            $group_id = $this->session_admin['id_usergroup'];
        if ($user == 'member')
            $group_id = $this->session->userdata['member']['group_id'];
        $access = $this->model_useraccess->get_useraccess($group_id, $menu_id);
        switch ($function) {
            case 1:
                if ($access->act_read == 1)
                    return TRUE;
                else
                    redirect('admin');
                break;
            case 2:
                if ($access->act_create == 1)
                    return TRUE;
                else
                    redirect('admin');
                break;
            case 3:
                if ($access->act_update == 1)
                    return TRUE;
                else
                    redirect('admin');
                break;
            case 4:
                if ($access->act_delete == 1)
                    return TRUE;
                else
                    redirect('admin');
                break;
        }
    }

    function delete_temp($folder) {
        if ($this->session->userdata($folder) != FALSE) {
            $temp_folder = $this->session->userdata($folder);
            $files = glob(FCPATH . "assets/uploads/temp/" . $temp_folder . "/{,.}*", GLOB_BRACE);
            foreach ($files as $file) {
                if (is_file($file))
                    @unlink($file);
            }
            @rmdir(FCPATH . "assets/uploads/temp/" . $temp_folder);
            $this->session->unset_userdata($folder);
        }
    }

    function delete_folder($folder) {
        $files = glob(FCPATH . "assets/uploads/" . $folder . "/{,.}*", GLOB_BRACE);
        foreach ($files as $file) {
            if (is_file($file))
                @unlink($file);
        }
        @rmdir(FCPATH . "assets/uploads/" . $folder);
    }

    function format_log() {
        $log['id_log_type'];
        $log['id_user'];
        $log['desc'];
        $log['date_created'];
    }

    function save_log($data) {
        if ($this->model_basic->insert_all($this->tbl_logs, $data))
            return true;
        else
            return false;
    }

    function returnJson($msg) {
        echo json_encode($msg);
        exit;
    }

    function indonesian_currency($number) {
        $result = 'Rp. ' . number_format($number, 0, '', '.');
        return $result;
    }

    function satuan($inp)
    {
        if ($inp == 1)
        {
            return "satu ";
        }
        else if ($inp == 2)
        {
            return "dua ";
        }
        else if ($inp == 3)
        {
            return "tiga ";
        }
        else if ($inp == 4)
        {
            return "empat ";
        }
        else if ($inp == 5)
        {
            return "lima ";
        }
        else if ($inp == 6)
        {
            return "enam ";
        }
        else if ($inp == 7)
        {
            return "tujuh ";
        }
        else if ($inp == 8)
        {
            return "delapan ";
        }
        else if ($inp == 9)
        {
            return "sembilan ";
        }
        else
        {
            return "";
        }
    }

    function belasan($inp)
    {
        $proses = $inp; //substr($inp, -1);
        if ($proses == '11')
        {
            return "sebelas ";
        }
        else
        {
            $proses = substr($proses,1,1);
            return satuan($proses)."belas ";
        }
    }

    function puluhan($inp)
    {
        $proses = $inp; //substr($inp, 0, -1);
        if ($proses == 1)
        {
            return "sepuluh ";
        }
        else if ($proses == 0)
        {
            return '';
        }
        else
        {
            return satuan($proses)."puluh ";
        }
    }

    function ratusan($inp)
    {
        $proses = $inp; //substr($inp, 0, -2);
        if ($proses == 1)
        {
            return "seratus ";
        }
        else if ($proses == 0)
        {
            return '';
        }
        else
        {
            return satuan($proses)."ratus ";
        }
    }

    function ribuan($inp)
    {
        $proses = $inp; //substr($inp, 0, -3);
        if ($proses == 1)
        {
            return "seribu ";
        }
        else if ($proses == 0)
        {
            return '';
        }
        else
        {
            return satuan($proses)."ribu ";
        }
    }

    function jutaan($inp)
    {
        $proses = $inp; //substr($inp, 0, -6);
        if ($proses == 0)
        {
            return '';
        }
        else
        {
            return satuan($proses)."juta ";
        }
    }

    function milyaran($inp)
    {
        $proses = $inp; //substr($inp, 0, -9);
        if ($proses == 0)
        {
            return '';
        }
        else
        {
            return satuan($proses)."milyar ";
        }
    }

    function terbilang($rp)
    {
        $kata = "";
        $rp = trim($rp);
        if (strlen($rp) >= 10)
        {
            $angka = substr($rp, strlen($rp)-10, -9);
            $kata = $kata.milyaran($angka);
        }
        $tambahan = "";
        if (strlen($rp) >= 9)
        {
            $angka = substr($rp, strlen($rp)-9, -8);
            $kata = $kata.ratusan($angka);
            if ($angka > 0) { $tambahan = "juta "; }
        }
        if (strlen($rp) >= 8)
        {
            $angka = substr($rp, strlen($rp)-8, -7);
            $angka1 = substr($rp, strlen($rp)-7, -6);
            if (($angka == 1) && ($angka1 > 0))
            {
                $angka = substr($rp, strlen($rp)-8, -6);
                //echo " belasan".($angka)." ";
                $kata = $kata.belasan($angka)."juta ";
            }
            else
            {
                $angka = substr($rp, strlen($rp)-8, -7);
                //echo " puluhan".($angka)." ";
                $kata = $kata.puluhan($angka);
                if ($angka > 0) { $tambahan = "juta "; }
                
                $angka = substr($rp, strlen($rp)-7, -6);
                //echo " ribuan".($angka)." ";
                $kata = $kata.ribuan($angka);
                if ($angka == 0) { $kata = $kata.$tambahan; }
            }   
        }
        if (strlen($rp) == 7)
        {
            $angka = substr($rp, strlen($rp)-7, -6);
            $kata = $kata.jutaan($angka);
            if ($angka == 0) { $kata = $kata.$tambahan; }
        }
        $tambahan = "";
        if (strlen($rp) >= 6)
        {
            $angka = substr($rp, strlen($rp)-6, -5);
            $kata = $kata.ratusan($angka);
            if ($angka > 0) { $tambahan = "ribu "; }
        }
        if (strlen($rp) >= 5)
        {
            $angka = substr($rp, strlen($rp)-5, -4);
            $angka1 = substr($rp, strlen($rp)-4, -3);
            if (($angka == 1) && ($angka1 > 0))
            {
                $angka = substr($rp, strlen($rp)-5, -3);
                //echo " belasan".($angka)." ";
                $kata = $kata.belasan($angka)."ribu ";
            }
            else
            {
                $angka = substr($rp, strlen($rp)-5, -4);
                //echo " puluhan".($angka)." ";
                $kata = $kata.puluhan($angka);
                if ($angka > 0) { $tambahan = "ribu "; }
                
                $angka = substr($rp, strlen($rp)-4, -3);
                //echo " ribuan".($angka)." ";
                $kata = $kata.ribuan($angka);
                if ($angka == 0) { $kata = $kata.$tambahan; }
            }
        }
        if (strlen($rp) == 4)
        {
            $angka = substr($rp, strlen($rp)-4, -3);
            //echo " ribuan".($angka)." ";
            $kata = $kata.ribuan($angka);
            if ($angka == 0) { $kata = $kata.$tambahan; }
        }
        if (strlen($rp) >= 3)
        {
            $angka = substr($rp, strlen($rp)-3, -2);
            //echo " ratusan".($angka)." ";
            $kata = $kata.ratusan($angka);
        }
        if (strlen($rp) >= 2)
        {
            $angka = substr($rp, strlen($rp)-2, -1);
            $angka1 = substr($rp, strlen($rp)-1);
            if (($angka == 1) && ($angka1 > 0))
            {
                $angka = substr($rp, strlen($rp)-2);
                //echo " belasan".($angka)." ";
                $kata = $kata.belasan($angka);
            }
            else
            {
                //echo " puluhan".($angka)." ";
                $kata = $kata.puluhan($angka);
                
                $angka = substr($rp, strlen($rp)-1);
                //echo " satuan".($angka)." ";
                $kata = $kata.satuan($angka);
            }
        }
        if (strlen($rp) == 1)
        {
            $angka = substr($rp, strlen($rp)-1);
            //echo " satuan".($angka)." ";
            $kata = $kata.satuan($angka);
        }
        return $kata;
    } 

}

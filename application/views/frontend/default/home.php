<?php
//include 'login.php';
if ($this->session->userdata('user_login')) {
    include 'logged_in_home.php';
}else {
    include 'logged_out_home.php';
}

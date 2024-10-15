<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 *  @author     : Creativeitem
 *  date        : 14 september, 2017
 *  Specification    :    Mobile app response, JSON formatted data for iOS & android app
 *  Ekattor School Management System Pro
 *  http://codecanyon.net/user/Creativeitem
 *  http://support.creativeitem.com
 */
class Mobile extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        //Authenticate data manipulation with the user level security key
        if ($this->validate_auth_key() != 'success')
            die;
    }
    // response of class list
    function get_class()
    {
        $response = array();
        $classes  = $this->db->get('class')->result_array();
        foreach ($classes as $row) {
            $data['class_id']     = $row['class_id'];
            $data['name']         = $row['name'];
            $data['name_numeric'] = $row['name_numeric'];
            $data['teacher_id']   = $row['teacher_id'];
            $sections             = $this->db->get_where('section', array(
                'class_id' => $row['class_id']
            ))->result_array();
            $data['sections']     = $sections;
            array_push($response, $data);
        }
        echo json_encode($response);
    }
    // returns image of user, returns blank image if not found.
    function get_image_url($type = '', $id = '')
    {
        $type     = $this->input->post('user_type');
        $id       = $this->input->post('user_id');
        $response = array();
        if (file_exists('uploads/' . $type . '_image/' . $id . '.jpg'))
            $response['image_url'] = base_url() . 'uploads/' . $type . '_image/' . $id . '.jpg';
        else
            $response['image_url'] = base_url() . 'uploads/user.jpg';
        echo json_encode($response);
    }
    // returns system name and logo as public call
    function get_system_info()
    {
        $response['system_name'] = $this->db->get_where('settings', array(
            'type' => 'system_name'
        ))->row()->description;
        echo json_encode($response);
    }
    // returns the students of a specific class according to requested class_id
    // ** class_id, year required to get students from enroll table
    function get_students_of_class()
    {
        $response     = array();
        $class_id     = $this->input->post('class_id');
        $running_year = $this->db->get_where('settings', array(
            'type' => 'running_year'
        ))->row()->description;
        $students     = $this->db->get_where('enroll', array(
            'class_id' => $class_id,
            'year' => $running_year
        ))->result_array();
        foreach ($students as $row) {
            $data['student_id']  = $row['student_id'];
            $data['roll']        = $row['roll'];
            $data['name']        = $this->db->get_where('student', array(
                'student_id' => $row['student_id']
            ))->row()->name;
            $data['birthday']    = $this->db->get_where('student', array(
                'student_id' => $row['student_id']
            ))->row()->birthday;
            $data['gender']      = $this->db->get_where('student', array(
                'student_id' => $row['student_id']
            ))->row()->sex;
            $data['address']     = $this->db->get_where('student', array(
                'student_id' => $row['student_id']
            ))->row()->address;
            $data['phone']       = $this->db->get_where('student', array(
                'student_id' => $row['student_id']
            ))->row()->phone;
            $data['email']       = $this->db->get_where('student', array(
                'student_id' => $row['student_id']
            ))->row()->email;
            $data['class']       = $this->db->get_where('class', array(
                'class_id' => $row['class_id']
            ))->row()->name;
            $data['section']     = $this->db->get_where('section', array(
                'section_id' => $row['section_id']
            ))->row()->name;
            $parent_id           = $this->db->get_where('student', array(
                'student_id' => $row['student_id']
            ))->row()->parent_id;
            $data['parent_name'] = $this->db->get_where('parent', array(
                'parent_id' => $parent_id
            ))->row()->name;
            $data['image_url']   = $this->crud_model->get_image_url('student', $row['student_id']);
            array_push($response, $data);
        }
        echo json_encode($response);
    }
    // get students basic info

    function get_attendance()
    {
        $response     = array();
        $date         = $this->input->post('date');
        $month        = $this->input->post('month');
        $year         = $this->input->post('year');
        $class_id     = $this->input->post('class_id');
        $timestamp    = strtotime($date . '-' . $month . '-' . $year);
        $running_year = $this->db->get_where('settings', array(
            'type' => 'running_year'
        ))->row()->description;
        $students     = $this->db->get_where('enroll', array(
            'class_id' => $class_id,
            'year' => $running_year
        ))->result_array();
        foreach ($students as $row) {
            $data['student_id'] = $row['student_id'];
            $data['roll']       = $row['roll'];
            $data['name']       = $this->db->get_where('student', array(
                'student_id' => $row['student_id']
            ))->row()->name;
            $attendance_query   = $this->db->get_where('attendance', array(
                'timestamp' => $timestamp,
                'student_id' => $row['student_id']
            ));
            if ($attendance_query->num_rows() > 0) {
                $attendance_result_row = $attendance_query->row();
                $data['status']        = $attendance_result_row->status;
            } else {
                $data['status'] = '0';
            }
            array_push($response, $data);
        }
        echo json_encode($response);
    }
    // class routine : class and weekly day wise
    // ** class_id, section_id, subject_id, year to get section wise class routine from class_routine table

    function get_message_threads() {
        $response = array();
        $user = $this->input->post('user');
        $this->db->where('sender', $user);
        $this->db->or_where('reciever', $user);
        $threads = $this->db->get('message_thread')->result_array();
        foreach ($threads as $row) {
            $sender   = explode('-', $row['sender']);
            $receiver = explode('-', $row['reciever']);
            $sender_name = $this->db->get_where($sender[0], array($sender[0].'_id' => $sender[1]))->row()->name;
            $receiver_name = $this->db->get_where($receiver[0], array($receiver[0].'_id' => $receiver[1]))->row()->name;
            $user_type = ($user == $row['sender']) ? $receiver[0] : $sender[0];
            $user_name = ($user == $row['sender']) ? $receiver_name : $sender_name;
            $user_id = ($user == $row['sender']) ? $receiver[1] : $sender[1];
            if (file_exists('uploads/'.$user_type.'_image/'.$user_id.'.jpg'))
                $image_url = base_url('uploads/'.$user_type.'_image/'.$user_id.'.jpg');
            else
                $image_url = base_url('uploads/user.jpg');
            $data['message_thread_code']    =   $row['message_thread_code'];
            $data['user_type']              =   $user_type;
            $data['user_name']              =   $user_name;
            $data['image_url']              =   $image_url;
            array_push($response, $data);
        }
        echo json_encode($response);
    }
    function get_messages() {
        $response = array();
        $message_thread_code = $this->input->post('message_thread_code');
        $this->db->where('message_thread_code', $message_thread_code);
        $this->db->order_by('timestamp', 'asc');
        $messages = $this->db->get('message')->result_array();
        foreach ($messages as $row) {
            $sender = explode('-', $row['sender']);
            $sender_name = $this->db->get_where($sender[0], array($sender[0].'_id' => $sender[1]))->row()->name;
            $data['sender']         =   $row['sender'];
            $data['sender_type']    =   $sender[0];
            $data['sender_id']      =   $sender[1];
            $data['sender_name']    =   $sender_name;
            $data['message']        =   $row['message'];
            $data['date']           =   date('d M, Y', $row['timestamp']);
            array_push($response, $data);
        }
        echo json_encode($response);
    }
    function get_receivers() {
        $student_array = array();
        $teacher_array = array();
        $parent_array = array();
        $admin_array = array();
        $response = array();
        $for_user = $this->input->post('for_user');
        $for_user = explode('-', $for_user);
        $type = $for_user[0];
        // students
        $this->db->order_by('name', 'asc');
        $students = $this->db->get('student')->result_array();
        foreach ($students as $row) {
            $data['id'] =   $row['student_id'];
            $data['type'] =   'student';
            $data['name'] =   $row['name'];
            array_push($student_array, $data);
        }
        // teachers
        $this->db->order_by('name', 'asc');
        $teachers = $this->db->get('teacher')->result_array();
        foreach ($teachers as $row) {
            $data['id'] =   $row['teacher_id'];
            $data['type'] =   'teacher';
            $data['name'] =   $row['name'];
            array_push($teacher_array, $data);
        }
        // parents
        $this->db->order_by('name', 'asc');
        $parents = $this->db->get('parent')->result_array();
        foreach ($parents as $row) {
            $data['id'] =   $row['parent_id'];
            $data['type'] =   'parent';
            $data['name'] =   $row['name'];
            array_push($parent_array, $data);
        }
        // admins
        $this->db->order_by('name', 'asc');
        $admins = $this->db->get('admin')->result_array();
        foreach ($admins as $row) {
            $data['id'] =   $row['admin_id'];
            $data['type'] =   'admin';
            $data['name'] =   $row['name'];
            array_push($admin_array, $data);
        }
        if ($type == 'admin') {
            $response = array_merge($teacher_array, $parent_array, $student_array);
            echo json_encode($response);
        } else if ($type == 'teacher') {
            $response = array_merge($admin_array, $parent_array, $student_array);
            echo json_encode($response);
        } else if ($type == 'student') {
            $response = array_merge($admin_array, $teacher_array);
            echo json_encode($response);
        } else {
            $response = array_merge($admin_array, $teacher_array);
            echo json_encode($response);
        }
    }
    function send_new_message() {
        $response   =   array();
        $message    =   $this->input->post('message');
        $receiver   =   $this->input->post('receiver');
        $sender     =   $this->input->post('sender');
        $timestamp  =   strtotime(date("Y-m-d H:i:s"));
        //check if the thread between those 2 users exists, if not create new thread
        $num1 = $this->db->get_where('message_thread', array('sender' => $sender, 'reciever' => $receiver))->num_rows();
        $num2 = $this->db->get_where('message_thread', array('sender' => $receiver, 'reciever' => $sender))->num_rows();
        if ($num1 == 0 && $num2 == 0) {
            $message_thread_code                        = substr(md5(rand(100000000, 20000000000)), 0, 15);
            $data_message_thread['message_thread_code'] = $message_thread_code;
            $data_message_thread['sender']              = $sender;
            $data_message_thread['reciever']            = $receiver;
            $this->db->insert('message_thread', $data_message_thread);
        }
        if ($num1 > 0)
            $message_thread_code = $this->db->get_where('message_thread', array('sender' => $sender, 'reciever' => $receiver))->row()->message_thread_code;
        if ($num2 > 0)
            $message_thread_code = $this->db->get_where('message_thread', array('sender' => $receiver, 'reciever' => $sender))->row()->message_thread_code;
        $data_message['message_thread_code']    = $message_thread_code;
        $data_message['message']                = $message;
        $data_message['sender']                 = $sender;
        $data_message['timestamp']              = $timestamp;
        $this->db->insert('message', $data_message);
        $data['message_thread_code']    =   $message_thread_code;
        array_push($response, $data);
        echo json_encode($response);
    }
    function send_reply() {
        $message_thread_code    =   $this->input->post('message_thread_code');
        $message                =   $this->input->post('message');
        $timestamp              =   strtotime(date("Y-m-d H:i:s"));
        $sender                 =   $this->input->post('sender');

        $data_message['message_thread_code']    = $message_thread_code;
        $data_message['message']                = $message;
        $data_message['sender']                 = $sender;
        $data_message['timestamp']              = $timestamp;
        $this->db->insert('message', $data_message);
        $data['message_thread_code']    =   $message_thread_code;
        echo 'success';
    }

    // authentication_key validation
    function validate_auth_key()
    {
        /*
         * Ignore the authentication and returns success by default to constructor
         * For pubic calls: login, forget password.
         * Pass post parameter 'authenticate' = 'false' to ignore the user level authentication
         */
        if ($this->input->post('authenticate') == 'false')
            return 'success';
        $response           = array();
        $authentication_key = $this->input->post("authentication_key");
        $user_type          = $this->input->post("user_type");
        $query              = $this->db->get_where($user_type, array(
            'authentication_key' => $authentication_key
        ));
        if ($query->num_rows() > 0) {
            $row                    = $query->row();
            $response['status']     = 'success';
            $response['login_type'] = 'admin';
            if ($user_type == 'admin')
                $response['login_user_id'] = $row->admin_id;
            if ($user_type == 'teacher')
                $response['login_user_id'] = $row->teacher_id;
            if ($user_type == 'student')
                $response['login_user_id'] = $row->student_id;
            if ($user_type == 'parent')
                $response['login_user_id'] = $row->parent_id;
            $response['authentication_key'] = $authentication_key;
        } else {
            $response['status'] = 'failed';
        }
        //return json_encode($response);
        return $response['status'];
    }
}

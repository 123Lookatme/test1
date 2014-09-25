<?php
require_once('db.php');
/**
 * Created by PhpStorm.
 * User: user
 * Date: 25.09.14
 * Time: 11:32
 */
$db=Database::get_instance();
if(isset($_POST['get_list']))
{
    $result=$db->get_group_list();
    if(count($result)>0)
        die(json_encode($result));
    else(die('0'));
}
if(isset($_POST['get_layout']))
{
    $result=$db->get_layout_list();
    if(count($result)>0)
        die(json_encode($result));
    else(die('0'));
}
if(isset($_POST['submited']))
{
    $error='';
    $data=array();
   foreach($_POST['submited'] as $k=> $v)
   {
       $data[$k]=trim(strip_tags(stripslashes($v)));
   }
    foreach($data as $k=> $v)
    {
        if(!$v)
            $error.='Invalid '.$k.'</br>';
    }
    die(json_encode($data));
}

if(isset($_FILES['file']))
{
    try {
        if (!isset($_FILES['file']['error']) || is_array($_FILES['file']['error']))
        {
            throw new RuntimeException('Error: ');
        }
        switch ($_FILES['file']['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new RuntimeException('File not exist.');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new RuntimeException('File size error.');
            default:
                throw new RuntimeException('Uncaught error.');
        }
        if ($_FILES['file']['size'] > 30000) {
            throw new RuntimeException('File size error.');
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        if (false === $ext = array_search(
                $finfo->file($_FILES['file']['tmp_name']),
                array(
                    'jpg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif'
                ),
                true
            )) {
            throw new RuntimeException('Invalid file format.');
        }
        $file=time().'.'.$ext;
        $path=getcwd().DIRECTORY_SEPARATOR.'img/';
        if (!move_uploaded_file($_FILES['file']['tmp_name'],$path.$file))
        {
            throw new RuntimeException('Server Error.');
        }else{
            print_r($_FILES);exit();
        }
    } catch (RuntimeException $e) {

        die($e->getMessage());
    }


}
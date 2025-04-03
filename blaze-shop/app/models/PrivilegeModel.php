<?php
class PrivilegeModel extends Controller
{
    private $id = null;
    private $name = "";
    private $url_match = "";
    private $db;
    public function __construct()
    {
        $this->db = new Model();
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        return $this->id = $id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        return $this->name = $name;
    }
    public function getUrl_match()
    {
        return $this->url_match;
    }
    public function setUrl_match($url_match)
    {
        return $this->url_match = $url_match;
    }

    public function checkPrivilege($uri = false)
    {
        $uri = $uri != false ? $uri : $_SERVER['REQUEST_URI'];
        if (empty($_SESSION['user']['regex'])) {
            return false;
        }
        //$ Đại diện khi kết thúc chuỗi
        $Privileges = $_SESSION['user']['regex'];
        //Chuyển mảng thành chuỗi
        $Privileges = implode("|", $Privileges);
        // Kiểm tra đường dẫn uri có nằm trong quyền hay không 
        preg_match('/dashboard|' . $Privileges . '/', $uri, $matches);
        return !empty($matches);
        // return true;
    }
    public function getAllPrivile()
    {
        return $this->db->getAllRecord('privileges');
    }
}
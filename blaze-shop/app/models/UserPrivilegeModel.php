<?php
class UserPrivilegeModel {
    private $id = null;
    private $user_id = null;
    private $privilege_id = null;

    private $db;

    public function __construct()
    {
        $this->db = new Model();
    }
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        return $this->id = $id;
    }
    public function getUser_id(){
        return $this->user_id;
    }
    public function setUser_id($user_id){
        return $this->user_id = $user_id;
    }
    public function getPrivilege_id(){
        return $this->privilege_id;
    }
    public function setPrivilege_id($privilege_id){
        return $this->privilege_id = $privilege_id;
    }
    public function getAllPrivileByIdUser(UserPrivilegeModel $usPri){
        $sql = "SELECT * FROM privileges pri ";
        $sql .= "JOIN user_privileges usPri ON pri.id = usPri.privilege_id ";
        $sql .= "WHERE usPri.user_id = ? ";
        return $this->db->getAll($sql, [$usPri->getUser_id()]);
    }
    // Chèn nhiều quyền cho người dùng
    public function insertUserPrivilege($params): bool
    {
        $placeholder = str_repeat("(?, ?), ", count($params));
        $value = rtrim($placeholder, ', ');
        $data = [];
        foreach ($params as $param) {
            $data[] = $param->getUser_id();
            $data[] = $param->getPrivilege_id();
        }
        $sql = "INSERT INTO user_privileges (user_id, privilege_id) VALUES $value";
        return $this->db->insert($sql, $data);
    }
    public function remove_privilege(UserPrivilegeModel $user){
        $sql = "DELETE FROM user_privileges";
        $sql .= " WHERE user_id = ?";
        return $this->db->delete($sql, [$user->getUser_id()]);
    }

}
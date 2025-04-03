<?php
class User extends Controller
{
    public $auth_model;
    public $userPrivilege_model;
    public $privilege_model;
    public $data = [];
    public function __construct()
    {
        $this->auth_model = $this->model('AuthModel');
        $this->userPrivilege_model = $this->model('UserPrivilegeModel');
        $this->privilege_model = $this->model('PrivilegeModel');
    }
 
    public function client()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idDelete'])) {
            $this->deleteUser();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idStatus'])) {
            $this->changeStatusUser();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idShow'])) {
            $this->showUserModal();
        }

        $this->auth_model->setRole(0);
        $dataUser = $this->auth_model->getAllUserByRole($this->auth_model);
        $this->data['sub_content']['dataUser'] = $dataUser;
        $this->data['page_title'] = 'BLAZE-Admin - Tài Khoản Khách Hàng';
        $this->data['content'] = 'admin/users/user.client';
        $this->render('layouts/admin_layout', $this->data);
    }

    public function deleteUser()
    {
        $this->auth_model->setId($_POST['idDelete']);
        $this->auth_model->deleteUser($this->auth_model);
    
        $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Xóa thành công!', 'type' => 'success'];
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
    } 

    public function changeStatusUser()
    {
        $this->auth_model->setId($_POST['idStatus']);
        $this->auth_model->setStatus($_POST['statusNew']);
        $this->auth_model->changeStatusUser($this->auth_model);
        $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Đổi trạng thái thành công!', 'type' => 'success'];
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;

    }

    public function showUserModal()
    {
        $this->auth_model->setId($_POST['idShow']); // Lấy ID danh mục
        $userShow = $this->auth_model->getOneUserByIdForOder($this->auth_model); // Lấy thông tin danh mục
        // Nếu tìm thấy danh mục, trả về dữ liệu dưới dạng JSON
        if ($userShow) {
            echo json_encode($userShow);
        } else {
            echo json_encode(['error' => 'Không tìm thấy người dùng']);
        }
    }

    public function staff()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nameStaffAdd'])) {
            $this->addStaff();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idDelete'])) {
            $this->deleteStaff();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idShow'])) {
            $this->showStaffModal();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idStaffEdit'])) {
            $this->updateStaff();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idStatus'])) {
            $this->changeStatusStaff();
        }
        $this->auth_model->setRole(1);
        $idUser = $_SESSION['user']['id'] ?? 1;
        $this->auth_model->setId($idUser);
        $dataStaff = $this->auth_model->getAllUserByRole($this->auth_model);
        $this->data['sub_content']['dataStaff'] = $dataStaff;
        $this->data['page_title'] = 'BLAZE-Admin - Tài Khoản Nhân Viên';
        $this->data['content'] = 'admin/users/user.staff';
        $this->render('layouts/admin_layout', $this->data);
    }

    public function addStaff()
    {   
        // Kiểm tra và lấy dữ liệu từ form
        $nameStaffAdd = $_POST['nameStaffAdd'] ?? null;
        $emailStaffAdd = $_POST['emailStaffAdd'] ?? null;
        $passwordStaffAdd = $_POST['passwordStaffAdd'] ?? null;
        $passwordCf = $_POST['passwordCf'] ?? null;

        if (!$nameStaffAdd || !$emailStaffAdd || !$passwordStaffAdd) {
            $_SESSION['messger'] = ['title' => 'Cảnh báo', 'mess' => 'Vui lòng nhập đầy đủ thông tin!', 'type' => 'warning'];
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } elseif ($passwordStaffAdd !== $passwordCf) {
            $_SESSION['messger'] = ['title' => 'Cảnh báo', 'mess' => 'Mật khẩu không trùng khớp!', 'type' => 'warning'];
            header("Location: " . $_SERVER['PHP_SELF']);
        } else {
            $this->auth_model->setName($_POST['nameStaffAdd']);
            $this->auth_model->setEmail($_POST['emailStaffAdd']);
            $this->auth_model->setPassword($_POST['passwordStaffAdd']);

            $this->auth_model->addStaff($this->auth_model);

            $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Thêm nhân viên thành công!', 'type' => 'success'];
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    public function deleteStaff()
    {
        $this->auth_model->setId($_POST['idDelete']);
        $this->auth_model->deleteStaff($this->auth_model);

        $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Xóa thành công!', 'type' => 'success'];
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    public function showStaffModal()
    {
        $this->auth_model->setId($_POST['idShow']); // Lấy ID danh mục
        $staffShow = $this->auth_model->getOneUserById($this->auth_model); // Lấy thông tin danh mục
        // Nếu tìm thấy danh mục, trả về dữ liệu dưới dạng JSON
        if ($staffShow) {
            echo json_encode($staffShow);
        } else {
            echo json_encode(['error' => 'Không tìm thấy người dùng']);
        }
    }

    public function updateStaff()
    {   
        $idStaff = $_POST['idStaffEdit'] ?? null;
        $nameStaff = $_POST['nameStaffEdit'] ?? null;
        $emailStaff = $_POST['emailStaffEdit'] ?? null;
        $passwordStaff = $_POST['passwordStaffEdit'] ?? null;
        $passwordCf = $_POST['passwordCfEdit'] ?? null;

        if (!$nameStaff || !$emailStaff || !$passwordStaff) {
            $_SESSION['messger'] = ['title' => 'Cảnh báo', 'mess' => 'Vui lòng nhập đầy đủ thông tin!', 'type' => 'warning'];
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }elseif ($passwordStaff !== $passwordCf) {
            $_SESSION['messger'] = ['title' => 'Cảnh báo', 'mess' => 'Mật khẩu không trùng khớp!', 'type' => 'warning'];
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $this->auth_model->setId($idStaff);
            $this->auth_model->setName($nameStaff);
            $this->auth_model->setEmail($emailStaff);
            $this->auth_model->setPassword($passwordStaff);

            $this->auth_model->update_user($this->auth_model);

            $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Cập nhật thành công!', 'type' => 'success'];
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    public function changeStatusStaff()
    {
        $this->auth_model->setId($_POST['idStatus']);
        $this->auth_model->setStatus($_POST['statusNew']);
        $this->auth_model->changeStatusUser($this->auth_model);

        $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Đổi trạng thái thành công!', 'type' => 'success'];
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;

    }
    public function showEditPrivilege()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['staffId'])) {
            $this->userPrivilege_model->setUser_id($_POST['staffId']); // Lấy ID nhân viên
            $dataPrivilege = $this->privilege_model->getAllPrivile();
            $dataPriStaff = $this->userPrivilege_model->getAllPrivileByIdUser($this->userPrivilege_model);
            // Lấy danh sách ID quyền hiện tại của nhân viên
            $privilegeId = array_column($dataPriStaff, 'privilege_id');
            if ($dataPrivilege) {
                echo '<input type="hidden" name="user_id" value="' . $_POST['staffId'] . '">';
                foreach ($dataPrivilege as $value) {
                    $checked = in_array($value['id'], $privilegeId) ? 'checked' : '';
                    echo '<div class="col-6 custom-control custom-switch mb-4">
                    <input type="checkbox" name="privilege[]" ' . $checked . ' value="' . $value['id'] . '" class="custom-control-input" id="' . $value['id'] . '">
                    <label class="custom-control-label fs-18" for="' . $value['id'] . '">' . $value['name'] . '</label>
                </div>';
                }
            } else {
                echo 'Không tìm thấy id nhân viên';
            }
        }
        exit;
    }
    public function addPrivilege()
    {
        if (isset($_POST['submitPrivilege'])) {
            $privilegeData = !empty($_POST['privilege']) ? $_POST['privilege'] : [];
            $userId = $_POST['user_id'] ?? null;
            $this->userPrivilege_model->setUser_id($userId);
            if (!empty($privilegeData)) {
                $privileges = [];
                foreach ($privilegeData as $privilegeId) {
                    $privilege = new UserPrivilegeModel(); //Gọi lại để tạo đối tượng mới
                    $privilege->setUser_id($userId);
                    $privilege->setPrivilege_id($privilegeId);
                    $privileges[] = $privilege; // Thêm đối tượng vào mảng
                }
                // Xóa quyền có sẳn nếu có
                $this->userPrivilege_model->remove_privilege($this->userPrivilege_model);
                // Gọi phương thức insertUserPrivilege để thêm vào database
                $checkAdd = $this->userPrivilege_model->insertUserPrivilege($privileges);
                if ($checkAdd) {
                    $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Phân quyền thành công', 'type' => 'success'];
                    header("Location: "._WEB_ROOT_."/admin/nhan-vien");
                } else {
                    $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Thêm quyền thất bại!', 'type' => 'error'];
                    header("Location: "._WEB_ROOT_."/admin/nhan-vien");
                }
            } else {
                //Gọi lại hàm xóa nếu muốn xóa tất cả quyền của nhân viên đó
                $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Phân quyền thành công!', 'type' => 'success'];
                header("Location: "._WEB_ROOT_."/admin/nhan-vien");
            }
        }
    }
}

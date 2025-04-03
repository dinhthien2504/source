<?php
class Auth extends Controller
{
    public $auth_model;
    public $userPrivilege_model;
    public $data = [];
    public $errorMessage = null;


    public function __construct()
    {
        $this->auth_model = $this->model('AuthModel');
        $this->userPrivilege_model = $this->model('UserPrivilegeModel');
    }

    // Trang đăng nhập
    public function index()
    {
        $this->data['page_title'] = 'Đăng nhập';
        $this->data['content'] = 'auth/index';
        $this->data['sub_content'] = [];
        $this->render('layouts/client_layout', $this->data);
    }

    // Trang Profile
    public function profile()
    {
        $this->data['page_title'] = 'Trang cá nhân';
        $this->data['content'] = 'auth/profile';
        $this->data['sub_content'] = [];
        $this->render('layouts/client_layout', $this->data);
    }

    //Update
    public function update_profile()
    {
        $this->data['page_title'] = 'Trang cá nhân';
        $this->data['content'] = 'auth/update_profile';
        $this->data['sub_content'] = [];
        $this->render('layouts/client_layout', $this->data);
    }

    //Forgot
    public function forgot()
    {
        $this->data['page_title'] = 'Quên mật khẩu';
        $this->data['content'] = 'auth/forgot';
        $this->data['sub_content'] = [];
        $this->render('layouts/client_layout', $this->data);
    }
    //verify
    public function verify()
    {
        $this->data['page_title'] = 'Mã xác nhận';
        $this->data['content'] = 'auth/verification';
        $this->data['sub_content'] = [];
        $this->render('layouts/client_layout', $this->data);
    }
    //reset
    public function reset()
    {
        $this->data['page_title'] = 'Đổi mật khẩu';
        $this->data['content'] = 'auth/resetpass';
        $this->data['sub_content'] = [];
        $this->render('layouts/client_layout', $this->data);
    }



    // Xử lý đăng nhập
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Vui lòng nhập đầy đủ thông tin', 'type' => 'error'];
                header("Location: " . _WEB_ROOT_ . "/tai-khoan");
                exit();
            } else {
                $user = new AuthModel();
                $user->setEmail($email);
                if (!$this->auth_model->getUserEmail($user)) {
                    $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Email chưa được đăng ký.', 'type' => 'error'];
                    header("Location: " . _WEB_ROOT_ . "/tai-khoan");
                    exit();
                } else {
                    $this->auth_model->setEmail($email);
                    $this->auth_model->setPassword($password);

                    $loggedInUser = $this->auth_model->login($this->auth_model);
                    if ($loggedInUser) {
                        if ($loggedInUser['role'] == 0) {
                            $_SESSION['user'] = $loggedInUser;
                            $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Đăng nhập thành công !', 'type' => 'success'];
                            header('Location: ' . _WEB_ROOT_ . '/trang-chu');
                            exit();
                        } else {
                            $this->userPrivilege_model->setUser_id($loggedInUser['id']);
                            $getPrivilegeUser = $this->userPrivilege_model->getAllPrivileByIdUser($this->userPrivilege_model);

                            $loggedInUser['regex'] = !isset($loggedInUser['regex']) ? [] : '';
                            $loggedInUser['namePrivilegeUser'] = !isset($loggedInUser['namePrivilegeUser']) ? [] : '';
                            $loggedInUser['regex'][] = 'admin\/dashboard$';

                            if (!empty($getPrivilegeUser)) {
                                foreach ($getPrivilegeUser as $privilege) {
                                    if (!empty($privilege['url_match'])) {
                                        $loggedInUser['regex'][] = $privilege['url_match'];
                                    }
                                    if (!empty($privilege['name'])) {
                                        $loggedInUser['namePrivilegeUser'][] = $privilege['name'];
                                    }
                                }
                            }

                            $_SESSION['user'] = $loggedInUser;
                            header('Location: ' . _WEB_ROOT_ . '/admin/dashboard');
                            exit;
                        }
                    } else {
                        $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Email hoặc mật khẩu không chính xác hoặc tài khoản đã bị chặn !', 'type' => 'error'];
                        header("Location: " . _WEB_ROOT_ . "/tai-khoan");
                        exit();
                    }
                }
            }
        }

        if (!empty($this->errorMessage)) {
            $this->data['error'] = $this->errorMessage;
        }

        $this->data['page_title'] = 'Đăng nhập';
        $this->data['content'] = 'auth/index';
        $this->render('layouts/client_layout', $this->data);
    }



    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $email = $_POST['email'] ?? '';
            $image = $_FILES['image'] ?? null;
            $password = $_POST['password'] ?? '';
            $address = $_POST['address'] ?? null;

            $validation = $this->checkFormRegister($name, $phone, $email, $password);
            if ($validation !== true) {
                $this->errorMessage = $validation;
            } else {
                $user = new AuthModel();
                $user->setEmail($email);
                if ($this->auth_model->getUserEmail($user)) {
                    $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Email đã được đăng ký.', 'type' => 'error'];
                    header("Location: " . _WEB_ROOT_ . "/tai-khoan");
                    exit();
                } else {
                    if (empty($image['name'])) {
                        $file_name = 'anh-avatar-fb-8.jpg';
                    } else {
                        $target_dir = dirname(__DIR__, 2) . "/public/assets/img/img_user/";
                        $unique_name = time() . '_' . basename($image["name"]);
                        $target_file = $target_dir . $unique_name;
                        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                        $check = getimagesize($image["tmp_name"]);

                        if ($check === false) {
                            $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'File không phải là ảnh.', 'type' => 'error'];
                            header("Location: " . _WEB_ROOT_ . "/tai-khoan");
                            exit();
                        } elseif ($image["size"] > 500000) {
                            $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'File ảnh quá lớn.', 'type' => 'error'];
                            header("Location: " . _WEB_ROOT_ . "/tai-khoan");
                            exit();
                        } elseif (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
                            $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Chỉ chấp nhận các định dạng JPG, JPEG, PNG, GIF.', 'type' => 'error'];
                            header("Location: " . _WEB_ROOT_ . "/tai-khoan");
                            exit();
                        } else {
                            if (move_uploaded_file($image["tmp_name"], $target_file)) {
                                $file_name = $unique_name;
                            } else {
                                $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Có lỗi xảy ra khi upload file.', 'type' => 'error'];
                                header("Location: " . _WEB_ROOT_ . "/tai-khoan");
                                exit();
                            }
                        }
                    }
                    if (empty($this->errorMessage)) {
                        try {
                            $this->auth_model->setName($name);
                            $this->auth_model->setPhone($phone);
                            $this->auth_model->setEmail($email);
                            $this->auth_model->setImage($file_name);
                            $this->auth_model->setPassword($password);
                            $this->auth_model->setAddress($address);
                            $this->auth_model->insert_user($this->auth_model);
                            $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Đăng ký thành công!', 'type' => 'success'];
                            header("Location: " . _WEB_ROOT_ . "/tai-khoan");
                            exit();
                        } catch (Exception $e) {
                            $this->errorMessage = 'Có lỗi xảy ra! Vui lòng thử lại.';
                        }
                    }
                }
            }

            if (!empty($this->errorMessage)) {
                $this->data['error'] = $this->errorMessage;
            }

            $this->data['page_title'] = 'Đăng ký';
            $this->data['content'] = 'auth/index';
            $this->render('layouts/client_layout', $this->data);
        }
    }




    // Xử lý đăng xuất
    public function logout()
    {
        session_start();
        session_destroy();
        unset($_SESSION['user']);
        header('Location: ' . _WEB_ROOT_ . '/trang-chu');
        exit;
    }

    public function checkFormRegister($name, $phone, $email, $password)
    {
        if (empty(trim($name))) {
            $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Họ và tên không được để trống.', 'type' => 'error'];
            header('Location: ' . _WEB_ROOT_ . '/tai-khoan');
            exit;
        }
        if (empty(trim($phone))) {
            $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Số điện thoại không được để trống.', 'type' => 'error'];
            header('Location: ' . _WEB_ROOT_ . '/tai-khoan');
            exit;
        } elseif (!preg_match('/^[0-9]{10,11}$/', $phone)) {
            $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Số điện thoại không hợp lệ. Phải là 10-11 chữ số.', 'type' => 'error'];
            header('Location: ' . _WEB_ROOT_ . '/tai-khoan');
            exit;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Email không hợp lệ. Email phải chứa @.', 'type' => 'error'];
            header('Location: ' . _WEB_ROOT_ . '/tai-khoan');
            exit;
        }
        $uppercase = preg_match('/[A-Z]/', $password);
        $specialChar = preg_match('/[\W_]/', $password);
        $hasNumber = preg_match('/\d/', $password);
        $minLength = strlen($password) >= 8;

        if (!$uppercase || !$specialChar || !$hasNumber || !$minLength) {
            $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Mật khẩu phải có ít nhất 8 ký tự, chứa ít nhất 1 chữ in hoa, 1 ký tự đặc biệt.', 'type' => 'error'];
            header('Location: ' . _WEB_ROOT_ . '/tai-khoan');
            exit;
        }
        return true;
    }

    //cap nhat user
    public function update_profile_user()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userID = $_SESSION['user']['id'];
            $name = $_POST['name'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $password_new = $_POST['password_new'] ?? '';
            $address = $_POST['address'] ?? '';

            $user = $this->auth_model->getUserById($userID);
            if (!$user) {
                $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Không tìm thấy người dùng !!!', 'type' => 'error'];
                header("Location: " . _WEB_ROOT_ . "/chinh-sua-trang-ca-nhan");
                exit();
            } else {
                if (!empty($password) && !empty($user['password']) && $password !== $user['password']) {
                    $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Mật khẩu cũ không chính xác. Không thể đổi mật khẩu.', 'type' => 'error'];
                    header("Location: " . _WEB_ROOT_ . "/chinh-sua-trang-ca-nhan");
                    exit();
                } else {
                    if (!empty($password_new)) {
                        $uppercase = preg_match('/[A-Z]/', $password_new);
                        $specialChar = preg_match('/[\W_]/', $password_new);
                        $hasNumber = preg_match('/\d/', $password_new);
                        $minLength = strlen($password_new) >= 8;

                        if (!$uppercase || !$specialChar || !$hasNumber || !$minLength) {
                            $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Mật khẩu mới phải có ít nhất 8 ký tự, chứa ít nhất 1 chữ in hoa, 1 ký tự đặc biệt, và 1 chữ số.', 'type' => 'error'];
                            header("Location: " . _WEB_ROOT_ . "/chinh-sua-trang-ca-nhan");
                            exit();
                        }
                    }

                    if (empty($this->errorMessage)) {
                        $imagePath = $user['image'];
                        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                            $fileType = $_FILES['image']['type'];
                            if (in_array($fileType, $allowedTypes)) {
                                if ($_FILES['image']['size'] <= 500000) {
                                    $uniqueName = time() . '_' . basename($_FILES['image']['name']);
                                    $targetDir = dirname(__DIR__, 2) . "/public/assets/img/img_user/";
                                    $targetFile = $targetDir . $uniqueName;
                                    if (!is_dir($targetDir)) {
                                        mkdir($targetDir, 0777, true);
                                    }
                                    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                                        $imagePath = $uniqueName;
                                    } else {
                                        $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Lỗi khi tải ảnh lên.', 'type' => 'error'];
                                        header("Location: " . _WEB_ROOT_ . "/chinh-sua-trang-ca-nhan");
                                        exit();
                                    }
                                } else {
                                    $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Ảnh quá lớn. Vui lòng chọn ảnh có dung lượng nhỏ hơn 500KB.', 'type' => 'error'];
                                    header("Location: " . _WEB_ROOT_ . "/chinh-sua-trang-ca-nhan");
                                    exit();
                                }
                            } else {
                                $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Chỉ chấp nhận ảnh JPG, PNG, JPEG, GIF.', 'type' => 'error'];
                                header("Location: " . _WEB_ROOT_ . "/chinh-sua-trang-ca-nhan");
                                exit();
                            }
                        }

                        if (empty($this->errorMessage)) {
                            $this->auth_model->setId($userID);
                            $this->auth_model->setName($name ?: $user['name']);
                            $this->auth_model->setPhone($phone ?: $user['phone']);
                            $this->auth_model->setEmail($email ?: $user['email']);
                            $this->auth_model->setAddress($address ?: $user['address']);
                            $this->auth_model->setImage($imagePath);

                            if (!empty($password_new)) {
                                $this->auth_model->setPassword($password_new);
                            } else {
                                $this->auth_model->setPassword($user['password']);
                            }

                            $this->auth_model->update_user($this->auth_model);
                            $updatedUser = $this->auth_model->getUserById($userID);
                            $_SESSION['user'] = $updatedUser;
                            $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Cập nhật thông tin thành công.', 'type' => 'success'];
                            header('Location: ' . _WEB_ROOT_ . '/trang-ca-nhan');
                            exit;
                        }
                    }
                }
            }

            // Truyền lỗi vào view
            if (!empty($this->errorMessage)) {
                $this->data['error'] = $this->errorMessage;
            }

            // Truyền thông tin vào view
            $this->data['page_title'] = 'Trang cá nhân';
            $this->data['content'] = 'auth/update_profile';
            $this->render('layouts/client_layout', $this->data);
        }
    }


    //forgot
    public function forgot_pass()
    {
        require_once '' . _DIR_ROOT . '/mail/mailer.php';
        $mail = new Mailer();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';

            if (empty($email)) {
                $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Email không được để trống.', 'type' => 'error'];
                header('Location: ' . _WEB_ROOT_ . '/quen-mat-khau');
                exit;
            }

            if (empty($this->errorMessage)) {
                $user = new AuthModel();
                $user->setEmail($email);
                $result = $this->auth_model->getUserEmail($user);

                if ($result) {
                    $code = substr(rand(0, 999999), 0, 6); // Tạo mã xác nhận 6 chữ số
                    $title = "Quên mật khẩu";
                    $content = "Mã xác nhận của bạn là: <span style='color:green'>" . $code . "</span>";

                    $mail = new Mailer();
                    $userEmail = $result['email'];

                    if ($mail->sendAcessToken($title, $content, $userEmail)) {
                        $_SESSION['email'] = $userEmail;
                        $_SESSION['code'] = $code;

                        header('Location: ' . _WEB_ROOT_ . '/trang-xac-minh');
                        exit;
                    } else {
                        $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Không thể gửi email, vui lòng thử lại.', 'type' => 'error'];
                        header('Location: ' . _WEB_ROOT_ . '/quen-mat-khau');
                        exit;
                    }
                } else {
                    $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Email không tồn tại.', 'type' => 'error'];
                    header('Location: ' . _WEB_ROOT_ . '/quen-mat-khau');
                    exit;
                }
            }

            // Gán lỗi cho view nếu có
            if (!empty($this->errorMessage)) {
                $this->data['error'] = $this->errorMessage;
            }
        }

        $this->data['page_title'] = 'Quên mật khẩu';
        $this->data['content'] = 'auth/forgot';
        $this->render('layouts/client_layout', $this->data);
    }


    //checkverify

    public function check_verify()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $text = $_POST['text'] ?? '';
            if ($text != $_SESSION['code']) {
                $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Mã xác nhận không hợp lệ.', 'type' => 'error'];
                header('Location: ' . _WEB_ROOT_ . '/trang-xac-minh');
                exit;
            } else {
                header('Location: ' . _WEB_ROOT_ . '/doi-mat-khau');
                exit;
            }
            if (!empty($this->errorMessage)) {
                $this->data['error'] = $this->errorMessage;
            }
        }

        // Cài đặt thông tin cho view
        $this->data['page_title'] = 'Mã xác nhận';
        $this->data['content'] = 'auth/verification';
        $this->render('layouts/client_layout', $this->data);
    }


    //resetpass
    public function reset_password()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_SESSION['email'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if (empty($new_password) || empty($confirm_password)) {
                $this->errorMessage = 'Vui lòng điền đầy đủ thông tin.';
            } else if ($new_password !== $confirm_password) {
                $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Mật khẩu mới và xác nhận mật khẩu không trùng khớp.', 'type' => 'error'];
                header('Location: ' . _WEB_ROOT_ . '/doi-mat-khau');
                exit;
            } else {
                $uppercase = preg_match('/[A-Z]/', $new_password);
                $specialChar = preg_match('/[\W_]/', $new_password);
                $hasNumber = preg_match('/\d/', $new_password);
                $minLength = strlen($new_password) >= 8;

                if (!$uppercase || !$specialChar || !$hasNumber || !$minLength) {
                    $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Mật khẩu mới phải có ít nhất 8 ký tự, chứa ít nhất 1 chữ in hoa, 1 ký tự đặc biệt và 1 chữ số.', 'type' => 'error'];
                    header('Location: ' . _WEB_ROOT_ . '/doi-mat-khau');
                    exit;
                } else {
                    $user = new AuthModel();
                    $user->setEmail($email);

                    if ($this->auth_model->getUserEmail($user)) {
                        $user->setPassword($new_password);
                        $this->auth_model->updatePass($user);
                        $_SESSION['messger'] = ['title' => 'Thành công', 'mess' => 'Cập nhật mật khẩu thành công !', 'type' => 'success'];
                        header('Location: ' . _WEB_ROOT_ . '/tai-khoan');
                        exit;
                    } else {
                        $_SESSION['messger'] = ['title' => 'Thất bại', 'mess' => 'Cập nhật mật khẩu không thành công, vui lòng thử lại.', 'type' => 'error'];
                        header('Location: ' . _WEB_ROOT_ . '/doi-mat-khau');
                        exit;
                    }
                }
            }
            // Truyền lỗi vào view
            if (!empty($this->errorMessage)) {
                $this->data['error'] = $this->errorMessage;
            }
        }
        // Cài đặt thông tin cho view
        $this->data['page_title'] = 'Đổi mật khẩu';
        $this->data['content'] = 'auth/resetpass';
        $this->render('layouts/client_layout', $this->data);
    }
}

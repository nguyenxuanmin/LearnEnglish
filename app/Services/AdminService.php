<?php 
namespace App\Services;
use Illuminate\Support\Facades\Storage;

class AdminService
{
    public function generateSlug($title) {
        $slug = strtolower($title);
        $slug = preg_replace('~[áàạảãâấầậẩẫăắằặẳẵ]~u', 'a', $slug);
        $slug = preg_replace('~[éèẹẻẽêếềệểễ]~u', 'e', $slug);
        $slug = preg_replace('~[íìịỉĩ]~u', 'i', $slug);
        $slug = preg_replace('~[óòọỏõôốồộổỗơớờợởỡ]~u', 'o', $slug);
        $slug = preg_replace('~[úùụủũưứừựửữ]~u', 'u', $slug);
        $slug = preg_replace('~[ýỳỵỷỹ]~u', 'y', $slug);
        $slug = preg_replace('~[đ]~u', 'd', $slug);
        $slug = preg_replace('/[^a-z0-9\s]/', '', $slug);
        $slug = preg_replace('/\s+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }

    public function generateImage($image,$folder) {
        $message = "";
        $uploadOk = 1;
        $targetFile = $folder.'/'. basename($image['name']);
        $uploadDir = storage_path('app/public/'.$folder.'/');
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $check = getimagesize($image["tmp_name"]);
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        if ($check === false) {
            $message = "Tệp không phải là hình ảnh.";
            return $message;
        }
        if (Storage::exists($targetFile)) {
            $message = "Xin lỗi, tệp này đã tồn tại.";
            return $message;
        }
        if ($image["size"] > 5000000) {
            $message = "Xin lỗi, tệp của bạn quá lớn.";
            return $message;
        }
        if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif" && $imageFileType != "webp") {
            $message = "Xin lỗi, chỉ các tệp JPG, JPEG, PNG, GIF, WEBP được phép.";
            return $message;
        }
        if (move_uploaded_file($image["tmp_name"], $uploadDir . basename($image['name']))) {
            return $message;
        } else {
            $message = "Có lỗi xảy ra khi tải tệp lên.";
            return $message;
        }
    }

    public function checkPhone($phone) {
        $message = "";
        $checkPhone = preg_match('/^(0|\+84)[0-9]{9}$/', $phone);
        if(!$checkPhone){
            $message = "Số điện thoại không hợp lệ.";
        }
        return $message;
    }
}

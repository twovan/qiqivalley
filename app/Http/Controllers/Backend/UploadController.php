<?php

namespace App\Http\Controllers\Backend;

use App\Models\Upload;
use Illuminate\Http\Request;

class UploadController extends BaseController
{
    //图片上传
    public function image(Request $request)
    {
        $info = $request->file('file');
        $save_path = $request->input('path');
        $upload_id = $request->input('upload_id');
        $size = $info->getSize();
        $mimeType = $info->getMimeType();
        $originalName = $info->getClientOriginalName();
        //大小
        if ($size/(1024*1024) > config('params')['uploadImg']['size']){
            return $this->err('图片大小不能超过'.config('params')['uploadImg']['size'].'M');
        }
        // 格式
        if (explode('/',$mimeType)[0] != 'image'){
            return $this->err('图片格式不正确');
        }
        $save_name = $info->store($save_path,'public');
        if ($save_name){
            $save_data = [
                'name' => $originalName,
                'disk' => 'public',
                'path' => $save_name,
                'size' => $size,
                'mime_type' => $mimeType,
            ];
            if($upload_id){
                $res = Upload::find($upload_id)->update($save_data);
                $save_id = $upload_id;
            }else{
                $res = Upload::create($save_data);
                $save_id = $res->id;
            }
            if ($res){
                return $this->ok([
                    'save_id' => $save_id,
                    'save_name' => $save_name,
                ]);
            }
        }
        return $this->err('上传失败');
    }
}

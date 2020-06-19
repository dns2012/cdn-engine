<?php 

namespace App;

use Config\Response;
use Intervention\Image\ImageManagerStatic as Image;

class PblCareerController 
{

    private $publicDir = './public/pbl-career/';

    public function __construct()
    {
        Image::configure(array('driver' => 'imagick'));
    }
    
    public function upload()
    {
        $data = $_POST;

        $directory = $this->getDirectory($data);

        $this->deleteImage($directory, $data);
        
        $image = $_FILES['image'];

        $name = uniqid() . '.jpg';
        
        if (Image::make($image['tmp_name'])
            ->fit(800)
            ->save($directory['dir_path'] . $name, 60)
        ) {
            return Response::success([
                'image' => $this->getHost($_SERVER) . $directory['dir_name'] . $name
            ], 200);
        }
    }

    public function deleteProduct()
    {
        $data = $_POST;

        $directory = $this->getDirectory(['user_id' => $data['user_id']]);
        $images = [$data['image_one'], $data['image_two'], $data['image_three']];

        foreach ($images as $image) {
            $this->deleteImage($directory, ['delete' => $image]);
        }

        return true;
    }

    public function deleteImage($directory, $data)
    {
        if (! empty($data['delete'])) {
            $currentImage = $directory['dir_path'] . $data['delete'];
            if (file_exists($currentImage)) {
                unlink($currentImage);
            }
        }
    }

    public function getDirectory($data)
    {
        $dirEncrypted = (! empty($data['user_id'])) ? md5($data['user_id']) : md5(1);
        $dirPath = $this->publicDir . $dirEncrypted;
        if (! file_exists($dirPath)) {
            mkdir($dirPath);
        }

        return [
            'dir_path' => $dirPath . '/',
            'dir_name' => $dirEncrypted . '/'
        ];
    }

    public function getHost($request)
    {
        $scheme = (! empty($request['REQUEST_SCHEME']) && $request['REQUEST_SCHEME'] == 'https') ? 'https://' : 'http://' ;
        return $scheme . $request['HTTP_HOST'] . '/public/pbl-career/';
    }
}
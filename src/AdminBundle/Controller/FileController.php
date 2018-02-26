<?php

namespace AdminBundle\Controller;

use Imagine\Filter\Basic\Autorotate;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FileController extends Controller
{

    /**
     * @Route("/file/upload", name="admin_file_upload")
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadAction(Request $request)
    {
        $docRootDirName = 'web';
        $uploadDirName = 'uploads';

        /* @var \Symfony\Component\HttpFoundation\File\UploadedFile $file */
        $file = $request->files->get('file');

        if (!($file instanceof UploadedFile)) {
            $message = 'ファイルサイズが大きすぎます(最大'. ini_get('upload_max_filesize'). 'バイト)';
            return new JsonResponse(['errors' => [$message]], 200);
        }

        if (!$file->isValid()) {
            $message = '';
            switch ($file->getError()) {
                case UPLOAD_ERR_OK: // OK
                    break;
                case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過
                case UPLOAD_ERR_FORM_SIZE: // フォーム定義の最大サイズ超過 (設定した場合のみ)
                    $message = 'ファイルサイズが大きすぎます(最大'. ini_get('upload_max_filesize'). 'バイト)';
                    break;
                default:
                    $message = $file->getErrorMessage();
                    break;
            }
            return new JsonResponse(['errors' => [$message]], 200);
        }

        $imagine = new Imagine();
        $image = $imagine->open($file->getPathname());

        $filter = new Autorotate();
        $filter->apply($image);

        // 設定したサイズより大きい辺がある画像をリサイズ
        $maxImageSize = $this->container->getParameter('max_image_size');
        $size = $image->getSize();
        $size->getHeight();
        $resize = false;
        $box = new Box($size->getWidth(), $size->getHeight());
        if (($size->getWidth() - $size->getHeight()) > 0) {
            if ($size->getWidth() > $maxImageSize) {
                $box = $box->widen($maxImageSize);
                $resize = true;
            }
        } else {
            if ($size->getHeight() > $maxImageSize) {
                $box = $box->heighten($maxImageSize);
                $resize = true;
            }
        }
        if ($resize) {
            $image->resize($box);
        }

        $hash = md5_file($file->getPathname());
        if ($resize) {
            $hash = md5($image);
        }
        $directory = substr($hash, 0, 2) . '/' . substr($hash, 2, 2);
        $uploadsDir = $this->container->getParameter('kernel.root_dir') . '/../'. $docRootDirName. '/'. $uploadDirName. '/';
        $destination = $uploadsDir . $directory;
        $fileName = $hash . '.' . strtolower($file->getClientOriginalExtension());

        $this->get('filesystem')->mkdir($destination);

        $image->save($destination . '/' . $fileName);
        $path = '/'. $uploadDirName. '/' . $directory . '/' . $fileName;

        return new JsonResponse([
            'path' => $path,
            'thumbnails' => []
        ]);
    }

}
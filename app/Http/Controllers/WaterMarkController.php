<?php

namespace App\Http\Controllers;

use Ajaxray\PHPWatermark\Watermark;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Img;

class WaterMarkController extends Controller
{

    const OUT_PATH = 'E:\FbPage\addwatermark\/';
    const TEXT_WATERMARK = 'fb.com/ogaidepkia';
    const FONT_PATH = 'app/public/fonts/cabin.ttf';

    public function index() {

        return view('add_watermark');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request) {

        if($request->hasFile('photos')) {
            $files = $request->file('photos');
            $outPath =  storage_path("watermark/" . Carbon::now()->format('Ymd_Hs'));
            //dd($outPath);
            File::makeDirectory($outPath, 777);
            $logo = Img::make(public_path('images/logo234x78.png'));

            $imgUrls = [];
            foreach ($files as $file) {
                $img = Img::make($file->getRealPath());
                $with = $img->getWidth();
                $height = $img->getWidth();
                $imgCh = sqrt($with * $with + $height * $height);

                $textSize = ceil($imgCh/63.25);
                $img->text(self::TEXT_WATERMARK, 15,15, function ($font) use ($textSize) {
                    //$font->file(public_path(self::FONT_PATH));
                    $font->size($textSize);
                    $font->color(array(255, 255, 255, 0.7));
                });

                $logoWidth = ceil($imgCh/6.7168);
                $logoHeight = ceil($logoWidth * 0.318584);
                $logo->resize($logoWidth, $logoHeight);
                $img->insert($logo, 'bottom-right', 10, 10);

                $img->save($outPath . $file->getClientOriginalName());
                $img->destroy();

                $imgUrls = asset($outPath . $file->getClientOriginalName());
            }

            return view('add_watermark', ['urls' => $imgUrls]);
        }

        return back()->withErrors('Khong cos file anh');
    }

    /**
     * @param $file UploadedFile
     * @param $outPath
     * @param $storagePath
     * @return string
     */
    protected function addWaterMark($file) {
        $path = storage_path('app/' . $file);
        var_dump($path);

        $watermark = new Watermark($path);

        // Watermarking with Text
        $watermark->setFont('Arial')
            ->setFontSize(18)
            ->setOpacity(.7)
            ->setPosition(Watermark::POSITION_TOP_LEFT);

        $text = "fb.com/ogaidepkia";
        $result = $watermark->withText($text, $path);
        /*
        $watermark->setPosition(Watermark::POSITION_BOTTOM_RIGHT)
            ->setOffset(15, 15)
            ->setOpacity(.7)
            ->setStyle(Watermark::STYLE_IMG_DISSOLVE);

        $result = $watermark->withImage(public_path('images/logo234x78.png'), $path);
        */
        var_dump($result);
        return Storage::url($file);
    }

    protected function addTextWatermark($fileName) {

    }

    // for png
    function resize_imagepng($file, $w, $h) {
        list($width, $height) = getimagesize($file);
        $src = imagecreatefrompng($file);
        $dst = imagecreatetruecolor($w, $h);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $w, $h, $width, $height);
        return $dst;
    }
}

<?php

class SignatureController extends BaseController {

    public function __construct() {
        // Constructor
    }

    public function index($id)
    {
        if(isset($id) == false) {
            return Response::make('This user could not be found.', 404);
        }

        $info = !is_numeric($id) ? User::where('NAME', '=', trim(strtolower(strip_tags($id))))->first() : User::find($id);

        if($info == null){
            return Response::make('This user could not be found.', 404);
        }

        header("Content-Type: image/png;");
        header("Cache-Control: post-check=120, pre-check=240, max-age=300;");
        //header("Cache-Control: must-revalidate, post-check=0, pre-check=0;");
        header("Pragma: public;");
    
        $backgrounds = array( 
            __DIR__ . "/../../public/assets/img/sig/0.png", //'http://i.imgur.com/UqEqSEH.png', 
            __DIR__ . "/../../public/assets/img/sig/1.png", //'http://i.imgur.com/gEa3sXf.png', 
            __DIR__ . "/../../public/assets/img/sig/2.png", //'http://i.imgur.com/sQGNnyb.png', 
            __DIR__ . "/../../public/assets/img/sig/3.png", //'http://i.imgur.com/QeipYAo.png', 
            __DIR__ . "/../../public/assets/img/sig/4.png", //'http://i.imgur.com/mJMKaWO.png', 
            __DIR__ . "/../../public/assets/img/sig/5.png"  //'http://i.imgur.com/WCy3zvG.png'
        );

        $backg = null;

        /*try
        {
            $src = trim(strip_tags(htmlentities(Input::get('bg'))));

            if(Input::has('bg') && filter_var($src, FILTER_VALIDATE_URL)) 
            {
                $asd = imagecreatefrompng($src);
                list($width, $height) = getimagesize($src);

                $backg = ImageCreateTrueColor(500, 150);
                $white = imagecolorallocate($backg, 255, 255, 255);
                imagefill($backg, 0, 0, $white);

                imagecopyresized($backg, $asd, 0, 0, 0, 0, 500, 150, $width, $height);
                imagedestroy($asd);
            }
            else
            {
                $backg = imagecreatefrompng($backgrounds[mt_rand(0,5)]);
            }            
        }
        catch(Exception $e)
        {
            $backg = imagecreatefrompng($backgrounds[mt_rand(0,5)]);            
        }*/

        $backg = imagecreatefrompng($backgrounds[mt_rand(0,5)]);    
        $image = imagecreatefrompng(__DIR__ . "/../../public/assets/img/sig/template.png"); // 'http://i.imgur.com/jppsLUM.png'

        imagealphablending($image, true);
        imagesavealpha($image, true);

        $text = imagecolorallocate($image, 0, 0, 0);
        $name = imagecolorallocate($image, 0, 0, 0);
        $text_cr = imagecolorallocate($image, 255, 255, 255);
        
        if($info->VIP_PACKAGE)       $name = imagecolorallocate($image, 255, 220, 46);
        if($info->ADMINLEVEL) $name = imagecolorallocate($image, 255,  7, 112); 
        
        $font = __DIR__ . "/../../public/assets/fonts/verdana.ttf";
        
        /* 1st Row */
        imagettftext($image, 11, 0, 110, 79, $name, $font, $info->NAME);
        imagettftext($image, 11, 0, 110, 79, $name, $font, $info->NAME);
        imagettftext($image, 10, 0, 55, 97, $text, $font, $info->KILLS);
        imagettftext($image, 10, 0, 76, 114, $text, $font, $info->DEATHS);
        imagettftext($image, 10, 0, 63, 130, $text, $font, sprintf("%4.2f",$info->KILLS/$info->DEATHS));
        
        /* 2nd Row */
        imagettftext($image, 10, 0, 253, 97, $text, $font, $info->ADMINLEVEL);
        imagettftext($image, 10, 0, 243, 114, $text, $font, \Gliee\Irresistible\Utils::vipToString($info->VIP_PACKAGE));
        imagettftext($image, 10, 0, 210, 130, $text, $font, $info->SCORE);
        
        /* 3rd row */
        $lastlogged = \Carbon\Carbon::createFromTimeStamp($info->LASTLOGGED)->diffForHumans();

        $lastlogged = str_replace('minute', 'min', $lastlogged);
        $lastlogged = str_replace('second', 'pie', $lastlogged);

        imagettftext($image, 7, 0, 417, 80.5, $text, $font, $lastlogged);
        //imagettftext($image, 8, 0, 420, 78, $text, $font, $info->LASTLOGGED);
        
        imagettftext($image, 10, 0, 401, 97, $text, $font, $info->ROBBERIES);
        imagettftext($image, 10, 0, 381, 114, $text, $font, $info->ARRESTS);
        
        imagecopyresampled($backg, $image, 0, 0, 0,  0, 500, 150, 500, 150);

        /* Create, cache and destroy*/
        imagepng($backg); 
        imagedestroy($image);
        imagedestroy($backg);
    }
}

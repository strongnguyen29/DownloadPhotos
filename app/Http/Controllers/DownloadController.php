<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use InstagramScraper\Instagram;
use Symfony\Component\HttpFoundation\Session\Session;

class DownloadController extends Controller
{


    public function index($userName) {
        // If account is public you can query Instagram without auth

        $instagram = new Instagram();
        $medias = $instagram->getMedias($userName, 500);

        echo '<div style="width:1024; margin: 100px auto;"';

        foreach ($medias as $media) {

            echo '<img style="display: inline-block; width: 100px; height: auto;" src="'. $media->getImageHighResolutionUrl() .'">';

        }

        echo '</div>';
    }
}

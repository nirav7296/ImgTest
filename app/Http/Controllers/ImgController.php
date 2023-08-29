<?php

namespace App\Http\Controllers;

use App\Models\Img;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImgController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // phpinfo();
        $img = Image::make('earthday.png');

        $h = $img->height(); // 766
        $w = $img->width(); // 538

        $iconX = 32;
        $iconOffsetX = 10;
        $iconOffsetY = 9;
        // dd($h, $w);
        $m = 50;

        $f2 = "fonts/Oswald-SemiBold.ttf";
        $tagFsize = 20;
        $socialHandleFsize = 22;
        $monFsize = 24;
        $dayFsize = 38;

        $dateFColor = [255, 255, 255, 0.8];
        $tagFColor = [255, 255, 255, 0.6];
        $socialHandleFColor = [255, 255, 255, 0.8];

        // $fb = "<i class='fa fa-facebook-square'></i>";

        $hashTag="#SAVETHEPLANET";
        $formatted = implode('  ',str_split($hashTag)); 

        // imagettftext($img, 20, 0, 0, 0, $tagFColor, $f2, $fb);

        $img->text($formatted, ($w/2), (($h/10)*1.25), function($font) use ($tagFColor, $f2, $tagFsize) {
            $font->file(realpath($f2));
            $font->size($tagFsize);
            $font->color($tagFColor);
            $font->align('center');
        });
        
        // draw a filled green square for date        
        $datePoints = [
            ($w-(($w/10)*2)),  ($h-(($h/10)*2.55)),  // Point 1 (x, y)
            ($w-($w/10)),  ($h-(($h/10)*2.55)), // Point 2 (x, y)
            ($w-($w/10)),  ($h-(($h/10)*1.65)),  // Point 3 (x, y)
            ($w-(($w/10)*2)), ($h-(($h/10)*1.65)),  // Point 4 (x, y)
        ];

        $img->polygon($datePoints, function ($draw) {
            $draw->background('#052909');
        });
        

        // draw a filled green square for social media links
        // $socialMediaPoints = [
        //     (0),  ($h-$m),  // Point 1 (x, y)
        //     ($w),  ($h-$m), // Point 2 (x, y)
        //     ($w),  ($h),  // Point 3 (x, y)
        //     (0), ($h),  // Point 4 (x, y)
        // ];

        // $img->polygon($socialMediaPoints, function ($draw) {
        //     $draw->background('#052909');
        // });

        // Add month in date square
        $dateMonth = "APR";
        $img->text($dateMonth, ($w-(($w/10)*1.5)), ($h-$m-140), function($font) use ($dateFColor, $f2, $monFsize) {
            $font->file(realpath($f2));
            $font->size($monFsize);
            $font->color($dateFColor);
            $font->align('center');
            $font->valign('top');
        });

        // Add Date in date square
        $dateDate = "22";
        $img->text($dateDate, ($w-(($w/10)*1.5)), ($h-$m-115), function($font) use ($dateFColor, $f2, $dayFsize) {
            $font->file(realpath($f2));
            $font->size($dayFsize);
            $font->color($dateFColor);
            $font->align('center');
            $font->valign('top');
        });

        // insert footer 1 
        $footer = Image::make('footer1.png')->resize(1280/2.35, 160/2.35)->brightness(-15);
        $img->insert($footer, 'bottom-left', 0, 0);

        // insert social media icons 
        // $fbIcon = Image::make('facebook_outline.png')->resize($iconX,$iconX)->brightness(-15);
        // $img->insert($fbIcon, 'bottom-left', $iconOffsetX, $iconOffsetY);
        
        // $instaIcon = Image::make('instagram_outline.png')->resize($iconX,$iconX)->brightness(-15);
        // $img->insert($instaIcon, 'bottom-left', ($iconOffsetX*2) + $iconX, $iconOffsetY);

        // $twitterIcon = Image::make('twitter.png')->resize($iconX,$iconX)->brightness(-15);
        // $img->insert($twitterIcon, 'bottom-left', ($iconOffsetX*3) + $iconX*2, $iconOffsetY);

        // $snapchatIcon = Image::make('snapchat.png')->resize($iconX,$iconX)->brightness(-15);
        // $img->insert($snapchatIcon, 'bottom-left', ($iconOffsetX*4) + $iconX*3, $iconOffsetY);

        // $linkedInIcon = Image::make('linkedIn.png')->resize($iconX,$iconX)->brightness(-15);
        // $img->insert($linkedInIcon, 'bottom-left', ($iconOffsetX*5) + $iconX*4, $iconOffsetY);

        // $locationIcon = Image::make('location_outline.png')->resize($iconX,$iconX)->brightness(-15);
        // $img->insert($locationIcon, 'bottom-left', ($iconOffsetX*6) + $iconX*8, $iconOffsetY);

        // $telephoneIcon = Image::make('telephone-call.png')->resize($iconX-8,$iconX-8);
        // $img->insert($telephoneIcon, 'bottom-left', ($iconOffsetX*7) + $iconX*9, $iconOffsetY);

        
        $socialMediaHandles = " / "."EarthDay";

        $img->text($socialMediaHandles,  ($iconOffsetX*3) + $iconX*3, ($h - $iconOffsetY*4.5), function($font) use ($socialHandleFColor, $f2, $socialHandleFsize) {
            $font->file(realpath($f2));
            $font->size($socialHandleFsize-6);
            $font->color($socialHandleFColor);
            $font->align('center');
        });

        $phone ="+91-"."9977889977";

        $img->text($phone,  $w-($w/8.5), ($h - $iconOffsetY*4.5), function($font) use ($socialHandleFColor, $f2, $socialHandleFsize) {
            $font->file(realpath($f2));
            $font->size($socialHandleFsize-6);
            $font->color($socialHandleFColor);
            $font->align('center');
        });
        
        $address = "SAKAR-9, Beside old Reserve Bank of India, Ashram Rd, Navrangpura, Ahmedabad, Gujarat 380009.";
        $img->text($address,  ($iconOffsetX*3), ($h - $iconOffsetY*1.25), function($font) use ($socialHandleFColor, $f2, $socialHandleFsize) {
            $font->file(realpath($f2));
            $font->size($socialHandleFsize-10);
            $font->color($socialHandleFColor);
        });
        
        
        // return view('welcome');
        return $img->response('png');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Img  $img
     * @return \Illuminate\Http\Response
     */
    public function show(Img $img)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Img  $img
     * @return \Illuminate\Http\Response
     */
    public function edit(Img $img)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Img  $img
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Img $img)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Img  $img
     * @return \Illuminate\Http\Response
     */
    public function destroy(Img $img)
    {
        //
    }
}

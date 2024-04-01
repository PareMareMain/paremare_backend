<?php
function getFileUrl($path, $prefix_path = '')
{
    if (strpos($path, "https://s3.us-east-2.amazonaws.com/auctions-new/uploads/images/") !== false) {
        $newPath = str_replace("https://s3.us-east-2.amazonaws.com/auctions-new/uploads/images/", "", $path);
        return \Storage::url($prefix_path . $newPath);
    }

    return strpos($path, "http:") !== false || strpos($path, "https:") !== false ? $path : \Storage::url($prefix_path . $path);
}

function getImagePath($path)
{
    return getFileUrl($path, 'uploads/images/');
}
function getFileExtension($file)
{
    $ext = $file->getClientOriginalExtension();

    return !!$ext ? $ext : $file->guessExtension();
}


function uploadImage($image)
{
    // dd($image);
    $fileName = uniqid(time()) . '.' . getFileExtension($image);

    // Save Original Image
    // $image->storeAs('uploads/images', $fileName);
    $path = Storage::disk('s3')->put('uploads/images', $image,'public');
    $path = Storage::disk('s3')->url($path);
    // $imgData = ['orig_path' => $fileName];

    // if ($withThumb) {
    //     $thumbFileName = 'thumb_' . $fileName;

    //     $img = \Image::make($image->getRealPath())
    //         ->resize(100, 100, function ($constraint) {
    //             $constraint->aspectRatio();
    //         })->stream();
    //     // Save thumb image
    //     \Storage::put('uploads/images/' . $thumbFileName, $img->__toString());

    //     $imgData['thumb_path'] = $thumbFileName;
    //     $imgData['thumb_path_url'] = getImagePath($imgData['thumb_path']);
    // }

    $imgData['orig_path_url'] = $path;

    return $imgData;
}

function fixSizeImageUpload($image, $height = 280, $width = 780)
{
    $imagename =  uniqid(time()) . '.' . getFileExtension($image);
    $new_image = \Image::make($image->getRealPath());
    $imp = $new_image->resize($width, $height);

    // Upload the resized image to S3
    $path = 'uploads/images/' . $imagename;
    \Storage::disk('s3')->put($path, (string)$new_image->encode(), 'public');

    // Get the AWS S3 URL
    $awsPath = \Storage::disk('s3')->url($path);
    return $awsPath;

}

function getCalculatedDistance($lat1, $lon1, $lat2, $lon2, $unit="K")
{
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K")
    {
        return ($miles * 1.609344);
    }
    else if ($unit == "N")
    {
    return ($miles * 0.8684);
    }
    else
    {
    return $miles;
    }
}

function sendCustomMessage($receiverNumber, $message)
{
    $account_sid = Config("services.twilio.twilio_sid");
    $auth_token = Config("services.twilio.twilio_token");
    $twilio_number = Config("services.twilio.number");
    $client = new \Twilio\Rest\Client($account_sid, $auth_token);
    $twillio=$client->messages->create($receiverNumber, [
        'from' => $twilio_number,
        'body' => $message]);
}
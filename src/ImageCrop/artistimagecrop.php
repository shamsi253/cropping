<?php
namespace ImageCrop;

class artistimagecrop
{
    public static function imageArtistModification($file_id, $file)
    {
        $file_id = explode('.', $file_id);
        $datas = ImageDetail::all();
        foreach ($datas as $data) {
            if ($data->type == "artist") {
                if ($data->width != null && $data->height != null) {
                    if ($data->ratio == 1) {
                        $file_name = $file_id[0] . '_' . $data->name . '.' . $file_id[1];
                        $thumbnailpath = public_path('public/' . $file_name);
                        $file->storeAs('public/', $file_name);
                        $img = Image::make($thumbnailpath)->fit($data->width, $data->height, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                        $img->save($thumbnailpath);
                    } else {
                        $file_name = $file_id[0] . '_' . $data->name . '.' . $file_id[1];
                        $thumbnailpath = public_path('public/' . $file_name);
                        $file->storeAs('public/', $file_name);
                        $img = Image::make($thumbnailpath)->fit($data->width, $data->height);
                        $img->save($thumbnailpath);
                    }
                } elseif ($data->width != null && $data->height == null) {
                    $file_name = $file_id[0] . '_' . $data->name . '.' . $file_id[1];
                    $thumbnailpath = public_path('public/' . $file_name);
                    $file->storeAs('public/', $file_name);
                    $img = Image::make($thumbnailpath)->fit($data->width);
                    $img->save($thumbnailpath);
                } elseif ($data->height != null && $data->width == null) {
                    $file_name = $file_id[0] . '_' . $data->name . '.' . $file_id[1];
                    $thumbnailpath = public_path('public/' . $file_name);
                    $file->storeAs('public/', $file_name);
                    $img = Image::make($thumbnailpath)->fit($data->height);
                    $img->save($thumbnailpath);
                }
            }
        }
        return 1;
    }

    public function imagePosterModification($file, $file_id)
    {
        $file_id = explode('.', $file_id);
        $datas = ImageDetail::all();
        foreach ($datas as $data) {
            if ($data->type == "movie") {
                if ($data->width != null && $data->height != null) {
                    if ($data->ratio == 1) {
                        $file_name = $file_id[0] . '_' . $data->name . '.' . $file_id[1];
                        $thumbnailpath = public_path('public/' . $file_name);
                        $file->storeAs('public/', $file_name);
                        $img = Image::make($thumbnailpath)->resize($data->width, $data->height, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                        $img->save($thumbnailpath);
                    } else {
                        $file_name = $file_id[0] . '_' . $data->name . '.' . $file_id[1];
                        $thumbnailpath = public_path('public/' . $file_name);
                        $file->storeAs('public/', $file_name);
                        $img = Image::make($thumbnailpath)->resize($data->width, $data->height);
                        $img->save($thumbnailpath);
                    }
                } elseif ($data->width != null && $data->height == null) {
                    $file_name = $file_id[0] . '_' . $data->name . '.' . $file_id[1];
                    $thumbnailpath = public_path('public/' . $file_name);
                    $file->storeAs('public/', $file_name);
                    $img = Image::make($thumbnailpath)->resize($data->width);
                    $img->save($thumbnailpath);
                } elseif ($data->height != null && $data->width == null) {
                    $file_name = $file_id[0] . '_' . $data->name . '.' . $file_id[1];
                    $thumbnailpath = public_path('public/' . $file_name);
                    $file->storeAs('public/', $file_name);
                    $img = Image::make($thumbnailpath)->resize($data->height);
                    $img->save($thumbnailpath);
                }
            }
        }
    }

// image crop manually
    public function imageCropManually($request)
    {
        $quality = 90;
        $src = 'public/' . $request->image;
        $img = imagecreatefromjpeg($src);
        if ($img == false) {
            $img = imagecreatefrompng($src);
        }
        $dest = ImageCreateTrueColor($request->w,
            $request->h);
        imagecopyresampled($dest, $img, 0, 0, $request->x,
            $request->y, $request->w, $request->h,
            $request->w, $request->h);
        imagejpeg($dest, $src, $quality);
        return 1;
    }
}

<?php
namespace App\Models\FEnt;

use App\Models\FEnt\FEntAbstract;

class FEntVideo extends FEntAbstract
{
  //SCM0043
    public $videoId; // 動画管理ID
    public $thumbnailUrl; // 動画tag
    public $embedIframe; // 動画tag
    public $videoCaption; // 動画キャプション
}

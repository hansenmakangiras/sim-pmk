<?php
/**
 * Created by PhpStorm.
 * User: HansenKibow
 * Date: 28/11/2014
 * Time: 10:41
 */

class SiteController extends BaseController
{

    /**
     * Site Dashboard/Home
     *
     */
    public function getIndex()
    {
        return View::make('site/home');
    }

}




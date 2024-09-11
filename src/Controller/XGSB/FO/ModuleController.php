<?php

namespace App\Controller\XGSB\FO;

use App\Entity\XGSB\Module;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ModuleController extends AbstractController
{
    public function index(Module $module)
    {
        switch ($module->getType()->getCode()){
            case 'banner':
                return $this->makeBanner($module);
            case 'card':
                return $this->makeCard($module);
            case 'imageText':
                return $this->makeImageText($module);
            case 'title':
                return $this->makeTitle($module);
            case 'video':
                return $this->makeVideo($module);
        }
    }

    public function makeBanner (Module $module){
        $banner=$module->getParam('Image');
        return $this->render('xgsb/fo/module/_banner.html.twig',[
            "banner"=>$banner
        ]);
    }

    public function makeCard(Module $module){
        $title=$module->getParam('title');
        $subtitle=$module->getParam('subtitle');
        $image=$module->getParam('Image');
        $imagePosition=$module->getParam('ImagePosition');
        $text=$module->getParam('Texte');
        return $this->render('xgsb/fo/module/_card.html.twig',[
            "title"=>$title,
            "subtitle"=>$subtitle,
            "image"=>$image,
            "imagePosition"=>$imagePosition,
            "text"=>$text,
        ]);
    }

    public function makeImageText(Module $module){
        $image=$module->getParam('Image');
        $imagePosition=$module->getParam('ImagePosition');
        $text=$module->getParam('Texte');
        return $this->render('xgsb/fo/module/_image-text.html.twig',[
            "image"=>$image,
            "imagePosition"=>$imagePosition,
            "text"=>$text,
        ]);
    }

    public function makeTitle(Module $module){
        $title=$module->getParam('Titre');
        $balise=$module->getParam('TypeTitre');
        return $this->render('xgsb/fo/module/_title.html.twig',[
            "title"=>$title,
            "balise"=>$balise,
        ]);
    }

    public function makeVideo(Module $module){
        $video=$module->getParam('media');
        $title=$module->getParam('Title');
        return $this->render('xgsb/fo/module/_video.html.twig',[
            "title"=>$title,
            "video"=>$video,
        ]);
    }

}

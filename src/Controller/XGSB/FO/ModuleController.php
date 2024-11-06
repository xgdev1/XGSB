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
            case 'flipcard':
                return $this->makeFlipCard($module);
            case 'imageText':
                return $this->makeImageText($module);
            case 'title':
                return $this->makeTitle($module);
            case 'video':
                return $this->makeVideo($module);
            case 'widget':
                return $this->makeWidget($module);
        }
    }

    public function makeBanner (Module $module){
        $banner=$module->getParam('Image');
        return $this->render('xgsb/fo/module/_banner.html.twig',[
            "banner"=>$banner
        ]);
    }

    public function makeCard(Module $module){
        $isVideo=false;
        $title=$module->getParam('Title');
        $subtitle=$module->getParam('SubTitle');
        $image=$module->getParam('Image');
        $VideoMP4=$module->getParam('VideoMP4', null);
        $VideoYT=$module->getParam('VideoYT', null);
        $classCard=$module->getParam('ClassCard', null);
        $imagePosition=$module->getParam('ImagePosition');
        $text=$module->getParam('Texte');
        return $this->render('xgsb/fo/module/_card.html.twig',[
            "title"=>$title,
            "subtitle"=>$subtitle,
            "image"=>$image,
            "imagePosition"=>$imagePosition,
            "text"=>$text,
            "classCard"=>$classCard,
            "VideoMP4"=>$VideoMP4,
            "VideoYT"=>$VideoYT,
            "module"=>$module
        ]);
    }

    public function makeFlipCard (Module $module){
        $Front=$module->getParam('Front');
        $Back=$module->getParam('Back');
        return $this->render('xgsb/fo/module/_flip_card.html.twig',[
            "front" => $Front,
            "back" => $Back,
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

    public function makeWidget(Module $module){
        $Widget=$module->getParam('widget');
        $title=$module->getParam('Title');
        return $this->render('xgsb/fo/module/_video.html.twig',[
            "title"=>$title,
            "widget"=>$Widget,
        ]);
    }
}

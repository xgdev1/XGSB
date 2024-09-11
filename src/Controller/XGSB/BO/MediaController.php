<?php

namespace App\Controller\XGSB\BO;

use App\Form\XGSB\UploadFileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[Route('/BO/media', name:"xgsb_bo_media_")]
class MediaController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $basedir=$this->getParameter("kernel.project_dir")."/public/media";
        $finder=new Finder();
        $finder->depth("==0")->in($basedir)->sortByType();
        $directories=clone $finder->directories();
        $files=$finder->files();
        $form=$this->createForm(UploadFileType::class);
        return $this->render('xgsb/bo/media/index.html.twig', [
            'basedir' => $basedir,
            'dirs'      => $directories,
            'files'     => $files,
            'form'      => $form->createView(),
        ]);
    }

    #[Route('/ajax', name: 'ajax')]
    public function ajax(): Response
    {
        $basedir=$this->getParameter("kernel.project_dir")."/public/media";
        $finder=new Finder();
        $finder->depth("==0")->in($basedir)->sortByType();
        $directories=clone $finder->directories();
        $files=$finder->files();
        $form=$this->createForm(UploadFileType::class);
        return $this->render('xgsb/bo/media/_ajax.html.twig', [
            'basedir' => $basedir,
            'dirs'      => $directories,
            'files'     => $files,
            'form'      => $form->createView(),
        ]);
    }

    public function directory(string $dir, string $current=null){
        if (!empty($current)){
            $currentDir=$current."/".$dir;

        }else{
            $currentDir=$dir;
        }
        $basedir=$this->getParameter("kernel.project_dir")."/public/".$currentDir;
        $finder=new Finder();
        $finder->depth("==0")->in($basedir)->sortByType();
        $directories=$finder->directories();
        return $this->render("xgsb/bo/media/helper/_dir.html.twig",[
            "dirs"  => $directories,
            "current"   =>  $currentDir,
            "dir"   => $dir,
        ]);
    }

    #[Route('/filelist', name: 'filelist')]
    public function fileList(Request $request){
        $dir=$request->get("dir", 'media');
        $basedir = $this->getParameter("kernel.project_dir") . "/public/" . $dir;
        $finder = new Finder();
        $finder->depth("==0")->in($basedir)->sortByType();
        $files = $finder->files();
        return $this->render("xgsb/bo/media/helper/_file-list.html.twig", [
            "files"     => $files,
            'current'   => $dir,
        ]);
    }

    #[Route('/delete-dir', name: 'deletedir')]
    public function deleteDir(Request $request){
        $dir=$request->get("dir", 'media');
        $basedir = $this->getParameter("kernel.project_dir") . "/public/" . $dir;
        $finder= new Finder();
        $finder->depth("==0")->in($basedir)->sortByType();
        $files=$finder->files();
        foreach($files as $file){
            unlink($file->getRealPath());
        }
        rmdir($basedir);
        return $this->redirectToRoute("xgsb_bo_media_index");
    }

    #[Route('/create-dir', name: 'createdir')]
    public function createDir(Request $request){
        $dir = $request->get("dir", 'media');
        $basedir = $this->getParameter("kernel.project_dir") . "/public/" . $dir;
        $newDir = $basedir . "/" . $request->get("newDir");
        mkdir($newDir);
        return $this->redirectToRoute("xgsb_bo_media_index");
    }

    #[Route('/upload-file', name: 'uploadfile')]
    public function uploadFile(Request $request){

        $form=$this->createForm(UploadFileType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $data=$form->getData();
            $path=$data["path"];
            /** @var UploadedFile $file */
            $file=$data['file'];
            $basedir=$this->getParameter("kernel.project_dir") . "/public/" . $path;
            $slugger=new AsciiSlugger();
            $tmp=explode(".", $file->getClientOriginalName());
            $filename=$slugger->slug($tmp[0]);
            $filename.='.'.$file->getClientOriginalExtension();
            $file->move($basedir, $filename);
            return new JsonResponse(null,200);
        }else{
            return new JsonResponse(null,400);
        }
    }

    #[Route('/delete-file', name: 'deletefile')]
    public function deleteFile(Request $request){
        $filename = $request->get("file");
        $basedir = $this->getParameter("kernel.project_dir") . "/public/";
        $file = $basedir . "/" . $filename;
        unlink($file);
        return new JsonResponse();
    }

}

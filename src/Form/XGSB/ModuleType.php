<?php

namespace App\Form\XGSB;

use App\Entity\XGSB\Module;
use App\Entity\XGSB\Page;
use App\Entity\XGSB\SectionPage;
use App\Entity\XGSB\TypeModule;
use App\Form\XGSB\ParamModuleType\ParamBannerType;
use App\Form\XGSB\ParamModuleType\ParamCardType;
use App\Form\XGSB\ParamModuleType\ParamImageTextType;
use App\Form\XGSB\ParamModuleType\ParamTitleType;
use App\Form\XGSB\ParamModuleType\ParamVideoType;
use App\Form\XGSB\ParamModuleType\ParamWidgetType;
use App\Repository\XGSB\SectionPageRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Title')
            ->add('ColWidth', ChoiceType::class, [
                'label'     => "Largeur du bloc",
                'help'      => "Permet une mise en page plus poussé, toutefois si les blocs ne remplissent pas une ligne 
                ils seront centrés",
                'required'  => true,
                'choices'   => [
                    'Pleine colonne'    => 12,
                    'Demi colonne'      => 6,
                    'Tiers colonne'     => 4,
                    'Quart colonne'     => 3,
                ]
            ])
        ;
        $builder->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData']);
    }

    public function onPreSetData(FormEvent $event): void {
        /** @var Module $module */
        $module = $event->getData();
        $form = $event->getForm();
        $form->add('sectionPage', EntityType::class, [
           "class" => SectionPage::class,
           "query_builder" => function (SectionPageRepository $repo) use ($module) {
                return $repo->createQueryBuilder('s')->andWhere("s.Page=:page")->setParameter("page", $module->getPage()->getId())
                    ->addOrderBy("s.Ordre","ASC");
           },
           "choice_label" => "Name",
        ]);
        switch ($module->getType()->getCode()){
            case 'banner':
                $form->add('parameters', ParamBannerType::class,[
                    'label' => 'Paramètres pour le module bannière'
                ]);
                break;
            case 'card':
                $form->add('parameters', ParamCardType::class,[
                    'label' => 'Paramètres pour le module carte'
                ]);
                break;
            case 'imageText':
                $form->add('parameters', ParamImageTextType::class, [
                    'label' =>  'Paramètre pour le module Image et Texte'
                ]);
                break;
            case 'title':
                $form->add('parameters', ParamTitleType::class,[
                    'label' => 'Paramètres pour le module titre'
                ]);
                break;
            case 'video':
                $form->add('parameters', ParamVideoType::class,[
                    'label' => 'Paramètres pour le module video'
                ]);
                break;
            case 'widget':
                $form->add('parameters', ParamWidgetType::class,[
                    'label' => 'Paramètres pour le module widget'
                ]);
                break;
            default:
                break;
        }
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Module::class,
        ]);
    }
}

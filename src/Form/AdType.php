<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextareaType::class, $this->getConfiguration('Titre', 'Tapez un super titre pour votre annonce', ['required' => true]))
            ->add('slug', TextareaType::class, $this->getConfiguration('Adresse web', "Tapez l'adresse web (automatique)", ['required' => false]))
            ->add('coverImage', UrlType::class, $this->getConfiguration('Image', "Donnez l'adresse d'une image qui donne vraiment envie"))
            ->add('introduction', TextareaType::class, $this->getConfiguration('Description', "Donnez une description courte de l'annonce"))
            ->add('price', MoneyType::class, $this->getConfiguration('Prix par jour', 'Indiquez le prix que vous voulez par jour'))
            ->add('images',CollectionType::class,
            [
                'entry_type' => ImageType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}

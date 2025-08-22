<?php

namespace App\Form;

use App\Entity\DbFaculties;
use App\Entity\DbMaritalStatus;
use App\Entity\DbSectors;
use App\Entity\DbSexes;
use App\Entity\DbCandidates;
use App\Entity\DbResidences;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom <span class="text-danger">*</span>',
                'label_html' => true,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Votre nom ...',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('fistName', TextType::class, [
                'label' => 'Post-nom <span class="text-danger">*</span>',
                'label_html' => true,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Votre post-nom ...',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Prénom <span class="text-danger">*</span>',
                'label_html' => true,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Votre prénom ...',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mail <span class="text-danger">*</span>',
                'label_html' => true,
                'attr' => [
                    'placeholder' => 'Votre adresse mail...',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('phone', TelType::class, [
                'label' => 'Numéro de téléphone <span class="text-danger">*</span>',
                'label_html' => true,
                'attr' =>[
                    'placeholder' => '099xxxxxxxxx',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('PlaceBirth', TextType::class, [
                'label' => 'Lieu de naissance <span class="text-danger">*</span>',
                'label_html' => true,
                'attr' => [
                    'placeholder' => 'Votre lieu de naissance ...',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('dateBirth', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de naissance <span class="text-danger">*</span>',
                'label_html' => true,
            ])
            ->add('urgName', TextType::class, [
                'label' => 'Nom au complet <span class="text-danger">*</span>',
                'label_html' => true,
                'attr' => [
                    'placeholder' => 'Nom de la personne',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('urgRelation', TextType::class, [
                'label' => 'Relation <span class="text-danger">*</span>',
                'label_html' => true,
                'attr' => [
                    'placeholder' => 'Relation avec l\'étudiant...',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('urgMail', EmailType::class, [
                'label' => 'E-mail <span class="text-danger">*</span>',
                'label_html' => true,
                'attr' => [
                    'placeholder' => 'Adresse mail ...',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('urgPhone', TelType::class, [
                'label' => 'N° Téléphone <span class="text-danger">*</span>',
                'label_html' => true,
                'attr' => [
                    'placeholder' => '099xxxxxxxxxx'
                ]
            ])
            ->add('scName', TextType::class, [
                'label' => 'Nom de l\'établissement <span class="text-danger">*</span>',
                'label_html' => true,
                'attr' => [
                    'placeholder' => 'Nom de l\'établissement ...',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('scSection', TextType::class, [
                'label' => 'Section <span class="text-danger">*</span>',
                'label_html' => true,
                'attr' => [
                    'placeholder' => 'Section ou Option ...',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('scCountry', CountryType::class, [
                'label' => 'Pays <span class="text-danger">*</span>',
                'label_html' => true,
                'attr' => [
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('scDiplomaType', TextType::class, [
                'label' => 'Type de Diplôme <span class="text-danger">*</span>',
                'label_html' => true,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ex : Diplôme d\'Etat',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('scDiplomaNumber', TextType::class, [
                'label' => 'N° Diplôme',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Le numéro de votre diplôme',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('scOption', TextType::class, [
                'label' => 'Option <span class="text-danger">*</span>',
                'label_html' => true,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Option',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('scDiplomaPlace', TextType::class, [
                'label' => 'Délivré à',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Lieu de délivrance du diplôme...',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('scDiplomaDate', DateType::class, [
                'label' => 'Date de délivrance',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Date de délivrance du diplôme',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('scCode', TextType::class, [
                'label' => 'Code',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Votre de code ...',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('scProvince', TextType::class, [
                'label' => 'Province',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Province...',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('nationality', TextType::class, [
                'label' => 'Nationalité <span class="text-danger">*</span>',
                'label_html' => true,
                'attr' => [
                    'class' => 'form-control-sm',
                    'placeholder' => 'Ex: Congolaise',
                ]
            ])
            ->add('scPercentage', IntegerType::class, [
                'label' => '% <span class="text-danger">*</span>',
                'label_html' => true,
                'attr' => [
                    'placeholder' => 50,
                    'class' => 'form-control-sm',
                    'min' => 50,
                    'max' => 99
                ]
            ])
            ->add('scYear', IntegerType::class, [
                'label' => 'Année <span class="text-danger">*</span>',
                'label_html' => true,
                'attr' => [
                    'placeholder' => '2000',
                    'class' => 'form-control-sm',
                    'min' => 1960,
                    'max' => 2024
                ]
            ])
            ->add('addNumber', IntegerType::class, [
                'label' => 'N°',
                'required' => false,
                'attr' => [
                    'placeholder' => '2000',
                    'class' => 'form-control-sm',
                    'min' => 0,
                    'max' => 999999
                ]
            ])
            ->add('addAvenue', TextType::class, [
                'label' => 'Avenue/Rue',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Votre avenue ou rue',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('addQuarter', TextType::class, [
                'label' => 'Quartier',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Votre quartier ....',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('addMunicipality', TextType::class, [
                'label' => 'Commune',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Votre commune',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('addCity', TextType::class, [
                'label' => 'Ville/Territoire',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Votre ville ou territoire ...',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('fatherName', TextType::class, [
                'label' => 'Nom',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Nom du père ou de votre responsable ...',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('fatherMail', EmailType::class, [
                'label' => 'E-mail',
                'required' => false,
                'attr' => [
                    'placeholder' => '@ mail ...'
                ]
            ])
            ->add('fatherPhone', TextType::class, [
                'label' => 'N° Téléphone',
                'required' => false,
                'attr' => [
                    'placeholder' => '099xxxxxxxxxx'
                ]
            ])
            ->add('fatherOccupation', TextType::class, [
                'label' => 'Profession',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Profession'
                ]
            ])
            ->add('motherName', TextType::class, [
                'label' => 'Nom',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Votre de la mère ou de votre responsable...',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('motherMail', EmailType::class, [
                'label' => 'E-mail',
                'required' => false,
                'attr' => [
                    'placeholder' => '@ mail ...'
                ]
            ])
            ->add('motherPhone', TextType::class, [
                'label' => 'N° Téléphone',
                'required' => false,
                'attr' => [
                    'placeholder' => '099xxxxxxxxxx'
                ]
            ])
            ->add('motherOccupation', TextType::class, [
                'label' => 'Profession',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Profession'
                ]
            ])
            ->add('residence', EntityType::class, [
                'placeholder' => '-- Veuillez sélectionner --',
                'class' => DbResidences::class,
                'choice_label' => 'name',
                'label' => 'Résidence <span class="text-danger">*</span>',
                'label_html' => true,
            ])
            ->add('maritalStatus', EntityType::class, [
                'placeholder' => '-- Veuillez sélectionner --',
                'label' => 'Etat civil <span class="text-danger">*</span>',
                'label_html' => true,
                'class' => DbMaritalStatus::class,
                'choice_label' => 'name',
            ])
//            ->add('fistChoice', EntityType::class, [
//                'placeholder' => '-- Veuillez sélectionner --',
//                'label' => 'Premier choix',
//                'class' => DbSectors::class,
//                'choice_label' => 'name',
//            ])
//            ->add('secondChoice', EntityType::class, [
//                'placeholder' => '-- Veuillez sélectionner --',
//                'label' => 'Deuxième choix',
//                'class' => DbSectors::class,
//                'choice_label' => 'name',
//            ])
            ->add('sexe', EntityType::class, [
                'placeholder' => '-- Veuillez sélectionner --',
                'label' => 'Genre <span class="text-danger">*</span>',
                'label_html' => true,
                'class' => DbSexes::class,
                'choice_label' => 'name',
            ])
            ->add('facOne', EntityType::class, [
                'label' => 'Faculté 1 <span class="text-danger">*</span>',
                'label_html' => true,
                'class' => DbFaculties::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisissez une faculté',
                'mapped' => false,
            ])
            ->add('fistChoice', EntityType::class, [
                'label' => 'Filière 1 <span class="text-danger">*</span>',
                'label_html' => true,
                'class' => DbSectors::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisissez une filière',
                //'mapped' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('f')
                        ->innerJoin('f.faculty', 'faculty')
                        ->orderBy('f.name', 'ASC');
                },
            ])
            ->add('factTwo', EntityType::class, [
                'label' => 'Faculté 2 <span class="text-danger">*</span>',
                'label_html' => true,
                'required' => false,
                'class' => DbFaculties::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisissez une faculté',
                'mapped' => false,
            ])
            ->add('secondChoice', EntityType::class, [
                'label' => 'Filière 2 <span class="text-danger">*</span>',
                'label_html' => true,
                'required' => false,
                'class' => DbSectors::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisissez une filière',
                //'mapped' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('f')
                        ->innerJoin('f.faculty', 'faculty')
                        ->orderBy('f.name', 'ASC');
                },
            ])
            ->add('provinceOrigin', TextType::class, [
                'label' => 'Province d\'origine',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Votre province d\'origine',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('territoryOrigin', TextType::class, [
                'label' => 'Territoire d\'origine',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Votre territoire d\'origine',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('instOrigin', TextType::class, [
                'label' => 'Institution de provenance <span class="text-danger">*</span>',
                'label_html' => true,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Institution de provenance',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('facultyOrigin', TextType::class, [
                'label' => 'Faculté/Filière de provenance <span class="text-danger">*</span>',
                'label_html' => true,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Faculté ou Filière',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('promRequest', TextType::class, [
                'label' => 'Promotion démandée <span class="text-danger">*</span>',
                'label_html' => true,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Promotion',
                    'class' => 'form-control-sm'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DbCandidates::class,
        ]);
    }
}

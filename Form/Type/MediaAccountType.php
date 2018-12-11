<?php

/*
 * @copyright   2018 Mautic Contributors. All rights reserved
 * @author      Digital Media Solutions, LLC
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticMediaBundle\Form\Type;

// use Mautic\CoreBundle\Form\EventListener\CleanFormSubscriber;
use Mautic\CoreBundle\Form\EventListener\FormExitSubscriber;
use Mautic\CoreBundle\Security\Permissions\CorePermissions;
use MauticPlugin\MauticMediaBundle\Constraints\JsonArray;
use MauticPlugin\MauticMediaBundle\Constraints\JsonObject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class MediaAccountType.
 */
class MediaAccountType extends AbstractType
{
    /**
     * @var CorePermissions
     */
    private $security;

    /**
     * MediaAccountType constructor.
     *
     * @param CorePermissions $security
     */
    public function __construct(CorePermissions $security)
    {
        $this->security = $security;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // CleanFormSubscriber causes JSON payloads containing XML to be purged :(
        // $builder->addEventSubscriber(new CleanFormSubscriber(['website' => 'url']));
        $builder->addEventSubscriber(new FormExitSubscriber('media', $options));

        $builder->add(
            'name',
            'text',
            [
                'label'      => 'mautic.core.name',
                'label_attr' => ['class' => 'control-label'],
                'attr'       => ['class' => 'form-control'],
            ]
        );

        $builder->add(
            'description',
            'textarea',
            [
                'label'      => 'mautic.core.description',
                'label_attr' => ['class' => 'control-label'],
                'attr'       => ['class' => 'form-control editor'],
                'required'   => false,
            ]
        );

        $builder->add(
            'account_map',
            'textarea',
            [
                'label'       => 'mautic.media.form.account_map',
                'label_attr'  => ['class' => 'control-label account-map'],
                'attr'        => [
                    'class' => 'form-control account-map hide',
                    'rows'  => 12,
                ],
                'required'    => false,
                'constraints' => [new JsonObject()],
            ]
        );

        $builder->add(
            'file_payload',
            'textarea',
            [
                'label'       => 'mautic.media.form.file_payload',
                'label_attr'  => ['class' => 'control-label file-payload'],
                'attr'        => [
                    'class' => 'form-control file-payload hide',
                    'rows'  => 12,
                ],
                'required'    => false,
                'constraints' => [new JsonObject()],
            ]
        );

        $builder->add(
            'website',
            'url',
            [
                'label'      => 'mautic.media.form.website',
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'class'   => 'form-control',
                    'tooltip' => 'mautic.media.form.website.tooltip',
                ],
                'required'   => false,
            ]
        );

        $builder->add(
            'attribution_default',
            'number',
            [
                'label'      => 'mautic.media.form.attribution.default',
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'class'    => 'form-control',
                    'preaddon' => 'fa fa-money',
                    'tooltip'  => 'mautic.media.form.attribution.default.tooltip',
                ],
                'required'   => false,
            ]
        );

        $builder->add(
            'attribution_settings',
            'textarea',
            [
                'label'       => 'mautic.media.form.attribution.settings',
                'label_attr'  => ['class' => 'control-label'],
                'attr'        => [
                    'class' => 'form-control hide',
                    'rows'  => 12,
                ],
                'required'    => false,
                'constraints' => [new JsonObject()],
            ]
        );

        $builder->add(
            'duplicate',
            'textarea',
            [
                'label'       => 'mautic.media.form.duplicate',
                'label_attr'  => ['class' => 'control-label'],
                'attr'        => [
                    'class' => 'form-control hide',
                    'rows'  => 12,
                ],
                'required'    => false,
                'constraints' => [new JsonObject()],
            ]
        );

        $builder->add(
            'exclusive',
            'textarea',
            [
                'label'       => 'mautic.media.form.exclusive',
                'label_attr'  => ['class' => 'control-label'],
                'attr'        => [
                    'class' => 'form-control hide',
                    'rows'  => 12,
                ],
                'required'    => false,
                'constraints' => [new JsonObject()],
            ]
        );

        $builder->add(
            'filter',
            'textarea',
            [
                'label'       => 'mautic.media.form.filter',
                'label_attr'  => ['class' => 'control-label'],
                'attr'        => [
                    'class' => 'form-control hide',
                    'rows'  => 12,
                ],
                'required'    => false,
                'constraints' => [new JsonObject()],
            ]
        );

        $builder->add(
            'limits',
            'textarea',
            [
                'label'       => 'mautic.media.form.limits',
                'label_attr'  => ['class' => 'control-label'],
                'attr'        => [
                    'class' => 'form-control hide',
                    'rows'  => 12,
                ],
                'required'    => false,
                'constraints' => [new JsonObject()],
            ]
        );

        $builder->add(
            'schedule_timezone',
            'timezone',
            [
                'label'       => 'mautic.media.form.schedule_timezone',
                'label_attr'  => ['class' => 'control-label'],
                'attr'        => [
                    'class'   => 'form-control',
                    'tooltip' => 'mautic.media.form.schedule_timezone.tooltip',
                ],
                'multiple'    => false,
                'empty_value' => 'mautic.user.user.form.defaulttimezone',
                'required'    => false,
            ]
        );

        $builder->add(
            'schedule_hours',
            'textarea',
            [
                'label'       => 'mautic.media.form.schedule_hours',
                'label_attr'  => ['class' => 'control-label'],
                'attr'        => [
                    'class'   => 'form-control hide',
                    'rows'    => 12,
                    'tooltip' => 'mautic.media.form.schedule_hours.tooltip',
                ],
                'required'    => false,
                'constraints' => [new JsonArray()],
            ]
        );

        $builder->add(
            'schedule_exclusions',
            'textarea',
            [
                'label'       => 'mautic.media.form.schedule_exclusions',
                'label_attr'  => ['class' => 'control-label'],
                'attr'        => [
                    'class'   => 'form-control hide',
                    'rows'    => 12,
                    'tooltip' => 'mautic.media.form.schedule_exclusions.tooltip',
                ],
                'required'    => false,
                'constraints' => [new JsonArray()],
            ]
        );

        //add category
        $builder->add(
            'category',
            'category',
            [
                'bundle' => 'plugin:media',
            ]
        );

        if (!empty($options['data']) && $options['data']->getId()) {
            $readonly = !$this->security->isGranted('plugin:media:items:publish');
            $data     = $options['data']->isPublished(false);
        } elseif (!$this->security->isGranted('plugin:media:items:publish')) {
            $readonly = true;
            $data     = false;
        } else {
            $readonly = false;
            $data     = false;
        }

        $builder->add(
            'isPublished',
            'yesno_button_group',
            [
                'read_only' => $readonly,
                'data'      => $data,
            ]
        );

        $builder->add(
            'publishUp',
            'datetime',
            [
                'widget'     => 'single_text',
                'label'      => 'mautic.core.form.publishup',
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'class'       => 'form-control',
                    'data-toggle' => 'datetime',
                ],
                'format'     => 'yyyy-MM-dd HH:mm',
                'required'   => false,
            ]
        );

        $builder->add(
            'publishDown',
            'datetime',
            [
                'widget'     => 'single_text',
                'label'      => 'mautic.core.form.publishdown',
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'class'       => 'form-control',
                    'data-toggle' => 'datetime',
                ],
                'format'     => 'yyyy-MM-dd HH:mm',
                'required'   => false,
            ]
        );

        $builder->add(
            'type',
            'button_group',
            [
                'label'             => 'mautic.media.form.type',
                'label_attr'        => ['class' => 'control-label media-type'],
                'choices'           => [
                    'mautic.media.form.type.api'  => 'api',
                    'mautic.media.form.type.file' => 'file',
                ],
                'choices_as_values' => true,
                'required'          => true,
                'attr'              => [
                    'class'    => 'form-control',
                    'tooltip'  => 'mautic.media.form.type.tooltip',
                    'onchange' => 'Mautic.mediaTypeChange(this);',
                ],
            ]
        );

        if (!empty($options['action'])) {
            $builder->setAction($options['action']);
        }

        $customButtons = [];

        if (!empty($options['update_select'])) {
            $builder->add(
                'buttons',
                'form_buttons',
                [
                    'apply_text'        => false,
                    'pre_extra_buttons' => $customButtons,
                ]
            );
            $builder->add(
                'updateSelect',
                'hidden',
                [
                    'data'   => $options['update_select'],
                    'mapped' => false,
                ]
            );
        } else {
            $builder->add(
                'buttons',
                'form_buttons',
                [
                    'pre_extra_buttons' => $customButtons,
                ]
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'MauticPlugin\MauticMediaBundle\Entity\MediaAccount',
            ]
        );
        $resolver->setDefined(['update_select']);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'media';
    }
}
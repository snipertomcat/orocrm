<?php

namespace Stc\Bundle\BandBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Oro\Bundle\ImportExportBundle\Processor\ProcessorRegistry;

class ImportType extends AbstractType
{
    const NAME = 'stc_band_importexport_import_form';

    /**
     * @var ProcessorRegistry
     */
    protected $processorRegistry;

    /**
     * @param ProcessorRegistry $processorRegistry
     */
    public function __construct(ProcessorRegistry $processorRegistry)
    {
        $this->processorRegistry = $processorRegistry;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'file',
            'file',
            array(
                'required' => true
            )
        );

        $processorChoices = $this->getImportProcessorsChoices($options['entityName']);

        $builder->add(
            'processorAlias',
            'choice',
            array(
                'choices' => $processorChoices,
                'required' => true,
                'preferred_choices' => $processorChoices ? array(reset($processorChoices)) : array(),
            )
        );
    }

    protected function getImportProcessorsChoices($entityName)
    {
        $aliases = $this->processorRegistry->getProcessorAliasesByEntity(
            ProcessorRegistry::TYPE_IMPORT,
            $entityName
        );
        $result = array();
        foreach ($aliases as $alias) {
            $result[$alias] = $this->generateProcessorLabel($alias);
        }
        return $result;
    }

    protected function generateProcessorLabel($alias)
    {
        return sprintf('oro.importexport.import.%s', $alias);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                //'data_class' => 'Oro\Bundle\ImportExportBundle\Form\Model\ImportData',
                'widget' => 'importForm',
                'data_class' => 'Stc\Bundle\BandBundle\Form\Model\ImportData'
            )
        );
        $resolver->setRequired(array('entityName'));
        $resolver->setAllowedTypes(
            array(
                'entityName' => 'string'
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::NAME;
    }
}
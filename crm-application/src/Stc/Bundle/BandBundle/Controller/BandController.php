<?php

namespace Stc\Bundle\BandBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;

use Oro\Bundle\UserBundle\Entity\User;
use Stc\Bundle\BandBundle\Entity\Band;

use Stc\Bundle\BandBundle\Form\Type\BandType;


/**
 * @Route("/band")
 */
class BandController extends Controller
{
    /**
     * @Route(
     * ".{_format}",
     * name="stc_band_index",
     * requirements={"_format"="html|json"},
     * defaults={"_format" = "html"}
     * )
     * @Template
     * @Acl(
     * id="stc_band_index",
     * type="entity",
     * class="StcBandBundle:Band",
     * permission="VIEW"
     * )
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/info/{id}", name="stc_band_info", requirements={"id"="\d+"})
     * @Template
     * @AclAncestor("stc_band_view")
     */
    public function infoViewAction(Band $band)
    {
        return array(
            'entity' => $band
        );
    }

    /**
     * Take uploaded file and move it to temp dir
     *
     * @Route("/import", name="stc_band_import")
     * @AclAncestor("oro_importexport_import")
     * @Template
     */
    public function importFormAction()
    {
        $entityName = $this->getRequest()->get('entity');

        //$importForm = $this->createForm('stc_band.importexport.form.type.import');

        //$importForm = $this->createForm('stc_band_importexport_import', null, array('entityName' => $entityName));
        $importForm = $this->createForm('oro_importexport_import', null, array('entityName' => $entityName));

        if ($this->getRequest()->isMethod('POST')) {
            $importForm->submit($this->getRequest());

            if ($importForm->isValid()) {
                /** @var ImportData $data */
                $data           = $importForm->getData();
                $file           = $data->getFile();
                $processorAlias = $data->getProcessorAlias();

                /** @var ImportHandler $handler */
                $handler = $this->get('oro_importexport.handler.import');
                $handler->saveImportingFile($file, $processorAlias, 'csv');

                return $this->forward(
                    'OroImportExportBundle:ImportExport:importValidate',
                    array('processorAlias' => $processorAlias),
                    $this->getRequest()->query->all()
                );
            }
        }

        return array(
            'entityName' => $entityName,
            'form'       => $importForm->createView()
        );
    }

    /**
     * @Route("/view/{id}", name="stc_band_view", requirements={"id"="\d+"})
     * @Template
     * @AclAncestor("stc_band_index")
     */
    public function viewAction(Band $band)
    {
        return array('entity' => $band);
    }


    /**
     * @Route("/create", name="stc_band_create")
     * @Template("StcBandBundle:Band:update.html.twig")
     * @Acl(
     * id="stc_band_create",
     * type="entity",
     * class="StcBandBundle:Band",
     * permission="CREATE"
     * )
     */
    public function createAction()
    {
        $band = new Band();

        $context = $this->get('security.context')->getToken();
        $username = $context->getUsername();
        $user = $context->getUser();

        $band->setStatus(1);
        $band->setDeleted(0);
        $band->setCreatedBy($username);
        $band->setOwner($user);

        return $this->update($band);
    }

    /**
     * @Route("/update/{id}", name="stc_band_update", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     * id="stc_band_update",
     * type="entity",
     * class="StcBandBundle:Band",
     * permission="EDIT"
     * )
     */
    public function updateAction(Band $entity)
    {
        return $this->update($entity);
    }

    /**
     * @param Band $band
     * @return array
     */
    protected function update(Band $band)
    {
        $request = $this->getRequest();
        $form = $this->createForm(new BandType(), $band);

        if ('POST' == $request->getMethod()) {
            $form->submit($request);
            if ($form->isValid()) {
                $this->getDoctrine()->getManager()->persist($band);
                $this->getDoctrine()->getManager()->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    $this->get('translator')->trans('stc.band.saved_message')
                );

                return $this->get('oro_ui.router')->actionRedirect(
                    array(
                        'route' => 'stc_band_update',
                        'parameters' => array('id' => $band->getId()),
                    ),
                    array(
                        'route' => 'stc_band_view',
                        'parameters' => array('id' => $band->getId()),
                    )
                );
            }
        }

        return array(
            'entity' => $band,
            'form' => $form->createView(),
        );
    }
}
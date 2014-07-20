<?php

namespace Stc\Bundle\ContractBundle\Controller;

use Akeneo\Bundle\BatchBundle\Job\RuntimeErrorException;
use Stc\Bundle\ContractBundle\Form\Handler\ContractHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;

use Oro\Bundle\UserBundle\Entity\User;
use Stc\Bundle\ContractBundle\Entity\Contract;

use Stc\Bundle\ContractBundle\Form\Type\ContractType;


/**
 * @Route("/contract")
 */
class ContractController extends Controller
{
    /**
     * @Route(
     * ".{_format}",
     * name="stc_contract_index",
     * requirements={"_format"="html|json"},
     * defaults={"_format" = "html"}
     * )
     * @Template
     * @Acl(
     * id="stc_contract_index",
     * type="entity",
     * class="StcContractBundle:Contract",
     * permission="VIEW"
     * )
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/info/{id}", name="stc_contract_info", requirements={"id"="\d+"})
     * @Template
     * @AclAncestor("stc_contract_view")
     */
    public function infoViewAction(Contract $contract)
    {
        return array(
            'entity' => $contract
        );
    }

    /**
     * Take uploaded file and move it to temp dir
     *
     * @Route("/import", name="stc_contract_import")
     * @AclAncestor("oro_importexport_import")
     * @Template
     */
    public function importFormAction()
    {
        $entityName = $this->getRequest()->get('entity');

        //$importForm = $this->createForm('stc_contract.importexport.form.type.import');

        //$importForm = $this->createForm('stc_contract_importexport_import', null, array('entityName' => $entityName));
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
     * @Route("/view/{id}", name="stc_contract_view", requirements={"id"="\d+"})
     * @Template
     * @AclAncestor("stc_contract_index")
     */
    public function viewAction(Contract $contract)
    {
        return array('entity' => $contract);
    }


    /**
     * @Route("/create", name="stc_contract_create")
     * @Template("StcContractBundle:Contract:update.html.twig")
     * @Acl(
     * id="stc_contract_create",
     * type="entity",
     * class="StcContractBundle:Contract",
     * permission="CREATE"
     * )
     */
    public function createAction()
    {
        $contract = new Contract();

        $context = $this->get('security.context')->getToken();
        $username = $context->getUsername();
        $user = $context->getUser();

        $contract->setCreatedBy($username);
        $contract->setOwner($user);

        return $this->update($contract);
    }

    /**
     * @Route("/update/{id}", name="stc_contract_update", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     * id="stc_contract_update",
     * type="entity",
     * class="StcContractBundle:Contract",
     * permission="EDIT"
     * )
     */
    public function updateAction(Contract $entity)
    {
        return $this->update($entity);
    }

    /**
     * @param Contract $contract
     * @return array
     */
    protected function update(Contract $contract)
    {
        $request = $this->getRequest();
        $form = $this->createForm(new ContractType(), $contract);
        $formHandler = $this->get('stc_contract.form.handler');

        if ('POST' == $request->getMethod()) {
            $form->setData($contract);
            if ($formHandler->handle($contract)) {
                $this->get('session')->getFlashBag()->add(
                    'success',
                    $this->get('translator')->trans('stc.contract.saved_message')
                );

                return $this->get('oro_ui.router')->actionRedirect(
                    array(
                        'route' => 'stc_contract_update',
                        'parameters' => array('id' => $contract->getId()),
                    ),
                    array(
                        'route' => 'stc_contract_view',
                        'parameters' => array('id' => $contract->getId()),
                    )
                );
            } else {
                $error = $form->getErrorsAsString(0);
                throw new RuntimeErrorException($error);
            }
        }

        return array(
            'entity' => $contract,
            'form' => $form->createView(),
        );
    }
}
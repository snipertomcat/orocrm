<?php

namespace Stc\Bundle\ContractBundle\Form\Handler;

use Doctrine\ORM\EntityManager;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

use Oro\Bundle\TagBundle\Entity\TagManager;

use Stc\Bundle\ContractBundle\Entity\Contract;

class ContractHandler
{
    /** @var FormInterface */
    protected $form;

    /** @var Request */
    protected $request;

    /** @var EntityManager */
    protected $manager;

    /**
     * @var TagManager
     */
    protected $tagManager;

    /**
     * @param FormInterface $form
     * @param Request       $request
     * @param EntityManager $manager
     */
    public function __construct(FormInterface $form, Request $request, EntityManager $manager, TagManager $tagManager)
    {
        $this->form    = $form;
        $this->request = $request;
        $this->manager = $manager;
        $this->tagManager = $tagManager;
    }

    /**
     * Process form
     *
     * @param  Contract $entity
     *
     * @return bool  True on successful processing, false otherwise
     */
    public function handle(Contract $entity)
    {
        //var_dump($entity);exit;
        //set a default tag:
        $entity->setTags('contract');

        //set empty stage to default of ''
        if (empty($entity->getStage())) {
            $entity->setStage('created');
        }

        //set default for location:
        if (empty($entity->getLocation())) {
            $entity->setLocation($this->request->getBasePath().'/web/documents');
        }

        //set other default field values:
        $entity->setDeleted(0);

        //increase each band's performance count (rating) by 1

        $bands = $entity->getBands();
        //var_dump($bands);
        //echo "<pre>".var_dump($_POST);
        //exit;
        /*foreach ($bands as $band) {
            $band->addContractCount();
        }*/

        $this->form->setData($entity);
        $this->form->submit($this->request);


        $this->onSuccess($entity);
        return true;

        if ($this->form->isValid()) {


        } else {
            exit;
        }

        //return false;
    }

    /**
     * "Success" form handler
     *
     * @param Contract $entity
     */
    protected function onSuccess(Contract $entity)
    {
        $this->manager->persist($entity);
        $this->manager->flush();

        $this->tagManager->saveTagging($entity);
    }

    /**
     * {@inheritdoc}
     */
    public function setTagManager(TagManager $tagManager)
    {
        $this->tagManager = $tagManager;
    }

}
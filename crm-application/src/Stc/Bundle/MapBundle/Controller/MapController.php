<?php

namespace Stc\Bundle\MapBundle\Controller;

use Akeneo\Bundle\BatchBundle\Job\RuntimeErrorException;
use Stc\Bundle\MapBundle\Form\Handler\MapHandler;
use Stc\Bundle\MapBundle\Form\Type\MapCustomizerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;

use Oro\Bundle\UserBundle\Entity\User;
use Stc\Bundle\MapBundle\Entity\Map;

use Stc\Bundle\MapBundle\Form\Type\MapType;
use Stc\Bundle\MapBundle\Form\Builder\MapCustomizerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
/**
 * @Route("/map")
 */
class MapController extends Controller
{
    /**
     * @Route(
     * ".{_format}",
     * name="stc_map_index",
     * requirements={"_format"="html|json"},
     * defaults={"_format" = "html"}
     * )
     * @Template
     * @Acl(
     * id="stc_map_index",
     * type="entity",
     * class="StcMapBundle:Map",
     * permission="VIEW"
     * )
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/view/{id}", name="stc_map_view", requirements={"id"="\d+"})
     * @Template
     * @AclAncestor("stc_map_index")
     */
    public function viewAction(Map $map)
    {
        return array('entity' => $map);
    }


    /**
     * @Route("/create", name="stc_map_create")
     * @Template("StcMapBundle:Map:update.html.twig")
     * @Acl(
     * id="stc_map_create",
     * type="entity",
     * class="StcMapBundle:Map",
     * permission="CREATE"
     * )
     */
    public function createAction()
    {
        $map = new Map();

        $context = $this->get('security.context')->getToken();
        $username = $context->getUsername();
        $user = $context->getUser();


        $map->setOwner($user);
        $map->setUpdatedAt(new \DateTime('now'));

        return $this->update($map);
    }

    /**
     * @Route("/update/{id}", name="stc_map_update", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     * id="stc_map_update",
     * type="entity",
     * class="StcMapBundle:Map",
     * permission="EDIT"
     * )
     */
    public function updateAction(Map $entity)
    {
        return $this->update($entity);
    }

    /**
     * @param Map $map
     * @return array
     */
    protected function update(Map $map)
    {
        $request = $this->getRequest();
        $form = $this->createForm(new MapType(), $map);
        $formHandler = $this->get('stc_map.form.handler');

        if ('POST' == $request->getMethod()) {
            $form->setData($map);
            if ($formHandler->handle($map)) {
                $this->get('session')->getFlashBag()->add(
                    'success',
                    $this->get('translator')->trans('stc.map.saved_message')
                );

                //return $this->generate($map);

                return $this->get('oro_ui.router')->actionRedirect(
                    array(
                        'route' => 'stc_map_update',
                        'parameters' => array('id' => $map->getId()),
                    ),
                    array(
                        'route' => 'stc_map_view',
                        'parameters' => array('id' => $map->getId()),
                    )
                );
            } else {
                $error = $form->getErrorsAsString(0);
                throw new RuntimeErrorException($error);
            }
        }

        return array(
            'entity' => $map,
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/map/{id}", name="stc_map_map", requirements={"id"="\d+"})
     * @Template()
     */
    public function mapAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('location', 'coordinate')
            ->getForm();

        $location = null;

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            $location = $form->getData()['location'];
        }

        $form = $form->createView();

        return compact('form', 'location');

    }
}
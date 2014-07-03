<?php

namespace Stc\Bundle\PerformanceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;

use Oro\Bundle\UserBundle\Entity\User;
use Stc\Bundle\PerformanceBundle\Entity\Performance;

use Stc\Bundle\PerformanceBundle\Form\Type\PerformanceType;


/**
 * @Route("/performance")
 */
class PerformanceController extends Controller
{
    /**
     * @Route(
     * ".{_format}",
     * name="stc_performance_index",
     * requirements={"_format"="html|json"},
     * defaults={"_format" = "html"}
     * )
     * @Template
     * @Acl(
     * id="stc_performance_index",
     * type="entity",
     * class="StcPerformanceBundle:Performance",
     * permission="VIEW"
     * )
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/view/{id}", name="stc_performance_view", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     * id="stc_performance_view",
     * type="entity",
     * class="StcPerformanceBundle:Performance",
     * permission="VIEW"
     * )
     */
    public function viewAction(Performance $performance)
    {
        return array('entity' => $performance);
    }


    /**
     * @Route("/create", name="stc_performance_create")
     * @Template("StcPerformanceBundle:Performance:update.html.twig")
     * @Acl(
     * id="stc_performance_create",
     * type="entity",
     * class="StcPerformanceBundle:Performance",
     * permission="CREATE"
     * )
     */
    public function createAction()
    {
        $performance = new Performance();

        $token = $this->get('security.context')->getToken();
        //$username = $context->getUsername();
        $user = $token->getUser();

        $performance->setCreatedAt(new \DateTime('now'));
        $performance->setStatus(1);
        $performance->setDeleted(0);
        $performance->setAssignee($user);
        $performance->setOwner($user);

        return $this->update($performance);
    }

    /**
     * @Route("/update/{id}", name="stc_performance_update", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     * id="stc_performance_update",
     * type="entity",
     * class="StcPerformanceBundle:Performance",
     * permission="VIEW"
     * )
     */
    public function updateAction(Performance $performance)
    {
        //$performanceRepository = $this->get('doctrine.')

        return $this->update($performance);
    }

    /**
     * @param Performance $performance
     * @return array
     */
    protected function update(Performance $performance)
    {
        $request = $this->getRequest();
        $form = $this->createForm(new PerformanceType(), $performance);

        $formHandler = $this->get('stc_performance.form.handler');

        if ($formHandler->handle($form, $request)) {
            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator').trans('stc.performance.saved_message')
            );

            return $this->get('oro_ui.router')->actionRedirect(
                array(
                    'route' => 'stc_performance_update',
                    'parameters' => array('id' => $performance->getId()),
                ),
                array(
                    'route' => 'stc_performance_view',
                    'parameters' => array('id' => $performance->getId()),
                )
            );
        }

        /*if ('POST' == $request->getMethod()) {
            $form->submit($request);
            if ($form->isValid()) {
                $this->getDoctrine()->getManager()->persist($performance);
                $this->getDoctrine()->getManager()->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    $this->get('translator')->trans('stc.performance.saved_message')
                );

                return $this->get('oro_ui.router')->actionRedirect(
                    array(
                        'route' => 'stc_performance_update',
                        'parameters' => array('id' => $performance->getId()),
                    ),
                    array(
                        'route' => 'stc_performance_view',
                        'parameters' => array('id' => $performance->getId()),
                    )
                );
            }
        }*/

        return array(
            'entity' => $performance,
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/info", name="stc_performance_widgets_info")
     * @Template()
     * @Acl(
     * id="stc_performance_info",
     * type="entity",
     * class="StcPerformanceBundle:Performance",
     * permission="VIEW"
     * )
     */
    public function infoAction(Performance $performance)
    {
        return [
            'entity' => $performance
        ];
    }

    /**
     * @Route("/dev", name="stc_performance_dev")
     * @Acl(
     * id="stc_performance_dev",
     * type="entity",
     * class="StcPerformanceBundle:Performance",
     * permission="VIEW"
     * )
     */
    public function devAction()
    {
        $view = $this->render('OroUIBundle:Default:index.html.twig');
        return $view;
    }

}
<?php

namespace Stc\Bundle\VenueBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;

use Oro\Bundle\UserBundle\Entity\User;
use Stc\Bundle\VenueBundle\Entity\Venue;

use Stc\Bundle\VenueBundle\Form\Type\VenueType;


/**
 * @Route("/venue")
 */
class VenueController extends Controller
{
    /**
     * @Route(
     * ".{_format}",
     * name="stc_venue_index",
     * requirements={"_format"="html|json"},
     * defaults={"_format" = "html"}
     * )
     * @Template
     * @Acl(
     * id="stc_venue_index",
     * type="entity",
     * class="StcVenueBundle:Venue",
     * permission="VIEW"
     * )
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/view/{id}", name="stc_venue_view", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     * id="stc_venue_view",
     * type="entity",
     * class="StcVenueBundle:Venue",
     * permission="VIEW"
     * )
     */
    public function viewAction(Venue $venue)
    {
        return array('entity' => $venue);
    }


    /**
     * @Route("/create", name="stc_venue_create")
     * @Template("StcVenueBundle:Venue:update.html.twig")
     * @Acl(
     * id="stc_venue_create",
     * type="entity",
     * class="StcVenueBundle:Venue",
     * permission="CREATE"
     * )
     */
    public function createAction()
    {
        $venue = new Venue();

        $token = $this->get('security.context')->getToken();
        //$username = $context->getUsername();
        $user = $token->getUser();

        $venue->setCreatedAt(new \DateTime('now'));
        $venue->setStatus(1);
        $venue->setDeleted(0);
        $venue->setAssignee($user);
        $venue->setOwner($user);

        return $this->update($venue);
    }

    /**
     * @Route("/update/{id}", name="stc_venue_update", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     * id="stc_venue_update",
     * type="entity",
     * class="StcVenueBundle:Venue",
     * permission="VIEW"
     * )
     */
    public function updateAction(Venue $venue)
    {
        //$venueRepository = $this->get('doctrine.')

        return $this->update($venue);
    }

    /**
     * @param Venue $venue
     * @return array
     */
    protected function update(Venue $venue)
    {
        $request = $this->getRequest();
        $form = $this->createForm(new VenueType(), $venue);

        if ('POST' == $request->getMethod()) {
            $form->submit($request);
            if ($form->isValid()) {
                $this->getDoctrine()->getManager()->persist($venue);
                $this->getDoctrine()->getManager()->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    $this->get('translator')->trans('stc.venue.saved_message')
                );

                return $this->get('oro_ui.router')->actionRedirect(
                    array(
                        'route' => 'stc_venue_update',
                        'parameters' => array('id' => $venue->getId()),
                    ),
                    array(
                        'route' => 'stc_venue_view',
                        'parameters' => array('id' => $venue->getId()),
                    )
                );
            }
        }

        return array(
            'entity' => $venue,
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/dev", name="stc_venue_dev")
     * @Acl(
     * id="stc_venue_dev",
     * type="entity",
     * class="StcVenueBundle:Venue",
     * permission="VIEW"
     * )
     */
    public function devAction()
    {
        $view = $this->render('OroUIBundle:Default:index.html.twig');
        return $view;
    }

}
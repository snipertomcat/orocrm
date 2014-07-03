<?php

namespace Stc\Bundle\PerformanceBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

use Stc\Bundle\VenueBundle\Entity\Venue;
use Stc\Bundle\PerformanceBundle\Entity\PerformanceManager;

/**
 * Class PerformanceHandler
 * @package Stc\Bundle\PerformanceBundle\Form\Handler
 *
 * This class only handles the form submission when creating a new performance.
 * It doesn't do much with the data -- All data persistence is handed off to the PerformanceManager.
 */

class PerformanceHandler
{
    /**
     * @var PerformanceManager
     */
    protected $manager;

    /**
     *
     * @param PerformanceManager $manager
     */
    public function __construct(PerformanceManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Handle Form Submission
     * @param FormInterface $form
     * @param Request $request
     */
    public function handle(FormInterface $form, $request)
    {
        if (!$request->isMethod('POST')) {
            return false;
        }

        $form->bind($request);

        if (!$form->isValid()) {
            return false;
        }

        $validPerformance = $form->getData();

        $this->manager->createPerformance($validPerformance);
    }

}
